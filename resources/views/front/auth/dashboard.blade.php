@extends('layouts.front.home')

@section('title')
<title>{{ app()->getLocale() === 'ar' ? 'لوحة العميل' : 'Customer Dashboard' }}</title>
@endsection

@section('css')
<style>
    .dashboard-wrap {
        margin-top: 2rem;
        margin-bottom: 3rem;
    }
    .dashboard-hero {
        border: 1px solid var(--hp-border);
        border-radius: 14px;
        background: linear-gradient(120deg, #ffffff 0%, #f7fbff 100%);
        padding: 1.4rem;
    }
    .dashboard-hero__title {
        font-weight: 700;
        color: #1f2b45;
        margin-bottom: .35rem;
    }
    .dashboard-hero__sub {
        color: #6b7280;
        margin-bottom: 0;
    }
    .dashboard-stat-card {
        border: 1px solid var(--hp-border);
        border-radius: 12px;
        background: #fff;
        padding: 1rem;
        height: 100%;
        transition: box-shadow .2s ease, transform .2s ease;
    }
    .dashboard-stat-card:hover {
        box-shadow: 0 10px 26px rgba(20,48,96,.08);
        transform: translateY(-2px);
    }
    .dashboard-stat-card .label {
        color: #6b7280;
        font-size: .9rem;
        margin-bottom: .45rem;
    }
    .dashboard-stat-card .value {
        font-size: 1.8rem;
        line-height: 1;
        font-weight: 700;
        color: #13213d;
    }
    .section-title {
        font-weight: 700;
        color: #1f2b45;
        margin-bottom: 1rem;
    }
    .market-link {
        display: block;
        text-decoration: none;
    }
    .market-link .market-item {
        border: 1px solid var(--hp-border);
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        font-weight: 600;
        color: var(--hp-primary);
        background: #fff;
        transition: all .2s ease;
    }
    .market-link:hover .market-item {
        border-color: #c7dafc;
        background: #f8fbff;
    }
    .dashboard-list-item {
        border-bottom: 1px solid #edf2f7;
        padding: .75rem 0;
    }
    .dashboard-list-item:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }
    .dashboard-list-item:first-child {
        padding-top: 0;
    }
    @media (max-width: 767.98px) {
        .dashboard-wrap {
            margin-top: 1rem;
        }
        .dashboard-hero {
            padding: 1rem;
        }
        .dashboard-stat-card .value {
            font-size: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<main class="container dashboard-wrap">
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

    <section class="dashboard-hero mb-4 reveal">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h4 class="dashboard-hero__title">{{ app()->getLocale() === 'ar' ? 'لوحة العميل' : 'Customer Dashboard' }}</h4>
                <p class="dashboard-hero__sub">
                    {{ app()->getLocale() === 'ar'
                        ? 'تابع الطلبات، الفواتير، الإشعارات، والمفضلة في مكان واحد.'
                        : 'Track orders, invoices, favorites, notifications, and recent activity.' }}
                </p>
            </div>
            <a href="{{ route('products') }}" class="btn btn-gradient">
                {{ app()->getLocale() === 'ar' ? 'تصفح المنتجات' : 'Browse Products' }}
            </a>
        </div>
    </section>

    <section class="row g-3 mb-4 reveal">
        <div class="col-6 col-md-4 col-xl-2">
            <div class="dashboard-stat-card">
                <div class="label">{{ app()->getLocale() === 'ar' ? 'طلباتي' : 'My Orders' }}</div>
                <div class="value">{{ $counts['orders'] }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="dashboard-stat-card">
                <div class="label">{{ app()->getLocale() === 'ar' ? 'فواتير مدفوعة' : 'Paid Invoices' }}</div>
                <div class="value">{{ $counts['paid_invoices'] }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="dashboard-stat-card">
                <div class="label">{{ app()->getLocale() === 'ar' ? 'طلبات معلقة' : 'Pending Orders' }}</div>
                <div class="value">{{ $counts['pending_orders'] }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="dashboard-stat-card">
                <div class="label">{{ app()->getLocale() === 'ar' ? 'المفضلة' : 'Favorites' }}</div>
                <div class="value">{{ $counts['favorites'] }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="dashboard-stat-card">
                <div class="label">{{ app()->getLocale() === 'ar' ? 'الإشعارات' : 'Notifications' }}</div>
                <div class="value">{{ $counts['notifications'] }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="dashboard-stat-card">
                <div class="label">{{ app()->getLocale() === 'ar' ? 'متابعة' : 'Tracking' }}</div>
                <div class="value">{{ $counts['orders'] }}</div>
            </div>
        </div>
    </section>

    <section class="detail-card mb-4 reveal">
        <h5 class="section-title">{{ app()->getLocale() === 'ar' ? 'أقسام السوق' : 'Marketplace Sections' }}</h5>
            <div class="row g-3">
                <div class="col-12 col-md-6 col-lg-3">
                    <a class="market-link" href="{{ route('products') }}">
                        <div class="market-item">{{ app()->getLocale() === 'ar' ? 'المستلزمات الطبية' : 'Medical Supplies' }}</div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <a class="market-link" href="{{ route('providers') }}">
                        <div class="market-item">{{ app()->getLocale() === 'ar' ? 'الشركات الصناعية' : 'Industrial Companies' }}</div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <a class="market-link" href="{{ route('providers') }}">
                        <div class="market-item">{{ app()->getLocale() === 'ar' ? 'الموردين والبائعين' : 'Suppliers / Vendors' }}</div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <a class="market-link" href="{{ route('categories') }}">
                        <div class="market-item">{{ app()->getLocale() === 'ar' ? 'المراكز والخدمات الطبية' : 'Medical Centers & Services' }}</div>
                    </a>
                </div>
            </div>
    </section>

    <section class="row g-4 reveal">
        <div class="col-lg-6">
            <div class="detail-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <strong>{{ app()->getLocale() === 'ar' ? 'الطلبات الأخيرة' : 'Recent Orders' }}</strong>
                    <a href="{{ route('user/myorders','all') }}">{{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View all' }}</a>
                </div>
                <div>
                    @forelse($orders as $order)
                        <div class="dashboard-list-item d-flex justify-content-between align-items-center gap-3">
                            <div>
                                <div class="fw-semibold">#{{ $order->id }} - {{ $order->provider->name ?? '-' }}</div>
                                <small class="text-muted">{{ optional($order->created_at)->format('Y-m-d') }}</small>
                            </div>
                            <div>
                                <span class="badge {{ (int)($order->payment_status ?? 0) === 1 ? 'bg-success' : 'bg-warning text-dark' }}">{{ (int)($order->payment_status ?? 0) === 1 ? 'Paid' : 'Pending' }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted">{{ app()->getLocale() === 'ar' ? 'لا توجد طلبات حتى الآن.' : 'No orders yet.' }}</div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="detail-card mb-4">
                <strong class="d-block mb-2">{{ app()->getLocale() === 'ar' ? 'الموردون والشركات' : 'Suppliers & Companies' }}</strong>
                <div>
                    @forelse($featuredSuppliers as $supplier)
                        <div class="dashboard-list-item d-flex align-items-center gap-2">
                            <img src="{{ $supplier->img ? asset($supplier->img) : asset('front/assets/images/emptyproducts.png') }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;" alt="supplier">
                            <div class="flex-grow-1">
                                <div class="fw-semibold">{{ $supplier->name }}</div>
                                <a class="small" href="{{ route('products', ['vendor_name' => $supplier->name]) }}">{{ app()->getLocale() === 'ar' ? 'عرض المنتجات' : 'View products' }}</a>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted">{{ app()->getLocale() === 'ar' ? 'لا يوجد موردون.' : 'No suppliers.' }}</div>
                    @endforelse
                </div>
            </div>
            <div class="detail-card">
                <strong class="d-block mb-2">{{ app()->getLocale() === 'ar' ? 'مساعدة سريعة' : 'FAQ / Help' }}</strong>
                <div class="small text-muted">
                    <div class="mb-2">{{ app()->getLocale() === 'ar' ? 'طريقة الطلب: اختر المنتج ثم أضفه إلى السلة وأكمل الدفع.' : 'How to order: choose product, add to cart, checkout.' }}</div>
                    <div class="mb-2">{{ app()->getLocale() === 'ar' ? 'طرق الدفع والتوصيل تظهر لك قبل تأكيد الطلب.' : 'Payment and delivery methods are shown before confirmation.' }}</div>
                    <div class="mb-2">{{ app()->getLocale() === 'ar' ? 'الموردون موثقون ويمكن تتبع مراحل الطلب.' : 'Suppliers are verified and order stages are tracked.' }}</div>
                    <div>{{ app()->getLocale() === 'ar' ? 'الدفع آمن والفواتير متاحة داخل صفحة الطلبات.' : 'Payments are secure and invoices are available via My Orders.' }}</div>
                </div>
            </div>
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
