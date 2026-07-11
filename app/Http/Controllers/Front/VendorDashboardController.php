<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Notification;
use App\Models\Category;
use App\Services\OrderStatusService;
use App\Services\VendorOrderVisibilityService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class VendorDashboardController extends Controller
{
    public function __construct(
        private OrderStatusService $orderStatusService,
        private VendorOrderVisibilityService $vendorOrderVisibilityService
    )
    {
    }

    private function pendingOfferStatuses(): array
    {
        return [1, '1', 'pending'];
    }

    private function acceptedOfferStatuses(): array
    {
        return [2, '2', 'accepted'];
    }

    public function dashboard(Request $request)
    {
        $vendor = auth()->user();

        $ordersBaseQuery = $this->vendorOrderVisibilityService->visibleOrdersQuery((int) $vendor->id, 'all');

        $ordersCount = (clone $ordersBaseQuery)->count();
        
        $offersCount = Offer::where('provider_id', $vendor->id)
            ->whereNull('deleted_at')
            ->count();

        $acceptedOffersCount = Offer::where('provider_id', $vendor->id)
            ->whereNull('deleted_at')
            ->whereIn('status', $this->acceptedOfferStatuses())
            ->count();

        $acceptanceRate = $offersCount > 0 ? round(($acceptedOffersCount / $offersCount) * 100, 1) : 0;
        
        $productsCount = Product::where('provider_id', $vendor->id)
            ->whereNull('deleted_at')
            ->where('is_activate', 1)
            ->count();

        $inactiveProductsCount = Product::where('provider_id', $vendor->id)
            ->whereNull('deleted_at')
            ->where('is_activate', 0)
            ->count();

        $lowStockProductsCount = Product::where('provider_id', $vendor->id)
            ->whereNull('deleted_at')
            ->where('is_activate', 1)
            ->lowStock()
            ->count();
        
        $scheduledOrdersCount = $this->orderStatusService->countByStatus($ordersBaseQuery, OrderStatusService::STATUS_SCHEDULED, ['provider_id' => (int) $vendor->id]);
        $completedOrdersCount = $this->orderStatusService->countByStatus($ordersBaseQuery, OrderStatusService::STATUS_COMPLETED, ['provider_id' => (int) $vendor->id]);
        $confirmedOrdersCount = $this->orderStatusService->countByStatus($ordersBaseQuery, OrderStatusService::STATUS_CONFIRMED, ['provider_id' => (int) $vendor->id]);
        $processingOrdersCount = $this->orderStatusService->countByStatus($ordersBaseQuery, OrderStatusService::STATUS_PROCESSING, ['provider_id' => (int) $vendor->id]);
        
        $avgRating = Rating::where('forable_id', $vendor->id)
            ->where('forable_type', 'App\\Models\\User')
            ->avg('rating') ?? 0;
        
        $ratingCount = Rating::where('forable_id', $vendor->id)
            ->where('forable_type', 'App\\Models\\User')
            ->count();

        $estimatedRevenue = Offer::where('provider_id', $vendor->id)
            ->whereNull('deleted_at')
            ->whereIn('status', $this->acceptedOfferStatuses())
            ->sum('cost');

        $newRequestsCount = $this->vendorOrderVisibilityService->visibleOrdersQuery((int) $vendor->id, 'quotations')
            ->whereNull('provider_id')
            ->count()
            + $this->vendorOrderVisibilityService->visibleOrdersQuery((int) $vendor->id, 'maintenance')
                ->whereNull('provider_id')
                ->count();
        
        $recentOrders = (clone $ordersBaseQuery)
            ->with(['user:id,name,email,mobile', 'offers'])
            ->latest()
            ->take(3)
            ->get()
            ->each(function ($order) use ($vendor) {
                $order->front_status_state = $order->resolveStatus([
                    'audience' => 'front',
                    'provider_id' => (int) $vendor->id,
                ]);
            });
        
        $recentScheduledOrders = $this->vendorOrderVisibilityService
            ->visibleOrdersQuery((int) $vendor->id, 'scheduled')
            ->with(['user:id,name,email,mobile', 'offers'])
            ->latest()
            ->take(3)
            ->get()
            ->each(function ($order) use ($vendor) {
                $order->front_status_state = $order->resolveStatus([
                    'audience' => 'front',
                    'provider_id' => (int) $vendor->id,
                ]);
            });
        
        $pendingOffersQuery = Offer::where('provider_id', $vendor->id)
            ->whereNull('deleted_at')
            ->whereIn('status', $this->pendingOfferStatuses())
            ->with(['order:id,order_type,user_id']);

        $pendingOffersCount = (clone $pendingOffersQuery)->count();

        $pendingOffers = $pendingOffersQuery
            ->latest()
            ->take(3)
            ->get();
        
        $recentNotifications = Notification::where('user_id', $vendor->id)
            ->whereIn('type', ['order', 'payment', 'status_change', 'product_approval', 'product_rejection'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        
        $unreadNotificationsCount = Notification::where('user_id', $vendor->id)
            ->unread()
            ->count();

        $featuredProducts = Product::query()
            ->whereNull('deleted_at')
            ->where('is_activate', 1)
            ->latest()
            ->take(6)
            ->get();
        
        return view('front.vendor.dashboard', compact(
            'ordersCount',
            'offersCount',
            'productsCount',
            'scheduledOrdersCount',
            'confirmedOrdersCount',
            'processingOrdersCount',
            'acceptedOffersCount',
            'acceptanceRate',
            'completedOrdersCount',
            'estimatedRevenue',
            'inactiveProductsCount',
            'lowStockProductsCount',
            'newRequestsCount',
            'avgRating',
            'ratingCount',
            'recentOrders',
            'recentScheduledOrders',
            'pendingOffers',
            'pendingOffersCount',
            'recentNotifications',
            'unreadNotificationsCount',
            'featuredProducts'
        ));
    }

    public function invoices(Request $request)
    {
        $vendor = auth()->user();
        $orderStatus = (string) $request->get('order_status', '');
        $paymentStatus = (string) $request->get('payment_status', '');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        $baseQuery = $this->vendorOrderVisibilityService->visibleOrdersQuery((int) $vendor->id, 'all');

        $filteredQuery = (clone $baseQuery)
            ->with(['user:id,name', 'offers', 'timeline']);

        if ($orderStatus !== '') {
            $filteredQuery = $this->orderStatusService->applyStatusFilter(
                $filteredQuery,
                $orderStatus,
                ['provider_id' => (int) $vendor->id]
            );
        }

        if ($paymentStatus !== '') {
            $filteredQuery->where('payment_status', $paymentStatus === 'paid' ? 1 : 0);
        }

        if ($dateFrom) {
            $filteredQuery->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $filteredQuery->whereDate('created_at', '<=', $dateTo);
        }

        $invoices = $filteredQuery->latest()->paginate(15)->withQueryString()
            ->through(function ($order) use ($vendor) {
                $order->front_status_state = $order->resolveStatus([
                    'audience' => 'front',
                    'provider_id' => (int) $vendor->id,
                ]);

                return $order;
            });

        $countsQuery = clone $baseQuery;
        $vendorId = (int) $vendor->id;
        $totals = [
            'paid' => (clone $countsQuery)->where('payment_status', 1)->count(),
            'pending' => (clone $countsQuery)->where('payment_status', 0)->count(),
            'scheduled' => $this->orderStatusService->countByStatus(clone $baseQuery, OrderStatusService::STATUS_SCHEDULED, ['provider_id' => $vendorId]),
            'completed' => $this->orderStatusService->countByStatus(clone $baseQuery, OrderStatusService::STATUS_COMPLETED, ['provider_id' => $vendorId]),
            'processing' => $this->orderStatusService->countByStatus(clone $baseQuery, OrderStatusService::STATUS_PROCESSING, ['provider_id' => $vendorId]),
            'cancelled' => $this->orderStatusService->countByStatus(clone $baseQuery, OrderStatusService::STATUS_CANCELLED, ['provider_id' => $vendorId]),
        ];

        return view('front.vendor.invoices.index', compact('invoices', 'totals', 'orderStatus', 'paymentStatus', 'dateFrom', 'dateTo'));
    }

    public function categories()
    {
        $categories = Category::whereNull('deleted_at')
            ->with(['products' => function ($query) {
                $query->where('provider_id', auth()->id())->latest();
            }])->orderBy('name')->get();

        return view('front.vendor.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $payload = ['name' => $request->name];
        if ($request->hasFile('img')) {
            $payload['img'] = uploadIamge($request->file('img'), 'categories');
        }

        Category::create($payload);
        flash()->success('Category added successfully');
        return back();
    }
}
