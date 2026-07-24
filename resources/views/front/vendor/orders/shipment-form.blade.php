@extends('layouts.front.home')

@section('title')
    <title>{{ __('nav.create_shipment') }} #{{ $order->id }} - Vendor | Hema</title>
@endsection

@section('css')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    .vs-ship,
    .vs-ship *{font-family:"Poppins",system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;}

    :root{
        --vs-bg:#f5f6f8;
        --vs-card:#ffffff;
        --vs-border:#e6e8ed;
        --vs-title:#1f2937;
        --vs-muted:#6b7280;
        --vs-primary:#0f4bbf;
        --vs-accent:#0ec6a0;
        --vs-danger:#d14343;
    }

    .vs-ship{max-width:800px;margin:12px auto 0;padding-bottom:28px;background:var(--vs-bg);}

    .vs-breadcrumb{font-size:15px;color:#6d7482;display:flex;align-items:center;gap:10px;margin-bottom:18px;}
    .vs-breadcrumb a{text-decoration:none;color:#6d7482;}
    .vs-breadcrumb .current{color:#0f3f9f;font-weight:600;}
    .vs-breadcrumb i{color:#0ec6a0;font-size:12px;}

    .vs-card{background:var(--vs-card);border:1px solid var(--vs-border);border-radius:16px;padding:22px;margin-bottom:16px;}
    .vs-card h4,.vs-card h5{margin:0 0 16px;color:var(--vs-title);font-weight:600;}
    .vs-card h4{font-size:22px;}
    .vs-card h5{font-size:17px;color:#374151;}

    .vs-form-group{margin-bottom:18px;}
    .vs-form-group label{display:block;font-size:14px;font-weight:600;color:#374151;margin-bottom:6px;}
    .vs-form-group input[type="text"],
    .vs-form-group select,
    .vs-form-group textarea{
        width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:10px;font-size:15px;
        color:#1f2937;background:#f9fafb;transition:border-color .2s;
    }
    .vs-form-group input:focus,
    .vs-form-group select:focus,
    .vs-form-group textarea:focus{outline:none;border-color:#0f4bbf;background:#fff;}
    .vs-form-group textarea{resize:vertical;min-height:80px;}
    .vs-form-group .hint{font-size:12px;color:#9ca3af;margin-top:4px;}

    .vs-radio-group{display:flex;flex-wrap:wrap;gap:12px;}
    .vs-radio-card{
        flex:1;min-width:200px;border:2px solid #e5e7eb;border-radius:12px;padding:14px 16px;
        cursor:pointer;transition:all .2s;display:flex;align-items:center;gap:12px;
    }
    .vs-radio-card:hover{border-color:#93c5fd;background:#f0f7ff;}
    .vs-radio-card.selected{border-color:#0f4bbf;background:#eff6ff;}
    .vs-radio-card input[type="radio"]{display:none;}
    .vs-radio-card .radio-dot{
        width:20px;height:20px;border-radius:50%;border:2px solid #d1d5db;flex-shrink:0;
        display:grid;place-items:center;transition:all .2s;
    }
    .vs-radio-card.selected .radio-dot{border-color:#0f4bbf;}
    .vs-radio-card.selected .radio-dot::after{content:"";width:10px;height:10px;border-radius:50%;background:#0f4bbf;}
    .vs-radio-card .radio-label{font-size:14px;font-weight:600;color:#1f2937;}
    .vs-radio-card .radio-desc{font-size:12px;color:#6b7280;margin-top:2px;}

    .vs-upload-area{
        border:2px dashed #d1d5db;border-radius:12px;padding:32px 20px;text-align:center;
        cursor:pointer;transition:all .2s;background:#f9fafb;
    }
    .vs-upload-area:hover{border-color:#0f4bbf;background:#f0f7ff;}
    .vs-upload-area.dragover{border-color:#0f4bbf;background:#eff6ff;}
    .vs-upload-area .upload-icon{font-size:40px;color:#9ca3af;margin-bottom:8px;}
    .vs-upload-area .upload-text{font-size:15px;color:#6b7280;}
    .vs-upload-area .upload-text strong{color:#0f4bbf;}
    .vs-upload-area input[type="file"]{display:none;}

    .vs-preview-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:12px;margin-top:14px;}
    .vs-preview-item{
        position:relative;border-radius:10px;overflow:hidden;border:1px solid #e5e7eb;
        background:#f3f4f6;
    }
    .vs-preview-item img{width:100%;height:130px;object-fit:cover;display:block;}
    .vs-preview-item .file-icon{
        width:100%;height:130px;display:grid;place-items:center;background:#f1f5f9;color:#475569;
    }
    .vs-preview-item .remove-btn{
        position:absolute;top:6px;right:6px;width:28px;height:28px;border-radius:50%;
        background:rgba(209,67,67,.9);color:#fff;border:none;cursor:pointer;
        display:grid;place-items:center;font-size:14px;
    }
    .vs-preview-item .caption-input{
        width:100%;padding:6px 8px;border:none;border-top:1px solid #e5e7eb;
        font-size:12px;box-sizing:border-box;
    }

    .vs-shipment-list{margin-top:12px;}
    .vs-shipment-card{
        border:1px solid #e5e7eb;border-radius:12px;padding:16px;margin-bottom:12px;
    }
    .vs-shipment-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;}
    .vs-shipment-header h6{margin:0;font-size:15px;font-weight:600;color:#1f2937;}
    .vs-shipment-badge{
        display:inline-block;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;
        background:#dbeafe;color:#1e40af;
    }
    .vs-shipment-meta{font-size:13px;color:#6b7280;margin-bottom:10px;}
    .vs-shipment-images{display:flex;gap:8px;flex-wrap:wrap;}
    .vs-shipment-images img{
        width:80px;height:80px;object-fit:cover;border-radius:8px;border:1px solid #e5e7eb;cursor:pointer;
    }

    .btn-vs{
        min-height:52px;border-radius:12px;border:1px solid transparent;padding:0 28px;
        font-size:16px;font-weight:600;display:inline-flex;align-items:center;justify-content:center;
        text-decoration:none;cursor:pointer;transition:all .2s;
    }
    .btn-vs-main{background:linear-gradient(90deg,#0f4bbf 0%,#10b981 100%);color:#fff;}
    .btn-vs-main:hover{color:#fff;filter:brightness(.96);}
    .btn-vs-outline{background:#fff;color:#0f3f9f;border-color:#0f4bbf;}
    .btn-vs-outline:hover{background:#f0f7ff;}
    .btn-vs:disabled{opacity:.5;cursor:not-allowed;}

    .vs-rows{display:grid;gap:8px;}
    .vs-row{display:flex;justify-content:space-between;gap:14px;align-items:flex-start;}
    .vs-key{font-size:14px;color:#6b7280;font-weight:500;}
    .vs-val{font-size:14px;color:#1f2937;font-weight:500;text-align:right;max-width:62%;}

    .vs-error{background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 14px;color:#991b1b;font-size:14px;margin-bottom:14px;}
    .vs-success{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 14px;color:#166534;font-size:14px;margin-bottom:14px;}

    @media (max-width:768px){
        .vs-radio-card{min-width:100%;}
        .btn-vs{width:100%;}
    }
</style>
@endsection

@section('content')
<main class="vs-ship">
    @include('flash::message')

    <nav class="vs-breadcrumb">
        <a href="{{ route('vendor/orders') }}">{{ __('nav.orders') }}</a>
        <i class="bi bi-chevron-right"></i>
        <a href="{{ route('vendor/orders/show', $order->id) }}">{{ __('nav.order_details') }} #{{ $order->id }}</a>
        <i class="bi bi-chevron-right"></i>
        <span class="current">{{ __('nav.create_shipment') }}</span>
    </nav>

    @if($errors->any())
        <div class="vs-error">
            <i class="bi bi-exclamation-triangle"></i>
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="vs-card">
        <h4><i class="bi bi-box-seam" style="color:#0f4bbf;"></i> {{ __('nav.create_shipment') }} #{{ $order->id }}</h4>
        <div class="vs-rows" style="margin-bottom:16px;">
            <div class="vs-row"><span class="vs-key">{{ __('nav.request_number') }}</span><span class="vs-val">#{{ $order->id }}</span></div>
            <div class="vs-row"><span class="vs-key">{{ __('nav.delivery_address') }}</span><span class="vs-val">{{ $order->address ?: '-' }}</span></div>
            <div class="vs-row"><span class="vs-key">{{ __('nav.customer') }}</span><span class="vs-val">{{ $order->user->name ?? '-' }}</span></div>
        </div>
    </div>

    @if($existingShipments->count() > 0)
        <div class="vs-card">
            <h5><i class="bi bi-clock-history" style="color:#6b7280;"></i> {{ __('nav.existing_shipments') }}</h5>
            <div class="vs-shipment-list">
                @foreach($existingShipments as $s)
                    <div class="vs-shipment-card">
                        <div class="vs-shipment-header">
                            <h6>{{ __('nav.shipment') }} #{{ $s->id }}</h6>
                            <span class="vs-shipment-badge">{{ $s->status_label }}</span>
                        </div>
                        <div class="vs-shipment-meta">
                            @if($s->tracking_number){{ __('nav.tracking_number') }}: {{ $s->tracking_number }} | @endif
                            @if($s->shippingMethod){{ $s->shippingMethod->name }} | @endif
                            {{ $s->created_at->translatedFormat('M d, Y H:i') }}
                        </div>
                        @if($s->images->count() > 0)
                            <div class="vs-shipment-images">
                                @foreach($s->images as $img)
                                    <a href="{{ asset($img->image_path) }}" target="_blank">
                                        <img src="{{ asset($img->image_path) }}" alt="{{ $img->caption ?? 'Shipment image' }}">
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="vs-card">
        <h5><i class="bi bi-plus-circle" style="color:#10b981;"></i> {{ __('nav.new_shipment') }}</h5>

        <form method="POST" action="{{ route('vendor/orders/store-shipment') }}" enctype="multipart/form-data" id="shipmentForm">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">

            <div class="vs-form-group">
                <label>{{ __('nav.shipping_method') }} *</label>
                <div class="vs-radio-group">
                    @foreach($shippingMethods as $method)
                        <label class="vs-radio-card" onclick="this.classList.toggle('selected', this.querySelector('input').checked)">
                            <input type="radio" name="shipping_method_id" value="{{ $method->id }}" {{ $loop->first ? 'checked' : '' }}>
                            <span class="radio-dot"></span>
                            <div>
                                <div class="radio-label">{{ $method->name }}</div>
                                <div class="radio-desc">{{ $method->description }}</div>
                                <div class="radio-desc" style="color:#0f4bbf;font-weight:600;">{{ number_format($method->base_price, 0) }} {{ __('nav.sar') }}</div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="vs-form-group">
                <label>{{ __('nav.tracking_number') }}</label>
                <input type="text" name="tracking_number" placeholder="{{ __('nav.tracking_number_placeholder') }}" value="{{ old('tracking_number') }}">
                <div class="hint">{{ __('nav.tracking_number_hint') }}</div>
            </div>

            <div class="vs-form-group">
                <label>{{ __('nav.shipment_images') }} *</label>
                <div class="vs-upload-area" id="uploadArea">
                    <div class="upload-icon"><i class="bi bi-cloud-arrow-up"></i></div>
                    <div class="upload-text">{{ __('nav.drop_images_here') }} <strong>{{ __('nav.or_click_to_browse') }}</strong></div>
                    <div class="hint">{{ __('nav.image_upload_hint') }}</div>
                    <input type="file" name="images[]" id="imageInput" multiple accept="image/jpeg,image/png,image/webp,application/pdf">
                </div>
                <div class="vs-preview-grid" id="previewGrid"></div>
            </div>

            <div class="vs-form-group">
                <label>{{ __('nav.notes') }}</label>
                <textarea name="notes" placeholder="{{ __('nav.shipment_notes_placeholder') }}">{{ old('notes') }}</textarea>
            </div>

            <div style="display:flex;gap:12px;margin-top:20px;">
                <button type="submit" class="btn-vs btn-vs-main" id="submitBtn">
                    <i class="bi bi-send-check"></i> {{ __('nav.create_shipment') }}
                </button>
                <a href="{{ route('vendor/orders/show', $order->id) }}" class="btn-vs btn-vs-outline">
                    <i class="bi bi-arrow-left"></i> {{ __('nav.back') }}
                </a>
            </div>
        </form>
    </div>
</main>
@endsection

@section('js')
<script>
(function(){
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('imageInput');
    const previewGrid = document.getElementById('previewGrid');
    const form = document.getElementById('shipmentForm');
    let files = [];

    uploadArea.addEventListener('click', () => fileInput.click());
    uploadArea.addEventListener('dragover', e => { e.preventDefault(); uploadArea.classList.add('dragover'); });
    uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('dragover'));
    uploadArea.addEventListener('drop', e => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        addFiles(e.dataTransfer.files);
    });
    fileInput.addEventListener('change', e => addFiles(e.target.files));

    function addFiles(newFiles) {
        for (let i = 0; i < newFiles.length && files.length < 10; i++) {
            if (newFiles[i].size > 10 * 1024 * 1024) {
                alert('File too large: ' + newFiles[i].name + ' (max 10MB)');
                continue;
            }
            files.push(newFiles[i]);
        }
        renderPreviews();
    }

    function renderPreviews() {
        previewGrid.innerHTML = '';
        files.forEach((file, idx) => {
            const item = document.createElement('div');
            item.className = 'vs-preview-item';

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = e => {
                    item.innerHTML = `
                        <img src="${e.target.result}" alt="Preview">
                        <button type="button" class="remove-btn" onclick="removeFile(${idx})"><i class="bi bi-x"></i></button>
                        <input type="text" class="caption-input" name="caption[${idx}]" placeholder="Caption (optional)" value="">
                    `;
                };
                reader.readAsDataURL(file);
            } else {
                item.innerHTML = `
                    <div class="file-icon"><i class="bi bi-file-earmark" style="font-size:28px;"></i></div>
                    <button type="button" class="remove-btn" onclick="removeFile(${idx})"><i class="bi bi-x"></i></button>
                    <input type="text" class="caption-input" name="caption[${idx}]" placeholder="Caption (optional)" value="">
                `;
            }
            previewGrid.appendChild(item);
        });
    }

    window.removeFile = function(idx) {
        files.splice(idx, 1);
        renderPreviews();
    };

    form.addEventListener('submit', function(e) {
        const dataTransfer = new DataTransfer();
        files.forEach(f => dataTransfer.items.add(f));
        fileInput.files = dataTransfer.files;

        if (files.length === 0) {
            e.preventDefault();
            alert('Please select at least one image');
            return;
        }

        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> {{ __("nav.creating_shipment") }}...';
    });

    document.querySelectorAll('.vs-radio-card').forEach(card => {
        const radio = card.querySelector('input[type="radio"]');
        if (radio.checked) card.classList.add('selected');
    });
})();
</script>
@endsection
