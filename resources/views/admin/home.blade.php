@extends('layouts.admin.home')

@section('title')
    <title>{{ __('admin.dashboard.title') }}</title>
@endsection

@section('content')
@php
    $paidTotal = max(1, (int) ($dashboard['totals']['orders'] ?? 0));
    $paidPercent = round((((int) ($dashboard['totals']['paid_orders'] ?? 0)) / $paidTotal) * 100, 1);
    $quickActions = [
        ['label' => __('admin.dashboard.manage_orders'), 'icon' => 'ri-shopping-bag-line', 'route' => route('admin/orders/index') . '/0/' . PAGINATION_COUNT],
        ['label' => __('admin.dashboard.manage_users'), 'icon' => 'ri-user-3-line', 'route' => route('admin/users/index') . '/0/' . PAGINATION_COUNT],
        ['label' => __('admin.dashboard.manage_products'), 'icon' => 'ri-capsule-line', 'route' => route('admin/products/index') . '/0/' . PAGINATION_COUNT],
        ['label' => __('admin.dashboard.manage_categories'), 'icon' => 'ri-layout-grid-line', 'route' => route('admin/categories/index') . '/0/' . PAGINATION_COUNT],
        ['label' => __('admin.dashboard.manage_coupons'), 'icon' => 'ri-coupon-2-line', 'route' => route('admin/coupons/index') . '/0/' . PAGINATION_COUNT],
        ['label' => __('admin.dashboard.manage_ratings'), 'icon' => 'ri-star-line', 'route' => route('admin/ratings/index') . '/0/' . PAGINATION_COUNT],
        ['label' => __('admin.dashboard.view_contacts'), 'icon' => 'ri-mail-line', 'route' => route('admin/contacts/index') . '/0/' . PAGINATION_COUNT],
        ['label' => __('admin.dashboard.manage_admins'), 'icon' => 'ri-shield-user-line', 'route' => route('admin/admins/index') . '/0/' . PAGINATION_COUNT],
    ];
    $stats = [
        [
            'label' => __('admin.dashboard.stats.orders'),
            'value' => number_format($dashboard['totals']['orders'] ?? 0),
            'growth' => $dashboard['growth']['orders'] ?? 0,
            'icon' => 'ri-shopping-bag-3-line',
            'softClass' => 'bg-primary-subtle text-primary',
            'showIcon' => true,
            'link' => route('admin/orders/index') . '/0/' . PAGINATION_COUNT,
        ],
        [
            'label' => __('admin.dashboard.accepted_orders'),
            'value' => number_format($dashboard['totals']['accepted_orders'] ?? 0),
            'growth' => 0,
            'icon' => null,
            'softClass' => '',
            'showIcon' => false,
            'meta' => __('admin.dashboard.accepted_payment_breakdown', [
                'paid' => number_format($dashboard['totals']['accepted_paid_orders'] ?? 0),
                'unpaid' => number_format($dashboard['totals']['accepted_unpaid_orders'] ?? 0),
            ]),
            'link' => route('admin/orders/index') . '/0/' . PAGINATION_COUNT,
        ],
        [
            'label' => __('admin.dashboard.rejected_orders'),
            'value' => number_format($dashboard['totals']['rejected_orders'] ?? 0),
            'growth' => 0,
            'icon' => null,
            'softClass' => '',
            'showIcon' => false,
            'link' => route('admin/orders/index') . '/0/' . PAGINATION_COUNT,
        ],
        [
            'label' => __('admin.dashboard.in_progress_orders'),
            'value' => number_format($dashboard['totals']['processing_orders'] ?? 0),
            'growth' => 0,
            'icon' => null,
            'softClass' => '',
            'showIcon' => false,
            'link' => route('admin/orders/index') . '/0/' . PAGINATION_COUNT,
        ],
        [
            'label' => __('admin.dashboard.executed_orders'),
            'value' => number_format($dashboard['totals']['executed_orders'] ?? 0),
            'growth' => 0,
            'icon' => null,
            'softClass' => '',
            'showIcon' => false,
            'link' => route('admin/orders/index') . '/0/' . PAGINATION_COUNT,
        ],
    ];
@endphp

<div class="page-content">
    <div class="container-fluid">
        <div class="dashboard-shell">
            <section class="dashboard-hero">
                <div class="dashboard-hero-grid">
                    <div class="dashboard-hero-copy">
                        <span class="badge bg-primary-subtle text-primary align-self-start">{{ __('admin.dashboard.eyebrow') }}</span>

                        <div class="dashboard-chip-row">
                            <div class="dashboard-chip">
                                <i class="ri-checkbox-circle-line text-success"></i>
                                <span>{{ __('admin.dashboard.paid_orders', ['count' => number_format($dashboard['totals']['paid_orders'] ?? 0)]) }}</span>
                            </div>
                            <div class="dashboard-chip">
                                <i class="ri-error-warning-line text-warning"></i>
                                <span>{{ __('admin.dashboard.pending_payments', ['count' => number_format($dashboard['totals']['unpaid_orders'] ?? 0)]) }}</span>
                            </div>
                            <div class="dashboard-chip">
                                <i class="ri-time-line text-primary"></i>
                                <span>{{ __('admin.dashboard.updated', ['time' => now()->format('Y-m-d H:i')]) }}</span>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-3 pt-2">
                            <a href="{{ route('admin/orders/index') }}/0/{{ PAGINATION_COUNT }}" class="btn btn-primary">
                                <i class="ri-shopping-bag-line align-bottom me-1"></i>
                                {{ __('admin.dashboard.open_orders') }}
                            </a>
                            <a href="{{ route('admin/products/index') }}/0/{{ PAGINATION_COUNT }}" class="btn btn-light">
                                <i class="ri-capsule-line align-bottom me-1"></i>
                                {{ __('admin.dashboard.browse_products') }}
                            </a>
                        </div>
                    </div>

                    <aside class="dashboard-hero-aside">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="badge bg-success-subtle text-success">{{ __('admin.dashboard.live_status') }}</span>
                                <span class="muted small">{{ __('admin.dashboard.collection_rate') }}</span>
                            </div>
                            <h3 class="text-white mb-2">{{ $paidPercent }}%</h3>
                            <p class="muted mb-0">{{ __('admin.dashboard.paid_orders_summary') }}</p>
                        </div>

                        <div>
                            <div class="progress mb-3" style="height: 12px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $paidPercent }}%"></div>
                            </div>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="small muted">{{ __('admin.dashboard.paid') }}</div>
                                    <div class="fw-bold fs-4">{{ number_format($dashboard['totals']['paid_orders'] ?? 0) }}</div>
                                </div>
                                <div class="col-6">
                                    <div class="small muted">{{ __('admin.dashboard.unpaid') }}</div>
                                    <div class="fw-bold fs-4">{{ number_format($dashboard['totals']['unpaid_orders'] ?? 0) }}</div>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </section>

            <section class="dashboard-stat-grid">
                @foreach($stats as $stat)
                    <a href="{{ $stat['link'] }}" class="dashboard-stat-card" style="text-decoration: none;">
                        <div class="dashboard-stat-head">
                            <div>
                                <span class="dashboard-stat-label">{{ $stat['label'] }}</span>
                                <strong class="dashboard-stat-value">{{ $stat['value'] }}</strong>
                                @if($stat['growth'] != 0)
                                    <div class="dashboard-stat-growth {{ $stat['growth'] >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ __('admin.dashboard.stats.vs_last_month', ['value' => ($stat['growth'] >= 0 ? '+' : '') . $stat['growth']]) }}
                                    </div>
                                @endif
                                @if(!empty($stat['meta']))
                                    <div class="dashboard-stat-growth text-muted">
                                        {{ $stat['meta'] }}
                                    </div>
                                @endif
                            </div>
                            @if(!empty($stat['showIcon']) && !empty($stat['icon']))
                                <span class="dashboard-stat-icon {{ $stat['softClass'] }}">
                                    <i class="{{ $stat['icon'] }}"></i>
                                </span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </section>

            <section class="dashboard-grid">
                <div class="d-flex flex-column gap-4">
                    <div class="card dashboard-panel">
                        <div class="card-header">
                            <div class="dashboard-section-heading mb-0">
                                <div>
                                    <h5 class="card-title mb-1">{{ __('admin.dashboard.quick_actions') }}</h5>
                                    <p class="text-muted mb-0">{{ __('admin.dashboard.quick_actions_subtitle') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dashboard-quick-actions">
                                @foreach ($quickActions as $action)
                                    <a href="{{ $action['route'] }}" class="dashboard-quick-link">
                                        <span><i class="{{ $action['icon'] }} me-2"></i>{{ $action['label'] }}</span>
                                        <i class="ri-arrow-left-up-line"></i>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="card dashboard-panel">
                        <div class="card-header">
                            <div class="dashboard-section-heading mb-0">
                                <div>
                                    <h5 class="card-title mb-1">{{ __('admin.dashboard.guidance_metrics_title') }}</h5>
                                    <p class="text-muted mb-0">{{ __('admin.dashboard.guidance_metrics_subtitle') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dashboard-mini-list">
                                <a href="{{ route('admin/users/index') }}/0/{{ PAGINATION_COUNT }}" class="dashboard-mini-item text-decoration-none">
                                    <div>
                                        <div class="fw-semibold">{{ __('admin.dashboard.vendors_count') }}</div>
                                        <div class="text-muted small">{{ __('admin.dashboard.vendor_orders_summary_hint') }}</div>
                                    </div>
                                    <span class="badge bg-primary-subtle text-primary">{{ number_format($dashboard['totals']['vendors_count'] ?? 0) }}</span>
                                </a>
                                <a href="{{ route('admin/users/index') }}/0/{{ PAGINATION_COUNT }}" class="dashboard-mini-item text-decoration-none">
                                    <div>
                                        <div class="fw-semibold">{{ __('admin.dashboard.customers_count') }}</div>
                                        <div class="text-muted small">{{ __('admin.dashboard.orders_rate_per_customer_hint') }}</div>
                                    </div>
                                    <span class="badge bg-info-subtle text-info">{{ number_format($dashboard['totals']['customers_count'] ?? 0) }}</span>
                                </a>
                                <a href="{{ route('admin/orders/index') }}/0/{{ PAGINATION_COUNT }}" class="dashboard-mini-item text-decoration-none">
                                    <div>
                                        <div class="fw-semibold">{{ __('admin.dashboard.avg_orders_per_customer') }}</div>
                                        <div class="text-muted small">{{ __('admin.dashboard.orders_rate_per_customer_hint') }}</div>
                                    </div>
                                    <span class="badge bg-warning-subtle text-warning">{{ number_format((float) ($dashboard['totals']['avg_orders_per_customer'] ?? 0), 2) }}</span>
                                </a>
                                <a href="{{ route('admin/contacts/index') }}/0/{{ PAGINATION_COUNT }}" class="dashboard-mini-item text-decoration-none">
                                    <div>
                                        <div class="fw-semibold">{{ __('admin.dashboard.contact_numbers_summary') }}</div>
                                        <div class="text-muted small">{{ __('admin.dashboard.contacts_snapshot') }}</div>
                                    </div>
                                    <span class="badge bg-info-subtle text-info">{{ number_format($dashboard['totals']['contacts'] ?? 0) }}</span>
                                </a>
                                <a href="{{ route('admin/ratings/index') }}/0/{{ PAGINATION_COUNT }}" class="dashboard-mini-item text-decoration-none">
                                    <div>
                                        <div class="fw-semibold">{{ __('admin.dashboard.ratings_summary') }}</div>
                                        <div class="text-muted small">{{ __('admin.dashboard.ratings_snapshot') }}</div>
                                    </div>
                                    <span class="badge bg-success-subtle text-success">{{ number_format($dashboard['totals']['ratings'] ?? 0) }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card dashboard-panel">
                        <div class="card-header">
                            <div class="dashboard-section-heading mb-0">
                                <div>
                                    <h5 class="card-title mb-1">{{ __('admin.dashboard.top_products') }}</h5>
                                    <p class="text-muted mb-0">{{ __('admin.dashboard.top_products_subtitle') }}</p>
                                </div>
                                <a href="{{ route('admin/products/index') }}/0/{{ PAGINATION_COUNT }}" class="btn btn-light btn-sm">{{ __('admin.dashboard.open_catalog') }}</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dashboard-mini-list">
                                @forelse($dashboard['top_products'] as $product)
                                    <a href="{{ route('admin/products/index') }}/0/{{ PAGINATION_COUNT }}" class="dashboard-mini-item text-decoration-none">
                                        <div>
                                            <div class="fw-semibold">{{ $product->name }}</div>
                                            <div class="text-muted small">
                                                {{ __('admin.pages.common.price') }}: {{ number_format((float) ($product->price ?? 0), 2) }}
                                            </div>
                                        </div>
                                        <span class="badge bg-primary-subtle text-primary">
                                            {{ __('admin.pages.common.stock_quantity') }}: {{ number_format((int) ($product->stock_quantity ?? 0)) }}
                                        </span>
                                    </a>
                                @empty
                                    <p class="text-muted mb-0">{{ __('admin.dashboard.no_top_products') }}</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="card dashboard-panel">
                        <div class="card-header">
                            <div class="dashboard-section-heading mb-0">
                                <div>
                                    <h5 class="card-title mb-1">{{ __('admin.dashboard.user_guidance_title') }}</h5>
                                    <p class="text-muted mb-0">{{ __('admin.dashboard.user_guidance_subtitle') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dashboard-mini-list">
                                <a href="{{ route('admin/users/index') }}/0/{{ PAGINATION_COUNT }}" class="dashboard-mini-item text-decoration-none">
                                    <div>
                                        <div class="fw-semibold">{{ __('admin.dashboard.active_users_label') }}</div>
                                    </div>
                                    <span class="badge bg-success-subtle text-success">{{ number_format($dashboard['totals']['active_users'] ?? 0) }}</span>
                                </a>
                                <a href="{{ route('admin/users/index') }}/0/{{ PAGINATION_COUNT }}" class="dashboard-mini-item text-decoration-none">
                                    <div>
                                        <div class="fw-semibold">{{ __('admin.dashboard.inactive_users_label') }}</div>
                                    </div>
                                    <span class="badge bg-danger-subtle text-danger">{{ number_format($dashboard['totals']['inactive_users'] ?? 0) }}</span>
                                </a>
                                <a href="{{ route('admin/users/index') }}/0/{{ PAGINATION_COUNT }}" class="dashboard-mini-item text-decoration-none">
                                    <div>
                                        <div class="fw-semibold">{{ __('admin.dashboard.new_users_label') }}</div>
                                    </div>
                                    <span class="badge bg-primary-subtle text-primary">{{ number_format($dashboard['totals']['new_users_today'] ?? 0) }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column gap-4">
                    <div class="card dashboard-panel">
                        <div class="card-header">
                            <div class="dashboard-section-heading mb-0">
                                <div>
                                    <h5 class="card-title mb-1">{{ __('admin.dashboard.offers_panel') }}</h5>
                                    <p class="text-muted mb-0">{{ __('admin.dashboard.offers_panel_subtitle') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dashboard-mini-list">
                                <a href="{{ route('admin/orders/index') }}/0/{{ PAGINATION_COUNT }}" class="dashboard-mini-item text-decoration-none">
                                    <div>
                                        <div class="fw-semibold">{{ __('admin.dashboard.total_offers') }}</div>
                                    </div>
                                    <span class="badge bg-primary-subtle text-primary">{{ number_format($dashboard['totals']['total_offers'] ?? 0) }}</span>
                                </a>
                                <a href="{{ route('admin/orders/index') }}/0/{{ PAGINATION_COUNT }}" class="dashboard-mini-item text-decoration-none">
                                    <div>
                                        <div class="fw-semibold">{{ __('admin.dashboard.pending_offers') }}</div>
                                    </div>
                                    <span class="badge bg-warning-subtle text-warning">{{ number_format($dashboard['totals']['pending_offers'] ?? 0) }}</span>
                                </a>
                                <a href="{{ route('admin/orders/index') }}/0/{{ PAGINATION_COUNT }}" class="dashboard-mini-item text-decoration-none">
                                    <div>
                                        <div class="fw-semibold">{{ __('admin.dashboard.accepted_offers') }}</div>
                                    </div>
                                    <span class="badge bg-success-subtle text-success">{{ number_format($dashboard['totals']['accepted_offers'] ?? 0) }}</span>
                                </a>
                                <a href="{{ route('admin/orders/index') }}/0/{{ PAGINATION_COUNT }}" class="dashboard-mini-item text-decoration-none">
                                    <div>
                                        <div class="fw-semibold">{{ __('admin.dashboard.acceptance_rate') }}</div>
                                    </div>
                                    <span class="badge bg-info-subtle text-info">{{ number_format((float) ($dashboard['totals']['acceptance_rate'] ?? 0), 2) }}%</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card dashboard-panel">
                        <div class="card-header">
                            <div class="dashboard-section-heading mb-0">
                                <div>
                                    <h5 class="card-title mb-1">{{ __('admin.dashboard.scheduled_operations') }}</h5>
                                    <p class="text-muted mb-0">{{ __('admin.dashboard.scheduled_operations_subtitle') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dashboard-mini-list">
                                <a href="{{ route('admin/orders/index') }}/0/{{ PAGINATION_COUNT }}" class="dashboard-mini-item text-decoration-none">
                                    <div>
                                        <div class="fw-semibold">{{ __('admin.dashboard.scheduled_orders') }}</div>
                                    </div>
                                    <span class="badge bg-primary-subtle text-primary">{{ number_format($dashboard['totals']['scheduled_orders'] ?? 0) }}</span>
                                </a>
                                <a href="{{ route('admin/orders/index') }}/0/{{ PAGINATION_COUNT }}" class="dashboard-mini-item text-decoration-none">
                                    <div>
                                        <div class="fw-semibold">{{ __('admin.dashboard.active_scheduled_orders') }}</div>
                                    </div>
                                    <span class="badge bg-info-subtle text-info">{{ number_format($dashboard['totals']['active_scheduled_orders'] ?? 0) }}</span>
                                </a>
                                <a href="{{ route('admin/orders/index') }}/0/{{ PAGINATION_COUNT }}" class="dashboard-mini-item text-decoration-none">
                                    <div>
                                        <div class="fw-semibold">{{ __('admin.dashboard.completed_scheduled_orders') }}</div>
                                    </div>
                                    <span class="badge bg-success-subtle text-success">{{ number_format($dashboard['totals']['completed_scheduled_orders'] ?? 0) }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card dashboard-panel">
                        <div class="card-header">
                            <div class="dashboard-section-heading mb-0">
                                <div>
                                    <h5 class="card-title mb-1">{{ __('admin.dashboard.notifications_panel') }}</h5>
                                    <p class="text-muted mb-0">{{ __('admin.dashboard.notifications_panel_subtitle') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dashboard-mini-list">
                                <a href="{{ route('admin/users/index') }}/0/{{ PAGINATION_COUNT }}" class="dashboard-mini-item text-decoration-none">
                                    <div>
                                        <div class="fw-semibold">{{ __('admin.dashboard.total_unread_notifications') }}</div>
                                    </div>
                                    <span class="badge bg-danger-subtle text-danger">{{ number_format($dashboard['totals']['total_unread_notifications'] ?? 0) }}</span>
                                </a>
                                <a href="{{ route('admin/users/index') }}/0/{{ PAGINATION_COUNT }}" class="dashboard-mini-item text-decoration-none">
                                    <div>
                                        <div class="fw-semibold">{{ __('admin.dashboard.vendor_unread_notifications') }}</div>
                                    </div>
                                    <span class="badge bg-warning-subtle text-warning">{{ number_format($dashboard['totals']['vendor_unread_notifications'] ?? 0) }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="dashboard-grid">
                <div class="d-flex flex-column gap-4">
                    <div class="card dashboard-panel">
                        <div class="card-header">
                            <div class="dashboard-section-heading mb-0">
                                <div>
                                    <h5 class="card-title mb-1">{{ __('admin.dashboard.orders_revenue_trend') }}</h5>
                                    <p class="text-muted mb-0">{{ __('admin.dashboard.performance_movement') }}</p>
                                </div>
                                <span class="badge bg-primary-subtle text-primary">{{ __('admin.dashboard.monthly_analytics') }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="real_dashboard_chart" class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>

                    <div class="card dashboard-table-card">
                        <div class="card-header">
                            <div class="dashboard-section-heading mb-0">
                                <div>
                                    <h5 class="card-title mb-1">{{ __('admin.dashboard.recent_orders') }}</h5>
                                    <p class="text-muted mb-0">{{ __('admin.dashboard.recent_orders_subtitle') }}</p>
                                </div>
                                <a href="{{ route('admin/orders/index') }}/0/{{ PAGINATION_COUNT }}" class="btn btn-light btn-sm">{{ __('admin.dashboard.view_all') }}</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('admin.dashboard.order_id') }}</th>
                                            <th>{{ __('admin.dashboard.customer') }}</th>
                                            <th>{{ __('admin.dashboard.provider') }}</th>
                                            <th>{{ __('admin.dashboard.total') }}</th>
                                            <th>{{ __('admin.dashboard.status') }}</th>
                                            <th>{{ __('admin.dashboard.date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($dashboard['recent_orders'] as $order)
                                            <tr>
                                                <td class="fw-semibold">#{{ $order->id }}</td>
                                                <td>{{ optional($order->user)->name ?? '-' }}</td>
                                                <td>{{ optional($order->provider)->name ?? '-' }}</td>
                                                <td>{{ number_format((float) ($order->total_cost ?? 0), 2) }}</td>
                                                <td>
                                                    @if((int) $order->payment_status === 1)
                                                        <span class="badge bg-success-subtle text-success">{{ __('admin.dashboard.paid_badge') }}</span>
                                                    @else
                                                        <span class="badge bg-warning-subtle text-warning">{{ __('admin.dashboard.pending_badge') }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ optional($order->created_at)->format('Y-m-d H:i') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">{{ __('admin.dashboard.no_recent_orders') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column gap-4">
                    <div class="card dashboard-panel">
                        <div class="card-header">
                            <div class="dashboard-section-heading mb-0">
                                <div>
                                    <h5 class="card-title mb-1">{{ __('admin.dashboard.top_categories') }}</h5>
                                    <p class="text-muted mb-0">{{ __('admin.dashboard.top_categories_subtitle') }}</p>
                                </div>
                                <span class="badge bg-info-subtle text-info">{{ __('admin.dashboard.top_five') }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dashboard-mini-list">
                                <a href="{{ route('admin/categories/index') }}/0/{{ PAGINATION_COUNT }}" class="dashboard-mini-item text-decoration-none">
                                    <div>
                                        <div class="fw-semibold">{{ __('admin.dashboard.total_categories_label') }}</div>
                                        <div class="text-muted small">{{ __('admin.dashboard.stats.categories') }}</div>
                                    </div>
                                    <span class="badge bg-primary-subtle text-primary">{{ number_format($dashboard['totals']['categories'] ?? 0) }}</span>
                                </a>
                                <a href="{{ route('admin/products/index') }}/0/{{ PAGINATION_COUNT }}" class="dashboard-mini-item text-decoration-none">
                                    <div>
                                        <div class="fw-semibold">{{ __('admin.dashboard.total_products_label') }}</div>
                                        <div class="text-muted small">{{ __('admin.dashboard.stats.products') }}</div>
                                    </div>
                                    <span class="badge bg-info-subtle text-info">{{ number_format($dashboard['totals']['products'] ?? 0) }}</span>
                                </a>
                                @forelse($dashboard['top_categories'] as $category)
                                    <div class="dashboard-mini-item">
                                        <div>
                                            <div class="fw-semibold">{{ $category->name }}</div>
                                            <div class="text-muted small">{{ __('admin.dashboard.products_listed') }}</div>
                                        </div>
                                        <span class="badge bg-primary-subtle text-primary">{{ $category->products_count }}</span>
                                    </div>
                                @empty
                                    <p class="text-muted mb-0">{{ __('admin.dashboard.no_category_insights') }}</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <section class="dashboard-entity-grid">
                <article class="dashboard-entity-card is-blue">
                    <div class="dashboard-entity-meta">
                        <i class="ri-user-heart-line text-primary"></i>
                        <span>{{ __('admin.dashboard.users_snapshot') }}</span>
                    </div>
                    <h4 class="mb-2">{{ __('admin.dashboard.registered_accounts', ['count' => number_format($dashboard['totals']['users'] ?? 0)]) }}</h4>
                    <p class="text-muted mb-3">{{ __('admin.dashboard.users_snapshot_text') }}</p>
                    <a href="{{ route('admin/users/index') }}/0/{{ PAGINATION_COUNT }}" class="btn btn-light btn-sm">{{ __('admin.dashboard.open_users') }}</a>
                </article>

                <article class="dashboard-entity-card is-green">
                    <div class="dashboard-entity-meta">
                        <i class="ri-shopping-bag-line text-success"></i>
                        <span>{{ __('admin.dashboard.operations_snapshot') }}</span>
                    </div>
                    <h4 class="mb-2">{{ __('admin.dashboard.total_orders', ['count' => number_format($dashboard['totals']['orders'] ?? 0)]) }}</h4>
                    <p class="text-muted mb-3">{{ __('admin.dashboard.operations_snapshot_text') }}</p>
                    <a href="{{ route('admin/orders/index') }}/0/{{ PAGINATION_COUNT }}" class="btn btn-light btn-sm">{{ __('admin.dashboard.open_orders_short') }}</a>
                </article>

                <article class="dashboard-entity-card is-amber">
                    <div class="dashboard-entity-meta">
                        <i class="ri-coupon-2-line text-warning"></i>
                        <span>{{ __('admin.dashboard.catalog_snapshot') }}</span>
                    </div>
                    <h4 class="mb-2">{{ __('admin.dashboard.listed_products', ['count' => number_format($dashboard['totals']['products'] ?? 0)]) }}</h4>
                    <p class="text-muted mb-3">{{ __('admin.dashboard.catalog_snapshot_text') }}</p>
                    <a href="{{ route('admin/products/index') }}/0/{{ PAGINATION_COUNT }}" class="btn btn-light btn-sm">{{ __('admin.dashboard.open_catalog') }}</a>
                </article>

                <article class="dashboard-entity-card" style="background: linear-gradient(135deg, #0f4bbf 0%, #10c7a5 100%); color: white;">
                    <div class="dashboard-entity-meta" style="color: rgba(255,255,255,0.8);">
                        <i class="ri-alert-line"></i>
                        <span>{{ __('admin.dashboard.inventory_alert') }}</span>
                    </div>
                    <h4 class="mb-2" style="color: white;">{{ __('admin.dashboard.low_stock_items', ['count' => number_format($dashboard['totals']['low_stock'] ?? 0)]) }}</h4>
                    <p class="mb-3" style="color: rgba(255,255,255,0.8);">{{ __('admin.dashboard.inventory_alert_text') }}</p>
                    <a href="{{ route('admin/products/index') }}/0/{{ PAGINATION_COUNT }}" class="btn btn-light btn-sm">{{ __('admin.dashboard.open_catalog') }}</a>
                </article>

                <article class="dashboard-entity-card is-blue">
                    <div class="dashboard-entity-meta">
                        <i class="ri-star-line text-warning"></i>
                        <span>{{ __('admin.dashboard.ratings_snapshot') }}</span>
                    </div>
                    <h4 class="mb-2">{{ number_format($dashboard['totals']['ratings'] ?? 0) }}</h4>
                    <p class="text-muted mb-3">{{ __('admin.dashboard.ratings_snapshot_text') }}</p>
                    <a href="{{ route('admin/ratings/index') }}/0/{{ PAGINATION_COUNT }}" class="btn btn-light btn-sm">{{ __('admin.dashboard.open_ratings') }}</a>
                </article>

                <article class="dashboard-entity-card is-green">
                    <div class="dashboard-entity-meta">
                        <i class="ri-mail-line text-info"></i>
                        <span>{{ __('admin.dashboard.contacts_snapshot') }}</span>
                    </div>
                    <h4 class="mb-2">{{ number_format($dashboard['totals']['contacts'] ?? 0) }}</h4>
                    <p class="text-muted mb-3">{{ __('admin.dashboard.contacts_snapshot_text') }}</p>
                    <a href="{{ route('admin/contacts/index') }}/0/{{ PAGINATION_COUNT }}" class="btn btn-light btn-sm">{{ __('admin.dashboard.open_contacts') }}</a>
                </article>

            </section>

            <!-- Recent Users & Low Stock Grid -->
            <section class="dashboard-grid" style="margin-top: 2rem;">
                <div class="d-flex flex-column gap-4">
                    <div class="card dashboard-table-card">
                        <div class="card-header">
                            <div class="dashboard-section-heading mb-0">
                                <div>
                                    <h5 class="card-title mb-1">{{ __('admin.dashboard.recent_users') }}</h5>
                                    <p class="text-muted mb-0">{{ __('admin.dashboard.recent_users_subtitle') }}</p>
                                </div>
                                <a href="{{ route('admin/users/index') }}/0/{{ PAGINATION_COUNT }}" class="btn btn-light btn-sm">{{ __('admin.dashboard.view_all') }}</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('admin.dashboard.user_id') }}</th>
                                            <th>{{ __('admin.pages.common.name') }}</th>
                                            <th>{{ __('admin.pages.common.email') }}</th>
                                            <th>{{ __('admin.dashboard.joined') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($dashboard['recent_users'] as $user)
                                            <tr>
                                                <td class="fw-semibold">#{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->created_at->locale(app()->getLocale())->translatedFormat('d M Y') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">{{ __('admin.dashboard.no_recent_users') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column gap-4">
                    <div class="card dashboard-panel">
                        <div class="card-header">
                            <div class="dashboard-section-heading mb-0">
                                <div>
                                    <h5 class="card-title mb-1">{{ __('admin.dashboard.low_stock_alerts') }}</h5>
                                    <p class="text-muted mb-0">{{ __('admin.dashboard.low_stock_threshold_hint') }}</p>
                                </div>
                                <span class="badge bg-danger-subtle text-danger">{{ count($dashboard['low_stock_products'] ?? []) }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dashboard-alert-list">
                                @forelse($dashboard['low_stock_products'] as $product)
                                    <a href="{{ route('admin/products/edit', $product->id) }}" class="dashboard-alert-item text-decoration-none">
                                        <span class="dashboard-alert-item__count">
                                            {{ __('admin.dashboard.stock_left', ['count' => $product->stock_quantity]) }}
                                        </span>
                                        <div class="dashboard-alert-item__content">
                                            <div class="dashboard-alert-item__title">{{ $product->name }}</div>
                                            <div class="dashboard-alert-item__meta">
                                                {{ __('admin.dashboard.supplier_label') }}: {{ optional($product->provider)->name ?? '-' }}
                                            </div>
                                            @if(!empty($product->provider_id))
                                                <a href="{{ route('admin/users/show', $product->provider_id) }}" class="btn btn-light btn-sm mt-2">
                                                    {{ __('admin.dashboard.open_supplier_profile') }}
                                                </a>
                                            @endif
                                        </div>
                                        <span class="dashboard-alert-item__accent" aria-hidden="true"></span>
                                    </a>
                                @empty
                                    <p class="text-muted mb-0">{{ __('admin.dashboard.all_stocked') }}</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="card dashboard-panel">
                        <div class="card-header">
                            <div class="dashboard-section-heading mb-0">
                                <div>
                                    <h5 class="card-title mb-1">{{ __('admin.dashboard.payment_status') }}</h5>
                                    <p class="text-muted mb-0">{{ __('admin.dashboard.payment_status_subtitle') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dashboard-mini-list">
                                <div class="dashboard-mini-item">
                                    <div>
                                        <div class="fw-semibold">{{ __('admin.dashboard.paid_orders_label') }}</div>
                                        <div class="text-muted small">{{ __('admin.dashboard.paid_badge') }}</div>
                                    </div>
                                    <span class="badge bg-success-subtle text-success">{{ number_format($dashboard['totals']['paid_orders'] ?? 0) }}</span>
                                </div>
                                <div class="dashboard-mini-item">
                                    <div>
                                        <div class="fw-semibold">{{ __('admin.dashboard.pending_payments_label') }}</div>
                                        <div class="text-muted small">{{ __('admin.dashboard.pending_badge') }}</div>
                                    </div>
                                    <span class="badge bg-warning-subtle text-warning">{{ number_format($dashboard['totals']['unpaid_orders'] ?? 0) }}</span>
                                </div>
                                <div class="dashboard-mini-item">
                                    <div>
                                        <div class="fw-semibold">{{ __('admin.dashboard.collection_rate_label') }}</div>
                                        <div class="text-muted small">{{ __('admin.dashboard.live_status') }}</div>
                                    </div>
                                    <span class="badge bg-primary-subtle text-primary">{{ $paidPercent }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    (function () {
        const isRtl = @json(app()->getLocale() === 'ar');
        const months = @json($dashboard['charts']['months']);
        const orders = @json($dashboard['charts']['orders']);
        const revenue = @json($dashboard['charts']['revenue']);

        const options = {
            series: [
                { name: @json(__('admin.dashboard.chart_orders')), type: 'column', data: orders },
                { name: @json(__('admin.dashboard.chart_revenue')), type: 'line', data: revenue }
            ],
            chart: {
                height: 360,
                type: 'line',
                toolbar: { show: false },
                fontFamily: isRtl ? 'Almarai, sans-serif' : 'Manrope, sans-serif'
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
                    title: { text: @json(__('admin.dashboard.chart_orders')) }
                },
                {
                    opposite: true,
                    title: { text: @json(__('admin.dashboard.chart_revenue')) }
                }
            ],
            colors: ['#0f4bbf', '#10c7a5'],
            dataLabels: {
                enabled: false
            },
            tooltip: {
                shared: true
            },
            legend: {
                position: 'top',
                horizontalAlign: isRtl ? 'right' : 'left'
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
