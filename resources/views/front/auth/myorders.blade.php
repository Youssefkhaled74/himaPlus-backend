@extends('layouts.front.home')

<!-- title page -->
@section('title')
    <title>{{ __('products.my_orders_title') }}</title>
@endsection

<!-- custom page -->
@section('css')
    <style>
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: #f8f9fa;
            border-radius: 12px;
            margin-top: 20px;
        }
        .empty-state__icon {
            font-size: 64px;
            color: #c5ccd6;
            margin-bottom: 20px;
        }
        .empty-state__title {
            font-size: 20px;
            font-weight: 600;
            color: #0F254A;
            margin-bottom: 8px;
        }
        .empty-state__text {
            color: #6c757d;
            font-size: 15px;
            margin-bottom: 20px;
        }
        .empty-state__btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 24px;
            background: linear-gradient(135deg, #00c6a9, #0099cc);
            color: #fff;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .empty-state__btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 198, 169, 0.3);
            color: #fff;
        }
    </style>
@endsection

@section('content')

<main class="container my-4">
    <h5 class="mb-3">{{ __('products.my_orders') }}</h5>
    @include('flash::message')
    @if ($errors->any())
        <div style="text-align: left; margin: 15px;">
            <ul dir="ltr">
                @foreach ($errors->all() as $error)
                    <li class="text-danger">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <ul class="nav hp-tabs mb-3">
        @php
            $tab = request()->route('page_type');
        @endphp

        <li class="nav-item">
            <a class="nav-link {{ $tab == 'all' && !request()->filled('payment_status') ? 'active' : '' }}"
               href="{{ route('user/myorders', 'all') }}">
                {{ __('products.all_orders') }}
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request('payment_status') === '1' ? 'active' : '' }}"
               href="{{ route('user/myorders', 'all') }}?payment_status=1">
                {{ app()->getLocale() === 'ar' ? 'الطلبات المدفوعة' : 'Paid Orders' }}
            </a>
        </li>

	        <li class="nav-item">
	            <a class="nav-link {{ request('status') === 'processing' ? 'active' : '' }}"
	               href="{{ route('user/myorders', 'all') }}?status=processing">
	                {{ app()->getLocale() === 'ar' ? 'طلبات قيد التنفيذ' : 'Processing Orders' }}
	            </a>
	        </li>

        <li class="nav-item">
            <a class="nav-link {{ $tab == 'purchase-orders' ? 'active' : '' }}"
               href="{{ route('user/myorders', 'purchase-orders') }}">
                {{ __('products.purchase_orders') }}
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $tab == 'quotations' ? 'active' : '' }}"
               href="{{ route('user/myorders', 'quotations') }}">
                {{ __('products.quotations') }}
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $tab == 'maintenances' ? 'active' : '' }}"
               href="{{ route('user/myorders', 'maintenances') }}">
                {{ __('products.maintenance') }}
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $tab == 'scheduled-orders' ? 'active' : '' }}"
               href="{{ route('user/myorders', 'scheduled-orders') }}">
                {{ __('products.scheduled_orders') }}
            </a>
        </li>
    </ul>
    @include('front.partials.order-workflow-hint', ['role' => 'customer', 'activeTab' => $tab])

    <div class="reveal">

        @if(isset($orders) && $orders->count() > 0)
            @foreach($orders as $order)
	                <div class="order-card mb-3 position-relative">
	                    <div class="chip chip--{{ orderStatusChipClass($order->front_status_state['key'] ?? null) }}">{{ $order->front_status_state['text'] ?? __('products.pending') }}</div>
	                    <div class="order-card__title">{{ orderType($order->order_type) }}</div>
                    <div class="meta">
                        <div><strong>{{ __('products.order_number_label') }} #{{ $order->id }} – {{ \Carbon\Carbon::parse($order->created_at)->format('M j, Y') }}</strong></div>
                        <div>{{ __('products.supplier_label') }}: {{ $order->provider?->name }}</div>
                        <div>{{ __('products.total_label') }}: {{ $order->total_cost }} {{ __('products.currency_sar') }}</div>
                    </div>
                    <a class="chev" href="{{ route('user/get/order', $order->id) }}"><i class="bi bi-chevron-right"></i></a>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <div class="empty-state__icon">
                    <i class="bi bi-inbox"></i>
                </div>
                <h5 class="empty-state__title">{{ __('products.no_orders_title') }}</h5>
                <p class="empty-state__text">{{ __('products.no_orders_text') }}</p>
                <a href="{{ route('products') }}" class="empty-state__btn">
                    <i class="bi bi-cart-plus"></i>
                    {{ __('products.browse_products') }}
                </a>
            </div>
        @endif

    </div>

    @if(isset($orders) && $orders->count() > 0)
    <nav class="mt-3 reveal">
        <ul class="pagination flex-wrap justify-content-center" style="align-items: center;">
            <!-- Previous Button -->
            @if (!$orders->onFirstPage())
                <li class="page-item mt-1">
                    <a class="page-link" href="{{ $orders->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            @endif

            <!-- Pagination Numbers -->
            @for ($i = 1; $i <= $orders->lastPage(); $i++)
                <li class="page-item mt-1 {{ $i == $orders->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $orders->url($i) }}"
                        @if ($i == $orders->currentPage()) style="font-weight:bold;" @endif>
                        {{ $i }}
                    </a>
                </li>
            @endfor

            <!-- Next Button -->
            @if ($orders->hasMorePages())
                <li class="page-item mt-1">
                    <a class="page-link" href="{{ $orders->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
    @endif
    
</main>
@endsection

<!-- custom js -->
@section('script')
<script>
    $(function(){
        $('#nav-orders').addClass('active');
    });
</script>
@endsection
