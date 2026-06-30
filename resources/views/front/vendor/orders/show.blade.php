@extends('layouts.front.home')

@section('title')
    <title>{{ trans_or_fallback('', '') }} #{{ $order->id }} - Vendor | Hema</title>
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

    .vendor-order-show{max-width:95%;margin:12px auto 0;padding-bottom:28px;background:var(--vos-bg);}

    .vos-breadcrumb{font-size:15px;color:#6d7482;display:flex;align-items:center;gap:10px;margin-bottom:18px;}
    .vos-breadcrumb a{text-decoration:none;color:#6d7482;}
    .vos-breadcrumb .current{color:#0f3f9f;font-weight:600;}
    .vos-breadcrumb i{color:#0ec6a0;font-size:12px;}

    .vos-grid{display:grid;grid-template-columns:1.35fr .95fr;gap:18px;align-items:start;}
    .vos-card{background:var(--vos-card);border:1px solid var(--vos-border);border-radius:16px;padding:20px 22px;}
    .vos-card h4,.vos-card h5{margin:0 0 14px;color:var(--vos-title);font-weight:600;}
    .vos-card h4{font-size:24px;}
    .vos-card h5{font-size:18px;}

    .vos-rows{display:grid;gap:10px;}
    .vos-row{display:flex;justify-content:space-between;gap:14px;align-items:flex-start;}
    .vos-key{font-size:15px;color:#3b4453;font-weight:500;}
    .vos-val{font-size:15px;color:#313844;font-weight:500;text-align:right;max-width:62%;line-height:1.35;}

    .vos-payment .vos-key,.vos-payment .vos-val{font-size:15px;}
    .vos-total .vos-key,.vos-total .vos-val{font-weight:700;color:#1f2937;}

    .vos-actions{display:flex;gap:12px;flex-wrap:wrap;}
    .btn-vos{
        min-height:64px;border-radius:12px;border:1px solid transparent;padding:0 24px;
        font-size:18px;font-weight:600;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;
    }
    .btn-vos-main{background:linear-gradient(90deg,#0f4bbf 0%, #10b981 100%);color:#fff;}
    .btn-vos-main:hover{color:#fff;filter:brightness(.98);}
    .btn-vos-outline{background:#fff;color:#0f3f9f;border-color:#0f4bbf;}
    .btn-vos-danger{background:#fff;color:#d14343;border-color:#e8a4a4;}
    .btn-vos-danger:hover{color:#be2f2f;border-color:#d98282;background:#fff5f5;}

    .vos-alert{border:2px solid #2d67d8;background:#f8fbff;border-radius:12px;padding:12px 14px;color:#214eb5;font-size:15px;font-weight:600;line-height:1.35;}

    .vos-timeline .line{position:relative;padding-left:10px;}
    .vos-timeline .line::before{content:"";position:absolute;left:11px;top:10px;bottom:10px;border-left:2px dashed #d5dae2;}
    .vos-step{position:relative;display:flex;gap:14px;align-items:flex-start;padding:10px 0 14px;}
    .vos-step .dot{position:relative;z-index:1;flex:0 0 24px;width:24px;height:24px;border-radius:50%;background:#a3a7af;display:grid;place-items:center;color:#fff;font-size:13px;margin-left:-10px;}
    .vos-step.done .dot{background:linear-gradient(90deg,#0f4bbf,#10b981);}
    .vos-step-copy{display:flex;flex-direction:column;gap:4px;padding-top:1px;}
    .vos-step .name{font-size:15px;font-weight:600;color:#0f3f9f;line-height:1.2;margin:0;}
    .vos-step .date{font-size:13px;color:#7a8292;line-height:1.2;margin:0;}
    .vos-step.pending .name{color:#9aa1af;}

    .vos-contact{background:#f0f1f3;border-radius:10px;padding:12px 14px;display:flex;justify-content:space-between;align-items:center;gap:12px;}
    .vos-contact-name{font-size:16px;font-weight:600;color:#1f2937;}
    .vos-contact-phone{font-size:14px;color:#7a8292;}
    .vos-contact-actions{display:flex;gap:10px;}
    .vos-circle{width:40px;height:40px;border-radius:50%;display:grid;place-items:center;color:#fff;background:linear-gradient(90deg,#0f4bbf,#10b981);text-decoration:none;}

    .vos-offer{border:1px solid var(--vos-border);border-radius:12px;overflow:hidden;}
    .vos-offer-head{background:#f3f4f6;padding:12px 14px;font-size:16px;font-weight:600;color:#303846;}
    .vos-offer-body{padding:14px;}
    .vos-file{display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid #eceef2;margin-bottom:10px;}
    .vos-file a{text-decoration:none;color:#2f3747;font-size:14px;}
    .vos-offer-line{font-size:14px;color:#6b7280;line-height:1.5;}

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
    $statusState = $order->front_status_state ?? $order->front_status ?? ['key' => 'pending', 'text' => 'Pending', 'class' => 'chip-pending'];

    $currentStatus = $statusState['text'];

    $actionLabel = null;
    $timelineActionNo = null;
    $showPendingConfirmActions = false;
    $isMaintenance = (int)$order->order_type === 3;
    $__stepMap = match ((int)$order->order_type) {
        1 => [1 => 3, 3 => 4, 4 => 5, 5 => 6],
        2 => [1 => 7, 7 => 9, 9 => 6],
        3 => [1 => 7, 7 => 9, 9 => 6],
        default => [],
    };
    $nextTimelineNo = $__stepMap[$lastTimelineNo] ?? null;

    if ($isQuotation) {
        if (!$myOffer) {
            $actionLabel = trans_or_fallback('', '');
        } else {
            $offerStatus = strtolower((string)$myOffer->status);
            if ($offerStatus === '3' || $offerStatus === 'rejected') {
                $actionLabel = trans_or_fallback('', '');
            } elseif ($offerStatus === '2' || $offerStatus === 'accepted') {
                if ($nextTimelineNo === 7) {
                    $actionLabel = trans_or_fallback('', '');
                    $timelineActionNo = 7;
                } elseif ($nextTimelineNo === 9) {
                    $actionLabel = trans_or_fallback('', '');
                    $timelineActionNo = 9;
                } elseif ($nextTimelineNo === 6) {
                    $actionLabel = trans_or_fallback('', '');
                    $timelineActionNo = 6;
                }
            } else {
                $actionLabel = trans_or_fallback('', '');
            }
        }
    } elseif ($isMaintenance) {
        if ($nextTimelineNo === 7) {
            $actionLabel = trans_or_fallback('', '');
            $timelineActionNo = 7;
        } elseif ($nextTimelineNo === 9) {
            $actionLabel = trans_or_fallback('', '');
            $timelineActionNo = 9;
        } elseif ($nextTimelineNo === 6) {
            $actionLabel = trans_or_fallback('', '');
            $timelineActionNo = 6;
        }
    } elseif ($isScheduled) {
        if (in_array($statusState['key'], ['scheduled', 'active_scheduled'], true)) {
            $actionLabel = trans_or_fallback('', '');
        } elseif ($statusState['key'] === 'completed_scheduled') {
            $actionLabel = trans_or_fallback('', '');
        } elseif ($statusState['key'] === 'cancelled') {
            $actionLabel = trans_or_fallback('', '');
        }
    } else {
        // Purchase order
        if ($nextTimelineNo === 3) {
            $actionLabel = trans_or_fallback('', '');
            $timelineActionNo = 3;
        } elseif ($nextTimelineNo === 4) {
            $actionLabel = trans_or_fallback('', '');
            $timelineActionNo = 4;
        } elseif ($nextTimelineNo === 5) {
            $actionLabel = trans_or_fallback('', '');
            $timelineActionNo = 5;
        } elseif ($nextTimelineNo === 6) {
            $actionLabel = trans_or_fallback('', '');
            $timelineActionNo = 6;
        }
    }

    $timelineSteps = $isQuotation
        ? [1,7,9,6]
        : ($isMaintenance ? [1,7,9,6] : ($isScheduled ? [1,2,3,4,5,6] : [1,3,4,5,6]));

    $isAr = app()->getLocale() === 'ar';
    $tr = function ($text) use ($isAr) {
        if (!$isAr) {
            return $text;
        }
        $map = [
            'pending' => 'Ù‚ÙŠØ¯ Ø§Ù„Ø§Ù†ØªØ¸Ø§Ø±',
            'confirmed' => 'ØªÙ… Ø§Ù„ØªØ£ÙƒÙŠØ¯',
            'under review' => 'Ù‚ÙŠØ¯ Ø§Ù„Ù…Ø±Ø§Ø¬Ø¹Ø©',
            'processing' => 'Ù‚ÙŠØ¯ Ø§Ù„Ù…Ø¹Ø§Ù„Ø¬Ø©',
            'shipped' => 'ØªÙ… Ø§Ù„Ø´Ø­Ù†',
            'delivered' => 'ØªÙ… Ø§Ù„ØªØ³Ù„ÙŠÙ…',
            'completed' => 'Ù…ÙƒØªÙ…Ù„',
            'cancelled' => 'Ù…Ù„ØºÙŠ',
            'canceled' => 'Ù…Ù„ØºÙŠ',
            'rejected' => 'Ù…Ø±ÙÙˆØ¶',
            'paused' => 'Ù…ØªÙˆÙ‚Ù',
            'upcoming' => 'Ù‚Ø§Ø¯Ù…',
            'active' => 'Ù†Ø´Ø·',
            'offers received' => 'ØªÙ… Ø§Ø³ØªÙ„Ø§Ù… Ø§Ù„Ø¹Ø±ÙˆØ¶',
            'supplier selected' => 'ØªÙ… Ø§Ø®ØªÙŠØ§Ø± Ø§Ù„Ù…ÙˆØ±Ø¯',
            'converted to order' => 'ØªÙ… Ø§Ù„ØªØ­ÙˆÙŠÙ„ Ø¥Ù„Ù‰ Ø·Ù„Ø¨',
            'assigned to supplier' => 'ØªÙ… Ø§Ù„ØªØ¹ÙŠÙŠÙ† Ø¥Ù„Ù‰ Ø§Ù„Ù…ÙˆØ±Ø¯',
            'on hold' => 'Ù…Ø¹Ù„Ù‚',
            'order created' => 'ØªÙ… Ø¥Ù†Ø´Ø§Ø¡ Ø§Ù„Ø·Ù„Ø¨',
            'edit offer' => 'ØªØ¹Ø¯ÙŠÙ„ Ø§Ù„Ø¹Ø±Ø¶',
            'cancel offer' => 'Ø¥Ù„ØºØ§Ø¡ Ø§Ù„Ø¹Ø±Ø¶',
            'send offer' => 'Ø¥Ø±Ø³Ø§Ù„ Ø¹Ø±Ø¶',
            'resubmit offer' => 'Ø¥Ø¹Ø§Ø¯Ø© ØªÙ‚Ø¯ÙŠÙ… Ø§Ù„Ø¹Ø±Ø¶',
            'mark as processing' => 'ØªØ­Ø¯ÙŠØ¯ ÙƒÙ‚ÙŠØ¯ Ø§Ù„Ù…Ø¹Ø§Ù„Ø¬Ø©',
            'mark as shipped' => 'ØªØ­Ø¯ÙŠØ¯ ÙƒØªÙ… Ø§Ù„Ø´Ø­Ù†',
            'mark as delivered' => 'ØªØ­Ø¯ÙŠØ¯ ÙƒØªÙ… Ø§Ù„ØªØ³Ù„ÙŠÙ…',
            'mark as completed' => 'ØªØ­Ø¯ÙŠØ¯ ÙƒÙ…ÙƒØªÙ…Ù„',
            'mark as offer prepared' => 'ØªØ­Ø¯ÙŠØ¯ ÙƒÙ…Ø¹Ø¯',
            'mark as offer sent' => 'ØªØ­Ø¯ÙŠØ¯ ÙƒØ¥Ø±Ø³Ø§Ù„ Ø§Ù„Ø¹Ø±Ø¶',
            'mark as appointment set' => 'ØªØ­Ø¯ÙŠØ¯ Ù…ÙˆØ¹Ø¯',
            'mark as in progress' => 'ØªØ­Ø¯ÙŠØ¯ ÙƒÙ‚ÙŠØ¯ Ø§Ù„ØªÙ†ÙÙŠØ°',
            'requests details' => 'ØªÙØ§ØµÙŠÙ„ Ø§Ù„Ø·Ù„Ø¨Ø§Øª',
            'my offer' => 'Ø¹Ø±Ø¶ÙŠ',
            'offer rejected' => 'ØªÙ… Ø±ÙØ¶ Ø§Ù„Ø¹Ø±Ø¶',
            'contact us' => 'ØªÙˆØ§ØµÙ„ Ù…Ø¹Ù†Ø§',
            'no notes provided.' => 'Ù„Ø§ ØªÙˆØ¬Ø¯ Ù…Ù„Ø§Ø­Ø¸Ø§Øª.',
            'delete this offer?' => 'Ù‡Ù„ ØªØ±ÙŠØ¯ Ø­Ø°Ù Ù‡Ø°Ø§ Ø§Ù„Ø¹Ø±Ø¶ØŸ',
        ];

        $key = strtolower(trim((string) $text));
        return $map[$key] ?? $text;
    };

    $currentStatus = $tr($currentStatus);
    $actionLabel = $actionLabel ? $tr($actionLabel) : null;

    $paymentRaw = $order->payment_type ?: ($order->payment_status ?: '-');
    $paymentKey = strtolower(trim((string) $paymentRaw));
    $paymentMap = [
        'cash on delivery' => $isAr ? 'Ø§Ù„Ø¯ÙØ¹ Ø¹Ù†Ø¯ Ø§Ù„Ø§Ø³ØªÙ„Ø§Ù…' : 'Cash on Delivery',
        'cod' => $isAr ? 'Ø§Ù„Ø¯ÙØ¹ Ø¹Ù†Ø¯ Ø§Ù„Ø§Ø³ØªÙ„Ø§Ù…' : 'Cash on Delivery',
        'paid' => $isAr ? 'Ù…Ø¯ÙÙˆØ¹' : 'Paid',
        'unpaid' => $isAr ? 'ØºÙŠØ± Ù…Ø¯ÙÙˆØ¹' : 'Unpaid',
        '1' => $isAr ? 'Ù…Ø¯ÙÙˆØ¹' : 'Paid',
        '0' => $isAr ? 'ØºÙŠØ± Ù…Ø¯ÙÙˆØ¹' : 'Unpaid',
    ];
    $paymentDisplay = $paymentMap[$paymentKey] ?? $paymentRaw;
    $orderFiles = collect(is_array($order->files) ? $order->files : [])->filter()->values();
    $imageExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp'];
@endphp

<main class="vendor-order-show">
    @include('flash::message')

    <nav class="vos-breadcrumb">
        @if($isQuotation)
            <a href="{{ route('vendor/orders', ['tab' => 'quotations']) }}">{{ trans_or_fallback('', '') }}</a>
            <i class="bi bi-chevron-right"></i>
            <span class="current">{{ $tr('Requests Details') }}</span>
        @elseif($isScheduled)
            <a href="{{ route('vendor/orders') }}">{{ trans_or_fallback('', '') }}</a>
            <i class="bi bi-chevron-right"></i>
            <a href="{{ route('vendor/orders', ['tab' => 'scheduled']) }}">{{ trans_or_fallback('', '') }}</a>
            <i class="bi bi-chevron-right"></i>
            <span class="current">{{ trans_or_fallback('', '') }}</span>
        @else
            <a href="{{ route('vendor/orders') }}">{{ trans_or_fallback('', '') }}</a>
            <i class="bi bi-chevron-right"></i>
            <span class="current">{{ trans_or_fallback('', '') }}</span>
        @endif
    </nav>

    <div class="vos-grid">
        <div>
            <div class="vos-card">
                <h5>{{ trans_or_fallback('', '') }}</h5>
                <div class="vos-rows">
                    <div class="vos-row"><span class="vos-key">{{ $isAr ? 'Ø±Ù‚Ù… Ø§Ù„Ø·Ù„Ø¨' : 'Request Number' }}</span><span class="vos-val">#{{ $order->id }}</span></div>
                    <div class="vos-row"><span class="vos-key">{{ $isAr ? 'Ø¹Ù†ÙˆØ§Ù† Ø§Ù„ØªØ³Ù„ÙŠÙ…' : 'Delivery Address' }}</span><span class="vos-val">{{ $order->address ?: '-' }}</span></div>
                    @if($isScheduled)
                        <div class="vos-row"><span class="vos-key">{{ $isAr ? 'Ø§Ù„Ù…ÙˆØ±Ø¯' : 'Supplier' }}</span><span class="vos-val">{{ auth()->user()->company_name ?? auth()->user()->name }}</span></div>
                    @endif
                    <div class="vos-row"><span class="vos-key">{{ $isAr ? 'Ø·Ø±ÙŠÙ‚Ø© Ø§Ù„Ø¯ÙØ¹' : 'Payment Method' }}</span><span class="vos-val">{{ $paymentDisplay }}</span></div>
                    <div class="vos-row"><span class="vos-key">{{ trans_or_fallback('', '') }}</span><span class="vos-val">{{ $currentStatus }}</span></div>
                    @if($isScheduled)
                        @php
                            $start = $order->schedule_start_date ? \Carbon\Carbon::parse($order->schedule_start_date) : null;
                            $end = $start ? (clone $start)->addMonths(3) : null;
                        @endphp
                        <div class="vos-row"><span class="vos-key">{{ trans_or_fallback('', '') }}</span><span class="vos-val">{{ $start ? $start->translatedFormat('M d') : '-' }} - {{ $end ? $end->translatedFormat('M d, Y') : '-' }}</span></div>
                    @endif
                    <div class="vos-row"><span class="vos-key">{{ trans_or_fallback('', '') }}</span><span class="vos-val">{{ $order->created_at->translatedFormat('M d, Y') }}</span></div>
                </div>
            </div>

            @if($isScheduled)
                <div class="vos-card" style="margin-top:14px;">
                    <h5>{{ $isAr ? 'Ù…Ù„Ø§Ø­Ø¸Ø©' : 'Note' }}</h5>
                    <div class="vos-offer-line">{{ $order->notes ?: $tr('No notes provided.') }}</div>
                </div>
            @endif
            <div class="vos-card" style="margin-top:14px;">
                <h5>{{ ($isQuotation || (int)$order->order_type === 3 || $isScheduled) ? (trans_or_fallback('', '')) : (trans_or_fallback('', '')) }}</h5>
                @if($isQuotation || (int)$order->order_type === 3 || $isScheduled)
                    @if($orderFiles->count() > 0)
                        <div class="row g-3">
                            @foreach($orderFiles as $f)
                                @php
                                    $ext = strtolower(pathinfo((string) $f, PATHINFO_EXTENSION));
                                    $isImage = in_array($ext, $imageExtensions, true);
                                @endphp
                                <div class="col-md-4 col-6">
                                    <a href="{{ asset($f) }}" target="_blank" style="text-decoration:none;">
                                        @if($isImage)
                                            <img src="{{ asset($f) }}" alt="attachment" style="width:100%;height:140px;object-fit:cover;border-radius:10px;border:1px solid #e6e8ed;">
                                        @else
                                            <div style="height:140px;border:1px solid #e6e8ed;border-radius:10px;display:flex;align-items:center;justify-content:center;background:#f8fafc;color:#334155;font-weight:600;padding:10px;text-align:center;">
                                                <span><i class="bi bi-file-earmark-text"></i> {{ strtoupper($ext ?: 'FILE') }}</span>
                                            </div>
                                        @endif
                                        <div style="margin-top:8px;font-size:13px;color:#6b7280;word-break:break-all;">{{ basename((string)$f) }}</div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="vos-rows">
                            <div class="vos-row"><span class="vos-key">-</span><span class="vos-val">-</span></div>
                        </div>
                    @endif
                @elseif($order->items && $order->items->count())
                    <div class="vos-rows">
                        @foreach($order->items as $item)
                            <div class="vos-row">
                                <span class="vos-key">{{ $item->product->name ?? 'Product' }}</span>
                                <span class="vos-val">{{ $item->quantity }} {{ trans_or_fallback('', '') }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="vos-rows">
                        <div class="vos-row"><span class="vos-key">{{ $order->device_name ?: '-' }}</span><span class="vos-val">-</span></div>
                    </div>
                @endif
            </div>

            <div class="vos-card vos-timeline" style="margin-top:14px;">
                <h5>{{ $isAr ? 'Ø§Ù„Ø¬Ø¯ÙˆÙ„ Ø§Ù„Ø²Ù…Ù†ÙŠ' : 'Timeline' }}</h5>
                <div class="line">
                    @foreach($timelineSteps as $stepNo)
                        @php
                            $done = in_array($stepNo, $timelineNos, true);
                            $entry = $timeline->firstWhere('timeline_no', $stepNo);
                        @endphp
                        <div class="vos-step {{ $done ? 'done' : 'pending' }}">
                            <span class="dot"><i class="bi bi-check"></i></span>
                            <div class="vos-step-copy">
                                <div class="name">{{ vendorTimelineName($stepNo, $order->order_type) }}</div>
                                <div class="date">{{ $entry ? $entry->created_at->translatedFormat('M j') : '-' }}</div>
                            </div>
                        </div>
                    @endforeach
                    @if($myOffer && in_array(strtolower((string)$myOffer->status), ['3','rejected'], true))
                        <div class="vos-step done">
                            <span class="dot"><i class="bi bi-check"></i></span>
                            <div class="vos-step-copy">
                                <div class="name">{{ $tr('Offer Rejected') }}</div>
                                <div class="date">{{ optional($myOffer->updated_at)->translatedFormat('M j') }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if($order->user)
                <div class="vos-card" style="margin-top:14px;">
                    <h5>{{ __('nav.contact_us') ?? ($isAr ? 'Ø§ØªØµÙ„ Ø¨Ù†Ø§' : 'Contact us') }}</h5>
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
                    <h5>{{ $tr('My Offer') }}</h5>
                    <div class="vos-offer">
                        <div class="vos-offer-head">{{ $tr('My Offer') }}</div>
                        <div class="vos-offer-body">
                            <div class="vos-file">
                                <a href="{{ is_array($myOffer->files) && !empty($myOffer->files[0]) ? asset($myOffer->files[0]) : '#' }}" target="_blank">
                                    <i class="bi bi-file-earmark-pdf"></i> {{ is_array($myOffer->files) && !empty($myOffer->files[0]) ? basename($myOffer->files[0]) : 'quotation.pdf' }}
                                </a>
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <div class="vos-offer-line">{{ $isAr ? 'Ø§Ù„Ø³Ø¹Ø± Ø§Ù„Ø¥Ø¬Ù…Ø§Ù„ÙŠ' : 'Total Price' }}: {{ number_format((float)($myOffer->cost ?? 0), 0) }} {{ $isAr ? 'Ø±.Ø³' : 'SAR' }}</div>
                            <div class="vos-offer-line">{{ $isAr ? 'Ù…Ø¯Ø© Ø§Ù„ØªØ³Ù„ÙŠÙ…' : 'Delivery Time' }}: {{ $myOffer->delivery_time ?? 0 }} {{ trans_or_fallback('', '') }}</div>
                            <div class="vos-offer-line">{{ __('nav.warranty') ?? ($isAr ? 'Ø§Ù„Ø¶Ù…Ø§Ù†' : 'Warranty') }}: {{ $myOffer->warranty ?? '-' }}</div>
                            <div class="vos-offer-line">{{ $isAr ? 'Ù…Ù„Ø§Ø­Ø¸Ø§Øª' : 'Notes' }}: {{ $myOffer->notes ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div>
            <div class="vos-card vos-payment">
                <h5>{{ $isAr ? 'ØªÙØ§ØµÙŠÙ„ Ø§Ù„Ø¯ÙØ¹' : 'Payment Details' }}</h5>
                <div class="vos-rows">
                    <div class="vos-row"><span class="vos-key">{{ $isAr ? 'Ø§Ù„Ù…Ø¬Ù…ÙˆØ¹ Ø§Ù„ÙØ±Ø¹ÙŠ' : 'Subtotal' }}</span><span class="vos-val">{{ number_format((float)($order->items_cost ?? $order->total_before_discount ?? $order->total_cost ?? 0), 0) }} {{ $isAr ? 'Ø±.Ø³' : 'SAR' }}</span></div>
                    <div class="vos-row"><span class="vos-key">{{ $isAr ? 'Ø¶Ø±ÙŠØ¨Ø© Ø§Ù„Ù‚ÙŠÙ…Ø© Ø§Ù„Ù…Ø¶Ø§ÙØ© (10%)' : 'VAT(10%)' }}</span><span class="vos-val">{{ number_format((float)($order->vat_amount ?? 0), 0) }} {{ $isAr ? 'Ø±.Ø³' : 'SAR' }}</span></div>
                    <div class="vos-row"><span class="vos-key">{{ $isAr ? 'Ø±Ø³ÙˆÙ… Ø§Ù„ØªÙˆØµÙŠÙ„' : 'Delivery Fee' }}</span><span class="vos-val">{{ number_format((float)($order->delivery_fee ?? 0), 0) }} {{ $isAr ? 'Ø±.Ø³' : 'SAR' }}</span></div>
                    <div class="vos-row vos-total"><span class="vos-key">{{ $isAr ? 'Ø§Ù„Ø¥Ø¬Ù…Ø§Ù„ÙŠ' : 'Net Total' }}</span><span class="vos-val">{{ number_format((float)($order->total_cost ?? 0), 0) }} {{ $isAr ? 'Ø±.Ø³' : 'SAR' }}</span></div>
                </div>
            </div>

            <div style="margin-top:14px;">
                @if($isQuotation && $myOffer && in_array(strtolower((string)$myOffer->status), ['3','rejected'], true))
                    <div class="vos-alert" style="margin-bottom:12px;">
                        <i class="bi bi-exclamation-triangle"></i>
                        {{ $isAr ? 'ØªÙ… Ø±ÙØ¶ Ø¹Ø±Ø¶Ùƒ. Ø§Ù„Ø³Ø¨Ø¨:' : 'Your offer was rejected. Reason:' }}
                        {{ $myOffer->rejected_reson ?: ($isAr ? 'Ø§Ù„Ø³Ø¹Ø± Ù…Ø±ØªÙØ¹. Ø§Ù„Ø¹Ù…ÙŠÙ„ ÙŠØ·Ù„Ø¨ Ø³Ø¹Ø±Ø§Ù‹ Ø£Ù‚Ù„.' : 'Price too high. The client requests a lower price.') }}
                    </div>
                    <div class="vos-actions">
                        <a href="{{ route('vendor/orders/offer-edit', $myOffer->id) }}" class="btn-vos btn-vos-main" style="width:100%;">{{ $tr('Resubmit Offer') }}</a>
                    </div>
                @elseif($isQuotation && !$myOffer)
                    <div class="vos-actions">
                        <a href="{{ route('vendor/orders/offer-form', $order->id) }}" class="btn-vos btn-vos-main" style="width:100%;">{{ $tr('Send Offer') }}</a>
                    </div>
                @elseif($isQuotation && $myOffer && (string)$myOffer->status === '1')
                    <div class="vos-actions">
                        <form method="POST" action="{{ route('vendor/orders/offer-delete', $myOffer->id) }}" style="flex:1;" onsubmit="return confirm('{{ $tr('Delete this offer?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-vos btn-vos-danger" style="width:100%;">{{ $tr('Cancel Offer') }}</button>
                        </form>
                        <a href="{{ route('vendor/orders/offer-edit', $myOffer->id) }}" class="btn-vos btn-vos-main" style="flex:1;">{{ $tr('Edit Offer') }}</a>
                    </div>
                @elseif($showPendingConfirmActions)
                    <div class="vos-actions">
                        <button type="button" class="btn-vos btn-vos-danger" style="flex:1;">{{ $isAr ? 'Ø¥Ù„ØºØ§Ø¡ Ø§Ù„Ø·Ù„Ø¨' : 'Cancel Order' }}</button>
                        <form method="POST" action="{{ route('user/order-timeline') }}" style="flex:1;">
                            @csrf
                            <input type="hidden" name="order_type" value="{{ encrypt((int)$order->order_type) }}">
                            <input type="hidden" name="timeline_no" value="{{ encrypt(2) }}">
                            <input type="hidden" name="order_id" value="{{ encrypt((int)$order->id) }}">
                            @if((int)$order->order_type === 1)
                                <input type="hidden" name="delivery_fee" value="{{ (float)($order->delivery_fee ?? 0) }}">
                            @endif
                            <button type="submit" class="btn-vos btn-vos-main" style="width:100%;">{{ $tr('Confirmed') }}</button>
                        </form>
                    </div>
                @elseif($timelineActionNo)
                    <div class="vos-actions">
                        <form method="POST" action="{{ route('user/order-timeline') }}" style="width:100%;">
                            @csrf
                            <input type="hidden" name="order_type" value="{{ encrypt((int)$order->order_type) }}">
                            <input type="hidden" name="timeline_no" value="{{ encrypt((int)$timelineActionNo) }}">
                            <input type="hidden" name="order_id" value="{{ encrypt((int)$order->id) }}">
                            @if((int)$timelineActionNo === 2 && (int)$order->order_type === 1)
                                <input type="hidden" name="delivery_fee" value="{{ (float)($order->delivery_fee ?? 0) }}">
                            @endif
                            <button type="submit" class="btn-vos btn-vos-main" style="width:100%;">{{ $actionLabel }}</button>
                        </form>
                    </div>
                @elseif($actionLabel)
                    <div class="vos-actions">
                        <button type="button" class="btn-vos {{ strtolower($actionLabel) === 'cancelled' ? 'btn-vos-outline' : 'btn-vos-main' }}" style="width:100%;" disabled>{{ $actionLabel }}</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection


