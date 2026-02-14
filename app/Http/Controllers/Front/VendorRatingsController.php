<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;

class VendorRatingsController extends Controller
{
    /**
     * Display vendor ratings and reviews
     */
    public function index(Request $request)
    {
        $vendorId = auth()->id();
        
        // Get vendor's products
        $products = Product::where('provider_id', $vendorId)->get();
        $productIds = $products->pluck('id')->toArray();
        
        // Build query for ratings
        $query = Rating::where('forable_type', Product::class)
            ->whereIn('forable_id', $productIds)
            ->with(['forable', 'user'])
            ->orderBy('created_at', 'desc');
        
        // Filter by product if selected
        if ($request->has('product_id') && $request->product_id) {
            $query->where('forable_id', $request->product_id);
        }
        
        // Filter by rating score if provided
        if ($request->has('rating') && $request->rating) {
            $query->where('rating', $request->rating);
        }
        
        $ratings = $query->paginate(10);
        
        // Calculate statistics
        $baseRatingQuery = Rating::where('forable_type', Product::class)
            ->whereIn('forable_id', $productIds);
        $totalRatings = (clone $baseRatingQuery)->count();
        $averageRating = (clone $baseRatingQuery)->avg('rating') ?? 0;
        $ratingBreakdown = [];
        for ($i = 5; $i >= 1; $i--) {
            $ratingBreakdown[$i] = Rating::where('forable_type', Product::class)
                ->whereIn('forable_id', $productIds)
                ->where('rating', $i)
                ->count();
        }
        
        return view('front.vendor.ratings.index', [
            'ratings' => $ratings,
            'products' => $products,
            'totalRatings' => $totalRatings,
            'averageRating' => round($averageRating, 2),
            'ratingBreakdown' => $ratingBreakdown,
        ]);
    }
}
