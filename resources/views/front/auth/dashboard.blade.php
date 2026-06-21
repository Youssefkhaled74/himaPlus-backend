@extends('layouts.front.home')

@section('title')
<title>{{ app()->getLocale() === 'ar' ? 'لوحة العميل' : 'Customer Dashboard' }}</title>
@endsection

@section('css')
<style>
    .cust-dash {
        --cd-primary: #0ea5a4;
        --cd-primary-dark: #0c8f8e;
        --cd-gradient: linear-gradient(135deg, #11c5b6 0%, #0ea5a4 100%);
        --cd-bg: #f3f6fc;
        --cd-card-bg: #ffffff;
        --cd-border: #e2e8f0;
        --cd-title: #0f2f7f;
        --cd-text: #1f2937;
        --cd-muted: #6b7280;
        margin-top: 1.5rem;
        margin-bottom: 3rem;
    }

    .cd-hero {
        background: var(--cd-gradient);
        border-radius: 18px;
        padding: 2rem 2.2rem;
        color: #fff;
        position: relative;
        overflow: hidden;
    }
    .cd-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='400' height='400' viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.06'%3E%3Ccircle cx='100' cy='100' r='120'/%3E%3Ccircle cx='300' cy='300' r='180'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") no-repeat;
        pointer-events: none;
    }
    .cd-hero * { position: relative; z-index: 1; }
    .cd-hero__title {
        font-weight: 800;
        font-size: 1.5rem;
        margin-bottom: .3rem;
    }
    .cd-hero__sub {
        opacity: .85;
        font-size: .92rem;
        margin-bottom: 0;
    }
    .cd-hero .btn-outline-light {
        border: 1.5px solid rgba(255,255,255,.55);
        backdrop-filter: blur(4px);
        font-weight: 700;
        border-radius: 10px;
        padding: .5rem 1.4rem;
        font-size: .88rem;
        transition: all .2s;
    }
    .cd-hero .btn-outline-light:hover {
        background: rgba(255,255,255,.18);
        border-color: rgba(255,255,255,.85);
        color: #fff;
    }

    .cd-stat {
        background: var(--cd-card-bg);
        border: 1px solid var(--cd-border);
        border-radius: 14px;
        padding: 1.1rem 1.2rem;
        height: 100%;
        transition: all .25s cubic-bezier(.22,.68,0,1.2);
        display: flex;
        align-items: center;
        gap: .9rem;
        text-decoration: none;
        color: inherit;
    }
    .cd-stat:hover {
        box-shadow: 0 8px 24px rgba(14,165,164,.12);
        border-color: #b8e6e5;
        transform: translateY(-2px);
    }
    .cd-stat__icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
        background: var(--cd-gradient);
        color: #fff;
    }
    .cd-stat__body .label {
        font-size: .78rem;
        color: var(--cd-muted);
        margin-bottom: 2px;
    }
    .cd-stat__body .value {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--cd-title);
        line-height: 1.1;
    }

    .cd-section-title {
        font-weight: 700;
        color: var(--cd-title);
        margin-bottom: 1rem;
        font-size: 1.05rem;
    }

    .cd-card {
        background: var(--cd-card-bg);
        border: 1px solid var(--cd-border);
        border-radius: 16px;
        padding: 1.3rem 1.4rem;
        height: 100%;
    }
    .cd-card__header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: .7rem;
    }
    .cd-card__header strong {
        font-size: .95rem;
        color: var(--cd-title);
    }
    .cd-card__header a {
        font-size: .82rem;
        color: var(--cd-primary);
        text-decoration: none;
        font-weight: 600;
        transition: opacity .15s;
    }
    .cd-card__header a:hover { opacity: .7; }

    .cd-item {
        display: flex;
        align-items: center;
        gap: .7rem;
        padding: .65rem 0;
        border-bottom: 1px solid #edf2f7;
        text-decoration: none;
        color: inherit;
        transition: background .12s;
    }
    .cd-item:last-of-type { border-bottom: 0; padding-bottom: 0; }
    .cd-item:first-of-type { padding-top: 0; }
    .cd-item__avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }
    .cd-item__body { flex: 1; min-width: 0; }
    .cd-item__title {
        font-weight: 600;
        color: var(--cd-text);
        font-size: .87rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .cd-item__meta {
        font-size: .75rem;
        color: var(--cd-muted);
    }
    .cd-item .badge {
        font-size: .72rem;
        font-weight: 700;
        padding: .25em .7em;
        border-radius: 999px;
        flex-shrink: 0;
    }
    .badge-cd-paid { background: #d1fae5; color: #065f46; }
    .badge-cd-pending { background: #fef3c7; color: #92400e; }

    .cd-market-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: .75rem;
    }
    .cd-market-item {
        display: flex;
        align-items: center;
        gap: .6rem;
        padding: .75rem 1rem;
        border: 1px solid var(--cd-border);
        border-radius: 12px;
        text-decoration: none;
        color: var(--cd-text);
        font-weight: 600;
        font-size: .85rem;
        transition: all .2s;
        background: var(--cd-card-bg);
    }
    .cd-market-item:hover {
        border-color: #b8e6e5;
        box-shadow: 0 4px 14px rgba(14,165,164,.08);
        color: var(--cd-primary);
    }
    .cd-market-item .icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
        background: #eef2f9;
        color: var(--cd-title);
        transition: background .2s;
    }
    .cd-market-item:hover .icon {
        background: var(--cd-gradient);
        color: #fff;
    }

    .cd-help {
        background: var(--cd-card-bg);
        border: 1px solid var(--cd-border);
        border-radius: 16px;
        padding: 1.3rem 1.4rem;
    }
    .cd-help__title {
        font-weight: 700;
        color: var(--cd-title);
        margin-bottom: .7rem;
        font-size: .95rem;
    }
    .cd-help__item {
        font-size: .82rem;
        color: var(--cd-muted);
        padding: .45rem 0;
        border-bottom: 1px solid #edf2f7;
        display: flex;
        gap: .5rem;
        align-items: flex-start;
    }
    .cd-help__item:last-child { border-bottom: 0; padding-bottom: 0; }
    .cd-help__item i {
        color: var(--cd-primary);
        font-size: .75rem;
        margin-top: .25rem;
        flex-shrink: 0;
    }

    @media (max-width: 767.98px) {
        .cust-dash { margin-top: .5rem; }
        .cd-hero { padding: 1.2rem 1rem; }
        .cd-hero__title { font-size: 1.15rem; }
        .cd-stat { padding: .85rem 1rem; }
        .cd-stat__body .value { font-size: 1.25rem; }
        .cd-stat__icon { width: 38px; height: 38px; font-size: 1.1rem; }
        .cd-market-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endsection

@section('content')
<main class="container cust-dash">
    @include('flash::message')
    @if ($errors->any())
        <div class="mb-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li class="text-danger">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="cd-hero mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h4 class="cd-hero__title">{{ app()->getLocale() === 'ar' ? 'مرحباً بعودتك 👋' : 'Welcome back 👋' }}</h4>
                <p class="cd-hero__sub">
                    {{ app()->getLocale() === 'ar'
                        ? 'تابع طلباتك، فواتيرك، وإشعاراتك من مكان واحد.'
                        : 'Track your orders, invoices, and notifications in one place.' }}
                </p>
            </div>
            <a href="{{ route('products') }}" class="btn btn-outline-light">
                <i class="bi bi-grid-3x3-gap-fill me-1"></i>
                {{ app()->getLocale() === 'ar' ? 'تصفح المنتجات' : 'Browse Products' }}
            </a>
        </div>
    </section>

    <section class="row g-3 mb-4">
        <div class="col-6 col-md-4 col-xl-2">
            <a href="{{ route('user/myorders', 'all') }}" class="cd-stat">
                <div class="cd-stat__icon"><i class="bi bi-bag-check-fill"></i></div>
                <div class="cd-stat__body">
                    <div class="label">{{ app()->getLocale() === 'ar' ? 'طلباتي' : 'Orders' }}</div>
                    <div class="value">{{ $counts['orders'] }}</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <a href="{{ route('user/myorders', 'all') }}" class="cd-stat">
                <div class="cd-stat__icon"><i class="bi bi-receipt-cutoff"></i></div>
                <div class="cd-stat__body">
                    <div class="label">{{ app()->getLocale() === 'ar' ? 'مدفوعة' : 'Paid' }}</div>
                    <div class="value">{{ $counts['paid_invoices'] }}</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <a href="{{ route('user/myorders', 'all') }}" class="cd-stat">
                <div class="cd-stat__icon"><i class="bi bi-hourglass-split"></i></div>
                <div class="cd-stat__body">
                    <div class="label">{{ app()->getLocale() === 'ar' ? 'معلقة' : 'Pending' }}</div>
                    <div class="value">{{ $counts['pending_orders'] }}</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <a href="{{ route('user/favorites') }}" class="cd-stat">
                <div class="cd-stat__icon"><i class="bi bi-heart-fill"></i></div>
                <div class="cd-stat__body">
                    <div class="label">{{ app()->getLocale() === 'ar' ? 'المفضلة' : 'Favorites' }}</div>
                    <div class="value">{{ $counts['favorites'] }}</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <a href="javascript:void(0)" class="cd-stat">
                <div class="cd-stat__icon"><i class="bi bi-bell-fill"></i></div>
                <div class="cd-stat__body">
                    <div class="label">{{ app()->getLocale() === 'ar' ? 'الإشعارات' : 'Notifications' }}</div>
                    <div class="value">{{ $counts['notifications'] }}</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <a href="{{ route('user/myorders', 'all') }}" class="cd-stat">
                <div class="cd-stat__icon"><i class="bi bi-truck"></i></div>
                <div class="cd-stat__body">
                    <div class="label">{{ app()->getLocale() === 'ar' ? 'متابعة' : 'Tracking' }}</div>
                    <div class="value">{{ $counts['orders'] }}</div>
                </div>
            </a>
        </div>
    </section>

    <section class="mb-4">
        <h5 class="cd-section-title">{{ app()->getLocale() === 'ar' ? 'أقسام السوق' : 'Marketplace Sections' }}</h5>
        <div class="cd-market-grid">
            <a class="cd-market-item" href="{{ route('products') }}">
                <span class="icon"><i class="bi bi-capsule"></i></span>
                {{ app()->getLocale() === 'ar' ? 'المستلزمات الطبية' : 'Medical Supplies' }}
            </a>
            <a class="cd-market-item" href="{{ route('providers') }}">
                <span class="icon"><i class="bi bi-building"></i></span>
                {{ app()->getLocale() === 'ar' ? 'الشركات الصناعية' : 'Industrial Companies' }}
            </a>
            <a class="cd-market-item" href="{{ route('providers') }}">
                <span class="icon"><i class="bi bi-people-fill"></i></span>
                {{ app()->getLocale() === 'ar' ? 'الموردين والبائعين' : 'Suppliers / Vendors' }}
            </a>
            <a class="cd-market-item" href="{{ route('categories') }}">
                <span class="icon"><i class="bi bi-hospital-fill"></i></span>
                {{ app()->getLocale() === 'ar' ? 'المراكز والخدمات الطبية' : 'Medical Centers & Services' }}
            </a>
        </div>
    </section>

    <section class="row g-4">
        <div class="col-lg-6">
            <div class="cd-card">
                <div class="cd-card__header">
                    <strong><i class="bi bi-clock-history me-1"></i>{{ app()->getLocale() === 'ar' ? 'الطلبات الأخيرة' : 'Recent Orders' }}</strong>
                    <a href="{{ route('user/myorders','all') }}">{{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View all' }} <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i></a>
                </div>
                <div>
                    @forelse($orders as $order)
                        <a href="{{ route('user/get/order', $order->id) }}" class="cd-item">
                            <div class="cd-item__body">
                                <div class="cd-item__title">#{{ $order->id }} — {{ $order->provider->name ?? '-' }}</div>
                                <div class="cd-item__meta">{{ optional($order->created_at)->format('Y-m-d') }}</div>
                            </div>
                            <span class="badge {{ (int)($order->payment_status ?? 0) === 1 ? 'badge-cd-paid' : 'badge-cd-pending' }}">
                                {{ (int)($order->payment_status ?? 0) === 1 ? (app()->getLocale() === 'ar' ? 'مدفوع' : 'Paid') : (app()->getLocale() === 'ar' ? 'معلق' : 'Pending') }}
                            </span>
                        </a>
                    @empty
                        <div class="text-muted small py-2">{{ app()->getLocale() === 'ar' ? 'لا توجد طلبات حتى الآن.' : 'No orders yet.' }}</div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-lg-6 d-flex flex-column gap-3">
            <div class="cd-card">
                <div class="cd-card__header">
                    <strong><i class="bi bi-shop me-1"></i>{{ app()->getLocale() === 'ar' ? 'الموردون والشركات' : 'Suppliers & Companies' }}</strong>
                </div>
                <div>
                    @forelse($featuredSuppliers as $supplier)
                        <a href="{{ route('products', ['vendor_name' => $supplier->name]) }}" class="cd-item">
                            <img src="{{ $supplier->img ? asset($supplier->img) : asset('front/assets/images/emptyproducts.png') }}" class="cd-item__avatar" alt="supplier">
                            <div class="cd-item__body">
                                <div class="cd-item__title">{{ $supplier->name }}</div>
                                <div class="cd-item__meta">{{ app()->getLocale() === 'ar' ? 'عرض المنتجات' : 'View products' }}</div>
                            </div>
                            <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}" style="color:var(--cd-muted);"></i>
                        </a>
                    @empty
                        <div class="text-muted small py-2">{{ app()->getLocale() === 'ar' ? 'لا يوجد موردون.' : 'No suppliers.' }}</div>
                    @endforelse
                </div>
            </div>
            @include('front.partials.order-workflow-hint', ['role' => 'customer'])
        </div>
    </section>
</main>
@endsection

@section('script')
<script>
    $(function () {
        $('#nav-dashboard').addClass('active');
    });
</script>
@endsection
