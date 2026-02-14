@extends('layouts.front.home')

@section('title')
<title>{{ __('nav.add_product') ?? 'Add Product' }} - Vendor | HemaPulse</title>
@endsection

@section('css')
<style>
    /* ===== Font like UI ===== */
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

    /* ===== UI Card (like modal) ===== */
    .hp-card {
        border: 1px solid #eef0f3;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 14px 40px rgba(2, 6, 23, .08);
        overflow: hidden;
    }

    .hp-card-header {
        padding: 18px 22px;
        border-bottom: 1px solid #eef0f3;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .hp-card-title {
        margin: 0;
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
    }

    /* ===== Inputs soft like UI ===== */
    .hp-input,
    .hp-select,
    .hp-textarea {
        border-radius: 10px !important;
        border: 1px solid #e6ecf5 !important;
        height: 44px;
        box-shadow: none !important;
    }

    .hp-textarea {
        height: auto;
        padding-top: 10px;
    }

    .hp-input:focus,
    .hp-select:focus,
    .hp-textarea:focus {
        border-color: rgba(13, 110, 253, .35) !important;
        box-shadow: 0 0 0 .2rem rgba(13, 110, 253, .10) !important;
    }

    /* ===== Upload box dashed ===== */
    .hp-upload {
        border: 2px dashed #e6ecf5;
        border-radius: 14px;
        padding: 18px;
        text-align: center;
        background: #fbfdff;
    }

    .hp-upload small {
        color: #94a3b8;
    }

    /* ===== Preview images ===== */
    .preview-image {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border-radius: 10px;
    }

    .image-gallery {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 12px;
    }

    .image-item {
        position: relative;
        display: inline-block;
    }

    .image-item .close-btn {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 999px;
        width: 26px;
        height: 26px;
        padding: 0;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* ===== Gradient button like UI ===== */
    .hp-btn-gradient {
        height: 46px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 0 26px;
        border: 0;
        color: #fff !important;
        background: linear-gradient(90deg, #0b3a82 0%, #0e5bd8 55%, #10b981 120%);
        box-shadow: 0 12px 26px rgba(14, 91, 216, .18);
        transition: transform .15s ease, filter .15s ease, box-shadow .15s ease;
        text-decoration: none;
        white-space: nowrap;
    }

    .hp-btn-gradient:hover {
        filter: brightness(.98);
        transform: translateY(-1px);
        box-shadow: 0 16px 34px rgba(14, 91, 216, .22);
        color: #fff !important;
    }

    /* Page spacing */
    .vendor-form-wrap {
        max-width: 900px;
        margin: 28px auto 60px;
    }
</style>
@endsection

@section('content')
<main class="hp-main">
    <div class="container" style="max-width: 95%; padding-top: 24px; padding-bottom: 40px;">

        @include('flash::message')

        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>{{ app()->getLocale() == 'ar' ? 'خطأ في التحقق:' : 'Validation Error:' }}</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <nav class="breadcrumb-custom mb-3">
            <a href="{{ route('vendor/dashboard') }}" class="text-decoration-none text-muted">
                {{ __('nav.dashboard') ?? 'Dashboard' }}
            </a>
            <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
            <a href="{{ route('vendor/products') }}" class="text-decoration-none text-muted">
                {{ __('nav.view_products') ?? 'Products' }}
            </a>
            <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
            <span class="text-primary fw-semibold">
                {{ __('nav.add_product') ?? 'Add Product' }}
            </span>
        </nav>

        <div class="vendor-form-wrap">
            <div class="hp-card">
                <div class="hp-card-header">
                    <h4 class="hp-card-title">{{ __('nav.add_product') ?? 'Add Product' }}</h4>
                    <a href="{{ route('vendor/products') }}" class="text-muted text-decoration-none">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>

                <div class="p-4 p-md-4">
                    <form method="POST" action="{{ route('vendor/products/store') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- Product Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">
                                {{ app()->getLocale() == 'ar' ? 'اسم المنتج' : 'Product Name' }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control hp-input @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name') }}" required
                                placeholder="{{ app()->getLocale() == 'ar' ? 'ادخل اسم المنتج' : 'Enter product name' }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Category --}}
                        <div class="mb-3">
                            <label for="category_id" class="form-label fw-semibold">
                                {{ app()->getLocale() == 'ar' ? 'الفئة' : 'Category' }}
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select hp-select @error('category_id') is-invalid @enderror"
                                id="category_id" name="category_id" required>
                                <option value="">{{ app()->getLocale() == 'ar' ? 'اختر الفئة' : 'Select category' }}</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">
                                {{ app()->getLocale() == 'ar' ? 'الوصف' : 'Description' }}
                                <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control hp-textarea @error('description') is-invalid @enderror"
                                id="description" name="description" rows="4" required
                                placeholder="{{ app()->getLocale() == 'ar' ? 'اكتب وصف المنتج' : 'Add product details, specifications, features' }}">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Price + Qty --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label fw-semibold">
                                    {{ app()->getLocale() == 'ar' ? 'السعر (للوحدة)' : 'Price (per unit)' }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" step="0.01"
                                        class="form-control hp-input @error('price') is-invalid @enderror"
                                        id="price" name="price" value="{{ old('price') }}" required
                                        placeholder="{{ app()->getLocale() == 'ar' ? 'ادخل السعر' : 'Enter price' }}">
                                    <span class="input-group-text">SAR</span>
                                </div>
                                @error('price')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="quantity" class="form-label fw-semibold">
                                    {{ app()->getLocale() == 'ar' ? 'المخزون / الكمية المتاحة' : 'Stock / Available Quantity' }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="number"
                                    class="form-control hp-input @error('quantity') is-invalid @enderror"
                                    id="quantity" name="quantity" value="{{ old('quantity') }}" required
                                    placeholder="{{ app()->getLocale() == 'ar' ? 'ادخل الكمية' : 'Enter available quantity' }}">
                                @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Upload Images --}}
                        <div class="mb-3">
                            <label for="images" class="form-label fw-semibold">
                                {{ app()->getLocale() == 'ar' ? 'رفع الصور' : 'Upload Images' }}
                                <span class="text-danger">*</span>
                            </label>

                            <div class="hp-upload">
                                <input type="file"
                                    class="form-control hp-input @error('images') is-invalid @enderror"
                                    id="images" name="images[]" multiple accept="image/*" required>
                                <div class="mt-2">
                                    <small>{{ app()->getLocale() == 'ar'
                                            ? 'رفع صور المنتج (JPG / PNG) - حد أقصى 5 صور'
                                            : 'Upload product images (JPG / PNG) - up to 5 images' }}</small>
                                </div>
                                @error('images')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <div class="image-gallery" id="imageGallery"></div>
                            </div>
                        </div>
                        {{-- ===== Specifications (Optional) ===== --}}
                        <div class="mb-3 mt-4">
                            <h6 class="fw-bold mb-3" style="color:#0f172a;">
                                {{ app()->getLocale() == 'ar' ? 'المواصفات' : 'Specifications' }}
                            </h6>

                            <div class="row">
                                {{-- Imaging Type --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        {{ app()->getLocale() == 'ar' ? 'نوع التصوير' : 'Imaging Type' }}
                                        <span class="text-muted">(option)</span>
                                    </label>
                                    <input type="text"
                                        name="imaging_type"
                                        value="{{ old('imaging_type') }}"
                                        class="form-control hp-input"
                                        placeholder="{{ app()->getLocale() == 'ar' ? 'ادخل نوع التصوير' : 'Enter imaging type' }}">
                                </div>

                                {{-- Production Date --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        {{ app()->getLocale() == 'ar' ? 'تاريخ الإنتاج (MFG Date)' : 'Production Date (MFG Date)' }}
                                        <span class="text-muted">(option)</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="date"
                                            name="mfg_date"
                                            value="{{ old('mfg_date') }}"
                                            class="form-control hp-input">
                                        <span class="input-group-text bg-white">
                                            <i class="bi bi-calendar"></i>
                                        </span>
                                    </div>
                                </div>

                                {{-- Expiry Date --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        {{ app()->getLocale() == 'ar' ? 'تاريخ الانتهاء (EXP Date)' : 'Expiry Date (EXP Date)' }}
                                        <span class="text-muted">(option)</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="date"
                                            name="exp_date"
                                            value="{{ old('exp_date') }}"
                                            class="form-control hp-input">
                                        <span class="input-group-text bg-white">
                                            <i class="bi bi-calendar"></i>
                                        </span>
                                    </div>
                                </div>

                                {{-- Weight --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        {{ app()->getLocale() == 'ar' ? 'الوزن' : 'Weight' }}
                                        <span class="text-muted">(option)</span>
                                    </label>
                                    <input type="text"
                                        name="weight"
                                        value="{{ old('weight') }}"
                                        class="form-control hp-input"
                                        placeholder="{{ app()->getLocale() == 'ar' ? 'ادخل الوزن' : 'Enter weight' }}">
                                </div>

                                {{-- Dimensions --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        {{ app()->getLocale() == 'ar' ? 'الأبعاد' : 'Dimensions' }}
                                        <span class="text-muted">(option)</span>
                                    </label>
                                    <input type="text"
                                        name="dimensions"
                                        value="{{ old('dimensions') }}"
                                        class="form-control hp-input"
                                        placeholder="{{ app()->getLocale() == 'ar' ? 'ادخل الأبعاد' : 'Enter dimensions' }}">
                                </div>

                                {{-- Warranty --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        {{ app()->getLocale() == 'ar' ? 'الضمان' : 'Warranty' }}
                                        <span class="text-muted">(option)</span>
                                    </label>
                                    <input type="text"
                                        name="warranty"
                                        value="{{ old('warranty') }}"
                                        class="form-control hp-input"
                                        placeholder="{{ app()->getLocale() == 'ar' ? 'مثال: سنة' : 'Ex: 1 Year' }}">
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="hp-btn-gradient px-5">
                                {{ app()->getLocale() == 'ar' ? 'حفظ المنتج' : 'Save Product' }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection

@section('scripts')
<script>
    // Image preview
    document.getElementById('images').addEventListener('change', function(e) {
        const gallery = document.getElementById('imageGallery');
        gallery.innerHTML = '';
        const files = Array.from(e.target.files);

        files.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(event) {
                const div = document.createElement('div');
                div.className = 'image-item';
                div.innerHTML = `
                        <img src="${event.target.result}" class="preview-image" alt="preview">
                        <button type="button" class="close-btn" onclick="removeImage(${index})">
                            <i class="bi bi-x"></i>
                        </button>
                    `;
                gallery.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    });

    function removeImage(index) {
        const input = document.getElementById('images');
        const dt = new DataTransfer();
        const {
            files
        } = input;

        for (let i = 0; i < files.length; i++) {
            if (index !== i) dt.items.add(files[i]);
        }

        input.files = dt.files;
        input.dispatchEvent(new Event('change', {
            bubbles: true
        }));
    }
</script>
@endsection