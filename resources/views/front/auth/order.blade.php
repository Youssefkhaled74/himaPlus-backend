@extends('layouts.front.home')

@section('title')
    <title>{{ __('products.order_title') }}</title>
@endsection

@section('css')
<style>
    .order-page {
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
    .order-page * { font-family: inherit; }

    .od-card {
        background: var(--vd-card);
        border: 1px solid var(--vd-border);
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(15, 23, 42, .04);
        overflow: hidden;
    }

    .od-hero {
        padding: 22px;
        margin-bottom: 16px;
    }

    .od-breadcrumb { font-size: 13px; margin-bottom: 12px; }
    .od-breadcrumb a { text-decoration: none; color: #6b7280; }
    .od-breadcrumb .active { color: #0f4bbf; font-weight: 700; }

    .od-title { margin: 0 0 6px; color: var(--vd-title); font-size: 28px; font-weight: 800; line-height: 1.1; }
    .od-subtitle { margin: 0; color: #475569; font-size: 15px; line-height: 1.55; }

    .od-journey {
        background: linear-gradient(135deg, #eef5ff 0%, #ecfffb 100%);
        border: 1px solid #d0e2f7;
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 16px;
        font-size: 14px;
        color: #1e3a8a;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .od-journey i { font-size: 18px; }

    .od-panel-head {
        border-bottom: 1px solid var(--vd-border);
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .od-panel-title { margin: 0; color: #0f172a; font-size: 17px; font-weight: 700; }
    .od-panel-sub { margin: 4px 0 0; color: #6b7280; font-size: 13px; }

    .od-panel-body { padding: 18px; }

    .od-detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .od-detail-row:last-child { border-bottom: 0; }
    .od-detail-label { color: #6b7280; font-size: 14px; font-weight: 500; }
    .od-detail-value { color: #1f2937; font-size: 14px; font-weight: 600; text-align: end; }

    .od-product {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        margin-bottom: 10px;
        transition: all .2s ease;
    }
    .od-product:hover { border-color: #93c5fd; box-shadow: 0 2px 8px rgba(15,75,191,.06); }
    .od-product-img {
        width: 64px;
        height: 64px;
        border-radius: 10px;
        object-fit: cover;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
    }
    .od-product-name { margin: 0; font-size: 15px; font-weight: 700; color: #111827; }
    .od-product-cat { margin: 2px 0 0; color: #6b7280; font-size: 13px; }
    .od-product-price { font-size: 16px; font-weight: 800; color: #0f4bbf; white-space: nowrap; }

    .od-timeline { position: relative; padding: 8px 0; }
    .od-timeline-item {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        position: relative;
        padding-bottom: 24px;
    }
    .od-timeline-item:last-child { padding-bottom: 0; }
    .od-timeline-item::before {
        content: "";
        position: absolute;
        left: 15px;
        top: 32px;
        bottom: 0;
        width: 2px;
        background: #e5e7eb;
    }
    .od-timeline-item:last-child::before { display: none; }
    .od-timeline-item.active::before { background: linear-gradient(180deg, #0f4bbf, #0ec6a0); }

    .od-timeline-dot {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
        transition: all .25s ease;
    }
    .od-timeline-item.active .od-timeline-dot {
        background: linear-gradient(135deg, var(--vd-primary), var(--vd-accent));
        box-shadow: 0 4px 12px rgba(15, 75, 191, .25);
    }
    .od-timeline-dot i { color: #fff; font-size: 14px; }
    .od-timeline-dot i.bi-check-lg { font-size: 16px; font-weight: 700; }

    .od-timeline-content { flex: 1; padding-top: 4px; }
    .od-timeline-label { margin: 0; font-size: 15px; font-weight: 700; color: #1f2937; }
    .od-timeline-item:not(.active) .od-timeline-label { color: #9ca3af; }
    .od-timeline-date { margin: 4px 0 0; font-size: 12px; color: #9ca3af; font-weight: 500; }
    .od-timeline-item.active .od-timeline-date { color: #6b7280; }

    .od-chip {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        padding: 5px 12px;
        font-size: 12px;
        font-weight: 700;
    }
    .od-chip-paid { background: #dcfce7; color: #166534; }
    .od-chip-unpaid { background: #ffedd5; color: #9a3412; }

    .od-summary-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        font-size: 14px;
        color: #475569;
    }
    .od-summary-row.total {
        border-top: 2px solid var(--vd-border);
        margin-top: 8px;
        padding-top: 12px;
        font-weight: 800;
        font-size: 16px;
        color: #0f172a;
    }

    .od-actions { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 16px; }

    .od-btn {
        border: 0;
        border-radius: 10px;
        font-weight: 700;
        padding: 11px 18px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        transition: all .2s ease;
        cursor: pointer;
    }
    .od-btn-primary {
        background: linear-gradient(90deg, var(--vd-primary) 0%, var(--vd-accent) 100%);
        color: #fff;
    }
    .od-btn-outline {
        background: #fff;
        color: #1e3a8a;
        border: 1px solid #cbd5e1;
    }
    .od-btn-danger {
        background: #fff;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }
    .od-btn:hover { opacity: .92; color: inherit; }

    .od-modal-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        width: 100%;
        flex-wrap: wrap;
    }

    .od-modal-actions form {
        margin: 0;
        flex: 1 1 180px;
    }

    .od-modal-actions .od-modal-btn {
        width: 100%;
        min-height: 48px;
        justify-content: center;
        font-size: 15px;
    }

    .od-offer {
        border: 1px solid #e7eaf0;
        border-radius: 14px;
        background: #fff;
        overflow: hidden;
        margin-bottom: 14px;
        transition: all .2s ease;
    }
    .od-offer:hover { box-shadow: 0 4px 12px rgba(15,23,42,.06); }
    .od-offer-header {
        padding: 14px 18px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .od-offer-body { padding: 16px 18px; }
    .od-offer-field { margin-bottom: 6px; font-size: 14px; }
    .od-offer-field strong { color: #374151; }

    .od-shipment {
        border: 1px solid #e7eaf0;
        border-radius: 14px;
        padding: 16px;
        margin-bottom: 12px;
        background: #fafbfc;
    }

    .od-empty {
        padding: 40px 20px;
        text-align: center;
        color: #94a3b8;
    }

    .rating-stars .star { font-size: 28px; color: #cfd8dc; cursor: pointer; margin-right: 6px; transition: color .15s; }
    .rating-stars .star.filled { color: #f5c518; }

    .files-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 8px; }
    .files-grid .cell { aspect-ratio: 1/1; border-radius: 8px; overflow: hidden; display: block; }
    .files-grid img { width: 100%; height: 100%; object-fit: cover; display: block; }

    @media (max-width: 991.98px) {
        .order-page { max-width: 100%; padding: 8px 12px 24px; }
        .od-title { font-size: 24px; }
    }
</style>
@endsection

@section('content')

<main class="order-page">
    @isset($order)
        @php
            $user = auth()->user();
            $provider = $order->provider;
            $step_1 = $order->timeline->where('timeline_no', 1)->last();
            $step_2 = $order->timeline->where('timeline_no', 2)->last();
            $step_3 = $order->timeline->where('timeline_no', 3)->last();
            $step_4 = $order->timeline->where('timeline_no', 4)->last();
            $step_5 = $order->timeline->where('timeline_no', 5)->last();
            $step_6 = $order->timeline->where('timeline_no', 6)->last();
            $step_7 = $order->timeline->where('timeline_no', 7)->last();
            $step_9 = $order->timeline->where('timeline_no', 9)->last();
            $step_12 = $order->timeline->where('timeline_no', 12)->last();
            $routeInfo = app('router')->getRoutes()->match(\Illuminate\Http\Request::create(url()->previous()));
            $page_type_endpoint = $routeInfo->parameter('page_type') ?? 'all';
            $isAr = app()->getLocale() === 'ar';
            $__journeyMap = [
                1 => __('products.journey_purchase'),
                2 => __('products.journey_quotation'),
                3 => __('products.journey_maintenance'),
            ];
            $__journeyText = $__journeyMap[(int)$order->order_type] ?? $__journeyMap[1];
        @endphp

        @include('flash::message')
        @if ($errors->any())
            <div style="text-align: {{ $isAr ? 'right' : 'left' }}; margin: 0 0 12px;">
                <ul dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="margin:0;padding:0;list-style:none;">
                    @foreach ($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="od-hero od-card">
            <div class="od-breadcrumb">
                <a href="{{ route('user/myorders', 'all') }}">{{ __('products.orders') }}</a>
                <i class="bi bi-chevron-{{ $isAr ? 'left' : 'right' }}"></i>
                <a href="{{ route('user/myorders', $page_type_endpoint) }}">{{ orderType($order->order_type) }}</a>
                <i class="bi bi-chevron-{{ $isAr ? 'left' : 'right' }}"></i>
                <span class="active">{{ __('products.order_details') }} #{{ $order->id }}</span>
            </div>

            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                <div>
                    <h1 class="od-title">{{ __('products.order_details') }} #{{ $order->id }}</h1>
                    <p class="od-subtitle">{{ \Carbon\Carbon::parse($order->created_at)->format('M j, Y — H:i') }}</p>
                </div>
                <div class="d-flex gap-2">
                    @if ($order->payment_status == 0)
                        <a href="{{ route('user/online-payment/actions', $order->id) }}" class="od-btn od-btn-primary">
                            <i class="bi bi-wallet-fill"></i> {{ __('products.get_payment') }}
                        </a>
                    @endif
                    <a href="{{ route('vendor/dashboard') }}" class="od-btn od-btn-outline">
                        <i class="bi bi-arrow-{{ $isAr ? 'right' : 'left' }}"></i>
                        {{ __('nav.dashboard') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="od-journey">
            <i class="bi bi-signpost-split"></i>
            <strong>{{ __('products.order_journey') }}</strong>
            {{ $__journeyText }}
        </div>

        <div class="row g-4">
            <div class="col-lg-7">

                <div class="od-card mb-4">
                    <div class="od-panel-head">
                        <div>
                            <h5 class="od-panel-title">{{ __('products.order_details') }}</h5>
                            <p class="od-panel-sub">#{{ $order->id }}</p>
                        </div>
                        <span class="od-chip {{ $order->payment_status == 1 ? 'od-chip-paid' : 'od-chip-unpaid' }}">
                            {{ $order->payment_status == 1 ? __('products.paid') : __('products.unpaid') }}
                        </span>
                    </div>
                    <div class="od-panel-body">
                        <div class="od-detail-row">
                            <span class="od-detail-label">{{ __('products.order_number') }}</span>
                            <span class="od-detail-value">#{{ $order->id }}</span>
                        </div>
                        <div class="od-detail-row">
                            <span class="od-detail-label">{{ __('products.delivery_address') }}</span>
                            <span class="od-detail-value">{{ $order->address }}</span>
                        </div>
                        <div class="od-detail-row">
                            <span class="od-detail-label">{{ __('products.payment_method') }}</span>
                            <span class="od-detail-value">{{ $order->payment_type ?? '---' }}</span>
                        </div>
                        <div class="od-detail-row">
                            <span class="od-detail-label">{{ __('products.date') }}</span>
                            <span class="od-detail-value">{{ \Carbon\Carbon::parse($order->created_at)->format('M j, Y') }}</span>
                        </div>
                    </div>
                </div>

                @if (isset($order->items) && count($order->items) > 0)
                    <div class="od-card mb-4">
                        <div class="od-panel-head">
                            <div>
                                <h5 class="od-panel-title">{{ __('products.items_count') }}</h5>
                                <p class="od-panel-sub">{{ $order->items_count }} {{ __('products.items_count') }}</p>
                            </div>
                        </div>
                        <div class="od-panel-body">
                            @foreach ($order->items as $item)
                                @php $product = $item->product; @endphp
                                <div class="od-product">
                                    <img src="{{ asset('storage/' . $product->img) }}" class="od-product-img" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='{{ asset('front/assets/images/emptyproducts.png') }}'">
                                    <div class="flex-grow-1">
                                        <p class="od-product-name">{{ $product->name }}</p>
                                        <p class="od-product-cat">{{ $product->category?->name }} &times; {{ $item->quantity }}</p>
                                    </div>
                                    <div class="od-product-price">{{ $item->item_price }} {{ __('products.currency_sar') }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @php
                    $__customerSteps = match ((int)$order->order_type) {
                        1 => [1, 3, 4, 5, 6],
                        2 => [1, 7, 9, 6],
                        3 => [1, 7, 9, 6],
                        default => [1, 3, 4, 5, 6],
                    };
                    $__stepIcons = [
                        1 => 'bi-bag-check',
                        3 => 'bi-gear',
                        4 => 'bi-truck',
                        5 => 'bi-box-seam',
                        6 => 'bi-check-circle',
                        7 => 'bi-file-earmark-text',
                        9 => 'bi-arrow-right-circle',
                        12 => 'bi-x-circle',
                    ];
                @endphp
                <div class="od-card mb-4">
                    <div class="od-panel-head">
                        <div>
                            <h5 class="od-panel-title">{{ __('products.timeline') }}</h5>
                            <p class="od-panel-sub">{{ __('products.order_journey') }}</p>
                        </div>
                    </div>
                    <div class="od-panel-body">
                        <div class="od-timeline">
                            @if (!isset($step_12->id))
                                @foreach ($__customerSteps as $__cs)
                                    @php
                                        $__csVar = 'step_' . $__cs;
                                        $__csEntry = $$__csVar;
                                    @endphp
                                    <div class="od-timeline-item {{ isset($__csEntry->id) ? 'active' : '' }}">
                                        <div class="od-timeline-dot">
                                            <i class="bi {{ isset($__csEntry->id) ? 'bi-check-lg' : ($__stepIcons[$__cs] ?? 'bi-circle') }}"></i>
                                        </div>
                                        <div class="od-timeline-content">
                                            <p class="od-timeline-label">{{ customerTimelineName($__cs, $order->order_type) }}</p>
                                            @if(isset($__csEntry->id))
                                                <p class="od-timeline-date">{{ \Carbon\Carbon::parse($__csEntry->created_at)->format('M j, Y — H:i') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="od-timeline-item active">
                                    <div class="od-timeline-dot"><i class="bi bi-x-lg"></i></div>
                                    <div class="od-timeline-content">
                                        <p class="od-timeline-label">{{ customerTimelineName(12, $order->order_type) }}</p>
                                        <p class="od-timeline-date">{{ \Carbon\Carbon::parse($step_12?->created_at)->format('M j, Y — H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-5">

                <div class="od-card mb-4">
                    <div class="od-panel-head">
                        <div>
                            <h5 class="od-panel-title">{{ __('products.payment_details') }}</h5>
                        </div>
                    </div>
                    <div class="od-panel-body">
                        <div class="od-summary-row">
                            <span>{{ __('products.subtotal') }}</span>
                            <span>{{ $order->items_cost }} {{ __('products.currency_sar') }}</span>
                        </div>
                        <div class="od-summary-row">
                            <span>{{ __('products.vat') }} ({{ $order->vat }}%)</span>
                            <span>{{ $order->vat_amount }} {{ __('products.currency_sar') }}</span>
                        </div>
                        <div class="od-summary-row">
                            <span>{{ __('products.discount') }}</span>
                            <span>{{ $order->discount }} {{ __('products.currency_sar') }}</span>
                        </div>
                        <div class="od-summary-row">
                            <span>{{ __('products.delivery_fee') }}</span>
                            <span>{{ $order->delivery_fee }} {{ __('products.currency_sar') }}</span>
                        </div>
                        <div class="od-summary-row total">
                            <span>{{ __('products.net_total') }}</span>
                            <span>{{ $order->total_cost + $order->delivery_fee }} {{ __('products.currency_sar') }}</span>
                        </div>

                        <div class="od-actions">
                            @if (!isset($step_12->id))
                                @if (!isset($step_5->id))
                                    @if (!isset($step_2->id))
                                        <a href="{{ route('user/cancel/order', $order->id) }}" class="od-btn od-btn-danger flex-fill" style="justify-content:center;">
                                            <i class="bi bi-x-circle"></i> {{ __('products.cancel_order') }}
                                        </a>
                                    @endif
                                    <button class="od-btn od-btn-primary flex-fill" data-bs-toggle="modal" data-bs-target="#contactModal" style="justify-content:center;">
                                        <i class="bi bi-chat-dots"></i> {{ __('products.contact_supplier') }}
                                    </button>
                                @endif
                                @if (isset($step_5->id) && !isset($step_6->id))
                                    <button type="button" class="od-btn od-btn-outline flex-fill" data-bs-toggle="modal" data-bs-target="#reportIssueModal-{{ $order->id }}" style="justify-content:center;">
                                        <i class="bi bi-exclamation-triangle"></i> {{ __('products.report_issue') }}
                                    </button>
                                    <button type="button" class="od-btn od-btn-primary flex-fill" data-bs-toggle="modal" data-bs-target="#reportConfirmDeliveryModal-{{ $order->id }}" style="justify-content:center;">
                                        <i class="bi bi-check2-circle"></i> {{ __('products.confirm_delivery') }}
                                    </button>
                                    <button type="button" class="od-btn od-btn-outline flex-fill" data-bs-toggle="modal" data-bs-target="#receivePartialShipmentModal-{{ $order->id }}" style="justify-content:center;">
                                        <i class="bi bi-box-seam"></i> {{ __('products.receive_partial') }}
                                    </button>
                                @endif
                                @if (isset($step_6->id) && !is_null($order->provider_id))
                                    <button type="button" class="od-btn od-btn-primary flex-fill" data-bs-toggle="modal" data-bs-target="#addReviewModal-{{ $order->id }}" style="justify-content:center;">
                                        <i class="bi bi-star-fill"></i> {{ __('products.rate_supplier') }}
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            @isset($order->offers)
                @if($order->offers->count() > 0)
                    <div class="col-12">
                        <div class="od-card mb-4">
                            <div class="od-panel-head">
                                <div>
                                    <h5 class="od-panel-title">{{ __('products.offer_list') }}</h5>
                                    <p class="od-panel-sub">{{ $order->offers->count() }} {{ __('products.offers') }}</p>
                                </div>
                            </div>
                            <div class="od-panel-body">
                                <div class="row g-3">
                                    @foreach($order->offers as $offer)
                                        @php
                                            $OFStatus = __('products.pending');
                                            $OFStatusClass = 'od-chip-unpaid';
                                            if ($offer->status == 2) { $OFStatus = __('products.accepted'); $OFStatusClass = 'od-chip-paid'; }
                                            elseif ($offer->status == 3) { $OFStatus = __('products.rejected'); $OFStatusClass = ''; }
                                        @endphp
                                        <div class="col-md-6">
                                            <div class="od-offer">
                                                <div class="od-offer-header">
                                                    <strong>{{ __('products.offer') }} #{{ $offer->id }}</strong>
                                                    <span class="od-chip {{ $OFStatusClass }}">{{ $OFStatus }}</span>
                                                </div>
                                                <div class="od-offer-body">
                                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <i class="bi bi-file-earmark-pdf text-danger"></i>
                                                            <span class="text-muted small">{{ $offer->filename ?? 'quotation.pdf' }}</span>
                                                        </div>
                                                        <a href="{{ route('user/order/offers/download', $offer->id) }}" class="od-btn od-btn-outline" style="padding:6px 12px;font-size:12px;">
                                                            <i class="bi bi-download"></i> {{ __('products.download') }}
                                                        </a>
                                                    </div>
                                                    @if (!is_null($offer->rejected_reson))
                                                        <div class="od-offer-field">
                                                            <strong>{{ __('products.rejected_reason') }}:</strong> {{ $offer->rejected_reson }}
                                                        </div>
                                                    @endif
                                                    <div class="od-offer-field">
                                                        <strong>{{ __('products.provider') }}:</strong> {{ $offer->provider?->name }}
                                                    </div>
                                                    <div class="od-offer-field">
                                                        <strong>{{ __('products.total_price') }}:</strong> {{ number_format($offer->cost, 0) }} {{ __('products.currency_sar') }}
                                                    </div>
                                                    <div class="od-offer-field">
                                                        <strong>{{ __('products.delivery_time') }}:</strong> {{ $offer->delivery_time }}
                                                    </div>
                                                    <div class="od-offer-field">
                                                        <strong>{{ __('products.warranty') }}:</strong> {{ $offer->warranty }}
                                                    </div>
                                                    @if($offer->notes)
                                                        <div class="od-offer-field">
                                                            <strong>{{ __('products.notes') }}:</strong> <span class="text-muted">{{ $offer->notes }}</span>
                                                        </div>
                                                    @endif
                                                    @if ($offer->status == 1)
                                                        <button class="od-btn od-btn-primary w-100 mt-2" data-bs-toggle="modal" data-bs-target="#offerDetailsModal-{{ $offer->id }}" style="justify-content:center;">
                                                            {{ __('products.view_details') }}
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="offerDetailsModal-{{ $offer->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content border-0 rounded-3">
                                                    <div class="modal-header border-0">
                                                        <h5 class="modal-title">{{ __('products.offer_details') }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-2"><strong>{{ __('products.total_price') }}:</strong> {{ number_format($offer->cost, 0) }} {{ __('products.currency_sar') }}</div>
                                                        <div class="mb-2"><strong>{{ __('products.delivery_time') }}:</strong> {{ $offer->delivery_time ?? '---' }}</div>
                                                        <div class="mb-2"><strong>{{ __('products.warranty') }}:</strong> {{ $offer->warranty ?? '---' }}</div>
                                                        <div class="mb-0"><strong>{{ __('products.notes') }}:</strong> <span class="text-muted">{{ $offer->notes ?? '---' }}</span></div>
                                                    </div>
                                                    <div class="modal-footer border-0 od-modal-actions">
                                                        <button class="od-btn od-btn-danger od-modal-btn" data-bs-toggle="modal" data-bs-target="#rejectOfferModal-{{ $offer->id }}" type="button">
                                                            {{ __('products.reject_offer') }}
                                                        </button>
                                                        <form method="POST" action="{{ route('user/offer/actions') }}">
                                                            @csrf
                                                            <input name="action" type="hidden" value="2">
                                                            <input name="offer_id" type="hidden" value="{{ $offer->id }}">
                                                            <button type="submit" class="od-btn od-btn-primary od-modal-btn">{{ __('products.accept_offer') }}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="rejectOfferModal-{{ $offer->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content border-0 rounded-3">
                                                    <div class="modal-header border-0">
                                                        <h5 class="modal-title">{{ __('products.reject_offer') }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form method="POST" action="{{ route('user/offer/actions') }}">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <input name="action" type="hidden" value="3">
                                                            <input name="offer_id" type="hidden" value="{{ $offer->id }}">
                                                            <label class="form-label">{{ __('products.rejected_reason') }}</label>
                                                            <textarea name="rejected_reson" class="form-control" rows="4" placeholder="{{ __('products.write_reason') }}"></textarea>
                                                        </div>
                                                        <div class="modal-footer border-0 justify-content-center gap-3">
                                                            <button type="button" class="od-btn od-btn-outline" data-bs-dismiss="modal">{{ __('products.cancel') }}</button>
                                                            <button type="submit" class="od-btn od-btn-danger">{{ __('products.confirm_reject') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endisset

            @isset($order->partial_receive)
                @foreach($order->partial_receive as $partial_receive)
                    <div class="col-12">
                        <div class="od-card mb-4">
                            <div class="od-panel-head">
                                <div>
                                    <h5 class="od-panel-title">{{ __('products.partial_shipment') }} #{{ $partial_receive->id }}</h5>
                                </div>
                            </div>
                            <div class="od-panel-body">
                                <div class="od-detail-row">
                                    <span class="od-detail-label">{{ __('products.received_quantity') }}</span>
                                    <span class="od-detail-value">{{ $partial_receive->received_quantity }}</span>
                                </div>
                                <div class="od-detail-row">
                                    <span class="od-detail-label">{{ __('products.reason_partial') }}</span>
                                    <span class="od-detail-value">{{ $partial_receive->reason_for_partial }}</span>
                                </div>
                                @if(!empty($partial_receive->files))
                                    <div style="margin-top:12px;">
                                        <span class="od-detail-label d-block mb-2">{{ __('products.files') }}</span>
                                        <div class="files-grid">
                                            @foreach(explode(',', $partial_receive->files) as $img)
                                                <a href="{{ asset($img) }}" target="_blank" class="cell"><img src="{{ asset($img) }}" alt=""></a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endisset

            @if(isset($order->shipments) && $order->shipments->count() > 0)
                <div class="col-12">
                    <div class="od-card mb-4">
                        <div class="od-panel-head">
                            <div>
                                <h5 class="od-panel-title">{{ __('nav.shipments') }}</h5>
                                <p class="od-panel-sub">{{ $order->shipments->count() }} {{ __('nav.shipment') }}</p>
                            </div>
                        </div>
                        <div class="od-panel-body">
                            @foreach($order->shipments as $shipment)
                                <div class="od-shipment">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span style="font-size:15px;font-weight:700;color:#1f2937;">{{ __('nav.shipment') }} #{{ $shipment->id }}</span>
                                        <span class="od-chip" style="background:#dbeafe;color:#1e40af;">{{ $shipment->status_label }}</span>
                                    </div>
                                    <div style="font-size:13px;color:#6b7280;margin-bottom:8px;">
                                        @if($shipment->tracking_number){{ __('nav.tracking_number') }}: {{ $shipment->tracking_number }} | @endif
                                        @if($shipment->shippingMethod){{ $shipment->shippingMethod->name }} | @endif
                                        {{ $shipment->created_at->translatedFormat('M d, Y H:i') }}
                                    </div>
                                    @if($shipment->notes)
                                        <div style="font-size:13px;color:#4b5563;margin-bottom:8px;"><strong>{{ __('nav.note') }}:</strong> {{ $shipment->notes }}</div>
                                    @endif
                                    @if($shipment->images->count() > 0)
                                        <div class="files-grid">
                                            @foreach($shipment->images as $img)
                                                <a href="{{ asset($img->image_path) }}" target="_blank" class="cell">
                                                    @if(in_array(strtolower(pathinfo($img->image_path, PATHINFO_EXTENSION)), ['jpg','jpeg','png','webp']))
                                                        <img src="{{ asset($img->image_path) }}" alt="{{ $img->caption ?? '' }}">
                                                    @else
                                                        <div style="width:90px;height:90px;border-radius:8px;border:1px solid #e5e7eb;display:grid;place-items:center;background:#f1f5f9;color:#475569;font-size:11px;">
                                                            <i class="bi bi-file-earmark"></i> {{ strtoupper(pathinfo($img->image_path, PATHINFO_EXTENSION)) }}
                                                        </div>
                                                    @endif
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Contact Modal -->
        <div class="modal fade" id="contactModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 rounded-3">
                    <div class="modal-header border-0">
                        <h5 class="modal-title">{{ __('products.contact_supplier') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center gap-3">
                                <img src="{{ asset('front/assets/images/newLogo.png') }}" width="56" height="56" alt="Hema">
                                <div class="flex-grow-1">
                                    <h6 class="mb-3">{{ __('products.app_contact_info') }}</h6>
                                    <div class="text-muted small mb-2"><i class="bi bi-mobile me-1"></i>{{ __('products.mobile') }}: {{ $info?->mobile ?? '—' }}</div>
                                    <div class="text-muted small mb-2"><i class="bi bi-envelope me-1"></i>{{ __('products.email') }}: {{ $info?->email ?? '—' }}</div>
                                    <div class="text-muted small mb-2"><i class="bi bi-geo-alt me-1"></i>{{ __('products.location') }}: {{ $info?->location ?? '—' }}</div>
                                    <div class="d-flex gap-2 mt-3">
                                        @if($info?->facebook)<a href="{{ $info->facebook }}" target="_blank" class="btn btn-outline-primary btn-sm"><i class="bi bi-facebook"></i></a>@endif
                                        @if($info?->twitter)<a href="{{ $info->twitter }}" target="_blank" class="btn btn-outline-info btn-sm"><i class="bi bi-twitter-x"></i></a>@endif
                                        @if($info?->instagram)<a href="{{ $info->instagram }}" target="_blank" class="btn btn-outline-danger btn-sm"><i class="bi bi-instagram"></i></a>@endif
                                        @if($info?->snapchat)<a href="{{ $info->snapchat }}" target="_blank" class="btn btn-outline-warning btn-sm"><i class="bi bi-snapchat"></i></a>@endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('products.close') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Issue Modal -->
        <div class="modal fade" id="reportIssueModal-{{ $order->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header"><h5 class="modal-title">{{ __('products.report_issue') }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                    <form method="POST" action="{{ route('user/update/order', $order->id) }}">
                        @csrf
                        <div class="modal-body"><textarea name="issue" class="form-control" rows="4" required placeholder="{{ __('products.describe_issue') }}"></textarea></div>
                        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('products.cancel') }}</button><button type="submit" class="od-btn od-btn-primary">{{ __('products.submit') }}</button></div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Confirm Delivery Modal -->
        <div class="modal fade" id="reportConfirmDeliveryModal-{{ $order->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header"><h5 class="modal-title">{{ __('products.confirm_delivery') }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                    <form method="POST" action="{{ route('user/order-timeline') }}">
                        @csrf
                        <div class="modal-body text-center p-4">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width:72px;height:72px;background:linear-gradient(135deg,#0f4bbf,#0ec6a0);">
                                <svg width="34" height="34" viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17L4 12" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <h5 class="mt-3 mb-1">{{ __('products.order_delivered') }}</h5>
                            <p class="text-muted mb-0">{{ __('products.thank_you') }}</p>
                        </div>
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <input type="hidden" name="order_type" value="{{ $order->order_type }}">
                        <input type="hidden" name="timeline_no" value="6">
                        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('products.cancel') }}</button><button type="submit" class="od-btn od-btn-primary">{{ __('products.submit') }}</button></div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Partial Shipment Modal -->
        <div class="modal fade" id="receivePartialShipmentModal-{{ $order->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header"><h5 class="modal-title">{{ __('products.partial_shipment') }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                    <form method="POST" action="{{ route('user/order/partial-receive') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3"><label class="form-label small text-muted mb-1">{{ __('products.received_quantity') }} <span class="text-danger">*</span></label><textarea class="form-control" name="received_quantity" rows="2" placeholder="{{ __('products.enter_quantity') }}"></textarea></div>
                            <div class="mb-3"><label class="form-label small text-muted mb-1">{{ __('products.reason_partial') }}</label><textarea class="form-control" name="reason_for_partial" rows="3" placeholder="{{ __('products.reason_placeholder') }}"></textarea></div>
                            <div class="mb-3"><label class="form-label small text-muted mb-1">{{ __('products.attach_images') }}</label><div class="border rounded-3 p-4 text-center bg-light"><input class="form-control" type="file" name="files[]" accept="image/*" multiple><div class="small text-muted mt-2">{{ __('products.add_images_proof') }}</div></div></div>
                        </div>
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('products.cancel') }}</button><button type="submit" class="od-btn od-btn-primary">{{ __('products.submit') }}</button></div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Review Modal -->
        <div class="modal fade" id="addReviewModal-{{ $order->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content border-0 rounded-3">
                    <div class="modal-header border-0"><h5 class="modal-title">{{ __('products.add_review') }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                    <form method="POST" action="{{ route('user/store/ratings') }}" id="review-form-{{ $order->id }}">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-4">
                                <label class="form-label d-block">{{ __('products.rating') }}</label>
                                <div class="rating-stars" data-input="#rating-input-{{ $order->id }}">
                                    <i class="bi bi-star star" data-value="1"></i>
                                    <i class="bi bi-star star" data-value="2"></i>
                                    <i class="bi bi-star star" data-value="3"></i>
                                    <i class="bi bi-star star" data-value="4"></i>
                                    <i class="bi bi-star star" data-value="5"></i>
                                </div>
                                <input type="hidden" name="rating" id="rating-input-{{ $order->id }}" required>
                            </div>
                            <label class="form-label">{{ __('products.detail_review') }}</label>
                            <textarea name="comment" class="form-control" rows="4" placeholder="{{ __('products.rate_experience') }}" required></textarea>
                            <input type="hidden" name="for_type" value="User">
                            <input type="hidden" name="for_id" value="{{ $order->provider_id ?? 0 }}">
                        </div>
                        <div class="modal-footer border-0"><button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('products.cancel') }}</button><button type="submit" class="od-btn od-btn-primary">{{ __('products.submit_review') }}</button></div>
                    </form>
                </div>
            </div>
        </div>

    @endisset
</main>

@endsection

@section('script')
<script>
    $(function(){
        $('#nav-orders').addClass('active');
        $('[id^="offerDetailsModal-"], [id^="rejectOfferModal-"]').each(function(){
            if (this.parentElement !== document.body) $(this).appendTo(document.body);
        });
    });

    document.addEventListener('click', function(e){
        if(!e.target.classList.contains('star')) return;
        const star = e.target;
        const wrap = star.closest('.rating-stars');
        const value = Number(star.dataset.value);
        const input = document.querySelector(wrap.dataset.input);
        wrap.querySelectorAll('.star').forEach(s=>{
            const v = Number(s.dataset.value);
            s.classList.toggle('filled', v <= value);
            s.classList.toggle('bi-star', v > value);
            s.classList.toggle('bi-star-fill', v <= value);
        });
        if(input) input.value = value;
    });
</script>
@endsection
