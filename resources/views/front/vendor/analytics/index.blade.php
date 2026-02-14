@extends('layouts.front.home')

@section('title')
    <title>{{ __('nav.analytics') ?? 'Analytics' }} - Vendor | HemaPulse</title>
@endsection

@section('css')
    <style>
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .stat-card.secondary {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .stat-card.tertiary {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .stat-card.quaternary {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        .stat-number {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .stat-label {
            font-size: 14px;
            opacity: 0.9;
        }
        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 30px;
        }
        .card-header.bg-gradient {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }
        .top-product {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }
        .top-product:last-child {
            border-bottom: none;
        }
        .top-product-rank {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
        }
        .top-product-info {
            flex: 1;
        }
        .top-product-count {
            background: #e7f3ff;
            color: #0066cc;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .period-btn {
            padding: 8px 16px;
            margin-right: 10px;
            margin-bottom: 10px;
        }
        .period-btn.active {
            background: #007bff;
            color: white;
        }
    </style>
@endsection

@section('content')
    <main class="container-fluid my-4" style="margin-top: 8% !important;">
        @include('flash::message')
        
        <!-- Breadcrumb -->
        <nav class="breadcrumb-custom mb-3 ps-3">
            <a href="{{ route('vendor/dashboard') }}" class="text-decoration-none text-muted">{{ __('nav.dashboard') ?? 'Dashboard' }}</a>
            <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
            <span class="text-primary fw-semibold">{{ __('nav.analytics') ?? 'Analytics' }}</span>
        </nav>

        <div class="px-3">
            <!-- Header with Period Selection -->
            <div class="card mb-4">
                <div class="card-header bg-gradient d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="bi bi-graph-up me-2"></i>{{ __('nav.analytics_dashboard') ?? 'Analytics Dashboard' }}</h4>
                    <div>
                        <a href="{{ route('vendor/analytics', ['period' => '7']) }}" class="btn btn-sm {{ $period == '7' ? 'btn-light' : 'btn-outline-light' }}">
                            {{ __('nav.last_7_days') ?? '7 Days' }}
                        </a>
                        <a href="{{ route('vendor/analytics', ['period' => '30']) }}" class="btn btn-sm {{ $period == '30' ? 'btn-light' : 'btn-outline-light' }}">
                            {{ __('nav.last_30_days') ?? '30 Days' }}
                        </a>
                        <a href="{{ route('vendor/analytics', ['period' => '90']) }}" class="btn btn-sm {{ $period == '90' ? 'btn-light' : 'btn-outline-light' }}">
                            {{ __('nav.last_90_days') ?? '90 Days' }}
                        </a>
                        <a href="{{ route('vendor/analytics', ['period' => 'all']) }}" class="btn btn-sm {{ $period == 'all' ? 'btn-light' : 'btn-outline-light' }}">
                            {{ __('nav.all_time') ?? 'All Time' }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Key Statistics -->
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-number">{{ $totalOrders }}</div>
                        <div class="stat-label">{{ __('nav.total_orders') ?? 'Total Orders' }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card secondary">
                        <div class="stat-number">{{ $totalOffers }}</div>
                        <div class="stat-label">{{ __('nav.offers_submitted') ?? 'Offers Submitted' }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card tertiary">
                        <div class="stat-number">{{ $acceptanceRate }}%</div>
                        <div class="stat-label">{{ __('nav.acceptance_rate') ?? 'Acceptance Rate' }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card quaternary">
                        <div class="stat-number">{{ $avgProductRating }}</div>
                        <div class="stat-label">{{ __('nav.avg_rating') ?? 'Avg Rating' }}</div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row mt-4">
                <!-- Monthly Orders Chart -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header bg-gradient">
                            <h5 class="mb-0">{{ __('nav.monthly_orders') ?? 'Monthly Orders' }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="ordersChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders by Status -->
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header bg-gradient">
                            <h5 class="mb-0">{{ __('nav.orders_by_status') ?? 'Orders by Status' }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="statusChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Products & Statistics Row -->
            <div class="row">
                <!-- Top Products by Orders -->
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header bg-gradient">
                            <h5 class="mb-0"><i class="bi bi-fire me-2"></i>{{ __('nav.top_products') ?? 'Top Products by Orders' }}</h5>
                        </div>
                        <div class="card-body">
                            @if($topProducts->count() > 0)
                                @foreach($topProducts as $index => $item)
                                    <div class="top-product">
                                        <div class="top-product-rank">{{ $index + 1 }}</div>
                                        <div class="top-product-info">
                                            <strong>{{ $item->product_name ?? 'Product' }}</strong>
                                        </div>
                                        <div class="top-product-count">{{ $item->order_count }} {{ __('nav.orders') }}</div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-info">{{ __('messages.no_data') ?? 'No data available' }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Summary Statistics -->
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header bg-gradient">
                            <h5 class="mb-0"><i class="bi bi-bar-chart me-2"></i>{{ __('nav.summary') ?? 'Summary' }}</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <tr>
                                    <td>{{ __('nav.completed_orders') ?? 'Completed Orders' }}</td>
                                    <td class="text-end"><strong>{{ $completedOrders }}</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ __('nav.accepted_offers') ?? 'Accepted Offers' }}</td>
                                    <td class="text-end"><strong>{{ $acceptedOffers }}</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ __('nav.total_ratings') ?? 'Total Ratings' }}</td>
                                    <td class="text-end"><strong>{{ $totalProductRatings }}</strong></td>
                                </tr>
                                <tr>
                                    <td>{{ __('nav.active_products') ?? 'Active Products' }}</td>
                                    <td class="text-end"><strong>{{ $products->count() }}</strong></td>
                                </tr>
                                <tr class="table-active">
                                    <td><strong>{{ __('nav.completion_rate') ?? 'Completion Rate' }}</strong></td>
                                    <td class="text-end"><strong>
                                        @php
                                            $completionRate = $totalOrders > 0 ? round(($completedOrders / $totalOrders) * 100, 2) : 0;
                                        @endphp
                                        {{ $completionRate }}%
                                    </strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Stats Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-gradient">
                            <h5 class="mb-0">{{ __('nav.detailed_statistics') ?? 'Detailed Statistics' }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>{{ __('nav.metric') ?? 'Metric' }}</th>
                                            <th class="text-end">{{ __('nav.value') ?? 'Value' }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ __('nav.total_orders') ?? 'Total Orders' }}</td>
                                            <td class="text-end"><strong>{{ $totalOrders }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('nav.completed_orders') ?? 'Completed Orders' }}</td>
                                            <td class="text-end"><strong>{{ $completedOrders }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('nav.total_offers') ?? 'Total Offers' }}</td>
                                            <td class="text-end"><strong>{{ $totalOffers }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('nav.accepted_offers') ?? 'Accepted Offers' }}</td>
                                            <td class="text-end"><strong>{{ $acceptedOffers }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('nav.acceptance_rate') ?? 'Acceptance Rate' }}</td>
                                            <td class="text-end"><strong>{{ $acceptanceRate }}%</strong></td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('nav.avg_rating') ?? 'Average Rating' }}</td>
                                            <td class="text-end"><strong>{{ $avgProductRating }}/5</strong></td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('nav.total_reviews') ?? 'Total Reviews' }}</td>
                                            <td class="text-end"><strong>{{ $totalProductRatings }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('nav.products') ?? 'Products' }}</td>
                                            <td class="text-end"><strong>{{ $products->count() }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        // Monthly Orders Chart
        const ordersCtx = document.getElementById('ordersChart');
        if (ordersCtx) {
            new Chart(ordersCtx, {
                type: 'line',
                data: {
                    labels: @json($chartMonths),
                    datasets: [{
                        label: '{{ __("nav.orders") ?? "Orders" }}',
                        data: @json($chartOrdersCount),
                        borderColor: '#667eea',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#667eea',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }

        // Orders by Status Chart
        const statusCtx = document.getElementById('statusChart');
        if (statusCtx) {
            const statusData = @json($ordersByStatus);
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(statusData),
                    datasets: [{
                        data: Object.values(statusData),
                        backgroundColor: [
                            '#667eea',
                            '#f093fb',
                            '#f5576c',
                            '#43e97b'
                        ],
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    </script>
@endsection
