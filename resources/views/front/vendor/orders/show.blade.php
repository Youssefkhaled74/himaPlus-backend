@extends('layouts.front.home')

@section('title')
    <title>{{ __('nav.order_details') ?? 'Order Details' }} #{{ $order->id }} - Vendor | HemaPulse</title>
@endsection

@section('css')
    <style>
        .timeline {
            position: relative;
            padding: 20px 0;
        }
        .timeline-item {
            padding-bottom: 20px;
            padding-left: 40px;
            border-left: 2px solid #dee2e6;
            position: relative;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -8px;
            top: 0;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background-color: #007bff;
        }
        .timeline-item.completed::before {
            background-color: #28a745;
        }
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .offer-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
        }
        .offer-card.own {
            background-color: #f0f8ff;
            border-color: #007bff;
        }
    </style>
@endsection

@section('content')
    <main class="container my-4" style="max-width: 95%; margin-top: 8% !important;">
        @include('flash::message')
        
        <nav class="breadcrumb-custom mb-3">
            <a href="{{ route('vendor/dashboard') }}" class="text-decoration-none text-muted">{{ __('nav.dashboard') ?? 'Dashboard' }}</a>
            <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
            <a href="{{ route('vendor/orders') }}" class="text-decoration-none text-muted">{{ __('nav.view_orders') ?? 'Orders' }}</a>
            <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
            @if($order->request_type == 2)
                <a href="{{ route('vendor/orders', ['tab' => 'scheduled']) }}" class="text-decoration-none text-muted">{{ __('Scheduled Orders') ?? 'Scheduled Orders' }}</a>
                <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
            @endif
            <span class="text-primary fw-semibold">{{ __('Order Details') ?? 'Order Details' }}</span>
        </nav>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header" style="background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%); color: #fff; display: flex; justify-content: space-between; align-items: center;">
                        <h4 class="mb-0">
                            @if($order->request_type == 2)
                                {{ __('Scheduled Order Details') ?? 'Scheduled Order Details' }}
                            @else
                                {{ __('Order Details') ?? 'Order Details' }} #{{ $order->id }}
                            @endif
                        </h4>
                        @if($order->request_type == 2 && $myOffer && ((string)$myOffer->status === '2' || strtolower((string)$myOffer->status) === 'accepted'))
                            <button class="btn btn-light btn-sm" style="border-radius:10px;font-weight:800;">
                                <i class="bi bi-box-seam"></i> {{ __('Mark as Shipped') ?? 'Mark as Shipped' }}
                            </button>
                        @endif
                    </div>
                    <div class="card-body">
                        @if($order->request_type == 2)
                            {{-- Scheduled Order Details --}}
                            <div class="info-box">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <strong>{{ __('Request Number') ?? 'Request Number' }}:</strong><br>
                                        #{{ $order->id }}
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>{{ __('Delivery Address') ?? 'Delivery Address' }}:</strong><br>
                                        {{ $order->address ?? '—' }}
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>{{ __('Supplier') ?? 'Supplier' }}:</strong><br>
                                        {{ $myOffer ? (auth()->user()->company_name ?? auth()->user()->name) : '—' }}
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>{{ __('Payment Method') ?? 'Payment Method' }}:</strong><br>
                                        {{ $order->payment_type ?? '—' }}
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>{{ __('Status') ?? 'Status' }}:</strong><br>
                                        @php $colors = $order->scheduled_status_color; @endphp
                                        <span style="display:inline-flex;align-items:center;padding:4px 10px;font-size:11px;font-weight:800;border-radius:6px;background:{{ $colors['bg'] }};color:{{ $colors['text'] }};border:1px solid {{ $colors['border'] }};">
                                            {{ ucfirst($order->scheduled_status) }}
                                        </span>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>{{ __('Duration') ?? 'Duration' }}:</strong><br>
                                        {{ $order->schedule_start_date ? \Carbon\Carbon::parse($order->schedule_start_date)->format('M d') . ' – ' . \Carbon\Carbon::parse($order->schedule_start_date)->addMonths(3)->format('M d, Y') : '—' }}
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>{{ __('Date') ?? 'Date' }}:</strong><br>
                                        {{ $order->created_at->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-4 mb-3">{{ __('Note') ?? 'Note' }}</h5>
                            <p style="background:#f8f9fa;padding:14px;border-radius:10px;border:1px solid #e9ecef;">
                                {{ $order->notes ?? __('No notes provided.') ?? 'No notes provided.' }}
                            </p>

                            <h5 class="mt-4 mb-3">{{ __('Products Requested') ?? 'Products Requested' }}</h5>
                            <div style="background:#f8f9fa;padding:14px;border-radius:10px;border:1px solid #e9ecef;">
                                @if($order->files && is_array($order->files) && count($order->files) > 0)
                                    @foreach($order->files as $file)
                                        @if($file)
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <i class="bi bi-file-earmark-pdf" style="font-size:24px;color:#dc3545;"></i>
                                                <a href="{{ asset($file) }}" target="_blank" class="text-decoration-none">
                                                    {{ basename($file) }}
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                @elseif($order->items && count($order->items) > 0)
                                    @foreach($order->items as $item)
                                        <div class="mb-2">• {{ $item->product->name ?? 'Product' }} ({{ $item->quantity }} {{ __('pcs') ?? 'pcs' }})</div>
                                    @endforeach
                                @else
                                    <div class="text-muted">{{ __('No products listed.') ?? 'No products listed.' }}</div>
                                @endif
                            </div>

                            <h5 class="mt-4 mb-3">{{ __('Contact us') ?? 'Contact us' }}</h5>
                            <div style="background:#f8f9fa;padding:14px;border-radius:10px;border:1px solid #e9ecef;">
                                @if($order->user)
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="mb-1">{{ $order->user->company_name ?? $order->user->name }}</h6>
                                            <p class="mb-0 text-muted" style="font-size:13px;">{{ $order->user->email }}</p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            @if($order->user->mobile)
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->user->mobile) }}" target="_blank" class="btn btn-success btn-sm" style="border-radius:10px;">
                                                    <i class="bi bi-whatsapp"></i>
                                                </a>
                                                <a href="tel:{{ $order->user->mobile }}" class="btn btn-primary btn-sm" style="border-radius:10px;">
                                                    <i class="bi bi-telephone"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="text-muted">{{ __('Contact information not available.') ?? 'Contact information not available.' }}</div>
                                @endif
                            </div>
                        @else
                            {{-- Regular Order Details --}}
                            <div class="info-box">
                                <p class="mb-2"><strong>{{ __('Order Type') ?? 'Order Type' }}:</strong> 
                                    <span class="badge" style="background: {{ $order->order_type === 1 ? '#e3f2fd' : '#f3e5f5' }}; color: {{ $order->order_type === 1 ? '#1976d2' : '#7b1fa2' }};">
                                        @if($order->order_type == 1)
                                            {{ __('Purchase Order') ?? 'Purchase Order' }}
                                        @elseif($order->order_type == 2)
                                            {{ __('Quotation') ?? 'Quotation' }}
                                        @else
                                            {{ __('Maintenance') ?? 'Maintenance' }}
                                        @endif
                                    </span>
                                </p>
                                <p class="mb-2"><strong>{{ __('Created Date') ?? 'Created Date' }}:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                                @if($order->address)
                                    <p class="mb-0"><strong>{{ __('Address') ?? 'Address' }}:</strong> {{ $order->address }}</p>
                                @endif
                            </div>

                            <h5 class="mt-4 mb-3">{{ __('Order Description') ?? 'Order Description' }}:</h5>
                            <p>{{ $order->notes ?? __('No description provided.') ?? 'No description provided.' }}</p>
                        @endif

                        @if($order->timeline && count($order->timeline) > 0)
                            <h5 class="mt-4 mb-3">{{ __('Order Timeline') ?? 'Order Timeline' }}:</h5>
                            <div class="timeline">
                                @foreach($order->timeline as $item)
                                    <div class="timeline-item {{ (int)$item->timeline_no === 6 ? 'completed' : '' }}">
                                        <div>
                                            <strong>{{ timelineName((int)$item->timeline_no) }}</strong>
                                            <p class="text-muted mb-0" style="font-size: 12px;">{{ $item->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                @if($order->request_type != 2 || ($myOffer && $order->offers->count() > 1))
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">{{ __('Offers Submitted') ?? 'Offers Submitted' }}</h5>
                        </div>
                        <div class="card-body">
                            @if($order->offers && count($order->offers) > 0)
                                @foreach($order->offers as $offer)
                                    <div class="offer-card {{ $offer->provider_id === auth()->id() ? 'own' : '' }}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-2">
                                                    <strong>{{ __('Provider') ?? 'Provider' }}:</strong> {{ $offer->provider->company_name ?? $offer->provider->name }}
                                                    @if($offer->provider_id === auth()->id())
                                                        <span class="badge bg-primary">{{ __('My Offer') ?? 'My Offer' }}</span>
                                                    @endif
                                                </p>
                                                <p class="mb-2"><strong>{{ __('Price') ?? 'Price' }}:</strong> {{ number_format($offer->cost ?? 0, 2) }} {{ __('SAR') ?? 'SAR' }}</p>
                                                <p class="mb-0"><strong>{{ __('Delivery Days') ?? 'Delivery Days' }}:</strong> {{ $offer->delivery_time ?? 'N/A' }} {{ __('days') ?? 'days' }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-2"><strong>{{ __('Warranty') ?? 'Warranty' }}:</strong> {{ $offer->warranty ?? __('None') ?? 'None' }}</p>
                                                <p class="mb-2"><strong>{{ __('Status') ?? 'Status' }}:</strong> 
                                                    @php
                                                        $offerStatus = (string) $offer->status;
                                                        $offerStatusLabel = ($offerStatus === '2' || strtolower($offerStatus) === 'accepted')
                                                            ? 'accepted'
                                                            : (($offerStatus === '3' || strtolower($offerStatus) === 'rejected') ? 'rejected' : 'pending');
                                                    @endphp
                                                    <span class="badge bg-{{ $offerStatusLabel === 'pending' ? 'warning' : ($offerStatusLabel === 'accepted' ? 'success' : 'danger') }}">
                                                        {{ ucfirst($offerStatusLabel) }}
                                                    </span>
                                                </p>
                                                @if($offer->provider_id === auth()->id())
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="{{ route('vendor/orders/offer-edit', $offer->id) }}" class="btn btn-sm btn-outline-primary">{{ __('Edit') ?? 'Edit' }}</a>
                                                        <form action="{{ route('vendor/orders/offer-delete', $offer->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ __('Are you sure you want to delete this offer?') ?? 'Are you sure?' }}');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Delete') ?? 'Delete' }}</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        @if($offer->notes)
                                            <p class="mt-2 mb-0 text-muted"><strong>{{ __('Notes') ?? 'Notes' }}:</strong> {{ $offer->notes }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-info mb-0">
                                    {{ __('No offers have been submitted for this order yet.') ?? 'No offers have been submitted for this order yet.' }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">{{ __('Customer Information') ?? 'Customer Information' }}</h5>
                    </div>
                    <div class="card-body">
                        @if($order->user)
                            <p class="mb-2">
                                <strong>{{ __('Name') ?? 'Name' }}:</strong><br>
                                {{ $order->user->name }}
                            </p>
                            <p class="mb-2">
                                <strong>{{ __('Email') ?? 'Email' }}:</strong><br>
                                {{ $order->user->email }}
                            </p>
                            <p class="mb-2">
                                <strong>{{ __('Phone') ?? 'Phone' }}:</strong><br>
                                {{ $order->user->mobile ?? __('Not specified') ?? 'Not specified' }}
                            </p>
                            @if($order->address)
                                <p class="mb-0">
                                    <strong>{{ __('Address') ?? 'Address' }}:</strong><br>
                                    {{ $order->address }}
                                </p>
                            @endif
                        @else
                            <p class="text-muted">{{ __('Customer information not available.') ?? 'Customer information not available.' }}</p>
                        @endif
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">{{ __('Actions') ?? 'Actions' }}</h5>
                    </div>
                    <div class="card-body">
                        @if(!$myOffer)
                            <a href="{{ route('vendor/orders/offer-form', $order->id) }}" class="btn btn-success w-100 mb-2">
                                <i class="bi bi-plus-circle"></i> {{ __('Submit Offer') ?? 'Submit Offer' }}
                            </a>
                        @else
                            @php
                                $myOfferStatus = (string) $myOffer->status;
                                $myOfferPending = ($myOfferStatus === '1' || strtolower($myOfferStatus) === 'pending');
                            @endphp
                            @if($myOfferPending)
                                <a href="{{ route('vendor/orders/offer-edit', $myOffer->id) }}" class="btn btn-warning w-100 mb-2">
                                    <i class="bi bi-pencil"></i> {{ __('Edit My Offer') ?? 'Edit My Offer' }}
                                </a>
                            @endif
                        @endif
                        <a href="{{ route('vendor/orders', $order->request_type == 2 ? ['tab' => 'scheduled'] : []) }}" class="btn btn-secondary w-100">
                            <i class="bi bi-arrow-left"></i> {{ __('Back to Orders') ?? 'Back to Orders' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
