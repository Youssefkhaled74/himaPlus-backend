@extends('layouts.front.home')

<!-- title page -->
@section('title')
    <title>{{ __('products.categories_title') }}</title>
@endsection

<!-- custom page -->
@section('css')
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
                                        <img src="{{ asset('storage/' . $product->img) }}" class="equipment-card__image" alt="{{ $product->name }}">
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
                                        <div class="d-flex align-items-center">
                                            <span class="equipment-price me-3">{{ $product->price }} SAR</span>
                                            
                                            <button class="hp-pill-btn ms-auto me-2 add-to-cart" data-id="{{ $product->id }}" data-img="{{ asset('storage/' . $product->img) }}" title="Add to cart">
                                                <i class="bi bi-cart-plus-fill"></i>
                                            </button>
                                            <a href="{{ route('product', [$product->id]) }}" class="btn btn-gradient btn-sm px-3 me-2">{{ __('products.details') }}</a>
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
    });
</script>
@endsection
