@extends('layouts.front.home')

@section('title')
    <title>{{ trans_or_fallback('', '') }} - Vendor | Hema</title>
@endsection

@section('css')
<style>
    .vendor-ratings {
        --vr-bg: #f5f6f8;
        --vr-card: #ffffff;
        --vr-border: #e7eaf0;
        --vr-title: #0f2f7f;
        --vr-text: #1f2937;
        --vr-muted: #6b7280;
        --vr-primary: #0f4bbf;
        --vr-accent: #0ec6a0;
        --vr-soft: #eef5ff;
        --vr-star: #fbbf24;
        max-width: 95%;
        margin: 12px auto 0;
        background: var(--vr-bg);
        padding: 8px 0 24px;
        font-family: "Poppins", "Tajawal", system-ui, -apple-system, "Segoe UI", Arial, sans-serif;
    }

    .vendor-ratings * {
        font-family: inherit;
    }

    .vr-card {
        background: var(--vr-card);
        border: 1px solid var(--vr-border);
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.04);
    }

    .vr-breadcrumb {
        font-size: 13px;
        margin-bottom: 12px;
    }

    .vr-breadcrumb a {
        text-decoration: none;
        color: #6b7280;
    }

    .vr-breadcrumb .active {
        color: var(--vr-primary);
        font-weight: 700;
    }

    .vr-hero {
        padding: 22px;
        margin-bottom: 16px;
    }

    .vr-title {
        margin: 0 0 6px;
        color: var(--vr-title);
        font-size: 34px;
        line-height: 1.08;
        font-weight: 800;
        letter-spacing: -0.01em;
    }

    .vr-subtitle {
        margin: 0;
        color: #475569;
        font-size: 16px;
        line-height: 1.55;
        max-width: 760px;
    }

    .vr-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .vr-btn-primary,
    .vr-btn-outline {
        border-radius: 10px;
        font-weight: 700;
        padding: 10px 16px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .vr-btn-primary {
        border: 0;
        color: #fff;
        background: linear-gradient(90deg, var(--vr-primary) 0%, var(--vr-accent) 100%);
    }

    .vr-btn-outline {
        border: 1px solid #cbd5e1;
        color: #1e3a8a;
        background: #fff;
    }

    .vr-stat {
        padding: 16px 18px;
        height: 100%;
        transition: all .2s ease;
    }

    .vr-stat:hover {
        border-color: #93c5fd;
        box-shadow: 0 4px 12px rgba(15, 75, 191, .08);
        transform: translateY(-1px);
    }

    .vr-stat-label {
        margin: 0;
        color: var(--vr-muted);
        font-size: 13px;
        font-weight: 500;
    }

    .vr-stat-value {
        margin: 8px 0 0;
        color: var(--vr-text);
        font-size: 40px;
        line-height: 1;
        font-weight: 800;
    }

    .vr-panel-head {
        border-bottom: 1px solid var(--vr-border);
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .vr-panel-title {
        margin: 0;
        color: #0f172a;
        font-size: 20px;
        font-weight: 700;
    }

    .vr-panel-subtitle {
        margin: 4px 0 0;
        color: var(--vr-muted);
        font-size: 13px;
    }

    .vr-body {
        padding: 18px;
    }

    .vr-filter-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .vr-field label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 8px;
    }

    .vr-field .form-select {
        min-height: 46px;
        border-radius: 10px;
        border-color: #d5deeb;
        box-shadow: none;
    }

    .vr-filter-actions {
        display: flex;
        gap: 10px;
        align-items: end;
        flex-wrap: wrap;
    }

    .vr-rating-row {
        display: grid;
        grid-template-columns: 58px 1fr 44px;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    .vr-rating-label,
    .vr-rating-count {
        font-size: 13px;
        font-weight: 700;
        color: #334155;
    }

    .vr-rating-track {
        height: 10px;
        background: #e9eef5;
        border-radius: 999px;
        overflow: hidden;
    }

    .vr-rating-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--vr-primary), var(--vr-accent));
        border-radius: 999px;
    }

    .vr-review {
        padding: 18px;
        border: 1px solid var(--vr-border);
        border-radius: 14px;
        background: #fff;
        margin-bottom: 14px;
        transition: all .2s ease;
    }

    .vr-review:hover {
        border-color: #c9d8ec;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
    }

    .vr-review-head {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        align-items: flex-start;
        margin-bottom: 14px;
    }

    .vr-review-title {
        margin: 0 0 4px;
        font-size: 18px;
        font-weight: 700;
        color: #111827;
    }

    .vr-review-meta {
        margin: 0;
        color: #64748b;
        font-size: 14px;
    }

    .vr-review-comment {
        margin: 0;
        color: #334155;
        font-size: 15px;
        line-height: 1.75;
        background: #f8fbff;
        border: 1px solid #e5edf8;
        border-radius: 12px;
        padding: 14px 16px;
    }

    .vr-stars {
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }

    .vr-stars i {
        color: var(--vr-star);
        font-size: 14px;
    }

    .vr-score-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: #fff8e6;
        color: #92400e;
        font-size: 13px;
        font-weight: 800;
        border: 1px solid #fde68a;
        white-space: nowrap;
    }

    .vr-empty {
        text-align: center;
        padding: 38px 20px;
        color: #64748b;
    }

    .vr-empty i {
        font-size: 38px;
        color: #94a3b8;
        margin-bottom: 10px;
        display: inline-block;
    }

    .vr-pagination .pagination {
        justify-content: center;
    }

    .vr-pagination .page-link {
        border-radius: 10px;
        margin: 0 4px;
    }

    @media (max-width: 992px) {
        .vendor-ratings {
            max-width: 100%;
            padding: 8px 12px 24px;
        }

        .vr-title {
            font-size: 28px;
        }

        .vr-subtitle {
            font-size: 15px;
        }

        .vr-stat-value {
            font-size: 32px;
        }

        .vr-panel-title {
            font-size: 18px;
        }

        .vr-filter-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
@php
    $isAr = app()->getLocale() === 'ar';
@endphp
<main class="vendor-ratings">
    @include('flash::message')

    <nav class="vr-breadcrumb">
        <a href="{{ route('vendor/dashboard') }}">{{ $isAr ? 'Ø§Ù„Ø±Ø¦ÙŠØ³ÙŠØ©' : 'Home' }}</a>
        <i class="bi bi-chevron-{{ $isAr ? 'left' : 'right' }}"></i>
        <span class="active">{{ trans_or_fallback('', '') }}</span>
    </nav>

    <section class="vr-card vr-hero">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h3 class="vr-title">{{ trans_or_fallback('', '') }}</h3>
                <p class="vr-subtitle">
                    {{ $isAr ? 'ØªØ§Ø¨Ø¹ Ø§Ù†Ø·Ø¨Ø§Ø¹Ø§Øª Ø§Ù„Ø¹Ù…Ù„Ø§Ø¡ Ø¹Ù† Ù…Ù†ØªØ¬Ø§ØªÙƒØŒ Ø±Ø§Ù‚Ø¨ Ù…ØªÙˆØ³Ø· Ø§Ù„ØªÙ‚ÙŠÙŠÙ…Ø§ØªØŒ ÙˆØ±Ø§Ø¬Ø¹ Ø£ÙƒØ«Ø± Ø§Ù„Ù…Ù„Ø§Ø­Ø¸Ø§Øª ØªØ£Ø«ÙŠØ±Ù‹Ø§ ÙÙŠ ØªØ¬Ø±Ø¨Ø© Ø§Ù„Ø´Ø±Ø§Ø¡.' : 'Track customer feedback on your products, monitor rating averages, and review the comments that shape the buying experience.' }}
                </p>
            </div>
            <div class="vr-actions">
                <a href="{{ route('vendor/dashboard') }}" class="vr-btn-outline">
                    <i class="bi bi-grid-1x2-fill"></i>
                    {{ trans_or_fallback('', '') }}
                </a>
                <a href="{{ route('vendor/products') }}" class="vr-btn-primary">
                    <i class="bi bi-box-seam"></i>
                    {{ trans_or_fallback('', '') }}
                </a>
            </div>
        </div>
    </section>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
            <div class="vr-card vr-stat">
                <p class="vr-stat-label">{{ trans_or_fallback('', '') }}</p>
                <h4 class="vr-stat-value">{{ number_format((float) $averageRating, 1) }}</h4>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="vr-card vr-stat">
                <p class="vr-stat-label">{{ trans_or_fallback('', '') }}</p>
                <h4 class="vr-stat-value">{{ number_format((int) $totalRatings) }}</h4>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="vr-card vr-stat">
                <p class="vr-stat-label">{{ trans_or_fallback('', '') }}</p>
                <h4 class="vr-stat-value">{{ number_format(count($products)) }}</h4>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="vr-card mb-4">
                <div class="vr-panel-head">
                    <div>
                        <h5 class="vr-panel-title">{{ trans_or_fallback('', '') }}</h5>
                        <p class="vr-panel-subtitle">{{ $isAr ? 'ØªÙˆØ²ÙŠØ¹ Ø§Ù„Ù…Ø±Ø§Ø¬Ø¹Ø§Øª Ø­Ø³Ø¨ Ø¹Ø¯Ø¯ Ø§Ù„Ù†Ø¬ÙˆÙ….' : 'Distribution of reviews by star score.' }}</p>
                    </div>
                </div>
                <div class="vr-body">
                    @for ($i = 5; $i >= 1; $i--)
                        @php
                            $percentage = $totalRatings > 0 ? ($ratingBreakdown[$i] / $totalRatings) * 100 : 0;
                        @endphp
                        <div class="vr-rating-row">
                            <div class="vr-rating-label">{{ $i }} <i class="bi bi-star-fill" style="color:#fbbf24;"></i></div>
                            <div class="vr-rating-track">
                                <div class="vr-rating-fill" style="width: {{ $percentage }}%;"></div>
                            </div>
                            <div class="vr-rating-count">{{ $ratingBreakdown[$i] }}</div>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="vr-card">
                <div class="vr-panel-head">
                    <div>
                        <h5 class="vr-panel-title">{{ $isAr ? 'ØªØµÙÙŠØ© Ø§Ù„Ù…Ø±Ø§Ø¬Ø¹Ø§Øª' : 'Filter Reviews' }}</h5>
                        <p class="vr-panel-subtitle">{{ $isAr ? 'Ø§Ø¹Ø±Ø¶ ØªÙ‚ÙŠÙŠÙ…Ø§Øª Ù…Ù†ØªØ¬ Ù…Ø­Ø¯Ø¯ Ø£Ùˆ Ø¯Ø±Ø¬Ø© ØªÙ‚ÙŠÙŠÙ… Ù…Ø¹ÙŠÙ†Ø©.' : 'Focus on a specific product or score.' }}</p>
                    </div>
                </div>
                <div class="vr-body">
                    <form method="GET" action="{{ route('vendor/ratings') }}">
                        <div class="vr-filter-grid">
                            <div class="vr-field">
                                <label>{{ trans_or_fallback('', '') }}</label>
                                <select name="product_id" class="form-select">
                                    <option value="">{{ trans_or_fallback('', '') }}</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ (string) request('product_id') === (string) $product->id ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="vr-field">
                                <label>{{ trans_or_fallback('', '') }}</label>
                                <select name="rating" class="form-select">
                                    <option value="">{{ trans_or_fallback('', '') }}</option>
                                    @for ($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}" {{ (string) request('rating') === (string) $i ? 'selected' : '' }}>
                                            {{ $i }} / 5
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="vr-filter-actions">
                                <button type="submit" class="vr-btn-primary" style="border:0;">
                                    <i class="bi bi-funnel-fill"></i>
                                    {{ trans_or_fallback('', '') }}
                                </button>
                                <a href="{{ route('vendor/ratings') }}" class="vr-btn-outline">
                                    <i class="bi bi-arrow-clockwise"></i>
                                    {{ trans_or_fallback('', '') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="vr-card">
                <div class="vr-panel-head">
                    <div>
                        <h5 class="vr-panel-title">{{ $isAr ? 'Ù…Ø±Ø§Ø¬Ø¹Ø§Øª Ø§Ù„Ø¹Ù…Ù„Ø§Ø¡' : 'Customer Reviews' }}</h5>
                        <p class="vr-panel-subtitle">{{ $isAr ? 'Ù‚Ø§Ø¦Ù…Ø© Ù…Ø­Ø¯Ø«Ø© Ø¨ØªÙ‚ÙŠÙŠÙ…Ø§Øª Ø§Ù„Ù…Ù†ØªØ¬Ø§Øª ÙˆØªØ¹Ù„ÙŠÙ‚Ø§Øª Ø§Ù„Ø¹Ù…Ù„Ø§Ø¡.' : 'A fresh list of product ratings and customer comments.' }}</p>
                    </div>
                    <span class="vr-score-badge">
                        <i class="bi bi-chat-square-quote-fill"></i>
                        {{ number_format($ratings->total()) }} {{ trans_or_fallback('', '') }}
                    </span>
                </div>
                <div class="vr-body">
                    @forelse($ratings as $rating)
                        <article class="vr-review">
                            <div class="vr-review-head">
                                <div>
                                    <h6 class="vr-review-title">{{ $rating->forable?->name ?? 'Product' }}</h6>
                                    <p class="vr-review-meta">
                                        <strong>{{ $rating->user?->name ?? 'Anonymous' }}</strong>
                                        <span class="mx-1">â€¢</span>
                                        {{ $rating->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <span class="vr-score-badge">
                                    <span class="vr-stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="bi {{ $i <= (int) $rating->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                        @endfor
                                    </span>
                                    {{ $rating->rating }}/5
                                </span>
                            </div>

                            @if(!empty($rating->comment))
                                <p class="vr-review-comment">"{{ $rating->comment }}"</p>
                            @else
                                <p class="vr-review-comment">{{ $isAr ? 'Ù„Ø§ ØªÙˆØ¬Ø¯ Ù…Ù„Ø§Ø­Ø¸Ø§Øª Ù†ØµÙŠØ© Ù„Ù‡Ø°Ø§ Ø§Ù„ØªÙ‚ÙŠÙŠÙ….' : 'No written comment was left for this rating.' }}</p>
                            @endif
                        </article>
                    @empty
                        <div class="vr-empty">
                            <i class="bi bi-star"></i>
                            <div>{{ trans_or_fallback('', '') }}</div>
                        </div>
                    @endforelse

                    @if($ratings->hasPages())
                        <div class="vr-pagination mt-4">
                            {{ $ratings->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

