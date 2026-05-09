@extends('layouts.front.home')

@section('title')
<title>{{ __('nav.home') }} - Vendor Dashboard</title>
@endsection

@section('content')
<main class="container py-4">
    @include('flash::message')

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h3 class="mb-1">{{ app()->getLocale() === 'ar' ? 'اهلا بكم شركاء النجاح' : 'Welcome Success Partners' }}</h3>
                <p class="text-muted mb-0">{{ app()->getLocale() === 'ar' ? 'لوحة تحكم المورد لإدارة المنتجات والطلبات والفواتير بسهولة.' : 'Vendor dashboard for products, orders, and invoices.' }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('vendor/products/create') }}" class="btn btn-primary">{{ app()->getLocale() === 'ar' ? 'إضافة منتج' : 'Add Product' }}</a>
                <a href="{{ route('vendor/orders') }}" class="btn btn-outline-primary">{{ app()->getLocale() === 'ar' ? 'الطلبات' : 'Orders' }}</a>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><small class="text-muted">{{ app()->getLocale() === 'ar' ? 'إجمالي الطلبات' : 'Total Orders' }}</small><h4 class="mb-0">{{ $ordersCount }}</h4></div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><small class="text-muted">{{ app()->getLocale() === 'ar' ? 'الطلبات المجدولة' : 'Scheduled Orders' }}</small><h4 class="mb-0">{{ $scheduledOrdersCount }}</h4></div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><small class="text-muted">{{ app()->getLocale() === 'ar' ? 'الطلبات المكتملة' : 'Completed Orders' }}</small><h4 class="mb-0">{{ $completedOrdersCount }}</h4></div></div></div>
        <div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><small class="text-muted">{{ app()->getLocale() === 'ar' ? 'المنتجات المفعلة' : 'Active Products' }}</small><h4 class="mb-0">{{ $productsCount }}</h4></div></div></div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <strong>{{ app()->getLocale() === 'ar' ? 'آخر الطلبات' : 'Recent Orders' }}</strong>
                    <a href="{{ route('vendor/orders') }}">{{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View all' }}</a>
                </div>
                <div class="card-body">
                    @forelse($recentOrders as $order)
                        @php $pending = ($order->payment_status ?? '') === 'pending'; @endphp
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <div>
                                <div class="fw-semibold">{{ app()->getLocale() === 'ar' ? 'طلب' : 'Order' }} #{{ $order->id }}</div>
                                <small class="text-muted">{{ $order->user->name ?? '-' }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge {{ $pending ? 'bg-warning text-dark' : 'bg-success' }}">{{ $pending ? 'Pending' : 'Paid' }}</span>
                                <div class="small text-muted">{{ number_format((float)($order->total_cost ?? 0), 2) }} SAR</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted">{{ app()->getLocale() === 'ar' ? 'لا توجد طلبات حالياً.' : 'No orders yet.' }}</div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <strong>{{ app()->getLocale() === 'ar' ? 'الإشعارات المهمة' : 'Important Notifications' }}</strong>
                    <a href="{{ route('vendor/notifications') }}">{{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View all' }}</a>
                </div>
                <div class="card-body">
                    @forelse($recentNotifications as $n)
                        <div class="border-bottom py-2">
                            <div class="fw-semibold">{{ $n->title ?? (app()->getLocale() === 'ar' ? 'تنبيه' : 'Alert') }}</div>
                            <div class="small text-muted">{{ $n->message ?? $n->content }}</div>
                        </div>
                    @empty
                        <div class="text-muted">{{ app()->getLocale() === 'ar' ? 'لا توجد إشعارات مهمة.' : 'No important notifications.' }}</div>
                    @endforelse
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><strong>{{ app()->getLocale() === 'ar' ? 'اختصارات' : 'Quick Links' }}</strong></div>
                <div class="card-body d-grid gap-2">
                    <a href="{{ route('vendor/invoices') }}" class="btn btn-outline-secondary">{{ app()->getLocale() === 'ar' ? 'الفواتير' : 'Invoices' }}</a>
                    <a href="{{ route('vendor/categories') }}" class="btn btn-outline-secondary">{{ app()->getLocale() === 'ar' ? 'التصنيفات' : 'Categories' }}</a>
                    <a href="{{ route('vendor/products') }}" class="btn btn-outline-secondary">{{ app()->getLocale() === 'ar' ? 'المنتجات' : 'Products' }}</a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
