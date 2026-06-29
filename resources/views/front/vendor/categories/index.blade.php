```blade
@extends('layouts.front.home')

@section('title')
<title>{{ __('providers.categories') ?? 'Vendor Categories' }}</title>
@endsection

@section('css')
<style>
    .vc-page {
        --brand-primary: #0f4bbf;
        --brand-primary-dark: #0b3a94;
        --brand-accent: #10c7a5;
        --shell-bg: #f3f7fc;
        --card-bg: #ffffff;
        --card-border: #d8e3f0;
        --card-shadow: 0 18px 40px rgba(15, 75, 191, .08);
        --text-main: #10203a;
        --text-muted: #6d7d93;
        --soft-blue: #eef5ff;
        --soft-green: #ecfffb;
        --soft-slate: #f8fafc;

        max-width: 95%;
        margin: 16px auto 32px;
        padding: 0 10px;
        color: var(--text-main);
    }

    .vc-page a {
        text-decoration: none;
    }

    .vc-shell {
        background:
            radial-gradient(circle at top left, rgba(16, 199, 165, .10), transparent 26%),
            radial-gradient(circle at top right, rgba(15, 75, 191, .10), transparent 30%),
            var(--shell-bg);
        border: 1px solid rgba(216, 227, 240, .9);
        border-radius: 28px;
        padding: 18px;
        min-height: 70vh;
    }

    .vc-hero {
        background: linear-gradient(135deg, var(--brand-primary) 0%, #1565d8 52%, var(--brand-accent) 100%);
        border-radius: 24px;
        padding: 26px;
        color: #fff;
        position: relative;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        margin-bottom: 18px;
    }

    .vc-hero::before,
    .vc-hero::after {
        content: "";
        position: absolute;
        border-radius: 999px;
        background: rgba(255, 255, 255, .10);
    }

    .vc-hero::before {
        width: 220px;
        height: 220px;
        top: -120px;
        {{ app()->getLocale() === 'ar' ? 'left' : 'right' }}: -60px;
    }

    .vc-hero::after {
        width: 160px;
        height: 160px;
        bottom: -70px;
        {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}: -40px;
    }

    .vc-hero > * {
        position: relative;
        z-index: 1;
    }

    .vc-hero-title {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 900;
        letter-spacing: -.02em;
    }

    .vc-hero-text {
        margin: 8px 0 0;
        max-width: 680px;
        opacity: .92;
        line-height: 1.8;
        font-size: .95rem;
    }

    .vc-hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .vc-btn {
        border-radius: 999px;
        font-weight: 800;
        transition: all .18s ease;
        border: 1px solid transparent;
        padding: 10px 16px;
        font-size: .84rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        min-height: 42px;
    }

    .vc-btn-primary {
        background: linear-gradient(135deg, var(--brand-primary), var(--brand-accent));
        color: #fff;
        box-shadow: 0 12px 24px rgba(15, 75, 191, .16);
        border: 0;
    }

    .vc-btn-primary:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 16px 28px rgba(15, 75, 191, .18);
    }

    .vc-btn-outline {
        background: #fff;
        color: var(--brand-primary);
        border-color: rgba(15, 75, 191, .20);
    }

    .vc-btn-outline:hover {
        color: var(--brand-primary-dark);
        background: var(--soft-blue);
        transform: translateY(-1px);
    }

    .vc-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 22px;
        box-shadow: 0 10px 25px rgba(16, 32, 58, .05);
        overflow: hidden;
    }

    .vc-card + .vc-card {
        margin-top: 18px;
    }

    .vc-card-head {
        padding: 18px 20px;
        border-bottom: 1px solid #edf2f7;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 14px;
    }

    .vc-card-head__content {
        min-width: 0;
    }

    .vc-card-head__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: var(--brand-primary);
        background: var(--soft-blue);
        border: 1px solid rgba(15, 75, 191, .10);
        font-size: .74rem;
        font-weight: 900;
        border-radius: 999px;
        padding: 5px 10px;
        margin-bottom: 9px;
    }

    .vc-card-head__title {
        color: var(--text-main);
        font-size: 1rem;
        font-weight: 900;
        margin: 0;
    }

    .vc-card-head__text {
        color: var(--text-muted);
        font-size: .86rem;
        margin: 5px 0 0;
        line-height: 1.7;
    }

    .vc-card-body {
        padding: 18px 20px 20px;
    }

    .vc-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 14px;
        align-items: end;
    }

    .vc-field label {
        display: block;
        color: #334155;
        font-size: .82rem;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .vc-field .form-control {
        min-height: 46px;
        border-radius: 12px;
        border-color: #d5deeb;
        box-shadow: none;
        color: var(--text-main);
        font-weight: 600;
    }

    .vc-field .form-control:focus {
        border-color: rgba(15, 75, 191, .45);
        box-shadow: 0 0 0 .18rem rgba(15, 75, 191, .08);
    }

    .vc-list {
        display: grid;
        gap: 12px;
    }

    .vc-category-item {
        background: #fff;
        border: 1px solid #e5edf6;
        border-radius: 18px;
        padding: 14px;
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 14px;
        align-items: center;
        transition: all .18s ease;
    }

    .vc-category-item:hover {
        border-color: #cfe0ff;
        background: #f8fbff;
        transform: translateY(-1px);
        box-shadow: 0 10px 22px rgba(15, 23, 42, .05);
    }

    .vc-category-img {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        object-fit: cover;
        border: 1px solid #e5edf6;
        background: var(--soft-slate);
        flex-shrink: 0;
    }

    .vc-category-name {
        margin: 0;
        color: var(--text-main);
        font-size: .98rem;
        font-weight: 900;
    }

    .vc-category-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        margin-top: 6px;
        color: var(--text-muted);
        font-size: .82rem;
        font-weight: 700;
    }

    .vc-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 5px 10px;
        background: var(--soft-green);
        color: #047857;
        border: 1px solid #b8efe3;
        font-size: .74rem;
        font-weight: 900;
        white-space: nowrap;
    }

    .vc-item-icon {
        width: 38px;
        height: 38px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--soft-blue);
        color: var(--brand-primary);
        flex-shrink: 0;
    }

    .vc-empty {
        padding: 48px 20px;
        text-align: center;
    }

    .vc-empty__icon {
        width: 72px;
        height: 72px;
        margin: 0 auto 16px;
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--soft-blue);
        color: var(--brand-primary);
        font-size: 1.7rem;
    }

    .vc-empty__title {
        margin: 0;
        color: var(--text-main);
        font-size: 1.05rem;
        font-weight: 900;
    }

    .vc-empty__text {
        margin: 8px auto 0;
        max-width: 460px;
        color: var(--text-muted);
        line-height: 1.8;
        font-size: .88rem;
    }

    .vc-pagination {
        margin-top: 20px;
    }

    .vc-pagination .pagination {
        justify-content: center;
        gap: 6px;
    }

    .vc-pagination .page-link {
        border-radius: 10px !important;
        border: 1px solid #d8e3f0;
        color: var(--text-main);
        font-weight: 800;
        box-shadow: none;
    }

    .vc-pagination .page-item.active .page-link {
        background: var(--brand-primary);
        border-color: var(--brand-primary);
        color: #fff;
    }

    @media (max-width: 991.98px) {
        .vc-page {
            max-width: 100%;
            padding: 0 12px;
        }

        .vc-hero {
            padding: 22px;
        }

        .vc-hero-title {
            font-size: 1.45rem;
        }

        .vc-form-grid {
            grid-template-columns: 1fr;
        }

        .vc-card-head {
            flex-direction: column;
        }

        .vc-category-item {
            grid-template-columns: auto 1fr;
        }

        .vc-item-icon {
            display: none;
        }
    }

    @media (max-width: 575.98px) {
        .vc-shell {
            padding: 12px;
            border-radius: 22px;
        }

        .vc-hero {
            border-radius: 20px;
            padding: 18px;
        }

        .vc-hero-title {
            font-size: 1.25rem;
        }

        .vc-hero-text {
            font-size: .86rem;
        }

        .vc-card {
            border-radius: 18px;
        }

        .vc-card-head,
        .vc-card-body {
            padding-left: 14px;
            padding-right: 14px;
        }

        .vc-category-img {
            width: 52px;
            height: 52px;
            border-radius: 14px;
        }
    }
</style>
@endsection

@section('content')
@php
    $isAr = app()->getLocale() === 'ar';
@endphp

<main class="vc-page">
    @include('flash::message')

    <div class="vc-shell">
        @if ($errors->any())
            <div class="vc-card mb-3">
                <div class="vc-card-body">
                    <ul class="mb-0" dir="ltr">
                        @foreach ($errors->all() as $error)
                            <li class="text-danger fw-semibold small">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <section class="vc-hero">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                <div>
                    <h1 class="vc-hero-title">
                        {{ __('providers.categories') ?? ($isAr ? 'التصنيفات' : 'Vendor Categories') }}
                    </h1>

                    <p class="vc-hero-text">
                        {{ __('providers.categories_desc') ?? ($isAr ? 'إدارة تصنيفات المنتجات الخاصة بك وتنظيم منتجاتك بطريقة واضحة للعملاء.' : 'Manage your product categories and keep your catalog organized for customers.') }}
                    </p>
                </div>

                <div class="vc-hero-actions">
                    <a href="{{ route('vendor/dashboard') }}" class="vc-btn vc-btn-outline">
                        <i class="bi bi-arrow-{{ $isAr ? 'right' : 'left' }}"></i>
                        {{ __('nav.dashboard') ?? ($isAr ? 'لوحة التحكم' : 'Dashboard') }}
                    </a>
                </div>
            </div>
        </section>

        <section class="vc-card">
            <div class="vc-card-head">
                <div class="vc-card-head__content">
                    <span class="vc-card-head__eyebrow">
                        <i class="bi bi-plus-circle"></i>
                        {{ __('providers.add_new') ?? ($isAr ? 'إضافة جديد' : 'Add New') }}
                    </span>

                    <h5 class="vc-card-head__title">
                        {{ __('providers.add_category') ?? ($isAr ? 'إضافة تصنيف جديد' : 'Add New Category') }}
                    </h5>

                    <p class="vc-card-head__text">
                        {{ __('providers.add_category_desc') ?? ($isAr ? 'أضف تصنيفاً جديداً مع صورة اختيارية لتمييزه داخل منتجاتك.' : 'Add a new category with an optional image to organize your products.') }}
                    </p>
                </div>
            </div>

            <div class="vc-card-body">
                <form method="POST" action="{{ route('vendor/categories/store') }}" enctype="multipart/form-data" class="vc-form-grid">
                    @csrf

                    <div class="vc-field">
                        <label>{{ __('providers.category_name') ?? ($isAr ? 'اسم التصنيف' : 'Category Name') }}</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            placeholder="{{ __('providers.category_name') ?? ($isAr ? 'اسم التصنيف' : 'Category Name') }}"
                            required
                        >
                    </div>

                    <div class="vc-field">
                        <label>{{ $isAr ? 'صورة التصنيف' : 'Category Image' }}</label>
                        <input type="file" name="img" class="form-control" accept="image/*">
                    </div>

                    <div class="d-grid">
                        <button class="vc-btn vc-btn-primary" type="submit">
                            <i class="bi bi-plus-lg"></i>
                            {{ __('providers.add') ?? ($isAr ? 'إضافة' : 'Add') }}
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <section class="vc-card">
            <div class="vc-card-head">
                <div class="vc-card-head__content">
                    <span class="vc-card-head__eyebrow">
                        <i class="bi bi-folder2-open"></i>
                        {{ __('providers.categories') ?? ($isAr ? 'التصنيفات' : 'Categories') }}
                    </span>

                    <h5 class="vc-card-head__title">
                        {{ __('providers.all_categories') ?? ($isAr ? 'جميع التصنيفات' : 'All Categories') }}
                    </h5>

                    <p class="vc-card-head__text">
                        {{ __('providers.all_categories_desc') ?? ($isAr ? 'التصنيفات المسجلة والمنتجات المرتبطة بكل منها.' : 'Registered categories and the products linked to each one.') }}
                    </p>
                </div>

                @if(isset($categories))
                    <span class="vc-pill">
                        <i class="bi bi-collection"></i>
                        {{ method_exists($categories, 'total') ? $categories->total() : $categories->count() }}
                        {{ __('providers.categories') ?? ($isAr ? 'تصنيف' : 'Categories') }}
                    </span>
                @endif
            </div>

            <div class="vc-card-body">
                @if(isset($categories) && $categories->count())
                    <div class="vc-list">
                        @foreach($categories as $category)
                            <article class="vc-category-item">
                                <img
                                    src="{{ !empty($category->img) ? asset(ltrim($category->img,'/')) : asset('front/assets/images/emptyproducts.png') }}"
                                    class="vc-category-img"
                                    alt="{{ $category->name ?? 'category' }}"
                                    onerror="this.onerror=null;this.src='{{ asset('front/assets/images/emptyproducts.png') }}'"
                                >

                                <div>
                                    <h6 class="vc-category-name">{{ $category->name }}</h6>

                                    <div class="vc-category-meta">
                                        <span>
                                            <i class="bi bi-box-seam"></i>
                                            {{ $category->products->count() }}
                                            {{ __('providers.products_count') ?? __('products.products') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="vc-item-icon">
                                    <i class="bi bi-chevron-{{ $isAr ? 'left' : 'right' }}"></i>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    @if(isset($categories) && method_exists($categories, 'hasPages') && $categories->hasPages())
                        <nav class="vc-pagination">
                            <ul class="pagination flex-wrap justify-content-center align-items-center mb-0">
                                @if (!$categories->onFirstPage())
                                    <li class="page-item mt-1">
                                        <a class="page-link" href="{{ $categories->previousPageUrl() }}" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                @endif

                                @for ($i = 1; $i <= $categories->lastPage(); $i++)
                                    <li class="page-item mt-1 {{ $i == $categories->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $categories->url($i) }}" @if ($i == $categories->currentPage()) style="font-weight:bold;" @endif>
                                            {{ $i }}
                                        </a>
                                    </li>
                                @endfor

                                @if ($categories->hasMorePages())
                                    <li class="page-item mt-1">
                                        <a class="page-link" href="{{ $categories->nextPageUrl() }}" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    @endif
                @else
                    <div class="vc-empty">
                        <div class="vc-empty__icon">
                            <i class="bi bi-folder-plus"></i>
                        </div>

                        <h5 class="vc-empty__title">
                            {{ __('providers.no_categories') ?? ($isAr ? 'لا توجد تصنيفات' : 'No categories yet') }}
                        </h5>

                        <p class="vc-empty__text">
                            {{ __('providers.no_categories_desc') ?? ($isAr ? 'أضف تصنيفاً جديداً باستخدام النموذج أعلاه لتنظيم منتجاتك.' : 'Add your first category using the form above to organize your products.') }}
                        </p>
                    </div>
                @endif
            </div>
        </section>
    </div>
</main>
@endsection
```
