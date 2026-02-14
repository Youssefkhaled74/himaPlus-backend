@extends('layouts.front.home')

@section('title')
    <title>{{ __('nav.offer_form') ?? 'Offer Form' }} - Vendor | HemaPulse</title>
@endsection

@section('css')
    <style>
        .form-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #007bff;
        }
        .info-box {
            background: #e3f2fd;
            border-left: 4px solid #007bff;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('content')
    <main class="container my-4" style="max-width: 95%; margin-top: 8% !important;">
        @include('flash::message')
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>خطأ في التحقق:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <nav class="breadcrumb-custom mb-3">
            <a href="{{ route('vendor/dashboard') }}" class="text-decoration-none text-muted">{{ __('nav.dashboard') ?? 'Dashboard' }}</a>
            <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
            <a href="{{ route('vendor/orders') }}" class="text-decoration-none text-muted">{{ __('nav.view_orders') ?? 'Orders' }}</a>
            <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
            <a href="{{ route('vendor/orders/show', $order->id) }}" class="text-decoration-none text-muted">الطلب #{{ $order->id }}</a>
            <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
            <span class="text-primary fw-semibold">تقديم عرض سعري</span>
        </nav>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-gradient">
                        <h4 class="mb-0">تقديم عرض سعري للطلب #{{ $order->id }}</h4>
                    </div>
                    
                    <div class="card-body">
                        <div class="info-box">
                            <h6 class="mb-2">تفاصيل الطلب:</h6>
                            <p class="mb-1"><strong>Type:</strong> @if((int)$order->order_type === 1) Purchase Order @elseif((int)$order->order_type === 3) Maintenance Request @else Quotation Request @endif</p>
                            <p class="mb-0"><strong>الوصف:</strong> {{ Str::limit($order->notes, 100) }}</p>
                        </div>

                        <form method="POST" action="{{ route('vendor/orders/make-offer') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            
                            <!-- Pricing Section -->
                            <div class="form-section">
                                <h5 class="mb-3">تفاصيل العرض</h5>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="price" class="form-label">السعر المقترح <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
                                            <span class="input-group-text">ر.س</span>
                                        </div>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="delivery_days" class="form-label">أيام التسليم <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control @error('delivery_days') is-invalid @enderror" id="delivery_days" name="delivery_days" value="{{ old('delivery_days') }}" required>
                                            <span class="input-group-text">يوم</span>
                                        </div>
                                        @error('delivery_days')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="warranty" class="form-label">الضمان</label>
                                    <input type="text" class="form-control @error('warranty') is-invalid @enderror" id="warranty" name="warranty" value="{{ old('warranty') }}" placeholder="Warranty">
                                    @error('warranty')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">ملاحظات إضافية</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Attachment Section -->
                            <div class="form-section">
                                <h5 class="mb-3">المرفقات (اختياري)</h5>
                                
                                <div class="mb-3">
                                    <label for="attachment" class="form-label">أرفق ملف (PDF, DOC, صورة)</label>
                                    <input type="file" class="form-control @error('attachment') is-invalid @enderror" id="attachment" name="attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif">
                                    <small class="form-text text-muted">الحد الأقصى: 5MB</small>
                                    @error('attachment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('vendor/orders/show', $order->id) }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> إلغاء
                                </a>
                                <button type="submit" class="btn btn-gradient">
                                    <i class="bi bi-check-circle"></i> تقديم العرض
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">معلومات العميل</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            <strong>الاسم:</strong><br>
                            {{ $order->user->name }}
                        </p>
                        <p class="mb-2">
                            <strong>البريد الإلكتروني:</strong><br>
                            <a href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a>
                        </p>
                        <p class="mb-0">
                            <strong>الهاتف:</strong><br>
                            <a href="tel:{{ $order->user->mobile }}">{{ $order->user->mobile ?? 'لم يتم التحديد' }}</a>
                        </p>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">نصائح</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="bi bi-check-circle text-success"></i> تأكد من دقة السعر</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success"></i> حدد موعد تسليم واقعي</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success"></i> أضف ملاحظات مهمة</li>
                            <li><i class="bi bi-check-circle text-success"></i> احفظ نسخة من عرضك</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

