```blade
@extends('layouts.front.home')

@section('title')
    <title>{{ __('providers.categories') ?? 'Vendor Categories' }} - Vendor | Hema</title>
@endsection

@section('css')
<style>
    .vendor-categories {
        --vc-bg: #f5f6f8;
        --vc-card: #ffffff;
        --vc-border: #e7eaf0;
        --vc-title: #0f2f7f;
        --vc-text: #1f2937;
        --vc-muted: #6b7280;
        --vc-primary: #0f4bbf;
        --vc-accent: #0ec6a0;
        --vc-soft: #eef5ff;
        --vc-soft-2: #f4fbf9;
        max-width: 95%;
        margin: 12px auto 0;
        background: var(--vc-bg);
        padding: 8px 0 24px;
        font-family: "Poppins", "Tajawal", system-ui, -apple-system, "Segoe UI", Arial, sans-serif;
    }

    .vendor-categories * {
        font-family: inherit;
    }

    .vc-card {
        background: var(--vc-card);
        border: 1px solid var(--vc-border);
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.04);
    }

    .vc-breadcrumb {
        font-size: 13px;
        margin-bottom: 12px;
    }

    .vc-breadcrumb a {
        text-decoration: none;
        color: #6b7280;
    }

    .vc-breadcrumb .active {
        color: var(--vc-primary);
        font-weight: 700;
    }

    .vc-hero {
        padding: 22px;
        margin-bottom: 16px;
    }

    .vc-title {
        margin: 0 0 6px;
        color: var(--vc-title);
        font-size: 34px;
        line-height: 1.08;
        font-weight: 800;
        letter-spacing: -0.01em;
    }

    .vc-subtitle {
        margin: 0;
        color: #475569;
        font-size: 16px;
        line-height: 1.55;
        max-width: 760px;
    }

    .vc-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .vc-btn-primary,
    .vc-btn-outline {
        border-radius: 10px;
        font-weight: 700;
        padding: 10px 16px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all .2s ease;
        min-height: 44px;
    }

    .vc-btn-primary {
        border: 0;
        color: #fff;
        background: linear-gradient(90deg, var(--vc-primary) 0%, var(--vc-accent) 100%);
    }

    .vc-btn-primary:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(15, 75, 191, .14);
    }

    .vc-btn-outline {
        border: 1px solid #cbd5e1;
        color: #1e3a8a;
        background: #fff;
    }

    .vc-btn-outline:hover {
        color: #1e3a8a;
        background: var(--vc-soft);
        transform: translateY(-1px);
    }

    .vc-stat {
        padding: 16px 18px;
        height: 100%;
        transition: all .2s ease;
    }

    .vc-stat:hover {
        border-color: #93c5fd;
        box-shadow: 0 4px 12px rgba(15, 75, 191, .08);
        transform: translateY(-1px);
    }

    .vc-stat-label {
        margin: 0;
        color: var(--vc-muted);
        font-size: 13px;
        font-weight: 500;
    }

    .vc-stat-value {
        margin: 8px 0 0;
        color: var(--vc-text);
        font-size: 40px;
        line-height: 1;
        font-weight: 800;
    }

    .vc-panel-head {
        border-bottom: 1px solid var(--vc-border);
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .vc-panel-title {
        margin: 0;
        color: #0f172a;
        font-size: 20px;
        font-weight: 700;
    }

    .vc-panel-subtitle {
        margin: 4px 0 0;
        color: var(--vc-muted);
        font-size: 13px;
    }

    .vc-body {
        padding: 18px;
    }

    .vc-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 14px;
        align-items: end;
    }

    .vc-field label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 8px;
    }

    .vc-field .form-control {
        min-height: 46px;
        border-radius: 10px;
        border-color: #d5deeb;
        box-shadow: none;
        color: #334155;
        font-weight: 600;
    }

    .vc-field .form-control:focus {
        border-color: rgba(15, 75, 191, .45);
        box-shadow: 0 0 0 .18rem rgba(15, 75, 191, .08);
    }

    .vc-category {
        display: grid;
        grid-template-columns: auto 1fr auto;
        align-items: center;
        gap: 14px;
        padding: 14px 0;
    }

    .vc-category + .vc-category {
        border-top: 1px solid #edf2f7;
    }

    .vc-category-img {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        object-fit: cover;
        border: 1px solid #e5edf8;
        background: #f8fbff;
        flex-shrink: 0;
    }

    .vc-category-title {
        margin: 0 0 4px;
        font-size: 16px;
        font-weight: 700;
        color: #111827;
    }

    .vc-category-meta {
        margin: 0;
        color: #64748b;
        font-size: 13px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
    }

    .vc-chip {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 700;
        line-height: 1;
        white-space: nowrap;
    }

    .vc-chip-primary {
        background: #eaf2ff;
        color: #1d4ed8;
    }

    .vc-chip-success {
        background: #dcfce7;
        color: #166534;
    }

    .vc-category-arrow {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: var(--vc-soft);
        color: var(--vc-primary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .vc-empty {
        text-align: center;
        padding: 38px 20px;
        color: #64748b;
    }

    .vc-empty i {
        font-size: 38px;
        color: #94a3b8;
        margin-bottom: 10px;
        display: inline-block;
    }

    .vc-empty-title {
        margin: 0 0 5px;
        color: #0f172a;
        font-size: 17px;
        font-weight: 700;
    }

    .vc-empty-text {
        margin: 0;
        color: #64748b;
        font-size: 14px;
    }

    .vc-pagination .pagination {
        justify-content: center;
    }

    .vc-pagination .page-link {
        border-radius: 10px;
        margin: 0 4px;
        color: var(--vc-primary);
        font-weight: 700;
        box-shadow: none;
    }

    .vc-pagination .page-item.active .page-link {
        background: var(--vc-primary);
        border-color: var(--vc-primary);
        color: #fff;
    }

    @media (max-width: 992px) {
        .vendor-categories {
            max-width: 100%;
            padding: 8px 12px 24px;
        }

        .vc-title {
            font-size: 28px;
        }

        .vc-subtitle {
            font-size: 15px;
        }

        .vc-stat-value {
            font-size: 32px;
        }

        .vc-panel-title {
            font-size: 18px;
        }

        .vc-form-grid {
            grid-template-columns: 1fr;
        }

        .vc-category {
            grid-template-columns: auto 1fr;
        }

        .vc-category-arrow {
            display: none;
        }
    }

    @media (max-width: 576px) {
        .vc-hero {
            padding: 18px;
        }

        .vc-title {
            font-size: 24px;
        }

        .vc-actions {
            width: 100%;
        }

        .vc-btn-primary,
        .vc-btn-outline {
            width: 100%;
        }

        .vc-panel-head {
            flex-direction: column;
            align-items: flex-start;
        }

        .vc-category-img {
            width: 50px;
            height: 50px;
            border-radius: 12px;
        }
    }
</style>
@endsection

@section('content')
@php
    $isAr = app()->getLocale() === 'ar';
    $categoriesCount = isset($categories)
        ? (method_exists($categories, 'total') ? $categories->total() : $categories->count())
        : 0;

    $productsCount = 0;
    if (isset($categories)) {
        foreach ($categories as $category) {
            $productsCount += $category->products->count();
        }
    }
@endphp

<main class="vendor-categories">
    @include('flash::message')

    <nav class="vc-breadcrumb">
        <a href="{{ route('vendor/dashboard') }}">{{ $isAr ? 'الرئيسية' : 'Home' }}</a>
        <i class="bi bi-chevron-{{ $isAr ? 'left' : 'right' }}"></i>
        <span class="active">{{ __('providers.categories') ?? ($isAr ? 'التصنيفات' : 'Vendor Categories') }}</span>
    </nav>

    @if ($errors->any())
        <div class="vc-card mb-4">
            <div class="vc-body">
                <ul class="mb-0" dir="ltr">
                    @foreach ($errors->all() as $error)
                        <li class="text-danger fw-semibold small">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <section class="vc-card vc-hero">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h3 class="vc-title">
                    {{ __('providers.categories') ?? ($isAr ? 'التصنيفات' : 'Vendor Categories') }}
                </h3>

                <p class="vc-subtitle">
                    {{ __('providers.categories_desc') ?? ($isAr ? 'نظّم منتجاتك داخل تصنيفات واضحة ليسهل على العملاء الوصول إليها وإدارتها.' : 'Organize your products into clear categories so customers can find them faster and you can manage them easier.') }}
                </p>
            </div>

            <div class="vc-actions">
                <a href="{{ route('vendor/dashboard') }}" class="vc-btn-outline">
                    <i class="bi bi-grid-1x2-fill"></i>
                    {{ __('nav.dashboard') ?? ($isAr ? 'لوحة التحكم' : 'Dashboard') }}
                </a>
            </div>
        </div>
    </section>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
            <div class="vc-card vc-stat">
                <p class="vc-stat-label">{{ $isAr ? 'إجمالي التصنيفات' : 'Total Categories' }}</p>
                <h4 class="vc-stat-value">{{ number_format($categoriesCount) }}</h4>
            </div>
        </div>

        <div class="col-6 col-md-4">
            <div class="vc-card vc-stat">
                <p class="vc-stat-label">{{ $isAr ? 'المنتجات المرتبطة' : 'Linked Products' }}</p>
                <h4 class="vc-stat-value">{{ number_format($productsCount) }}</h4>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="vc-card vc-stat">
                <p class="vc-stat-label">{{ $isAr ? 'آخر تحديث' : 'Latest Update' }}</p>
                <h4 class="vc-stat-value" style="font-size: 24px;">
                    @if(isset($categories) && $categories->count())
                        {{ optional($categories->first()->updated_at ?? $categories->first()->created_at)->format('Y-m-d') }}
                    @else
                        —
                    @endif
                </h4>
            </div>
        </div>
    </div>

    <div class="vc-card mb-4">
        <div class="vc-panel-head">
            <div>
                <h5 class="vc-panel-title">
                    {{ __('providers.add_category') ?? ($isAr ? 'إضافة تصنيف جديد' : 'Add New Category') }}
                </h5>
                <p class="vc-panel-subtitle">
                    {{ __('providers.add_category_desc') ?? ($isAr ? 'أضف تصنيفاً جديداً مع صورة اختيارية.' : 'Add a new category with an optional image.') }}
                </p>
            </div>
        </div>

        <div class="vc-body">
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

                <div>
                    <button class="vc-btn-primary border-0" type="submit">
                        <i class="bi bi-plus-lg"></i>
                        {{ __('providers.add') ?? ($isAr ? 'إضافة' : 'Add') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="vc-card">
        <div class="vc-panel-head">
            <div>
                <h5 class="vc-panel-title">
                    {{ __('providers.all_categories') ?? ($isAr ? 'جميع التصنيفات' : 'All Categories') }}
                </h5>
                <p class="vc-panel-subtitle">
                    {{ __('providers.all_categories_desc') ?? ($isAr ? 'التصنيفات المسجلة والمنتجات المرتبطة بكل منها.' : 'Registered categories and the products linked to each one.') }}
                </p>
            </div>

            <span class="vc-chip vc-chip-primary">
                <i class="bi bi-collection"></i>
                {{ number_format($categoriesCount) }}
                {{ __('providers.categories') ?? ($isAr ? 'تصنيف' : 'Categories') }}
            </span>
        </div>

        <div class="vc-body">
            @forelse($categories as $category)
                <article class="vc-category">
                    <img
                        src="{{ !empty($category->img) ? asset(ltrim($category->img,'/')) : asset('front/assets/images/emptyproducts.png') }}"
                        class="vc-category-img"
                        alt="{{ $category->name ?? 'category' }}"
                        onerror="this.onerror=null;this.src='{{ asset('front/assets/images/emptyproducts.png') }}'"
                    >

                    <div>
                        <h6 class="vc-category-title">{{ $category->name }}</h6>

                        <p class="vc-category-meta">
                            <span>
                                <i class="bi bi-box-seam"></i>
                                {{ $category->products->count() }}
                                {{ __('providers.products_count') ?? __('products.products') }}
                            </span>

                            <span class="vc-chip vc-chip-success">
                                <i class="bi bi-check2-circle"></i>
                                {{ $isAr ? 'نشط' : 'Active' }}
                            </span>
                        </p>
                    </div>

                    <div class="vc-category-arrow">
                        <i class="bi bi-chevron-{{ $isAr ? 'left' : 'right' }}"></i>
                    </div>
                </article>
            @empty
                <div class="vc-empty">
                    <i class="bi bi-folder-plus"></i>
                    <h5 class="vc-empty-title">
                        {{ __('providers.no_categories') ?? ($isAr ? 'لا توجد تصنيفات' : 'No Categories Yet') }}
                    </h5>
                    <p class="vc-empty-text">
                        {{ __('providers.no_categories_desc') ?? ($isAr ? 'أضف تصنيفاً جديداً باستخدام النموذج أعلاه.' : 'Add your first category using the form above.') }}
                    </p>
                </div>
            @endforelse

            @if(isset($categories) && method_exists($categories, 'hasPages') && $categories->hasPages())
                <div class="vc-pagination mt-4">
                    {{ $categories->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</main>
@endsection
```
