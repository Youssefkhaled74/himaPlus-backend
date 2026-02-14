@extends('layouts.front.home')

@section('title')
    <title>{{ __('nav.dashboard') ?? 'Dashboard' }} - Vendor | HemaPulse</title>
@endsection

@section('css')
<style>
    :root{
        --v-bg:#f6f7fb;
        --v-card:#fff;
        --v-border: rgba(0,0,0,.08);
        --v-text:#111827;
        --v-muted:#6b7280;
        --v-shadow: 0 10px 30px rgba(17,24,39,.08);
        --v-shadow-sm: 0 6px 18px rgba(17,24,39,.08);
        --v-radius:16px;
    }

    .v-page{
        background: var(--v-bg);
        border: 1px solid var(--v-border);
        border-radius: var(--v-radius);
        padding: 22px;
    }

    .v-head{
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:16px;
        margin-bottom: 16px;
    }

    .v-title{
        margin:0;
        font-weight:900;
        letter-spacing:-.02em;
        color: var(--v-text);
    }

    .v-sub{
        margin:6px 0 0;
        color: var(--v-muted);
        font-size: 14px;
    }

    .v-pill{
        display:inline-flex;
        align-items:center;
        gap:8px;
        padding: 10px 12px;
        background: rgba(13,110,253,.08);
        color: #0d6efd;
        border: 1px solid rgba(13,110,253,.18);
        border-radius: 999px;
        font-size: 13px;
        white-space: nowrap;
    }

    /* Stat Cards */
    .stat-card{
        position:relative;
        overflow:hidden;
        padding: 18px;
        border-radius: var(--v-radius);
        color: #fff;
        box-shadow: var(--v-shadow-sm);
        transition: transform .15s ease, box-shadow .15s ease;
        height:100%;
    }
    .stat-card:hover{
        transform: translateY(-2px);
        box-shadow: var(--v-shadow);
    }
    .stat-card:before{
        content:"";
        position:absolute;
        inset:-1px;
        background: radial-gradient(600px 180px at 20% 0%, rgba(255,255,255,.18), transparent 60%);
        pointer-events:none;
    }
    .stat-top{
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:10px;
        position:relative;
    }
    .stat-ico{
        width:42px;height:42px;
        border-radius: 14px;
        display:grid;
        place-items:center;
        background: rgba(255,255,255,.18);
        border: 1px solid rgba(255,255,255,.20);
        flex: 0 0 auto;
    }
    .stat-ico i{ font-size: 18px; }
    .stat-value{
        font-size: 30px;
        font-weight: 900;
        margin: 10px 0 2px;
        letter-spacing:-.02em;
        position:relative;
    }
    .stat-label{
        font-size: 13px;
        opacity: .92;
        position:relative;
    }

    .stat-card.orders { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
    .stat-card.offers { background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%); }
    .stat-card.products { background: linear-gradient(135deg, #06b6d4 0%, #0284c7 100%); }
    .stat-card.rating { background: linear-gradient(135deg, #22c55e 0%, #10b981 100%); }

    /* Section Card */
    .v-card{
        background: var(--v-card);
        border: 1px solid var(--v-border);
        border-radius: var(--v-radius);
        box-shadow: var(--v-shadow-sm);
    }
    .v-card-head{
        padding: 14px 16px;
        border-bottom: 1px solid rgba(0,0,0,.06);
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:10px;
    }
    .v-card-head h5{
        margin:0;
        font-weight:900;
        color: var(--v-text);
        font-size: 15px;
    }

    /* Action Tiles */
    .action-tile{
        display:flex;
        align-items:center;
        gap:12px;
        padding: 14px;
        border-radius: 14px;
        border: 1px solid rgba(0,0,0,.07);
        background:#fff;
        text-decoration:none;
        transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
        height: 100%;
        color: inherit;
    }
    .action-tile:hover{
        transform: translateY(-2px);
        box-shadow: var(--v-shadow);
        border-color: rgba(13,110,253,.22);
    }
    .action-ico{
        width:42px;height:42px;
        border-radius: 14px;
        display:grid;
        place-items:center;
        background: rgba(13,110,253,.08);
        color:#0d6efd;
        border: 1px solid rgba(13,110,253,.16);
        flex: 0 0 auto;
    }
    .action-ico i{ font-size: 18px; }
    .action-title{ margin:0; font-weight:900; font-size: 14px; color: var(--v-text); line-height: 1.2; }
    .action-desc{ margin:3px 0 0; font-size: 12px; color: var(--v-muted); }

    /* Lists */
    .recent-item{
        padding: 14px 16px;
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
        border-radius: var(--v-radius);
        border: 1px solid rgba(13,110,253,.18);
        background: linear-gradient(135deg, rgba(13,110,253,.10), rgba(236,72,153,.06));
        padding: 14px 16px;
    }

    @media (max-width:576px){
        .v-page{ padding: 16px; }
        .stat-value{ font-size: 26px; }
    }
</style>
@endsection

@section('content')
<main class="container my-4" style="max-width: 95%; margin-top: 8% !important;">
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
        <div class="row g-3 mb-3">
            <div class="col-12 col-sm-6 col-lg-3">
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

            <div class="col-12 col-sm-6 col-lg-3">
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

            <div class="col-12 col-sm-6 col-lg-3">
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

            <div class="col-12 col-sm-6 col-lg-3">
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

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
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
                    <div class="col-12 col-sm-6 col-lg-4">
                        <a href="{{ route('vendor/products/create') }}" class="action-tile">
                            <div class="action-ico"><i class="bi bi-plus-lg"></i></div>
                            <div>
                                <p class="action-title">{{ __('nav.add_product') ?? 'Add Product' }}</p>
                                <p class="action-desc">{{ __('nav.add_product_desc') ?? 'Create a new listing in seconds' }}</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-4">
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

                    <div class="col-12 col-sm-6 col-lg-4">
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

                    <div class="col-12 col-sm-6 col-lg-4">
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

                    <div class="col-12 col-sm-6 col-lg-4">
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

                    <div class="col-12 col-sm-6 col-lg-4">
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

                    <div class="col-12 col-sm-6 col-lg-4">
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

                    <div class="col-12 col-sm-6 col-lg-4">
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

                    <div class="col-12 col-sm-6 col-lg-4">
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
