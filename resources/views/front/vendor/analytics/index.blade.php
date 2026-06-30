@extends('layouts.front.home')

@section('title')
    <title>{{ app()->getLocale() === 'ar' ? 'لوحة العميل' : 'Customer Dashboard' }}</title>
@endsection

@section('css')
<style>
    .customer-home {
        --ch-bg: #f5f6f8;
        --ch-card: #ffffff;
        --ch-border: #e7eaf0;
        --ch-title: #0f2f7f;
        --ch-text: #1f2937;
        --ch-muted: #6b7280;
        --ch-primary: #0f4bbf;
        --ch-accent: #0ec6a0;
        --ch-soft: #eef5ff;
        --ch-soft-2: #f4fbf9;

        max-width: 95%;
        margin: 12px auto 0;
        background: var(--ch-bg);
        padding: 8px 0 24px;
        font-family: "Poppins", "Tajawal", system-ui, -apple-system, "Segoe UI", Arial, sans-serif;
    }

    .customer-home * {
        font-family: inherit;
    }

    .ch-card {
        background: var(--ch-card);
        border: 1px solid var(--ch-border);
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.04);
    }

    .ch-breadcrumb {
        font-size: 13px;
        margin-bottom: 12px;
    }

    .ch-breadcrumb a {
        text-decoration: none;
        color: #6b7280;
    }

    .ch-breadcrumb .active {
        color: var(--ch-primary);
        font-weight: 700;
    }

    .ch-hero {
        padding: 22px;
        margin-bottom: 16px;
    }

    .ch-title {
        margin: 0 0 6px;
        color: var(--ch-title);
        font-size: 34px;
        line-height: 1.08;
        font-weight: 800;
        letter-spacing: -0.01em;
    }

    .ch-subtitle {
        margin: 0;
        color: #475569;
        font-size: 16px;
        line-height: 1.55;
        max-width: 760px;
    }

    .ch-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .ch-btn-primary,
    .ch-btn-outline {
        border-radius: 10px;
        font-weight: 700;
        padding: 10px 16px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all .2s ease;
        min-height: 44px;
    }

    .ch-btn-primary {
        border: 0;
        color: #fff;
        background: linear-gradient(90deg, var(--ch-primary) 0%, var(--ch-accent) 100%);
    }

    .ch-btn-primary:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(15, 75, 191, .14);
    }

    .ch-btn-outline {
        border: 1px solid #cbd5e1;
        color: #1e3a8a;
        background: #fff;
    }

    .ch-btn-outline:hover {
        color: #1e3a8a;
        background: var(--ch-soft);
        transform: translateY(-1px);
    }

    .ch-stat {
        padding: 16px 18px;
        height: 100%;
        transition: all .2s ease;
        text-decoration: none;
        display: block;
    }

    .ch-stat:hover {
        border-color: #93c5fd;
        box-shadow: 0 4px 12px rgba(15, 75, 191, .08);
        transform: translateY(-1px);
    }

    .ch-stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: linear-gradient(90deg, var(--ch-primary) 0%, var(--ch-accent) 100%);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        font-size: 18px;
    }

    .ch-stat-label {
        margin: 0;
        color: var(--ch-muted);
        font-size: 13px;
        font-weight: 500;
    }

    .ch-stat-value {
        margin: 8px 0 0;
        color: var(--ch-text);
        font-size: 40px;
        line-height: 1;
        font-weight: 800;
    }

    .ch-panel-head {
        border-bottom: 1px solid var(--ch-border);
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .ch-panel-title {
        margin: 0;
        color: #0f172a;
        font-size: 20px;
        font-weight: 700;
    }

    .ch-panel-subtitle {
        margin: 4px 0 0;
        color: var(--ch-muted);
        font-size: 13px;
    }

    .ch-body {
        padding: 18px;
    }

    .ch-market {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 0;
        text-decoration: none;
        color: inherit;
        transition: all .2s ease;
    }

    .ch-market + .ch-market {
        border-top: 1px solid #edf2f7;
    }

    .ch-market:hover {
        color: inherit;
        transform: translateX({{ app()->getLocale() === 'ar' ? '-2px' : '2px' }});
    }

    .ch-market-icon {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: var(--ch-soft);
        color: var(--ch-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 18px;
    }

    .ch-market-title {
        margin: 0 0 3px;
        font-size: 15px;
        font-weight: 700;
        color: #111827;
    }

    .ch-market-meta {
        margin: 0;
        color: #64748b;
        font-size: 13px;
    }

    .ch-product,
    .ch-order,
    .ch-supplier {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 0;
        text-decoration: none;
        color: inherit;
    }

    .ch-product + .ch-product,
    .ch-order + .ch-order,
    .ch-supplier + .ch-supplier {
        border-top: 1px solid #edf2f7;
    }

    .ch-order:hover,
    .ch-supplier:hover {
        color: inherit;
        transform: translateX({{ app()->getLocale() === 'ar' ? '-2px' : '2px' }});
    }

    .ch-rank {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: linear-gradient(90deg, var(--ch-primary), var(--ch-accent));
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        flex-shrink: 0;
    }

    .ch-avatar {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        object-fit: cover;
        border: 1px solid #e5edf8;
        background: #f8fbff;
        flex-shrink: 0;
    }

    .ch-item-title {
        margin: 0 0 3px;
        font-size: 15px;
        font-weight: 700;
        color: #111827;
    }

    .ch-item-meta {
        margin: 0;
        color: #64748b;
        font-size: 13px;
    }

    .ch-chip {
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

    .ch-chip-primary {
        background: #eaf2ff;
        color: #1d4ed8;
    }

    .ch-chip-success {
        background: #dcfce7;
        color: #166534;
    }

    .ch-chip-warning {
        background: #fff7ed;
        color: #9a3412;
    }

    .ch-empty {
        text-align: center;
        padding: 38px 20px;
        color: #64748b;
    }

    .ch-empty i {
        font-size: 38px;
        color: #94a3b8;
        margin-bottom: 10px;
        display: inline-block;
    }

    .ch-empty-title {
        margin: 0 0 5px;
        color: #0f172a;
        font-size: 17px;
        font-weight: 700;
    }

    .ch-empty-text {
        margin: 0;
        color: #64748b;
        font-size: 14px;
    }

    .ch-summary-table {
        width: 100%;
        border-collapse: collapse;
    }

    .ch-summary-table tr + tr {
        border-top: 1px solid #edf2f7;
    }

    .ch-summary-table td {
        padding: 12px 0;
        font-size: 14px;
        color: #334155;
    }

    .ch-summary-table td:last-child {
        text-align: end;
        font-weight: 800;
        color: #0f172a;
    }

    .ch-workflow-wrap {
        overflow: hidden;
        border-radius: 14px;
    }

    @media (max-width: 992px) {
        .customer-home {
            max-width: 100%;
            padding: 8px 12px 24px;
        }

        .ch-title {
            font-size: 28px;
        }

        .ch-subtitle {
            font-size: 15px;
        }

        .ch-stat-value {
            font-size: 32px;
        }

        .ch-panel-title {
            font-size: 18px;
        }
    }

    @media (max-width: 576px) {
        .ch-hero {
            padding: 18px;
        }

        .ch-title {
            font-size: 24px;
        }

        .ch-actions {
            width: 100%;
        }

        .ch-btn-primary,
        .ch-btn-outline {
            width: 100%;
        }

        .ch-panel-head {
            flex-direction: column;
            align-items: flex-start;
        }

        .ch-summary-table td:last-child {
            text-align: start;
        }
    }
</style>
@endsection

@section('content')
@php
    $isAr = app()->getLocale() === 'ar';

    $ordersCount = $counts['orders'] ?? 0;
    $paidInvoicesCount = $counts['paid_invoices'] ?? 0;
    $processingOrdersCount = $counts['processing_orders'] ?? 0;
    $favoritesCount = $counts['favorites'] ?? 0;
    $notificationsCount = $counts['notifications'] ?? 0;
    $trackingOrdersCount = $counts['tracking_orders'] ?? 0;
@endphp

<main class="customer-home">
    @include('flash::message')

    <nav class="ch-breadcrumb">
        <a href="{{ route('user/dashboard') }}">{{ $isAr ? 'الرئيسية' : 'Home' }}</a>
        <i class="bi bi-chevron-{{ $isAr ? 'left' : 'right' }}"></i>
        <span class="active">{{ $isAr ? 'لوحة العميل' : 'Customer Dashboard' }}</span>
    </nav>

    @if ($errors->any())
        <div class="ch-card mb-4">
            <div class="ch-body">
                <ul class="mb-0" dir="ltr">
                    @foreach ($errors->all() as $error)
                        <li class="text-danger fw-semibold small">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <section class="ch-card ch-hero">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h3 class="ch-title">
                    {{ $isAr ? 'لوحة العميل' : 'Customer Dashboard' }}
                </h3>

                <p class="ch-subtitle">
                    {{ $isAr
                        ? 'تابع طلباتك، فواتيرك، مفضلاتك، والإشعارات من مكان واحد بتصميم واضح وسهل الاستخدام.'
                        : 'Track your orders, invoices, favorites, and notifications from one clean and easy-to-use place.' }}
                </p>
            </div>

            <div class="ch-actions">
                <a href="{{ route('products') }}" class="ch-btn-primary">
                    <i class="bi bi-grid-3x3-gap-fill"></i>
                    {{ $isAr ? 'تصفح المنتجات' : 'Browse Products' }}
                </a>

                <a href="{{ route('user/myorders', 'all') }}" class="ch-btn-outline">
                    <i class="bi bi-bag-check"></i>
                    {{ $isAr ? 'طلباتي' : 'My Orders' }}
                </a>
            </div>
        </div>
    </section>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4 col-xl-2">
            <a href="{{ route('user/myorders', 'all') }}" class="ch-card ch-stat">
                <span class="ch-stat-icon"><i class="bi bi-bag-check-fill"></i></span>
                <p class="ch-stat-label">{{ $isAr ? 'كل الطلبات' : 'All Orders' }}</p>
                <h4 class="ch-stat-value">{{ number_format($ordersCount) }}</h4>
            </a>
        </div>

        <div class="col-6 col-md-4 col-xl-2">
            <a href="{{ route('user/myorders', 'all') }}?payment_status=1" class="ch-card ch-stat">
                <span class="ch-stat-icon"><i class="bi bi-receipt-cutoff"></i></span>
                <p class="ch-stat-label">{{ $isAr ? 'فواتير مدفوعة' : 'Paid Invoices' }}</p>
                <h4 class="ch-stat-value">{{ number_format($paidInvoicesCount) }}</h4>
            </a>
        </div>

        <div class="col-6 col-md-4 col-xl-2">
            <a href="{{ route('user/myorders', 'all') }}?status=processing" class="ch-card ch-stat">
                <span class="ch-stat-icon"><i class="bi bi-hourglass-split"></i></span>
                <p class="ch-stat-label">{{ $isAr ? 'قيد التنفيذ' : 'Processing' }}</p>
                <h4 class="ch-stat-value">{{ number_format($processingOrdersCount) }}</h4>
            </a>
        </div>

        <div class="col-6 col-md-4 col-xl-2">
            <a href="{{ route('user/favorites') }}" class="ch-card ch-stat">
                <span class="ch-stat-icon"><i class="bi bi-heart-fill"></i></span>
                <p class="ch-stat-label">{{ $isAr ? 'المفضلة' : 'Favorites' }}</p>
                <h4 class="ch-stat-value">{{ number_format($favoritesCount) }}</h4>
            </a>
        </div>

        <div class="col-6 col-md-4 col-xl-2">
            <a href="{{ route('user/notifications', [0, PAGINATION_COUNT]) }}" class="ch-card ch-stat">
                <span class="ch-stat-icon"><i class="bi bi-bell-fill"></i></span>
                <p class="ch-stat-label">{{ $isAr ? 'الإشعارات' : 'Notifications' }}</p>
                <h4 class="ch-stat-value">{{ number_format($notificationsCount) }}</h4>
            </a>
        </div>

        <div class="col-6 col-md-4 col-xl-2">
            <a href="{{ route('user/myorders', 'scheduled-orders') }}?status=scheduled" class="ch-card ch-stat">
                <span class="ch-stat-icon"><i class="bi bi-calendar-check"></i></span>
                <p class="ch-stat-label">{{ $isAr ? 'طلبات مجدولة' : 'Scheduled' }}</p>
                <h4 class="ch-stat-value">{{ number_format($trackingOrdersCount) }}</h4>
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <section class="ch-card h-100">
                <div class="ch-panel-head">
                    <div>
                        <h5 class="ch-panel-title">
                            {{ $isAr ? 'أقسام السوق' : 'Marketplace Sections' }}
                        </h5>
                        <p class="ch-panel-subtitle">
                            {{ $isAr ? 'وصول سريع لأهم أقسام المنصة.' : 'Quick access to the main marketplace sections.' }}
                        </p>
                    </div>

                    <span class="ch-chip ch-chip-primary">
                        <i class="bi bi-grid-1x2-fill"></i>
                        {{ $isAr ? 'السوق' : 'Market' }}
                    </span>
                </div>

                <div class="ch-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('products') }}" class="ch-market">
                                <span class="ch-market-icon"><i class="bi bi-capsule"></i></span>
                                <span>
                                    <p class="ch-market-title">{{ $isAr ? 'المستلزمات الطبية' : 'Medical Supplies' }}</p>
                                    <p class="ch-market-meta">{{ $isAr ? 'تصفح المنتجات المتاحة' : 'Browse available products' }}</p>
                                </span>
                            </a>
                        </div>

                        <div class="col-md-6">
                            <a href="{{ route('providers') }}" class="ch-market">
                                <span class="ch-market-icon"><i class="bi bi-building"></i></span>
                                <span>
                                    <p class="ch-market-title">{{ $isAr ? 'الشركات الصناعية' : 'Industrial Companies' }}</p>
                                    <p class="ch-market-meta">{{ $isAr ? 'استكشف الشركات والمصنعين' : 'Explore companies and manufacturers' }}</p>
                                </span>
                            </a>
                        </div>

                        <div class="col-md-6">
                            <a href="{{ route('providers') }}" class="ch-market">
                                <span class="ch-market-icon"><i class="bi bi-people-fill"></i></span>
                                <span>
                                    <p class="ch-market-title">{{ $isAr ? 'الموردون والبائعون' : 'Suppliers / Vendors' }}</p>
                                    <p class="ch-market-meta">{{ $isAr ? 'اعرض الموردين المتاحين' : 'View available suppliers' }}</p>
                                </span>
                            </a>
                        </div>

                        <div class="col-md-6">
                            <a href="{{ route('categories') }}" class="ch-market">
                                <span class="ch-market-icon"><i class="bi bi-hospital-fill"></i></span>
                                <span>
                                    <p class="ch-market-title">{{ $isAr ? 'الأقسام والخدمات الطبية' : 'Medical Categories & Services' }}</p>
                                    <p class="ch-market-meta">{{ $isAr ? 'تصفح الأقسام والخدمات' : 'Browse categories and services' }}</p>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="col-lg-4">
            <section class="ch-card h-100">
                <div class="ch-panel-head">
                    <div>
                        <h5 class="ch-panel-title">
                            {{ $isAr ? 'ملخص الحساب' : 'Account Summary' }}
                        </h5>
                        <p class="ch-panel-subtitle">
                            {{ $isAr ? 'نظرة سريعة على نشاطك.' : 'A quick look at your activity.' }}
                        </p>
                    </div>
                </div>

                <div class="ch-body">
                    <table class="ch-summary-table">
                        <tr>
                            <td>{{ $isAr ? 'الطلبات' : 'Orders' }}</td>
                            <td>{{ number_format($ordersCount) }}</td>
                        </tr>
                        <tr>
                            <td>{{ $isAr ? 'المدفوع' : 'Paid' }}</td>
                            <td>{{ number_format($paidInvoicesCount) }}</td>
                        </tr>
                        <tr>
                            <td>{{ $isAr ? 'قيد التنفيذ' : 'Processing' }}</td>
                            <td>{{ number_format($processingOrdersCount) }}</td>
                        </tr>
                        <tr>
                            <td>{{ $isAr ? 'المفضلة' : 'Favorites' }}</td>
                            <td>{{ number_format($favoritesCount) }}</td>
                        </tr>
                        <tr>
                            <td>{{ $isAr ? 'الإشعارات' : 'Notifications' }}</td>
                            <td>{{ number_format($notificationsCount) }}</td>
                        </tr>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <section class="ch-card h-100">
                <div class="ch-panel-head">
                    <div>
                        <h5 class="ch-panel-title">
                            {{ $isAr ? 'الطلبات الأخيرة' : 'Recent Orders' }}
                        </h5>
                        <p class="ch-panel-subtitle">
                            {{ $isAr ? 'آخر الطلبات التي قمت بإنشائها.' : 'Your latest created orders.' }}
                        </p>
                    </div>

                    <a href="{{ route('user/myorders', 'all') }}" class="ch-chip ch-chip-primary">
                        {{ $isAr ? 'عرض الكل' : 'View All' }}
                        <i class="bi bi-chevron-{{ $isAr ? 'left' : 'right' }}"></i>
                    </a>
                </div>

                <div class="ch-body">
                    @forelse($orders as $order)
                        @php
                            $statusState = $order->front_status_state ?? [];
                            $statusKey = $statusState['key'] ?? '';
                            $statusText = $statusState['text'] ?? ((int)($order->payment_status ?? 0) === 1
                                ? ($isAr ? 'مدفوع' : 'Paid')
                                : ($isAr ? 'معلق' : 'Pending'));

                            $chipClass = in_array($statusKey, ['completed', 'completed_scheduled'], true)
                                ? 'ch-chip-success'
                                : 'ch-chip-warning';
                        @endphp

                        <a href="{{ route('user/get/order', $order->id) }}" class="ch-order">
                            <span class="ch-rank">
                                <i class="bi bi-box-seam"></i>
                            </span>

                            <div class="flex-grow-1">
                                <p class="ch-item-title">
                                    #{{ $order->id }} — {{ $order->provider->name ?? '-' }}
                                </p>
                                <p class="ch-item-meta">
                                    <i class="bi bi-calendar2-week"></i>
                                    {{ optional($order->created_at)->format('Y-m-d') }}
                                </p>
                            </div>

                            <span class="ch-chip {{ $chipClass }}">
                                {{ $statusText }}
                            </span>
                        </a>
                    @empty
                        <div class="ch-empty">
                            <i class="bi bi-bag-x"></i>
                            <h5 class="ch-empty-title">
                                {{ $isAr ? 'لا توجد طلبات' : 'No Orders' }}
                            </h5>
                            <p class="ch-empty-text">
                                {{ $isAr ? 'لم تقم بإنشاء أي طلب حتى الآن.' : 'You have not created any orders yet.' }}
                            </p>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>

        <div class="col-lg-6">
            <section class="ch-card h-100">
                <div class="ch-panel-head">
                    <div>
                        <h5 class="ch-panel-title">
                            {{ $isAr ? 'الموردون والشركات' : 'Suppliers & Companies' }}
                        </h5>
                        <p class="ch-panel-subtitle">
                            {{ $isAr ? 'موردون مقترحون لمتابعة منتجاتهم.' : 'Suggested suppliers to browse their products.' }}
                        </p>
                    </div>

                    <a href="{{ route('providers') }}" class="ch-chip ch-chip-primary">
                        {{ $isAr ? 'عرض الكل' : 'View All' }}
                        <i class="bi bi-chevron-{{ $isAr ? 'left' : 'right' }}"></i>
                    </a>
                </div>

                <div class="ch-body">
                    @forelse($featuredSuppliers as $supplier)
                        <a href="{{ route('products', ['vendor_name' => $supplier->name]) }}" class="ch-supplier">
                            <img
                                src="{{ !empty($supplier->img) ? asset(ltrim($supplier->img, '/')) : asset('front/assets/images/emptyproducts.png') }}"
                                class="ch-avatar"
                                alt="{{ $supplier->name ?? 'supplier' }}"
                                onerror="this.onerror=null;this.src='{{ asset('front/assets/images/emptyproducts.png') }}'"
                            >

                            <div class="flex-grow-1">
                                <p class="ch-item-title">{{ $supplier->name ?? '-' }}</p>
                                <p class="ch-item-meta">
                                    <i class="bi bi-grid-3x3-gap"></i>
                                    {{ $isAr ? 'عرض المنتجات' : 'View products' }}
                                </p>
                            </div>

                            <i class="bi bi-chevron-{{ $isAr ? 'left' : 'right' }} text-muted"></i>
                        </a>
                    @empty
                        <div class="ch-empty">
                            <i class="bi bi-shop-window"></i>
                            <h5 class="ch-empty-title">
                                {{ $isAr ? 'لا يوجد موردون' : 'No Suppliers' }}
                            </h5>
                            <p class="ch-empty-text">
                                {{ $isAr ? 'لا توجد بيانات موردين متاحة حالياً.' : 'There are no suppliers available now.' }}
                            </p>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>

        <div class="col-12">
            <div class="ch-workflow-wrap">
                @include('front.partials.order-workflow-hint', ['role' => 'customer'])
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
