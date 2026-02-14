@extends('layouts.front.home')

<!-- title page -->
@section('title')
    <title>{{ __('products.checkout_title') }}</title>
@endsection

<!-- custom page -->
@section('css')
    <style></style>
@endsection

@section('content')
    <main class="container my-5" style="padding-top: 3%; padding-bottom: 7%;">
        <nav class="breadcrumb-custom mb-3">
            <a href="{{ route('home') }}" class="text-decoration-none text-muted">{{ __('products.home') }}</a>
            <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
            <a href="{{ route('user/cart') }}" class="text-decoration-none text-muted">{{ __('products.cart') }}</a>
            <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
            <span class="text-primary fw-semibold">{{ __('products.checkout') }}</span>
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
            @php
                $vat = 0;
                $rate = 0.10;
                $subtotal = 0;
            @endphp
            @isset($cart)
                <div class="col-lg-7 reveal">
                    <!-- List items -->
                    
                @if(count($cart) > 0)
                    @foreach ($cart as $item)
                        @php
                            $product = $item?->product;
                            $cost = $item->quantity * $product->price;
                            $subtotal += $cost;
                            $vat += $cost * $rate;
                        @endphp
                        <div class="product-item mb-3" id="item-area-{{ $item->product_id }}">
                            <div class="product-thumb"><img src="{{ asset('storage/' . $product->img) }}" alt="{{ $product->name }}"></div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <div class="product-title">{{ $product->name }}</div>
                                        <div class="product-meta">{{ $product->category?->name }}</div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div class="product-price"><span class="text-black">{{ __('products.cost') }}:</span> {{ $cost }} SAR</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="product-item mb-3">
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="product-title">{{ __('products.empty_cart') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                    
                </div>
            @endisset
            
            <div class="col-lg-5 reveal">
                <div class="summary-card p-4">
                    <form method="POST" action="{{ route('user/order/store') }}">
                        @csrf
                        <div class="mb-3">
                            <h6 class="mb-2"><i class="bi bi-geo-alt-fill text-primary {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}"></i>{{ __('products.address') }} <span class="text-danger">*</span></h6>
                            <input class="form-control text-muted" name="address" placeholder="{{ __('products.add_address') }}">
                        </div>
                        <div class="mb-3">
                            <h6 class="mb-2">{{ __('products.add_coupon') }}</h6>
                            <div class="input-group">
                                <input id="coupon-value" name="coupon" class="form-control" placeholder="{{ __('products.add_coupon') }}">
                                <button id="check-coupon" class="btn btn-light border">{{ __('products.apply') }}</button>
                            </div>
                            <span id="coupon-message">

                            </span>
                        </div>
                        {{-- <div class="mb-3">
                            <h6 class="mb-2">Choose Payment Method</h6>
                            <label class="method">
                                <input type="radio" name="pay" checked> 
                                <span>Cash on Delivery</span>
                            </label>
                            <label class="method">
                                <input type="radio" name="pay"> 
                                <span class="logos">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg" alt="visa">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a4/Mastercard_2019_logo.svg" alt="mc">
                                </span>
                                <span>Credit Card</span>
                            </label>
                            <label class="method">
                                <input type="radio" name="pay"> <span>Apple Pay</span>
                            </label>
                            <label class="method">
                                <input type="radio" name="pay"> <span>Installments – via Tamara</span>
                            </label>
                            <label class="method">
                                <input type="radio" name="pay"> <span>Installments – via Tabby</span>
                            </label>
                        </div> --}}
                        <h6 class="mb-2">{{ __('products.payment_details') }}</h6>
                        <div class="row-line"><span>{{ __('products.subtotal') }}</span><span id="subtotal-area-checkout">{{ $subtotal }} SAR</span></div>
                        <div class="row-line"><span>{{ __('products.vat') }}</span><span id="vat-area-checkout">{{ $vat }} SAR</span></div>
                        {{-- <div class="row-line"><span>Delivery Fee</span><span>50 SAR</span></div> --}}
                        <div class="row-line"><strong>{{ __('products.net_total') }}</strong><strong id="nettotal-area-checkout">{{ $subtotal + $vat }} SAR</strong></div>
                        <button type="submit" class="btn btn-gradient w-100 mt-3 py-2">{{ __('products.complete_order') }}</button>
                    </form>
                </div>
            </div>
        </div>
        <strong id="net-checkout" style="display: none;">{{ $subtotal + $vat }}</strong>
    </main>
@endsection

<!-- custom js -->
@section('script')
<script>
    $(document).on('click', '#check-coupon', function() {
        var coupon = $('#coupon-value').val();
        var _token = $('input[name="_token"]').val();
        event.preventDefault();
        $.ajax({
            url: `{{ route('user/check/coupon') }}`,
            method: "POST",
            data: {
                coupon: coupon,
                _token: _token
            },
            success: function(data) {
                if(data.status == 200){
                    var coupon  = data.data;
                    var baseNet = $('#net-checkout').text();
                    let discount = 0;
                    if (coupon.type === 2){
                        discount = baseNet * (coupon.amount/100);
                    } else {
                        discount = Number(coupon.amount);
                    }
                    discount = Math.min(discount, baseNet);
                    const newNet = baseNet - discount;
                    $('#nettotal-area-checkout').text(newNet.toFixed(2) + ' SAR');
                }else{
                    $('#coupon-message').append('<span id="coupon-message" class="btn btn-light border text-danger mt-2">{{ __('products.invalid_coupon') }}</span>');
                }
            }
        });
    });
    $(document).on('click', 'button.qty-decrease', function(e){
        e.preventDefault();
        const parentId = $(this).attr('parent-id');
        const $item = $('#'+parentId);
        const $qty = $item.find('input[type="text"].form-control');
        const val = parseInt(($qty.val() || '0'), 10);
        if (val === 1) { $item.remove(); return; }
    });
</script>

@endsection
