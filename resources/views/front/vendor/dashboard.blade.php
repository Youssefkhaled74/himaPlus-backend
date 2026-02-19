@extends('layouts.front.home')

@section('title')
    <title>{{ __('nav.dashboard') ?? 'Dashboard' }} - Vendor | HemaPulse</title>
@endsection

@section('css')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    :root {
        --page-bg: #edf2fb;
        --card-bg: #ffffff;
        --border-soft: rgba(15, 23, 42, .08);
        --text-main: #0b2545;
        --text-muted: #64748b;
        --shadow-soft: 0 18px 50px rgba(15, 23, 42, .12);
        --shadow-sm: 0 8px 26px rgba(15, 23, 42, .08);
        --radius-lg: 28px;
        --radius-md: 18px;
        --accent-blue: linear-gradient(135deg, #2d8bfd 0%, #1d4ed8 100%);
        --accent-pink: linear-gradient(135deg, #ec4899 0%, #a855f7 100%);
        --accent-teal: linear-gradient(135deg, #0bc5ea 0%, #0ea5e9 100%);
        --accent-green: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);
        --accent-gold: linear-gradient(135deg, #f97316 0%, #f59e0b 100%);
    }

    body, .v-page, .v-page * {
        font-family: "Poppins", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
    }

    .dashboard-layout {
        background: linear-gradient(180deg, #f8fbff 0%, #eef5ff 70%, #eef2fb 100%);
        padding: 18px 20px 32px;
        min-height: 100vh;
    }

    .v-page {
        background: var(--card-bg);
        border-radius: var(--radius-lg);
        padding: 22px;
        border: none;
        box-shadow: var(--shadow-soft);
        max-width: 1320px;
        margin: 0 auto;
    }

    .v-head {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 18px;
    }

    .v-title {
        margin: 0;
        font-weight: 700;
        font-size: 28px;
        color: var(--text-main);
        letter-spacing: -0.03em;
    }

    .v-sub {
        margin: 6px 0 0;
        color: var(--text-muted);
        font-size: 13px;
    }

    .v-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        border: 1px solid rgba(13, 110, 253, .25);
        background: rgba(13, 110, 253, .08);
        color: #0b49c6;
        font-weight: 600;
    }

    .stats-grid {
        margin-bottom: 14px;
    }

    .stat-card {
        position: relative;
        border-radius: var(--radius-md);
        padding: 14px;
        color: #fff;
        height: 116px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(15, 23, 42, .10);
        transition: transform .15s ease, box-shadow .15s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-soft);
    }

    .stat-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
    }

    .stat-ico {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        background: rgba(255, 255, 255, .15);
        border: 1px solid rgba(255, 255, 255, .25);
    }

    .stat-ico i {
        font-size: 15px;
    }

    .stat-value {
        font-size: 24px;
        font-weight: 700;
        margin: 6px 0 2px;
    }

    .stat-label {
        font-size: 11px;
        opacity: .9;
    }

    .stat-card.orders { background: var(--accent-blue); }
    .stat-card.offers { background: var(--accent-pink); }
    .stat-card.products { background: var(--accent-teal); }
    .stat-card.rating { background: var(--accent-green); }
    .stat-card.scheduled { background: var(--accent-gold); }

    .v-card {
        border-radius: var(--radius-md);
        overflow: hidden;
        border: none;
        box-shadow: var(--shadow-sm);
        background: #fff;
    }

    .v-card-head {
        padding: 13px 16px;
        border-bottom: 1px solid rgba(0, 0, 0, .06);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .v-card-head h5 {
        margin: 0;
        font-weight: 700;
        color: var(--text-main);
        font-size: 15px;
    }

    .action-tile {
        display: flex;
        gap: 10px;
        padding: 12px;
        align-items: flex-start;
        border: 1px solid rgba(15, 23, 42, .08);
        background: #fdfdff;
        border-radius: 12px;
        transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
    }

    .action-tile:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
        border-color: rgba(13, 110, 253, .35);
    }

    .action-ico {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        background: rgba(13, 110, 253, .12);
        border: 1px solid rgba(13, 110, 253, .20);
        color: #0d6efd;
    }

    .action-title {
        margin: 2px 0 0;
        font-weight: 600;
        font-size: 13px;
    }

    .action-desc {
        margin: 5px 0 0;
        font-size: 11px;
        color: var(--text-muted);
    }

    /* Lists */
    .recent-item{
        padding: 10px 12px;
        border-top: 1px solid rgba(0,0,0,.06);
    }
    .recent-item:first-child{ border-top: 0; }
    .status-badge{
        display:inline-flex;
        align-items:center;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
        border: 1px solid transparent;
        white-space: nowrap;
    }
    .status-pending{ background: rgba(245,158,11,.12); color:#92400e; border-color: rgba(245,158,11,.20); }
    .status-accepted{ background: rgba(34,197,94,.12); color:#166534; border-color: rgba(34,197,94,.20); }
    .status-rejected{ background: rgba(239,68,68,.12); color:#991b1b; border-color: rgba(239,68,68,.20); }

    .v-cta{
        border-radius: 12px;
        border: 1px solid rgba(13,110,253,.18);
        background: linear-gradient(135deg, rgba(13,110,253,.10), rgba(236,72,153,.06));
        padding: 10px 12px;
    }

    @media (max-width:576px){
        .v-page{ padding: 16px; }
        .stat-value{ font-size: 22px; }
        .v-title{ font-size: 22px; }
    }
</style>
@endsection

@section('content')
<main class="dashboard-layout">
    @include('flash::message')

    <div class="v-page">

        <!-- Header -->
        <div class="v-head">
            <div>
                <h2 class="v-title">{{ __('nav.welcome') ?? 'Welcome' }}, {{ auth()->user()->name }}</h2>
                <p class="v-sub">{{ __('nav.dashboard_description') ?? 'Manage your business and view analytics' }}</p>
            </div>
            <div class="v-pill">
                <i class="bi bi-shield-check"></i>
                <span>{{ __('nav.vendor_portal') ?? 'Vendor Portal' }}</span>
            </div>
        </div>

        <!-- Stats -->
        <div class="row g-2 mb-3 stats-grid">
            <div class="col-6 col-md-4 col-xl">
                <div class="stat-card orders">
                    <div class="stat-top">
                        <div>
                            <div class="stat-value">{{ $ordersCount }}</div>
                            <div class="stat-label">{{ __('nav.orders_received') ?? 'Orders Received' }}</div>
                        </div>
                        <div class="stat-ico"><i class="bi bi-bag"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl">
                <div class="stat-card offers">
                    <div class="stat-top">
                        <div>
                            <div class="stat-value">{{ $offersCount }}</div>
                            <div class="stat-label">{{ __('nav.offers_made') ?? 'Offers Made' }}</div>
                        </div>
                        <div class="stat-ico"><i class="bi bi-chat-dots"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl">
                <div class="stat-card products">
                    <div class="stat-top">
                        <div>
                            <div class="stat-value">{{ $productsCount }}</div>
                            <div class="stat-label">{{ __('nav.active_products') ?? 'Active Products' }}</div>
                        </div>
                        <div class="stat-ico"><i class="bi bi-box"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl">
                <div class="stat-card rating">
                    <div class="stat-top">
                        <div>
                            <div class="stat-value">{{ number_format($avgRating, 1) }}</div>
                            <div class="stat-label">{{ __('nav.average_rating') ?? 'Average Rating' }} ({{ $ratingCount }})</div>
                        </div>
                        <div class="stat-ico"><i class="bi bi-star-fill"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl">
                <div class="stat-card scheduled">
                    <div class="stat-top">
                        <div>
                            <div class="stat-value">{{ $scheduledOrdersCount ?? 0 }}</div>
                            <div class="stat-label">{{ __('nav.scheduled_orders') ?? 'Scheduled Orders' }}</div>
                        </div>
                        <div class="stat-ico"><i class="bi bi-calendar-check"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions (ONE place فقط) -->
        <div class="v-card mb-3">
            <div class="v-card-head">
                <h5>{{ __('nav.quick_actions') ?? 'Quick Actions' }}</h5>
                <span class="text-muted small">{{ __('nav.shortcuts') ?? 'Shortcuts' }}</span>
            </div>
            <div class="p-3">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="{{ route('vendor/products/create') }}" class="action-tile">
                            <div class="action-ico"><i class="bi bi-plus-lg"></i></div>
                            <div>
                                <p class="action-title">{{ __('nav.add_product') ?? 'Add Product' }}</p>
                                <p class="action-desc">{{ __('nav.add_product_desc') ?? 'Create a new listing in seconds' }}</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="{{ route('vendor/products') }}" class="action-tile">
                            <div class="action-ico" style="background:rgba(2,132,199,.08);color:#0284c7;border-color:rgba(2,132,199,.16)">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <div>
                                <p class="action-title">{{ __('nav.view_products') ?? 'View Products' }}</p>
                                <p class="action-desc">{{ __('nav.view_products_desc') ?? 'Edit price, stock, and details' }}</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="{{ route('vendor/orders') }}" class="action-tile">
                            <div class="action-ico" style="background:rgba(245,158,11,.10);color:#92400e;border-color:rgba(245,158,11,.18)">
                                <i class="bi bi-receipt"></i>
                            </div>
                            <div>
                                <p class="action-title">{{ __('nav.view_orders') ?? 'View Orders' }}</p>
                                <p class="action-desc">{{ __('nav.view_orders_desc') ?? 'Track new requests & deliveries' }}</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="{{ route('vendor/orders', ['tab' => 'scheduled']) }}" class="action-tile">
                            <div class="action-ico" style="background:rgba(251,191,36,.10);color:#92400e;border-color:rgba(251,191,36,.18)">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <div>
                                <p class="action-title">{{ __('nav.scheduled_orders') ?? 'Scheduled Orders' }}</p>
                                <p class="action-desc">{{ __('nav.scheduled_orders_desc') ?? 'Manage recurring deliveries' }}</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="{{ route('vendor/orders/my-offers') }}" class="action-tile">
                            <div class="action-ico" style="background:rgba(124,58,237,.10);color:#7c3aed;border-color:rgba(124,58,237,.18)">
                                <i class="bi bi-chat-quote"></i>
                            </div>
                            <div>
                                <p class="action-title">{{ __('nav.view_offers') ?? 'View Offers' }}</p>
                                <p class="action-desc">{{ __('nav.view_offers_desc') ?? 'Manage pending and active offers' }}</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="{{ route('vendor/ratings') }}" class="action-tile">
                            <div class="action-ico" style="background:rgba(34,197,94,.10);color:#166534;border-color:rgba(34,197,94,.18)">
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <div>
                                <p class="action-title">{{ __('nav.ratings') ?? 'Ratings' }}</p>
                                <p class="action-desc">{{ __('nav.ratings_desc') ?? 'Review customer feedback' }}</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="{{ route('vendor/profile') }}" class="action-tile">
                            <div class="action-ico" style="background:rgba(17,24,39,.06);color:#111827;border-color:rgba(17,24,39,.12)">
                                <i class="bi bi-person-circle"></i>
                            </div>
                            <div>
                                <p class="action-title">{{ __('profile.profile') ?? 'Profile' }}</p>
                                <p class="action-desc">{{ __('nav.profile_desc') ?? 'Update info to build trust' }}</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="{{ route('vendor/notifications') }}" class="action-tile">
                            <div class="action-ico"><i class="bi bi-bell-fill"></i></div>
                            <div>
                                <p class="action-title">
                                    {{ __('nav.notifications') ?? 'Notifications' }}
                                    @if($unreadNotificationsCount > 0)
                                        <span class="badge bg-danger ms-2" style="font-size:10px;">{{ $unreadNotificationsCount }}</span>
                                    @endif
                                </p>
                                <p class="action-desc">{{ __('nav.notifications_desc') ?? 'Stay on top of updates' }}</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="{{ route('vendor/analytics') }}" class="action-tile">
                            <div class="action-ico" style="background:rgba(236,72,153,.08);color:#ec4899;border-color:rgba(236,72,153,.16)">
                                <i class="bi bi-graph-up"></i>
                            </div>
                            <div>
                                <p class="action-title">{{ __('nav.analytics') ?? 'Analytics' }}</p>
                                <p class="action-desc">{{ __('nav.analytics_desc') ?? 'Performance and trends' }}</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent -->
        <div class="row g-3 mb-3">
            <div class="col-12 col-lg-6">
                <div class="v-card">
                    <div class="v-card-head">
                        <h5>{{ __('nav.recent_orders') ?? 'Recent Orders' }}</h5>
                        <a href="{{ route('vendor/orders') }}" class="small text-primary fw-bold text-decoration-none">
                            {{ __('nav.view_all') ?? 'View All' }} <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </div>
                    <div class="p-0">
                        @forelse($recentOrders as $order)
                            <div class="recent-item">
                                <div class="d-flex justify-content-between align-items-start gap-2">
                                    <div>
                                        <strong>{{ __('nav.order') ?? 'Order' }} #{{ $order->id }}</strong>
                                        <div class="small text-muted mt-1">
                                            <i class="bi bi-person me-1"></i>{{ $order->user->name ?? __('nav.unknown') ?? 'Unknown' }}
                                        </div>
                                    </div>
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>{{ $order->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        @empty
                            <div class="recent-item text-center text-muted py-4">
                                <i class="bi bi-inbox me-1"></i> {{ __('nav.no_orders') ?? 'No orders yet' }}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="v-card">
                    <div class="v-card-head">
                        <h5>{{ __('nav.pending_offers') ?? 'Pending Offers' }}</h5>
                        <a href="{{ route('vendor/orders/my-offers') }}" class="small text-primary fw-bold text-decoration-none">
                            {{ __('nav.view_all') ?? 'View All' }} <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </div>
                    <div class="p-0">
                        @forelse($pendingOffers as $offer)
                            <div class="recent-item">
                                <div class="d-flex justify-content-between align-items-start gap-2">
                                    <div>
                                        <strong>{{ __('nav.offer') ?? 'Offer' }} #{{ $offer->id }}</strong>
                                        <div class="small text-muted mt-1">
                                            <i class="bi bi-tag me-1"></i>
                                            @if((int)($offer->order->order_type ?? 0) === 1)
                                                {{ __('Purchase Order') ?? 'Purchase Order' }}
                                            @elseif((int)($offer->order->order_type ?? 0) === 3)
                                                {{ __('Maintenance Request') ?? 'Maintenance Request' }}
                                            @else
                                                {{ __('Quotation Request') ?? 'Quotation Request' }}
                                            @endif
                                        </div>
                                    </div>
                                    @php
                                        $offerStatus = (string) $offer->status;
                                        $offerStatusLabel = ($offerStatus === '2' || strtolower($offerStatus) === 'accepted')
                                            ? 'accepted'
                                            : (($offerStatus === '3' || strtolower($offerStatus) === 'rejected') ? 'rejected' : 'pending');
                                    @endphp
                                    <span class="status-badge status-{{ $offerStatusLabel }}">{{ ucfirst($offerStatusLabel) }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="recent-item text-center text-muted py-4">
                                <i class="bi bi-check2-circle me-1"></i> {{ __('nav.no_pending_offers') ?? 'No pending offers' }}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Scheduled Orders -->
        <div class="row g-3 mb-3">
            <div class="col-12">
                <div class="v-card">
                    <div class="v-card-head">
                        <h5>{{ __('nav.recent_scheduled_orders') ?? 'Recent Scheduled Orders' }}</h5>
                        <a href="{{ route('vendor/orders', ['tab' => 'scheduled']) }}" class="small text-primary fw-bold text-decoration-none">
                            {{ __('nav.view_all') ?? 'View All' }} <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </div>
                    <div class="p-0">
                        @forelse($recentScheduledOrders ?? [] as $order)
                            <div class="recent-item">
                                <div class="d-flex justify-content-between align-items-start gap-2">
                                    <div class="flex-grow-1">
                                        <strong>{{ __('Scheduled Order') ?? 'Scheduled Order' }} #{{ $order->id }}</strong>
                                        <div class="small text-muted mt-1">
                                            <i class="bi bi-calendar me-1"></i>
                                            @if($order->schedule_start_date)
                                                {{ \Carbon\Carbon::parse($order->schedule_start_date)->format('M d, Y') }}
                                            @endif
                                            @if($order->frequency)
                                                - {{ $order->frequency }}
                                            @endif
                                        </div>
                                    </div>
                                    @php $colors = $order->scheduled_status_color; @endphp
                                    <span style="display:inline-flex;align-items:center;padding:4px 10px;font-size:11px;font-weight:800;border-radius:6px;background:{{ $colors['bg'] }};color:{{ $colors['text'] }};border:1px solid {{ $colors['border'] }};">
                                        {{ __('nav.' . strtolower($order->scheduled_status)) ?? ucfirst($order->scheduled_status) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="recent-item text-center text-muted py-4">
                                <i class="bi bi-calendar-x me-1"></i> {{ __('nav.no_scheduled_orders') ?? 'No scheduled orders yet' }}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Notifications -->
        <div class="row g-3 mb-3">
            <div class="col-12">
                <div class="v-card">
                    <div class="v-card-head">
                        <h5>{{ __('nav.recent_notifications') ?? 'Recent Notifications' }}</h5>
                        <a href="{{ route('vendor/notifications') }}" class="small text-primary fw-bold text-decoration-none">
                            {{ __('nav.view_all') ?? 'View All' }} <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </div>
                    <div class="p-0">
                        @forelse($recentNotifications ?? [] as $notification)
                            <div class="recent-item">
                                <div class="d-flex justify-content-between align-items-start gap-2">
                                    <div class="flex-grow-1">
                                        <strong>{{ $notification->title ?? __('nav.notification') ?? 'Notification' }}</strong>
                                        @if(is_null($notification->read_at))
                                            <span class="badge bg-warning text-dark ms-2" style="font-size:10px;">{{ __('nav.new') ?? 'New' }}</span>
                                        @endif
                                        <div class="small text-muted mt-1">
                                            {{ Str::limit($notification->message ?? $notification->content ?? '', 60) }}
                                        </div>
                                    </div>
                                    <small class="text-muted" style="white-space:nowrap;">
                                        <i class="bi bi-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        @empty
                            <div class="recent-item text-center text-muted py-4">
                                <i class="bi bi-bell-slash me-1"></i> {{ __('nav.no_notifications') ?? 'No notifications yet' }}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="v-cta">
            <div class="d-flex align-items-start gap-2">
                <i class="bi bi-info-circle mt-1 text-primary"></i>
                <div>
                    <div class="fw-bold">{{ __('nav.dashboard_tip_title') ?? 'Tip' }}</div>
                    <div class="text-muted small">
                        {{ __('nav.dashboard_info') ?? 'Keep your profile updated and respond to orders quickly to increase your business opportunities.' }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
