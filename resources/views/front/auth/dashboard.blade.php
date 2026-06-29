```blade
@extends('layouts.front.home')

@section('title')
<title>{{ app()->getLocale() === 'ar' ? 'لوحة العميل' : 'Customer Dashboard' }}</title>
@endsection

@section('css')
<style>
    .cust-dash {
        --brand-primary: #0f4bbf;
        --brand-primary-dark: #0b3a94;
        --brand-accent: #10c7a5;
        --dash-bg: #f3f7fc;
        --dash-card: #ffffff;
        --dash-border: #d8e3f0;
        --dash-title: #10203a;
        --dash-text: #1f2937;
        --dash-muted: #6d7d93;
        --dash-soft: #eef6ff;
        --dash-soft-accent: #ecfffb;
        --dash-shadow: 0 14px 35px rgba(15, 75, 191, 0.08);
        --dash-shadow-hover: 0 18px 45px rgba(15, 75, 191, 0.13);

        margin-top: 1.5rem;
        margin-bottom: 3rem;
        color: var(--dash-text);
    }

    .cust-dash a {
        text-decoration: none;
    }

    .cd-shell {
        background:
            radial-gradient(circle at top left, rgba(16, 199, 165, .12), transparent 32%),
            radial-gradient(circle at top right, rgba(15, 75, 191, .11), transparent 35%),
            var(--dash-bg);
        border: 1px solid rgba(216, 227, 240, .8);
        border-radius: 26px;
        padding: 1.2rem;
    }

    .cd-hero {
        background: linear-gradient(135deg, var(--brand-primary) 0%, #1565d8 52%, var(--brand-accent) 100%);
        border-radius: 22px;
        padding: 1.8rem 2rem;
        color: #fff;
        position: relative;
        overflow: hidden;
        box-shadow: var(--dash-shadow);
    }

    .cd-hero::before {
        content: '';
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: rgba(255,255,255,.1);
        top: -120px;
        {{ app()->getLocale() === 'ar' ? 'left' : 'right' }}: -80px;
    }

    .cd-hero::after {
        content: '';
        position: absolute;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        background: rgba(255,255,255,.08);
        bottom: -90px;
        {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}: 18%;
    }

    .cd-hero > * {
        position: relative;
        z-index: 2;
    }

    .cd-hero__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        background: rgba(255,255,255,.15);
        border: 1px solid rgba(255,255,255,.22);
        border-radius: 999px;
        padding: .34rem .8rem;
        font-size: .78rem;
        font-weight: 700;
        margin-bottom: .85rem;
        backdrop-filter: blur(8px);
    }

    .cd-hero__title {
        font-weight: 850;
        font-size: 1.55rem;
        margin-bottom: .35rem;
        letter-spacing: -.02em;
    }

    .cd-hero__sub {
        opacity: .9;
        font-size: .93rem;
        margin-bottom: 0;
        max-width: 620px;
        line-height: 1.7;
    }

    .cd-hero__actions {
        display: flex;
        flex-wrap: wrap;
        gap: .7rem;
        align-items: center;
        justify-content: flex-end;
    }

    .cd-btn-light {
        border: 1px solid rgba(255,255,255,.5);
        background: #fff;
        color: var(--brand-primary);
        font-weight: 800;
        border-radius: 13px;
        padding: .62rem 1.1rem;
        font-size: .86rem;
        transition: all .2s ease;
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        box-shadow: 0 10px 24px rgba(16, 32, 58, .12);
    }

    .cd-btn-light:hover {
        color: var(--brand-primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 14px 30px rgba(16, 32, 58, .16);
    }

    .cd-btn-ghost {
        border: 1px solid rgba(255,255,255,.35);
        color: #fff;
        font-weight: 750;
        border-radius: 13px;
        padding: .62rem 1.1rem;
        font-size: .86rem;
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        transition: all .2s ease;
        background: rgba(255,255,255,.08);
    }

    .cd-btn-ghost:hover {
        color: #fff;
        background: rgba(255,255,255,.16);
        border-color: rgba(255,255,255,.55);
    }

    .cd-stats-grid {
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        gap: .9rem;
    }

    .cd-stat {
        background: var(--dash-card);
        border: 1px solid var(--dash-border);
        border-radius: 18px;
        padding: 1rem;
        min-height: 112px;
        height: 100%;
        color: inherit;
        transition: all .22s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 22px rgba(16, 32, 58, .04);
    }

    .cd-stat::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(15, 75, 191, .06), rgba(16, 199, 165, .04));
        opacity: 0;
        transition: opacity .22s ease;
    }

    .cd-stat:hover {
        transform: translateY(-3px);
        border-color: rgba(15, 75, 191, .24);
        box-shadow: var(--dash-shadow-hover);
        color: inherit;
    }

    .cd-stat:hover::before {
        opacity: 1;
    }

    .cd-stat__top,
    .cd-stat__bottom {
        position: relative;
        z-index: 2;
    }

    .cd-stat__top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: .75rem;
        margin-bottom: .9rem;
    }

    .cd-stat__icon {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        flex-shrink: 0;
        background: linear-gradient(135deg, var(--brand-primary), var(--brand-accent));
        color: #fff;
        box-shadow: 0 10px 20px rgba(15, 75, 191, .16);
    }

    .cd-stat__arrow {
        color: #9aa8bd;
        font-size: .95rem;
        margin-top: .2rem;
    }

    .cd-stat__label {
        font-size: .78rem;
        color: var(--dash-muted);
        margin-bottom: .18rem;
        font-weight: 700;
    }

    .cd-stat__value {
        font-size: 1.65rem;
        font-weight: 850;
        color: var(--dash-title);
        line-height: 1;
        letter-spacing: -.03em;
    }

    .cd-stat.is-disabled {
        cursor: default;
    }

    .cd-stat.is-disabled:hover {
        transform: none;
    }

    .cd-section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .cd-section-title {
        display: flex;
        align-items: center;
        gap: .55rem;
        font-weight: 850;
        color: var(--dash-title);
        margin-bottom: 0;
        font-size: 1.02rem;
        letter-spacing: -.01em;
    }

    .cd-section-title .icon {
        width: 34px;
        height: 34px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--brand-primary);
        background: var(--dash-soft);
    }

    .cd-section-link {
        color: var(--brand-primary);
        font-weight: 800;
        font-size: .84rem;
        display: inline-flex;
        align-items: center;
        gap: .25rem;
        transition: opacity .18s ease;
    }

    .cd-section-link:hover {
        color: var(--brand-primary-dark);
        opacity: .85;
    }

    .cd-market-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: .9rem;
    }

    .cd-market-item {
        background: var(--dash-card);
        border: 1px solid var(--dash-border);
        border-radius: 18px;
        padding: 1rem;
        color: var(--dash-text);
        font-weight: 800;
        font-size: .88rem;
        transition: all .22s ease;
        min-height: 96px;
        display: flex;
        align-items: center;
        gap: .85rem;
        box-shadow: 0 8px 22px rgba(16, 32, 58, .04);
    }

    .cd-market-item:hover {
        transform: translateY(-3px);
        border-color: rgba(16, 199, 165, .34);
        box-shadow: var(--dash-shadow-hover);
        color: var(--brand-primary);
    }

    .cd-market-item .icon {
        width: 46px;
        height: 46px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.18rem;
        flex-shrink: 0;
        background: var(--dash-soft-accent);
        color: var(--brand-accent);
        transition: all .22s ease;
    }

    .cd-market-item:hover .icon {
        background: linear-gradient(135deg, var(--brand-primary), var(--brand-accent));
        color: #fff;
        box-shadow: 0 10px 20px rgba(16, 199, 165, .18);
    }

    .cd-market-item small {
        display: block;
        color: var(--dash-muted);
        font-weight: 650;
        margin-top: .2rem;
        font-size: .73rem;
        line-height: 1.35;
    }

    .cd-card {
        background: var(--dash-card);
        border: 1px solid var(--dash-border);
        border-radius: 20px;
        padding: 1.15rem;
        height: 100%;
        box-shadow: 0 8px 22px rgba(16, 32, 58, .04);
    }

    .cd-card__header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        margin-bottom: .95rem;
        padding-bottom: .85rem;
        border-bottom: 1px solid #edf2f7;
    }

    .cd-card__header strong {
        display: flex;
        align-items: center;
        gap: .45rem;
        font-size: .95rem;
        color: var(--dash-title);
        font-weight: 850;
    }

    .cd-card__header strong i {
        color: var(--brand-primary);
    }

    .cd-list {
        display: flex;
        flex-direction: column;
        gap: .55rem;
    }

    .cd-item {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .75rem;
        border: 1px solid transparent;
        border-radius: 15px;
        color: inherit;
        transition: all .18s ease;
        background: #fff;
    }

    .cd-item:hover {
        color: inherit;
        border-color: var(--dash-border);
        background: #f8fbff;
        transform: translateX({{ app()->getLocale() === 'ar' ? '-2px' : '2px' }});
    }

    .cd-item__icon {
        width: 38px;
        height: 38px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--dash-soft);
        color: var(--brand-primary);
        flex-shrink: 0;
        font-size: 1rem;
    }

    .cd-item__avatar {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        object-fit: cover;
        flex-shrink: 0;
        border: 1px solid var(--dash-border);
        background: #f8fafc;
    }

    .cd-item__body {
        flex: 1;
        min-width: 0;
    }

    .cd-item__title {
        font-weight: 800;
        color: var(--dash-text);
        font-size: .88rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: .18rem;
    }

    .cd-item__meta {
        font-size: .75rem;
        color: var(--dash-muted);
        display: flex;
        align-items: center;
        gap: .45rem;
        flex-wrap: wrap;
    }

    .cd-badge {
        font-size: .72rem;
        font-weight: 850;
        padding: .33rem .72rem;
        border-radius: 999px;
        flex-shrink: 0;
        border: 1px solid transparent;
        white-space: nowrap;
    }

    .badge-cd-paid {
        background: #dcfce7;
        color: #166534;
        border-color: #bbf7d0;
    }

    .badge-cd-pending {
        background: #fff7ed;
        color: #9a3412;
        border-color: #fed7aa;
    }

    .cd-chevron {
        color: #a3afc2;
        flex-shrink: 0;
    }

    .cd-empty {
        border: 1px dashed #cad7e8;
        border-radius: 16px;
        background: #f8fbff;
        padding: 1.2rem;
        text-align: center;
        color: var(--dash-muted);
    }

    .cd-empty__icon {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--dash-soft);
        color: var(--brand-primary);
        margin-bottom: .55rem;
        font-size: 1.1rem;
    }

    .cd-empty__text {
        margin: 0;
        font-size: .86rem;
        font-weight: 700;
    }

    .cd-workflow-wrap {
        overflow: hidden;
        border-radius: 20px;
    }

    @media (max-width: 1199.98px) {
        .cd-stats-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .cd-market-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .cust-dash {
            margin-top: .75rem;
            margin-bottom: 2rem;
        }

        .cd-shell {
            padding: .75rem;
            border-radius: 20px;
        }

        .cd-hero {
            padding: 1.25rem;
            border-radius: 18px;
        }

        .cd-hero__title {
            font-size: 1.2rem;
        }

        .cd-hero__sub {
            font-size: .84rem;
        }

        .cd-hero__actions {
            justify-content: flex-start;
            width: 100%;
        }

        .cd-btn-light,
        .cd-btn-ghost {
            width: 100%;
            justify-content: center;
        }

        .cd-stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: .7rem;
        }

        .cd-stat {
            min-height: 104px;
            padding: .85rem;
            border-radius: 16px;
        }

        .cd-stat__icon {
            width: 38px;
            height: 38px;
            border-radius: 13px;
            font-size: 1rem;
        }

        .cd-stat__value {
            font-size: 1.35rem;
        }

        .cd-market-grid {
            grid-template-columns: 1fr;
            gap: .7rem;
        }

        .cd-market-item {
            min-height: auto;
            padding: .85rem;
            border-radius: 16px;
        }

        .cd-card {
            padding: .9rem;
            border-radius: 18px;
        }

        .cd-card__header {
            align-items: flex-start;
        }

        .cd-item {
            padding: .65rem;
        }
    }
</style>
@endsection

@section('content')
<main class="container cust-dash">
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

    <div class="cd-shell">
        <section class="cd-hero mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <div class="cd-hero__eyebrow">
                        <i class="bi bi-stars"></i>
                        {{ app()->getLocale() === 'ar' ? 'لوحة التحكم' : 'Dashboard' }}
                    </div>

                    <h4 class="cd-hero__title">
                        {{ app()->getLocale() === 'ar' ? 'مرحباً بعودتك 👋' : 'Welcome back 👋' }}
                    </h4>

                    <p class="cd-hero__sub">
                        {{ app()->getLocale() === 'ar'
                            ? 'تابع طلباتك، فواتيرك، مفضلاتك، وأقسام السوق من مكان واحد بتجربة أسهل وأوضح.'
                            : 'Track your orders, invoices, favorites, and marketplace sections from one clean place.' }}
                    </p>
                </div>

                <div class="cd-hero__actions">
                    <a href="{{ route('products') }}" class="cd-btn-light">
                        <i class="bi bi-grid-3x3-gap-fill"></i>
                        {{ app()->getLocale() === 'ar' ? 'تصفح المنتجات' : 'Browse Products' }}
                    </a>

                    <a href="{{ route('user/myorders', 'all') }}" class="cd-btn-ghost">
                        <i class="bi bi-bag-check"></i>
                        {{ app()->getLocale() === 'ar' ? 'طلباتي' : 'My Orders' }}
                    </a>
                </div>
            </div>
        </section>

        <section class="cd-stats-grid mb-4">
            <a href="{{ route('user/myorders', 'all') }}" class="cd-stat">
                <div class="cd-stat__top">
                    <div class="cd-stat__icon">
                        <i class="bi bi-bag-check-fill"></i>
                    </div>
                    <i class="bi bi-arrow-up-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} cd-stat__arrow"></i>
                </div>
                <div class="cd-stat__bottom">
                    <div class="cd-stat__label">{{ app()->getLocale() === 'ar' ? 'طلباتي' : 'Orders' }}</div>
                    <div class="cd-stat__value">{{ $counts['orders'] }}</div>
                </div>
            </a>

            <a href="{{ route('user/myorders', 'all') }}" class="cd-stat">
                <div class="cd-stat__top">
                    <div class="cd-stat__icon">
                        <i class="bi bi-receipt-cutoff"></i>
                    </div>
                    <i class="bi bi-arrow-up-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} cd-stat__arrow"></i>
                </div>
                <div class="cd-stat__bottom">
                    <div class="cd-stat__label">{{ app()->getLocale() === 'ar' ? 'مدفوعة' : 'Paid' }}</div>
                    <div class="cd-stat__value">{{ $counts['paid_invoices'] }}</div>
                </div>
            </a>

            <a href="{{ route('user/myorders', 'all') }}" class="cd-stat">
                <div class="cd-stat__top">
                    <div class="cd-stat__icon">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <i class="bi bi-arrow-up-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} cd-stat__arrow"></i>
                </div>
                <div class="cd-stat__bottom">
                    <div class="cd-stat__label">{{ app()->getLocale() === 'ar' ? 'معلقة' : 'Pending' }}</div>
                    <div class="cd-stat__value">{{ $counts['pending_orders'] }}</div>
                </div>
            </a>

            <a href="{{ route('user/favorites') }}" class="cd-stat">
                <div class="cd-stat__top">
                    <div class="cd-stat__icon">
                        <i class="bi bi-heart-fill"></i>
                    </div>
                    <i class="bi bi-arrow-up-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} cd-stat__arrow"></i>
                </div>
                <div class="cd-stat__bottom">
                    <div class="cd-stat__label">{{ app()->getLocale() === 'ar' ? 'المفضلة' : 'Favorites' }}</div>
                    <div class="cd-stat__value">{{ $counts['favorites'] }}</div>
                </div>
            </a>

            <div class="cd-stat is-disabled">
                <div class="cd-stat__top">
                    <div class="cd-stat__icon">
                        <i class="bi bi-bell-fill"></i>
                    </div>
                    <span class="cd-stat__arrow">
                        <i class="bi bi-dot"></i>
                    </span>
                </div>
                <div class="cd-stat__bottom">
                    <div class="cd-stat__label">{{ app()->getLocale() === 'ar' ? 'الإشعارات' : 'Notifications' }}</div>
                    <div class="cd-stat__value">{{ $counts['notifications'] }}</div>
                </div>
            </div>

            <a href="{{ route('user/myorders', 'all') }}" class="cd-stat">
                <div class="cd-stat__top">
                    <div class="cd-stat__icon">
                        <i class="bi bi-truck"></i>
                    </div>
                    <i class="bi bi-arrow-up-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} cd-stat__arrow"></i>
                </div>
                <div class="cd-stat__bottom">
                    <div class="cd-stat__label">{{ app()->getLocale() === 'ar' ? 'متابعة' : 'Tracking' }}</div>
                    <div class="cd-stat__value">{{ $counts['orders'] }}</div>
                </div>
            </a>
        </section>

        <section class="mb-4">
            <div class="cd-section-head">
                <h5 class="cd-section-title">
                    <span class="icon"><i class="bi bi-grid-1x2-fill"></i></span>
                    {{ app()->getLocale() === 'ar' ? 'أقسام السوق' : 'Marketplace Sections' }}
                </h5>
            </div>

            <div class="cd-market-grid">
                <a class="cd-market-item" href="{{ route('products') }}">
                    <span class="icon"><i class="bi bi-capsule"></i></span>
                    <span>
                        {{ app()->getLocale() === 'ar' ? 'المستلزمات الطبية' : 'Medical Supplies' }}
                        <small>{{ app()->getLocale() === 'ar' ? 'تصفح المنتجات المتاحة' : 'Browse available products' }}</small>
                    </span>
                </a>

                <a class="cd-market-item" href="{{ route('providers') }}">
                    <span class="icon"><i class="bi bi-building"></i></span>
                    <span>
                        {{ app()->getLocale() === 'ar' ? 'الشركات الصناعية' : 'Industrial Companies' }}
                        <small>{{ app()->getLocale() === 'ar' ? 'استكشف الشركات والمصنعين' : 'Explore companies and manufacturers' }}</small>
                    </span>
                </a>

                <a class="cd-market-item" href="{{ route('providers') }}">
                    <span class="icon"><i class="bi bi-people-fill"></i></span>
                    <span>
                        {{ app()->getLocale() === 'ar' ? 'الموردين والبائعين' : 'Suppliers / Vendors' }}
                        <small>{{ app()->getLocale() === 'ar' ? 'اعرض الموردين المتاحين' : 'View available suppliers' }}</small>
                    </span>
                </a>

                <a class="cd-market-item" href="{{ route('categories') }}">
                    <span class="icon"><i class="bi bi-hospital-fill"></i></span>
                    <span>
                        {{ app()->getLocale() === 'ar' ? 'المراكز والخدمات الطبية' : 'Medical Centers & Services' }}
                        <small>{{ app()->getLocale() === 'ar' ? 'تصفح الأقسام والخدمات' : 'Browse categories and services' }}</small>
                    </span>
                </a>
            </div>
        </section>

        <section class="row g-4">
            <div class="col-lg-6">
                <div class="cd-card">
                    <div class="cd-card__header">
                        <strong>
                            <i class="bi bi-clock-history"></i>
                            {{ app()->getLocale() === 'ar' ? 'الطلبات الأخيرة' : 'Recent Orders' }}
                        </strong>

                        <a class="cd-section-link" href="{{ route('user/myorders','all') }}">
                            {{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View all' }}
                            <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
                        </a>
                    </div>

                    <div class="cd-list">
                        @forelse($orders as $order)
                            <a href="{{ route('user/get/order', $order->id) }}" class="cd-item">
                                <div class="cd-item__icon">
                                    <i class="bi bi-box-seam"></i>
                                </div>

                                <div class="cd-item__body">
                                    <div class="cd-item__title">
                                        #{{ $order->id }} — {{ $order->provider->name ?? '-' }}
                                    </div>

                                    <div class="cd-item__meta">
                                        <span>
                                            <i class="bi bi-calendar2-week"></i>
                                            {{ optional($order->created_at)->format('Y-m-d') }}
                                        </span>
                                    </div>
                                </div>

                                <span class="cd-badge {{ (int)($order->payment_status ?? 0) === 1 ? 'badge-cd-paid' : 'badge-cd-pending' }}">
                                    {{ (int)($order->payment_status ?? 0) === 1
                                        ? (app()->getLocale() === 'ar' ? 'مدفوع' : 'Paid')
                                        : (app()->getLocale() === 'ar' ? 'معلق' : 'Pending') }}
                                </span>
                            </a>
                        @empty
                            <div class="cd-empty">
                                <div class="cd-empty__icon">
                                    <i class="bi bi-bag-x"></i>
                                </div>
                                <p class="cd-empty__text">
                                    {{ app()->getLocale() === 'ar' ? 'لا توجد طلبات حتى الآن.' : 'No orders yet.' }}
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-lg-6 d-flex flex-column gap-3">
                <div class="cd-card">
                    <div class="cd-card__header">
                        <strong>
                            <i class="bi bi-shop"></i>
                            {{ app()->getLocale() === 'ar' ? 'الموردون والشركات' : 'Suppliers & Companies' }}
                        </strong>

                        <a class="cd-section-link" href="{{ route('providers') }}">
                            {{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View all' }}
                            <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
                        </a>
                    </div>

                    <div class="cd-list">
                        @forelse($featuredSuppliers as $supplier)
                            <a href="{{ route('products', ['vendor_name' => $supplier->name]) }}" class="cd-item">
                                <img
                                    src="{{ $supplier->img ? asset($supplier->img) : asset('front/assets/images/emptyproducts.png') }}"
                                    class="cd-item__avatar"
                                    alt="{{ $supplier->name ?? 'supplier' }}"
                                >

                                <div class="cd-item__body">
                                    <div class="cd-item__title">{{ $supplier->name }}</div>
                                    <div class="cd-item__meta">
                                        <span>
                                            <i class="bi bi-grid-3x3-gap"></i>
                                            {{ app()->getLocale() === 'ar' ? 'عرض المنتجات' : 'View products' }}
                                        </span>
                                    </div>
                                </div>

                                <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} cd-chevron"></i>
                            </a>
                        @empty
                            <div class="cd-empty">
                                <div class="cd-empty__icon">
                                    <i class="bi bi-shop-window"></i>
                                </div>
                                <p class="cd-empty__text">
                                    {{ app()->getLocale() === 'ar' ? 'لا يوجد موردون.' : 'No suppliers.' }}
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="cd-workflow-wrap">
                    @include('front.partials.order-workflow-hint', ['role' => 'customer'])
                </div>
            </div>
        </section>
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
```
