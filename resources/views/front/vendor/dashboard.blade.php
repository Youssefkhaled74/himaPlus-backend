@extends('layouts.front.home')

@section('title')
    <title>{{ __('nav.home') }} - Vendor Dashboard</title>
@endsection

@section('css')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Marai:wght@300;400;500;600;700;800&display=swap');

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
        font-family: "Marai", "Tajawal", system-ui, -apple-system, "Segoe UI", Arial, sans-serif;
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
    }

    .vd-item:last-child {
        border-bottom: 0;
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

    .vd-list .small.text-muted {
        font-size: 13px;
    }

    .vd-quick a {
        font-size: 15px;
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

    <div class="vd-card vd-hero">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h3 class="vd-title">{{ $isAr ? 'اهلا بكم شركاء النجاح' : 'Welcome Success Partners' }}</h3>
                <p class="vd-subtitle">{{ $isAr ? 'لوحة تحكم المورد لإدارة المنتجات والطلبات والفواتير بسهولة.' : 'Vendor dashboard for products, orders, and invoices.' }}</p>
            </div>
            <div class="vd-actions">
                <a href="{{ route('vendor/products/create') }}" class="vd-btn-primary">{{ $isAr ? 'إضافة منتج' : 'Add Product' }}</a>
                <a href="{{ route('vendor/orders') }}" class="vd-btn-outline">{{ $isAr ? 'الطلبات' : 'Orders' }}</a>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="vd-card vd-stat">
                <p class="vd-stat-label">{{ $isAr ? 'إجمالي الطلبات' : 'Total Orders' }}</p>
                <h4 class="vd-stat-value">{{ $ordersCount }}</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="vd-card vd-stat">
                <p class="vd-stat-label">{{ $isAr ? 'الطلبات المجدولة' : 'Scheduled Orders' }}</p>
                <h4 class="vd-stat-value">{{ $scheduledOrdersCount }}</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="vd-card vd-stat">
                <p class="vd-stat-label">{{ $isAr ? 'الطلبات المكتملة' : 'Completed Orders' }}</p>
                <h4 class="vd-stat-value">{{ $completedOrdersCount }}</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="vd-card vd-stat">
                <p class="vd-stat-label">{{ $isAr ? 'المنتجات المفعلة' : 'Active Products' }}</p>
                <h4 class="vd-stat-value">{{ $productsCount }}</h4>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="vd-card h-100">
                <div class="vd-panel-head">
                    <h5 class="vd-panel-title">{{ $isAr ? 'آخر الطلبات' : 'Recent Orders' }}</h5>
                    <a class="vd-link" href="{{ route('vendor/orders') }}">{{ $isAr ? 'عرض الكل' : 'View all' }}</a>
                </div>
                <div class="vd-list">
                    @forelse($recentOrders as $order)
                        @php
                            $isPaid = (string)($order->payment_status ?? '') === '1' || (string)($order->payment_status ?? '') === 'paid';
                        @endphp
                        <div class="vd-item d-flex justify-content-between align-items-start gap-3">
                            <div>
                                <p class="vd-item-title">{{ $isAr ? 'طلب' : 'Order' }} #{{ $order->id }}</p>
                                <p class="vd-item-sub">{{ $order->user->name ?? '-' }}</p>
                            </div>
                            <div class="text-end">
                                <span class="vd-chip {{ $isPaid ? 'vd-chip-paid' : 'vd-chip-pending' }}">{{ $isPaid ? ($isAr ? 'مدفوع' : 'Paid') : ($isAr ? 'قيد الانتظار' : 'Pending') }}</span>
                                <div class="small text-muted mt-2">{{ number_format((float)($order->total_cost ?? 0), 2) }} SAR</div>
                            </div>
                        </div>
                    @empty
                        <div class="vd-empty">{{ $isAr ? 'لا توجد طلبات حاليا.' : 'No orders yet.' }}</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="vd-card mb-4">
                <div class="vd-panel-head">
                    <h5 class="vd-panel-title">{{ $isAr ? 'الإشعارات المهمة' : 'Important Notifications' }}</h5>
                    <a class="vd-link" href="{{ route('vendor/notifications') }}">{{ $isAr ? 'عرض الكل' : 'View all' }}</a>
                </div>
                <div class="vd-list">
                    @forelse($recentNotifications as $n)
                        <div class="vd-item">
                            <p class="vd-item-title">{{ $n->title ?? ($isAr ? 'تنبيه' : 'Alert') }}</p>
                            <p class="vd-item-sub">{{ $n->message ?? $n->content }}</p>
                        </div>
                    @empty
                        <div class="vd-empty">{{ $isAr ? 'لا توجد إشعارات مهمة.' : 'No important notifications.' }}</div>
                    @endforelse
                </div>
            </div>

            @include('front.partials.order-workflow-hint', ['role' => 'vendor'])

            <div class="vd-card">
                <div class="vd-panel-head">
                    <h5 class="vd-panel-title">{{ $isAr ? 'اختصارات' : 'Quick Links' }}</h5>
                </div>
                <div class="vd-quick">
                    <a href="{{ route('vendor/invoices') }}">{{ $isAr ? 'الفواتير' : 'Invoices' }}</a>
                    <a href="{{ route('vendor/categories') }}">{{ $isAr ? 'التصنيفات' : 'Categories' }}</a>
                    <a href="{{ route('vendor/products') }}">{{ $isAr ? 'المنتجات' : 'Products' }}</a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
