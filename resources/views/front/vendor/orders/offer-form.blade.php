@extends('layouts.front.home')

@section('title')
    <title>{{ __('nav.send_offer') }} - Vendor | Hema</title>
@endsection

@section('css')
<style>
    .vendor-offer-form {
        --vd-bg: #f5f6f8;
        --vd-card: #ffffff;
        --vd-border: #e7eaf0;
        --vd-title: #0f2f7f;
        --vd-text: #1f2937;
        --vd-muted: #6b7280;
        --vd-primary: #0f4bbf;
        --vd-accent: #0ec6a0;
        max-width: 95%;
        margin: 12px auto 0;
        background: var(--vd-bg);
        padding: 8px 0 24px;
        font-family: "Poppins", "Tajawal", system-ui, -apple-system, "Segoe UI", Arial, sans-serif;
    }

    .vendor-offer-form * {
        font-family: inherit;
    }

    .vo-shell {
        display: grid;
        grid-template-columns: minmax(0, 1.45fr) minmax(280px, .85fr);
        gap: 18px;
        align-items: start;
    }

    .vo-card,
    .vo-side-card {
        background: var(--vd-card);
        border: 1px solid var(--vd-border);
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }

    .vo-card-head {
        padding: 20px 22px;
        border-bottom: 1px solid var(--vd-border);
    }

    .vo-breadcrumb {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
        color: var(--vd-muted);
        font-size: 13px;
        margin-bottom: 8px;
    }

    .vo-breadcrumb a {
        color: var(--vd-muted);
        text-decoration: none;
    }

    .vo-breadcrumb a:hover {
        color: var(--vd-primary);
    }

    .vo-title {
        margin: 0;
        color: var(--vd-title);
        font-size: 32px;
        line-height: 1.08;
        font-weight: 800;
        letter-spacing: -0.01em;
    }

    .vo-subtitle {
        margin: 8px 0 0;
        color: #475569;
        font-size: 15px;
        line-height: 1.6;
    }

    .vo-body {
        padding: 22px;
    }

    .vo-info {
        background: #f8fbff;
        border: 1px solid #dbeafe;
        border-radius: 14px;
        padding: 16px;
        margin-bottom: 18px;
    }

    .vo-info-title {
        margin: 0 0 10px;
        color: var(--vd-text);
        font-size: 18px;
        font-weight: 700;
    }

    .vo-info-grid {
        display: grid;
        gap: 8px;
        color: var(--vd-text);
        font-size: 14px;
        line-height: 1.7;
    }

    .vo-section {
        border: 1px solid var(--vd-border);
        border-radius: 14px;
        padding: 18px;
        background: #fff;
        margin-bottom: 16px;
    }

    .vo-section-title {
        margin: 0 0 14px;
        color: var(--vd-text);
        font-size: 18px;
        font-weight: 700;
    }

    .vo-label {
        display: block;
        margin-bottom: 8px;
        color: var(--vd-muted);
        font-size: 14px;
        font-weight: 600;
    }

    .vo-control,
    .vo-input-group-text {
        min-height: 52px;
        border: 1px solid #d8dde6;
        border-radius: 12px;
        background: #fff;
        box-shadow: none;
    }

    .vo-control:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 3px rgba(15, 75, 191, .12);
    }

    .vo-control {
        color: var(--vd-text);
    }

    textarea.vo-control {
        min-height: 126px;
        resize: vertical;
        padding-top: 12px;
    }

    .input-group .vo-control {
        border-end-end-radius: 0;
        border-start-end-radius: 0;
    }

    .input-group .vo-input-group-text {
        border-start-start-radius: 0;
        border-end-start-radius: 0;
        background: #f8fafc;
        color: var(--vd-muted);
        font-weight: 600;
    }

    .vo-help {
        margin-top: 6px;
        font-size: 12px;
        color: var(--vd-muted);
    }

    .vo-actions {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-top: 18px;
    }

    .vo-btn,
    .vo-btn-outline {
        min-height: 52px;
        padding: 0 22px;
        border-radius: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .vo-btn {
        border: 0;
        color: #fff;
        background: linear-gradient(90deg, var(--vd-primary) 0%, var(--vd-accent) 100%);
        box-shadow: 0 10px 22px rgba(15, 75, 191, .14);
    }

    .vo-btn-outline {
        border: 1px solid #cbd5e1;
        color: #1e3a8a;
        background: #fff;
    }

    .vo-btn-outline:hover {
        background: #eef5ff;
        color: #1d4ed8;
    }

    .vo-side-card {
        padding: 18px;
    }

    .vo-side-card + .vo-side-card {
        margin-top: 16px;
    }

    .vo-side-title {
        margin: 0 0 14px;
        color: var(--vd-text);
        font-size: 18px;
        font-weight: 700;
    }

    .vo-side-text,
    .vo-side-list {
        color: var(--vd-muted);
        font-size: 14px;
        line-height: 1.7;
    }

    .vo-side-list {
        margin: 0;
        padding-inline-start: 18px;
    }

    .vo-side-list li + li {
        margin-top: 8px;
    }

    .vo-alert {
        border-radius: 14px;
        border: 1px solid #fecaca;
        background: #fff1f2;
    }

    @media (max-width: 991.98px) {
        .vo-shell {
            grid-template-columns: 1fr;
        }

        .vo-title {
            font-size: 28px;
        }
    }

    @media (max-width: 767.98px) {
        .vendor-offer-form {
            max-width: 100%;
            margin-top: 0;
            padding: 0 4px 20px;
        }

        .vo-card,
        .vo-side-card {
            border-radius: 12px;
        }

        .vo-card-head,
        .vo-body {
            padding: 16px;
        }

        .vo-actions {
            flex-direction: column-reverse;
        }

        .vo-actions .vo-btn,
        .vo-actions .vo-btn-outline {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<main class="vendor-offer-form">
    @include('flash::message')

    @if ($errors->any())
        <div class="alert alert-danger vo-alert">
            <strong>{{ __('messages.error') ?? 'Error' }}:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="vo-shell">
        <section class="vo-card">
            <div class="vo-card-head">
                <nav class="vo-breadcrumb" aria-label="breadcrumb">
                    <a href="{{ route('vendor/dashboard') }}">{{ __('nav.dashboard') }}</a>
                    <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
                    <a href="{{ route('vendor/orders') }}">{{ __('nav.orders') }}</a>
                    <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
                    <a href="{{ route('vendor/orders/show', $order->id) }}">{{ __('nav.order_details') }} #{{ $order->id }}</a>
                </nav>

                <h1 class="vo-title">{{ __('nav.send_offer') }} #{{ $order->id }}</h1>
                <p class="vo-subtitle">
                    {{ __('nav.order_details') }} — {{ (int)$order->order_type === 1 ? __('nav.purchase_orders') : ((int)$order->order_type === 3 ? __('nav.maintenance_request') : __('nav.quotation_request')) }}
                </p>
            </div>

            <div class="vo-body">
                <div class="vo-info">
                    <h2 class="vo-info-title">{{ __('nav.order_details') }}</h2>
                    <div class="vo-info-grid">
                        <div><strong>{{ __('nav.customer') }}:</strong> {{ $order->user->name }}</div>
                        <div><strong>{{ __('nav.note') ?? 'Note' }}:</strong> {{ \Illuminate\Support\Str::limit($order->notes, 120) }}</div>
                        <div><strong>{{ __('nav.type') ?? 'Type' }}:</strong> @if((int)$order->order_type === 1) {{ __('nav.purchase_orders') }} @elseif((int)$order->order_type === 3) {{ __('nav.maintenance_request') }} @else {{ __('nav.quotation_request') }} @endif</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('vendor/orders/make-offer') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                    <div class="vo-section">
                        <h3 class="vo-section-title">{{ __('nav.offer_form') ?? __('nav.send_offer') }}</h3>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="vo-label">{{ __('nav.offer_price') ?? __('nav.total_price') }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" class="form-control vo-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
                                    <span class="input-group-text vo-input-group-text">SAR</span>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="delivery_days" class="vo-label">{{ __('nav.delivery_days') ?? __('nav.delivery_duration') }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control vo-control @error('delivery_days') is-invalid @enderror" id="delivery_days" name="delivery_days" value="{{ old('delivery_days') }}" required>
                                    <span class="input-group-text vo-input-group-text">{{ __('nav.days_text') ?? 'days' }}</span>
                                </div>
                                @error('delivery_days')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="warranty" class="vo-label">{{ __('nav.warranty') ?? 'Warranty' }}</label>
                            <input type="text" class="form-control vo-control @error('warranty') is-invalid @enderror" id="warranty" name="warranty" value="{{ old('warranty') }}" placeholder="{{ __('nav.warranty') ?? 'Warranty' }}">
                            @error('warranty')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="vo-label">{{ __('nav.general_notes') ?? __('nav.note') }}</label>
                            <textarea class="form-control vo-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="vo-section">
                        <h3 class="vo-section-title">{{ __('nav.attachments') ?? 'Attachments' }}</h3>

                        <div class="mb-3">
                            <label for="attachment" class="vo-label">{{ __('nav.file_label') ?? 'File' }} (PDF, DOC, JPG, PNG)</label>
                            <input type="file" class="form-control vo-control @error('attachment') is-invalid @enderror" id="attachment" name="attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif">
                            <div class="vo-help">Max 5MB</div>
                            @error('attachment')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="vo-actions">
                        <a href="{{ route('vendor/orders/show', $order->id) }}" class="vo-btn-outline">
                            <i class="bi bi-arrow-left"></i> {{ __('nav.back') ?? __('nav.cancel') }}
                        </a>
                        <button type="submit" class="vo-btn">
                            <i class="bi bi-check-circle"></i> {{ __('nav.send_offer') ?? __('nav.submit') }}
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <aside>
            <div class="vo-side-card">
                <h2 class="vo-side-title">{{ __('nav.customer_info') ?? 'Customer information' }}</h2>
                <div class="vo-side-text">
                    <div class="mb-2"><strong>{{ __('nav.customer') }}:</strong> {{ $order->user->name }}</div>
                    <div class="mb-2"><strong>{{ __('nav.email') ?? 'Email' }}:</strong> <a href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a></div>
                    <div><strong>{{ __('nav.phone') ?? 'Phone' }}:</strong> <a href="tel:{{ $order->user->mobile }}">{{ $order->user->mobile ?? __('nav.unknown') }}</a></div>
                </div>
            </div>

            <div class="vo-side-card">
                <h2 class="vo-side-title">{{ __('nav.tips') ?? 'Tips' }}</h2>
                <ul class="vo-side-list">
                    <li>{{ __('nav.verify_price') ?? 'Make sure the price is accurate.' }}</li>
                    <li>{{ __('nav.verify_delivery') ?? 'Choose a realistic delivery date.' }}</li>
                    <li>{{ __('nav.add_notes') ?? 'Add useful notes if needed.' }}</li>
                    <li>{{ __('nav.keep_copy') ?? 'Keep a copy of your offer.' }}</li>
                </ul>
            </div>
        </aside>
    </div>
</main>
@endsection
