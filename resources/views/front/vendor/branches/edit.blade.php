@extends('layouts.front.home')

@section('title')
    <title>{{ $isAr ?? app()->getLocale() === 'ar' ? 'تعديل الفرع' : 'Edit Branch' }} - Vendor | Hema</title>
@endsection

@section('css')
<style>
    .vendor-branches,
    .vendor-branches *{font-family:"Poppins","Tajawal",system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;}
    :root{--vb-bg:#f5f6f8;--vb-card:#fff;--vb-border:#e8eaee;--vb-text:#1f2937;--vb-muted:#6b7280;--vb-primary:#0f4bbf;--vb-accent:#0ec6a0;}
    .vendor-branches{max-width:95%;margin:12px auto 0;background:var(--vb-bg);padding:8px 0 24px;}
    .vb-title{font-size:34px;font-weight:600;color:#0f2f7f;margin:0 0 14px;}
    .vb-card{background:var(--vb-card);border:1px solid var(--vb-border);border-radius:14px;box-shadow:0 6px 20px rgba(15,23,42,.04);overflow:hidden;margin-bottom:18px;}
    .vb-card-head{background:#f2f2f4;padding:16px 22px;border-bottom:1px solid var(--vb-border);}
    .vb-card-head h6{margin:0;font-size:18px;font-weight:600;color:#21242c;}
    .vb-body{padding:22px;}
    .vb-hero-subtitle{margin:6px 0 0;color:#475569;font-size:16px;line-height:1.55;}
    .vb-btn{border-radius:10px;font-weight:700;padding:10px 18px;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;gap:8px;transition:all .2s ease;min-height:44px;border:0;color:#fff;background:linear-gradient(90deg,var(--vb-primary),var(--vb-accent));}
    .vb-btn:hover{color:#fff;transform:translateY(-1px);box-shadow:0 8px 18px rgba(15,75,191,.14);}
    .vb-btn-outline{border:1px solid #cbd5e1;color:#1e3a8a;background:#fff;}
    .vb-btn-outline:hover{color:#1e3a8a;background:#eef5ff;transform:translateY(-1px);}
    .vb-field{margin-bottom:18px;}
    .vb-field label{display:block;font-size:14px;font-weight:700;color:#334155;margin-bottom:6px;}
    .vb-field .form-control,.vb-field .form-select{min-height:46px;border-radius:10px;border-color:#d5deeb;box-shadow:none;color:#334155;font-weight:500;}
    .vb-field .form-control:focus,.vb-field .form-select:focus{border-color:rgba(15,75,191,.45);box-shadow:0 0 0 .18rem rgba(15,75,191,.08);}
    .vb-field .form-check-input:checked{background-color:var(--vb-primary);border-color:var(--vb-primary);}
    .vb-form-grid{display:grid;grid-template-columns:1fr 1fr;gap:0 20px;}
    @media(max-width:768px){.vb-title{font-size:28px;}.vb-form-grid{grid-template-columns:1fr;}}
</style>
@endsection

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp

<main class="vendor-branches">
    @include('flash::message')

    <nav class="mb-3" style="font-size:13px;">
        <a href="{{ route('vendor/dashboard') }}" style="text-decoration:none;color:#6b7280;">{{ $isAr ? 'الرئيسية' : 'Home' }}</a>
        <i class="bi bi-chevron-{{ $isAr ? 'left' : 'right' }}" style="color:#94a3b8;"></i>
        <a href="{{ route('vendor/branches') }}" style="text-decoration:none;color:#6b7280;">{{ __('vendor_branches.my_branches') }}</a>
        <i class="bi bi-chevron-{{ $isAr ? 'left' : 'right' }}" style="color:#94a3b8;"></i>
        <span style="color:var(--vb-primary);font-weight:700;">{{ $isAr ? 'تعديل الفرع' : 'Edit Branch' }}</span>
    </nav>

    <div class="vb-card" style="margin-bottom:20px;">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3" style="padding:22px;">
            <div>
                <h3 class="vb-title">{{ $isAr ? 'تعديل الفرع' : 'Edit Branch' }}: {{ $branch->display_name }}</h3>
                <p class="vb-hero-subtitle">{{ $isAr ? 'حدّث بيانات الفرع.' : 'Update the branch information.' }}</p>
            </div>
            <a href="{{ route('vendor/branches') }}" class="vb-btn vb-btn-outline">
                <i class="bi bi-arrow-left"></i> {{ $isAr ? 'العودة' : 'Back' }}
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="vb-card mb-4">
            <div class="vb-body">
                <ul class="mb-0" dir="ltr">
                    @foreach($errors->all() as $error)
                        <li class="text-danger fw-semibold small">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="vb-card">
        <div class="vb-card-head">
            <h6>{{ $isAr ? 'بيانات الفرع' : 'Branch Information' }}</h6>
        </div>
        <div class="vb-body">
            <form method="POST" action="{{ route('vendor/branches/update', $branch->id) }}">
                @csrf
                @method('PUT')
                <div class="vb-form-grid">
                    <div class="vb-field">
                        <label>{{ $isAr ? 'اسم الفرع (عربي)' : 'Branch Name (Arabic)' }} *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $branch->name) }}" required>
                    </div>

                    <div class="vb-field">
                        <label>{{ $isAr ? 'اسم الفرع (إنجليزي)' : 'Branch Name (English)' }}</label>
                        <input type="text" name="name_ar" class="form-control" value="{{ old('name_ar', $branch->name_ar) }}">
                    </div>

                    <div class="vb-field" style="grid-column:1/-1;">
                        <label>{{ $isAr ? 'العنوان' : 'Address' }}</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address', $branch->address) }}">
                    </div>

                    <div class="vb-field">
                        <label>{{ $isAr ? 'المدينة' : 'City' }}</label>
                        <input type="text" name="city" class="form-control" value="{{ old('city', $branch->city) }}">
                    </div>

                    <div class="vb-field">
                        <label>{{ $isAr ? 'المنطقة' : 'Region' }}</label>
                        <input type="text" name="region" class="form-control" value="{{ old('region', $branch->region) }}">
                    </div>

                    <div class="vb-field">
                        <label>{{ $isAr ? 'الرمز البريدي' : 'Postal Code' }}</label>
                        <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $branch->postal_code) }}">
                    </div>

                    <div class="vb-field">
                        <label>{{ $isAr ? 'رقم الهاتف' : 'Phone' }}</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $branch->phone) }}">
                    </div>

                    <div class="vb-field">
                        <label>{{ $isAr ? 'البريد الإلكتروني' : 'Email' }}</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $branch->email) }}">
                    </div>

                    <div class="vb-field" style="grid-column:1/-1;">
                        <label>{{ $isAr ? 'ملاحظات' : 'Notes' }}</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $branch->notes) }}</textarea>
                    </div>

                    <div class="vb-field">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" {{ old('is_active', $branch->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="isActive" style="color:#334155;">{{ $isAr ? 'نشط' : 'Active' }}</label>
                        </div>
                    </div>

                    <div class="vb-field">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_default" value="1" id="isDefault" {{ old('is_default', $branch->is_default) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="isDefault" style="color:#334155;">{{ $isAr ? 'الفرع الافتراضي' : 'Default Branch' }}</label>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="vb-btn">
                        <i class="bi bi-check-lg"></i> {{ $isAr ? 'حفظ التعديلات' : 'Save Changes' }}
                    </button>
                    <a href="{{ route('vendor/branches') }}" class="vb-btn vb-btn-outline">
                        {{ $isAr ? 'إلغاء' : 'Cancel' }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
