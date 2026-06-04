@extends('layouts.front.home')

<!-- title page -->
@section('title')
    <title>{{ __('products.categories_title') }}</title>
@endsection

<!-- custom page -->
@section('css')
<style>
    .autocomplete-wrap { position: relative; }
    .autocomplete-wrap .suggestions-list {
        position: absolute; top: 100%; left: 0; right: 0; z-index: 1050;
        background: #fff; border: 1px solid #d1d9e6; border-radius: 0 0 10px 10px;
        max-height: 220px; overflow-y: auto; display: none;
        box-shadow: 0 8px 24px rgba(0,0,0,.08);
        list-style: none; padding: 0; margin: 0;
    }
    .autocomplete-wrap .suggestions-list li {
        padding: .5rem .85rem; cursor: pointer; font-size: .88rem;
        transition: background .1s;
    }
    .autocomplete-wrap .suggestions-list li:hover,
    .autocomplete-wrap .suggestions-list li.highlighted {
        background: #eef2ff; color: #0f4bbf;
    }
</style>
@endsection

@section('content')

    <main>
        <section id="hero" class="hero-landing hero-home" style="background-image:url({{ asset('front/assets/images/men-girls-are-surfing.png') }});">
            <div class="container position-relative">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-xl-6">
                        <span class="eyebrow text-uppercase text-white-50"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-up">{{ __('products.categories_eyebrow') }}</span>
                        <h1 class="display-5 fw-semibold mb-3 text-white"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-up" data-aos-delay="50">{{ __('products.categories_heading') }}</h1>
                        <p class="lead text-white-70 mb-4"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-up" data-aos-delay="100">
                            {{ __('products.categories_desc') }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container">
                @isset($report['category'])
                    <form method="GET" action="{{ route('categoryProducts', [$report['category']->id]) }}" class="row g-2 mb-4" id="productsFilterForm">
                        <div class="col-md-3 autocomplete-wrap">
                            <input class="form-control" name="product_name" value="{{ request('product_name') }}" placeholder="{{ __('products.product_name') }}" autocomplete="off" data-suggest="name">
                            <ul class="suggestions-list"></ul>
                        </div>
                        <div class="col-md-2 autocomplete-wrap">
                            <input class="form-control" name="factory_name" value="{{ request('factory_name') }}" placeholder="{{ __('products.factory_name') }}" autocomplete="off" data-suggest="factory_name">
                            <ul class="suggestions-list"></ul>
                        </div>
                        <div class="col-md-2 autocomplete-wrap">
                            <input class="form-control" name="vendor_name" value="{{ request('vendor_name') }}" placeholder="{{ __('products.supplier_name') }}" autocomplete="off" data-suggest="vendor_name">
                            <ul class="suggestions-list"></ul>
                        </div>
                        <div class="col-md-3 autocomplete-wrap">
                            <input class="form-control" name="factory_country" value="{{ request('factory_country') }}" placeholder="{{ __('products.factory_country') }}" autocomplete="off" list="countryList">
                            <datalist id="countryList">
                                @foreach($countries as $country)
                                    <option value="{{ $country->name }}">{{ $country->name }}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-md-2 d-flex gap-2">
                            <button class="btn btn-primary w-100" type="submit">{{ __('products.filter') }}</button>
                            <a href="{{ route('categoryProducts', [$report['category']->id]) }}" class="btn btn-outline-secondary">{{ __('products.reset') }}</a>
                        </div>
                    </form>
                    <nav class="hp-breadcrumb small mb-4">
                        <a href="{{ route('categories') }}" class="hp-crumb">{{ __('products.home') }}</a>
                        <i class="bi bi-chevron-right"></i>
                        <span class="hp-crumb text-body-secondary">
                            <a href="{{ route('categories') }}" style="color: #47566B;">{{ __('products.categories') }}</a>
                        </span>
                        <i class="bi bi-chevron-right"></i>
                        <span class="hp-crumb text-body-secondary">{{ $report['category']->name }}</span>
                    </nav>
                    <div class="row g-4">
                        @foreach ($products as $g => $product)
                            <div class="col-md-6 col-lg-4">
                                <article class="equipment-card h-100"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-up">
                                    {{-- <img src="{{ asset($product->img) }}" class="equipment-card__image" alt="{{ $product->name }}"> --}}
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $product->img) }}" class="equipment-card__image" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='{{ asset('front/assets/images/emptyproducts.png') }}'">
                                        @if (is_null($product->is_favorite))
                                            <button class="wishlist-btn btn p-0 position-absolute top-0 end-0 m-2" data-id="{{ $product->id }}" aria-label="Add to wishlist">
                                                <i class="bi bi-heart fs-5"></i>
                                            </button>
                                        @else
                                            <button class="wishlist-btn btn p-0 position-absolute top-0 end-0 m-2 active" data-id="{{ $product->id }}" aria-label="Add to wishlist">
                                                <i class="bi fs-5 bi-heart-fill"></i>
                                            </button>
                                        @endif
                                    </DIV>
                                    <div class="equipment-card__body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1">{{ $product->name }}</h6>
                                                <span class="badge bg-light text-primary fw-semibold">{{ $report['category']->name }}</span>
                                            </div>
                                            <span class="rating-badge">
                                                <i class="bi bi-star-fill me-1"></i>
                                                {{ substr(number_format((float) $product->ratings_avg_rating, 1, '.', ''), 0) }}
                                            </span>
                                        </div>
                                        <p class="text-muted small mb-3">{{ $product->desc }}</p>
                                        <div class="small text-muted mb-2 d-flex align-items-center gap-2">
                                            <img src="{{ $product->provider?->img ? asset($product->provider->img) : asset('front/assets/images/emptyproducts.png') }}" style="width:22px;height:22px;border-radius:50%;object-fit:cover;" alt="supplier">
                                            <span>{{ $product->provider?->name ?? 'Supplier' }}</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="equipment-price me-3">{{ $product->price }} SAR</span>
                                            
                                            <button class="hp-pill-btn ms-auto me-2 add-to-cart" data-id="{{ $product->id }}" data-img="{{ asset('storage/' . $product->img) }}" title="Add to cart" onerror="this.onerror=null;this.src='{{ asset('front/assets/images/emptyproducts.png') }}'">
                                                <i class="bi bi-cart-plus-fill"></i>
                                            </button>
                                            <a href="{{ route('product', [$product->id]) }}" class="btn btn-gradient btn-sm px-3 me-2">{{ __('products.details') }}</a>
                                            <a href="{{ route('products', ['vendor_name' => $product->provider?->name]) }}" class="btn btn-outline-secondary btn-sm px-2">{{ __('products.supplier') }}</a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                    <div class="ltn__pagination-area text-center mt-5">
    
                        {{-- pagination area --}}
                        <div class="d-flex justify-content-center mt-2">
                            <div class="d-flex justify-content-center mt-2">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination flex-wrap justify-content-center" style="align-items: center;">
                                        <!-- Previous Button -->
                                        @if (!$products->onFirstPage())
                                            <li class="page-item mt-1">
                                                <a class="page-link" href="{{ $products->previousPageUrl() }}"
                                                aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                        @endif
                        
                                        <!-- Pagination Numbers -->
                                        @for ($i = 1; $i <= $products->lastPage(); $i++)
                                            <li class="page-item mt-1 {{ $i == $products->currentPage() ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $products->url($i) }}"
                                                @if ($i == $products->currentPage()) style="font-weight:bold;" @endif>
                                                    {{ $i }}
                                                </a>
                                            </li>
                                        @endfor
                        
                                        <!-- Next Button -->
                                        @if ($products->hasMorePages())
                                            <li class="page-item mt-1">
                                                <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>

                    </div>
                @endisset
            </div>
        </section>
    </main>
        
@endsection

<!-- custom js -->
@section('script')
<script>
    $(function(){
        $('#nav-categories').addClass('active');

        var suggestTimeout;
        $('[data-suggest]').each(function () {
            var $input = $(this);
            var $list  = $input.next('.suggestions-list');
            var field  = $input.data('suggest');

            $input.on('input', function () {
                clearTimeout(suggestTimeout);
                var val = $input.val().trim();
                if (val.length < 1) { $list.hide().empty(); return; }
                suggestTimeout = setTimeout(function () {
                    $.getJSON('{{ route("products/suggestions") }}', { field: field, q: val }, function (data) {
                        $list.empty();
                        if (data.length === 0) { $list.hide(); return; }
                        $.each(data.slice(0, 10), function (i, item) {
                            $list.append('<li>' + $('<span>').text(item).html() + '</li>');
                        });
                        $list.show();
                    });
                }, 200);
            });

            $list.on('click', 'li', function () {
                $input.val($(this).text());
                $list.hide().empty();
            });

            $list.on('mouseenter', 'li', function () {
                $list.find('.highlighted').removeClass('highlighted');
                $(this).addClass('highlighted');
            });

            $(document).on('click', function (e) {
                if (!$input.is(e.target) && !$list.is(e.target) && $list.has(e.target).length === 0) {
                    $list.hide();
                }
            });
        });
    });
</script>
@endsection
