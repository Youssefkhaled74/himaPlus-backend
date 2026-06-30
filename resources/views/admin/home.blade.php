@extends('layouts.admin.home')

@section('title')
    <title>{{ __('admin.dashboard.title') }}</title>
@endsection

@section('css')
<style>
    .admin-dashboard {
        --ad-bg: #f5f6f8;
        --ad-card: #ffffff;
        --ad-border: #e7eaf0;
        --ad-title: #0f2f7f;
        --ad-text: #1f2937;
        --ad-muted: #6b7280;
        --ad-primary: #0f4bbf;
        --ad-accent: #0ec6a0;
        --ad-soft: #eef5ff;

        background: var(--ad-bg);
        padding: 8px 0 24px;
        font-family: "Poppins", "Tajawal", system-ui, -apple-system, "Segoe UI", Arial, sans-serif;
    }

    .admin-dashboard * {
        font-family: inherit;
    }

    .ad-shell {
        max-width: 95%;
        margin: 12px auto 0;
    }

    .ad-card {
        background: var(--ad-card);
        border: 1px solid var(--ad-border);
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.04);
    }

    .ad-hero {
        padding: 22px;
        margin-bottom: 16px;
    }

    .ad-title {
        margin: 0 0 6px;
        color: var(--ad-title);
        font-size: 34px;
        line-height: 1.08;
        font-weight: 800;
        letter-spacing: -0.01em;
    }

    .ad-subtitle {
        margin: 0;
        color: #475569;
        font-size: 16px;
        line-height: 1.55;
        max-width: 760px;
    }

    .ad-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .ad-btn-primary,
    .ad-btn-outline {
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

    .ad-btn-primary {
        border: 0;
        color: #fff;
        background: linear-gradient(90deg, var(--ad-primary) 0%, var(--ad-accent) 100%);
    }

    .ad-btn-primary:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(15, 75, 191, .14);
    }

    .ad-btn-outline {
        border: 1px solid #cbd5e1;
        color: #1e3a8a;
        background: #fff;
    }

    .ad-btn-outline:hover {
        color: #1e3a8a;
        background: var(--ad-soft);
        transform: translateY(-1px);
    }

    .ad-chip-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 18px;
    }

    .ad-chip {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border-radius: 999px;
        padding: 7px 12px;
        font-size: 12px;
        font-weight: 700;
        background: #fff;
        color: #334155;
        border: 1px solid var(--ad-border);
    }

    .ad-stat {
        padding: 16px 18px;
        height: 100%;
        transition: all .2s ease;
        text-decoration: none;
        display: block;
    }

    .ad-stat:hover {
        border-color: #93c5fd;
        box-shadow: 0 4px 12px rgba(15, 75, 191, .08);
        transform: translateY(-1px);
    }

    .ad-stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: linear-gradient(90deg, var(--ad-primary) 0%, var(--ad-accent) 100%);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        font-size: 18px;
    }

    .ad-stat-label {
        display: block;
        color: var(--ad-muted);
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
        line-height: 1.35;
    }

    .ad-stat-value {
        display: block;
        color: var(--ad-text);
        font-size: 36px;
        line-height: 1;
        font-weight: 800;
    }

    .ad-stat-meta {
        margin-top: 8px;
        color: var(--ad-muted);
        font-size: 12px;
        font-weight: 600;
    }

    .ad-panel-head {
        border-bottom: 1px solid var(--ad-border);
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .ad-panel-title {
        margin: 0;
        color: #0f172a;
        font-size: 20px;
        font-weight: 700;
    }

    .ad-panel-subtitle {
        margin: 4px 0 0;
        color: var(--ad-muted);
        font-size: 13px;
    }

    .ad-body {
        padding: 18px;
    }

    .ad-chart {
        min-height: 360px;
    }

    .ad-badge {
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

    .ad-badge-primary {
        background: #eaf2ff;
        color: #1d4ed8;
    }

    .ad-badge-success {
        background: #dcfce7;
        color: #166534;
    }

    .ad-badge-warning {
        background: #fff7ed;
        color: #9a3412;
    }

    .ad-badge-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .ad-table {
        width: 100%;
        margin: 0;
    }

    .ad-table th {
        color: #64748b;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        border-bottom: 1px solid var(--ad-border);
        white-space: nowrap;
    }

    .ad-table td {
        vertical-align: middle;
        color: #334155;
        font-size: 14px;
        border-bottom: 1px solid #edf2f7;
    }

    .ad-table tbody tr {
        cursor: pointer;
        transition: background .18s ease;
    }

    .ad-table tbody tr:hover {
        background: #f8fbff;
    }

    .ad-alert-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .ad-alert-item {
        border: 1px solid var(--ad-border);
        border-radius: 14px;
        padding: 14px;
        background: #fff;
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .ad-alert-count {
        flex-shrink: 0;
        border-radius: 999px;
        padding: 7px 10px;
        font-size: 12px;
        font-weight: 800;
        background: #fee2e2;
        color: #991b1b;
    }

    .ad-alert-content {
        flex: 1;
        min-width: 0;
    }

    .ad-alert-title {
        font-size: 14px;
        color: #111827;
        font-weight: 800;
        margin-bottom: 4px;
    }

    .ad-alert-meta {
        color: #64748b;
        font-size: 13px;
        margin-bottom: 10px;
    }

    .ad-empty {
        text-align: center;
        padding: 30px 18px;
        color: #64748b;
    }

    .ad-empty i {
        font-size: 34px;
        color: #94a3b8;
        margin-bottom: 10px;
        display: inline-block;
    }

    @media (max-width: 992px) {
        .ad-shell {
            max-width: 100%;
            padding: 0 12px;
        }

        .ad-title {
            font-size: 28px;
        }

        .ad-subtitle {
            font-size: 15px;
        }

        .ad-stat-value {
            font-size: 30px;
        }

        .ad-panel-title {
            font-size: 18px;
        }
    }

    @media (max-width: 576px) {
        .ad-hero {
            padding: 18px;
        }

        .ad-title {
            font-size: 24px;
        }

        .ad-actions,
        .ad-btn-primary,
        .ad-btn-outline {
            width: 100%;
        }

        .ad-panel-head {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endsection

@section('content')
@php
    $isAr = app()->getLocale() === 'ar';

    $tr = function ($key, $fallback, $replace = []) {
        $translated = __($key, $replace);
        return $translated === $key ? $fallback : $translated;
    };

    $dashboard = $dashboard ?? [];
    $totals = $dashboard['totals'] ?? [];
    $charts = $dashboard['charts'] ?? [];

    $recentOrders = collect($dashboard['recent_orders'] ?? []);
    $lowStockProducts = collect($dashboard['low_stock_products'] ?? []);

    $ordersTotal = (int) ($totals['orders'] ?? 0);
    $paidOrders = (int) ($totals['paid_orders'] ?? 0);
    $unpaidOrders = (int) ($totals['unpaid_orders'] ?? 0);
    $processingOrders = (int) ($totals['processing_orders'] ?? 0);
    $lowStock = (int) ($totals['low_stock'] ?? 0);

    $paidPercent = $ordersTotal > 0 ? round(($paidOrders / $ordersTotal) * 100, 1) : 0;
@endphp

<div class="page-content admin-dashboard">
    <div class="container-fluid">
        <div class="ad-shell">
            <section class="ad-card ad-hero">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <span class="ad-badge ad-badge-primary mb-3">
                            <i class="ri-dashboard-3-line"></i>
                            {{ $tr('admin.dashboard.eyebrow', $isAr ? 'لوحة الإدارة' : 'Admin Dashboard') }}
                        </span>

                        <h3 class="ad-title">
                            {{ $tr('admin.dashboard.title', $isAr ? 'لوحة التحكم' : 'Dashboard') }}
                        </h3>

                        <p class="ad-subtitle">
                            {{ $isAr
                                ? 'تابع أهم أرقام المنصة: الطلبات، المدفوعات، الطلبات قيد التنفيذ، وتنبيهات المخزون من مكان واحد.'
                                : 'Track the most important platform numbers: orders, payments, processing orders, and stock alerts from one place.' }}
                        </p>

                        <div class="ad-chip-row">
                            <span class="ad-chip">
                                <i class="ri-checkbox-circle-line text-success"></i>
                                {{ $isAr ? 'مدفوع' : 'Paid' }}: {{ number_format($paidOrders) }}
                            </span>

                            <span class="ad-chip">
                                <i class="ri-error-warning-line text-warning"></i>
                                {{ $isAr ? 'غير مدفوع' : 'Unpaid' }}: {{ number_format($unpaidOrders) }}
                            </span>

                            <span class="ad-chip">
                                <i class="ri-time-line text-primary"></i>
                                {{ $isAr ? 'آخر تحديث' : 'Updated' }}: {{ now()->format('Y-m-d H:i') }}
                            </span>
                        </div>
                    </div>

                    <div class="ad-actions">
                        <a href="{{ route('admin/orders/index', [0, PAGINATION_COUNT]) }}" class="ad-btn-primary">
                            <i class="ri-shopping-bag-line"></i>
                            {{ $tr('admin.dashboard.open_orders', $isAr ? 'فتح الطلبات' : 'Open Orders') }}
                        </a>

                        <a href="{{ route('admin/products/index', [0, PAGINATION_COUNT]) }}" class="ad-btn-outline">
                            <i class="ri-capsule-line"></i>
                            {{ $tr('admin.dashboard.browse_products', $isAr ? 'المنتجات' : 'Products') }}
                        </a>
                    </div>
                </div>
            </section>

            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <a href="{{ route('admin/orders/index', [0, PAGINATION_COUNT]) }}?tab=orders" class="ad-card ad-stat">
                        <span class="ad-stat-icon">
                            <i class="ri-shopping-bag-3-line"></i>
                        </span>
                        <span class="ad-stat-label">{{ $isAr ? 'إجمالي الطلبات' : 'Total Orders' }}</span>
                        <strong class="ad-stat-value">{{ number_format($ordersTotal) }}</strong>
                    </a>
                </div>

                <div class="col-6 col-md-3">
                    <a href="{{ route('admin/orders/index', [0, PAGINATION_COUNT]) }}?tab=orders&payment_status=1" class="ad-card ad-stat">
                        <span class="ad-stat-icon">
                            <i class="ri-bank-card-line"></i>
                        </span>
                        <span class="ad-stat-label">{{ $isAr ? 'طلبات مدفوعة' : 'Paid Orders' }}</span>
                        <strong class="ad-stat-value">{{ number_format($paidOrders) }}</strong>
                        <div class="ad-stat-meta">{{ $isAr ? 'معدل التحصيل' : 'Collection Rate' }}: {{ $paidPercent }}%</div>
                    </a>
                </div>

                <div class="col-6 col-md-3">
                    <a href="{{ route('admin/orders/index', [0, PAGINATION_COUNT]) }}?tab=orders&status=processing" class="ad-card ad-stat">
                        <span class="ad-stat-icon">
                            <i class="ri-time-line"></i>
                        </span>
                        <span class="ad-stat-label">{{ $isAr ? 'قيد التنفيذ' : 'Processing' }}</span>
                        <strong class="ad-stat-value">{{ number_format($processingOrders) }}</strong>
                    </a>
                </div>

                <div class="col-6 col-md-3">
                    <a href="{{ route('admin/products/index', [0, PAGINATION_COUNT]) }}?low_stock=1" class="ad-card ad-stat">
                        <span class="ad-stat-icon">
                            <i class="ri-alert-line"></i>
                        </span>
                        <span class="ad-stat-label">{{ $isAr ? 'تنبيهات المخزون' : 'Low Stock Alerts' }}</span>
                        <strong class="ad-stat-value">{{ number_format($lowStock) }}</strong>
                    </a>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-12">
                    <section class="ad-card">
                        <div class="ad-panel-head">
                            <div>
                                <h5 class="ad-panel-title">
                                    {{ $tr('admin.dashboard.orders_revenue_trend', $isAr ? 'اتجاه الطلبات والإيرادات' : 'Orders & Revenue Trend') }}
                                </h5>
                                <p class="ad-panel-subtitle">
                                    {{ $isAr ? 'رسم بياني بسيط يوضح حركة الطلبات والإيرادات.' : 'A simple chart showing orders and revenue movement.' }}
                                </p>
                            </div>

                            <span class="ad-badge ad-badge-primary">
                                {{ $tr('admin.dashboard.monthly_analytics', $isAr ? 'تحليلات شهرية' : 'Monthly Analytics') }}
                            </span>
                        </div>

                        <div class="ad-body">
                            <div id="real_dashboard_chart" class="ad-chart" dir="ltr"></div>
                        </div>
                    </section>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-xl-8">
                    <section class="ad-card h-100">
                        <div class="ad-panel-head">
                            <div>
                                <h5 class="ad-panel-title">
                                    {{ $tr('admin.dashboard.recent_orders', $isAr ? 'أحدث الطلبات' : 'Recent Orders') }}
                                </h5>
                                <p class="ad-panel-subtitle">
                                    {{ $isAr ? 'آخر الطلبات التي تم إنشاؤها داخل المنصة.' : 'Latest orders created in the platform.' }}
                                </p>
                            </div>

                            <a href="{{ route('admin/orders/index', [0, PAGINATION_COUNT]) }}" class="ad-badge ad-badge-primary text-decoration-none">
                                {{ $tr('admin.dashboard.view_all', $isAr ? 'عرض الكل' : 'View All') }}
                            </a>
                        </div>

                        <div class="ad-body">
                            <div class="table-responsive">
                                <table class="table ad-table align-middle">
                                    <thead>
                                        <tr>
                                            <th>{{ $isAr ? 'رقم الطلب' : 'Order ID' }}</th>
                                            <th>{{ $isAr ? 'العميل' : 'Customer' }}</th>
                                            <th>{{ $isAr ? 'المورد' : 'Provider' }}</th>
                                            <th>{{ $isAr ? 'الإجمالي' : 'Total' }}</th>
                                            <th>{{ $isAr ? 'الدفع' : 'Payment' }}</th>
                                            <th>{{ $isAr ? 'التاريخ' : 'Date' }}</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($recentOrders as $order)
                                            <tr onclick="window.location='{{ route('admin/orders/edit', $order->id) }}'">
                                                <td class="fw-semibold">#{{ $order->id }}</td>
                                                <td>{{ optional($order->user)->name ?? '-' }}</td>
                                                <td>{{ optional($order->provider)->name ?? '-' }}</td>
                                                <td>{{ number_format((float) ($order->total_cost ?? 0), 2) }}</td>
                                                <td>
                                                    @if((int) ($order->payment_status ?? 0) === 1)
                                                        <span class="ad-badge ad-badge-success">
                                                            {{ $isAr ? 'مدفوع' : 'Paid' }}
                                                        </span>
                                                    @else
                                                        <span class="ad-badge ad-badge-warning">
                                                            {{ $isAr ? 'معلق' : 'Pending' }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>{{ optional($order->created_at)->format('Y-m-d H:i') ?? '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">
                                                    {{ $isAr ? 'لا توجد طلبات حديثة.' : 'No recent orders.' }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="col-xl-4">
                    <section class="ad-card h-100">
                        <div class="ad-panel-head">
                            <div>
                                <h5 class="ad-panel-title">
                                    {{ $tr('admin.dashboard.low_stock_alerts', $isAr ? 'تنبيهات المخزون' : 'Low Stock Alerts') }}
                                </h5>
                                <p class="ad-panel-subtitle">
                                    {{ $isAr ? 'منتجات تحتاج مراجعة المخزون.' : 'Products that need stock review.' }}
                                </p>
                            </div>

                            <span class="ad-badge ad-badge-danger">{{ number_format($lowStock) }}</span>
                        </div>

                        <div class="ad-body">
                            <div class="ad-alert-list">
                                @forelse($lowStockProducts as $product)
                                    <div class="ad-alert-item">
                                        <span class="ad-alert-count">
                                            {{ $isAr ? 'المتبقي' : 'Left' }}: {{ $product->stock_quantity ?? 0 }}
                                        </span>

                                        <div class="ad-alert-content">
                                            <a href="{{ route('admin/products/edit', $product->id) }}" class="text-decoration-none">
                                                <div class="ad-alert-title">{{ $product->name ?? '-' }}</div>
                                            </a>

                                            <div class="ad-alert-meta">
                                                {{ $isAr ? 'المورد' : 'Supplier' }}:
                                                {{ optional($product->provider)->name ?? '-' }}
                                            </div>

                                            <div class="d-flex flex-wrap gap-2">
                                                <a href="{{ route('admin/products/edit', $product->id) }}" class="ad-badge ad-badge-primary text-decoration-none">
                                                    {{ $isAr ? 'فتح المنتج' : 'Open Product' }}
                                                </a>

                                                @if(!empty($product->provider_id))
                                                    <a href="{{ route('admin/users/show', $product->provider_id) }}" class="ad-badge ad-badge-primary text-decoration-none">
                                                        {{ $isAr ? 'ملف المورد' : 'Supplier Profile' }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="ad-empty">
                                        <i class="ri-checkbox-circle-line"></i>
                                        <p class="mb-0">
                                            {{ $isAr ? 'كل المنتجات لديها مخزون كافٍ.' : 'All products are sufficiently stocked.' }}
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    (function () {
        const isRtl = @json(app()->getLocale() === 'ar');
        const months = @json($charts['months'] ?? []);
        const orders = @json($charts['orders'] ?? []);
        const revenue = @json($charts['revenue'] ?? []);

        const chartEl = document.querySelector('#real_dashboard_chart');

        if (!chartEl || typeof ApexCharts === 'undefined') {
            return;
        }

        const options = {
            series: [
                {
                    name: isRtl ? 'الطلبات' : 'Orders',
                    type: 'column',
                    data: orders
                },
                {
                    name: isRtl ? 'الإيرادات' : 'Revenue',
                    type: 'line',
                    data: revenue
                }
            ],
            chart: {
                height: 360,
                type: 'line',
                toolbar: { show: false },
                fontFamily: isRtl ? 'Tajawal, Almarai, sans-serif' : 'Poppins, Manrope, sans-serif'
            },
            stroke: {
                width: [0, 4],
                curve: 'smooth'
            },
            plotOptions: {
                bar: {
                    columnWidth: '42%',
                    borderRadius: 10
                }
            },
            grid: {
                borderColor: '#e3ebf5',
                strokeDashArray: 4
            },
            xaxis: {
                categories: months,
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: [
                {
                    title: {
                        text: isRtl ? 'الطلبات' : 'Orders'
                    }
                },
                {
                    opposite: true,
                    title: {
                        text: isRtl ? 'الإيرادات' : 'Revenue'
                    }
                }
            ],
            colors: ['#0f4bbf', '#0ec6a0'],
            dataLabels: {
                enabled: false
            },
            tooltip: {
                shared: true
            },
            legend: {
                position: 'top',
                horizontalAlign: isRtl ? 'right' : 'left'
            },
            noData: {
                text: isRtl ? 'لا توجد بيانات كافية لعرض الرسم البياني' : 'No data available'
            }
        };

        const chart = new ApexCharts(chartEl, options);
        chart.render();
    })();
</script>
@endsection
