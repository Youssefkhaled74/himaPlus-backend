@extends('layouts.admin.home')

@section('title')
    <title>Orders</title>
@endsection

@section('css')
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent" style="direction: ltr;">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"></li>
                                <li class="breadcrumb-item"><a href="{{route('admin/index')}}">Home</a></li>
                                <li class="breadcrumb-item active"><a href="{{route('admin/orders/index')}}/0/{{PAGINATION_COUNT}}">Orders</a></li>
                                <li class="active" style="color: var(--vz-breadcrumb-item-active-color);">Details</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            @php
                $orderType = match ((int) ($order->order_type ?? 0)) {
                    1 => 'Order',
                    2 => 'Quotation',
                    3 => 'Maintenance',
                    default => 'Unknown',
                };
            @endphp

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Order Details</h4>
                        </div>
                        <div class="card-body">
                            @isset($order)
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <ul class="list-group small shadow-sm rounded-3" style="padding: 0;">
                                            <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Order ID</span><span class="fw-semibold">{{ $order->id }}</span></li>
                                            <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Type</span><span class="fw-semibold">{{ $orderType }}</span></li>
                                            <li class="list-group-item d-flex justify-content-between"><span class="text-muted">User</span><span class="fw-semibold">{{ $order->user?->name ?? '-' }}</span></li>
                                            <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Provider</span><span class="fw-semibold">{{ $order->provider?->name ?? '-' }}</span></li>
                                            <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Address</span><span class="fw-semibold">{{ $order->address ?? '-' }}</span></li>
                                            <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Payment Status</span><span class="fw-semibold">{{ $order->payment_status ?? '-' }}</span></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group small shadow-sm rounded-3" style="padding: 0;">
                                            <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Items Cost</span><span class="fw-semibold">{{ $order->items_cost ?? '-' }}</span></li>
                                            <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Discount</span><span class="fw-semibold">{{ $order->discount ?? '-' }}</span></li>
                                            <li class="list-group-item d-flex justify-content-between"><span class="text-muted">VAT</span><span class="fw-semibold">{{ $order->vat ?? '-' }}</span></li>
                                            <li class="list-group-item d-flex justify-content-between"><span class="text-muted">VAT Amount</span><span class="fw-semibold">{{ $order->vat_amount ?? '-' }}</span></li>
                                            <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Delivery Fee</span><span class="fw-semibold">{{ $order->delivery_fee ?? '-' }}</span></li>
                                            <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Total Cost</span><span class="fw-semibold">{{ $order->total_cost ?? '-' }}</span></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card border">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">Notes</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="mb-0">{{ $order->notes ?? 'No notes available.' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <a href="{{ route('admin/orders/index') }}/0/{{ PAGINATION_COUNT }}" class="btn btn-light">Back To Orders</a>
                                    </div>
                                </div>
                            @endisset
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
