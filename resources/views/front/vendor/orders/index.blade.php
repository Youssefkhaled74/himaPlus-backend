@extends('layouts.front.home')

@section('title')
    <title>{{ __('nav.view_orders') ?? 'Orders' }} - Vendor | HemaPulse</title>
@endsection

@section('css')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    .vendor-orders,
    .vendor-orders *{font-family:"Poppins",system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;}

    :root{
        --vo-bg:#f5f6f8;
        --vo-card:#ffffff;
        --vo-border:#e8eaee;
        --vo-head:#f2f2f4;
        --vo-text:#1f2937;
        --vo-muted:#6b7280;
        --vo-primary:#0f4bbf;
        --vo-accent:#0ec6a0;
    }

    .vendor-orders{max-width:95%;margin:8% auto 0;background:var(--vo-bg);padding:8px 0 24px;}
    .vo-title{font-size:34px;font-weight:700;color:#0f2f7f;margin:0 0 14px;}

    .vo-tabs{display:flex;flex-wrap:wrap;gap:0;background:#efeff2;border-radius:10px;padding:0;margin-bottom:22px;overflow:hidden;}
    .vo-tab{padding:12px 28px;font-size:28px;font-weight:500;color:#2f3747;text-decoration:none;background:transparent;line-height:1.2;}
    .vo-tab:hover{color:#0f4bbf;}
    .vo-tab.active{background:linear-gradient(90deg,#0f4bbf 0%, #10b981 100%);color:#fff;}

    .vo-card{display:block;text-decoration:none;color:inherit;background:var(--vo-card);border:1px solid var(--vo-border);border-radius:12px;overflow:hidden;margin-bottom:18px;}
    .vo-card-head{background:var(--vo-head);padding:16px 22px;display:flex;align-items:center;justify-content:space-between;gap:12px;}
    .vo-card-head h6{margin:0;font-size:30px;font-weight:600;color:#21242c;}
    .vo-card-body{padding:18px 22px 16px;display:flex;align-items:center;justify-content:space-between;gap:12px;}

    .vo-name{font-size:38px;font-weight:600;line-height:1.1;margin-bottom:10px;color:#1f2633;}
    .vo-meta{margin:0;color:#5d6471;font-size:28px;line-height:1.5;}

    .vo-arrow{font-size:56px;color:#b0b5bf;line-height:1;}

    .vo-chip{display:inline-flex;align-items:center;padding:7px 14px;border-radius:8px;font-size:20px;font-weight:600;line-height:1;border:1px solid transparent;}
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

    .vo-pagination{display:flex;justify-content:center;margin-top:26px;}
    .vo-pagination .pagination{gap:8px;}
    .vo-pagination .page-link{min-width:42px;height:42px;border:1px solid #dce6fb;border-radius:10px;color:#2b4a8f;font-weight:600;display:inline-flex;align-items:center;justify-content:center;padding:0 10px;background:#eaf1ff;}
    .vo-pagination .page-item.active .page-link{background:linear-gradient(90deg,#0f4bbf 0%, #10b981 100%);border-color:transparent;color:#fff;}

    @media (max-width: 992px){
        .vo-tab{font-size:18px;padding:10px 16px;}
        .vo-card-head h6{font-size:18px;}
        .vo-name{font-size:24px;}
        .vo-meta{font-size:16px;}
        .vo-chip{font-size:14px;padding:6px 10px;}
        .vo-arrow{font-size:30px;}
    }
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
@endphp

<main class="vendor-orders">
    @include('flash::message')

    <h3 class="vo-title">{{ __('nav.view_orders') ?? 'Orders' }}</h3>

    <div class="vo-tabs">
        <a href="{{ route('vendor/orders', ['tab' => 'all']) }}" class="vo-tab {{ $tab === 'all' ? 'active' : '' }}">{{ __('All') }}</a>
        <a href="{{ route('vendor/orders', ['tab' => 'purchase']) }}" class="vo-tab {{ $tab === 'purchase' ? 'active' : '' }}">{{ __('Purchase Orders') }}</a>
        <a href="{{ route('vendor/orders', ['tab' => 'quotations']) }}" class="vo-tab {{ $tab === 'quotations' ? 'active' : '' }}">{{ __('Quotations') }}</a>
        <a href="{{ route('vendor/orders', ['tab' => 'maintenance']) }}" class="vo-tab {{ $tab === 'maintenance' ? 'active' : '' }}">{{ __('Maintenance') }}</a>
        <a href="{{ route('vendor/orders', ['tab' => 'scheduled']) }}" class="vo-tab {{ $tab === 'scheduled' ? 'active' : '' }}">{{ __('Scheduled Orders') }}</a>
    </div>

    @forelse($orders as $order)
        @php
            $lastTimelineNo = optional($order->timeline->sortByDesc('timeline_no')->first())->timeline_no;
            $lastTimelineLabel = strtolower(trim((string) timelineName((int) $lastTimelineNo)));
            $myOffer = $order->offers->where('provider_id', auth()->id())->first();

            if ((int) $order->request_type === 2) {
                $statusText = ucfirst($order->scheduled_status);
                $statusKey = strtolower($order->scheduled_status);
                $title = __('Scheduled Order') ?? 'Scheduled Order';
            } else {
                if ((int) $order->order_type === 1) {
                    $title = __('Purchase Order') ?? 'Purchase Order';
                } elseif ((int) $order->order_type === 2) {
                    $title = __('Quotation Request') ?? 'Quotation Request';
                } else {
                    $title = __('Maintenance Request') ?? 'Maintenance Request';
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
                    $statusText = ucwords($lastTimelineLabel !== '---' ? $lastTimelineLabel : 'Pending');
                    $statusKey = $lastTimelineLabel !== '---' ? $lastTimelineLabel : 'pending';
                }
            }

            $statusClass = $statusClasses[$statusKey] ?? 'chip-pending';
        @endphp

        <a href="{{ route('vendor/orders/show', $order->id) }}" class="vo-card">
            <div class="vo-card-head">
                <h6>{{ $title }}</h6>
                <span class="vo-chip {{ $statusClass }}">{{ $statusText }}</span>
            </div>
            <div class="vo-card-body">
                <div>
                    <div class="vo-name">
                        @if((int)$order->request_type === 2)
                            {{ $order->device_name ?: (__('Scheduled Supply') ?? 'Scheduled Supply') }}
                        @else
                            @if((int)$order->order_type === 3)
                                {{ __('Request') ?? 'Request' }} #{{ $order->id }} - {{ $order->created_at->format('M d, Y') }}
                            @elseif((int)$order->order_type === 2)
                                {{ __('Request') ?? 'Request' }} #{{ $order->id }} - {{ $order->created_at->format('M d, Y') }}
                            @else
                                {{ __('Order') ?? 'Order' }} #{{ $order->id }} - {{ $order->created_at->format('M d, Y') }}
                            @endif
                        @endif
                    </div>
                    @if((int)$order->request_type === 2)
                        @php
                            $start = $order->schedule_start_date ? \Carbon\Carbon::parse($order->schedule_start_date) : null;
                            $end = $start ? (clone $start)->addMonths(3) : null;
                        @endphp
                        <p class="vo-meta">{{ __('Duration') ?? 'Duration' }}: {{ $start ? $start->format('M d') : '—' }} – {{ $end ? $end->format('M d, Y') : '—' }}</p>
                        <p class="vo-meta">{{ __('Frequency') ?? 'Frequency' }}: {{ $order->frequency ?: '—' }}</p>
                        <p class="vo-meta">{{ __('Next Shipment') ?? 'Next Shipment' }}: {{ $order->delivery_duration ?: '—' }}</p>
                    @elseif((int)$order->order_type === 3)
                        <p class="vo-meta">{{ __('Device') ?? 'Device' }}: {{ $order->device_name ?: '—' }}</p>
                        <p class="vo-meta">{{ __('Hospital') ?? 'Hospital' }}: {{ $order->user->name ?? '—' }}</p>
                        <p class="vo-meta">{{ __('Assigned To') ?? 'Assigned To' }}: {{ __('Technician who finished the job') }}</p>
                    @else
                        <p class="vo-meta">{{ __('Product') ?? 'Product' }}: {{ optional($order->items->first())->product->name ?? ($order->device_name ?: '—') }} @if($order->items->count()) - {{ $order->items->sum('quantity') }} {{ __('Units') ?? 'Units' }} @endif</p>
                        <p class="vo-meta">{{ __('Hospital') ?? 'Hospital' }}: {{ $order->user->name ?? '—' }}</p>
                        <p class="vo-meta">{{ __('Total') ?? 'Total' }}: {{ number_format((float)($order->total_cost ?? 0), 0) }} {{ __('SAR') ?? 'SAR' }}</p>
                    @endif
                </div>
                <span class="vo-arrow"><i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i></span>
            </div>
        </a>
    @empty
        <div class="alert alert-light border">{{ __('No orders found.') ?? 'No orders found.' }}</div>
    @endforelse

    <div class="vo-pagination">
        {{ $orders->appends(['tab' => $tab, 'status' => $status, 'search' => $search])->links('pagination::bootstrap-4') }}
    </div>
</main>
@endsection
