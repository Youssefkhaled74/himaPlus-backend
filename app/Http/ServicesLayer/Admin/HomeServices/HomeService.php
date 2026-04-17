<?php

namespace App\Http\ServicesLayer\Admin\HomeServices;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use Carbon\Carbon;

class HomeService
{
    private const LOW_STOCK_THRESHOLD = 20;

    public function home()
    {
        $now = now();
        $startCurrentMonth = $now->copy()->startOfMonth();
        $startPreviousMonth = $now->copy()->subMonth()->startOfMonth();
        $endPreviousMonth = $startCurrentMonth->copy()->subSecond();

        $ordersBase = Order::query()->whereNull('deleted_at');
        $usersBase = User::query()->whereNull('deleted_at');
        $productsBase = Product::query()->whereNull('deleted_at');
        $offersBase = Offer::query()->whereNull('deleted_at');
        $notificationsBase = Notification::query()->whereNull('deleted_at');

        $customersBase = (clone $usersBase)->where('user_type', 1);
        $vendorsBase = (clone $usersBase)->where('user_type', 2);

        $acceptedOfferStatuses = $this->acceptedOfferStatuses();
        $pendingOfferStatuses = $this->pendingOfferStatuses();

        $ordersCurrentMonth = (clone $ordersBase)->whereBetween('created_at', [$startCurrentMonth, $now])->count();
        $ordersPreviousMonth = (clone $ordersBase)->whereBetween('created_at', [$startPreviousMonth, $endPreviousMonth])->count();

        $revenueCurrentMonth = (clone $ordersBase)
            ->where('payment_status', 1)
            ->whereBetween('created_at', [$startCurrentMonth, $now])
            ->sum('total_cost');
        $revenuePreviousMonth = (clone $ordersBase)
            ->where('payment_status', 1)
            ->whereBetween('created_at', [$startPreviousMonth, $endPreviousMonth])
            ->sum('total_cost');

        $usersCurrentMonth = (clone $usersBase)->whereBetween('created_at', [$startCurrentMonth, $now])->count();
        $usersPreviousMonth = (clone $usersBase)->whereBetween('created_at', [$startPreviousMonth, $endPreviousMonth])->count();

        $categoriesCurrentMonth = Category::query()->whereNull('deleted_at')->whereBetween('created_at', [$startCurrentMonth, $now])->count();
        $categoriesPreviousMonth = Category::query()->whereNull('deleted_at')->whereBetween('created_at', [$startPreviousMonth, $endPreviousMonth])->count();

        $couponsCurrentMonth = Coupon::query()->whereNull('deleted_at')->whereBetween('created_at', [$startCurrentMonth, $now])->count();
        $couponsPreviousMonth = Coupon::query()->whereNull('deleted_at')->whereBetween('created_at', [$startPreviousMonth, $endPreviousMonth])->count();

        $ratingsCurrentMonth = Rating::query()->whereNull('deleted_at')->whereBetween('created_at', [$startCurrentMonth, $now])->count();
        $ratingsPreviousMonth = Rating::query()->whereNull('deleted_at')->whereBetween('created_at', [$startPreviousMonth, $endPreviousMonth])->count();

        $contactsCurrentMonth = Contact::query()->whereNull('deleted_at')->whereBetween('created_at', [$startCurrentMonth, $now])->count();
        $contactsPreviousMonth = Contact::query()->whereNull('deleted_at')->whereBetween('created_at', [$startPreviousMonth, $endPreviousMonth])->count();

        $countriesCurrentMonth = Country::query()->whereNull('deleted_at')->whereBetween('created_at', [$startCurrentMonth, $now])->count();
        $countriesPreviousMonth = Country::query()->whereNull('deleted_at')->whereBetween('created_at', [$startPreviousMonth, $endPreviousMonth])->count();

        $productsCurrentMonth = (clone $productsBase)->whereBetween('created_at', [$startCurrentMonth, $now])->count();
        $productsPreviousMonth = (clone $productsBase)->whereBetween('created_at', [$startPreviousMonth, $endPreviousMonth])->count();

        $chartMonths = [];
        $ordersSeries = [];
        $revenueSeries = [];
        for ($i = 11; $i >= 0; $i--) {
            $monthStart = Carbon::now()->subMonths($i)->startOfMonth();
            $monthEnd = $monthStart->copy()->endOfMonth();

            $chartMonths[] = $monthStart->locale(app()->getLocale())->translatedFormat('M Y');
            $ordersSeries[] = (clone $ordersBase)->whereBetween('created_at', [$monthStart, $monthEnd])->count();
            $revenueSeries[] = (float) (clone $ordersBase)
                ->where('payment_status', 1)
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('total_cost');
        }

        $totalOrders = (clone $ordersBase)->count();
        $paidOrders = (clone $ordersBase)->where('payment_status', 1)->count();
        $unpaidOrders = (clone $ordersBase)->where('payment_status', 0)->count();

        $totalOffers = (clone $offersBase)->count();
        $pendingOffers = (clone $offersBase)->whereIn('status', $pendingOfferStatuses)->count();
        $acceptedOffers = (clone $offersBase)->whereIn('status', $acceptedOfferStatuses)->count();

        $scheduledOrdersCollection = (clone $ordersBase)
            ->scheduled()
            ->with(['offers', 'timeline'])
            ->get();
        $scheduledOrders = $scheduledOrdersCollection->count();
        $activeScheduledOrders = $scheduledOrdersCollection
            ->filter(fn (Order $order) => $order->scheduled_status === 'active')
            ->count();
        $completedScheduledOrders = $scheduledOrdersCollection
            ->filter(fn (Order $order) => $order->scheduled_status === 'completed')
            ->count();

        $recentOrders = (clone $ordersBase)
            ->with(['user:id,name,email', 'provider:id,name,email'])
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        $recentUsers = (clone $usersBase)
            ->select(['id', 'name', 'email', 'created_at'])
            ->orderByDesc('id')
            ->limit(8)
            ->get();

        $topCategories = Category::query()
            ->whereNull('deleted_at')
            ->withCount(['products' => function ($query) {
                $query->whereNull('deleted_at');
            }])
            ->orderByDesc('products_count')
            ->limit(5)
            ->get();

        $topProducts = Product::query()
            ->whereNull('deleted_at')
            ->select(['id', 'name', 'price', 'stock_quantity'])
            ->orderByDesc('id')
            ->limit(8)
            ->get();

        $lowStockProducts = Product::query()
            ->whereNull('deleted_at')
            ->where('stock_quantity', '<', self::LOW_STOCK_THRESHOLD)
            ->select(['id', 'name', 'stock_quantity', 'price'])
            ->orderBy('stock_quantity')
            ->limit(6)
            ->get();

        $vendorsWithLowStockProducts = Product::query()
            ->whereNull('deleted_at')
            ->where('stock_quantity', '<', self::LOW_STOCK_THRESHOLD)
            ->whereNotNull('provider_id')
            ->distinct('provider_id')
            ->count('provider_id');

        $totalUnreadNotifications = (clone $notificationsBase)->unread()->count();
        $vendorUnreadNotifications = Notification::query()
            ->whereNull('deleted_at')
            ->whereNull('read_at')
            ->whereHas('user', function ($query) {
                $query->where('user_type', 2)
                    ->whereNull('deleted_at');
            })
            ->count();

        $dashboard = [
            'totals' => [
                'orders' => $totalOrders,
                'users' => (clone $usersBase)->count(),
                'customers_count' => (clone $customersBase)->count(),
                'vendors_count' => (clone $vendorsBase)->count(),
                'products' => (clone $productsBase)->count(),
                'revenue' => (float) (clone $ordersBase)->where('payment_status', 1)->sum('total_cost'),
                'paid_orders' => $paidOrders,
                'unpaid_orders' => $unpaidOrders,
                'categories' => Category::whereNull('deleted_at')->count(),
                'coupons' => Coupon::whereNull('deleted_at')->count(),
                'ratings' => Rating::whereNull('deleted_at')->count(),
                'contacts' => Contact::whereNull('deleted_at')->count(),
                'countries' => Country::whereNull('deleted_at')->count(),
                'low_stock' => (clone $productsBase)->where('stock_quantity', '<', self::LOW_STOCK_THRESHOLD)->count(),
                'total_offers' => $totalOffers,
                'pending_offers' => $pendingOffers,
                'accepted_offers' => $acceptedOffers,
                'acceptance_rate' => $this->safeRate($acceptedOffers, $totalOffers),
                'active_vendors' => (clone $vendorsBase)->where('is_activate', 1)->count(),
                'inactive_vendors' => (clone $vendorsBase)->where('is_activate', 0)->count(),
                'vendors_with_low_stock_products' => $vendorsWithLowStockProducts,
                'scheduled_orders' => $scheduledOrders,
                'active_scheduled_orders' => $activeScheduledOrders,
                'completed_scheduled_orders' => $completedScheduledOrders,
                'total_unread_notifications' => $totalUnreadNotifications,
                'vendor_unread_notifications' => $vendorUnreadNotifications,
            ],
            'growth' => [
                'orders' => $this->growthRate($ordersCurrentMonth, $ordersPreviousMonth),
                'revenue' => $this->growthRate((float) $revenueCurrentMonth, (float) $revenuePreviousMonth),
                'users' => $this->growthRate($usersCurrentMonth, $usersPreviousMonth),
                'products' => $this->growthRate($productsCurrentMonth, $productsPreviousMonth),
                'categories' => $this->growthRate($categoriesCurrentMonth, $categoriesPreviousMonth),
                'coupons' => $this->growthRate($couponsCurrentMonth, $couponsPreviousMonth),
                'ratings' => $this->growthRate($ratingsCurrentMonth, $ratingsPreviousMonth),
                'contacts' => $this->growthRate($contactsCurrentMonth, $contactsPreviousMonth),
                'countries' => $this->growthRate($countriesCurrentMonth, $countriesPreviousMonth),
            ],
            'charts' => [
                'months' => $chartMonths,
                'orders' => $ordersSeries,
                'revenue' => $revenueSeries,
            ],
            'recent_orders' => $recentOrders,
            'recent_users' => $recentUsers,
            'top_products' => $topProducts,
            'low_stock_products' => $lowStockProducts,
            'top_categories' => $topCategories,
        ];

        return view('admin.home', compact('dashboard'));
    }

    private function growthRate(float|int $current, float|int $previous): float
    {
        if ((float) $previous === 0.0) {
            return (float) $current > 0 ? 100.0 : 0.0;
        }

        return round(((($current - $previous) / $previous) * 100), 2);
    }

    private function safeRate(int $numerator, int $denominator): float
    {
        if ($denominator <= 0) {
            return 0.0;
        }

        return round(($numerator / $denominator) * 100, 2);
    }

    private function pendingOfferStatuses(): array
    {
        return [1, '1', 'pending'];
    }

    private function acceptedOfferStatuses(): array
    {
        return [2, '2', 'accepted'];
    }

}
