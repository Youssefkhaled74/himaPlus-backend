<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class VendorRatingsController extends Controller
{
    /**
     * Display vendor ratings and reviews
     */
    public function index(Request $request)
    {
        $vendorId = (int) auth()->id();

        // Get vendor's products
        $products = Product::where('provider_id', $vendorId)->get();
        $productIds = $products->pluck('id')->toArray();

        $baseQuery = Rating::query()
            ->with(['forable', 'user'])
            ->where(function ($query) use ($vendorId, $productIds) {
                $query->where(function ($subQuery) use ($productIds) {
                    $subQuery->where('forable_type', Product::class)
                        ->whereIn('forable_id', $productIds);
                })->orWhere(function ($subQuery) use ($vendorId) {
                    $subQuery->where('forable_type', User::class)
                        ->where('forable_id', $vendorId);
                });
            });

        // Filter by product if selected
        if ($request->filled('product_id')) {
            $baseQuery->where(function ($query) use ($request) {
                $query->where('forable_type', Product::class)
                    ->where('forable_id', (int) $request->product_id);
            });
        }

        // Filter by rating score if provided
        if ($request->filled('rating')) {
            $baseQuery->where('rating', (int) $request->rating);
        }

        $ratings = $baseQuery->orderByDesc('created_at')->paginate(10);

        // Calculate statistics
        $baseRatingQuery = clone $baseQuery;
        $totalRatings = (clone $baseRatingQuery)->count();
        $averageRating = (clone $baseRatingQuery)->avg('rating') ?? 0;
        $ratingBreakdown = [];
        for ($i = 5; $i >= 1; $i--) {
            $ratingBreakdown[$i] = (clone $baseRatingQuery)->where('rating', $i)->count();
        }

        $reviewedItemsCount = (clone $baseRatingQuery)
            ->selectRaw('CONCAT(forable_type, ":", forable_id) as key')
            ->get()
            ->pluck('key')
            ->unique()
            ->count();

        return view('front.vendor.ratings.index', [
            'ratings' => $ratings,
            'products' => $products,
            'totalRatings' => $totalRatings,
            'averageRating' => round($averageRating, 2),
            'ratingBreakdown' => $ratingBreakdown,
            'reviewedItemsCount' => $reviewedItemsCount,
        ]);
    }
}
