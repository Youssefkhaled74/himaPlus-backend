@extends('layouts.front.home')

@section('title')
    <title>{{ __('products.my_orders_title') }}</title>
@endsection

@section('css')
<style>
    .customer-orders,
    .customer-orders *{font-family:"Poppins","Tajawal",system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;}

    :root{
        --co-bg:#f5f6f8;
        --co-card:#ffffff;
        --co-border:#e8eaee;
        --co-head:#f2f2f4;
        --co-text:#1f2937;
        --co-muted:#6b7280;
        --co-primary:#0f4bbf;
        --co-accent:#0ec6a0;
    }

    .customer-orders{max-width:95%;margin:12px auto 0;background:var(--co-bg);padding:8px 0 24px;}
    .co-title{font-size:34px;font-weight:600;color:#0f2f7f;margin:0 0 14px;}
    .co-tabs{display:flex;flex-wrap:wrap;gap:0;background:#efeff2;border-radius:10px;padding:0;margin-bottom:22px;overflow:hidden;}
    .co-tab{padding:12px 22px;font-size:16px;font-weight:500;color:#2f3747;text-decoration:none;background:transparent;line-height:1.2;}
    .co-tab:hover{color:#0f4bbf;}
    .co-tab.active{background:linear-gradient(90deg,#0f4bbf 0%, #10b981 100%);color:#fff;}
    .co-card{display:block;text-decoration:none;color:inherit;background:var(--co-card);border:1px solid var(--co-border);border-radius:12px;overflow:hidden;margin-bottom:18px;}
    .co-card-head{background:var(--co-head);padding:16px 22px;display:flex;align-items:center;justify-content:space-between;gap:12px;}
    .co-card-head h6{margin:0;font-size:18px;font-weight:600;color:#21242c;}
    .co-card-body{padding:18px 22px 16px;display:flex;align-items:center;justify-content:space-between;gap:12px;}
    .co-name{font-size:16px;font-weight:600;line-height:1.25;margin-bottom:8px;color:#1f2633;}
    .co-meta{margin:0;color:#5d6471;font-size:14px;line-height:1.5;}
    .co-arrow{font-size:26px;color:#b0b5bf;line-height:1;}
    .co-chip{display:inline-flex;align-items:center;padding:6px 10px;border-radius:8px;font-size:12px;font-weight:600;line-height:1;border:1px solid transparent;}
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
    .chip-paid{background:#dcfce7;color:#166534;}
    .co-pagination{display:flex;justify-content:center;margin-top:26px;}
    .co-pagination .pagination{gap:8px;}
    .co-pagination .page-link{min-width:36px;height:36px;border:1px solid #dce6fb;border-radius:10px;color:#2b4a8f;font-weight:600;display:inline-flex;align-items:center;justify-content:center;padding:0 10px;background:#eaf1ff;}
    .co-pagination .page-item.active .page-link{background:linear-gradient(90deg,#0f4bbf 0%, #10b981 100%);border-color:transparent;color:#fff;}

    @media (max-width: 992px){
        .co-tab{font-size:18px;padding:10px 16px;}
        .co-card-head h6{font-size:18px;}
        .co-name{font-size:24px;}
        .co-meta{font-size:16px;}
        .co-chip{font-size:14px;padding:6px 10px;}
        .co-arrow{font-size:30px;}
    }
</style>
@endsection

@section('content')
@php
    $isAr = app()->getLocale() === 'ar';
    $tab = request()->route('page_type', 'all') ?? 'all';
    $paymentStatus = (string) request('payment_status', '');
    $status = (string) request('status', '');
@endphp

<main class="customer-orders">
    @include('flash::message')

    <h3 class="co-title">{{ __('products.my_orders') }}</h3>

    <div class="co-tabs">
        <a href="{{ route('user/myorders', 'all') }}" class="co-tab {{ $tab === 'all' ? 'active' : '' }}">{{ __('products.all_orders') }}</a>
        <a href="{{ route('user/myorders', 'purchase-orders') }}" class="co-tab {{ $tab === 'purchase-orders' ? 'active' : '' }}">{{ __('products.purchase_orders') }}</a>
        <a href="{{ route('user/myorders', 'quotations') }}" class="co-tab {{ $tab === 'quotations' ? 'active' : '' }}">{{ __('products.quotations') }}</a>
        <a href="{{ route('user/myorders', 'maintenances') }}" class="co-tab {{ $tab === 'maintenances' ? 'active' : '' }}">{{ __('products.maintenance') }}</a>
        <a href="{{ route('user/myorders', 'scheduled-orders') }}" class="co-tab {{ $tab === 'scheduled-orders' ? 'active' : '' }}">{{ __('products.scheduled_orders') }}</a>
    </div>

    <div class="co-tabs" style="background:#fff;border:1px solid var(--co-border);padding:8px;">
        <a href="{{ route('user/myorders', $tab) }}" class="co-tab {{ $paymentStatus === '' && $status === '' ? 'active' : '' }}">{{ __('nav.all') }}</a>
        <a href="{{ route('user/myorders', $tab) }}?payment_status=1" class="co-tab {{ $paymentStatus === '1' ? 'active' : '' }}">{{ __('products.paid') }}</a>
        <a href="{{ route('user/myorders', $tab) }}?payment_status=0" class="co-tab {{ $paymentStatus === '0' ? 'active' : '' }}">{{ __('products.unpaid') }}</a>
        <a href="{{ route('user/myorders', $tab) }}?status=processing" class="co-tab {{ $status === 'processing' ? 'active' : '' }}">{{ __('products.processing') }}</a>
        <a href="{{ route('user/myorders', $tab) }}?status=completed" class="co-tab {{ $status === 'completed' ? 'active' : '' }}">{{ __('products.completed') }}</a>
        <a href="{{ route('user/myorders', $tab) }}?status=scheduled" class="co-tab {{ $status === 'scheduled' ? 'active' : '' }}">{{ __('products.scheduled_orders') }}</a>
    </div>

    @include('front.partials.order-workflow-hint', ['role' => 'customer', 'activeTab' => $tab])

    @forelse($orders as $order)
        @php
            $statusState = $order->front_status_state ?? ['text' => __('products.pending'), 'class' => 'chip-pending'];
            $orderFiles = collect(is_array($order->files) ? $order->files : [])->filter()->values();
            $title = (int) $order->request_type === 2
                ? __('nav.scheduled_order')
                : ((int) $order->order_type === 1
                    ? __('nav.purchase_orders')
                    : ((int) $order->order_type === 2 ? __('nav.quotation_request') : __('nav.maintenance_request')));
        @endphp

        <a href="{{ route('user/get/order', $order->id) }}" class="co-card">
            <div class="co-card-head">
                <h6>{{ $title }}</h6>
                <span class="co-chip {{ $statusState['class'] }}">{{ $statusState['text'] }}</span>
            </div>
            <div class="co-card-body">
                <div>
                    <div class="co-name">
                        {{ __('products.order_number_label') }} #{{ $order->id }} - {{ $order->created_at->translatedFormat('M d, Y') }}
                    </div>

                    <p class="co-meta">{{ __('products.supplier_label') }}: {{ $order->provider?->name ?? '-' }}</p>
                    <p class="co-meta">{{ __('products.total_label') }}: {{ number_format((float) ($order->total_cost ?? 0), 2) }} {{ __('products.currency_sar') }}</p>
                </div>

                <span class="co-arrow"><i class="bi bi-chevron-{{ $isAr ? 'left' : 'right' }}"></i></span>
            </div>
        </a>
    @empty
        <div class="alert alert-light border">{{ __('nav.no_orders_found') }}</div>
    @endforelse

    @if(isset($orders) && method_exists($orders, 'hasPages') && $orders->hasPages())
        <div class="co-pagination">
            {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    @endif
</main>
@endsection

@section('script')
<script>
    $(function(){
        $('#nav-orders').addClass('active');
    });
</script>
@endsection
