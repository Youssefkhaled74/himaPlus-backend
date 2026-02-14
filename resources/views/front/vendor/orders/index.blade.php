@extends('layouts.front.home')

@section('title')
    <title>{{ __('nav.view_orders') ?? 'Orders' }} - Vendor | HemaPulse</title>
@endsection

@section('css')
    <style>
        :root{
            --page-bg:#f5f6f8;
            --card-bg:#fff;
            --border:#ececec;
            --text:#111827;
            --muted:#6b7280;
            --shadow:0 6px 20px rgba(16,24,40,.06);
            --radius:10px;
            --primary:#0d6efd;
        }

        .orders-page{
            background: var(--page-bg);
            border: 1px solid rgba(0,0,0,.04);
            border-radius: 12px;
            padding: 18px;
        }

        /* Tabs like screenshot */
        .orders-tabs{
            display:flex;
            gap: 8px;
            overflow-x: auto;
            margin-bottom: 18px;
            padding-bottom: 4px;
        }
        .orders-tabs::-webkit-scrollbar{ height: 4px; }
        .orders-tabs::-webkit-scrollbar-thumb{ background: #cbd5e1; border-radius:4px; }
        
        .tab-btn{
            padding: 8px 16px;
            border-radius: 999px;
            border: 1px solid var(--border);
            background: var(--card-bg);
            color: var(--muted);
            font-weight: 700;
            font-size: 13px;
            white-space: nowrap;
            text-decoration: none;
            transition: all .15s ease;
        }
        .tab-btn:hover{
            border-color: rgba(13,110,253,.22);
            color: var(--primary);
        }
        .tab-btn.active{
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        /* Order Card like screenshot */
        .order-card{
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 14px 16px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap: 14px;
            margin-bottom: 10px;
            transition: transform .12s ease, box-shadow .12s ease, border-color .12s ease;
            text-decoration:none;
            color: inherit;
            position: relative;
        }
        .order-card:hover{
            transform: translateY(-1px);
            box-shadow: 0 10px 26px rgba(16,24,40,.10);
            border-color: rgba(13,110,253,.22);
        }

        .order-main{ flex: 1; min-width: 0; }
        .order-title-row{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:10px;
            margin-bottom: 6px;
        }
        .order-title{
            font-weight: 800;
            font-size: 14px;
            color: var(--text);
            margin:0;
        }

        .order-meta{
            font-size: 12px;
            color: var(--muted);
            margin: 3px 0 0 0;
            line-height: 1.6;
        }
        .order-meta div{ margin-bottom: 2px; }

        /* Status badge at top-right */
        .order-status{
            position: absolute;
            top: 12px;
            right: 12px;
            display:inline-flex;
            align-items:center;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 800;
            border-radius: 6px;
            border: 1px solid transparent;
            white-space: nowrap;
        }

        /* Chevron arrow */
        .order-arrow{
            flex: 0 0 auto;
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display:grid;
            place-items:center;
            border: 1px solid var(--border);
            background:#fff;
            color:#9ca3af;
        }
        .order-card:hover .order-arrow{ color: var(--primary); border-color: rgba(13,110,253,.22); }

        /* Pagination like screenshot (center pills) */
        .pagination-wrap{
            display:flex;
            justify-content:center;
            margin-top: 20px;
        }
        .pagination-wrap .pagination{
            gap: 6px;
        }
        .pagination-wrap .page-link{
            border-radius: 8px !important;
            border: 1px solid var(--border);
            color: #374151;
            padding: 6px 10px;
            font-weight: 700;
            box-shadow: none;
        }
        .pagination-wrap .page-item.active .page-link{
            background: #0b5ed7;
            border-color: #0b5ed7;
            color: #fff;
        }

        @media (max-width: 576px){
            .order-card{ padding: 12px; }
            .order-arrow{ width: 32px; height: 32px; }
            .order-status{ position: static; margin-bottom: 6px; }
        }
    </style>
@endsection

@section('content')
    <main class="container my-4" style="max-width: 95%; margin-top: 8% !important;">
        @include('flash::message')
        
        <div class="orders-page">
            <nav class="mb-2" style="font-size:12px;">
                <a href="{{ route('vendor/dashboard') }}" class="text-decoration-none text-muted">{{ __('nav.dashboard') ?? 'Dashboard' }}</a>
                <span class="text-muted mx-1">/</span>
                <span class="text-primary fw-bold">{{ __('nav.view_orders') ?? 'Orders' }}</span>
            </nav>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="m-0 fw-bold">{{ __('nav.view_orders') ?? 'Orders' }}</h4>
                <a href="{{ route('vendor/orders/my-offers') }}" class="btn btn-outline-primary btn-sm" style="border-radius:10px;font-weight:800;">
                    <i class="bi bi-star"></i> {{ __('nav.my_offers') ?? 'My Offers' }} ({{ $myOffersCount ?? 0 }})
                </a>
            </div>

            <!-- Tabs -->
            <div class="orders-tabs">
                <a href="{{ route('vendor/orders', ['tab' => 'all']) }}" class="tab-btn {{ $tab === 'all' ? 'active' : '' }}">
                    {{ __('All') ?? 'All' }} @if(isset($counts['all']))({{ $counts['all'] }})@endif
                </a>
                <a href="{{ route('vendor/orders', ['tab' => 'purchase']) }}" class="tab-btn {{ $tab === 'purchase' ? 'active' : '' }}">
                    {{ __('Purchase Orders') ?? 'Purchase Orders' }} @if(isset($counts['purchase']))({{ $counts['purchase'] }})@endif
                </a>
                <a href="{{ route('vendor/orders', ['tab' => 'quotations']) }}" class="tab-btn {{ $tab === 'quotations' ? 'active' : '' }}">
                    {{ __('Quotations') ?? 'Quotations' }} @if(isset($counts['quotations']))({{ $counts['quotations'] }})@endif
                </a>
                <a href="{{ route('vendor/orders', ['tab' => 'maintenance']) }}" class="tab-btn {{ $tab === 'maintenance' ? 'active' : '' }}">
                    {{ __('Maintenance') ?? 'Maintenance' }} @if(isset($counts['maintenance']))({{ $counts['maintenance'] }})@endif
                </a>
                <a href="{{ route('vendor/orders', ['tab' => 'scheduled']) }}" class="tab-btn {{ $tab === 'scheduled' ? 'active' : '' }}">
                    {{ __('Scheduled Orders') ?? 'Scheduled Orders' }} @if(isset($counts['scheduled']))({{ $counts['scheduled'] }})@endif
                </a>
            </div>

            @if($orders->count() > 0)
                @foreach($orders as $order)
                    <a href="{{ route('vendor/orders/show', $order->id) }}" class="order-card">
                        <div class="order-main">
                            <div class="order-title-row">
                                <h6 class="order-title">
                                    @if($order->request_type == 2)
                                        {{ __('Scheduled Order') ?? 'Scheduled Order' }}
                                    @else
                                        @if($order->order_type == 1)
                                            {{ __('Purchase Order') ?? 'Purchase Order' }}
                                        @elseif($order->order_type == 2)
                                            {{ __('Quotation Request') ?? 'Quotation Request' }}
                                        @elseif($order->order_type == 3)
                                            {{ __('Maintenance Request') ?? 'Maintenance Request' }}
                                        @else
                                            {{ __('Order') ?? 'Order' }}
                                        @endif
                                    @endif
                                </h6>
                            </div>
                            <div class="order-meta">
                                @if($order->request_type == 2)
                                    {{-- Scheduled Order Info --}}
                                    @if($order->device_name || $order->notes)
                                        <div><strong>{{ __('Item') ?? 'Item' }}:</strong> {{ $order->device_name ?? Str::limit($order->notes, 30) }}</div>
                                    @endif
                                    @if($order->schedule_start_date)
                                        <div><strong>{{ __('Duration') ?? 'Duration' }}:</strong> {{ \Carbon\Carbon::parse($order->schedule_start_date)->format('M d, Y') }}</div>
                                    @endif
                                    @if($order->frequency)
                                        <div><strong>{{ __('Frequency') ?? 'Frequency' }}:</strong> {{ $order->frequency }}</div>
                                    @endif
                                    @if($order->delivery_duration)
                                        <div><strong>{{ __('Next Shipment') ?? 'Next Shipment' }}:</strong> {{ $order->delivery_duration }}</div>
                                    @endif
                                @else
                                    {{-- Regular Order Info --}}
                                    <div><strong>{{ __('Order ID') ?? 'Order ID' }}:</strong> #{{ $order->id }}</div>
                                    @if($order->user)
                                        <div><strong>{{ __('Customer') ?? 'Customer' }}:</strong> {{ $order->user->name }}</div>
                                    @endif
                                    <div><strong>{{ __('Date') ?? 'Date' }}:</strong> {{ $order->created_at->format('M d, Y') }}</div>
                                @endif
                            </div>
                        </div>
                        
                        {{-- Status Badge --}}
                        @if($order->request_type == 2)
                            @php
                                $colors = $order->scheduled_status_color;
                            @endphp
                            <span class="order-status" style="background:{{ $colors['bg'] }}; color:{{ $colors['text'] }}; border-color:{{ $colors['border'] }};">
                                {{ ucfirst($order->scheduled_status) }}
                            </span>
                        @else
                            @php
                                $myOffer = $order->offers->where('provider_id', auth()->id())->first();
                                if($myOffer) {
                                    $offerStatus = (string) $myOffer->status;
                                    if($offerStatus === '2' || strtolower($offerStatus) === 'accepted') {
                                        $statusColor = ['bg' => 'rgba(34,197,94,.12)', 'text' => '#166534', 'border' => 'rgba(34,197,94,.20)'];
                                        $statusText = 'Accepted';
                                    } elseif($offerStatus === '3' || strtolower($offerStatus) === 'rejected') {
                                        $statusColor = ['bg' => 'rgba(239,68,68,.12)', 'text' => '#991b1b', 'border' => 'rgba(239,68,68,.20)'];
                                        $statusText = 'Rejected';
                                    } else {
                                        $statusColor = ['bg' => 'rgba(251,191,36,.12)', 'text' => '#92400e', 'border' => 'rgba(251,191,36,.20)'];
                                        $statusText = 'Pending';
                                    }
                                } else {
                                    $statusColor = ['bg' => '#f3f4f6', 'text' => '#6b7280', 'border' => '#e5e7eb'];
                                    $statusText = 'New';
                                }
                            @endphp
                            <span class="order-status" style="background:{{ $statusColor['bg'] }}; color:{{ $statusColor['text'] }}; border-color:{{ $statusColor['border'] }};">
                                {{ $statusText }}
                            </span>
                        @endif
                        
                        <div class="order-arrow">
                            <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
                        </div>
                    </a>
                @endforeach

                <!-- Pagination -->
                <div class="pagination-wrap">
                    {{ $orders->appends(['tab' => $tab, 'status' => $status, 'search' => $search])->links('pagination::bootstrap-4') }}
                </div>
            @else
                <div class="alert alert-info" role="alert" style="border-radius:var(--radius);">
                    <i class="bi bi-info-circle me-2"></i>
                    {{ __('No orders found.') ?? 'No orders found.' }}
                </div>
            @endif
        </div>
    </main>
@endsection
