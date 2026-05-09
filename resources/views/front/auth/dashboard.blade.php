@extends('layouts.front.home')

@section('title')
<title>Customer Dashboard</title>
@endsection

@section('content')
<main class="container py-4">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h4 class="mb-1">Customer Dashboard</h4>
                <p class="text-muted mb-0">Track orders, invoices, favorites, notifications, and recent activity.</p>
            </div>
            <a href="{{ route('products') }}" class="btn btn-primary">Browse Products</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-2"><div class="card border-0 shadow-sm"><div class="card-body"><small class="text-muted">My Orders</small><h5>{{ $counts['orders'] }}</h5></div></div></div>
        <div class="col-md-2"><div class="card border-0 shadow-sm"><div class="card-body"><small class="text-muted">Paid Invoices</small><h5>{{ $counts['paid_invoices'] }}</h5></div></div></div>
        <div class="col-md-2"><div class="card border-0 shadow-sm"><div class="card-body"><small class="text-muted">Pending Orders</small><h5>{{ $counts['pending_orders'] }}</h5></div></div></div>
        <div class="col-md-2"><div class="card border-0 shadow-sm"><div class="card-body"><small class="text-muted">Favorites</small><h5>{{ $counts['favorites'] }}</h5></div></div></div>
        <div class="col-md-2"><div class="card border-0 shadow-sm"><div class="card-body"><small class="text-muted">Notifications</small><h5>{{ $counts['notifications'] }}</h5></div></div></div>
        <div class="col-md-2"><div class="card border-0 shadow-sm"><div class="card-body"><small class="text-muted">Tracking</small><h5>{{ $counts['orders'] }}</h5></div></div></div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-3">Marketplace Sections</h5>
            <div class="row g-3">
                <div class="col-md-3"><a class="text-decoration-none" href="{{ route('products') }}"><div class="border rounded p-3 h-100"><div class="fw-semibold">Medical Supplies</div></div></a></div>
                <div class="col-md-3"><a class="text-decoration-none" href="{{ route('providers') }}"><div class="border rounded p-3 h-100"><div class="fw-semibold">Industrial Companies</div></div></a></div>
                <div class="col-md-3"><a class="text-decoration-none" href="{{ route('providers') }}"><div class="border rounded p-3 h-100"><div class="fw-semibold">Suppliers / Vendors</div></div></a></div>
                <div class="col-md-3"><a class="text-decoration-none" href="{{ route('categories') }}"><div class="border rounded p-3 h-100"><div class="fw-semibold">Medical Centers & Services</div></div></a></div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between"><strong>Recent Orders</strong><a href="{{ route('user/myorders','all') }}">View all</a></div>
                <div class="card-body">
                    @forelse($orders as $order)
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <div>
                                <div class="fw-semibold">#{{ $order->id }} - {{ $order->provider->name ?? '-' }}</div>
                                <small class="text-muted">{{ optional($order->created_at)->format('Y-m-d') }}</small>
                            </div>
                            <div>
                                <span class="badge {{ (int)($order->payment_status ?? 0) === 1 ? 'bg-success' : 'bg-warning text-dark' }}">{{ (int)($order->payment_status ?? 0) === 1 ? 'Paid' : 'Pending' }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted">No orders yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white"><strong>Suppliers & Companies</strong></div>
                <div class="card-body">
                    @forelse($featuredSuppliers as $supplier)
                        <div class="d-flex align-items-center gap-2 border-bottom py-2">
                            <img src="{{ $supplier->img ? asset($supplier->img) : asset('front/assets/images/emptyproducts.png') }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;" alt="supplier">
                            <div class="flex-grow-1">
                                <div class="fw-semibold">{{ $supplier->name }}</div>
                                <a class="small" href="{{ route('products', ['vendor_name' => $supplier->name]) }}">View products</a>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted">No suppliers.</div>
                    @endforelse
                </div>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><strong>FAQ / Help</strong></div>
                <div class="card-body small text-muted">
                    <div class="mb-2">How to order: choose product, add to cart, checkout.</div>
                    <div class="mb-2">Payment and delivery methods are shown before confirmation.</div>
                    <div class="mb-2">Suppliers are verified and order stages are tracked.</div>
                    <div>Payments are secure and invoices are available via My Orders.</div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
