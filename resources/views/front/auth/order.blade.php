@extends('layouts.front.home')

<!-- title page -->
@section('title')
    <title>{{ __('products.order_title') }}</title>
@endsection

<!-- custom page -->
@section('css')
    <style>
        .t-bullet { top: 13px; }
        .timeline-data { margin-left: 3%; }
    </style>
    <style>
  .btn-gradient{
    background: linear-gradient(135deg,#0ea5e9,#10b981);
    color:#fff;border:0;
  }
  .btn-gradient:hover{ opacity:.95; color:#fff; }

  .rating-stars .star{
    font-size:28px; color:#cfd8dc; cursor:pointer; margin-right:6px; transition: color .15s;
  }
  .rating-stars .star.filled{ color:#f5c518; }
  .files-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(110px,1fr)); gap:8px; }
.files-grid .cell { aspect-ratio:1/1; border-radius:8px; overflow:hidden; display:block; }
.files-grid img { width:90%; height:70%; object-fit:cover; display:block; }


</style>

@endsection

@section('content')

<main class="container my-4">
    @isset($order)
        @php
            $user = auth()->user();
            $provider = $order->provider;
            $step_1 = $order->timeline->where('timeline_no', 1)->last();
            $step_2 = $order->timeline->where('timeline_no', 2)->last();
            $step_3 = $order->timeline->where('timeline_no', 3)->last();
            $step_4 = $order->timeline->where('timeline_no', 4)->last();
            $step_5 = $order->timeline->where('timeline_no', 5)->last();
            $step_6 = $order->timeline->where('timeline_no', 6)->last();
            $step_7 = $order->timeline->where('timeline_no', 7)->last();
            $step_9 = $order->timeline->where('timeline_no', 9)->last();
            $step_12 = $order->timeline->where('timeline_no', 12)->last();
            $routeInfo = app('router')->getRoutes()->match(\Illuminate\Http\Request::create(url()->previous()));
            $page_type_endpoint = $routeInfo->parameter('page_type') ?? 'all';
            // 1 => Order Created, 2 => Confirmed by Supplier, 3 => Processing, 4 => Shipped, 
            // 5 => Delivered, 6 => Completed, 7 => Offers Received, 8 => Supplier Selected, 
            // 9 => Converted to Order, 10 => Under Review, 11 => Assigned to Supplier
        @endphp
        <nav class="breadcrumb-custom mb-3">
            <a href="{{ route('user/myorders', 'all') }}" class="text-decoration-none text-muted">{{ __('products.orders') }}</a>
            <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
            <a href="{{ route('user/myorders', $page_type_endpoint) }}" class="text-decoration-none text-muted">{{ orderType($order->order_type) }}</a>
            <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
            <span class="text-primary fw-semibold">{{ __('products.order_details') }} #{{ $order->id }} – {{ \Carbon\Carbon::parse($order->created_at)->format('M j, Y') }}</span>
        </nav>
        <div class="row g-4">
            @include('flash::message')
            @if ($errors->any())
                <div style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}; margin: 15px;">
                    <ul dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                        @foreach ($errors->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm mx-3 mt-3" role="alert"> 
                    <i class="bi bi-check-circle-fill me-2"></i> 
                    {{ session('success') }} 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> 
                </div>
            @endif
            <div class="col-lg-7">
                <div class="detail-card reveal">
                    
                    <div class="detail-row">
                        <span class="detail-label">
                            <h5 class="mb-3">{{ __('products.order_details') }}</h5>
                        </span>
                        <span class="detail-value">
                            @if ($order->payment_status == 0)
                                <a href="{{ route('user/online-payment/actions', $order->id) }}" class="btn btn-success btn-sm" style="text-decoration: none;">
                                    <i class="bi bi-wallet-fill"></i> {{ __('products.get_payment') }}
                                </a>
                            @endif
                        </span>
                    </div>
                    <div class="detail-row"><span class="detail-label">{{ __('products.order_number') }}</span><span class="detail-value">#{{ $order->id }}</span></div>
                    <div class="detail-row"><span class="detail-label">{{ __('products.delivery_address') }}</span><span class="detail-value">{{ $order->address }}</span></div>
                    <div class="detail-row"><span class="detail-label">{{ __('products.payment_method') }}</span><span class="detail-value">{{ $order->payment_type ?? '---' }}</span></div>
                    <div class="detail-row">
                        <span class="detail-label">{{ __('products.payment_status') }}</span>
                        <span class="detail-value">{{ $order->payment_status == 1 ? __('products.paid') : __('products.unpaid') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">{{ __('products.date') }}</span>
                        <span class="detail-value">{{ \Carbon\Carbon::parse($order->created_at)->format('M j, Y') }}</span>
                    </div>
                </div>

                <div class="mt-3 reveal">
                    @if (isset($order->items) && count($order->items) > 0)
                    @foreach ($order->items as $item)
                        @php
                            $product = $item->product;
                        @endphp
                        <div class="mini-card mb-3">
                            <div class="mini-thumb"><img src="{{ asset('storage/' . $product->img) }}" alt="{{ $product->name }}"></div>
                            <div class="flex-grow-1">
                                <div class="product-title">{{ $product->name }}</div>
                                <div class="product-meta">{{ $product->category?->name }}</div>
                                <div class="text-muted small mt-1">x{{ $item->quantity }}</div>
                            </div>
                            <div class="product-price">{{ $item->item_price }} ASR</div>
                        </div>
                    @endforeach
                    @endif
                </div>

                <div class="detail-card mt-3 reveal">
                    <h6 class="mb-3">{{ __('products.timeline') }}</h6>
                    <div class="timeline">
                        <div class="t-item {{ isset($step_1->id) ? 'active' : '' }}">
                            <span class="t-bullet"></span>
                            <div class="timeline-data fw-semibold">{{ __('products.order_created') }}</div>
                            <div class="timeline-data t-date">Sep 1</div>
                            <div class="timeline-data t-date">
                                {{ \Carbon\Carbon::parse($step_1?->created_at)->format('M j, Y') }}
                            </div>
                        </div>
                        @if (!isset($step_12->id))
                            @if ($order->order_type == 1)
                                <div class="t-item {{ isset($step_2->id) ? 'active' : '' }}">
                                    <span class="t-bullet"></span>
                                    <div class="timeline-data fw-semibold">{{ __('products.confirmed_by_supplier') }}</div>
                                    <div class="timeline-data t-date">Sep 2</div>
                                    <div class="timeline-data t-date">
                                        {{ \Carbon\Carbon::parse($step_2?->created_at)->format('M j, Y') }}
                                    </div>
                                </div>
                            @endif
                            @if ($order->order_type > 1)
                                <div class="t-item {{ isset($step_7->id) ? 'active' : '' }}">
                                    <span class="t-bullet"></span>
                                    <div class="timeline-data fw-semibold">{{ __('products.offers_received') }}</div>
                                    <div class="timeline-data t-date">Sep 7</div>
                                    <div class="timeline-data t-date">
                                        {{ \Carbon\Carbon::parse($step_7?->created_at)->format('M j, Y') }}
                                    </div>
                                </div>
                                <div class="t-item {{ isset($step_9->id) ? 'active' : '' }}">
                                    <span class="t-bullet"></span>
                                    <div class="timeline-data fw-semibold">{{ __('products.converted_to_order') }}</div>
                                    <div class="timeline-data t-date">Sep 9</div>
                                    <div class="timeline-data t-date">
                                        {{ \Carbon\Carbon::parse($step_9?->created_at)->format('M j, Y') }}
                                    </div>
                                </div>
                            @endif
                            <div class="t-item {{ isset($step_3->id) ? 'active' : '' }}">
                                <span class="t-bullet"></span>
                                <div class="timeline-data fw-semibold">{{ __('products.processing') }}</div>
                                <div class="timeline-data t-date">Sep 3</div>
                                <div class="timeline-data t-date">
                                    {{ \Carbon\Carbon::parse($step_3?->created_at)->format('M j, Y') }}
                                </div>
                            </div>
                            <div class="t-item {{ isset($step_4->id) ? 'active' : '' }}">
                                <span class="t-bullet"></span>
                                <div class="timeline-data fw-semibold">{{ __('products.shipped') }}</div>
                                <div class="timeline-data t-date">Sep 4</div>
                                <div class="timeline-data t-date">
                                    {{ \Carbon\Carbon::parse($step_4?->created_at)->format('M j, Y') }}
                                </div>
                            </div>
                            <div class="t-item {{ isset($step_5->id) ? 'active' : '' }}">
                                <span class="t-bullet"></span>
                                <div class="timeline-data fw-semibold">{{ __('products.delivered') }}</div>
                                <div class="timeline-data t-date">Sep 5</div>
                                <div class="timeline-data t-date">
                                    {{ \Carbon\Carbon::parse($step_5?->created_at)->format('M j, Y') }}
                                </div>
                            </div>
                            <div class="t-item {{ isset($step_6->id) ? 'active' : '' }}">
                                <span class="t-bullet"></span>
                                <div class="timeline-data fw-semibold">{{ __('products.completed') }}</div>
                                <div class="timeline-data t-date">Sep 6</div>
                                <div class="timeline-data t-date">
                                    {{ \Carbon\Carbon::parse($step_6?->created_at)->format('M j, Y') }}
                                </div>
                            </div>
                        @else
                            <div class="t-item active">
                                <span class="t-bullet"></span>
                                <div class="timeline-data fw-semibold">{{ __('products.canceled') }}</div>
                                <div class="timeline-data t-date">Sep 12</div>
                                <div class="timeline-data t-date">
                                    {{ \Carbon\Carbon::parse($step_12?->created_at)->format('M j, Y') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="summary-card p-4 reveal">
                    <h6 class="mb-3">{{ __('products.payment_details') }}</h6>
                    <div class="row-line"><span>{{ __('products.subtotal') }}</span><span>{{ $order->items_cost }} SAR</span></div>
                    <div class="row-line"><span>{{ __('products.vat') }}({{ $order->vat }}%)</span><span>{{ $order->vat_amount }} SAR</span></div>
                    <div class="row-line"><span>{{ __('products.discount') }}</span><span>{{ $order->discount }} SAR</span></div>
                    <div class="row-line"><span>{{ __('products.delivery_fee') }}</span><span>{{ $order->delivery_fee }} SAR</span></div>
                    <div class="row-line"><strong>{{ __('products.net_total') }}</strong><strong>{{ $order->total_cost + $order->delivery_fee }} SAR</strong></div>
                    <div class="d-flex gap-2 mt-3">
                        @if (!isset($step_12->id))
                            @if (!isset($step_5->id))
                                @if (!isset($step_2->id))
                                    <button class="btn btn-ghost flex-fill">
                                        <a href="{{ route('user/cancel/order', $order->id) }}" style="text-decoration: none; color: black;">
                                            {{ __('products.cancel_order') }}
                                        </a>
                                    </button>
                                @endif
                                {{-- <button class="btn btn-gradient flex-fill">Contact Supplier</button> --}}
                                <button class="btn btn-gradient flex-fill" data-bs-toggle="modal" data-bs-target="#contactModal">
                                    {{ __('products.contact_supplier') }}
                                </button>
                                <div class="modal fade" id="contactModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content border-0 rounded-3">
                                            <div class="modal-header border-0">
                                                <h5 class="modal-title">{{ __('products.contact_supplier') }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card border-0 shadow-sm">
                                                    <div class="card-body d-flex align-items-center gap-3">
                                                        <img src="{{asset($provider?->img)}}" class="rounded-circle" width="56" height="56" alt="Logo">
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-1">{{ $provider?->name }}</h6>
                                                            <div class="text-muted small">
                                                                <i class="bi bi-mobile {{ app()->getLocale() == 'ar' ? 'ms-1' : 'me-1' }}"></i>{{ __('products.mobile') }}: {{ $provider?->mobile ?? '—' }}.
                                                            </div>
                                                            <div class="text-muted small">
                                                                <i class="bi bi-envelope {{ app()->getLocale() == 'ar' ? 'ms-1' : 'me-1' }}"></i>{{ __('products.email') }}: {{ $provider?->email ?? '—' }}.
                                                            </div>
                                                            <div class="text-muted small">
                                                                <i class="bi bi-geo-alt {{ app()->getLocale() == 'ar' ? 'ms-1' : 'me-1' }}"></i>{{ $provider?->location ?? '—' }}.
                                                                <i class="bi bi-star-fill text-warning {{ app()->getLocale() == 'ar' ? 'me-2 ms-1' : 'ms-2 me-1' }}"></i>{{ round($provider?->ratings->avg('rating'), 2) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-4 p-3 rounded-3 bg-light d-flex align-items-center">
                                                    <i class="bi bi-phone-vibrate fs-3 text-primary {{ app()->getLocale() == 'ar' ? 'ms-3' : 'me-3' }}"></i>
                                                    <div class="flex-grow-1">
                                                        <div class="fw-semibold">{{ __('products.get_app_chat') }}</div>
                                                        <div class="text-muted small">{{ __('products.download_app_msg') }}</div>
                                                    </div>
                                                    <div class="d-flex gap-2">
                                                        <a href="https://apps.apple.com/app/idXXXXXXXX" class="btn btn-dark btn-sm">
                                                            <i class="bi bi-apple {{ app()->getLocale() == 'ar' ? 'ms-1' : 'me-1' }}"></i> App Store
                                                        </a>
                                                        <a href="https://play.google.com/store/apps/details?id=XXXXXXXX" class="btn btn-success btn-sm">
                                                            <i class="bi bi-google-play {{ app()->getLocale() == 'ar' ? 'ms-1' : 'me-1' }}"></i> Google Play
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('products.close') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (isset($step_5->id) && !isset($step_6->id))
                                <div class="row gy-3">
                                    <div class="col-12">
                                        <button type="button" class="btn btn-ghost flex-fill" data-bs-toggle="modal" data-bs-target="#reportIssueModal-{{ $order->id }}">
                                            {{ __('products.report_issue') }}
                                        </button>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="btn btn-gradient flex-fill" data-bs-toggle="modal" data-bs-target="#reportConfirmDeliveryModal-{{ $order->id }}">
                                            {{ __('products.confirm_delivery') }}
                                        </button>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="btn btn-gradient flex-fill" data-bs-toggle="modal" data-bs-target="#receivePartialShipmentModal-{{ $order->id }}">
                                            {{ __('products.receive_partial') }}
                                        </button>
                                    </div>
                                </div>
                                <div class="modal fade" id="reportIssueModal-{{ $order->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('products.report_issue') }} ({{ __('products.order_details') }} #{{ $order->id }})</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="{{ route('user/update/order', $order->id) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('products.details') }}</label>
                                                    <textarea name="issue" class="form-control" rows="4" required placeholder="{{ __('products.describe_issue') }}"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('products.cancel') }}</button>
                                                <button type="submit" class="btn btn-gradient">{{ __('products.submit') }}</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="reportConfirmDeliveryModal-{{ $order->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('products.confirm_delivery') }} ({{ __('products.order_details') }} #{{ $order->id }})</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="{{ route('user/order-timeline') }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="text-center p-4">
                                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width:72px;height:72px;background:linear-gradient(135deg,#0ea5e9,#10b981);">
                                                        <svg width="34" height="34" viewBox="0 0 24 24" fill="none">
                                                            <path d="M20 6L9 17L4 12" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </div>
                                                    <h5 class="mt-3 mb-1">{{ __('products.order_delivered') }}</h5>
                                                    <p class="text-muted mb-0">{{ __('products.thank_you') }}</p>
                                                </div>
                                            </div>
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            <input type="hidden" name="order_type" value="{{ $order->order_type }}">
                                            <input type="hidden" name="timeline_no" value="6">
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('products.cancel') }}</button>
                                                <button type="submit" class="btn btn-gradient">{{ __('products.submit') }}</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="receivePartialShipmentModal-{{ $order->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ __('products.partial_shipment') }} ({{ __('products.order_details') }} #{{ $order->id }})</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="{{ route('user/order/partial-receive') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="modal-body pt-0">
                                                <div class="mb-3">
                                                    <label class="form-label small text-muted mb-1">{{ __('products.received_quantity') }} <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" name="received_quantity" rows="2" placeholder="{{ __('products.enter_quantity') }}"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small text-muted mb-1">{{ __('products.reason_partial') }}</label>
                                                    <textarea class="form-control" name="reason_for_partial" rows="3" placeholder="{{ __('products.reason_placeholder') }}"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small text-muted mb-1">{{ __('products.attach_images') }}</label>
                                                    <div class="border rounded-3 p-4 text-center bg-light">
                                                        <input class="form-control" type="file" name="files[]" accept="image/*" multiple>
                                                        <div class="small text-muted mt-2">{{ __('products.add_images_proof') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('products.cancel') }}</button>
                                                <button type="submit" class="btn btn-gradient">{{ __('products.submit') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                </div>
                            @endif
                            @if (isset($step_6->id) && !is_null($order->provider_id))
                                <button type="button" class="btn btn-gradient flex-fill" data-bs-toggle="modal" data-bs-target="#addReviewModal-{{ $order->id }}">
                                    {{ __('products.rate_supplier') }}
                                </button>
                                <div class="modal fade" id="addReviewModal-{{ $order->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content border-0 rounded-3">
                                            <div class="modal-header border-0">
                                                <h5 class="modal-title">{{ __('products.add_review') }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <form method="POST" action="{{ route('user/store/ratings') }}" id="review-form-{{ $order->id }}">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-4">
                                                        <label class="form-label d-block">{{ __('products.rating') }}</label>
                                                        <div class="rating-stars" data-input="#rating-input-{{ $order->id }}">
                                                            <i class="bi bi-star star" data-value="1"></i>
                                                            <i class="bi bi-star star" data-value="2"></i>
                                                            <i class="bi bi-star star" data-value="3"></i>
                                                            <i class="bi bi-star star" data-value="4"></i>
                                                            <i class="bi bi-star star" data-value="5"></i>
                                                        </div>
                                                        <input type="hidden" name="rating" id="rating-input-{{ $order->id }}" required>
                                                    </div>
                                                    <div>
                                                        <label class="form-label">{{ __('products.detail_review') }}</label>
                                                        <textarea name="comment" class="form-control" rows="4" placeholder="{{ __('products.rate_experience') }}" required></textarea>
                                                    </div>
                                                    <input type="hidden" name="for_type" value="User">
                                                    <input type="hidden" name="for_id" value="{{ $order->provider_id ?? 0 }}">
                                                </div>

                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('products.cancel') }}</button>
                                                    <button type="submit" class="btn btn-gradient">{{ __('products.submit_review') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            @isset($order->offers)
                <section class="container my-4">
                    <h6 class="mb-3">{{ __('products.offer_list') }}</h6>
                    <div class="row g-3">
                        @foreach($order->offers as $offer)
                            @php
                                $OFStatus = __('products.pending');
                                $OFStatusBG = 'primary';
                                if ($offer->status == 2) { $OFStatus = __('products.accepted'); $OFStatusBG = 'success'; }
                                elseif ($offer->status == 3) { $OFStatus = __('products.rejected'); $OFStatusBG = 'danger'; }
                            @endphp
                            <div class="col-7">
                                <div class="card shadow-sm border-0 mb-3">
                                    <div class="card-header bg-light border-0">
                                        <strong>{{ __('products.offer') }} #{{ $offer->id }}</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-file-earmark-pdf text-danger"></i>
                                                <span class="text-muted small">{{ $offer->filename ?? 'quotation.pdf' }}</span>
                                            </div>
                                            <a href="{{ route('user/order/offers/download', $offer->id) }}" class="btn btn-light btn-sm">
                                                <i class="bi bi-download {{ app()->getLocale() == 'ar' ? 'ms-1' : 'me-1' }}"></i> {{ __('products.download') }}
                                            </a>
                                        </div>
                                        <span class="btn btn-{{ $OFStatusBG }} btn-sm">{{ $OFStatus }}</span>
                                        @if (!is_null($offer->rejected_reson))
                                            <div class="mb-1">
                                                <span class="fw-semibold">{{ __('products.rejected_reason') }}:</span>
                                                <span class="text-muted">{{ $offer->rejected_reson }}</span>
                                            </div>
                                        @endif
                                        <div class="mb-1 mt-3">
                                            <span class="fw-semibold">{{ __('products.provider') }}:</span>
                                            <span>{{ $offer->provider?->name }}</span>
                                        </div>
                                        <div class="mb-1">
                                            <span class="fw-semibold">{{ __('products.total_price') }}:</span>
                                            <span>{{ number_format($offer->cost, 0) }} SAR</span>
                                        </div>
                                        <div class="mb-1">
                                            <span class="fw-semibold">{{ __('products.delivery_time') }}:</span>
                                            <span>{{ $offer->delivery_time }}</span>
                                        </div>
                                        <div class="mb-1">
                                            <span class="fw-semibold">{{ __('products.warranty') }}:</span>
                                            <span>{{ $offer->warranty }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <span class="fw-semibold">{{ __('products.notes') }}:</span>
                                            <span class="text-muted">{{ $offer->notes }}</span>
                                        </div>
                                        @if ($offer->status == 1)
                                            <button class="btn btn-gradient w-100" data-bs-toggle="modal" data-bs-target="#offerDetailsModal-{{ $offer->id }}">
                                                {{ __('products.view_details') }}
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="offerDetailsModal-{{ $offer->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content border-0 rounded-3">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title">{{ __('products.offer_details') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="bi bi-file-earmark-pdf text-danger fs-5"></i>
                                                    <span class="text-muted">{{ $offer->filename ?? 'quotation.pdf' }}</span>
                                                </div>
                                                <a href="{{ $offer->file_url ?? '#' }}" class="btn btn-light btn-sm">
                                                    <i class="bi bi-download {{ app()->getLocale() == 'ar' ? 'ms-1' : 'me-1' }}"></i> {{ __('products.download') }}
                                                </a>
                                            </div>
                                            <div class="mb-2">
                                                <span class="fw-semibold">{{ __('products.total_price') }}:</span>
                                                <span>{{ number_format($offer->cost, 0) }} SAR</span>
                                            </div>
                                            <div class="mb-2">
                                                <span class="fw-semibold">{{ __('products.delivery_time') }}:</span>
                                                <span>{{ $offer->delivery_time ?? '---' }}</span>
                                            </div>
                                            <div class="mb-2">
                                                <span class="fw-semibold">{{ __('products.warranty') }}:</span>
                                                <span>{{ $offer->warranty ?? '---' }}</span>
                                            </div>
                                            <div class="mb-0">
                                                <span class="fw-semibold">{{ __('products.notes') }}:</span>
                                                <span class="text-muted">{{ $offer->notes ?? '---' }}</span>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 justify-content-center gap-3">
                                            <button class="btn btn-outline-secondary reject-offer" data-bs-toggle="modal" data-bs-target="#rejectOfferModal-{{ $offer->id }}">
                                                {{ __('products.reject_offer') }}
                                            </button>

                                            <form method="POST" action="{{ route('user/offer/actions') }}">
                                                @csrf
                                                <input name="action" type="hidden" value="2">
                                                <input name="offer_id" type="hidden" value="{{ $offer->id }}">
                                                <button type="submit" class="btn btn-gradient px-5">{{ __('products.accept_offer') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="rejectOfferModal-{{ $offer->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content border-0 rounded-3">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title">{{ __('products.reject_offer') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="{{ route('user/offer/actions') }}">
                                            @csrf
                                            <div class="modal-body">
                                                <input name="action" type="hidden" value="3">
                                                <input name="offer_id" type="hidden" value="{{ $offer->id }}">
                                                <div class="col-12 mb-4">
                                                    <label class="form-label">{{ __('products.rejected_reason') }}</label>
                                                    <textarea name="rejected_reson" class="form-control" rows="4" placeholder="{{ __('products.write_reason') }}"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 justify-content-center gap-3">
                                                <button type="button" class="btn btn-outline-gradient px-5" data-bs-dismiss="modal">{{ __('products.cancel') }}</button>
                                                <button type="submit" class="btn btn-gradient px-5">{{ __('products.confirm_reject') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endisset

            @isset($order->partial_receive)
                @foreach($order->partial_receive as $partial_receive)
                    <div class="detail-card reveal mt-3">
                        <div class="detail-row">
                            <span class="detail-label">
                                <h5 class="mb-3">{{ __('products.partial_shipment') }} #{{ $partial_receive->id }}</h5>
                            </span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">{{ __('products.received_quantity') }}: {{ $partial_receive->received_quantity }}</span>
                            <span class="detail-value"></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">{{ __('products.reason_partial') }}: {{ $partial_receive->reason_for_partial }}</span>
                            <span class="detail-value"></span>
                        </div>
                        <div class="detail-row">
                            <div class="row">
                                <div class="col-1">
                                    <span class="detail-label {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}">{{ __('products.files') }}</span>
                                </div>
                                <div class="col-11">
                                    <div class="files-grid">
                                        @foreach(explode(',', $partial_receive->files) as $img)
                                            <a href="{{ asset($img) }}" target="_blank" class="cell"><img src="{{ asset($img) }}" alt=""></a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row">
                                @foreach(explode(',', $partial_receive->files) as $img)
                                    <a href="{{ asset($img) }}" target="_blank">
                                        <img class="ml-2 col-md-3" src="{{ asset($img) }}" style="max-width: 13%; margin-left: 8px;">
                                    </a>
                                @endforeach
                            </div> --}}
                        </div>
                    </div>
                @endforeach
            @endisset

        </div>
    @endisset
</main>

@endsection

<!-- custom js -->
@section('script')
<script>
    $(function(){
        $('#nav-orders').addClass('active');
        $(document).on('show.bs.modal', '[id^="rejectOfferModal-"]', function(){
            $(this).find('.col-7').remove();
        });
        $('[id^="offerDetailsModal-"], [id^="rejectOfferModal-"]').each(function(){
            if (this.parentElement !== document.body) {
                $(this).appendTo(document.body);
            }
        });
    });

    document.addEventListener('click', function(e){
        if(!e.target.classList.contains('star')) return;
        const star   = e.target;
        const wrap   = star.closest('.rating-stars');
        const value  = Number(star.dataset.value);
        const input  = document.querySelector(wrap.dataset.input);

        wrap.querySelectorAll('.star').forEach(s=>{
            const v = Number(s.dataset.value);
            s.classList.toggle('filled', v <= value);
            s.classList.toggle('bi-star', v > value);
            s.classList.toggle('bi-star-fill', v <= value);
        });
        if(input) input.value = value;
    });
</script>

@endsection
