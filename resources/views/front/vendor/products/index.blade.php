@extends('layouts.front.home')

@section('title')
    <title>{{ __('nav.view_products') ?? 'Products' }} - Vendor | HemaPulse</title>
@endsection

@section('css')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');

        .hp-main,
        .hp-main * {
            font-family: "Poppins", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
        }

        .hp-main {
            background: #f7f8fa;
            padding-top: 0 !important;
            padding-bottom: 0;
        }

        .vendor-hero {
            min-height: 350px;
            background: linear-gradient(0deg, rgba(9, 16, 31, .58), rgba(9, 16, 31, .58)),
                url('{{ asset('front/assets/images/men-girls-are-surfing.png') }}') center/cover no-repeat;
            display: flex;
            align-items: center;
            text-align: center;
            color: #fff;
        }

        .vendor-hero__title {
            margin: 0;
            font-size: 52px;
            line-height: 1.1;
            font-weight: 700;
            letter-spacing: -.02em;
        }

        .vendor-hero__sub {
            margin: 18px auto 0;
            max-width: 840px;
            font-size: 18px;
            line-height: 1.5;
            color: rgba(255, 255, 255, .92);
        }

        .vendor-products {
            max-width: 1320px;
            margin: 0 auto;
            padding: 74px 12px 72px;
        }

        .vendor-products__bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 36px;
        }

        .vendor-products__title {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            color: #123C91;
        }

        .vendor-tools {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .vendor-search {
            position: relative;
            width: 420px;
        }

        .vendor-search i {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 16px;
            color: #b3bcc8;
        }

        [dir="rtl"] .vendor-search i {
            left: auto;
            right: 16px;
        }

        .vendor-search input {
            width: 100%;
            height: 50px;
            border: 1px solid #DCE4F0;
            border-radius: 12px;
            background: #fff;
            padding: 0 14px 0 44px;
            font-size: 16px;
            color: #1f2937;
            outline: none;
            box-shadow: none;
        }

        [dir="rtl"] .vendor-search input {
            padding: 0 44px 0 14px;
        }

        .vendor-search input::placeholder {
            color: #a8b2c1;
        }

        .btn-add-product {
            height: 50px;
            min-width: 186px;
            border: 0;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0 20px;
            font-size: 18px;
            font-weight: 600;
            color: #fff;
            text-decoration: none;
            background: linear-gradient(90deg, #133F9B 0%, #0DC79C 100%);
        }

        .btn-add-product:hover {
            color: #fff;
            filter: brightness(.98);
        }

        .product-grid .col {
            margin-bottom: 24px;
        }

        .product-card {
            display: block;
            text-decoration: none;
            border: 1px solid #E4E9F1;
            border-radius: 16px;
            background: #fff;
            overflow: hidden;
            height: 100%;
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(15, 23, 42, .08);
        }

        .product-thumb {
            width: 100%;
            height: 250px;
            background: #eff3f9;
        }

        .product-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .product-body {
            padding: 18px 16px 16px;
        }

        .product-name {
            margin: 0;
            font-size: 16px;
            line-height: 1.3;
            font-weight: 600;
            color: #1f2937;
        }

        .product-price {
            margin: 12px 0 0;
            font-size: 15px;
            font-weight: 700;
            color: #0A42A5;
        }

        .vendor-pagination {
            margin-top: 24px;
        }

        .vendor-pagination .pagination {
            justify-content: center;
            gap: 6px;
        }

        .vendor-pagination .page-link {
            min-width: 36px;
            height: 36px;
            border: 1px solid #dce6f5;
            border-radius: 8px !important;
            font-size: 14px;
            color: #173f8f;
            display: grid;
            place-items: center;
        }

        .vendor-pagination .page-item.active .page-link {
            border-color: transparent;
            background: linear-gradient(90deg, #133F9B 0%, #0DC79C 100%);
            color: #fff;
        }

        .empty-wrap {
            border: 1px solid #E4E9F1;
            border-radius: 18px;
            background: #fff;
            padding: 56px 24px;
            text-align: center;
        }

        .empty-wrap img {
            max-width: 300px;
            width: 100%;
            height: auto;
        }

        @media (max-width: 1399.98px) {
            .vendor-hero__title { font-size: 46px; }
            .vendor-hero__sub { font-size: 17px; }
            .vendor-products__title { font-size: 26px; }
            .product-name { font-size: 15px; }
            .product-price { font-size: 14px; }
        }

        @media (max-width: 991.98px) {
            .vendor-hero { min-height: 260px; }
            .vendor-hero__title { font-size: 34px; }
            .vendor-hero__sub { font-size: 15px; margin-top: 10px; }
            .vendor-products { padding: 36px 12px 48px; }
            .vendor-products__bar { flex-direction: column; align-items: stretch; margin-bottom: 24px; }
            .vendor-products__title { font-size: 24px; }
            .vendor-tools { flex-direction: column; align-items: stretch; }
            .vendor-search { width: 100%; }
            .btn-add-product { width: 100%; font-size: 16px; }
            .product-thumb { height: 220px; }
            .product-name { font-size: 15px; }
            .product-price { font-size: 14px; }
        }

        @media (max-width: 575.98px) {
            .vendor-hero__title { font-size: 28px; }
            .vendor-hero__sub { font-size: 14px; }
            .product-thumb { height: 200px; }
            .product-name { font-size: 14px; }
            .product-price { font-size: 13px; }
        }
    </style>
@endsection

@section('content')
    <main class="hp-main">
        <section class="vendor-hero">
            <div class="container">
                <h1 class="vendor-hero__title">{{ __('nav.products') ?? 'Products' }}</h1>
                <p class="vendor-hero__sub">
                    {{ __('products.products_desc') ?? 'Find high-quality medical devices, consumables, and equipment from verified suppliers - compare, request quotations, or shop directly with ease.' }}
                </p>
            </div>
        </section>

        <section class="vendor-products">
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

            <div class="vendor-products__bar">
                <h2 class="vendor-products__title">{{ __('products.products_heading') ?? 'Our Products' }}</h2>

                <div class="vendor-tools">
                    <form method="GET" action="{{ route('vendor/products') }}">
                        <div class="vendor-search">
                            <i class="bi bi-search"></i>
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search', $search ?? '') }}"
                                placeholder="Search..."
                            >
                        </div>
                    </form>

                    <a href="{{ route('vendor/products/create') }}" class="btn-add-product">
                        <i class="bi bi-plus-lg"></i>
                        {{ __('nav.add_product') ?? 'Add Product' }}
                    </a>
                </div>
            </div>

            @if (isset($products) && $products->count() > 0)
                <div class="row product-grid row-cols-1 row-cols-md-2 row-cols-xl-3">
                    @foreach($products as $product)
                        <div class="col">
                            <a href="{{ route('vendor/products/show', $product->id) }}" class="product-card">
                                <div class="product-thumb">
                                    @if(!empty($product->img))
                                        @php
                                            $imgPath = ltrim((string) $product->img, '/');
                                            if (!str_starts_with($imgPath, 'http') && !str_contains($imgPath, '/')) {
                                                $imgPath = 'products/' . $imgPath;
                                            }
                                            if (str_starts_with((string) $product->img, 'http')) {
                                                $imgUrl = (string) $product->img;
                                            } elseif (file_exists(storage_path('app/public/' . $imgPath))) {
                                                $imgUrl = asset('storage/' . $imgPath);
                                            } elseif (file_exists(public_path($imgPath))) {
                                                $imgUrl = asset($imgPath);
                                            } else {
                                                $imgUrl = asset('storage/' . $imgPath);
                                            }
                                        @endphp
                                        <img src="{{ $imgUrl }}" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='{{ asset('front/assets/images/emptyproducts.png') }}';">
                                    @else
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                            <i class="bi bi-image fs-1"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="product-body">
                                    <h3 class="product-name">{{ $product->name }}</h3>
                                    <p class="product-price">
                                        {{ number_format((float) $product->price, 2) }}
                                        SAR
                                    </p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="vendor-pagination">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="empty-wrap">
                    <img src="{{ asset('front/assets/images/emptyproducts.png') }}" alt="Empty Products" class="img-fluid mb-4" />
                    <div>
                        <a href="{{ route('vendor/products/create') }}" class="btn-add-product">
                            <i class="bi bi-plus-lg"></i>
                            {{ __('nav.add_product') ?? 'Add Product' }}
                        </a>
                    </div>
                </div>
            @endif
        </section>
    </main>
@endsection
