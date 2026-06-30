@extends('layouts.front.home')

@section('title')
    <title>{{ trans_or_fallback('', '') }} - Vendor | Hema</title>
@endsection

@section('css')
<style>
    .vendor-analytics {
        --va-bg: #f5f6f8;
        --va-card: #ffffff;
        --va-border: #e7eaf0;
        --va-title: #0f2f7f;
        --va-text: #1f2937;
        --va-muted: #6b7280;
        --va-primary: #0f4bbf;
        --va-accent: #0ec6a0;
        --va-soft: #eef5ff;
        --va-soft-2: #f4fbf9;
        max-width: 95%;
        margin: 12px auto 0;
        background: var(--va-bg);
        padding: 8px 0 24px;
        font-family: "Poppins", "Tajawal", system-ui, -apple-system, "Segoe UI", Arial, sans-serif;
    }

    .vendor-analytics * {
        font-family: inherit;
    }

    .va-card {
        background: var(--va-card);
        border: 1px solid var(--va-border);
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.04);
    }

    .va-breadcrumb {
        font-size: 13px;
        margin-bottom: 12px;
    }

    .va-breadcrumb a {
        text-decoration: none;
        color: #6b7280;
    }

    .va-breadcrumb .active {
        color: var(--va-primary);
        font-weight: 700;
    }

    .va-hero {
        padding: 22px;
        margin-bottom: 16px;
    }

    .va-title {
        margin: 0 0 6px;
        color: var(--va-title);
        font-size: 34px;
        line-height: 1.08;
        font-weight: 800;
        letter-spacing: -0.01em;
    }

    .va-subtitle {
        margin: 0;
        color: #475569;
        font-size: 16px;
        line-height: 1.55;
        max-width: 760px;
    }

    .va-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .va-btn-primary,
    .va-btn-outline,
    .va-period {
        border-radius: 10px;
        font-weight: 700;
        padding: 10px 16px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all .2s ease;
    }

    .va-btn-primary {
        border: 0;
        color: #fff;
        background: linear-gradient(90deg, var(--va-primary) 0%, var(--va-accent) 100%);
    }

    .va-btn-outline {
        border: 1px solid #cbd5e1;
        color: #1e3a8a;
        background: #fff;
    }

    .va-period {
        border: 1px solid #dbe4f0;
        background: #fff;
        color: #334155;
        padding: 8px 14px;
        font-size: 13px;
    }

    .va-period.is-active {
        color: #fff;
        border-color: transparent;
        background: linear-gradient(90deg, var(--va-primary) 0%, var(--va-accent) 100%);
    }

    .va-periods {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .va-stat {
        padding: 16px 18px;
        height: 100%;
        transition: all .2s ease;
    }

    .va-stat:hover {
        border-color: #93c5fd;
        box-shadow: 0 4px 12px rgba(15, 75, 191, .08);
        transform: translateY(-1px);
    }

    .va-stat-label {
        margin: 0;
        color: var(--va-muted);
        font-size: 13px;
        font-weight: 500;
    }

    .va-stat-value {
        margin: 8px 0 0;
        color: var(--va-text);
        font-size: 40px;
        line-height: 1;
        font-weight: 800;
    }

    .va-panel-head {
        border-bottom: 1px solid var(--va-border);
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .va-panel-title {
        margin: 0;
        color: #0f172a;
        font-size: 20px;
        font-weight: 700;
    }

    .va-panel-subtitle {
        margin: 4px 0 0;
        color: var(--va-muted);
        font-size: 13px;
    }

    .va-body {
        padding: 18px;
    }

    .va-chart {
        position: relative;
        height: 320px;
    }

    .va-mini-table {
        width: 100%;
        border-collapse: collapse;
    }

    .va-mini-table tr + tr {
        border-top: 1px solid #edf2f7;
    }

    .va-mini-table td {
        padding: 12px 0;
        font-size: 14px;
        color: #334155;
    }

    .va-mini-table td:last-child {
        text-align: end;
        font-weight: 800;
        color: #0f172a;
    }

    .va-product {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 0;
    }

    .va-product + .va-product {
        border-top: 1px solid #edf2f7;
    }

    .va-rank {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: linear-gradient(90deg, var(--va-primary), var(--va-accent));
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        flex-shrink: 0;
    }

    .va-product-title {
        margin: 0 0 3px;
        font-size: 15px;
        font-weight: 700;
        color: #111827;
    }

    .va-product-meta {
        margin: 0;
        color: #64748b;
        font-size: 13px;
    }

    .va-chip {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 700;
        line-height: 1;
    }

    .va-chip-primary {
        background: #eaf2ff;
        color: #1d4ed8;
    }

    .va-chip-success {
        background: #dcfce7;
        color: #166534;
    }

    .va-chip-warning {
        background: #fff7ed;
        color: #9a3412;
    }

    .va-empty {
        text-align: center;
        padding: 38px 20px;
        color: #64748b;
    }

    .va-empty i {
        font-size: 38px;
        color: #94a3b8;
        margin-bottom: 10px;
        display: inline-block;
    }

    @media (max-width: 992px) {
        .vendor-analytics {
            max-width: 100%;
            padding: 8px 12px 24px;
        }

        .va-title {
            font-size: 28px;
        }

        .va-subtitle {
            font-size: 15px;
        }

        .va-stat-value {
            font-size: 32px;
        }

        .va-panel-title {
            font-size: 18px;
        }

        .va-chart {
            height: 260px;
        }
    }
</style>
@endsection

@section('content')
@php
    $isAr = app()->getLocale() === 'ar';
    $completionRate = $totalOrders > 0 ? round(($completedOrders / $totalOrders) * 100, 2) : 0;
@endphp
<main class="vendor-analytics">
    @include('flash::message')

    <nav class="va-breadcrumb">
        <a href="{{ route('vendor/dashboard') }}">{{ $isAr ? 'الرئيسية' : 'Home' }}</a>
        <i class="bi bi-chevron-{{ $isAr ? 'left' : 'right' }}"></i>
        <span class="active">{{ trans_or_fallback('', '') }}</span>
    </nav>

    <section class="va-card va-hero">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h3 class="va-title">{{ trans_or_fallback('', '') }}</h3>
                <p class="va-subtitle">
                    {{ $isAr ? 'تابع أداء الطلبات والعروض، راقب معدلات الإنجاز والقبول، وحدد المنتجات الأكثر حركة خلال الفترة التي تهمك.' : 'Track orders and offers performance, monitor completion and acceptance rates, and identify your most active products for the period that matters most.' }}
                </p>
            </div>
            <div class="va-actions">
                <a href="{{ route('vendor/dashboard') }}" class="va-btn-outline">
                    <i class="bi bi-grid-1x2-fill"></i>
                    {{ trans_or_fallback('', '') }}
                </a>
                <a href="{{ route('vendor/orders') }}" class="va-btn-primary">
                    <i class="bi bi-bag-check"></i>
                    {{ trans_or_fallback('', '') }}
                </a>
            </div>
        </div>
    </section>

    <div class="va-card mb-4">
        <div class="va-body">
            <div class="va-periods">
                <a href="{{ route('vendor/analytics', ['period' => '7']) }}" class="va-period {{ $period === '7' ? 'is-active' : '' }}">{{ $isAr ? 'آخر 7 أيام' : 'Last 7 Days' }}</a>
                <a href="{{ route('vendor/analytics', ['period' => '30']) }}" class="va-period {{ $period === '30' ? 'is-active' : '' }}">{{ $isAr ? 'آخر 30 يومًا' : 'Last 30 Days' }}</a>
                <a href="{{ route('vendor/analytics', ['period' => '90']) }}" class="va-period {{ $period === '90' ? 'is-active' : '' }}">{{ $isAr ? 'آخر 90 يومًا' : 'Last 90 Days' }}</a>
                <a href="{{ route('vendor/analytics', ['period' => 'all']) }}" class="va-period {{ $period === 'all' ? 'is-active' : '' }}">{{ $isAr ? 'كل الفترات' : 'All Time' }}</a>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="va-card va-stat">
                <p class="va-stat-label">{{ $isAr ? 'إجمالي الطلبات' : 'Total Orders' }}</p>
                <h4 class="va-stat-value">{{ number_format($totalOrders) }}</h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="va-card va-stat">
                <p class="va-stat-label">{{ $isAr ? 'إجمالي العروض' : 'Total Offers' }}</p>
                <h4 class="va-stat-value">{{ number_format($totalOffers) }}</h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="va-card va-stat">
                <p class="va-stat-label">{{ $isAr ? 'معدل القبول' : 'Acceptance Rate' }}</p>
                <h4 class="va-stat-value">{{ number_format((float) $acceptanceRate, 1) }}%</h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="va-card va-stat">
                <p class="va-stat-label">{{ $isAr ? 'متوسط التقييم' : 'Average Rating' }}</p>
                <h4 class="va-stat-value">{{ number_format((float) $avgProductRating, 1) }}</h4>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="va-card">
                <div class="va-panel-head">
                    <div>
                        <h5 class="va-panel-title">{{ $isAr ? 'اتجاه الطلبات' : 'Orders Trend' }}</h5>
                        <p class="va-panel-subtitle">{{ $isAr ? 'حركة الطلبات عبر الأشهر الحالية داخل الرسم البياني.' : 'Order movement across the current months.' }}</p>
                    </div>
                    <span class="va-chip va-chip-primary">{{ $period === 'all' ? ($isAr ? 'كل الفترات' : 'All Time') : ($isAr ? 'فترة مفلترة' : 'Filtered Period') }}</span>
                </div>
                <div class="va-body">
                    <div class="va-chart">
                        <canvas id="ordersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="va-card">
                <div class="va-panel-head">
                    <div>
                        <h5 class="va-panel-title">{{ $isAr ? 'توزيع الحالات' : 'Status Mix' }}</h5>
                        <p class="va-panel-subtitle">{{ $isAr ? 'مقارنة سريعة بين الطلبات المؤكدة وقيد التنفيذ والمكتملة.' : 'A quick comparison of confirmed, processing, and completed orders.' }}</p>
                    </div>
                </div>
                <div class="va-body">
                    <div class="va-chart">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="va-card">
                <div class="va-panel-head">
                    <div>
                        <h5 class="va-panel-title">{{ $isAr ? 'أفضل المنتجات' : 'Top Products' }}</h5>
                        <p class="va-panel-subtitle">{{ $isAr ? 'المنتجات الأكثر توليدًا للطلبات خلال الفترة.' : 'Products generating the most orders in the selected period.' }}</p>
                    </div>
                </div>
                <div class="va-body">
                    @forelse($topProducts as $index => $item)
                        <div class="va-product">
                            <div class="va-rank">{{ $index + 1 }}</div>
                            <div class="flex-grow-1">
                                <p class="va-product-title">{{ $item->product_name ?? ($isAr ? 'منتج' : 'Product') }}</p>
                                <p class="va-product-meta">{{ $isAr ? 'عدد الطلبات المرتبطة بهذا المنتج.' : 'Orders generated by this product.' }}</p>
                            </div>
                            <span class="va-chip va-chip-primary">{{ $item->order_count }} {{ trans_or_fallback('', '') }}</span>
                        </div>
                    @empty
                        <div class="va-empty">
                            <i class="bi bi-box-seam"></i>
                            <div>{{ $isAr ? 'لا توجد بيانات منتجات كافية لعرض الترتيب.' : 'Not enough product data to display rankings yet.' }}</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="va-card mb-4">
                <div class="va-panel-head">
                    <div>
                        <h5 class="va-panel-title">{{ $isAr ? 'ملخص الأداء' : 'Performance Summary' }}</h5>
                        <p class="va-panel-subtitle">{{ $isAr ? 'ملخص سريع لأهم مؤشرات التشغيل والمراجعات.' : 'A fast view of key operations and review metrics.' }}</p>
                    </div>
                </div>
                <div class="va-body">
                    <table class="va-mini-table">
                        <tr>
                            <td>{{ $isAr ? 'طلبات مكتملة' : 'Completed Orders' }}</td>
                            <td>{{ number_format($completedOrders) }}</td>
                        </tr>
                        <tr>
                            <td>{{ $isAr ? 'طلبات مؤكدة' : 'Confirmed Orders' }}</td>
                            <td>{{ number_format($confirmedOrders) }}</td>
                        </tr>
                        <tr>
                            <td>{{ $isAr ? 'طلبات قيد التنفيذ' : 'Processing Orders' }}</td>
                            <td>{{ number_format($processingOrders) }}</td>
                        </tr>
                        <tr>
                            <td>{{ $isAr ? 'عروض مقبولة' : 'Accepted Offers' }}</td>
                            <td>{{ number_format($acceptedOffers) }}</td>
                        </tr>
                        <tr>
                            <td>{{ $isAr ? 'إجمالي التقييمات' : 'Total Ratings' }}</td>
                            <td>{{ number_format($totalProductRatings) }}</td>
                        </tr>
                        <tr>
                            <td>{{ $isAr ? 'منتجات نشطة' : 'Active Products' }}</td>
                            <td>{{ number_format($products->count()) }}</td>
                        </tr>
                        <tr>
                            <td>{{ $isAr ? 'معدل الإنجاز' : 'Completion Rate' }}</td>
                            <td>{{ number_format((float) $completionRate, 1) }}%</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="va-card">
                <div class="va-panel-head">
                    <div>
                        <h5 class="va-panel-title">{{ $isAr ? 'مؤشرات الحالات' : 'Status Signals' }}</h5>
                        <p class="va-panel-subtitle">{{ $isAr ? 'مقارنة مباشرة بين الحالات الأهم لتقييم سرعة التنفيذ.' : 'Direct status comparison to assess execution velocity.' }}</p>
                    </div>
                </div>
                <div class="va-body">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>{{ $isAr ? 'مؤكد' : 'Confirmed' }}</span>
                            <span class="va-chip va-chip-primary">{{ $confirmedOrders }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>{{ $isAr ? 'قيد التنفيذ' : 'Processing' }}</span>
                            <span class="va-chip va-chip-warning">{{ $processingOrders }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>{{ $isAr ? 'مكتمل' : 'Completed' }}</span>
                            <span class="va-chip va-chip-success">{{ $completedOrders }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        const analyticsIsRtl = @json(app()->getLocale() === 'ar');

        const ordersCtx = document.getElementById('ordersChart');
        if (ordersCtx) {
            new Chart(ordersCtx, {
                type: 'line',
                data: {
                    labels: @json($chartMonths),
                    datasets: [{
                        label: analyticsIsRtl ? 'الطلبات' : 'Orders',
                        data: @json($chartOrdersCount),
                        borderColor: '#0f4bbf',
                        backgroundColor: 'rgba(15, 75, 191, 0.12)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#0ec6a0',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            rtl: analyticsIsRtl
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            },
                            grid: {
                                color: 'rgba(148, 163, 184, 0.18)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        const statusCtx = document.getElementById('statusChart');
        if (statusCtx) {
            const statusData = @json($ordersByStatus);
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: analyticsIsRtl
                        ? ['مؤكد', 'قيد التنفيذ', 'مكتمل']
                        : Object.keys(statusData),
                    datasets: [{
                        data: Object.values(statusData),
                        backgroundColor: ['#0f4bbf', '#f59e0b', '#10b981'],
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            rtl: analyticsIsRtl
                        }
                    }
                }
            });
        }
    </script>
@endsection

