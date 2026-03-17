<?php

namespace App\Http\ServicesLayer\Admin\HomeServices;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use Carbon\Carbon;

class HomeService
{
    public function home()
    {
        $now = now();
        $startCurrentMonth = $now->copy()->startOfMonth();
        $startPreviousMonth = $now->copy()->subMonth()->startOfMonth();
        $endPreviousMonth = $startCurrentMonth->copy()->subSecond();

        $ordersBase = Order::query()->whereNull('deleted_at');
        $usersBase = User::query()->whereNull('deleted_at');
        $productsBase = Product::query()->whereNull('deleted_at');

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

        $productsCurrentMonth = (clone $productsBase)->whereBetween('created_at', [$startCurrentMonth, $now])->count();
        $productsPreviousMonth = (clone $productsBase)->whereBetween('created_at', [$startPreviousMonth, $endPreviousMonth])->count();

        $chartMonths = [];
        $ordersSeries = [];
        $revenueSeries = [];
        for ($i = 11; $i >= 0; $i--) {
            $monthStart = Carbon::now()->subMonths($i)->startOfMonth();
            $monthEnd = $monthStart->copy()->endOfMonth();

            $chartMonths[] = $monthStart->format('M Y');
            $ordersSeries[] = (clone $ordersBase)->whereBetween('created_at', [$monthStart, $monthEnd])->count();
            $revenueSeries[] = (float) (clone $ordersBase)
                ->where('payment_status', 1)
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('total_cost');
        }

        $totalOrders = (clone $ordersBase)->count();
        $paidOrders = (clone $ordersBase)->where('payment_status', 1)->count();
        $unpaidOrders = (clone $ordersBase)->where('payment_status', 0)->count();

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
            ->where('stock_quantity', '<', 20)
            ->select(['id', 'name', 'stock_quantity', 'price'])
            ->orderBy('stock_quantity')
            ->limit(6)
            ->get();

        $dashboard = [
            'totals' => [
                'orders' => $totalOrders,
                'users' => (clone $usersBase)->count(),
                'products' => (clone $productsBase)->count(),
                'revenue' => (float) (clone $ordersBase)->where('payment_status', 1)->sum('total_cost'),
                'paid_orders' => $paidOrders,
                'unpaid_orders' => $unpaidOrders,
                'categories' => Category::whereNull('deleted_at')->count(),
                'coupons' => Coupon::whereNull('deleted_at')->count(),
                'ratings' => Rating::whereNull('deleted_at')->count(),
                'contacts' => Contact::whereNull('deleted_at')->count(),
                'low_stock' => (clone $productsBase)->where('stock_quantity', '<', 20)->count(),
            ],
            'growth' => [
                'orders' => $this->growthRate($ordersCurrentMonth, $ordersPreviousMonth),
                'revenue' => $this->growthRate((float) $revenueCurrentMonth, (float) $revenuePreviousMonth),
                'users' => $this->growthRate($usersCurrentMonth, $usersPreviousMonth),
                'products' => $this->growthRate($productsCurrentMonth, $productsPreviousMonth),
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

}
