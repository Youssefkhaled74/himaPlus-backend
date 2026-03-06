@extends('layouts.admin.home')

@section('title')
    <title>لوحة التحكم</title>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">مرحبًا، {{ auth()->guard('admin')->user()->name }}</h4>
                    <p class="text-muted mb-0">ملخص حقيقي من قاعدة البيانات</p>
                </div>
                <div class="text-muted small">
                    آخر تحديث: {{ now()->format('Y-m-d H:i') }}
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card card-animate h-100">
                    <div class="card-body">
                        <p class="text-muted text-uppercase fw-medium mb-2">إجمالي الطلبات</p>
                        <h3 class="mb-1">{{ number_format($dashboard['totals']['orders']) }}</h3>
                        <small class="{{ $dashboard['growth']['orders'] >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ $dashboard['growth']['orders'] >= 0 ? '+' : '' }}{{ $dashboard['growth']['orders'] }}% عن الشهر السابق
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card card-animate h-100">
                    <div class="card-body">
                        <p class="text-muted text-uppercase fw-medium mb-2">إجمالي المستخدمين</p>
                        <h3 class="mb-1">{{ number_format($dashboard['totals']['users']) }}</h3>
                        <small class="{{ $dashboard['growth']['users'] >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ $dashboard['growth']['users'] >= 0 ? '+' : '' }}{{ $dashboard['growth']['users'] }}% عن الشهر السابق
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card card-animate h-100">
                    <div class="card-body">
                        <p class="text-muted text-uppercase fw-medium mb-2">إجمالي المنتجات</p>
                        <h3 class="mb-1">{{ number_format($dashboard['totals']['products']) }}</h3>
                        <small class="{{ $dashboard['growth']['products'] >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ $dashboard['growth']['products'] >= 0 ? '+' : '' }}{{ $dashboard['growth']['products'] }}% عن الشهر السابق
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card card-animate h-100">
                    <div class="card-body">
                        <p class="text-muted text-uppercase fw-medium mb-2">إجمالي الإيراد (مدفوع)</p>
                        <h3 class="mb-1">{{ number_format($dashboard['totals']['revenue'], 2) }}</h3>
                        <small class="{{ $dashboard['growth']['revenue'] >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ $dashboard['growth']['revenue'] >= 0 ? '+' : '' }}{{ $dashboard['growth']['revenue'] }}% عن الشهر السابق
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">اتجاه الطلبات والإيراد (12 شهر)</h5>
                    </div>
                    <div class="card-body">
                        <div id="real_dashboard_chart" class="apex-charts" dir="ltr"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">ملخص حالة الدفع</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">طلبات مدفوعة</span>
                            <strong>{{ number_format($dashboard['totals']['paid_orders']) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">طلبات غير مدفوعة</span>
                            <strong>{{ number_format($dashboard['totals']['unpaid_orders']) }}</strong>
                        </div>
                        @php
                            $total = max(1, $dashboard['totals']['orders']);
                            $paidPercent = round(($dashboard['totals']['paid_orders'] / $total) * 100, 2);
                        @endphp
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $paidPercent }}%"></div>
                        </div>
                        <div class="small text-muted mt-2">نسبة المدفوع: {{ $paidPercent }}%</div>

                        <hr>
                        <h6 class="mb-3">أعلى 5 فئات (بعدد المنتجات)</h6>
                        @forelse($dashboard['top_categories'] as $category)
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ $category->name }}</span>
                                <span class="text-muted">{{ $category->products_count }}</span>
                            </div>
                        @empty
                            <p class="text-muted mb-0">لا توجد بيانات فئات</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">آخر الطلبات</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>العميل</th>
                            <th>المورد</th>
                            <th>قيمة الطلب</th>
                            <th>حالة الدفع</th>
                            <th>التاريخ</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($dashboard['recent_orders'] as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ optional($order->user)->name ?? '-' }}</td>
                                <td>{{ optional($order->provider)->name ?? '-' }}</td>
                                <td>{{ number_format((float) ($order->total_cost ?? 0), 2) }}</td>
                                <td>
                                    @if((int) $order->payment_status === 1)
                                        <span class="badge bg-success-subtle text-success">مدفوع</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger">غير مدفوع</span>
                                    @endif
                                </td>
                                <td>{{ optional($order->created_at)->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">لا توجد طلبات</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    (function () {
        const months = @json($dashboard['charts']['months']);
        const orders = @json($dashboard['charts']['orders']);
        const revenue = @json($dashboard['charts']['revenue']);

        const options = {
            series: [
                { name: 'الطلبات', type: 'column', data: orders },
                { name: 'الإيراد', type: 'line', data: revenue }
            ],
            chart: {
                height: 360,
                type: 'line',
                toolbar: { show: false }
            },
            stroke: {
                width: [0, 3],
                curve: 'smooth'
            },
            plotOptions: {
                bar: { columnWidth: '45%' }
            },
            xaxis: {
                categories: months
            },
            yaxis: [
                {
                    title: { text: 'عدد الطلبات' }
                },
                {
                    opposite: true,
                    title: { text: 'الإيراد' }
                }
            ],
            colors: ['#405189', '#0ab39c'],
            dataLabels: {
                enabled: false
            },
            tooltip: {
                shared: true
            }
        };

        const chartEl = document.querySelector('#real_dashboard_chart');
        if (chartEl) {
            const chart = new ApexCharts(chartEl, options);
            chart.render();
        }
    })();
</script>
@endsection
