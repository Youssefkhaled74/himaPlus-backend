@extends('layouts.front.home')

@section('title')
    <title>{{ __('nav.view_products') ?? 'My Products' }} - Vendor | HemaPulse</title>
@endsection

@section('css')
    <style>
        /* ===== Font (match UI) ===== */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');

        .hp-main,
        .hp-main *{
            font-family: "Poppins", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ===== Page background like UI ===== */
        .hp-main{
            background: #f7f9fc;
        }

        /* ===== HERO (full width - no container) ===== */
        .vendor-hero{
            position: relative;
            height: 260px;
            width: 100%;
            overflow: hidden;
            margin: 0;
            padding: 0;
        }
        .vendor-hero .hero-bg{
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .vendor-hero::before{
            content:"";
            position:absolute;
            inset:0;
            background: rgba(0,0,0,.42);
            z-index: 1;
        }
        .vendor-hero .hero-content{
            position: relative;
            z-index: 2;
            height: 100%;
            display:flex;
            align-items:center;
            justify-content:center;
            text-align:center;
            padding: 0 16px;
            color:#fff;
        }
        .vendor-hero .hero-title{
            font-size: 46px;
            font-weight: 800;
            letter-spacing: .2px;
            margin: 0 0 10px 0;
        }
        .vendor-hero .hero-subtitle{
            max-width: 860px;
            margin: 0 auto;
            font-size: 14px;
            opacity: .92;
            line-height: 1.7;
        }

        /* ===== Container spacing (remove big gap) ===== */
        .vendor-products-wrap{
            max-width: 95%;
            padding-top: 24px;
            padding-bottom: 40px;
        }

        /* ===== Breadcrumb (keep but lighter) ===== */
        .hp-breadcrumb{
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 10px;
        }
        .hp-breadcrumb a{
            color: #0d6efd;
            text-decoration: none;
        }

        /* ===== Page title (closer to UI) ===== */
        .hp-page-title{
            font-size: 42px;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
        }
        .hp-page-subtitle{
            color: #64748b;
            margin-top: 10px;
            margin-bottom: 0;
            font-size: 15px;
        }

        /* ===== Section title row (Our Products) ===== */
        .hp-section-row{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap: 16px;
            margin-top: 14px;
            margin-bottom: 18px;
        }
        .hp-section-title{
            font-size: 22px;
            font-weight: 700;
            color: #0b3a82;
            margin: 0;
        }

        /* ===== Search bar (match UI) ===== */
        .hp-search{
            position: relative;
            width: 100%;
            max-width: 440px;
        }
        .hp-search .hp-search-icon{
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: #9aa4b2;
            font-size: 16px;
        }
        html[dir="rtl"] .hp-search .hp-search-icon{ right: 14px; }
        html:not([dir="rtl"]) .hp-search .hp-search-icon{ left: 14px; }

        .hp-search input{
            height: 44px;
            border-radius: 10px;
            border: 1px solid #e6ecf5;
            background: #fff;
            padding-inline: 40px 14px;
            font-size: 14px;
            box-shadow: 0 6px 16px rgba(15, 23, 42, .04);
        }
        .hp-search input::placeholder{ color: #a8b2bf; }
        .hp-search input:focus{
            border-color: rgba(13,110,253,.35);
            box-shadow: 0 0 0 .2rem rgba(13,110,253,.10);
        }

        /* ===== Buttons ===== */
        .btn-hp{
            height: 44px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            justify-content:center;
            gap: 10px;
            padding: 0 18px;
            border: 0;
            white-space: nowrap;
        }

        .btn-hp-outline{
            background: #fff;
            border: 1px solid #e6ecf5 !important;
            color: #0f172a;
            box-shadow: 0 6px 16px rgba(15, 23, 42, .04);
        }
        .btn-hp-outline:hover{
            background: #f8fbff;
            color: #0f172a;
        }

        /* ✅ Add Product button like UI (gradient) */
        .hp-btn-gradient{
            height: 44px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 0 18px;
            border: 0;
            color: #fff !important;
            background: linear-gradient(90deg,#0b3a82 0%, #0e5bd8 55%, #10b981 120%);
            box-shadow: 0 12px 26px rgba(14,91,216,.18);
            transition: transform .15s ease, filter .15s ease, box-shadow .15s ease;
            text-decoration: none;
            white-space: nowrap;
        }
        .hp-btn-gradient:hover{
            filter: brightness(.98);
            transform: translateY(-1px);
            box-shadow: 0 16px 34px rgba(14,91,216,.22);
            color: #fff !important;
        }
        .hp-btn-gradient:active{ transform: translateY(0); }

        /* ===== Product card ===== */
        .product-card{
            border: 1px solid #eef0f3;
            border-radius: 14px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0,0,0,.05);
            transition: transform .15s ease, box-shadow .15s ease;
            height: 100%;
        }
        .product-card:hover{
            transform: translateY(-2px);
            box-shadow: 0 16px 40px rgba(0,0,0,.08);
        }

        .product-thumb{
            position: relative;
            height: 190px;
            background: #f3f4f6;
            overflow: hidden;
            width: 329px;
        }
        .product-thumb img{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-badge{
            position: absolute;
            top: 12px;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }
        html[dir="rtl"] .product-badge{ right: 12px; }
        html:not([dir="rtl"]) .product-badge{ left: 12px; }

        .badge-active{ background: #dcfce7; color: #166534; }
        .badge-inactive{ background: #fee2e2; color: #991b1b; }

        .product-body{ padding: 14px 14px 12px; }
        .product-name{
            font-size: 14px;
            font-weight: 700;
            color: #111827;
            margin: 0;
            line-height: 1.35;
        }
        .line-clamp-2{
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .product-meta{ font-size: 12px; color: #6b7280; margin-top: 6px; }
        .product-price{ font-size: 16px; font-weight: 800; color: #111827; }
        .product-stock{ font-size: 12px; color: #6b7280; }

        .rating{
            font-size: 13px;
            color: #4b5563;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }
        .rating i{ color: #f59e0b; }

        .product-actions{
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }
        .product-actions .btn{
            border-radius: 10px;
            font-weight: 700;
            font-size: 12px;
            padding: 8px 10px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-danger-soft{
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #be123c;
        }
        .btn-danger-soft:hover{
            background: #ffe4e6;
            color: #9f1239;
        }

        /* ===== Empty state ===== */
        .empty-wrap{
            border: 1px solid #eef0f3;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0,0,0,.05);
            padding: 44px 18px;
            text-align: center;
        }
        .empty-img{ max-height: 260px; width: auto; }

        .pagination .page-link{
            border-radius: 10px !important;
            margin: 0 4px;
        }
    </style>
@endsection

@section('content')
    <main class="hp-main">

        {{-- HERO Section --}}
        <section class="vendor-hero">
            <img
                src="{{ asset('front/assets/images/herosectionproducts.png') }}"
                alt="Products Hero"
                class="hero-bg"
            />
            <!-- <div class="hero-content">
                <div>
                    <h1 class="hero-title">{{ app()->getLocale() == 'ar' ? 'المنتجات' : 'Products' }}</h1>
                    <p class="hero-subtitle">
                        {{ app()->getLocale() == 'ar'
                            ? 'اعثر على أجهزة ومستلزمات طبية عالية الجودة من موردين موثوقين — قارن، اطلب عرض سعر، أو اشترِ بسهولة.'
                            : 'Find high-quality medical devices, consumables, and equipment from verified suppliers — compare, request quotations, or shop directly with ease.' }}
                    </p>
                </div>
            </div> -->
        </section>

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

            {{-- Breadcrumb --}}
            <div class="hp-breadcrumb">
                <a href="{{ route('vendor/dashboard') }}">{{ __('nav.dashboard') ?? 'Dashboard' }}</a>
                <span class="mx-2">/</span>
                <span class="text-dark">{{ __('nav.view_products') ?? 'View Products' }}</span>
            </div>

            {{-- Title --}}
            <div class="mb-4">
                <h1 class="hp-page-title">{{ __('nav.view_products') ?? 'View Products' }}</h1>
                <p class="hp-page-subtitle">
                    {{ app()->getLocale() == 'ar'
                        ? 'اعرض منتجاتك وأضف منتجات جديدة لاستقبال الطلبات.'
                        : 'Manage your products and add new items to receive requests.' }}
                </p>
            </div>

            {{-- Our Products + Search + Add --}}
            <div class="hp-section-row">
                <h2 class="hp-section-title">{{ app()->getLocale() == 'ar' ? 'منتجاتنا' : 'Our Products' }}</h2>

                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <form method="GET" action="{{ route('vendor/products') }}" class="d-flex align-items-center gap-2">
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
                        <button type="submit" class="btn btn-hp btn-hp-outline">
                            {{ app()->getLocale() == 'ar' ? 'بحث' : 'Search' }}
                        </button>
                    </form>

                    {{-- ✅ UI-like Add Product button --}}
                    <a href="{{ route('vendor/products/create') }}" class="hp-btn-gradient">
                        <i class="bi bi-plus-lg"></i>
                        {{ __('nav.add_product') ?? 'Add Product' }}
                    </a>
                </div>
            </div>

            {{-- Content --}}
            @if(isset($products) && $products->count() > 0)

                <div class="row g-4">
                    @foreach($products as $product)
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                            <div class="product-card">
                                <div class="product-thumb">
                                    @if(!empty($product->img))
                                        <img src="{{ asset('storage/' . $product->img) }}" alt="{{ $product->name }}">
                                    @else
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                            <i class="bi bi-image fs-1"></i>
                                        </div>
                                    @endif

                                    @if($product->is_activate)
                                        <span class="product-badge badge-active">
                                            {{ app()->getLocale() == 'ar' ? 'مفعل' : 'Active' }}
                                        </span>
                                    @else
                                        <span class="product-badge badge-inactive">
                                            {{ app()->getLocale() == 'ar' ? 'معطل' : 'Inactive' }}
                                        </span>
                                    @endif
                                </div>

                                <div class="product-body">
                                    <div class="d-flex align-items-start justify-content-between gap-2">
                                        <h3 class="product-name line-clamp-2">{{ $product->name }}</h3>

                                        <div class="rating">
                                            <i class="bi bi-star-fill"></i>
                                            <span>{{ $product->ratings_avg_rating ? number_format($product->ratings_avg_rating, 1) : '—' }}</span>
                                        </div>
                                    </div>

                                    <div class="product-meta">
                                        {{ $product->category->name ?? (app()->getLocale() == 'ar' ? 'بدون فئة' : 'No category') }}
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between mt-3">
                                        <div class="product-price">
                                            {{ number_format((float) $product->price, 2) }}
                                            <small class="fw-semibold text-muted">{{ app()->getLocale() == 'ar' ? 'ر.س' : 'SAR' }}</small>
                                        </div>
                                        <div class="product-stock">
                                            {{ app()->getLocale() == 'ar' ? 'المخزون:' : 'Stock:' }}
                                            <span class="fw-bold text-dark">{{ (int) ($product->stock_quantity ?? 0) }}</span>
                                        </div>
                                    </div>

                                    <div class="product-actions">
                                        <a href="{{ route('vendor/products/show', $product->id) }}"
                                           class="btn btn-hp-outline w-100 justify-content-center"
                                           title="{{ app()->getLocale() == 'ar' ? 'عرض' : 'View' }}">
                                            <i class="bi bi-cart3"></i>
                                            {{ app()->getLocale() == 'ar' ? 'عرض' : 'View' }}
                                        </a>

                                        <a href="{{ route('vendor/products/edit', $product->id) }}"
                                           class="btn btn-hp-outline w-100 justify-content-center">
                                            <i class="bi bi-pencil"></i>
                                            {{ app()->getLocale() == 'ar' ? 'تعديل' : 'Edit' }}
                                        </a>

                                        <a href="{{ route('vendor/products/toggle', $product->id) }}"
                                           class="btn btn-hp-outline w-100 justify-content-center"
                                           title="{{ $product->is_activate ? (app()->getLocale() == 'ar' ? 'تعطيل' : 'Disable') : (app()->getLocale() == 'ar' ? 'تفعيل' : 'Activate') }}">
                                            <i class="bi bi-{{ $product->is_activate ? 'toggle-on' : 'toggle-off' }}"></i>
                                            {{ $product->is_activate ? (app()->getLocale() == 'ar' ? 'تعطيل' : 'Disable') : (app()->getLocale() == 'ar' ? 'تفعيل' : 'Activate') }}
                                        </a>

                                        <form action="{{ route('vendor/products/delete', $product->id) }}" method="POST"
                                              onsubmit="return confirm('{{ app()->getLocale() == 'ar' ? 'هل تريد حذف هذا المنتج؟' : 'Delete this product?' }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger-soft">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>

            @else

                <div class="empty-wrap mt-4">
                    <div class="mb-3">
                        <img
                            src="{{ asset('front/assets/images/emptyproducts.png') }}"
                            alt="Empty Products"
                            class="img-fluid empty-img"
                        />
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
