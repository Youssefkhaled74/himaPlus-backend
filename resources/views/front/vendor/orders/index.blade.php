@extends('layouts.front.home')

@section('title')
    <title>{{ $tab === 'quotations' ? __('nav.quotations') : __('nav.view_orders') }} - Vendor | Hema</title>
@endsection

@section('css')
<style>
    .vendor-orders,
    .vendor-orders *{font-family:"Poppins","Tajawal",system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;}

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

    .vendor-orders{max-width:95%;margin:12px auto 0;background:var(--vo-bg);padding:8px 0 24px;}
    .vo-title{font-size:34px;font-weight:600;color:#0f2f7f;margin:0 0 14px;}
    .vo-tabs{display:flex;flex-wrap:wrap;gap:0;background:#efeff2;border-radius:10px;padding:0;margin-bottom:22px;overflow:hidden;}
    .vo-tab{padding:12px 22px;font-size:16px;font-weight:500;color:#2f3747;text-decoration:none;background:transparent;line-height:1.2;}
    .vo-tab:hover{color:#0f4bbf;}
    .vo-tab.active{background:linear-gradient(90deg,#0f4bbf 0%, #10b981 100%);color:#fff;}
    .vo-card{display:block;text-decoration:none;color:inherit;background:var(--vo-card);border:1px solid var(--vo-border);border-radius:12px;overflow:hidden;margin-bottom:18px;}
    .vo-card-head{background:var(--vo-head);padding:16px 22px;display:flex;align-items:center;justify-content:space-between;gap:12px;}
    .vo-card-head h6{margin:0;font-size:18px;font-weight:600;color:#21242c;}
    .vo-card-body{padding:18px 22px 16px;display:flex;align-items:center;justify-content:space-between;gap:12px;}
    .vo-name{font-size:16px;font-weight:600;line-height:1.25;margin-bottom:8px;color:#1f2633;}
    .vo-meta{margin:0;color:#5d6471;font-size:14px;line-height:1.5;}
    .vo-arrow{font-size:26px;color:#b0b5bf;line-height:1;}
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
    .vo-pagination{display:flex;justify-content:center;margin-top:26px;}
    .vo-pagination .pagination{gap:8px;}
    .vo-pagination .page-link{min-width:36px;height:36px;border:1px solid #dce6fb;border-radius:10px;color:#2b4a8f;font-weight:600;display:inline-flex;align-items:center;justify-content:center;padding:0 10px;background:#eaf1ff;}
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
<main class="vendor-orders">
    @include('flash::message')

    <h3 class="vo-title">{{ $tab === 'quotations' ? __('nav.quotations') : __('nav.view_orders') }}</h3>

    @if(($counts[$tab] ?? $counts['all'] ?? 0) > 0)
        <div class="alert alert-info py-2">{{ __('nav.orders_waiting_follow_up') }}: <strong>{{ $counts[$tab] ?? $counts['all'] }}</strong></div>
    @endif

    <div class="vo-tabs">
        <a href="{{ route('vendor/orders', ['tab' => 'all']) }}" class="vo-tab {{ $tab === 'all' ? 'active' : '' }}">{{ __('nav.all') }}</a>
        <a href="{{ route('vendor/orders', ['tab' => 'purchase']) }}" class="vo-tab {{ $tab === 'purchase' ? 'active' : '' }}">{{ __('nav.purchase_orders') }}</a>
        <a href="{{ route('vendor/orders', ['tab' => 'quotations']) }}" class="vo-tab {{ $tab === 'quotations' ? 'active' : '' }}">{{ __('nav.quotations') }}</a>
        <a href="{{ route('vendor/orders', ['tab' => 'maintenance']) }}" class="vo-tab {{ $tab === 'maintenance' ? 'active' : '' }}">{{ __('nav.maintenance') }}</a>
        <a href="{{ route('vendor/orders', ['tab' => 'scheduled']) }}" class="vo-tab {{ $tab === 'scheduled' ? 'active' : '' }}">{{ __('nav.scheduled_orders') }}</a>
    </div>

    <div class="vo-tabs" style="background:#fff;border:1px solid var(--vo-border);padding:8px;">
        <a href="{{ route('vendor/orders', ['tab' => $tab]) }}" class="vo-tab {{ $status === '' ? 'active' : '' }}">{{ __('nav.all') }}</a>
        <a href="{{ route('vendor/orders', ['tab' => $tab, 'status' => 'confirmed']) }}" class="vo-tab {{ $status === 'confirmed' ? 'active' : '' }}">{{ __('admin.pages.orders.statuses.confirmed') }}</a>
        <a href="{{ route('vendor/orders', ['tab' => $tab, 'status' => 'processing']) }}" class="vo-tab {{ $status === 'processing' ? 'active' : '' }}">{{ __('admin.pages.orders.statuses.processing') }}</a>
        <a href="{{ route('vendor/orders', ['tab' => $tab, 'status' => 'completed']) }}" class="vo-tab {{ $status === 'completed' ? 'active' : '' }}">{{ __('admin.pages.orders.statuses.completed') }}</a>
        <a href="{{ route('vendor/orders', ['tab' => $tab, 'status' => 'scheduled']) }}" class="vo-tab {{ $status === 'scheduled' ? 'active' : '' }}">{{ __('admin.pages.orders.statuses.scheduled') }}</a>
    </div>

    <form method="GET" action="{{ route('vendor/orders') }}" class="mb-3">
        <input type="hidden" name="tab" value="{{ $tab }}">
        @if($status !== '')
            <input type="hidden" name="status" value="{{ $status }}">
        @endif
        <div class="input-group">
            <input type="text" class="form-control" name="search" value="{{ $search }}" placeholder="{{ __('nav.search_order_id') }}">
            <button class="btn btn-primary" type="submit">{{ __('nav.search') }}</button>
        </div>
    </form>

    @include('front.partials.order-workflow-hint', ['role' => 'vendor', 'activeTab' => $tab])

    @forelse($orders as $order)
        @php
            $statusState = $order->front_status_state ?? $order->front_status ?? ['text' => __('nav.pending'), 'class' => 'chip-pending'];
            $orderFiles = collect(is_array($order->files) ? $order->files : [])->filter()->values();
            $title = (int) $order->request_type === 2
                ? __('nav.scheduled_order')
                : ((int) $order->order_type === 1
                    ? __('nav.purchase_orders')
                    : ((int) $order->order_type === 2 ? __('nav.quotation_request') : __('nav.maintenance_request')));
        @endphp

        <a href="{{ route('vendor/orders/show', $order->id) }}" class="vo-card">
            <div class="vo-card-head">
                <h6>{{ $title }}</h6>
                <span class="vo-chip {{ $statusState['class'] }}">{{ $statusState['text'] }}</span>
            </div>
            <div class="vo-card-body">
                <div>
                    <div class="vo-name">
                        @if((int) $order->request_type === 2)
                            {{ $order->device_name ?: __('nav.scheduled_supply') }}
                        @elseif((int) $order->order_type === 1)
                            {{ __('nav.order') }} #{{ $order->id }} - {{ $order->created_at->translatedFormat('M d, Y') }}
                        @else
                            {{ __('nav.request') }} #{{ $order->id }} - {{ $order->created_at->translatedFormat('M d, Y') }}
                        @endif
                    </div>

                    @if((int) $order->request_type === 2)
                        @php
                            $start = $order->schedule_start_date ? \Carbon\Carbon::parse($order->schedule_start_date) : null;
                            $end = $start ? (clone $start)->addMonths(3) : null;
                        @endphp
                        <p class="vo-meta">{{ __('nav.duration') }}: {{ $start ? $start->translatedFormat('M d') : '-' }} - {{ $end ? $end->translatedFormat('M d, Y') : '-' }}</p>
                        <p class="vo-meta">{{ __('nav.frequency') }}: {{ $order->frequency ?: '-' }}</p>
                        <p class="vo-meta">{{ __('nav.next_shipment') }}: {{ $order->delivery_duration ?: '-' }}</p>
                    @elseif((int) $order->order_type === 3)
                        <p class="vo-meta">{{ __('nav.device') }}: {{ $order->device_name ?: '-' }}</p>
                        <p class="vo-meta">{{ __('nav.hospital') }}: {{ $order->user->name ?? '-' }}</p>
                        <p class="vo-meta">{{ __('nav.assigned_to') }}: {{ __('nav.assigned_technician') }}</p>
                    @else
                        @if((int) $order->order_type === 2)
                            <p class="vo-meta">{{ __('nav.attachments') }}: {{ $orderFiles->count() }} {{ __('nav.files') }}</p>
                            <p class="vo-meta">{{ __('nav.first_file') }}: {{ $orderFiles->count() ? basename((string) $orderFiles->first()) : '-' }}</p>
                        @else
                            <p class="vo-meta">{{ __('nav.product') }}: {{ optional($order->items->first())->product->name ?? ($order->device_name ?: '-') }} @if($order->items->count()) - {{ $order->items->sum('quantity') }} {{ __('nav.units') }} @endif</p>
                        @endif
                        <p class="vo-meta">{{ __('nav.hospital') }}: {{ $order->user->name ?? '-' }}</p>
                        <p class="vo-meta">{{ __('nav.total') }}: {{ number_format((float) ($order->total_cost ?? 0), 0) }} {{ __('nav.currency_sar') }}</p>
                    @endif
                </div>

                <span class="vo-arrow"><i class="bi bi-chevron-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}"></i></span>
            </div>
        </a>
    @empty
        <div class="alert alert-light border">{{ __('nav.no_orders_found') }}</div>
    @endforelse

    <div class="vo-pagination">
        {{ $orders->appends(['tab' => $tab, 'status' => $status, 'search' => $search])->links('pagination::bootstrap-5') }}
    </div>
</main>
@endsection
