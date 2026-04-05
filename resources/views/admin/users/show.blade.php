@extends('layouts.admin.home')

@section('title')
    <title>{{ __('admin.pages.users.title') }} - {{ $user->name }}</title>
@endsection

@section('css')
    <style>
        .vo-chip{display:inline-flex;align-items:center;padding:6px 10px;border-radius:8px;font-size:12px;font-weight:600;line-height:1;border:1px solid transparent;}
        .chip-pending{background:#eef0f4;color:#666d79;}
        .chip-confirmed{background:#dbefff;color:#2285e8;}
        .chip-under-review{background:#ffefda;color:#e4972d;}
        .chip-processing{background:#ffefda;color:#e4972d;}
        .chip-shipped{background:#e8e0f9;color:#7a58c9;}
        .chip-delivered,.chip-completed{background:#dff0e3;color:#4fa464;}
        .chip-cancelled,.chip-rejected{background:#ffe1df;color:#ef5753;}
        .chip-upcoming{background:#eef0f4;color:#666d79;}
        .chip-active{background:#dbefff;color:#2285e8;}
        .chip-paused{background:#ffefda;color:#e4972d;}
        .chip-converted{background:#dff0e3;color:#4fa464;}
        .chip-offers-received{background:#dbefff;color:#2285e8;}
        .chip-supplier-selected{background:#e8e0f9;color:#7a58c9;}
        .chip-assigned{background:#dbefff;color:#2285e8;}
        .chip-on-hold{background:#ece4fa;color:#7a58c9;}
    </style>
@endsection

@section('content')
    @php
        $statusClasses = [
            'pending' => 'chip-pending',
            'confirmed' => 'chip-confirmed',
            'under review' => 'chip-under-review',
            'under_review' => 'chip-under-review',
            'processing' => 'chip-processing',
            'shipped' => 'chip-shipped',
            'delivered' => 'chip-delivered',
            'completed' => 'chip-completed',
            'cancelled' => 'chip-cancelled',
            'canceled' => 'chip-cancelled',
            'rejected' => 'chip-rejected',
            'upcoming' => 'chip-upcoming',
            'active' => 'chip-active',
            'paused' => 'chip-paused',
            'converted to order' => 'chip-converted',
            'offers received' => 'chip-offers-received',
            'supplier selected' => 'chip-supplier-selected',
            'assigned to supplier' => 'chip-assigned',
            'assigned' => 'chip-assigned',
            'on hold' => 'chip-on-hold',
        ];

        $resolveStatus = function ($order, $providerId = null) use ($statusClasses) {
            $lastTimelineNo = optional($order->timeline->sortByDesc('timeline_no')->first())->timeline_no;
            $lastTimelineLabel = strtolower(trim((string) timelineName((int) $lastTimelineNo)));

            if ((int) $order->request_type === 2) {
                $statusText = ucfirst((string) $order->scheduled_status);
                $statusKey = strtolower((string) $order->scheduled_status);
            } else {
                $myOffer = null;
                if (!is_null($providerId)) {
                    $myOffer = $order->offers->where('provider_id', (int) $providerId)->first();
                }

                if ($myOffer) {
                    $offerStatus = strtolower((string) $myOffer->status);
                    if ($offerStatus === '2' || $offerStatus === 'accepted') {
                        $statusText = 'Confirmed';
                        $statusKey = 'confirmed';
                    } elseif ($offerStatus === '3' || $offerStatus === 'rejected') {
                        $statusText = 'Rejected';
                        $statusKey = 'rejected';
                    } else {
                        $statusText = ucwords($lastTimelineLabel !== '---' ? $lastTimelineLabel : 'Pending');
                        $statusKey = $lastTimelineLabel !== '---' ? $lastTimelineLabel : 'pending';
                    }
                } else {
                    $acceptedOffer = $order->offers->first(function ($offer) {
                        $status = strtolower((string) $offer->status);
                        return $status === '2' || $status === 'accepted';
                    });
                    $rejectedOffer = $order->offers->first(function ($offer) {
                        $status = strtolower((string) $offer->status);
                        return $status === '3' || $status === 'rejected';
                    });

                    if ($acceptedOffer) {
                        $statusText = 'Confirmed';
                        $statusKey = 'confirmed';
                    } elseif ($rejectedOffer && $order->offers->count() > 0) {
                        $statusText = 'Rejected';
                        $statusKey = 'rejected';
                    } else {
                        $statusText = ucwords($lastTimelineLabel !== '---' ? $lastTimelineLabel : 'Pending');
                        $statusKey = $lastTimelineLabel !== '---' ? $lastTimelineLabel : 'pending';
                    }
                }
            }

            return [
                'text' => $statusText,
                'class' => $statusClasses[$statusKey] ?? 'chip-pending',
            ];
        };
    @endphp

    <div class="page-content">
        <div class="container-fluid">
            <x-admin.page-header
                :badge="__('admin.pages.users.module_label')"
                :title="$user->name"
                :description="__('admin.pages.users.description')"
                :breadcrumbs="[
                    ['label' => __('admin.pages.common.home'), 'href' => route('admin/index')],
                    ['label' => __('admin.nav.users'), 'href' => route('admin/users/index') . '/0/' . PAGINATION_COUNT],
                    ['label' => __('admin.pages.common.details'), 'active' => true],
                ]"
            >
                <x-slot:actions>
                    <a href="{{ route('admin/users/index') . '/0/' . PAGINATION_COUNT }}" class="btn btn-light">
                        <i class="ri-arrow-left-line align-bottom"></i>
                        <span>{{ __('admin.pages.users.back_to_users') }}</span>
                    </a>
                    <a href="{{ route('admin/users/edit', $user->id) }}" class="btn btn-primary">
                        <i class="ri-pencil-line align-bottom"></i>
                        <span>{{ __('admin.pages.common.edit') }}</span>
                    </a>
                </x-slot:actions>
            </x-admin.page-header>

            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'account' ? 'active' : '' }}" href="{{ route('admin/users/show', $user->id) }}?tab=account">Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'customer-orders' ? 'active' : '' }}" href="{{ route('admin/users/show', $user->id) }}?tab=customer-orders">Customer Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'vendor-orders' ? 'active' : '' }}" href="{{ route('admin/users/show', $user->id) }}?tab=vendor-orders">Vendor Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'products' ? 'active' : '' }}" href="{{ route('admin/users/show', $user->id) }}?tab=products">Vendor Products</a>
                </li>
            </ul>

            @if($activeTab === 'account')
                <div class="card admin-content-card mb-4">
                    <div class="card-body">
                        <div class="row g-4 align-items-center">
                            <div class="col-md-2 text-center">
                                @if($user->img)
                                    <img src="{{ asset($user->img) }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 96px; height: 96px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center" style="width: 96px; height: 96px;">
                                        <i class="ri-user-3-line fs-2 text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-10">
                                <div class="d-flex flex-wrap gap-2 align-items-center mb-2">
                                    <h4 class="mb-0">{{ $user->name }}</h4>
                                    @if((int) $user->user_type === 2)
                                        <span class="badge bg-primary-subtle text-primary">{{ __('admin.pages.common.provider') }}</span>
                                    @elseif((int) $user->user_type === 1)
                                        <span class="badge bg-success-subtle text-success">{{ __('admin.pages.common.client') }}</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary-emphasis">{{ __('admin.pages.common.undefined') }}</span>
                                    @endif
                                    @if((int) $user->is_activate === 1)
                                        <span class="badge bg-success-subtle text-success">{{ __('admin.pages.common.active') }}</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger">{{ __('admin.pages.common.inactive') }}</span>
                                    @endif
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-4"><strong>{{ __('admin.pages.common.email') }}:</strong> {{ $user->email ?? '-' }}</div>
                                    <div class="col-md-4"><strong>{{ __('admin.pages.common.mobile') }}:</strong> {{ $user->mobile ?? '-' }}</div>
                                    <div class="col-md-4"><strong>{{ __('admin.pages.common.location') }}:</strong> {{ $user->location ?? '-' }}</div>
                                    <div class="col-md-4"><strong>{{ __('admin.pages.common.branch') }}:</strong> {{ $user->branch ?? '-' }}</div>
                                    <div class="col-md-4"><strong>{{ __('admin.pages.common.tax_number') }}:</strong> {{ $user->tax_number ?? '-' }}</div>
                                    <div class="col-md-4"><strong>{{ __('admin.pages.common.cr_number') }}:</strong> {{ $user->cr_number ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <a href="{{ route('admin/users/show', $user->id) }}?tab=customer-orders" class="text-decoration-none text-reset">
                            <div class="card admin-content-card h-100">
                                <div class="card-body">
                                    <div class="text-muted small mb-1">Customer Orders</div>
                                    <h4 class="mb-0">{{ $customerOrdersCount }}</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('admin/users/show', $user->id) }}?tab=vendor-orders" class="text-decoration-none text-reset">
                            <div class="card admin-content-card h-100">
                                <div class="card-body">
                                    <div class="text-muted small mb-1">Vendor Orders</div>
                                    <h4 class="mb-0">{{ $vendorOrdersCount }}</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('admin/users/show', $user->id) }}?tab=products" class="text-decoration-none text-reset">
                            <div class="card admin-content-card h-100">
                                <div class="card-body">
                                    <div class="text-muted small mb-1">Vendor Products</div>
                                    <h4 class="mb-0">{{ $productsCount }}</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endif

            @if($activeTab === 'customer-orders')
                <div class="card admin-content-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Customer Orders</h5>
                        <small class="text-muted">Total: {{ $customerOrders->total() }}</small>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                <tr>
                                    <th class="text-center">{{ __('admin.pages.common.id') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.provider') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.total_cost') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.status') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.created_at') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($customerOrders as $order)
                                    @php
                                        $status = $resolveStatus($order, (int) ($order->provider_id ?? 0) ?: null);
                                    @endphp
                                    <tr class="text-center">
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ optional($order->provider)->name ?? '-' }}</td>
                                        <td>{{ $order->total_cost ?? 0 }}</td>
                                        <td><span class="vo-chip {{ $status['class'] }}">{{ $status['text'] }}</span></td>
                                        <td>{{ optional($order->created_at)->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin/orders/edit', $order->id) }}" class="btn btn-sm btn-light">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">{{ __('admin.pages.common.no_data') }}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="p-3">
                            {{ $customerOrders->appends(['tab' => 'customer-orders'])->links() }}
                        </div>
                    </div>
                </div>
            @endif

            @if($activeTab === 'vendor-orders')
                <div class="card admin-content-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Vendor Orders</h5>
                        <small class="text-muted">Total: {{ $vendorOrders->total() }}</small>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                <tr>
                                    <th class="text-center">{{ __('admin.pages.common.id') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.customer') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.total_cost') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.status') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.created_at') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($vendorOrders as $order)
                                    @php
                                        $status = $resolveStatus($order, $user->id);
                                    @endphp
                                    <tr class="text-center">
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ optional($order->user)->name ?? '-' }}</td>
                                        <td>{{ $order->total_cost ?? 0 }}</td>
                                        <td><span class="vo-chip {{ $status['class'] }}">{{ $status['text'] }}</span></td>
                                        <td>{{ optional($order->created_at)->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin/orders/edit', $order->id) }}" class="btn btn-sm btn-light">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">{{ __('admin.pages.common.no_data') }}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="p-3">
                            {{ $vendorOrders->appends(['tab' => 'vendor-orders'])->links() }}
                        </div>
                    </div>
                </div>
            @endif

            @if($activeTab === 'products')
                <div class="card admin-content-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Vendor Products</h5>
                        <small class="text-muted">Total: {{ $products->total() }}</small>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                <tr>
                                    <th class="text-center">{{ __('admin.pages.common.id') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.name') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.category') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.price') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.stock_quantity') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($products as $product)
                                    <tr class="text-center">
                                        <td>#{{ $product->id }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ optional($product->category)->name ?? '-' }}</td>
                                        <td>{{ $product->price ?? 0 }}</td>
                                        <td>{{ $product->stock_quantity ?? 0 }}</td>
                                        <td>
                                            <a href="{{ route('admin/products/edit', $product->id) }}" class="btn btn-sm btn-light">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">{{ __('admin.pages.common.no_data') }}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="p-3">
                            {{ $products->appends(['tab' => 'products'])->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
