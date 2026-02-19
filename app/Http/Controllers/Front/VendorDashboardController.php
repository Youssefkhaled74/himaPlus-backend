<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Notification;
use Illuminate\Http\Request;

class VendorDashboardController extends Controller
{
    private function pendingOfferStatuses(): array
    {
        return [1, '1', 'pending'];
    }

    public function dashboard(Request $request)
    {
        $vendor = auth()->user();
        
        // Get vendor's orders
        $ordersCount = Order::where('provider_id', $vendor->id)
            ->where('deleted_at', null)
            ->count();
        
        $offersCount = Offer::where('provider_id', $vendor->id)
            ->where('deleted_at', null)
            ->count();
        
        $productsCount = Product::where('provider_id', $vendor->id)
            ->where('deleted_at', null)
            ->where('is_activate', 1)
            ->count();
        
        // Get scheduled orders count
        $scheduledOrdersCount = Order::scheduled()
            ->where(function ($query) use ($vendor) {
                $query->where('provider_id', $vendor->id)
                    ->orWhereHas('offers', function ($offersQuery) use ($vendor) {
                        $offersQuery->where('provider_id', $vendor->id);
                    });
            })
            ->where('deleted_at', null)
            ->count();
        
        // Get average rating
        $avgRating = Rating::where('forable_id', $vendor->id)
            ->where('forable_type', 'App\\Models\\User')
            ->avg('rating') ?? 0;
        
        $ratingCount = Rating::where('forable_id', $vendor->id)
            ->where('forable_type', 'App\\Models\\User')
            ->count();
        
        // Get recent orders
        $recentOrders = Order::where('provider_id', $vendor->id)
            ->where('deleted_at', null)
            ->with(['user:id,name,email,mobile'])
            ->latest()
            ->take(3)
            ->get();
        
        // Get recent scheduled orders
        $recentScheduledOrders = Order::scheduled()
            ->where(function ($query) use ($vendor) {
                $query->where('provider_id', $vendor->id)
                    ->orWhereHas('offers', function ($offersQuery) use ($vendor) {
                        $offersQuery->where('provider_id', $vendor->id);
                    });
            })
            ->where('deleted_at', null)
            ->with(['user:id,name,email,mobile', 'offers'])
            ->latest()
            ->take(3)
            ->get();
        
        // Get pending offers
        $pendingOffers = Offer::where('provider_id', $vendor->id)
            ->where('deleted_at', null)
            ->whereIn('status', $this->pendingOfferStatuses())
            ->with(['order:id,order_type,user_id'])
            ->latest()
            ->take(3)
            ->get();
        
        // Get notifications
        $recentNotifications = Notification::where('user_id', $vendor->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        
        $unreadNotificationsCount = Notification::where('user_id', $vendor->id)
            ->unread()
            ->count();
        
        return view('front.vendor.dashboard', compact(
            'ordersCount',
            'offersCount',
            'productsCount',
            'scheduledOrdersCount',
            'avgRating',
            'ratingCount',
            'recentOrders',
            'recentScheduledOrders',
            'pendingOffers',
            'recentNotifications',
            'unreadNotificationsCount'
        ));
    }
}
