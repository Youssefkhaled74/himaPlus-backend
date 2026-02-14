@extends('layouts.front.home')

<!-- title page -->
@section('title')
    <title>{{ __('products.cart_title') }}</title>
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
            <span class="text-primary fw-semibold">{{ __('products.cart') }}</span>
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
                <div class="col-lg-7 reveal item-area">
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
                                @php
                                    $img = $product->img ?? '';
                                    if ($img) {
                                        if (strpos($img, 'http') === 0) {
                                            $imgUrl = $img;
                                        } elseif (strpos($img, 'storage/') === 0) {
                                            $imgUrl = asset($img);
                                        } else {
                                            $imgUrl = asset('storage/' . $img);
                                        }
                                    } else {
                                        $imgUrl = asset('front/assets/images/placeholder.png');
                                    }
                                @endphp
                                <div class="product-thumb"><img src="{{ $imgUrl }}" alt="{{ $product->name }}"></div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <div class="product-title">{{ $product->name }}</div>
                                            <div class="product-meta">{{ $product->category?->name }}</div>
                                        </div>
                                        <a class="btn-outline-delete" href="{{ route('user/cart/remove', $product->id) }}">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <div class="product-price">{{ $product->price }} SAR</div>
                                        {{-- <div class="product-price product-total-price">{{ $cost }} SAR</div> --}}
                                        <div class="product-qty">
                                            <button class="btn btn-light border qty-decrease qty-quantity" 
                                                data-id="{{ $product->id }}" data-type="negative" data-url="{{ route('user/cart/update/quantity', $product->id) }}" 
                                                parent-id="item-area-{{ $item->product_id }}" data-price="{{ $product->price }}"
                                            >
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <input type="text" class="form-control form-control-sm text-center" value="{{ $item->quantity }}" style="width:54px">
                                            <button class="btn btn-light border qty-increase qty-quantity" 
                                                data-id="{{ $product->id }}" data-type="plus" data-url="{{ route('user/cart/update/quantity', $product->id) }}"
                                                data-price="{{ $product->price }}"
                                            >
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
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
                <h6 class="mb-3">{{ __('products.payment_details') }}</h6>
                <div class="row-line"><span>{{ __('products.subtotal') }}</span><span id="subtotal-area">{{ $subtotal }} SAR</span></div>
                <div class="row-line"><span>{{ __('products.vat') }}</span><span id="vat-area">{{ $vat }} SAR</span></div>
                <div class="row-line"><strong>{{ __('products.net_total') }}</strong><strong id="nettotal-area">{{ $subtotal + $vat }} SAR</strong></div>
                <a href="{{ route('user/cart/checkout') }}" class="btn btn-gradient w-100 mt-3 py-2">{{ __('products.proceed_to_payment') }}</a>
                </div>
            </div>
        </div>
    </main>
@endsection

<!-- custom js -->
@section('script')
<script>
    $(document).on('click', '.qty-quantity', function() {
        var dataId = $(this).data('id');
        var dataUrl = $(this).data('url');
        var dataType = $(this).data('type');
        var _token = $('input[name="_token"]').val();
        const parentId = $(this).attr('parent-id');
        const $item = $('#'+parentId);
        event.preventDefault();
        $.ajax({
            url: dataUrl,
            method: "GET",
            data: {
                type: dataType,
                _token: _token
            },
            success: function(data) {
                console.log(data);
                console.log(data.data?.new_quan);
                if (data.data?.new_quan == 0) {
                    $item.remove();
                    $('.item-area').append(`<div class="product-item mb-3">
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="product-title">{{ __('products.empty_cart') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>`);
                    return;
                }
            }
        });
    });
    // $(document).on('click', 'button.qty-decrease', function(e){
    //     e.preventDefault();
    //     const parentId = $(this).attr('parent-id');
    //     const $item = $('#'+parentId);
    //     const $qty = $item.find('input[type="text"].form-control');
    //     const val = parseInt(($qty.val() || '0'), 10);
    //     if (val === 1) { $item.remove(); return; }
    // });
</script>
<script>
    const VAT_RATE = 0.10;

    const toNum = v => {
        const n = Number((v+'').trim());
        return Number.isNaN(n) ? 0 : n;
    };
    const money = n => Number(n).toFixed(2) + ' SAR';

    function recalcTotalsNoTouchInputs() {
        let subtotal = 0;

        document.querySelectorAll('.product-item').forEach(item => {
        const qtyBox = item.querySelector('.product-qty');
        if (!qtyBox) return;

        const inp    = qtyBox.querySelector('input[type="text"]');
        const btnAny = qtyBox.querySelector('.qty-quantity');
        const price  = toNum(btnAny?.getAttribute('data-price'));
        const qty    = Math.max(1, toNum(inp?.value ?? 1));

        subtotal += price * qty;
        const priceEl = item.querySelector('.product-total-price');
        if (priceEl) priceEl.textContent = money(price * qty).replace(' SAR','') + ' SAR';
        });

        const vat = +(subtotal * VAT_RATE).toFixed(2);
        const net = +(subtotal + vat).toFixed(2);
        const subEl = document.getElementById('subtotal-area');
        const vatEl = document.getElementById('vat-area');
        const netEl = document.getElementById('nettotal-area');
        if (subEl) subEl.textContent = money(subtotal);
        if (vatEl) vatEl.textContent = money(vat);
        if (netEl) netEl.textContent = money(net);
    }

    // document.addEventListener('click', function(e){
    //     const btn = e.target.closest('.qty-quantity');
    //     if (!btn) return;
    //     e.preventDefault();
    //     e.stopPropagation();

    //     recalcTotalsNoTouchInputs();
    //     const url = btn.getAttribute('data-url');
    //     const id  = btn.getAttribute('data-id');
    //     if (url && id && window.$) {
    //         const box = btn.closest('.product-qty');
    //         const qty = Math.max(1, toNum(box.querySelector('input[type="text"]').value));
    //         $.post(url, { item_id:id, qty:qty });
    //     }
    // });

    document.addEventListener('DOMContentLoaded', recalcTotalsNoTouchInputs);
</script>


@endsection
