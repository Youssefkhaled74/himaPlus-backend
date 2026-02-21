@extends('layouts.front.home')

@section('title')
    <title>{{ __('nav.view_products') ?? 'My Products' }} - Vendor | HemaPulse</title>
@endsection

@section('css')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');

        .hp-main,
        .hp-main * {
            font-family: "Poppins", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .hp-main {
            background: #f7f9fc;
        }

        .vendor-products-wrap {
            max-width: 1320px;
            padding-top: 10px;
            padding-bottom: 40px;
        }

        .hp-page-head {
            margin-bottom: 16px;
        }

        .hp-page-title {
            margin: 0;
            font-size: 30px;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: #0f172a;
        }

        .hp-page-subtitle {
            margin: 6px 0 0;
            font-size: 14px;
            color: #64748b;
        }

        .hp-section-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 14px;
        }

        .hp-section-title {
            font-size: 28px;
            font-weight: 700;
            color: #0b3a82;
            margin: 0;
        }

        .hp-search {
            position: relative;
            width: 100%;
            max-width: 320px;
        }

        .hp-search .hp-search-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: #9aa4b2;
            font-size: 14px;
        }

        html[dir="rtl"] .hp-search .hp-search-icon {
            right: 12px;
        }

        html:not([dir="rtl"]) .hp-search .hp-search-icon {
            left: 12px;
        }

        .hp-search input {
            height: 40px;
            border-radius: 8px;
            border: 1px solid #dfe6f1;
            background: #fff;
            padding-inline: 36px 12px;
            font-size: 13px;
            box-shadow: none;
        }

        .hp-search input::placeholder {
            color: #a8b2bf;
        }

        .hp-search input:focus {
            border-color: rgba(13, 110, 253, .35);
            box-shadow: 0 0 0 .2rem rgba(13, 110, 253, .10);
        }

        .hp-btn-gradient {
            height: 38px;
            border-radius: 7px;
            font-weight: 700;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0 14px;
            border: 0;
            color: #fff !important;
            background: linear-gradient(90deg, #0b3a82 0%, #0e5bd8 52%, #0ea5a4 110%);
            text-decoration: none;
            white-space: nowrap;
            transition: filter .15s ease;
        }

        .hp-btn-gradient:hover {
            filter: brightness(1.04);
            color: #fff !important;
        }

        .product-card {
            border: 1px solid #e9eef6;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
            transition: transform .15s ease;
            height: 100%;
            text-decoration: none;
            display: block;
        }

        .product-card:hover {
            transform: translateY(-2px);
        }

        .product-thumb {
            position: relative;
            height: 150px;
            background: #f3f4f6;
            overflow: hidden;
            width: 100%;
        }

        .product-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-body {
            padding: 10px 10px 12px;
        }

        .product-name {
            font-size: 12px;
            font-weight: 600;
            color: #111827;
            margin: 0 0 4px;
            line-height: 1.35;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-price {
            font-size: 12px;
            font-weight: 700;
            color: #0b55c6;
            margin: 0;
        }

        .empty-wrap {
            border: 1px solid #eef0f3;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .05);
            padding: 44px 18px;
            text-align: center;
        }

        .empty-img {
            max-height: 260px;
            width: auto;
        }

        .pagination .page-link {
            border-radius: 6px !important;
            margin: 0 3px;
            font-size: 12px;
            color: #3f4f63;
        }

        @media (max-width: 991.98px) {
            .hp-section-title {
                font-size: 24px;
            }
        }

        @media (max-width: 767.98px) {
            .vendor-products-wrap {
                padding-top: 16px;
            }

            .hp-section-row {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .hp-section-title {
                font-size: 21px;
            }

            .hp-page-title {
                font-size: 24px;
            }

            .hp-page-subtitle {
                font-size: 13px;
            }

            .hp-search {
                max-width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <main class="hp-main">
        <section id="hero" class="hero-landing hero-home" style="background-image:url({{ asset('front/assets/images/men-girls-are-surfing.png') }});"></section>

        <div class="container vendor-products-wrap">
            @include('flash::message')

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="hp-page-head">
                <h1 class="hp-page-title">{{ app()->getLocale() == 'ar' ? 'إدارة المنتجات' : 'Product Management' }}</h1>
                <p class="hp-page-subtitle">
                    {{ app()->getLocale() == 'ar'
                        ? 'تابع منتجاتك بسهولة، وحدث الأسعار والمخزون بسرعة من لوحة واحدة.'
                        : 'Manage your catalog efficiently and keep pricing and stock details up to date.' }}
                </p>
            </div>

            <div class="hp-section-row">
                <h2 class="hp-section-title">{{ app()->getLocale() == 'ar' ? 'منتجاتنا' : 'Our Products' }}</h2>

                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <form method="GET" action="{{ route('vendor/products') }}" class="d-flex align-items-center">
                        <div class="hp-search">
                            <i class="bi bi-search hp-search-icon"></i>
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search', $search ?? '') }}"
                                placeholder="{{ app()->getLocale() == 'ar' ? 'بحث...' : 'Search...' }}"
                                class="form-control"
                            />
                        </div>
                    </form>

                    <a href="{{ route('vendor/products/create') }}" class="hp-btn-gradient">
                        <i class="bi bi-plus-lg"></i>
                        {{ __('nav.add_product') ?? 'Add Product' }}
                    </a>
                </div>
            </div>

            @if(isset($products) && $products->count() > 0)
                <div class="row g-4">
                    @foreach($products as $product)
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                            <a href="{{ route('vendor/products/show', $product->id) }}" class="product-card">
                                <div class="product-thumb">
                                    @if(!empty($product->img))
                                        @php
                                            $imgPath = ltrim((string) $product->img, '/');
                                            if (!str_starts_with($imgPath, 'http') && !str_contains($imgPath, '/')) {
                                                $imgPath = 'products/' . $imgPath;
                                            }
                                            $imgUrl = str_starts_with((string) $product->img, 'http')
                                                ? (string) $product->img
                                                : asset('storage/' . $imgPath);
                                        @endphp
                                        <img src="{{ $imgUrl }}" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='{{ asset('front/assets/images/emptyproducts.png') }}';">
                                    @else
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                            <i class="bi bi-image fs-1"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="product-body">
                                    <h3 class="product-name line-clamp-2">{{ $product->name }}</h3>
                                    <p class="product-price mb-0">
                                        {{ number_format((float) $product->price, 2) }}
                                        {{ app()->getLocale() == 'ar' ? 'ر.س' : 'SAR' }}
                                    </p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="empty-wrap mt-4">
                    <div class="mb-3">
                        <img src="{{ asset('front/assets/images/emptyproducts.png') }}" alt="Empty Products" class="img-fluid empty-img" />
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('vendor/products/create') }}" class="hp-btn-gradient">
                            <i class="bi bi-plus-lg"></i>
                            {{ __('nav.add_product') ?? 'Add Product' }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </main>
@endsection
