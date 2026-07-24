@extends('layouts.front.home')

@section('title')
    <title>{{ __('nav.customer_dashboard_title') }}</title>
@endsection

@section('css')
<style>
    .vendor-dashboard {
        --vd-bg: #f5f6f8;
        --vd-card: #ffffff;
        --vd-border: #e7eaf0;
        --vd-title: #0f2f7f;
        --vd-text: #1f2937;
        --vd-muted: #6b7280;
        --vd-primary: #0f4bbf;
        --vd-accent: #0ec6a0;
        max-width: 95%;
        margin: 12px auto 0;
        background: var(--vd-bg);
        padding: 8px 0 24px;
        font-family: "Poppins", "Tajawal", system-ui, -apple-system, "Segoe UI", Arial, sans-serif;
    }

    .vendor-dashboard * {
        font-family: inherit;
    }

    .vd-card {
        background: var(--vd-card);
        border: 1px solid var(--vd-border);
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.04);
    }

    .vd-hero {
        padding: 22px;
        margin-bottom: 16px;
    }

    .vd-breadcrumb {
        font-size: 13px;
        margin-bottom: 12px;
    }
    .vd-breadcrumb a {
        text-decoration: none;
        color: #6b7280;
    }
    .vd-breadcrumb .active {
        color: #0f4bbf;
        font-weight: 700;
    }

    .vd-title {
        margin: 0 0 6px;
        color: var(--vd-title);
        font-size: 34px;
        line-height: 1.08;
        font-weight: 800;
        letter-spacing: -0.01em;
    }

    .vd-subtitle {
        margin: 0;
        color: #475569;
        font-size: 16px;
        line-height: 1.55;
        max-width: 760px;
    }

    .vd-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .vd-btn-primary {
        border: 0;
        border-radius: 10px;
        color: #fff;
        font-weight: 700;
        padding: 10px 16px;
        text-decoration: none;
        background: linear-gradient(90deg, var(--vd-primary) 0%, var(--vd-accent) 100%);
    }

    .vd-btn-outline {
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        color: #1e3a8a;
        font-weight: 700;
        padding: 10px 16px;
        text-decoration: none;
        background: #fff;
    }

    .vd-btn-primary:hover,
    .vd-btn-outline:hover {
        opacity: .95;
        color: inherit;
    }

    .vd-stat {
        padding: 16px 18px;
        height: 100%;
        transition: all .2s ease;
    }
    a:hover .vd-stat {
        border-color: #93c5fd;
        box-shadow: 0 4px 12px rgba(15, 75, 191, .08);
        transform: translateY(-1px);
    }

    .vd-stat-label {
        margin: 0;
        color: var(--vd-muted);
        font-size: 13px;
        font-weight: 500;
    }

    .vd-stat-value {
        margin: 8px 0 0;
        color: var(--vd-text);
        font-size: 40px;
        line-height: 1;
        font-weight: 800;
    }

    .vd-panel-head {
        border-bottom: 1px solid var(--vd-border);
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .vd-panel-title {
        margin: 0;
        color: #0f172a;
        font-size: 20px;
        font-weight: 700;
        line-height: 1.1;
    }

    .vd-link {
        text-decoration: none;
        font-weight: 700;
        color: #2563eb;
        font-size: 15px;
    }

    .vd-list {
        padding: 8px 18px 14px;
    }

    .vd-item {
        padding: 14px 0;
        border-bottom: 1px solid var(--vd-border);
        display: block;
    }

    .vd-item:last-child {
        border-bottom: 0;
    }

    a:hover .vd-item {
        opacity: .8;
    }

    .vd-item-title {
        margin: 0 0 4px;
        color: #111827;
        font-size: 17px;
        font-weight: 700;
    }

    .vd-item-sub {
        margin: 0;
        color: #475569;
        font-size: 15px;
        line-height: 1.5;
        word-break: break-word;
    }

    .vd-chip {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 700;
        line-height: 1;
    }

    .vd-chip-paid { background: #dcfce7; color: #166534; }
    .vd-chip-pending { background: #ffedd5; color: #9a3412; }
    .vd-chip-confirmed { background: #dbefff; color: #2285e8; }
    .vd-chip-processing { background: #ffefda; color: #e4972d; }
    .vd-chip-completed { background: #dff0e3; color: #4fa464; }
    .vd-chip-scheduled { background: #eef0f4; color: #666d79; }
    .vd-chip-cancelled { background: #ffe1df; color: #ef5753; }
    .vd-chip-rejected { background: #ffe1df; color: #ef5753; }

    .vd-quick {
        padding: 14px 18px 18px;
        display: grid;
        gap: 10px;
    }

    .vd-quick a {
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 12px 14px;
        text-decoration: none;
        color: #1e293b;
        font-weight: 700;
        font-size: 15px;
        background: #fff;
    }

    .vd-quick a:hover {
        border-color: #93c5fd;
        color: #1d4ed8;
    }

    .vd-empty {
        color: #64748b;
        font-size: 14px;
        padding: 12px 0;
    }

    @media (max-width: 992px) {
        .vendor-dashboard { max-width: 100%; padding: 8px 12px 24px; }
        .vd-title { font-size: 28px; }
        .vd-subtitle { font-size: 15px; }
        .vd-stat-value { font-size: 32px; }
        .vd-panel-title { font-size: 18px; }
        .vd-item-title { font-size: 16px; }
        .vd-item-sub { font-size: 14px; }
    }
</style>
@endsection

@section('content')
@php
    $isAr = app()->getLocale() === 'ar';
@endphp
<main class="vendor-dashboard">
    @include('flash::message')

    <nav class="vd-breadcrumb">
        <a href="{{ route('user/dashboard') }}">{{ __('nav.home') }}</a>
        <i class="bi bi-chevron-{{ $isAr ? 'left' : 'right' }}"></i>
        <span class="active">{{ __('nav.dashboard') }}</span>
    </nav>

    <div class="vd-card vd-hero">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h3 class="vd-title">{{ __('nav.welcome_back') }}</h3>
                <p class="vd-subtitle">{{ __('nav.dashboard_track_desc') }}</p>
            </div>
            <div class="vd-actions">
                <a href="{{ route('products') }}" class="vd-btn-primary">
                    <i class="bi bi-grid-3x3-gap-fill me-1"></i>
                    {{ __('products.browse_products') }}
                </a>
                <a href="{{ route('user/myorders', 'all') }}" class="vd-btn-outline">
                    <i class="bi bi-bag-check me-1"></i>
                    {{ __('nav.orders') }}
                </a>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md">
            <a href="{{ route('user/myorders', 'all') }}" class="text-decoration-none" style="color:inherit;">
                <div class="vd-card vd-stat">
                    <p class="vd-stat-label">{{ __('nav.orders') }}</p>
                    <h4 class="vd-stat-value">{{ $counts['orders'] }}</h4>
                </div>
            </a>
        </div>
        <div class="col-6 col-md">
            <a href="{{ route('user/myorders', 'all') }}?payment_status=1" class="text-decoration-none" style="color:inherit;">
                <div class="vd-card vd-stat">
                    <p class="vd-stat-label">{{ __('nav.paid') }}</p>
                    <h4 class="vd-stat-value">{{ $counts['paid_invoices'] }}</h4>
                </div>
            </a>
        </div>
        <div class="col-6 col-md">
            <a href="{{ route('user/myorders', 'all') }}?status=processing" class="text-decoration-none" style="color:inherit;">
                <div class="vd-card vd-stat">
                    <p class="vd-stat-label">{{ __('nav.processing') }}</p>
                    <h4 class="vd-stat-value">{{ $counts['processing_orders'] }}</h4>
                </div>
            </a>
        </div>
        <div class="col-6 col-md">
            <a href="{{ route('user/favorites') }}" class="text-decoration-none" style="color:inherit;">
                <div class="vd-card vd-stat">
                    <p class="vd-stat-label">{{ __('products.favorites') }}</p>
                    <h4 class="vd-stat-value">{{ $counts['favorites'] }}</h4>
                </div>
            </a>
        </div>
        <div class="col-6 col-md">
            <a href="{{ route('user/myorders', 'scheduled-orders') }}?status=scheduled" class="text-decoration-none" style="color:inherit;">
                <div class="vd-card vd-stat">
                    <p class="vd-stat-label">{{ __('nav.tracking') }}</p>
                    <h4 class="vd-stat-value">{{ $counts['tracking_orders'] ?? 0 }}</h4>
                </div>
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="vd-card h-100">
                <div class="vd-panel-head">
                    <h5 class="vd-panel-title">{{ __('nav.recent_orders') }}</h5>
                    <a class="vd-link" href="{{ route('user/myorders', 'all') }}">{{ __('nav.view_all') }}</a>
                </div>
                <div class="vd-list">
                    @forelse($orders as $order)
                        @php
                            $statusState = $order->front_status_state ?? ['text' => ($isAr ? 'قيد الانتظار' : 'Pending'), 'class' => 'vd-chip-pending'];
                            $statusChipClass = $statusState['class'] ?? 'vd-chip-pending';
                            if (str_starts_with($statusChipClass, 'chip-')) {
                                $statusChipClass = 'vd-chip-' . substr($statusChipClass, 5);
                            }
                        @endphp
                        <a href="{{ route('user/get/order', $order->id) }}" class="text-decoration-none" style="color:inherit;">
                            <div class="vd-item d-flex justify-content-between align-items-start gap-3">
                                <div>
                                    <p class="vd-item-title">{{ __('nav.order') }} #{{ $order->id }}</p>
                                    <p class="vd-item-sub">{{ $order->provider->name ?? '-' }}</p>
                                </div>
                                <div class="text-end">
                                    <span class="vd-chip {{ $statusChipClass }}">{{ $statusState['text'] ?? ($isAr ? 'قيد الانتظار' : 'Pending') }}</span>
                                    <div class="small text-muted mt-2">{{ number_format((float)($order->total_cost ?? 0), 2) }} SAR</div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="vd-empty">{{ __('nav.no_orders') }}</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="vd-card mb-4">
                <div class="vd-panel-head">
                    <h5 class="vd-panel-title">{{ __('nav.notifications') }}</h5>
                    <a class="vd-link" href="{{ route('user/notifications', [0, PAGINATION_COUNT]) }}">{{ __('nav.view_all') }}</a>
                </div>
                <div class="vd-list">
                    @forelse($recentNotifications as $n)
                        <a href="{{ route('user/notifications', [0, PAGINATION_COUNT]) }}" class="text-decoration-none" style="color:inherit;">
                            <div class="vd-item">
                                <p class="vd-item-title">{{ $n->title ?? __('nav.alert') }}</p>
                                <p class="vd-item-sub">{{ \Illuminate\Support\Str::limit($n->message ?? $n->content, 60) }}</p>
                            </div>
                        </a>
                    @empty
                        <div class="vd-empty">{{ __('nav.no_notifications') }}</div>
                    @endforelse
                </div>
            </div>

            @include('front.partials.order-workflow-hint', ['role' => 'customer'])

            <div class="vd-card">
                <div class="vd-panel-head">
                    <h5 class="vd-panel-title">{{ __('nav.shortcuts') }}</h5>
                </div>
                <div class="vd-quick">
                    <a href="{{ route('products') }}">{{ __('nav.products') }}</a>
                    <a href="{{ route('providers') }}">{{ __('nav.service_providers') }}</a>
                    <a href="{{ route('categories') }}">{{ __('nav.categories') }}</a>
                    <a href="{{ route('user/favorites') }}">{{ __('products.favorites') }}</a>
                    <a href="{{ route('contactUs') }}">{{ __('nav.contact_us') }}</a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
    $(function () {
        $('#nav-dashboard').addClass('active');
    });
</script>
@endsection
