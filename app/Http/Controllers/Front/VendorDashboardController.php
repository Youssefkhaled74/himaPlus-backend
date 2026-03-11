<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class VendorDashboardController extends Controller
{
    private function relevantOrdersQuery(int $vendorId): Builder
    {
        return Order::query()
            ->whereNull('deleted_at')
            ->where(function ($query) use ($vendorId) {
                $query->where('provider_id', $vendorId)
                    ->orWhereHas('offers', function ($offersQuery) use ($vendorId) {
                        $offersQuery->where('provider_id', $vendorId);
                    });
            });
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

        $ordersBaseQuery = $this->relevantOrdersQuery((int) $vendor->id);

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
            ->where('stock_quantity', '<=', 5)
            ->count();
        
        $scheduledOrdersCount = (clone $ordersBaseQuery)
            ->scheduled()
            ->count();

        $completedOrdersCount = (clone $ordersBaseQuery)
            ->whereHas('timeline', function ($timelineQuery) {
                $timelineQuery->where('timeline_no', 6);
            })
            ->count();
        
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

        $newRequestsCount = (clone $ordersBaseQuery)
            ->where(function ($query) use ($vendor) {
                $query->whereNull('provider_id')
                    ->orWhereHas('offers', function ($offersQuery) use ($vendor) {
                        $offersQuery->where('provider_id', $vendor->id)
                            ->whereIn('status', $this->pendingOfferStatuses());
                    });
            })
            ->count();
        
        $recentOrders = (clone $ordersBaseQuery)
            ->with(['user:id,name,email,mobile', 'offers'])
            ->latest()
            ->take(3)
            ->get();
        
        $recentScheduledOrders = (clone $ordersBaseQuery)
            ->scheduled()
            ->with(['user:id,name,email,mobile', 'offers'])
            ->latest()
            ->take(3)
            ->get();
        
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
}
