@extends('layouts.front.home')

@section('title')
    <title>{{ __('nav.my_offers') ?? 'My Offers' }} - Vendor | HemaPulse</title>
@endsection

@section('css')
<style>
    :root{
        --page-bg:#f5f6f8;
        --card-bg:#fff;
        --border:#ececec;
        --text:#111827;
        --muted:#6b7280;
        --shadow:0 6px 20px rgba(16,24,40,.06);
        --radius:10px;
        --primary:#0d6efd;
    }

    .offers-page{
        background: var(--page-bg);
        border: 1px solid rgba(0,0,0,.04);
        border-radius: 12px;
        padding: 18px;
    }

    .page-title{
        font-size: 14px;
        color: var(--muted);
        margin-bottom: 8px;
    }

    .page-subtitle{
        font-size: 13px;
        color: var(--muted);
        margin: 0 0 14px 0;
    }

    /* Filters (simple, like toolbar) */
    .filters-bar{
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 12px;
        box-shadow: var(--shadow);
        margin-bottom: 12px;
    }
    .filters-bar .form-control,
    .filters-bar .form-select{
        border-radius: 10px;
    }

    /* List Card like screenshot */
    .rq-card{
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 14px 16px;
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap: 14px;
        margin-bottom: 10px;
        transition: transform .12s ease, box-shadow .12s ease, border-color .12s ease;
        text-decoration:none;
        color: inherit;
    }
    .rq-card:hover{
        transform: translateY(-1px);
        box-shadow: 0 10px 26px rgba(16,24,40,.10);
        border-color: rgba(13,110,253,.22);
    }

    .rq-main{ min-width: 0; } /* allow text truncation */
    .rq-title-row{
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:10px;
        margin-bottom: 8px;
    }
    .rq-title{
        font-weight: 800;
        font-size: 13px;
        color: var(--text);
        margin:0;
    }

    .rq-meta{
        font-size: 12px;
        color: var(--muted);
        margin: 2px 0 0 0;
        line-height: 1.55;
    }

    /* Status pill like screenshot */
    .rq-status{
        display:inline-flex;
        align-items:center;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 800;
        border-radius: 6px;
        border: 1px solid transparent;
        white-space: nowrap;
        margin-inline-start: 10px;
    }
    .rq-status.pending{
        background:#f3f4f6;
        color:#6b7280;
        border-color:#e5e7eb;
    }
    .rq-status.accepted{
        background: rgba(34,197,94,.10);
        color:#166534;
        border-color: rgba(34,197,94,.18);
    }
    .rq-status.rejected{
        background: rgba(239,68,68,.10);
        color:#991b1b;
        border-color: rgba(239,68,68,.18);
    }

    .rq-arrow{
        flex: 0 0 auto;
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display:grid;
        place-items:center;
        border: 1px solid var(--border);
        background:#fff;
        color:#9ca3af;
    }
    .rq-card:hover .rq-arrow{ color: var(--primary); border-color: rgba(13,110,253,.22); }

    /* Pagination like screenshot (center pills) */
    .pagination-wrap .pagination{
        gap: 6px;
    }
    .pagination-wrap .page-link{
        border-radius: 8px !important;
        border: 1px solid var(--border);
        color: #374151;
        padding: 6px 10px;
        font-weight: 700;
        box-shadow: none;
    }
    .pagination-wrap .page-item.active .page-link{
        background: #0b5ed7;
        border-color: #0b5ed7;
        color: #fff;
    }

    /* Make action buttons look minimal (optional) */
    .rq-actions{
        display:flex;
        gap: 6px;
        flex-wrap: wrap;
        margin-top: 8px;
    }
    .rq-actions .btn{
        border-radius: 10px;
        font-weight: 700;
        font-size: 12px;
        padding: 6px 10px;
    }

    @media (max-width: 576px){
        .rq-card{ padding: 12px; }
        .rq-arrow{ width: 32px; height: 32px; }
    }
</style>
@endsection

@section('content')
<main class="container my-4" style="max-width: 95%; margin-top: 8% !important;">
    @include('flash::message')

    <div class="offers-page">

        {{-- Title like screenshot --}}
        <div class="page-title">Requests</div>

        {{-- Breadcrumb (keep it small) --}}
        <nav class="mb-2" style="font-size:12px;">
            <a href="{{ route('vendor/dashboard') }}" class="text-decoration-none text-muted">{{ __('nav.dashboard') ?? 'Dashboard' }}</a>
            <span class="text-muted mx-1">/</span>
            <a href="{{ route('vendor/orders') }}" class="text-decoration-none text-muted">{{ __('nav.view_orders') ?? 'Orders' }}</a>
            <span class="text-muted mx-1">/</span>
            <span class="text-primary fw-bold">{{ __('nav.my_offers') ?? 'My Offers' }}</span>
        </nav>

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="m-0 fw-bold">{{ __('nav.my_offers') ?? 'My Offers' }}</h5>
            <a href="{{ route('vendor/orders') }}" class="btn btn-outline-primary btn-sm" style="border-radius:10px;font-weight:800;">
                <i class="bi bi-arrow-left"></i> {{ __('nav.view_orders') ?? 'Orders' }}
            </a>
        </div>
        <p class="page-subtitle">{{ __('nav.dashboard_description') ?? 'Manage your business and view analytics' }}</p>

        {{-- Filters (simple toolbar) --}}
        <div class="filters-bar">
            <form method="GET" action="{{ route('vendor/orders/my-offers') }}" class="row g-2 align-items-center">
                <div class="col-12 col-md-4">
                    <select name="status" class="form-select">
                        <option value="">{{ __('nav.all_statuses') ?? 'All statuses' }}</option>
                        <option value="pending"  {{ request('status') === 'pending' ? 'selected' : '' }}>{{ __('nav.pending') ?? 'Pending' }}</option>
                        <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>{{ __('nav.accepted') ?? 'Accepted' }}</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>{{ __('nav.rejected') ?? 'Rejected' }}</option>
                    </select>
                </div>
                <div class="col-12 col-md-5">
                    <input type="text" name="search" class="form-control"
                           placeholder="{{ __('nav.search_order_id') ?? 'Search by order #' }}"
                           value="{{ request('search') }}">
                </div>
                <div class="col-12 col-md-3">
                    <button type="submit" class="btn btn-primary w-100" style="border-radius:10px;font-weight:800;">
                        <i class="bi bi-search"></i> {{ __('nav.search') ?? 'Search' }}
                    </button>
                </div>
            </form>
        </div>

        {{-- List --}}
        @if($offers->count() > 0)
            @foreach($offers as $offer)
                @php
                    $status = strtolower($offer->status_label ?? 'pending');
                    $statusLabel = $status === 'pending'
                        ? (__('nav.pending') ?? 'Pending')
                        : ($status === 'accepted'
                            ? (__('nav.accepted') ?? 'Accepted')
                            : (__('nav.rejected') ?? 'Rejected'));

                    $typeTitle = match((int)($offer->order->order_type ?? 0)) {
                        1 => 'Purchase Order',
                        3 => 'Maintenance Request',
                        default => 'Quotation Request',
                    };
                @endphp

                {{-- Whole card clickable to details like screenshot --}}
                <a href="{{ route('vendor/orders/show', $offer->order_id) }}" class="rq-card">
                    <div class="rq-main">
                        <div class="rq-title-row">
                            <p class="rq-title m-0">{{ $typeTitle }}</p>
                            <span class="rq-status {{ $status }}">{{ $statusLabel }}</span>
                        </div>

                        <p class="rq-meta">
                            <strong>{{ __('nav.offer') ?? 'Offer' }} #{{ $offer->id }}</strong>
                            <span class="text-muted"> — {{ __('nav.order') ?? 'Order' }} #{{ $offer->order_id }}</span>
                        </p>

                        <p class="rq-meta mb-0">
                            {{ __('nav.client') ?? 'Client' }}: {{ $offer->order->user->name ?? 'N/A' }}<br>
                            {{ __('nav.price') ?? 'Price' }}: {{ number_format((float)($offer->cost ?? 0), 2) }} {{ __('nav.sar') ?? 'SAR' }}<br>
                            {{ __('nav.delivery_days') ?? 'Delivery days' }}: {{ $offer->delivery_time ?? 'N/A' }}
                            @if($offer->warranty)
                                — {{ __('nav.warranty') ?? 'Warranty' }}: {{ $offer->warranty }}
                            @endif
                            <br>
                            {{ __('nav.date') ?? 'Date' }}: {{ $offer->created_at->format('M d, Y') }}
                        </p>

                        {{-- Optional mini actions (small, not noisy) --}}
                        <div class="rq-actions">
                            <span class="btn btn-outline-secondary btn-sm disabled" style="opacity:.85;">
                                <i class="bi bi-clock"></i> {{ $offer->created_at->format('d/m/Y H:i') }}
                            </span>

                            @if(($offer->status_label ?? 'pending') === 'pending')
                                <a href="{{ route('vendor/orders/offer-edit', $offer->id) }}" class="btn btn-outline-warning btn-sm" onclick="event.stopPropagation();">
                                    <i class="bi bi-pencil"></i> {{ __('nav.edit') ?? 'Edit' }}
                                </a>
                                <form action="{{ route('vendor/orders/offer-delete', $offer->id) }}"
                                      method="POST"
                                      onsubmit="event.stopPropagation(); return confirm('{{ __('nav.confirm_delete') ?? 'Delete this offer?' }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i> {{ __('nav.delete') ?? 'Delete' }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="rq-arrow" aria-hidden="true">
                        <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
                    </div>
                </a>
            @endforeach

            {{-- Pagination centered --}}
            <div class="d-flex justify-content-center mt-3 pagination-wrap">
                {{ $offers->links() }}
            </div>
        @else
            <div class="v-card p-4 text-center" style="background:#fff;border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow);">
                <div class="text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    {{ __('nav.no_offers_yet') ?? 'You have not submitted any offers yet.' }}
                </div>
                <div class="mt-2">
                    <a href="{{ route('vendor/orders') }}" class="text-decoration-none fw-bold">
                        {{ __('nav.start_offer') ?? 'Start submitting an offer' }}
                    </a>
                </div>
            </div>
        @endif

    </div>
</main>
@endsection
