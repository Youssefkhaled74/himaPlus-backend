@extends('layouts.front.home')
@section('title')<title>Vendor Categories</title>@endsection

@section('css')
<style>
    .vc-page {
        max-width: 95%;
        margin: 12px auto 0;
        background: #f5f6f8;
        padding: 8px 0 24px;
        min-height: 70vh;
    }
    .vc-header {
        padding: 18px 0;
    }
    .vc-header h3 {
        margin: 0 0 4px;
        color: #0f2f7f;
        font-size: 26px;
        font-weight: 700;
    }
    .vc-header p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }
    .vc-card {
        background: #fff;
        border: 1px solid #e7eaf0;
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(15,23,42,0.04);
    }
    .vc-card .vc-card-head {
        padding: 16px 20px 0;
    }
    .vc-card .vc-card-head__eyebrow {
        color: #6b7280;
        font-size: 13px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .vc-card .vc-card-head__title {
        color: #0f2f7f;
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 2px;
    }
    .vc-card .vc-card-head__text {
        color: #6b7280;
        font-size: 13px;
        margin: 0 0 12px;
    }
    .vc-card .card-body {
        padding: 20px;
    }
    .vc-table {
        width: 100%;
        border-collapse: collapse;
    }
    .vc-table th {
        text-align: center;
        padding: 12px 10px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: #6b7280;
        border-bottom: 2px solid #e7eaf0;
        background: #f9fafb;
    }
    .vc-table td {
        text-align: center;
        padding: 14px 10px;
        font-size: 14px;
        border-bottom: 1px solid #edf2f7;
        vertical-align: middle;
    }
    .vc-table tr:hover td {
        background: #f8fafd;
    }
    .vc-toggle-wrap {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .vc-toggle-wrap .form-check-input {
        width: 2.45rem;
        height: 1.35rem;
        cursor: pointer;
    }
    .vc-toggle-wrap .status-text {
        min-width: 62px;
        font-weight: 700;
        font-size: 0.82rem;
    }
    .vc-empty {
        text-align: center;
        padding: 50px 20px;
    }
    .vc-empty__icon {
        font-size: 48px;
        color: #c5ccd6;
        margin-bottom: 12px;
    }
    .vc-empty__title {
        font-size: 17px;
        font-weight: 600;
        color: #1f2b45;
        margin-bottom: 4px;
    }
    .vc-empty__text {
        color: #6b7280;
        font-size: 14px;
    }
</style>
@endsection

@section('content')
<main class="container vc-page">
    @include('flash::message')
    @if ($errors->any())
        <div class="vc-card mb-4">
            <div class="card-body">
                <ul class="mb-0" dir="ltr">
                    @foreach ($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="vc-header">
        <h3>{{ __('providers.categories') ?? 'التصنيفات' }}</h3>
        <p>{{ __('providers.categories_desc') ?? 'إدارة تصنيفات المنتجات الخاصة بك' }}</p>
    </div>

    <div class="vc-card mb-4">
        <div class="vc-card-head">
            <span class="vc-card-head__eyebrow">{{ __('providers.add_new') ?? 'إضافة جديد' }}</span>
            <h5 class="vc-card-head__title">{{ __('providers.add_category') ?? 'إضافة تصنيف جديد' }}</h5>
            <p class="vc-card-head__text">{{ __('providers.add_category_desc') ?? 'أضف تصنيفاً جديداً مع صورة اختيارية' }}</p>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('vendor/categories/store') }}" enctype="multipart/form-data" class="row g-3">
                @csrf
                <div class="col-md-5">
                    <input type="text" name="name" class="form-control" placeholder="{{ __('providers.category_name') ?? 'اسم التصنيف' }}" required>
                </div>
                <div class="col-md-5">
                    <input type="file" name="img" class="form-control" accept="image/*">
                </div>
                <div class="col-md-2 d-grid">
                    <button class="btn btn-primary">{{ __('providers.add') ?? 'إضافة' }}</button>
                </div>
            </form>
        </div>
    </div>

    <div class="vc-card">
        <div class="vc-card-head">
            <span class="vc-card-head__eyebrow">{{ __('providers.categories') ?? 'التصنيفات' }}</span>
            <h5 class="vc-card-head__title">{{ __('providers.all_categories') ?? 'جميع التصنيفات' }}</h5>
            <p class="vc-card-head__text">{{ __('providers.all_categories_desc') ?? 'التصنيفات المسجلة والمنتجات المرتبطة بكل منها' }}</p>
        </div>
        <div class="card-body">
            @forelse($categories as $category)
                <div class="d-flex align-items-center justify-content-between py-3 border-bottom">
                    <div class="d-flex align-items-center gap-3">
                        @if(!empty($category->img))
                            <img src="{{ asset(ltrim($category->img,'/')) }}" style="width:48px;height:48px;border-radius:10px;object-fit:cover;" alt="cat">
                        @else
                            <div style="width:48px;height:48px;border-radius:10px;background:#eef2f7;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-folder text-muted"></i>
                            </div>
                        @endif
                        <div>
                            <div class="fw-semibold" style="color:#0f2f7f;">{{ $category->name }}</div>
                            <small class="text-muted">{{ $category->products->count() }} {{ __('providers.products_count') ?? 'منتج' }}</small>
                        </div>
                    </div>
                    </div>
                </div>
            @empty
                <div class="vc-empty">
                    <div class="vc-empty__icon"><i class="bi bi-folder-plus"></i></div>
                    <h5 class="vc-empty__title">{{ __('providers.no_categories') ?? 'لا توجد تصنيفات' }}</h5>
                    <p class="vc-empty__text">{{ __('providers.no_categories_desc') ?? 'أضف تصنيفاً جديداً باستخدام النموذج أعلاه' }}</p>
                </div>
            @endforelse

            @if(isset($categories) && method_exists($categories, 'hasPages') && $categories->hasPages())
                <nav class="mt-4">
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
                                <a class="page-link" href="{{ $categories->url($i) }}" @if ($i == $categories->currentPage()) style="font-weight:bold;" @endif>{{ $i }}</a>
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
        </div>
    </div>
</main>
@endsection
