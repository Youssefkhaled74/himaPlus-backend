@extends('layouts.front.home')

@section('title')
    <title>{{ __('nav.order_details') }} #{{ $order->id }} - Vendor | Hema</title>
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
    $isMaintenance = (int)$order->order_type === 3;
    $isPurchase = (int)$order->order_type === 1;
    $statusState = $order->front_status_state ?? $order->front_status ?? ['key' => 'pending', 'text' => 'Pending', 'class' => 'chip-pending'];

    $currentStatus = $statusState['text'];

    $actionLabelKey = null;
    $timelineActionNo = null;
    $showPendingConfirmActions = false;
    $__stepMap = match ((int)$order->order_type) {
        1 => [1 => 3, 3 => 4, 4 => 5, 5 => 6],
        2 => [1 => 7, 7 => 9, 9 => 6],
        3 => [1 => 7, 7 => 9, 9 => 6],
        default => [],
    };
    $nextTimelineNo = $__stepMap[$lastTimelineNo] ?? null;

    if ($isQuotation) {
        if (!$myOffer) {
            $actionLabelKey = 'nav.send_offer';
        } else {
            $offerStatus = strtolower((string)$myOffer->status);
            if ($offerStatus === '3' || $offerStatus === 'rejected') {
                $actionLabelKey = 'nav.resubmit_offer';
            } elseif ($offerStatus === '2' || $offerStatus === 'accepted') {
                if ($nextTimelineNo === 7) {
                    $actionLabelKey = 'nav.mark_as_offer_prepared';
                    $timelineActionNo = 7;
                } elseif ($nextTimelineNo === 9) {
                    $actionLabelKey = 'nav.mark_as_offer_sent';
                    $timelineActionNo = 9;
                } elseif ($nextTimelineNo === 6) {
                    $actionLabelKey = 'nav.mark_as_completed';
                    $timelineActionNo = 6;
                }
            } else {
                $actionLabelKey = 'nav.send_offer';
            }
        }
    } elseif ($isMaintenance) {
        if ($nextTimelineNo === 7) {
            $actionLabelKey = 'nav.mark_as_appointment_set';
            $timelineActionNo = 7;
        } elseif ($nextTimelineNo === 9) {
            $actionLabelKey = 'nav.mark_as_in_progress';
            $timelineActionNo = 9;
        } elseif ($nextTimelineNo === 6) {
            $actionLabelKey = 'nav.mark_as_completed';
            $timelineActionNo = 6;
        }
    } elseif ($isScheduled) {
        if (in_array($statusState['key'], ['scheduled', 'active_scheduled'], true)) {
            $actionLabelKey = 'nav.mark_as_in_progress';
        } elseif ($statusState['key'] === 'completed_scheduled') {
            $actionLabelKey = 'nav.mark_as_completed';
        } elseif ($statusState['key'] === 'cancelled') {
            $actionLabelKey = 'nav.cancel_order';
        }
    } else {
        // Purchase order
        if ($nextTimelineNo === 3) {
            $actionLabelKey = 'nav.mark_as_offer_prepared';
            $timelineActionNo = 3;
        } elseif ($nextTimelineNo === 4) {
            $actionLabelKey = 'nav.mark_as_shipped';
            $timelineActionNo = 4;
        } elseif ($nextTimelineNo === 5) {
            $actionLabelKey = 'nav.mark_as_delivered';
            $timelineActionNo = 5;
        } elseif ($nextTimelineNo === 6) {
            $actionLabelKey = 'nav.mark_as_completed';
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
            'pending' => 'قيد الانتظار',
            'confirmed' => 'تم التأكيد',
            'under review' => 'قيد المراجعة',
            'processing' => 'قيد المعالجة',
            'shipped' => 'تم الشحن',
            'delivered' => 'تم التسليم',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغي',
            'canceled' => 'ملغي',
            'rejected' => 'مرفوض',
            'paused' => 'متوقف',
            'upcoming' => 'قادم',
            'active' => 'نشط',
            'offers received' => 'تم استلام العروض',
            'supplier selected' => 'تم اختيار المورد',
            'converted to order' => 'تم التحويل إلى طلب',
            'assigned to supplier' => 'تم التعيين إلى المورد',
            'on hold' => 'معلق',
            'order created' => 'تم إنشاء الطلب',
            'edit offer' => 'تعديل العرض',
            'cancel offer' => 'إلغاء العرض',
            'send offer' => 'إرسال عرض',
            'resubmit offer' => 'إعادة تقديم العرض',
            'mark as processing' => 'تحديد كقيد المعالجة',
            'mark as shipped' => 'تحديد كتم الشحن',
            'mark as delivered' => 'تحديد كتم التسليم',
            'mark as completed' => 'تحديد كمكتمل',
            'mark as offer prepared' => 'تحديد كمعد',
            'mark as offer sent' => 'تحديد كإرسال العرض',
            'mark as appointment set' => 'تحديد موعد',
            'mark as in progress' => 'تحديد كقيد التنفيذ',
            'requests details' => 'تفاصيل الطلبات',
            'my offer' => 'عرضي',
            'offer rejected' => 'تم رفض العرض',
            'contact us' => 'تواصل معنا',
            'no notes provided.' => 'لا توجد ملاحظات.',
            'delete this offer?' => 'هل تريد حذف هذا العرض؟',
        ];

        $key = strtolower(trim((string) $text));
        return $map[$key] ?? $text;
    };

    $currentStatus = $tr($currentStatus);
    $actionLabel = $actionLabelKey ? __($actionLabelKey) : null;

    $paymentRaw = $order->payment_type ?: ($order->payment_status ?: '-');
    $paymentKey = strtolower(trim((string) $paymentRaw));
    $paymentMap = [
        'cash on delivery' => $isAr ? 'الدفع عند الاستلام' : 'Cash on Delivery',
        'cod' => $isAr ? 'الدفع عند الاستلام' : 'Cash on Delivery',
        'paid' => $isAr ? 'مدفوع' : 'Paid',
        'unpaid' => $isAr ? 'غير مدفوع' : 'Unpaid',
        '1' => $isAr ? 'مدفوع' : 'Paid',
        '0' => $isAr ? 'غير مدفوع' : 'Unpaid',
    ];
    $paymentDisplay = $paymentMap[$paymentKey] ?? $paymentRaw;
    $orderFiles = collect(is_array($order->files) ? $order->files : [])->filter()->values();
    $imageExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp'];
@endphp

<main class="vendor-order-show">
    @include('flash::message')

    <nav class="vos-breadcrumb">
        @if($isQuotation)
            <a href="{{ route('vendor/orders', ['tab' => 'quotations']) }}">{{ __('nav.quotations') }}</a>
            <i class="bi bi-chevron-right"></i>
            <span class="current">{{ __('nav.requests_details') }}</span>
        @elseif($isScheduled)
            <a href="{{ route('vendor/orders') }}">{{ __('nav.orders') }}</a>
            <i class="bi bi-chevron-right"></i>
            <a href="{{ route('vendor/orders', ['tab' => 'scheduled']) }}">{{ __('nav.scheduled_orders') }}</a>
            <i class="bi bi-chevron-right"></i>
            <span class="current">{{ __('nav.order_details') }}</span>
        @else
            <a href="{{ route('vendor/orders') }}">{{ __('nav.orders') }}</a>
            <i class="bi bi-chevron-right"></i>
            <span class="current">{{ __('nav.order_details') }}</span>
        @endif
    </nav>

    <div class="vos-grid">
        <div>
            <div class="vos-card">
                <h5>{{ __('nav.order_details') }}</h5>
                <div class="vos-rows">
                    <div class="vos-row"><span class="vos-key">{{ __('nav.request_number') }}</span><span class="vos-val">#{{ $order->id }}</span></div>
                    <div class="vos-row"><span class="vos-key">{{ __('nav.delivery_address') }}</span><span class="vos-val">{{ $order->address ?: '-' }}</span></div>
                    @if($isScheduled)
                        <div class="vos-row"><span class="vos-key">{{ __('nav.supplier') }}</span><span class="vos-val">{{ auth()->user()->company_name ?? auth()->user()->name }}</span></div>
                    @endif
                    <div class="vos-row"><span class="vos-key">{{ __('nav.payment_method') }}</span><span class="vos-val">{{ $paymentDisplay }}</span></div>
                    <div class="vos-row"><span class="vos-key">{{ __('nav.status') }}</span><span class="vos-val">{{ $currentStatus }}</span></div>
                    @if($isScheduled)
                        @php
                            $start = $order->schedule_start_date ? \Carbon\Carbon::parse($order->schedule_start_date) : null;
                            $end = $start ? (clone $start)->addMonths(3) : null;
                        @endphp
                        <div class="vos-row"><span class="vos-key">{{ __('nav.scheduled_period') }}</span><span class="vos-val">{{ $start ? $start->translatedFormat('M d') : '-' }} - {{ $end ? $end->translatedFormat('M d, Y') : '-' }}</span></div>
                    @endif
                    <div class="vos-row"><span class="vos-key">{{ __('nav.created_at') }}</span><span class="vos-val">{{ $order->created_at->translatedFormat('M d, Y') }}</span></div>
                </div>
            </div>

            @if($isQuotation || $isMaintenance)
                <div class="vos-card" style="margin-top:14px;">
                    <h5>{{ __('nav.request_information') }}</h5>
                    <div class="vos-rows">
                        <div class="vos-row"><span class="vos-key">{{ __('nav.order_type_label') }}</span><span class="vos-val">{{ $isQuotation ? __('nav.quotation_request') : __('nav.maintenance_request') }}</span></div>
                        @if($isQuotation)
                            @if($order->budget)
                                <div class="vos-row"><span class="vos-key">{{ __('nav.budget') }}</span><span class="vos-val">{{ number_format((float)$order->budget, 0) }} {{ __('nav.sar') }}</span></div>
                            @endif
                            @if($order->delivery_duration)
                                <div class="vos-row"><span class="vos-key">{{ __('nav.delivery_duration') }}</span><span class="vos-val">{{ $order->delivery_duration }}</span></div>
                            @endif
                            @if($order->frequency)
                                <div class="vos-row"><span class="vos-key">{{ __('nav.frequency') }}</span><span class="vos-val">{{ $order->frequency }}</span></div>
                            @endif
                            @if($order->date_time_picker)
                                <div class="vos-row"><span class="vos-key">{{ __('nav.preferred_date_time') }}</span><span class="vos-val">{{ $order->date_time_picker }}</span></div>
                            @endif
                            @if($order->quotation_type)
                                <div class="vos-row"><span class="vos-key">{{ __('nav.quotation_type') }}</span><span class="vos-val">{{ $order->quotation_type }}</span></div>
                            @endif
                        @endif
                        @if($isMaintenance)
                            @if($order->device_category)
                                <div class="vos-row"><span class="vos-key">{{ __('nav.device_category') }}</span><span class="vos-val">{{ $order->device_category->name ?? $order->device_category_id }}</span></div>
                            @endif
                            @if($order->device_name)
                                <div class="vos-row"><span class="vos-key">{{ __('nav.device_name') }}</span><span class="vos-val">{{ $order->device_name }}</span></div>
                            @endif
                            @if($order->serial_number)
                                <div class="vos-row"><span class="vos-key">{{ __('nav.serial_number') }}</span><span class="vos-val">{{ $order->serial_number }}</span></div>
                            @endif
                            @if($order->issue_description)
                                <div class="vos-row"><span class="vos-key">{{ __('nav.issue_description') }}</span><span class="vos-val">{{ $order->issue_description }}</span></div>
                            @endif
                            @if($order->preferred_service_time)
                                <div class="vos-row"><span class="vos-key">{{ __('nav.preferred_service_time') }}</span><span class="vos-val">{{ $order->preferred_service_time }}</span></div>
                            @endif
                        @endif
                    </div>
                </div>
            @endif

            @if($isScheduled)
                <div class="vos-card" style="margin-top:14px;">
                <h5>{{ __('nav.note') }}</h5>
                    <div class="vos-offer-line">{{ $order->notes ?: __('nav.no_notes_provided') }}</div>
                </div>
            @elseif($order->notes)
                <div class="vos-card" style="margin-top:14px;">
                    <h5>{{ __('nav.general_notes') }}</h5>
                    <div class="vos-offer-line">{{ $order->notes }}</div>
                </div>
            @endif
            <div class="vos-card" style="margin-top:14px;">
                <h5>{{ ($isQuotation || (int)$order->order_type === 3 || $isScheduled) ? __('nav.request_attachments') : __('nav.product_details') }}</h5>
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
                                            <img src="{{ asset($f) }}" alt="{{ __('nav.attachment_preview') }}" style="width:100%;height:140px;object-fit:cover;border-radius:10px;border:1px solid #e6e8ed;">
                                        @else
                                            <div style="height:140px;border:1px solid #e6e8ed;border-radius:10px;display:flex;align-items:center;justify-content:center;background:#f8fafc;color:#334155;font-weight:600;padding:10px;text-align:center;">
                                                <span><i class="bi bi-file-earmark-text"></i> {{ strtoupper($ext ?: __('nav.file_label')) }}</span>
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
                                <span class="vos-key">{{ $item->product->name ?? __('nav.product') }}</span>
                                <span class="vos-val">{{ $item->quantity }} {{ __('nav.quantity') }}</span>
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
                <h5>{{ __('nav.timeline') }}</h5>
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
                                <div class="name">{{ __('nav.offer_rejected') }}</div>
                                <div class="date">{{ optional($myOffer->updated_at)->translatedFormat('M j') }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if($order->user)
                <div class="vos-card" style="margin-top:14px;">
                    <h5>{{ __('nav.contact_us') }}</h5>
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
                    <h5>{{ __('nav.my_offer') }}</h5>
                    <div class="vos-offer">
                        <div class="vos-offer-head">{{ __('nav.my_offer') }}</div>
                        <div class="vos-offer-body">
                            <div class="vos-file">
                                <a href="{{ is_array($myOffer->files) && !empty($myOffer->files[0]) ? asset($myOffer->files[0]) : '#' }}" target="_blank">
                                    <i class="bi bi-file-earmark-pdf"></i> {{ is_array($myOffer->files) && !empty($myOffer->files[0]) ? basename($myOffer->files[0]) : __('nav.quotation_file_name') }}
                                </a>
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <div class="vos-offer-line">{{ __('nav.total_price') }}: {{ number_format((float)($myOffer->cost ?? 0), 0) }} {{ __('nav.sar') }}</div>
                            <div class="vos-offer-line">{{ __('nav.delivery_time') }}: {{ $myOffer->delivery_time ?? 0 }} {{ __('nav.days_text') }}</div>
                            <div class="vos-offer-line">{{ __('nav.warranty') }}: {{ $myOffer->warranty ?? '-' }}</div>
                            <div class="vos-offer-line">{{ __('nav.note') }}: {{ $myOffer->notes ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div>
            <div class="vos-card vos-payment">
                <h5>{{ __('nav.payment_details') }}</h5>
                <div class="vos-rows">
                    @if($order->items_cost && $order->items_cost != $order->total_before_discount && $order->items_cost != $order->total_cost)
                        <div class="vos-row"><span class="vos-key">{{ __('nav.items_cost') }}</span><span class="vos-val">{{ number_format((float)$order->items_cost, 0) }} {{ __('nav.sar') }}</span></div>
                    @endif
                    <div class="vos-row"><span class="vos-key">{{ __('nav.subtotal') }}</span><span class="vos-val">{{ number_format((float)($order->total_before_discount ?? $order->items_cost ?? $order->total_cost ?? 0), 0) }} {{ __('nav.sar') }}</span></div>
                    @if($order->discount)
                        <div class="vos-row"><span class="vos-key">{{ __('nav.discount') }}</span><span class="vos-val">-{{ number_format((float)$order->discount, 0) }} {{ __('nav.sar') }}</span></div>
                    @endif
                    @if($order->coupon)
                        <div class="vos-row"><span class="vos-key">{{ __('nav.coupon_code') }}</span><span class="vos-val">{{ $order->coupon->code ?? $order->coupon_id }}</span></div>
                    @endif
                    <div class="vos-row"><span class="vos-key">{{ __('nav.vat') }} (10%)</span><span class="vos-val">{{ number_format((float)($order->vat_amount ?? 0), 0) }} {{ __('nav.sar') }}</span></div>
                    <div class="vos-row"><span class="vos-key">{{ __('nav.delivery_fee') }}</span><span class="vos-val">{{ number_format((float)($order->delivery_fee ?? 0), 0) }} {{ __('nav.sar') }}</span></div>
                    <div class="vos-row vos-total"><span class="vos-key">{{ __('nav.net_total') }}</span><span class="vos-val">{{ number_format((float)($order->total_cost ?? 0), 0) }} {{ __('nav.sar') }}</span></div>
                </div>
                @if($order->payment_status || $order->gateway_name)
                    <div style="margin-top:14px;padding-top:14px;border-top:1px solid var(--vos-border);">
                        <div class="vos-rows">
                            @if($order->payment_status)
                                <div class="vos-row"><span class="vos-key">{{ __('nav.payment_status') }}</span><span class="vos-val">{{ $paymentDisplay }}</span></div>
                            @endif
                            @if($order->gateway_name)
                                <div class="vos-row"><span class="vos-key">{{ __('nav.payment_gateway') }}</span><span class="vos-val">{{ $order->gateway_name }}</span></div>
                            @endif
                            @if($order->gateway_payment_id)
                                <div class="vos-row"><span class="vos-key">Gateway Payment ID</span><span class="vos-val" style="font-size:13px;word-break:break-all;">{{ $order->gateway_payment_id }}</span></div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <div style="margin-top:14px;">
                @php
                    $orderShipments = $order->shipments()->with(['images', 'shippingMethod'])->orderByDesc('id')->get();
                @endphp
                @if($orderShipments->count() > 0)
                    <div class="vos-card" style="margin-bottom:14px;">
                        <h5>{{ __('nav.shipments') }} ({{ $orderShipments->count() }})</h5>
                        @foreach($orderShipments as $s)
                            <div style="border:1px solid #e5e7eb;border-radius:12px;padding:14px;margin-bottom:10px;">
                                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                                    <span style="font-size:14px;font-weight:600;color:#1f2937;">{{ __('nav.shipment') }} #{{ $s->id }}</span>
                                    <span style="display:inline-block;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;background:#dbeafe;color:#1e40af;">{{ $s->status_label }}</span>
                                </div>
                                <div style="font-size:13px;color:#6b7280;margin-bottom:8px;">
                                    @if($s->tracking_number){{ __('nav.tracking_number') }}: {{ $s->tracking_number }} | @endif
                                    @if($s->shippingMethod){{ $s->shippingMethod->name }} | @endif
                                    {{ $s->created_at->translatedFormat('M d, Y H:i') }}
                                </div>
                                @if($s->images->count() > 0)
                                    <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                        @foreach($s->images as $img)
                                            <a href="{{ asset($img->image_path) }}" target="_blank">
                                                <img src="{{ asset($img->image_path) }}" alt="{{ $img->caption ?? '' }}" style="width:70px;height:70px;object-fit:cover;border-radius:8px;border:1px solid #e5e7eb;">
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($isQuotation && $myOffer && in_array(strtolower((string)$myOffer->status), ['3','rejected'], true))
                    <div class="vos-alert" style="margin-bottom:12px;">
                        <i class="bi bi-exclamation-triangle"></i>
                        {{ __('nav.offer_rejected') }}:
                        {{ $myOffer->rejected_reson ?: __('nav.client_requests_lower_price') }}
                    </div>
                    <div class="vos-actions">
                        <a href="{{ route('vendor/orders/offer-edit', $myOffer->id) }}" class="btn-vos btn-vos-main" style="width:100%;">{{ __('nav.resubmit_offer') }}</a>
                    </div>
                @elseif($isQuotation && !$myOffer)
                    <div class="vos-actions">
                        <a href="{{ route('vendor/orders/offer-form', $order->id) }}" class="btn-vos btn-vos-main" style="width:100%;">{{ __('nav.send_offer') }}</a>
                    </div>
                @elseif($isQuotation && $myOffer && (string)$myOffer->status === '1')
                    <div class="vos-actions">
                        <form method="POST" action="{{ route('vendor/orders/offer-delete', $myOffer->id) }}" style="flex:1;" onsubmit="return confirm('{{ __('nav.delete_this_offer') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-vos btn-vos-danger" style="width:100%;">{{ __('nav.cancel_offer') }}</button>
                        </form>
                        <a href="{{ route('vendor/orders/offer-edit', $myOffer->id) }}" class="btn-vos btn-vos-main" style="flex:1;">{{ __('nav.edit_offer') }}</a>
                    </div>
                @elseif($showPendingConfirmActions)
                    <div class="vos-actions">
                        <button type="button" class="btn-vos btn-vos-danger" style="flex:1;">{{ __('nav.cancel_order') }}</button>
                        <form method="POST" action="{{ route('user/order-timeline') }}" style="flex:1;">
                            @csrf
                            <input type="hidden" name="order_type" value="{{ encrypt((int)$order->order_type) }}">
                            <input type="hidden" name="timeline_no" value="{{ encrypt(2) }}">
                            <input type="hidden" name="order_id" value="{{ encrypt((int)$order->id) }}">
                            @if((int)$order->order_type === 1)
                                <input type="hidden" name="delivery_fee" value="{{ (float)($order->delivery_fee ?? 0) }}">
                            @endif
                            <button type="submit" class="btn-vos btn-vos-main" style="width:100%;">{{ __('nav.confirmed') }}</button>
                        </form>
                    </div>
                @elseif($timelineActionNo && (int)$timelineActionNo === 4)
                    <div class="vos-actions" style="flex-direction:column;gap:10px;">
                        <a href="{{ route('vendor/orders/create-shipment', $order->id) }}" class="btn-vos btn-vos-main" style="width:100%;text-align:center;">
                            <i class="bi bi-box-seam"></i> {{ __('nav.create_shipment_with_images') }}
                        </a>
                        <form method="POST" action="{{ route('user/order-timeline') }}" style="width:100%;">
                            @csrf
                            <input type="hidden" name="order_type" value="{{ encrypt((int)$order->order_type) }}">
                            <input type="hidden" name="timeline_no" value="{{ encrypt((int)$timelineActionNo) }}">
                            <input type="hidden" name="order_id" value="{{ encrypt((int)$order->id) }}">
                            <button type="submit" class="btn-vos btn-vos-outline" style="width:100%;">{{ __('nav.mark_as_shipped') }} ({{ __('nav.without_images') }})</button>
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


