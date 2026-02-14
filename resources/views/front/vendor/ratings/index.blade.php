@extends('layouts.front.home')

@section('title')
    <title>{{ __('nav.ratings_reviews') ?? 'Ratings & Reviews' }} - Vendor | HemaPulse</title>
@endsection

@section('css')
    <style>
        .rating-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }
        .rating-card:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .star {
            color: #ffc107;
            font-size: 18px;
        }
        .empty-star {
            color: #ddd;
            font-size: 18px;
        }
        .stat-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
        }
        .stat-number {
            font-size: 32px;
            font-weight: bold;
        }
        .stat-label {
            font-size: 14px;
            opacity: 0.9;
            margin-top: 5px;
        }
        .rating-bar {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .rating-bar-label {
            width: 60px;
            font-weight: 500;
        }
        .rating-bar-fill {
            flex: 1;
            height: 8px;
            background: #e0e0e0;
            border-radius: 4px;
            margin: 0 10px;
            position: relative;
        }
        .rating-bar-value {
            width: 50px;
            text-align: right;
            font-size: 12px;
            color: #666;
        }
        .review-text {
            font-size: 14px;
            color: #555;
            line-height: 1.6;
            margin-top: 10px;
        }
    </style>
@endsection

@section('content')
    <main class="container my-4" style="max-width: 95%; margin-top: 8% !important;">
        @include('flash::message')
        
        <!-- Breadcrumb -->
        <nav class="breadcrumb-custom mb-3">
            <a href="{{ route('vendor/dashboard') }}" class="text-decoration-none text-muted">{{ __('nav.dashboard') ?? 'Dashboard' }}</a>
            <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
            <span class="text-primary fw-semibold">{{ __('nav.ratings_reviews') ?? 'Ratings & Reviews' }}</span>
        </nav>

        <!-- Header -->
        <div class="card mb-4">
            <div class="card-header bg-gradient">
                <h4 class="mb-0"><i class="bi bi-star-fill me-2"></i>{{ __('nav.ratings_reviews') ?? 'Ratings & Reviews' }}</h4>
            </div>
            
            <div class="card-body">
                <!-- Statistics -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="stat-box">
                            <div class="stat-number">{{ $averageRating }}</div>
                            <div class="stat-label">{{ __('nav.average_rating') ?? 'Average Rating' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-box" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <div class="stat-number">{{ $totalRatings }}</div>
                            <div class="stat-label">{{ __('nav.total_reviews') ?? 'Total Reviews' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-box" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <div class="stat-number">{{ count($products) }}</div>
                            <div class="stat-label">{{ __('nav.your_products') ?? 'Your Products' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Rating Breakdown -->
                <div class="mb-4">
                    <h5 class="mb-3">{{ __('nav.rating_breakdown') ?? 'Rating Breakdown' }}</h5>
                    @for ($i = 5; $i >= 1; $i--)
                        <div class="rating-bar">
                            <div class="rating-bar-label">
                                <span class="star">★</span> {{ $i }}
                            </div>
                            <div class="rating-bar-fill">
                                @php
                                    $percentage = $totalRatings > 0 ? ($ratingBreakdown[$i] / $totalRatings) * 100 : 0;
                                @endphp
                                <div style="width: {{ $percentage }}%; height: 100%; background: linear-gradient(90deg, #667eea, #764ba2); border-radius: 4px;"></div>
                            </div>
                            <div class="rating-bar-value">{{ $ratingBreakdown[$i] }}</div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('vendor/ratings') }}" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('profile.product') ?? 'Product' }}</label>
                        <select name="product_id" class="form-select">
                            <option value="">{{ __('profile.all') ?? 'All Products' }}</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('nav.rating') ?? 'Rating' }}</label>
                        <select name="rating" class="form-select">
                            <option value="">{{ __('profile.all') ?? 'All' }}</option>
                            @for ($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                    {{ $i }} <span class="star">★</span>
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">{{ __('profile.search') ?? 'Search' }}</button>
                        <a href="{{ route('vendor/ratings') }}" class="btn btn-secondary">{{ __('profile.reset') ?? 'Reset' }}</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Reviews List -->
        @if($ratings->count() > 0)
            @foreach($ratings as $rating)
                <div class="rating-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h5 class="mb-2">{{ $rating->forable?->name ?? 'Product' }}</h5>
                            <div class="mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $rating->rating)
                                        <span class="star">★</span>
                                    @else
                                        <span class="empty-star">★</span>
                                    @endif
                                @endfor
                                <span class="text-muted ms-2">({{ $rating->rating }}/5)</span>
                            </div>
                            <p class="text-muted mb-2">
                                <strong>{{ $rating->user?->name ?? 'Anonymous' }}</strong>
                                <span class="text-muted">• {{ $rating->created_at->diffForHumans() }}</span>
                            </p>
                            @if($rating->comment)
                                <div class="review-text">
                                    "{{ $rating->comment }}"
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    {{ $ratings->links() }}
                </ul>
            </nav>
        @else
            <div class="alert alert-info text-center py-4">
                <i class="bi bi-info-circle me-2"></i>
                {{ __('messages.no_data') ?? 'No reviews yet' }}
            </div>
        @endif
    </main>
@endsection

@section('scripts')
    <script>
        // Add any interactive features if needed
    </script>
@endsection
