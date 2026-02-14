<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Offer;
use App\Models\OrderItem;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorAnalyticsController extends Controller
{
    private function acceptedOfferStatuses(): array
    {
        return [2, '2', 'accepted'];
    }

    /**
     * Display analytics dashboard
     */
    public function index(Request $request)
    {
        $vendorId = auth()->id();
        $period = $request->get('period', '30'); // 7, 30, 90 days or 'all'
        
        // Calculate date range
        $startDate = match($period) {
            '7' => now()->subDays(7),
            '90' => now()->subDays(90),
            'all' => null,
            default => now()->subDays(30),
        };
        
        // Get vendor's products
        $products = Product::where('provider_id', $vendorId)->get();
        $productIds = $products->pluck('id')->toArray();
        
        // Get orders statistics
        $ordersQuery = Order::where('provider_id', $vendorId)->whereNull('deleted_at');
        if ($startDate) {
            $ordersQuery->where('created_at', '>=', $startDate);
        }
        $totalOrders = (clone $ordersQuery)->count();
        $completedOrders = (clone $ordersQuery)
            ->whereHas('timeline', function ($timelineQuery) {
                $timelineQuery->where('timeline_no', 6);
            })
            ->count();

        // Get offers statistics
        $offersQuery = Offer::where('provider_id', $vendorId)->whereNull('deleted_at');
        if ($startDate) {
            $offersQuery->where('created_at', '>=', $startDate);
        }
        $totalOffers = (clone $offersQuery)->count();
        $acceptedOffers = (clone $offersQuery)
            ->whereIn('status', $this->acceptedOfferStatuses())
            ->count();
        $acceptanceRate = $totalOffers > 0 ? round(($acceptedOffers / $totalOffers) * 100, 2) : 0;

        // Top products by orders
        $topProducts = OrderItem::query()
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('orders.provider_id', $vendorId)
            ->whereNull('orders.deleted_at')
            ->select('order_items.product_id', DB::raw('COUNT(*) as order_count'), DB::raw('MAX(products.name) as product_name'))
            ->groupBy('order_items.product_id')
            ->orderBy('order_count', 'desc')
            ->limit(5)
            ->get();

        // Product ratings
        $avgProductRating = Rating::where('forable_type', Product::class)
            ->whereIn('forable_id', $productIds)
            ->avg('rating') ?? 0;
        $totalProductRatings = Rating::where('forable_type', Product::class)
            ->whereIn('forable_id', $productIds)
            ->count();

        // Revenue data (if price available in offers)
        $revenueDataQuery = Offer::where('provider_id', $vendorId)
            ->whereIn('status', $this->acceptedOfferStatuses());
        if ($startDate) {
            $revenueDataQuery->where('created_at', '>=', $startDate);
        }
        $revenueData = $revenueDataQuery
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(cost) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->limit(30)
            ->get();

        // Orders by status
        $ordersByStatus = Order::where('provider_id', $vendorId)
            ->whereNull('deleted_at')
            ->select('payment_status', DB::raw('count(*) as count'))
            ->groupBy('payment_status')
            ->get()
            ->mapWithKeys(function ($item) {
                $key = ((int) $item->payment_status === 1) ? 'Paid' : 'Unpaid';
                return [$key => $item->count];
            })
            ->toArray();

        // Monthly orders chart data
        $monthlyOrdersQuery = Order::where('provider_id', $vendorId)->whereNull('deleted_at');
        if ($startDate) {
            $monthlyOrdersQuery->where('created_at', '>=', $startDate);
        }
        $monthlyOrders = $monthlyOrdersQuery
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as count'))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->pluck('count', 'month')
            ->toArray();
        
        // Prepare chart data
        $months = [];
        $ordersCount = [];
        for ($i = 1; $i <= 12; $i++) {
            $translated = __('months.' . $i);
            $months[] = ($translated === 'months.' . $i) ? now()->startOfYear()->month($i)->format('M') : $translated;
            $ordersCount[] = $monthlyOrders[$i] ?? 0;
        }
        
        return view('front.vendor.analytics.index', [
            'totalOrders' => $totalOrders,
            'completedOrders' => $completedOrders,
            'totalOffers' => $totalOffers,
            'acceptedOffers' => $acceptedOffers,
            'acceptanceRate' => $acceptanceRate,
            'avgProductRating' => round($avgProductRating, 2),
            'totalProductRatings' => $totalProductRatings,
            'topProducts' => $topProducts,
            'revenueData' => $revenueData,
            'ordersByStatus' => $ordersByStatus,
            'monthlyOrders' => $monthlyOrders,
            'chartMonths' => $months,
            'chartOrdersCount' => $ordersCount,
            'period' => $period,
            'products' => $products,
        ]);
    }
}
