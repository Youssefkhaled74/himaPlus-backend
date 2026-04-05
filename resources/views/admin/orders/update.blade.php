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
        $paymentLabel = (int) ($order->payment_status ?? 0) === 1 ? 'Paid' : 'Unpaid';
        $orderType = match ((int) ($order->order_type ?? 0)) {
            1 => __('admin.pages.common.order'),
            2 => __('admin.pages.common.quotation'),
            3 => __('admin.pages.common.maintenance'),
            default => '---',
        };
        $requestMode = (int) ($order->request_type ?? 0) === 2 ? 'Scheduled' : 'Standard';
    @endphp

    <div class="page-content">
        <div class="container-fluid">
            <x-admin.page-header
                :badge="__('admin.pages.orders.module_label')"
                :title="'Order #' . $order->id"
                :description="'Operational details, timeline, offers, and payment summary.'"
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
                                                <div class="text-muted small mb-1">Type</div>
                                                <div class="fw-semibold">{{ $orderType }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="border rounded-3 p-3 h-100">
                                                <div class="text-muted small mb-1">Mode</div>
                                                <div class="fw-semibold">{{ $requestMode }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="border rounded-3 p-3 h-100">
                                                <div class="text-muted small mb-1">Status</div>
                                                <span class="badge {{ $status['class'] }}">{{ $status['text'] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="border rounded-3 p-3 h-100">
                                                <div class="text-muted small mb-1">Customer</div>
                                                <div class="fw-semibold">{{ $order->user?->name ?? '-' }}</div>
                                                <div class="small text-muted">{{ $order->user?->email ?? '-' }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="border rounded-3 p-3 h-100">
                                                <div class="text-muted small mb-1">Vendor</div>
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
                                                <div class="text-muted small mb-1">Payment</div>
                                                <div class="fw-semibold">Commercial Snapshot</div>
                                            </div>
                                            <span class="badge {{ $paymentBadgeClass }}">{{ $paymentLabel }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between py-2 border-top">
                                            <span class="text-muted">Items Cost</span>
                                            <span class="fw-semibold">{{ number_format((float) ($order->items_cost ?? 0), 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between py-2 border-top">
                                            <span class="text-muted">Discount</span>
                                            <span class="fw-semibold">{{ number_format((float) ($order->discount ?? 0), 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between py-2 border-top">
                                            <span class="text-muted">VAT Amount</span>
                                            <span class="fw-semibold">{{ number_format((float) ($order->vat_amount ?? 0), 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between py-2 border-top">
                                            <span class="text-muted">Delivery Fee</span>
                                            <span class="fw-semibold">{{ number_format((float) ($order->delivery_fee ?? 0), 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between py-2 border-top">
                                            <span class="text-muted">Total Cost</span>
                                            <span class="fw-semibold">{{ number_format((float) ($order->total_cost ?? 0), 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between py-2 border-top">
                                            <span class="text-muted">Payment Type</span>
                                            <span class="fw-semibold">{{ $order->payment_type ?? '-' }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between py-2 border-top">
                                            <span class="text-muted">Transaction ID</span>
                                            <span class="fw-semibold">{{ $order->getway_transaction_id ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card admin-content-card h-100">
                        <div class="card-header">
                            <h5 class="mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Address</span>
                                <span class="fw-semibold text-end">{{ $order->address ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Device Category</span>
                                <span class="fw-semibold">{{ $order->device_category?->name ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Device Name</span>
                                <span class="fw-semibold">{{ $order->device_name ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Serial Number</span>
                                <span class="fw-semibold">{{ $order->serial_number ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Budget</span>
                                <span class="fw-semibold">{{ $order->budget ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Preferred Service Time</span>
                                <span class="fw-semibold">{{ $order->preferred_service_time ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Schedule Start</span>
                                <span class="fw-semibold">{{ $order->schedule_start_date ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2">
                                <span class="text-muted">Created At</span>
                                <span class="fw-semibold">{{ optional($order->created_at)->format('Y-m-d H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card admin-content-card h-100">
                        <div class="card-header">
                            <h5 class="mb-0">Accepted Offer</h5>
                        </div>
                        <div class="card-body">
                            @if($acceptedOffer)
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">Offer ID</span>
                                    <span class="fw-semibold">#{{ $acceptedOffer->id }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">Vendor</span>
                                    <span class="fw-semibold">{{ $acceptedOffer->provider?->name ?? '-' }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">Cost</span>
                                    <span class="fw-semibold">{{ number_format((float) ($acceptedOffer->cost ?? 0), 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">Delivery Time</span>
                                    <span class="fw-semibold">{{ $acceptedOffer->delivery_time ?? '-' }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">Warranty</span>
                                    <span class="fw-semibold">{{ $acceptedOffer->warranty ?? '-' }}</span>
                                </div>
                                <div class="pt-2">
                                    <div class="text-muted small mb-1">Notes</div>
                                    <div class="fw-semibold">{{ $acceptedOffer->notes ?? '-' }}</div>
                                </div>
                            @else
                                <div class="text-center text-muted py-5">No accepted offer is attached to this order yet.</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card admin-content-card">
                        <div class="card-header">
                            <h5 class="mb-0">Offers</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Offer</th>
                                            <th>Vendor</th>
                                            <th>Status</th>
                                            <th>Cost</th>
                                            <th>Delivery</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($order->offers->sortByDesc('id') as $offer)
                                            @php
                                                $offerStatus = strtolower((string) $offer->status);
                                                $offerLabel = $offerStatus === '2' || $offerStatus === 'accepted'
                                                    ? 'Accepted'
                                                    : ($offerStatus === '3' || $offerStatus === 'rejected' ? 'Rejected' : 'Pending');
                                                $offerClass = $offerLabel === 'Accepted'
                                                    ? 'bg-success-subtle text-success'
                                                    : ($offerLabel === 'Rejected' ? 'bg-danger-subtle text-danger' : 'bg-warning-subtle text-warning');
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
                                                <td colspan="6" class="text-center text-muted py-4">No offers found for this order.</td>
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
                            <h5 class="mb-0">Timeline</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Step</th>
                                            <th>Actor</th>
                                            <th>Timeline No</th>
                                            <th>Action At</th>
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
                                                <td colspan="4" class="text-center text-muted py-4">No timeline entries found.</td>
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
                            <h5 class="mb-0">Cancellation History</h5>
                        </div>
                        <div class="card-body">
                            @forelse($cancellationEntries as $entry)
                                <div class="border rounded-3 p-3 mb-3">
                                    <div class="fw-semibold mb-1">{{ timelineName((int) $entry->timeline_no) }}</div>
                                    <div class="text-muted small mb-2">Cancelled by {{ $entry->user?->name ?? ('User #' . ($entry->user_id ?? '-')) }}</div>
                                    <div class="small">{{ optional($entry->action_at ?? $entry->created_at)->format('Y-m-d H:i') }}</div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-5">No cancellation history recorded.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card admin-content-card">
                        <div class="card-header">
                            <h5 class="mb-0">Partial Receive</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                @forelse($partialReceives as $partialReceive)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="border rounded-3 p-3 h-100">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div class="fw-semibold">Partial #{{ $partialReceive->id }}</div>
                                                <span class="badge bg-info-subtle text-info">{{ optional($partialReceive->created_at)->format('Y-m-d') }}</span>
                                            </div>
                                            <div class="small text-muted mb-1">Offer ID</div>
                                            <div class="fw-semibold mb-3">{{ $partialReceive->offer_id ?? '-' }}</div>
                                            <div class="small text-muted mb-1">Received Quantity</div>
                                            <div class="fw-semibold mb-3">{{ $partialReceive->received_quantity ?? '-' }}</div>
                                            <div class="small text-muted mb-1">Received All</div>
                                            <div class="fw-semibold mb-3">{{ (int) ($partialReceive->received_all_quantity ?? 0) === 1 ? 'Yes' : 'No' }}</div>
                                            <div class="small text-muted mb-1">Reason</div>
                                            <div class="fw-semibold">{{ $partialReceive->reason_for_partial ?? '-' }}</div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="text-center text-muted py-4">No partial receive records found.</div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card admin-content-card">
                        <div class="card-header">
                            <h5 class="mb-0">Internal Notes</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $order->notes ?? 'No notes available for this order.' }}</p>
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
