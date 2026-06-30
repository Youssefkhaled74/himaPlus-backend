@extends('layouts.front.home')

@section('title')
    <title>{{ __('products.my_orders_title') }}</title>
@endsection

@section('css')
    <style>
        .cust-orders{
            --brand-primary:#0f4bbf;
            --brand-accent:#10c7a5;
            --orders-bg:#f3f7fc;
            --orders-card:#ffffff;
            --orders-border:#d8e3f0;
            --orders-title:#10203a;
            --orders-text:#1f2937;
            --orders-muted:#6d7d93;
            --orders-shadow:0 14px 35px rgba(15, 75, 191, .08);
            --orders-shadow-hover:0 18px 45px rgba(15, 75, 191, .13);
            margin-top:1.25rem;
            margin-bottom:3rem;
            color:var(--orders-text);
        }
        .cust-orders a{ text-decoration:none; }
        .co-shell{
            background:
                radial-gradient(circle at top left, rgba(16, 199, 165, .10), transparent 34%),
                radial-gradient(circle at top right, rgba(15, 75, 191, .10), transparent 36%),
                var(--orders-bg);
            border:1px solid rgba(216, 227, 240, .8);
            border-radius:26px;
            padding:1.2rem;
        }
        .co-hero{
            background: linear-gradient(135deg, var(--brand-primary) 0%, #1565d8 52%, var(--brand-accent) 100%);
            border-radius:22px;
            padding:1.8rem 2rem;
            color:#fff;
            box-shadow:var(--orders-shadow);
            position:relative;
            overflow:hidden;
        }
        .co-hero::before,
        .co-hero::after{
            content:'';
            position:absolute;
            border-radius:50%;
            background:rgba(255,255,255,.10);
        }
        .co-hero::before{
            width:260px;height:260px;top:-120px;{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}:-80px;
        }
        .co-hero::after{
            width:160px;height:160px;bottom:-90px;{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}:18%;
        }
        .co-hero > *{ position:relative; z-index:2; }
        .co-hero__eyebrow{
            display:inline-flex;align-items:center;gap:.45rem;background:rgba(255,255,255,.15);
            border:1px solid rgba(255,255,255,.24);border-radius:999px;padding:.34rem .8rem;
            font-size:.78rem;font-weight:700;margin-bottom:.85rem;backdrop-filter: blur(8px);
        }
        .co-hero__title{ font-weight:850;font-size:1.55rem;margin-bottom:.35rem;letter-spacing:-.02em; }
        .co-hero__sub{ opacity:.92;font-size:.94rem;margin-bottom:0;max-width:760px;line-height:1.7; }
        .co-hero__actions{ display:flex;flex-wrap:wrap;gap:.7rem;justify-content:flex-end;align-items:center; }
        .co-btn{
            border-radius:13px;padding:.62rem 1.05rem;font-size:.88rem;font-weight:800;display:inline-flex;
            align-items:center;gap:.45rem;transition:all .2s ease;box-shadow:0 10px 24px rgba(16, 32, 58, .12);
        }
        .co-btn-light{ background:#fff;color:var(--brand-primary);border:1px solid rgba(255,255,255,.55); }
        .co-btn-light:hover{ transform:translateY(-1px); color:var(--brand-primary); }
        .co-btn-ghost{ background:rgba(255,255,255,.08);color:#fff;border:1px solid rgba(255,255,255,.34);box-shadow:none; }
        .co-btn-ghost:hover{ background:rgba(255,255,255,.16); color:#fff; }
        .co-card{
            background:var(--orders-card);border:1px solid var(--orders-border);border-radius:20px;
            box-shadow:0 8px 22px rgba(16, 32, 58, .04);overflow:hidden;
        }
        .co-card__head{
            padding:1rem 1.1rem .75rem;display:flex;flex-wrap:wrap;justify-content:space-between;gap:.75rem;
            align-items:center;border-bottom:1px solid rgba(216, 227, 240, .65);
        }
        .co-card__title{
            margin:0;font-size:1rem;font-weight:850;color:var(--orders-title);display:flex;align-items:center;gap:.55rem;
        }
        .co-card__title .icon{
            width:34px;height:34px;border-radius:12px;display:grid;place-items:center;background:var(--orders-bg);color:var(--brand-primary);
        }
        .co-tab-row,.co-filter-row{ display:flex;flex-wrap:wrap;gap:.55rem;padding:1rem 1.1rem 1.1rem; }
        .co-tab-row{ border-bottom:1px solid rgba(216, 227, 240, .55); }
        .co-tab,.co-filter{
            border:1px solid #d9e4f0;background:#f9fbff;color:#29405f;border-radius:14px;padding:.75rem .95rem;
            min-width:160px;transition:all .2s ease;
        }
        .co-filter{ min-width:unset;padding:.65rem .9rem;border-radius:999px;font-size:.88rem;font-weight:750; }
        .co-tab:hover,.co-filter:hover{
            border-color:rgba(15, 75, 191, .24);color:var(--brand-primary);transform:translateY(-1px);
            box-shadow:0 8px 18px rgba(15, 75, 191, .08);
        }
        .co-tab.active,.co-filter.active{
            background:linear-gradient(135deg, var(--brand-primary), var(--brand-accent));color:#fff;border-color:transparent;
            box-shadow:0 12px 26px rgba(15, 75, 191, .14);
        }
        .co-tab__label{ display:block;font-size:.9rem;font-weight:850; }
        .co-tab__hint{ display:block;margin-top:.15rem;font-size:.74rem;opacity:.8; }
        .co-list{ display:grid;gap:.9rem; }
        .co-order{
            background:#fff;border:1px solid var(--orders-border);border-radius:20px;padding:1rem 1.05rem;
            box-shadow:0 8px 20px rgba(16, 32, 58, .04);transition:all .22s ease;
        }
        .co-order:hover{ transform:translateY(-2px);border-color:rgba(15, 75, 191, .24);box-shadow:var(--orders-shadow-hover); }
        .co-order__top{ display:flex;justify-content:space-between;gap:1rem;align-items:flex-start; }
        .co-order__type{
            display:inline-flex;align-items:center;gap:.4rem;border-radius:999px;background:var(--orders-bg);color:var(--brand-primary);
            font-size:.76rem;font-weight:800;padding:.33rem .7rem;margin-bottom:.45rem;
        }
        .co-order__title{ margin:0;color:var(--orders-title);font-weight:850;font-size:1rem; }
        .co-order__meta{
            display:flex;flex-wrap:wrap;gap:.7rem 1rem;margin-top:.55rem;color:var(--orders-muted);font-size:.85rem;
        }
        .co-order__meta span{ display:inline-flex;align-items:center;gap:.35rem; }
        .co-order__side{
            text-align:end;display:flex;flex-direction:column;gap:.45rem;align-items:flex-end;flex-shrink:0;
        }
        .co-badge{
            display:inline-flex;align-items:center;gap:.35rem;padding:.35rem .72rem;border-radius:999px;font-size:.75rem;
            font-weight:850;border:1px solid transparent;white-space:nowrap;
        }
        .co-badge--confirmed,.co-badge--completed{ background:#dcfce7;color:#166534;border-color:#bbf7d0; }
        .co-badge--inprogress,.co-badge--upcoming{ background:#e0ecff;color:#1d4ed8;border-color:#c7dbff; }
        .co-badge--cancelled{ background:#fee2e2;color:#b91c1c;border-color:#fecaca; }
        .co-badge--pending{ background:#fff7ed;color:#9a3412;border-color:#fed7aa; }
        .co-price{ font-size:1.05rem;font-weight:900;color:var(--orders-title); }
        .co-order__bottom{
            margin-top:1rem;padding-top:.9rem;border-top:1px solid rgba(216, 227, 240, .72);
            display:flex;flex-wrap:wrap;justify-content:space-between;gap:.9rem;align-items:center;
        }
        .co-mini{ min-width:0;display:flex;flex-direction:column;gap:.2rem; }
        .co-mini__label{
            font-size:.74rem;font-weight:800;color:var(--orders-muted);text-transform:uppercase;letter-spacing:.03em;
        }
        .co-mini__value{ font-size:.92rem;font-weight:800;color:var(--orders-title); }
        .co-view{
            border-radius:999px;padding:.6rem 1rem;font-weight:850;color:#fff;background:linear-gradient(135deg, var(--brand-primary), var(--brand-accent));
            border:0;display:inline-flex;align-items:center;gap:.45rem;flex-shrink:0;white-space:nowrap;
        }
        .co-view:hover{ color:#fff; filter:brightness(.99); }
        .co-empty{
            border:1px dashed #cad7e8;border-radius:18px;background:#f8fbff;padding:2rem 1.25rem;text-align:center;color:var(--orders-muted);
        }
        .co-empty__icon{
            width:48px;height:48px;border-radius:16px;display:inline-flex;align-items:center;justify-content:center;
            background:var(--orders-bg);color:var(--brand-primary);margin-bottom:.65rem;font-size:1.2rem;
        }
        .co-empty__title{ margin:0 0 .35rem;font-size:1rem;font-weight:850;color:var(--orders-title); }
        .co-empty__text{ margin:0 0 1rem;font-size:.9rem;line-height:1.7; }
        .co-empty__btn{
            display:inline-flex;align-items:center;gap:.45rem;border-radius:13px;padding:.7rem 1rem;background:linear-gradient(135deg, var(--brand-primary), var(--brand-accent));
            color:#fff;font-weight:850;
        }
        .co-pagination{ display:flex;justify-content:center;margin-top:1rem; }
        .co-pagination .pagination{ gap:.4rem;flex-wrap:wrap;justify-content:center; }
        .co-pagination .page-link{
            border-radius:10px !important;border:1px solid #d9e4f0;color:#29405f;padding:.55rem .8rem;font-weight:800;box-shadow:none;
        }
        .co-pagination .page-item.active .page-link{ background:linear-gradient(135deg, var(--brand-primary), var(--brand-accent));border-color:transparent;color:#fff; }
        @media (max-width: 767.98px){
            .cust-orders{ margin-top:.75rem;margin-bottom:2rem; }
            .co-shell{ padding:.75rem;border-radius:20px; }
            .co-hero{ padding:1.25rem;border-radius:18px; }
            .co-hero__title{ font-size:1.2rem; }
            .co-hero__sub{ font-size:.86rem; }
            .co-hero__actions{ width:100%;justify-content:flex-start; }
            .co-btn{ width:100%;justify-content:center; }
            .co-tab{ min-width:calc(50% - .3rem); }
            .co-order__top,.co-order__bottom{ flex-direction:column;align-items:flex-start; }
            .co-order__side{ align-items:flex-start;text-align:start; }
            .co-view{ width:100%;justify-content:center; }
        }
    </style>
@endsection

@section('content')
@php
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
        ['key' => 'all', 'label' => __('products.all_orders'), 'hint' => __('products.workflow_title')],
        ['key' => 'purchase-orders', 'label' => __('products.purchase_orders'), 'hint' => __('products.workflow_purchase')],
        ['key' => 'quotations', 'label' => __('products.quotations'), 'hint' => __('products.workflow_quotation')],
        ['key' => 'maintenances', 'label' => __('products.maintenance'), 'hint' => __('products.workflow_maintenance')],
        ['key' => 'scheduled-orders', 'label' => __('products.scheduled_orders'), 'hint' => __('products.workflow_scheduled')],
    ];

    $orderCount = isset($orders) ? $orders->total() : 0;
@endphp

<main class="container cust-orders">
    @include('flash::message')

    @if ($errors->any())
        <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-3">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li class="small fw-semibold">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="co-shell">
        <section class="co-hero mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <div class="co-hero__eyebrow">
                        <i class="bi bi-stars"></i>
                        {{ __('products.workflow_title') }}
                    </div>
                    <h4 class="co-hero__title">{{ __('products.my_orders') }}</h4>
                    <p class="co-hero__sub">{{ __('products.order_stages_info') }}</p>
                </div>

                <div class="co-hero__actions">
                    <a href="{{ route('products') }}" class="co-btn co-btn-light">
                        <i class="bi bi-grid-3x3-gap-fill"></i>
                        {{ __('products.browse_products') }}
                    </a>
                    <a href="{{ route('user/dashboard') }}" class="co-btn co-btn-ghost">
                        <i class="bi bi-speedometer2"></i>
                        {{ __('nav.dashboard') }}
                    </a>
                </div>
            </div>
        </section>

        <section class="co-card mb-3">
            <div class="co-card__head">
                <h5 class="co-card__title">
                    <span class="icon"><i class="bi bi-funnel"></i></span>
                    {{ __('products.filter') }}
                </h5>
                <span class="badge text-bg-light border rounded-pill px-3 py-2">
                    {{ $orderCount }} {{ __('products.my_orders') }}
                </span>
            </div>

            <div class="co-tab-row">
                @foreach($primaryTabs as $item)
                    <a href="{{ $buildUrl($item['key']) }}" class="co-tab {{ $tab === $item['key'] ? 'active' : '' }}">
                        <span class="co-tab__label">{{ $item['label'] }}</span>
                        <span class="co-tab__hint">{{ $item['hint'] }}</span>
                    </a>
                @endforeach
            </div>

            <div class="co-filter-row">
                <a href="{{ $buildUrl($tab, ['payment_status' => null, 'status' => null]) }}" class="co-filter {{ $paymentStatus === '' && $status === '' ? 'active' : '' }}">
                    {{ __('nav.all') }}
                </a>
                <a href="{{ $buildUrl($tab, ['payment_status' => 1]) }}" class="co-filter {{ $paymentStatus === '1' ? 'active' : '' }}">
                    {{ __('products.paid') }}
                </a>
                <a href="{{ $buildUrl($tab, ['payment_status' => 0]) }}" class="co-filter {{ $paymentStatus === '0' ? 'active' : '' }}">
                    {{ __('products.unpaid') }}
                </a>
                <a href="{{ $buildUrl($tab, ['status' => 'processing']) }}" class="co-filter {{ $status === 'processing' ? 'active' : '' }}">
                    {{ __('products.processing') }}
                </a>
                <a href="{{ $buildUrl($tab, ['status' => 'completed']) }}" class="co-filter {{ $status === 'completed' ? 'active' : '' }}">
                    {{ __('products.completed') }}
                </a>
                <a href="{{ $buildUrl($tab, ['status' => 'scheduled']) }}" class="co-filter {{ $status === 'scheduled' ? 'active' : '' }}">
                    {{ __('products.scheduled_orders') }}
                </a>
                @if($paymentStatus !== '' || $status !== '')
                    <a href="{{ $buildUrl($tab, ['payment_status' => null, 'status' => null]) }}" class="co-filter">
                        {{ __('nav.reset') }}
                    </a>
                @endif
            </div>
        </section>

        @include('front.partials.order-workflow-hint', ['role' => 'customer', 'activeTab' => $tab])

        <section class="co-list">
            @forelse($orders as $order)
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
                    <div class="co-order__top">
                        <div class="flex-grow-1">
                            <div class="co-order__type">
                                <i class="bi bi-box-seam"></i>
                                {{ orderType($order->order_type) }}
                            </div>
                            <h5 class="co-order__title">{{ __('products.order_number_label') }} #{{ $order->id }}</h5>
                            <div class="co-order__meta">
                                <span>
                                    <i class="bi bi-calendar2-week"></i>
                                    {{ optional($order->created_at)->translatedFormat('M d, Y') }}
                                </span>
                                <span>
                                    <i class="bi bi-person-badge"></i>
                                    {{ __('products.supplier_label') }}: {{ $order->provider?->name ?? '-' }}
                                </span>
                            </div>
                        </div>

                        <div class="co-order__side">
                            <span class="co-badge co-badge--{{ $statusClass }}">{{ $statusLabel }}</span>
                            <span class="co-badge co-badge--{{ $paymentClass }}">{{ $paymentLabel }}</span>
                            <div class="co-price">{{ number_format((float)($order->total_cost ?? 0), 2) }} {{ __('products.currency_sar') }}</div>
                        </div>
                    </div>

                    <div class="co-order__bottom">
                        <div class="co-mini">
                            <span class="co-mini__label">{{ __('products.total_label') }}</span>
                            <span class="co-mini__value">{{ number_format((float)($order->total_cost ?? 0), 2) }} {{ __('products.currency_sar') }}</span>
                        </div>

                        <a href="{{ route('user/get/order', $order->id) }}" class="co-view">
                            <i class="bi bi-eye"></i>
                            {{ __('products.view_details') }}
                        </a>
                    </div>
                </article>
            @empty
                <div class="co-empty">
                    <div class="co-empty__icon">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <h5 class="co-empty__title">{{ __('products.no_orders_title') }}</h5>
                    <p class="co-empty__text">{{ __('products.no_orders_text') }}</p>
                    <a href="{{ route('products') }}" class="co-empty__btn">
                        <i class="bi bi-cart-plus"></i>
                        {{ __('products.browse_products') }}
                    </a>
                </div>
            @endforelse
        </section>

        @if(isset($orders) && $orders->hasPages())
            <div class="co-pagination">
                {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        @endif
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
