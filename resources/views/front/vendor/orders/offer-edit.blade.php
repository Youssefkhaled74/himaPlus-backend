@extends('layouts.front.home')

@section('title')
    <title>{{ trans_or_fallback('', '') }} - Vendor | Hema</title>
@endsection

@section('css')
    <style>
        .vendor-offer-form{max-width:95%;margin-top:8%!important;}
        .vendor-offer-form .card{border:1px solid #e3e7ee;border-radius:18px;overflow:hidden;box-shadow:none;}
        .vendor-offer-form .card-header.bg-gradient{
            background:#fff !important;
            border-bottom:1px solid #edf1f5;
            text-align:center;
            padding:20px 18px;
        }
        .vendor-offer-form .card-header h4{font-size:30px;font-weight:700;color:#111827;}
        .vendor-offer-form .info-box{
            background:#f8fbff;border:1px solid #e3edf9;border-radius:14px;padding:14px 16px;margin-bottom:18px;
        }
        .vendor-offer-form .form-section{
            background:#fff;border:1px solid #e8ecf2;border-radius:16px;padding:16px;margin-bottom:16px;
        }
        .vendor-offer-form .form-section h5{font-size:20px;font-weight:700;margin-bottom:12px;}
        .vendor-offer-form .form-label{font-weight:600;color:#6b7280;font-size:15px;}
        .vendor-offer-form .form-control,
        .vendor-offer-form .input-group-text{
            border:1px solid #d8dde6;border-radius:14px;min-height:56px;background:#fff;color:#111827;
            box-shadow:none;
        }
        .vendor-offer-form .input-group .form-control{border-end-end-radius:0;border-start-end-radius:0;}
        .vendor-offer-form .input-group .input-group-text{
            border-start-start-radius:0;border-end-start-radius:0;background:#f9fafb;color:#6b7280;font-weight:600;
        }
        .vendor-offer-form textarea.form-control{min-height:120px;resize:vertical;padding-top:12px;}
        .vendor-offer-form .form-control:focus{border-color:#0ea5a4;box-shadow:0 0 0 3px rgba(16,185,129,.12);}
        .vendor-offer-form #attachment.form-control{padding:14px;}
        .vendor-offer-form .btn-gradient{
            background:linear-gradient(90deg,#0f4bbf 0%, #10c7a5 100%);
            border:0;color:#fff;border-radius:16px;min-height:56px;padding:0 26px;font-weight:700;
        }
        .vendor-offer-form .btn-secondary{
            background:#fff;border:1px solid #e5a0a0;color:#d14343;border-radius:16px;min-height:56px;padding:0 26px;font-weight:700;
        }
        .vendor-offer-form .btn-secondary:hover{background:#fff5f5;color:#b91c1c;border-color:#dc8a8a;}
        @media (max-width: 992px){
            .vendor-offer-form .card-header h4{font-size:28px;}
            .vendor-offer-form .d-flex.justify-content-between{gap:10px;flex-direction:row-reverse;}
            .vendor-offer-form .d-flex.justify-content-between .btn{flex:1;}
        }
    </style>
@endsection

@section('content')
    <main class="container my-4 vendor-offer-form">
        @include('flash::message')
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Ø®Ø·Ø£ ÙÙŠ Ø§Ù„ØªØ­Ù‚Ù‚:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <nav class="breadcrumb-custom mb-3">
            <a href="{{ route('vendor/dashboard') }}" class="text-decoration-none text-muted">{{ trans_or_fallback('', '') }}</a>
            <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
            <a href="{{ route('vendor/orders/my-offers') }}" class="text-decoration-none text-muted">{{ trans_or_fallback('', '') }}</a>
            <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
            <span class="text-primary fw-semibold">ØªØ¹Ø¯ÙŠÙ„ Ø§Ù„Ø¹Ø±Ø¶ #{{ $offer->id }}</span>
        </nav>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-gradient">
                        <h4 class="mb-0">ØªØ¹Ø¯ÙŠÙ„ Ø§Ù„Ø¹Ø±Ø¶ Ø§Ù„Ø³Ø¹Ø±ÙŠ #{{ $offer->id }}</h4>
                    </div>
                    
                    <div class="card-body">
                        <div class="info-box">
                            <h6 class="mb-2">ØªÙØ§ØµÙŠÙ„ Ø§Ù„Ø·Ù„Ø¨:</h6>
                            <p class="mb-1"><strong>Ø±Ù‚Ù… Ø§Ù„Ø·Ù„Ø¨:</strong> #{{ $offer->order->id }}</p>
                            <p class="mb-0"><strong>Ø§Ù„ÙˆØµÙ:</strong> {{ Str::limit($offer->order->notes, 100) }}</p>
                        </div>

                        <form method="POST" action="{{ route('vendor/orders/offer-update', $offer->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Pricing Section -->
                            <div class="form-section">
                                <h5 class="mb-3">ØªÙØ§ØµÙŠÙ„ Ø§Ù„Ø¹Ø±Ø¶</h5>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="price" class="form-label">Ø§Ù„Ø³Ø¹Ø± Ø§Ù„Ù…Ù‚ØªØ±Ø­ <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $offer->cost) }}" required>
                                            <span class="input-group-text">Ø±.Ø³</span>
                                        </div>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="delivery_days" class="form-label">Ø£ÙŠØ§Ù… Ø§Ù„ØªØ³Ù„ÙŠÙ… <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control @error('delivery_days') is-invalid @enderror" id="delivery_days" name="delivery_days" value="{{ old('delivery_days', $offer->delivery_time) }}" required>
                                            <span class="input-group-text">ÙŠÙˆÙ…</span>
                                        </div>
                                        @error('delivery_days')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="warranty" class="form-label">Ø§Ù„Ø¶Ù…Ø§Ù†</label>
                                    <input type="text" class="form-control @error('warranty') is-invalid @enderror" id="warranty" name="warranty" value="{{ old('warranty', $offer->warranty) }}" placeholder="Ù…Ø«Ø§Ù„: Ø³Ù†Ø© ÙˆØ§Ø­Ø¯Ø©">
                                    @error('warranty')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">Ù…Ù„Ø§Ø­Ø¸Ø§Øª Ø¥Ø¶Ø§ÙÙŠØ©</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4">{{ old('notes', $offer->notes) }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Attachment Section -->
                            <div class="form-section">
                                <h5 class="mb-3">Ø§Ù„Ù…Ø±ÙÙ‚Ø§Øª (Ø§Ø®ØªÙŠØ§Ø±ÙŠ)</h5>
                                
                                @if(!empty($offer->files[0]))
                                    <div class="mb-3">
                                        <p class="mb-2"><strong>Ø§Ù„Ù…Ù„Ù Ø§Ù„Ø­Ø§Ù„ÙŠ:</strong></p>
                                        <a href="{{ asset($offer->files[0]) }}" target="_blank" class="btn btn-sm btn-info">
                                            <i class="bi bi-download"></i> ØªØ­Ù…ÙŠÙ„
                                        </a>
                                        <label class="form-check mt-2">
                                            <input type="checkbox" name="remove_attachment" class="form-check-input">
                                            <span class="form-check-label">Ø­Ø°Ù Ø§Ù„Ù…Ù„Ù Ø§Ù„Ø­Ø§Ù„ÙŠ</span>
                                        </label>
                                    </div>
                                @endif
                                
                                <div class="mb-3">
                                    <label for="attachment" class="form-label">Ø§Ø³ØªØ¨Ø¯Ù„ Ø§Ù„Ù…Ù„Ù (PDF, DOC, ØµÙˆØ±Ø©)</label>
                                    <input type="file" class="form-control @error('attachment') is-invalid @enderror" id="attachment" name="attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif">
                                    <small class="form-text text-muted">Ø§Ù„Ø­Ø¯ Ø§Ù„Ø£Ù‚ØµÙ‰: 5MB</small>
                                    @error('attachment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('vendor/orders/my-offers') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Ø¥Ù„ØºØ§Ø¡
                                </a>
                                <button type="submit" class="btn btn-gradient">
                                    <i class="bi bi-check-circle"></i> ØªØ­Ø¯ÙŠØ« Ø§Ù„Ø¹Ø±Ø¶
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Ù…Ø¹Ù„ÙˆÙ…Ø§Øª Ø§Ù„Ø¹Ù…ÙŠÙ„</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            <strong>Ø§Ù„Ø§Ø³Ù…:</strong><br>
                            {{ $offer->order->user->name }}
                        </p>
                        <p class="mb-2">
                            <strong>Ø§Ù„Ø¨Ø±ÙŠØ¯ Ø§Ù„Ø¥Ù„ÙƒØªØ±ÙˆÙ†ÙŠ:</strong><br>
                            <a href="mailto:{{ $offer->order->user->email }}">{{ $offer->order->user->email }}</a>
                        </p>
                        <p class="mb-0">
                            <strong>Ø§Ù„Ù‡Ø§ØªÙ:</strong><br>
                            <a href="tel:{{ $offer->order->user->mobile }}">{{ $offer->order->user->mobile ?? 'Ù„Ù… ÙŠØªÙ… Ø§Ù„ØªØ­Ø¯ÙŠØ¯' }}</a>
                        </p>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Ø­Ø§Ù„Ø© Ø§Ù„Ø¹Ø±Ø¶</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">
                            <strong>Ø§Ù„Ø­Ø§Ù„Ø© Ø§Ù„Ø­Ø§Ù„ÙŠØ©:</strong><br>
                            @php $s=(string)$offer->status; $isPending=($s === '1' || strtolower($s)==='pending'); $isAccepted=($s === '2' || strtolower($s)==='accepted'); @endphp
                            <span class="badge bg-{{ $isPending ? 'warning' : ($isAccepted ? 'success' : 'danger') }}">
                                {{ $isPending ? 'Pending' : ($isAccepted ? 'Accepted' : 'Rejected') }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection


