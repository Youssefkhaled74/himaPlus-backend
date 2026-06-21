@extends('layouts.admin.home')

@section('title')
    <title>{{ __('admin.pages.orders.title') }}</title>
@endsection

@section('content')
    @php
        $status = $order->resolveAdminStatus((int) ($order->provider_id ?? 0) ?: null);
        $acceptedOffer = $order->offer;
        $timelineEntries = $order->timeline->sortByDesc('action_at')->values();
        $cancellationEntries = $timelineEntries->where('timeline_no', 12)->values();
        $partialReceives = collect($order->partial_receive ?? [])->sortByDesc('created_at')->values();
        $paymentBadgeClass = (int) ($order->payment_status ?? 0) === 1 ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning';
        $paymentLabel = (int) ($order->payment_status ?? 0) === 1 ? __('admin.dashboard.paid_badge') : __('admin.dashboard.pending_badge');
        $orderType = match ((int) ($order->order_type ?? 0)) {
            1 => __('admin.pages.common.order'),
            2 => __('admin.pages.common.quotation'),
            3 => __('admin.pages.common.maintenance'),
            default => '---',
        };
        $requestMode = (int) ($order->request_type ?? 0) === 2 ? __('admin.pages.orders.scheduled') : __('admin.pages.orders.standard');
    @endphp

    <div class="page-content">
        <div class="container-fluid">
            <x-admin.page-header
                :badge="__('admin.pages.orders.module_label')"
                :title="__('admin.pages.orders.order_details', ['id' => $order->id])"
                :description="__('admin.pages.orders.operational_details')"
                :breadcrumbs="[
                    ['label' => __('admin.pages.common.home'), 'href' => route('admin/index')],
                    ['label' => __('admin.nav.orders'), 'href' => route('admin/orders/index') . '/0/' . PAGINATION_COUNT],
                    ['label' => __('admin.pages.common.details'), 'active' => true],
                ]"
            >
                <x-slot:actions>
                    <a href="{{ route('admin/orders/index') . '/0/' . PAGINATION_COUNT }}" class="btn btn-light">
                        <i class="ri-arrow-left-line align-bottom"></i>
                        <span>{{ __('admin.pages.orders.back_to_orders') }}</span>
                    </a>
                </x-slot:actions>
            </x-admin.page-header>

            <div class="row g-4">
                <div class="col-12">
                    <div class="card admin-content-card">
                        <div class="card-body">
                            <div class="row g-4 align-items-stretch">
                                <div class="col-xl-8">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="border rounded-3 p-3 h-100">
                                                <div class="text-muted small mb-1">{{ __('admin.pages.orders.type') }}</div>
                                                <div class="fw-semibold">{{ $orderType }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="border rounded-3 p-3 h-100">
                                                <div class="text-muted small mb-1">{{ __('admin.pages.orders.mode') }}</div>
                                                <div class="fw-semibold">{{ $requestMode }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="border rounded-3 p-3 h-100">
                                                <div class="text-muted small mb-1">{{ __('admin.pages.orders.status') }}</div>
                                                <span class="badge {{ $status['class'] }}">{{ $status['text'] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="border rounded-3 p-3 h-100">
                                                <div class="text-muted small mb-1">{{ __('admin.pages.orders.customer') }}</div>
                                                <div class="fw-semibold">{{ $order->user?->name ?? '-' }}</div>
                                                <div class="small text-muted">{{ $order->user?->email ?? '-' }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="border rounded-3 p-3 h-100">
                                                <div class="text-muted small mb-1">{{ __('admin.pages.orders.vendor') }}</div>
                                                <div class="fw-semibold">{{ $order->provider?->name ?? '-' }}</div>
                                                <div class="small text-muted">{{ $order->provider?->email ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <div class="text-muted small mb-1">{{ __('admin.pages.orders.payment') }}</div>
                                                <div class="fw-semibold">{{ __('admin.pages.orders.commercial_snapshot') }}</div>
                                            </div>
                                            <span class="badge {{ $paymentBadgeClass }}">{{ $paymentLabel }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between py-2 border-top">
                                            <span class="text-muted">{{ __('admin.pages.orders.items_cost') }}</span>
                                            <span class="fw-semibold">{{ number_format((float) ($order->items_cost ?? 0), 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between py-2 border-top">
                                            <span class="text-muted">Discount</span>
                                            <span class="fw-semibold">{{ number_format((float) ($order->discount ?? 0), 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between py-2 border-top">
                                            <span class="text-muted">{{ __('admin.pages.orders.vat_amount') }}</span>
                                            <span class="fw-semibold">{{ number_format((float) ($order->vat_amount ?? 0), 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between py-2 border-top">
                                            <span class="text-muted">{{ __('admin.pages.orders.delivery_fee') }}</span>
                                            <span class="fw-semibold">{{ number_format((float) ($order->delivery_fee ?? 0), 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between py-2 border-top">
                                            <span class="text-muted">{{ __('admin.pages.orders.total_cost') }}</span>
                                            <span class="fw-semibold">{{ number_format((float) ($order->total_cost ?? 0), 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between py-2 border-top">
                                            <span class="text-muted">{{ __('admin.pages.orders.payment_type') }}</span>
                                            <span class="fw-semibold">{{ $order->payment_type ?? '-' }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between py-2 border-top">
                                            <span class="text-muted">{{ __('admin.pages.orders.transaction_id') }}</span>
                                            <span class="fw-semibold">{{ $order->getway_transaction_id ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card admin-content-card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('admin.pages.orders.order_items') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('admin.pages.orders.product_name') }}</th>
                                            <th>{{ __('admin.pages.orders.product_quantity') }}</th>
                                            <th>{{ __('admin.pages.orders.expiry_date') }}</th>
                                            <th>{{ __('admin.pages.orders.delivery_duration') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($order->items as $item)
                                            @php
                                                $deliveryDuration = $order->delivery_duration
                                                    ?? ($acceptedOffer?->delivery_time ?? '-');
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="fw-semibold">{{ $item->product?->name ?? '-' }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ optional($item->product?->expiry_date)->format('Y-m-d') ?? '-' }}</td>
                                                <td>{{ $deliveryDuration }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">{{ __('admin.pages.orders.no_items_found') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card admin-content-card h-100">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('admin.pages.orders.order_summary') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">{{ __('admin.pages.orders.address') }}</span>
                                <span class="fw-semibold text-end">{{ $order->address ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">{{ __('admin.pages.orders.device_category') }}</span>
                                <span class="fw-semibold">{{ $order->device_category?->name ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">{{ __('admin.pages.orders.device_name') }}</span>
                                <span class="fw-semibold">{{ $order->device_name ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">{{ __('admin.pages.orders.serial_number') }}</span>
                                <span class="fw-semibold">{{ $order->serial_number ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">{{ __('admin.pages.orders.budget') }}</span>
                                <span class="fw-semibold">{{ $order->budget ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">{{ __('admin.pages.orders.preferred_service_time') }}</span>
                                <span class="fw-semibold">{{ $order->preferred_service_time ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">{{ __('admin.pages.orders.schedule_start') }}</span>
                                <span class="fw-semibold">{{ $order->schedule_start_date ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2">
                                <span class="text-muted">{{ __('admin.pages.orders.created_at') }}</span>
                                <span class="fw-semibold">{{ optional($order->created_at)->format('Y-m-d H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card admin-content-card h-100">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('admin.pages.orders.accepted_offer') }}</h5>
                        </div>
                        <div class="card-body">
                            @if($acceptedOffer)
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">{{ __('admin.pages.orders.offer_id') }}</span>
                                    <span class="fw-semibold">#{{ $acceptedOffer->id }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">{{ __('admin.pages.orders.vendor') }}</span>
                                    <span class="fw-semibold">{{ $acceptedOffer->provider?->name ?? '-' }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">{{ __('admin.pages.orders.cost') }}</span>
                                    <span class="fw-semibold">{{ number_format((float) ($acceptedOffer->cost ?? 0), 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">{{ __('admin.pages.orders.delivery_time') }}</span>
                                    <span class="fw-semibold">{{ $acceptedOffer->delivery_time ?? '-' }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">{{ __('admin.pages.orders.warranty') }}</span>
                                    <span class="fw-semibold">{{ $acceptedOffer->warranty ?? '-' }}</span>
                                </div>
                                <div class="pt-2">
                                    <div class="text-muted small mb-1">{{ __('admin.pages.orders.notes') }}</div>
                                    <div class="fw-semibold">{{ $acceptedOffer->notes ?? '-' }}</div>
                                </div>
                            @else
                                <div class="text-center text-muted py-5">{{ __('admin.pages.orders.no_accepted_offer') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card admin-content-card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('admin.pages.orders.offers_list') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>{{ __('admin.pages.orders.offer') }}</th>
                                            <th>{{ __('admin.pages.orders.vendor') }}</th>
                                            <th>{{ __('admin.pages.orders.status') }}</th>
                                            <th>{{ __('admin.pages.orders.cost') }}</th>
                                            <th>{{ __('admin.pages.orders.delivery_time') }}</th>
                                            <th>{{ __('admin.pages.orders.notes') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($order->offers->sortByDesc('id') as $offer)
                                            @php
                                                $offerStatus = strtolower((string) $offer->status);
                                                $offerLabel = $offerStatus === '2' || $offerStatus === 'accepted'
                                                    ? __('admin.pages.orders.statuses.accepted')
                                                    : ($offerStatus === '3' || $offerStatus === 'rejected' ? __('admin.pages.orders.statuses.rejected') : __('admin.pages.orders.statuses.pending'));
                                                $offerClass = $offerLabel === __('admin.pages.orders.statuses.accepted')
                                                    ? 'bg-success-subtle text-success'
                                                    : ($offerLabel === __('admin.pages.orders.statuses.rejected') ? 'bg-danger-subtle text-danger' : 'bg-warning-subtle text-warning');
                                            @endphp
                                            <tr>
                                                <td class="fw-semibold">#{{ $offer->id }}</td>
                                                <td>{{ $offer->provider?->name ?? '-' }}</td>
                                                <td><span class="badge {{ $offerClass }}">{{ $offerLabel }}</span></td>
                                                <td>{{ number_format((float) ($offer->cost ?? 0), 2) }}</td>
                                                <td>{{ $offer->delivery_time ?? '-' }}</td>
                                                <td>{{ $offer->notes ?? '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">{{ __('admin.pages.orders.no_offers') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card admin-content-card h-100">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('admin.pages.orders.timeline') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>{{ __('admin.pages.orders.step') }}</th>
                                            <th>{{ __('admin.pages.orders.actor') }}</th>
                                            <th>{{ __('admin.pages.orders.timeline_no') }}</th>
                                            <th>{{ __('admin.pages.orders.action_at') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($timelineEntries as $entry)
                                            <tr>
                                                <td class="fw-semibold">{{ timelineName((int) $entry->timeline_no) }}</td>
                                                <td>{{ $entry->user?->name ?? ('User #' . ($entry->user_id ?? '-')) }}</td>
                                                <td>{{ $entry->timeline_no }}</td>
                                                <td>{{ optional($entry->action_at ?? $entry->created_at)->format('Y-m-d H:i') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">{{ __('admin.pages.orders.no_timeline') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card admin-content-card h-100">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('admin.pages.orders.cancellation_history') }}</h5>
                        </div>
                        <div class="card-body">
                            @forelse($cancellationEntries as $entry)
                                <div class="border rounded-3 p-3 mb-3">
                                    <div class="fw-semibold mb-1">{{ timelineName((int) $entry->timeline_no) }}</div>
                                    <div class="text-muted small mb-2">{{ __('admin.pages.orders.cancelled_by') }} {{ $entry->user?->name ?? ('User #' . ($entry->user_id ?? '-')) }}</div>
                                    <div class="small">{{ optional($entry->action_at ?? $entry->created_at)->format('Y-m-d H:i') }}</div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-5">{{ __('admin.pages.orders.no_cancellation') }}</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card admin-content-card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('admin.pages.orders.partial_receive') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                @forelse($partialReceives as $partialReceive)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="border rounded-3 p-3 h-100">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div class="fw-semibold">{{ __('admin.pages.orders.partial_id', ['id' => $partialReceive->id]) }}</div>
                                                <span class="badge bg-info-subtle text-info">{{ optional($partialReceive->created_at)->format('Y-m-d') }}</span>
                                            </div>
                                            <div class="small text-muted mb-1">{{ __('admin.pages.orders.offer_id') }}</div>
                                            <div class="fw-semibold mb-3">{{ $partialReceive->offer_id ?? '-' }}</div>
                                            <div class="small text-muted mb-1">{{ __('admin.pages.orders.received_quantity') }}</div>
                                            <div class="fw-semibold mb-3">{{ $partialReceive->received_quantity ?? '-' }}</div>
                                            <div class="small text-muted mb-1">{{ __('admin.pages.orders.received_all') }}</div>
                                            <div class="fw-semibold mb-3">{{ (int) ($partialReceive->received_all_quantity ?? 0) === 1 ? __('admin.pages.orders.yes') : __('admin.pages.orders.no') }}</div>
                                            <div class="small text-muted mb-1">{{ __('admin.pages.orders.reason') }}</div>
                                            <div class="fw-semibold">{{ $partialReceive->reason_for_partial ?? '-' }}</div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="text-center text-muted py-4">{{ __('admin.pages.orders.no_partial_receives') }}</div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card admin-content-card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('admin.pages.orders.internal_notes') }}</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $order->notes ?? __('admin.pages.orders.no_notes') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        (function () {
            $('.nav-link.menu-link').removeClass('active');
            $('.menu-dropdown').removeClass('show');
            $('.sidebarorders').addClass('active');
            var target = $('.sidebarorders').attr('href');
            $(target).addClass('show');
        })();
    </script>
@endsection
