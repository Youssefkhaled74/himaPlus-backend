@extends('layouts.front.home')

@section('title')
    <title>{{ __('products.my_orders_title') }}</title>
@endsection

@section('css')
<style>
    .customer-orders {
        --co-bg: #f5f6f8;
        --co-card: #ffffff;
        --co-border: #e7eaf0;
        --co-title: #0f2f7f;
        --co-text: #1f2937;
        --co-muted: #6b7280;
        --co-primary: #0f4bbf;
        --co-accent: #0ec6a0;
        --co-soft: #eef5ff;
        --co-soft-2: #f4fbf9;

        max-width: 95%;
        margin: 12px auto 0;
        background: var(--co-bg);
        padding: 8px 0 24px;
        font-family: "Poppins", "Tajawal", system-ui, -apple-system, "Segoe UI", Arial, sans-serif;
    }

    .customer-orders * {
        font-family: inherit;
    }

    .co-card {
        background: var(--co-card);
        border: 1px solid var(--co-border);
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.04);
    }

    .co-breadcrumb {
        font-size: 13px;
        margin-bottom: 12px;
    }

    .co-breadcrumb a {
        text-decoration: none;
        color: #6b7280;
    }

    .co-breadcrumb .active {
        color: var(--co-primary);
        font-weight: 700;
    }

    .co-hero {
        padding: 22px;
        margin-bottom: 16px;
    }

    .co-title {
        margin: 0 0 6px;
        color: var(--co-title);
        font-size: 34px;
        line-height: 1.08;
        font-weight: 800;
        letter-spacing: -0.01em;
    }

    .co-subtitle {
        margin: 0;
        color: #475569;
        font-size: 16px;
        line-height: 1.55;
        max-width: 760px;
    }

    .co-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .co-btn-primary,
    .co-btn-outline,
    .co-tab,
    .co-filter {
        border-radius: 10px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all .2s ease;
    }

    .co-btn-primary {
        border: 0;
        color: #fff;
        background: linear-gradient(90deg, var(--co-primary) 0%, var(--co-accent) 100%);
        padding: 10px 16px;
    }

    .co-btn-primary:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(15, 75, 191, .14);
    }

    .co-btn-outline {
        border: 1px solid #cbd5e1;
        color: #1e3a8a;
        background: #fff;
        padding: 10px 16px;
    }

    .co-btn-outline:hover {
        color: #1e3a8a;
        background: var(--co-soft);
        transform: translateY(-1px);
    }

    .co-stat {
        padding: 16px 18px;
        height: 100%;
        transition: all .2s ease;
    }

    .co-stat:hover {
        border-color: #93c5fd;
        box-shadow: 0 4px 12px rgba(15, 75, 191, .08);
        transform: translateY(-1px);
    }

    .co-stat-label {
        margin: 0;
        color: var(--co-muted);
        font-size: 13px;
        font-weight: 500;
    }

    .co-stat-value {
        margin: 8px 0 0;
        color: var(--co-text);
        font-size: 40px;
        line-height: 1;
        font-weight: 800;
    }

    .co-panel-head {
        border-bottom: 1px solid var(--co-border);
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .co-panel-title {
        margin: 0;
        color: #0f172a;
        font-size: 20px;
        font-weight: 700;
    }

    .co-panel-subtitle {
        margin: 4px 0 0;
        color: var(--co-muted);
        font-size: 13px;
    }

    .co-body {
        padding: 18px;
    }

    .co-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .co-tab {
        border: 1px solid #dbe4f0;
        background: #fff;
        color: #334155;
        padding: 10px 14px;
        font-size: 13px;
        min-height: 48px;
    }

    .co-tab:hover,
    .co-tab.is-active {
        color: #fff;
        border-color: transparent;
        background: linear-gradient(90deg, var(--co-primary) 0%, var(--co-accent) 100%);
        transform: translateY(-1px);
    }

    .co-filter-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #edf2f7;
    }

    .co-filter {
        border: 1px solid #dbe4f0;
        background: #fff;
        color: #334155;
        padding: 8px 14px;
        font-size: 13px;
    }

    .co-filter:hover,
    .co-filter.is-active {
        color: #fff;
        border-color: transparent;
        background: linear-gradient(90deg, var(--co-primary) 0%, var(--co-accent) 100%);
    }

    .co-chip {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 700;
        line-height: 1;
        white-space: nowrap;
    }

    .co-chip-primary {
        background: #eaf2ff;
        color: #1d4ed8;
    }

    .co-chip-success,
    .co-badge--confirmed,
    .co-badge--completed {
        background: #dcfce7;
        color: #166534;
        border-color: #bbf7d0;
    }

    .co-badge--inprogress,
    .co-badge--upcoming {
        background: #e0ecff;
        color: #1d4ed8;
        border-color: #c7dbff;
    }

    .co-badge--pending {
        background: #fff7ed;
        color: #9a3412;
        border-color: #fed7aa;
    }

    .co-badge--cancelled {
        background: #fee2e2;
        color: #b91c1c;
        border-color: #fecaca;
    }

    .co-order {
        display: grid;
        grid-template-columns: 1fr auto;
        align-items: start;
        gap: 16px;
        padding: 16px 0;
    }

    .co-order + .co-order {
        border-top: 1px solid #edf2f7;
    }

    .co-order-type {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 6px 12px;
        background: var(--co-soft);
        color: var(--co-primary);
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .co-order-title {
        margin: 0 0 6px;
        font-size: 17px;
        font-weight: 800;
        color: #111827;
    }

    .co-order-meta {
        margin: 0;
        color: #64748b;
        font-size: 13px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px;
    }

    .co-order-meta span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .co-order-side {
        min-width: 220px;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 8px;
    }

    .co-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 800;
        line-height: 1;
        border: 1px solid transparent;
        white-space: nowrap;
    }

    .co-price {
        color: #0f172a;
        font-size: 16px;
        font-weight: 900;
    }

    .co-order-footer {
        grid-column: 1 / -1;
        margin-top: 8px;
        padding-top: 12px;
        border-top: 1px solid #edf2f7;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .co-mini-table {
        width: 100%;
        border-collapse: collapse;
    }

    .co-mini-table tr + tr {
        border-top: 1px solid #edf2f7;
    }

    .co-mini-table td {
        padding: 12px 0;
        font-size: 14px;
        color: #334155;
    }

    .co-mini-table td:last-child {
        text-align: end;
        font-weight: 800;
        color: #0f172a;
    }

    .co-view {
        border-radius: 10px;
        font-weight: 700;
        padding: 10px 16px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #fff;
        background: linear-gradient(90deg, var(--co-primary) 0%, var(--co-accent) 100%);
        transition: all .2s ease;
    }

    .co-view:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(15, 75, 191, .14);
    }

    .co-empty {
        text-align: center;
        padding: 38px 20px;
        color: #64748b;
    }

    .co-empty i {
        font-size: 38px;
        color: #94a3b8;
        margin-bottom: 10px;
        display: inline-block;
    }

    .co-empty-title {
        margin: 0 0 5px;
        color: #0f172a;
        font-size: 17px;
        font-weight: 700;
    }

    .co-empty-text {
        margin: 0 0 16px;
        color: #64748b;
        font-size: 14px;
    }

    .co-pagination {
        padding-top: 18px;
    }

    .co-pagination .pagination {
        justify-content: center;
    }

    .co-pagination .page-link {
        border-radius: 10px;
        margin: 0 4px;
        color: var(--co-primary);
        font-weight: 700;
        box-shadow: none;
    }

    .co-pagination .page-item.active .page-link {
        background: var(--co-primary);
        border-color: var(--co-primary);
        color: #fff;
    }

    @media (max-width: 992px) {
        .customer-orders {
            max-width: 100%;
            padding: 8px 12px 24px;
        }

        .co-title {
            font-size: 28px;
        }

        .co-subtitle {
            font-size: 15px;
        }

        .co-stat-value {
            font-size: 32px;
        }

        .co-panel-title {
            font-size: 18px;
        }

        .co-order {
            grid-template-columns: 1fr;
        }

        .co-order-side {
            min-width: 0;
            align-items: flex-start;
        }
    }

    @media (max-width: 576px) {
        .co-hero {
            padding: 18px;
        }

        .co-title {
            font-size: 24px;
        }

        .co-actions {
            width: 100%;
        }

        .co-btn-primary,
        .co-btn-outline,
        .co-view {
            width: 100%;
            justify-content: center;
        }

        .co-panel-head {
            flex-direction: column;
            align-items: flex-start;
        }

        .co-tab,
        .co-filter {
            width: 100%;
            justify-content: center;
        }

        .co-order-footer {
            flex-direction: column;
            align-items: flex-start;
        }

        .co-mini-table td:last-child {
            text-align: start;
        }
    }
</style>
@endsection

@section('content')
@php
    $isAr = app()->getLocale() === 'ar';

    $tab = request()->route('page_type', 'all') ?? 'all';
    $paymentStatus = (string) request('payment_status', '');
    $status = (string) request('status', '');

    $baseQuery = [];

    if ($paymentStatus !== '') {
        $baseQuery['payment_status'] = $paymentStatus;
    }

    if ($status !== '') {
        $baseQuery['status'] = $status;
    }

    $buildUrl = function (string $pageType, array $changes = []) use ($baseQuery) {
        $query = $baseQuery;

        foreach ($changes as $key => $value) {
            if ($value === null || $value === '') {
                unset($query[$key]);
            } else {
                $query[$key] = $value;
            }
        }

        $url = route('user/myorders', $pageType);

        return $query ? $url . '?' . http_build_query($query) : $url;
    };

    $primaryTabs = [
        [
            'key' => 'all',
            'label' => __('products.all_orders'),
            'icon' => 'bi-grid-1x2-fill',
        ],
        [
            'key' => 'purchase-orders',
            'label' => __('products.purchase_orders'),
            'icon' => 'bi-bag-check',
        ],
        [
            'key' => 'quotations',
            'label' => __('products.quotations'),
            'icon' => 'bi-file-earmark-text',
        ],
        [
            'key' => 'maintenances',
            'label' => __('products.maintenance'),
            'icon' => 'bi-tools',
        ],
        [
            'key' => 'scheduled-orders',
            'label' => __('products.scheduled_orders'),
            'icon' => 'bi-calendar-check',
        ],
    ];

    $orderCount = isset($orders) && method_exists($orders, 'total')
        ? $orders->total()
        : (isset($orders) ? $orders->count() : 0);

    $currentTabLabel = collect($primaryTabs)->firstWhere('key', $tab)['label'] ?? __('products.all_orders');
@endphp

<main class="customer-orders">
    @include('flash::message')

    <nav class="co-breadcrumb">
        <a href="{{ route('user/dashboard') }}">{{ __('products.home') }}</a>
        <i class="bi bi-chevron-{{ $isAr ? 'left' : 'right' }}"></i>
        <span class="active">{{ __('products.my_orders') }}</span>
    </nav>

    @if ($errors->any())
        <div class="co-card mb-4">
            <div class="co-body">
                <ul class="mb-0" dir="ltr">
                    @foreach ($errors->all() as $error)
                        <li class="text-danger fw-semibold small">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <section class="co-card co-hero">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h3 class="co-title">{{ __('products.my_orders') }}</h3>

                <p class="co-subtitle">
                    {{ __('products.order_stages_info') }}
                </p>
            </div>

            <div class="co-actions">
                <a href="{{ route('user/dashboard') }}" class="co-btn-outline">
                    <i class="bi bi-grid-1x2-fill"></i>
                    {{ __('nav.dashboard') }}
                </a>

                <a href="{{ route('products') }}" class="co-btn-primary">
                    <i class="bi bi-cart-plus"></i>
                    {{ __('products.browse_products') }}
                </a>
            </div>
        </div>
    </section>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
            <div class="co-card co-stat">
                <p class="co-stat-label">{{ __('products.total_orders') }}</p>
                <h4 class="co-stat-value">{{ number_format($orderCount) }}</h4>
            </div>
        </div>

        <div class="col-6 col-md-4">
            <div class="co-card co-stat">
                <p class="co-stat-label">{{ __('products.current_tab') }}</p>
                <h4 class="co-stat-value" style="font-size: 24px;">{{ $currentTabLabel }}</h4>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="co-card co-stat">
                <p class="co-stat-label">{{ __('products.active_filters') }}</p>
                <h4 class="co-stat-value" style="font-size: 24px;">
                    @if($paymentStatus !== '' || $status !== '')
                        {{ __('products.filtered') }}
                    @else
                        {{ __('nav.all') }}
                    @endif
                </h4>
            </div>
        </div>
    </div>

    <section class="co-card mb-4">
        <div class="co-panel-head">
            <div>
                <h5 class="co-panel-title">{{ __('products.filter') }}</h5>
                <p class="co-panel-subtitle">
                    {{ __('products.filter_description') }}
                </p>
            </div>

            <span class="co-chip co-chip-primary">
                <i class="bi bi-bag-check"></i>
                {{ number_format($orderCount) }}
                {{ __('products.my_orders') }}
            </span>
        </div>

        <div class="co-body">
            <div class="co-tabs">
                @foreach($primaryTabs as $item)
                    <a href="{{ $buildUrl($item['key']) }}" class="co-tab {{ $tab === $item['key'] ? 'is-active' : '' }}">
                        <i class="bi {{ $item['icon'] }}"></i>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>

            <div class="co-filter-row">
                <a href="{{ $buildUrl($tab, ['payment_status' => null, 'status' => null]) }}" class="co-filter {{ $paymentStatus === '' && $status === '' ? 'is-active' : '' }}">
                    <i class="bi bi-grid"></i>
                    {{ __('nav.all') }}
                </a>

                <a href="{{ $buildUrl($tab, ['payment_status' => 1, 'status' => null]) }}" class="co-filter {{ $paymentStatus === '1' ? 'is-active' : '' }}">
                    <i class="bi bi-check2-circle"></i>
                    {{ __('products.paid') }}
                </a>

                <a href="{{ $buildUrl($tab, ['payment_status' => 0, 'status' => null]) }}" class="co-filter {{ $paymentStatus === '0' ? 'is-active' : '' }}">
                    <i class="bi bi-hourglass-split"></i>
                    {{ __('products.unpaid') }}
                </a>

                <a href="{{ $buildUrl($tab, ['status' => 'processing', 'payment_status' => null]) }}" class="co-filter {{ $status === 'processing' ? 'is-active' : '' }}">
                    <i class="bi bi-arrow-repeat"></i>
                    {{ __('products.processing') }}
                </a>

                <a href="{{ $buildUrl($tab, ['status' => 'completed', 'payment_status' => null]) }}" class="co-filter {{ $status === 'completed' ? 'is-active' : '' }}">
                    <i class="bi bi-check2-all"></i>
                    {{ __('products.completed') }}
                </a>

                <a href="{{ $buildUrl($tab, ['status' => 'scheduled', 'payment_status' => null]) }}" class="co-filter {{ $status === 'scheduled' ? 'is-active' : '' }}">
                    <i class="bi bi-calendar-check"></i>
                    {{ __('products.scheduled_orders') }}
                </a>

                @if($paymentStatus !== '' || $status !== '')
                    <a href="{{ $buildUrl($tab, ['payment_status' => null, 'status' => null]) }}" class="co-filter">
                        <i class="bi bi-arrow-clockwise"></i>
                        {{ __('nav.reset') }}
                    </a>
                @endif
            </div>
        </div>
    </section>

    @include('front.partials.order-workflow-hint', ['role' => 'customer', 'activeTab' => $tab])

    <div class="row g-4 mt-1">
        <div class="col-lg-8">
            <section class="co-card">
                <div class="co-panel-head">
                    <div>
                        <h5 class="co-panel-title">{{ __('products.orders_list') }}</h5>
                        <p class="co-panel-subtitle">
                            {{ __('products.orders_list_desc') }}
                        </p>
                    </div>

                    <span class="co-chip co-chip-primary">
                        <i class="bi bi-list-check"></i>
                        {{ number_format($orderCount) }}
                        {{ __('products.my_orders') }}
                    </span>
                </div>

                <div class="co-body">
                    @if(isset($orders) && $orders->count())
                        @foreach($orders as $order)
                            @php
                                $statusState = $order->front_status_state ?? ['key' => 'pending', 'text' => __('products.pending')];
                                $statusKey = $statusState['key'] ?? 'pending';
                                $statusLabel = $statusState['text'] ?? __('products.pending');
                                $statusClass = orderStatusChipClass($statusKey);

                                $paymentPaid = (int) ($order->payment_status ?? 0) === 1;
                                $paymentLabel = $paymentPaid ? __('products.paid') : __('products.unpaid');
                                $paymentClass = $paymentPaid ? 'confirmed' : 'pending';
                            @endphp

                            <article class="co-order">
                                <div>
                                    <div class="co-order-type">
                                        <i class="bi bi-box-seam"></i>
                                        {{ orderType($order->order_type) }}
                                    </div>

                                    <h5 class="co-order-title">
                                        {{ __('products.order_number_label') }} #{{ $order->id }}
                                    </h5>

                                    <p class="co-order-meta">
                                        <span>
                                            <i class="bi bi-calendar2-week"></i>
                                            {{ optional($order->created_at)->translatedFormat('M d, Y') }}
                                        </span>

                                        <span>
                                            <i class="bi bi-person-badge"></i>
                                            {{ __('products.supplier_label') }}:
                                            {{ $order->provider?->name ?? '-' }}
                                        </span>
                                    </p>
                                </div>

                                <div class="co-order-side">
                                    <span class="co-badge co-badge--{{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>

                                    <span class="co-badge co-badge--{{ $paymentClass }}">
                                        {{ $paymentLabel }}
                                    </span>

                                    <div class="co-price">
                                        {{ number_format((float)($order->total_cost ?? 0), 2) }}
                                        {{ __('products.currency_sar') }}
                                    </div>
                                </div>

                                <div class="co-order-footer">
                                    <table class="co-mini-table">
                                        <tr>
                                            <td>{{ __('products.total_label') }}</td>
                                            <td>
                                                {{ number_format((float)($order->total_cost ?? 0), 2) }}
                                                {{ __('products.currency_sar') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('products.supplier_label') }}</td>
                                            <td>{{ $order->provider?->name ?? '-' }}</td>
                                        </tr>
                                    </table>

                                    <a href="{{ route('user/get/order', $order->id) }}" class="co-view">
                                        <i class="bi bi-eye"></i>
                                        {{ __('products.view_details') }}
                                    </a>
                                </div>
                            </article>
                        @endforeach

                        @if(isset($orders) && method_exists($orders, 'hasPages') && $orders->hasPages())
                            <div class="co-pagination">
                                {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    @else
                        <div class="co-empty">
                            <i class="bi bi-inbox"></i>

                            <h5 class="co-empty-title">
                                {{ __('products.no_orders_title') }}
                            </h5>

                            <p class="co-empty-text">
                                {{ __('products.no_orders_text') }}
                            </p>

                            <a href="{{ route('products') }}" class="co-btn-primary">
                                <i class="bi bi-cart-plus"></i>
                                {{ __('products.browse_products') }}
                            </a>
                        </div>
                    @endif
                </div>
            </section>
        </div>

        <div class="col-lg-4">
            <section class="co-card mb-4">
                <div class="co-panel-head">
                    <div>
                        <h5 class="co-panel-title">{{ __('products.view_summary') }}</h5>
                        <p class="co-panel-subtitle">
                            {{ __('products.view_summary_desc') }}
                        </p>
                    </div>
                </div>

                <div class="co-body">
                    <table class="co-mini-table">
                        <tr>
                            <td>{{ __('products.tab') }}</td>
                            <td>{{ $currentTabLabel }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('products.orders_count') }}</td>
                            <td>{{ number_format($orderCount) }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('products.payment') }}</td>
                            <td>
                                @if($paymentStatus === '1')
                                    {{ __('products.paid') }}
                                @elseif($paymentStatus === '0')
                                    {{ __('products.unpaid') }}
                                @else
                                    {{ __('nav.all') }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('nav.status') }}</td>
                            <td>{{ $status !== '' ? $status : __('nav.all') }}</td>
                        </tr>
                    </table>
                </div>
            </section>

            <section class="co-card">
                <div class="co-panel-head">
                    <div>
                        <h5 class="co-panel-title">{{ __('nav.quick_actions') }}</h5>
                        <p class="co-panel-subtitle">
                            {{ __('products.quick_actions_desc') }}
                        </p>
                    </div>
                </div>

                <div class="co-body d-flex flex-column gap-2">
                    <a href="{{ route('products') }}" class="co-btn-primary justify-content-center">
                        <i class="bi bi-cart-plus"></i>
                        {{ __('products.browse_products') }}
                    </a>

                    <a href="{{ route('user/dashboard') }}" class="co-btn-outline justify-content-center">
                        <i class="bi bi-grid-1x2-fill"></i>
                        {{ __('nav.dashboard') }}
                    </a>
                </div>
            </section>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
    $(function(){
        $('#nav-orders').addClass('active');
    });
</script>
@endsection
