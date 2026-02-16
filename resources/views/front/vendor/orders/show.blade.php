@extends('layouts.front.home')

@section('title')
    <title>{{ __('nav.order_details') ?? 'Order Details' }} #{{ $order->id }} - Vendor | HemaPulse</title>
@endsection

@section('css')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    .vendor-order-show,
    .vendor-order-show *{font-family:"Poppins",system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;}

    :root{
        --vos-bg:#f5f6f8;
        --vos-card:#ffffff;
        --vos-border:#e6e8ed;
        --vos-title:#1f2937;
        --vos-muted:#6b7280;
        --vos-primary:#0f4bbf;
        --vos-accent:#0ec6a0;
    }

    .vendor-order-show{max-width:95%;margin:8% auto 0;padding-bottom:28px;background:var(--vos-bg);}

    .vos-breadcrumb{font-size:16px;color:#6d7482;display:flex;align-items:center;gap:10px;margin-bottom:18px;}
    .vos-breadcrumb a{text-decoration:none;color:#6d7482;}
    .vos-breadcrumb .current{color:#0f3f9f;font-weight:600;}
    .vos-breadcrumb i{color:#0ec6a0;font-size:12px;}

    .vos-grid{display:grid;grid-template-columns:1.35fr .95fr;gap:18px;align-items:start;}
    .vos-card{background:var(--vos-card);border:1px solid var(--vos-border);border-radius:16px;padding:20px 22px;}
    .vos-card h4,.vos-card h5{margin:0 0 14px;color:var(--vos-title);font-weight:600;}
    .vos-card h4{font-size:42px;}
    .vos-card h5{font-size:34px;}

    .vos-rows{display:grid;gap:10px;}
    .vos-row{display:flex;justify-content:space-between;gap:14px;align-items:flex-start;}
    .vos-key{font-size:31px;color:#3b4453;font-weight:500;}
    .vos-val{font-size:31px;color:#313844;font-weight:500;text-align:right;max-width:62%;line-height:1.25;}

    .vos-payment .vos-key,.vos-payment .vos-val{font-size:30px;}
    .vos-total .vos-key,.vos-total .vos-val{font-weight:700;color:#1f2937;}

    .vos-actions{display:flex;gap:12px;flex-wrap:wrap;}
    .btn-vos{
        min-height:64px;border-radius:12px;border:1px solid transparent;padding:0 24px;
        font-size:29px;font-weight:600;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;
    }
    .btn-vos-main{background:linear-gradient(90deg,#0f4bbf 0%, #10b981 100%);color:#fff;}
    .btn-vos-main:hover{color:#fff;filter:brightness(.98);}
    .btn-vos-outline{background:#fff;color:#0f3f9f;border-color:#0f4bbf;}

    .vos-alert{border:2px solid #2d67d8;background:#f8fbff;border-radius:12px;padding:12px 14px;color:#214eb5;font-size:27px;font-weight:600;line-height:1.35;}

    .vos-timeline .line{position:relative;padding-left:38px;}
    .vos-timeline .line::before{content:"";position:absolute;left:11px;top:10px;bottom:10px;border-left:2px dashed #d5dae2;}
    .vos-step{position:relative;padding:10px 0 14px;}
    .vos-step .dot{position:absolute;left:-2px;top:14px;width:24px;height:24px;border-radius:50%;background:#a3a7af;display:grid;place-items:center;color:#fff;font-size:13px;}
    .vos-step.done .dot{background:linear-gradient(90deg,#0f4bbf,#10b981);}
    .vos-step .name{font-size:30px;font-weight:600;color:#0f3f9f;line-height:1.2;}
    .vos-step .date{font-size:25px;color:#7a8292;line-height:1.2;}
    .vos-step.pending .name{color:#9aa1af;}

    .vos-contact{background:#f0f1f3;border-radius:10px;padding:12px 14px;display:flex;justify-content:space-between;align-items:center;gap:12px;}
    .vos-contact-name{font-size:28px;font-weight:600;color:#1f2937;}
    .vos-contact-phone{font-size:23px;color:#7a8292;}
    .vos-contact-actions{display:flex;gap:10px;}
    .vos-circle{width:40px;height:40px;border-radius:50%;display:grid;place-items:center;color:#fff;background:linear-gradient(90deg,#0f4bbf,#10b981);text-decoration:none;}

    .vos-offer{border:1px solid var(--vos-border);border-radius:12px;overflow:hidden;}
    .vos-offer-head{background:#f3f4f6;padding:12px 14px;font-size:28px;font-weight:600;color:#303846;}
    .vos-offer-body{padding:14px;}
    .vos-file{display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid #eceef2;margin-bottom:10px;}
    .vos-file a{text-decoration:none;color:#2f3747;font-size:27px;}
    .vos-offer-line{font-size:27px;color:#6b7280;line-height:1.5;}

    @media (max-width: 1200px){
        .vos-grid{grid-template-columns:1fr;}
    }
    @media (max-width: 992px){
        .vos-card h4{font-size:28px;}
        .vos-card h5{font-size:22px;}
        .vos-key,.vos-val,.vos-payment .vos-key,.vos-payment .vos-val{font-size:16px;}
        .btn-vos{font-size:16px;min-height:48px;width:100%;}
        .vos-step .name{font-size:16px;}
        .vos-step .date,.vos-contact-name,.vos-offer-head,.vos-offer-line,.vos-alert,.vos-file a{font-size:14px;}
    }
</style>
@endsection

@section('content')
@php
    $timeline = $order->timeline->sortBy('timeline_no')->values();
    $timelineNos = $timeline->pluck('timeline_no')->map(fn($n)=>(int)$n)->all();
    $lastTimelineNo = (int) ($timeline->last()->timeline_no ?? 0);
    $isScheduled = (int)$order->request_type === 2;
    $isQuotation = (int)$order->order_type === 2;

    $currentStatus = 'Pending';
    if ($isScheduled) {
        $currentStatus = ucfirst($order->scheduled_status);
    } elseif ($lastTimelineNo > 0) {
        $currentStatus = timelineName($lastTimelineNo);
    }

    $actionLabel = null;
    if ($isQuotation) {
        if (!$myOffer) {
            $actionLabel = __('Send Offer') ?? 'Send Offer';
        } else {
            $offerStatus = strtolower((string)$myOffer->status);
            if ($offerStatus === '3' || $offerStatus === 'rejected') {
                $actionLabel = __('Resubmit Offer') ?? 'Resubmit Offer';
            } elseif ($offerStatus === '2' || $offerStatus === 'accepted') {
                if ($lastTimelineNo >= 4 && $lastTimelineNo < 5) {
                    $actionLabel = __('Mark as Delivered') ?? 'Mark as Delivered';
                } elseif ($lastTimelineNo >= 3 && $lastTimelineNo < 4) {
                    $actionLabel = __('Mark as Shipped') ?? 'Mark as Shipped';
                } elseif ($lastTimelineNo >= 2 && $lastTimelineNo < 3) {
                    $actionLabel = __('Mark as Processing') ?? 'Mark as Processing';
                }
            } else {
                $actionLabel = __('Edit Offer') ?? 'Edit Offer';
            }
        }
    } elseif ($isScheduled) {
        if (in_array(strtolower($order->scheduled_status), ['upcoming','active','paused'])) {
            $actionLabel = __('Mark as Shipped') ?? 'Mark as Shipped';
        } elseif (strtolower($order->scheduled_status) === 'completed') {
            $actionLabel = __('Mark as Completed') ?? 'Mark as Completed';
        } elseif (strtolower($order->scheduled_status) === 'cancelled') {
            $actionLabel = __('Cancelled') ?? 'Cancelled';
        }
    } else {
        if ($lastTimelineNo >= 5 && $lastTimelineNo < 6) {
            $actionLabel = __('Mark as Completed') ?? 'Mark as Completed';
        } elseif ($lastTimelineNo >= 4 && $lastTimelineNo < 5) {
            $actionLabel = __('Mark as Delivered') ?? 'Mark as Delivered';
        } elseif ($lastTimelineNo >= 3 && $lastTimelineNo < 4) {
            $actionLabel = __('Mark as Shipped') ?? 'Mark as Shipped';
        } elseif ($lastTimelineNo >= 2 && $lastTimelineNo < 3) {
            $actionLabel = __('Mark as Processing') ?? 'Mark as Processing';
        } elseif ($lastTimelineNo === 1) {
            $actionLabel = __('Confirmed') ?? 'Confirmed';
        }
    }

    $timelineSteps = $isQuotation
        ? [1,7,9,3,4,5]
        : ($isScheduled ? [1,2,3,4,5,6] : [1,2,3,4,5,6]);
@endphp

<main class="vendor-order-show">
    @include('flash::message')

    <nav class="vos-breadcrumb">
        @if($isQuotation)
            <a href="{{ route('vendor/orders', ['tab' => 'quotations']) }}">{{ __('Requests') ?? 'Requests' }}</a>
            <i class="bi bi-chevron-right"></i>
            <span class="current">{{ __('Requests Details') ?? 'Requests Details' }}</span>
        @elseif($isScheduled)
            <a href="{{ route('vendor/orders') }}">{{ __('Orders') ?? 'Orders' }}</a>
            <i class="bi bi-chevron-right"></i>
            <a href="{{ route('vendor/orders', ['tab' => 'scheduled']) }}">{{ __('Scheduled Orders') ?? 'Scheduled Orders' }}</a>
            <i class="bi bi-chevron-right"></i>
            <span class="current">{{ __('Order Details') ?? 'Order Details' }}</span>
        @else
            <a href="{{ route('vendor/orders') }}">{{ __('Orders') ?? 'Orders' }}</a>
            <i class="bi bi-chevron-right"></i>
            <span class="current">{{ __('Order Details') ?? 'Order Details' }}</span>
        @endif
    </nav>

    <div class="vos-grid">
        <div>
            <div class="vos-card">
                <h5>{{ __('Order Details') ?? 'Order Details' }}</h5>
                <div class="vos-rows">
                    <div class="vos-row"><span class="vos-key">{{ __('Request Number') ?? 'Request Number' }}</span><span class="vos-val">#{{ $order->id }}</span></div>
                    <div class="vos-row"><span class="vos-key">{{ __('Delivery Address') ?? 'Delivery Address' }}</span><span class="vos-val">{{ $order->address ?: '—' }}</span></div>
                    @if($isScheduled)
                        <div class="vos-row"><span class="vos-key">{{ __('Supplier') ?? 'Supplier' }}</span><span class="vos-val">{{ auth()->user()->company_name ?? auth()->user()->name }}</span></div>
                    @endif
                    <div class="vos-row"><span class="vos-key">{{ __('Payment Method') ?? 'Payment Method' }}</span><span class="vos-val">{{ $order->payment_type ?: ($order->payment_status ?: '—') }}</span></div>
                    <div class="vos-row"><span class="vos-key">{{ __('Status') ?? 'Status' }}</span><span class="vos-val">{{ $currentStatus }}</span></div>
                    @if($isScheduled)
                        @php
                            $start = $order->schedule_start_date ? \Carbon\Carbon::parse($order->schedule_start_date) : null;
                            $end = $start ? (clone $start)->addMonths(3) : null;
                        @endphp
                        <div class="vos-row"><span class="vos-key">{{ __('Duration') ?? 'Duration' }}</span><span class="vos-val">{{ $start ? $start->format('M d') : '—' }} – {{ $end ? $end->format('M d, Y') : '—' }}</span></div>
                    @endif
                    <div class="vos-row"><span class="vos-key">{{ __('Date') ?? 'Date' }}</span><span class="vos-val">{{ $order->created_at->format('M d, Y') }}</span></div>
                </div>
            </div>

            @if($isScheduled)
                <div class="vos-card" style="margin-top:14px;">
                    <h5>{{ __('Note') ?? 'Note' }}</h5>
                    <div class="vos-offer-line">{{ $order->notes ?: __('No notes provided.') }}</div>
                </div>
            @endif

            <div class="vos-card" style="margin-top:14px;">
                <h5>{{ __('Products Requested') ?? 'Products Requested' }}</h5>
                @if($order->items && $order->items->count())
                    <div class="vos-rows">
                        @foreach($order->items as $item)
                            <div class="vos-row">
                                <span class="vos-key">{{ $item->product->name ?? 'Product' }}</span>
                                <span class="vos-val">{{ $item->quantity }} {{ __('Units') ?? 'Units' }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="vos-rows">
                        <div class="vos-row"><span class="vos-key">{{ $order->device_name ?: 'X-Ray Machine' }}</span><span class="vos-val">2 {{ __('Units') ?? 'Units' }}</span></div>
                        <div class="vos-row"><span class="vos-key">Surgical Gloves</span><span class="vos-val">500 Boxes</span></div>
                        <div class="vos-row"><span class="vos-key">Surgical Gloves</span><span class="vos-val">500 Boxes</span></div>
                    </div>
                @endif

                @if($isScheduled && is_array($order->files) && count(array_filter($order->files)) > 0)
                    <div class="vos-offer" style="margin-top:14px;">
                        <div class="vos-offer-body">
                            @foreach($order->files as $f)
                                @if($f)
                                    <div class="vos-file">
                                        <a href="{{ asset($f) }}" target="_blank"><i class="bi bi-file-earmark-text"></i> {{ basename($f) }}</a>
                                        <i class="bi bi-download"></i>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="vos-card vos-timeline" style="margin-top:14px;">
                <h5>{{ __('Timeline') ?? 'Timeline' }}</h5>
                <div class="line">
                    @foreach($timelineSteps as $stepNo)
                        @php
                            $done = in_array($stepNo, $timelineNos, true);
                            $entry = $timeline->firstWhere('timeline_no', $stepNo);
                        @endphp
                        <div class="vos-step {{ $done ? 'done' : 'pending' }}">
                            <span class="dot"><i class="bi bi-check"></i></span>
                            <div class="name">{{ timelineName($stepNo) }}</div>
                            <div class="date">{{ $entry ? $entry->created_at->format('M j') : 'Sep 10' }}</div>
                        </div>
                    @endforeach
                    @if($myOffer && in_array(strtolower((string)$myOffer->status), ['3','rejected'], true))
                        <div class="vos-step done">
                            <span class="dot"><i class="bi bi-check"></i></span>
                            <div class="name">{{ __('Offer Rejected') ?? 'Offer Rejected' }}</div>
                            <div class="date">{{ optional($myOffer->updated_at)->format('M j') }}</div>
                        </div>
                    @endif
                </div>
            </div>

            @if($order->user)
                <div class="vos-card" style="margin-top:14px;">
                    <h5>{{ __('Contact us') ?? 'Contact us' }}</h5>
                    <div class="vos-contact">
                        <div>
                            <div class="vos-contact-name">{{ $order->user->company_name ?? $order->user->name }}</div>
                            <div class="vos-contact-phone">{{ $order->user->mobile ?? '+966-1234567' }}</div>
                        </div>
                        <div class="vos-contact-actions">
                            @if($order->user->mobile)
                                <a class="vos-circle" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->user->mobile) }}" target="_blank"><i class="bi bi-whatsapp"></i></a>
                                <a class="vos-circle" href="tel:{{ $order->user->mobile }}"><i class="bi bi-telephone"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if($isQuotation && $myOffer)
                <div class="vos-card" style="margin-top:14px;">
                    <h5>{{ __('My Offer') ?? 'My Offer' }}</h5>
                    <div class="vos-offer">
                        <div class="vos-offer-head">{{ __('My offer') ?? 'My offer' }}</div>
                        <div class="vos-offer-body">
                            <div class="vos-file">
                                <a href="{{ is_array($myOffer->files) && !empty($myOffer->files[0]) ? asset($myOffer->files[0]) : '#' }}" target="_blank">
                                    <i class="bi bi-file-earmark-pdf"></i> {{ is_array($myOffer->files) && !empty($myOffer->files[0]) ? basename($myOffer->files[0]) : 'quotation.pdf' }}
                                </a>
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <div class="vos-offer-line">Total Price: {{ number_format((float)($myOffer->cost ?? 0), 0) }} {{ __('SAR') ?? 'SAR' }}</div>
                            <div class="vos-offer-line">Delivery Time: {{ $myOffer->delivery_time ?? 0 }} {{ __('Days') ?? 'Days' }}</div>
                            <div class="vos-offer-line">Warranty: {{ $myOffer->warranty ?? '—' }}</div>
                            <div class="vos-offer-line">Notes: {{ $myOffer->notes ?? '—' }}</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div>
            <div class="vos-card vos-payment">
                <h5>{{ __('Payment Details') ?? 'Payment Details' }}</h5>
                <div class="vos-rows">
                    <div class="vos-row"><span class="vos-key">{{ __('Subtotal') ?? 'Subtotal' }}</span><span class="vos-val">{{ number_format((float)($order->items_cost ?? $order->total_before_discount ?? $order->total_cost ?? 0), 0) }} {{ __('SAR') ?? 'SAR' }}</span></div>
                    <div class="vos-row"><span class="vos-key">{{ __('VAT(10%)') ?? 'VAT(10%)' }}</span><span class="vos-val">{{ number_format((float)($order->vat_amount ?? 0), 0) }} {{ __('SAR') ?? 'SAR' }}</span></div>
                    <div class="vos-row"><span class="vos-key">{{ __('Delivery Fee') ?? 'Delivery Fee' }}</span><span class="vos-val">{{ number_format((float)($order->delivery_fee ?? 0), 0) }} {{ __('SAR') ?? 'SAR' }}</span></div>
                    <div class="vos-row vos-total"><span class="vos-key">{{ __('Net Total') ?? 'Net Total' }}</span><span class="vos-val">{{ number_format((float)($order->total_cost ?? 0), 0) }} {{ __('SAR') ?? 'SAR' }}</span></div>
                </div>
            </div>

            <div style="margin-top:14px;">
                @if($isQuotation && $myOffer && in_array(strtolower((string)$myOffer->status), ['3','rejected'], true))
                    <div class="vos-alert" style="margin-bottom:12px;">
                        <i class="bi bi-exclamation-triangle"></i>
                        {{ __('Your offer was rejected. Reason:') ?? 'Your offer was rejected. Reason:' }}
                        {{ $myOffer->rejected_reson ?: __('Price too high. The client requests a lower price.') }}
                    </div>
                    <div class="vos-actions">
                        <a href="{{ route('vendor/orders/offer-edit', $myOffer->id) }}" class="btn-vos btn-vos-main" style="width:100%;">{{ __('Resubmit Offer') ?? 'Resubmit Offer' }}</a>
                    </div>
                @elseif($isQuotation && !$myOffer)
                    <div class="vos-actions">
                        <a href="{{ route('vendor/orders/offer-form', $order->id) }}" class="btn-vos btn-vos-main" style="width:100%;">{{ __('Send Offer') ?? 'Send Offer' }}</a>
                    </div>
                @elseif($isQuotation && $myOffer && (string)$myOffer->status === '1')
                    <div class="vos-actions">
                        <form method="POST" action="{{ route('vendor/orders/offer-delete', $myOffer->id) }}" style="flex:1;" onsubmit="return confirm('Delete this offer?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-vos btn-vos-outline" style="width:100%;">{{ __('Cancel Offer') ?? 'Cancel Offer' }}</button>
                        </form>
                        <a href="{{ route('vendor/orders/offer-edit', $myOffer->id) }}" class="btn-vos btn-vos-main" style="flex:1;">{{ __('Edit Offer') ?? 'Edit Offer' }}</a>
                    </div>
                @elseif($actionLabel)
                    <div class="vos-actions">
                        <button type="button" class="btn-vos {{ strtolower($actionLabel) === 'cancelled' ? 'btn-vos-outline' : 'btn-vos-main' }}" style="width:100%;">{{ $actionLabel }}</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
