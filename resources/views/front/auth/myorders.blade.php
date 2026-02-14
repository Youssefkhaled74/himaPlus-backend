@extends('layouts.front.home')

<!-- title page -->
@section('title')
    <title>HemaPulse - Smart Medical Procurement</title>
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
    <h5 class="mb-3">Orders</h5>
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
        <li class="nav-item"><a class="nav-link {{ $tab == 'all' ? 'active' : '' }}" href="{{ route('user/myorders', 'all') }}">All</a></li>
        <li class="nav-item"><a class="nav-link {{ $tab == 'purchase-orders' ? 'active' : '' }}" href="{{ route('user/myorders', 'purchase-orders') }}">Purchase Orders</a></li>
        <li class="nav-item"><a class="nav-link {{ $tab == 'quotations' ? 'active' : '' }}" href="{{ route('user/myorders', 'quotations') }}">Quotations</a></li>
        <li class="nav-item"><a class="nav-link {{ $tab == 'maintenances' ? 'active' : '' }}" href="{{ route('user/myorders', 'maintenances') }}">Maintenance</a></li>
        <li class="nav-item"><a class="nav-link {{ $tab == 'scheduled-orders' ? 'active' : '' }}" href="{{ route('user/myorders', 'scheduled-orders') }}">Scheduled Orders</a></li>
    </ul>

    <div class="reveal">

        @if(isset($orders) && $orders->count() > 0)
            @foreach($orders as $order)
                @php
                    $lastTimeline = $order->timeline->last();
                    // 1 => Order Created, 2 => Confirmed by Supplier, 3 => Processing, 4 => Shipped,
                    // 5 => Delivered, 6 => Completed, 7 => Offers Received, 8 => Supplier Selected,
                    // 9 => Converted to Order, 10 => Under Review, 11 => Assigned to Supplier
                @endphp

                <div class="order-card mb-3 position-relative">
                    <div class="chip chip--{{ timelineNameBackground($lastTimeline?->timeline_no) }}">{{ timelineName($lastTimeline?->timeline_no) }}</div>
                    <div class="order-card__title">{{ orderType($order->order_type) }}</div>
                    <div class="meta">
                        <div><strong>Order #{{ $order->id }} – {{ \Carbon\Carbon::parse($order->created_at)->format('M j, Y') }}</strong></div>
                        {{-- <div>Product: X-Ray Machine – 2 Units</div> --}}
                        <div>Supplier: {{ $order->provider?->name }}</div>
                        <div>Total: {{ $order->total_cost }} SAR</div>
                    </div>
                    <a class="chev" href="{{ route('user/get/order', $order->id) }}"><i class="bi bi-chevron-right"></i></a>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <div class="empty-state__icon">
                    <i class="bi bi-inbox"></i>
                </div>
                <h5 class="empty-state__title">No Orders Yet</h5>
                <p class="empty-state__text">You haven't placed any orders yet. Start browsing our products and place your first order.</p>
                <a href="{{ route('products') }}" class="empty-state__btn">
                    <i class="bi bi-cart-plus"></i>
                    Browse Products
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
