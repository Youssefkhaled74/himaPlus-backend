@extends('layouts.front.home')

@section('title')
    <title>{{ $product->name ?? __('nav.product_details') ?? 'Product Details' }} - Vendor | HemaPulse</title>
@endsection

@section('css')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');

    .hp-main, .hp-main *{
        font-family: "Poppins", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .hp-main{
        background:#f7f8fa;
        padding-top: 0 !important;
        padding-bottom: 0;
    }

    .hp-wrap{
        max-width: 1320px;
        margin: 0 auto;
        padding: 34px 12px 72px;
    }

    /* Breadcrumb */
    .hp-bc{
        font-size: 14px;
        color: #94a3b8;
        display:flex;
        align-items:center;
        gap: 8px;
        margin-bottom: 34px;
    }
    .hp-bc a{ color:#94a3b8; text-decoration:none; }
    .hp-bc a:hover{ color:#0b3a82; }
    .hp-bc .sep{ color:#cbd5e1; }

    /* Top grid */
    .hp-top{
        display:grid;
        grid-template-columns: minmax(0, 1.05fr) minmax(0, .95fr);
        gap: 24px;
        align-items:start;
    }
    @media (max-width: 992px){
        .hp-top{ grid-template-columns: 1fr; }
    }

    /* Image card */
    .img-card{ background:transparent; border:0; border-radius:0; overflow:visible; box-shadow:none; }
    .img-main{
        width:100%;
        height: 340px;
        background:#e9edf5;
        border-radius:10px;
        overflow:hidden;
        display:flex;
        align-items:center;
        justify-content:center;
        position:relative;
    }
    .img-main img{
        width:100%;
        height:100%;
        object-fit:cover;
        display:block;
    }

    /* Thumbs */
    .thumbs-strip{
        display:flex;
        align-items:center;
        gap:8px;
        margin-top:12px;
    }
    .thumb-nav{
        width:24px;
        height:24px;
        border:0;
        background:transparent;
        color:#8a95a8;
        display:grid;
        place-items:center;
        font-size:20px;
        line-height:1;
        padding:0;
        cursor:pointer;
        flex:0 0 auto;
    }
    .thumb-nav:hover{ color:#0b4fae; }
    .thumbs{
        display:flex;
        gap: 10px;
        padding: 0;
        align-items:center;
        overflow:auto;
        border-top: 0;
        scrollbar-width:none;
    }
    .thumbs::-webkit-scrollbar{ display:none; }
    .thumb{
        width: 82px;
        height: 58px;
        border-radius: 8px;
        overflow:hidden;
        border: 1px solid #d8e1ee;
        flex: 0 0 auto;
        cursor:pointer;
        background:#eef2f7;
    }
    .thumb img{ width:100%; height:100%; object-fit:cover; display:block; }
    .thumb.active{ border-color:#0D6BDA; box-shadow:0 0 0 1px #0D6BDA inset; }

    /* Right side */
    .info-card{ background:transparent; border:0; border-radius:0; padding:0; box-shadow:none; }
    .prod-title{
        font-size: 22px;
        font-weight: 700;
        color:#0f172a;
        margin:0 0 12px;
        line-height:1.35;
    }
    .sec-label{
        font-size: 16px;
        font-weight: 500;
        color:#1f2937;
        text-transform:none;
        margin-bottom:8px;
    }
    .desc{
        color:#5f6b7d;
        font-size: 13px;
        line-height:1.6;
        margin:0 0 12px;
    }

    .meta-line{
        display:flex;
        gap: 6px;
        align-items:center;
        font-size: 14px;
        color:#1f2937;
        margin-bottom: 10px;
    }
    .meta-line b{ color:#0b4fae; font-weight:700; }

    .vendor-mini{
        display:flex;
        gap: 10px;
        align-items:center;
        padding: 6px 0 2px;
        border:0;
        border-radius: 12px;
        margin: 0 0 6px;
        background:transparent;
    }
    .vendor-ico{
        width:34px;height:34px;border-radius:999px;
        display:flex;align-items:center;justify-content:center;
        background:#eef6ff;color:#0e5bd8;
        font-size:14px;
    }
    .vendor-name{ font-weight: 700; font-size: 14px; color:#0f172a; margin:0; line-height:1.2; }
    .vendor-loc{ font-size: 12px; color:#7b8594; margin:0; line-height:1.2; }

    .price{
        font-size: 36px;
        font-weight: 800;
        color:#0e5bd8;
        margin: 8px 0 14px;
        line-height:1.2;
    }

    /* Buttons */
    .btn-hp{
        height: 44px;
        border-radius: 9px;
        font-weight: 700;
        font-size: 14px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        padding: 0 18px;
        border: 1px solid transparent;
        white-space:nowrap;
        gap: 10px;
        width: 100%;
    }
    .btn-row{ display:flex; gap: 16px; }
    .btn-row form{ flex:1; }
    @media (max-width: 480px){
        .btn-row{ flex-direction:column; }
    }

    .btn-grad{
        background: linear-gradient(90deg, #0B4FAE 0%, #0DC79C 100%);
        color:#fff;
        box-shadow:none;
    }
    .btn-grad:hover{ filter: brightness(.97); color:#fff; }
    .btn-outline{
        background:#fff;
        border-color:#0DC79C;
        color:#0B4FAE;
    }
    .btn-outline:hover{ background:#f5fffc; }
    .btn-outline-danger-soft{
        background:#fff;
        border:1px solid #0D6BDA;
        color:#0D6BDA;
    }
    .btn-outline-danger-soft:hover{ background:#f5f9ff; }

    .delete-modal-backdrop{
        position:fixed;
        inset:0;
        background:rgba(15, 23, 42, .45);
        display:none;
        align-items:center;
        justify-content:center;
        z-index:1080;
        padding:20px;
    }
    .delete-modal{
        width:100%;
        max-width:540px;
        background:#fff;
        border-radius:18px;
        box-shadow:0 24px 70px rgba(2, 6, 23, .26);
        padding:34px 28px 26px;
        text-align:center;
    }
    .delete-modal-icon{
        width:68px;
        height:68px;
        margin:0 auto 14px;
        border-radius:999px;
        background:linear-gradient(135deg,#0b3a82 0%, #0e5bd8 45%, #10b981 100%);
        color:#fff;
        display:grid;
        place-items:center;
        font-size:34px;
        line-height:1;
    }
    .delete-modal-title{
        margin:0;
        font-size:34px;
        font-weight:700;
        color:#111827;
    }
    .delete-modal-text{
        margin:12px 0 22px;
        font-size:20px;
        color:#6b7280;
        line-height:1.5;
    }
    .delete-modal-actions{
        display:flex;
        justify-content:center;
        gap:12px;
    }
    .delete-modal-btn{
        min-width:150px;
        height:46px;
        border-radius:10px;
        font-size:16px;
        font-weight:600;
        border:1px solid transparent;
    }
    .delete-modal-cancel{
        color:#fff;
        background:linear-gradient(90deg,#0B4FAE,#0DC79C);
    }
    .delete-modal-confirm{
        color:#0D6BDA;
        background:#fff;
        border-color:#0D6BDA;
    }

    /* Tabs */
    .hp-tabs{
        margin-top: 56px;
        background:transparent;
        border:0;
        border-radius: 0;
        box-shadow:none;
        padding: 0;
    }
    .tab-head{
        display:flex;
        gap: 44px;
        border-bottom: 1px solid #d9dee8;
        padding: 0 4px;
    }
    .tab-btn{
        background:transparent;
        border:0;
        padding: 14px 0;
        font-weight:700;
        font-size: 16px;
        color:#94a3b8;
        position:relative;
        cursor:pointer;
    }
    .tab-btn.active{
        color:#0DAE8F;
    }
    .tab-btn.active::after{
        content:"";
        position:absolute;
        left:0; right:0; bottom:-1px;
        height:2px;
        background:linear-gradient(90deg,#0B4FAE,#0DC79C);
        border-radius: 2px;
    }
    .tab-body{ padding: 22px 0 0; }

    /* Specs grid */
    .spec-grid{
        display:grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    @media (max-width: 768px){
        .spec-grid{ grid-template-columns: 1fr; }
    }
    .spec-box{
        border: 1px solid #e6ebf2;
        border-radius: 10px;
        background:#f1f3f6;
        overflow: hidden;
    }
    .spec-row{
        display:flex;
        justify-content:space-between;
        gap: 12px;
        padding: 14px 20px;
        border-bottom: 1px solid #e4e8ef;
        font-size: 14px;
        background:#f3f5f7;
    }
    .spec-row:nth-child(2n){ background:#eef1f4; }
    .spec-row:last-child{ border-bottom:0; }
    .spec-row .k{ color:#1f2937; font-weight:600; }
    .spec-row .v{ color:#4b5563; text-align:right; margin-inline-start: auto; }

    /* Reviews placeholder */
    .reviews-empty{
        color:#64748b;
        font-size: 13px;
    }
    .reviews-list{display:grid; gap:10px;}
    .review-item{
        background:#fff;
        border:1px solid #e3e8f1;
        border-radius:10px;
        padding:12px 14px;
    }
    .review-head{
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:10px;
        margin-bottom:6px;
    }
    .review-user{font-size:13px; font-weight:700; color:#0f172a;}
    .review-stars{color:#f59e0b; font-size:13px; letter-spacing:1px;}
    .review-comment{font-size:13px; color:#64748b; margin:0;}

    @media (max-width: 991.98px){
        .img-main{ height: 320px; }
        .prod-title{ font-size: 26px; }
        .price{ font-size: 28px; }
        .btn-hp{ height: 46px; font-size: 14px; }
        .tab-btn{ font-size: 16px; }
    }

    @media (max-width: 575.98px){
        .hp-wrap{ padding: 28px 12px 48px; }
        .hp-bc{ margin-bottom: 20px; font-size: 13px; }
        .img-main{ height: 240px; }
        .thumb{ width: 72px; height: 52px; }
        .prod-title{ font-size: 24px; }
        .desc{ font-size: 14px; }
        .meta-line{ font-size: 13px; }
        .price{ font-size: 24px; }
        .btn-row{ flex-direction: column; }
        .hp-tabs{ margin-top: 30px; }
        .tab-btn{ font-size: 15px; }
        .spec-row{ font-size: 14px; padding: 14px 16px; }
    }
</style>
@endsection

@section('content')
<main class="hp-main">
    <div class="hp-wrap">

        {{-- Breadcrumb --}}
        <div class="hp-bc">
            <a href="{{ route('vendor/products') }}">{{ __('nav.products') ?? 'Products' }}</a>
            <span class="sep">&rsaquo;</span>
            <span style="color:#0e5bd8;font-weight:700;">{{ $product->name ?? '' }}</span>
        </div>

        {{-- Top --}}
        <div class="hp-top">

            {{-- Images --}}
            <div class="img-card">
                <div class="img-main">
                    @php
                        $firstImg = null;
                        if(isset($images) && count($images)) $firstImg = $images[0];
                        elseif(!empty($product->img)) $firstImg = $product->img;

                        $toStorageUrl = function ($path) {
                            $p = ltrim((string) $path, '/');
                            if (!str_starts_with($p, 'http') && !str_contains($p, '/')) {
                                $p = 'products/' . $p;
                            }
                            if (str_starts_with((string) $path, 'http')) {
                                return (string) $path;
                            }

                            // Prefer Laravel public disk path
                            if (file_exists(storage_path('app/public/' . $p))) {
                                return asset('storage/' . $p);
                            }

                            // Fallback for hosts storing files directly under public/
                            if (file_exists(public_path($p))) {
                                return asset($p);
                            }

                            return asset('storage/' . $p);
                        };
                        $placeholderImage = asset('front/assets/images/emptyproducts.png');
                    @endphp

                    @if($firstImg)
                        <img id="mainPreview" src="{{ $toStorageUrl($firstImg) }}" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='{{ $placeholderImage }}';">
                    @else
                        <div class="text-muted">
                            <i class="bi bi-image fs-1"></i>
                        </div>
                    @endif
                </div>

                @php
                    $thumbs = [];
                    if(isset($images) && count($images)) $thumbs = $images;
                    elseif(!empty($product->img)) $thumbs = [$product->img];
                @endphp

                @if(count($thumbs))
                    <div class="thumbs-strip">
                        <button type="button" class="thumb-nav" id="thumbPrev" aria-label="Previous">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <div class="thumbs" id="thumbsWrap">
                            @foreach($thumbs as $idx => $img)
                                <div class="thumb {{ $idx==0 ? 'active' : '' }}" data-src="{{ $toStorageUrl($img) }}">
                                    <img src="{{ $toStorageUrl($img) }}" alt="thumb" onerror="this.onerror=null;this.src='{{ $placeholderImage }}';">
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="thumb-nav" id="thumbNext" aria-label="Next">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                @endif
            </div>

            {{-- Info --}}
            <div class="info-card">
                <h1 class="prod-title">
                    {{ $product->name ?? '' }}
                </h1>

                <div class="sec-label">{{ __('nav.description') ?? 'Description' }}</div>
                <p class="desc">
                    {{ $product->desc ?? '-' }}
                </p>

                <div class="meta-line">
                    <span>{{ __('nav.stock_status') ?? 'Stock Status' }}:</span>
                    <b>{{ (int)($product->stock_quantity ?? 0) }} {{ __('nav.units') ?? 'Units' }}</b>
                </div>

                {{-- Vendor mini card (optional) --}}
                <div class="vendor-mini">
                    <div class="vendor-ico">
                        <i class="bi bi-buildings"></i>
                    </div>
                    <div>
                        <p class="vendor-name">
                            {{ $product->provider->name ?? 'Vendor' }}
                        </p>
                        <p class="vendor-loc">
                            {{ $product->provider->location ?? '-' }}
                        </p>
                    </div>
                </div>

                <div class="price">
                    {{ number_format((float)($product->price ?? 0), 0) }} {{ app()->getLocale()=='ar' ? __('products.currency_sar') : 'SAR' }}
                </div>
                <div class="btn-row">
                    <a href="{{ route('vendor/products/edit', $product->id) }}" class="btn-hp btn-grad">
                        {{ __('nav.edit_product') ?? 'Edit' }}
                    </a>

                    <form class="js-delete-form" action="{{ route('vendor/products/delete', $product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-hp btn-outline">
                            {{ __('nav.delete') ?? 'Delete' }}
                        </button>
                    </form>
                </div>
                <a href="{{ route('vendor/products/edit', $product->id) }}#images"
                   class="d-inline-block mt-2 text-decoration-none"
                   style="font-size:13px;color:#0e5bd8;">
                    {{ __('products.manage_images') ?? 'Manage images (update/remove one by one)' }}
                </a>
            </div>

        </div>

        {{-- Tabs --}}
        <div class="hp-tabs">
            <div class="tab-head">
                <button type="button" class="tab-btn active" data-tab="specs">
                    {{ __('products.specifications') ?? 'Specifications' }}
                </button>
                <button type="button" class="tab-btn" data-tab="reviews">
                    {{ __('products.ratings_reviews') ?? 'Ratings & Reviews' }}
                </button>
            </div>

            <div class="tab-body">
                {{-- Specifications --}}
                <div id="tab-specs" class="tab-pane">
                    <div class="spec-grid">
                        <div class="spec-box">
                            <div class="spec-row">
                                <div class="k">{{ __('products.imaging_type') ?? 'Imaging Type' }}:</div>
                                <div class="v">{{ $product->imaging_type ?? '-' }}</div>
                            </div>
                            <div class="spec-row">
                                <div class="k">{{ __('products.power') ?? 'Power' }}:</div>
                                <div class="v">{{ $product->power ?? '-' }}</div>
                            </div>
                            <div class="spec-row">
                                <div class="k">{{ __('products.weight') ?? 'Weight' }}:</div>
                                <div class="v">{{ $product->weight ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="spec-box">
                            <div class="spec-row">
                                <div class="k">{{ __('products.dimensions') ?? 'Dimensions' }}:</div>
                                <div class="v">{{ $product->dimensions ?? '-' }}</div>
                            </div>
                            <div class="spec-row">
                                <div class="k">{{ __('products.warranty') ?? 'Warranty' }}:</div>
                                <div class="v">{{ $product->warranty ?? '-' }}</div>
                            </div>
                            <div class="spec-row">
                                <div class="k">{{ __('products.origin') ?? 'Origin' }}:</div>
                                <div class="v">{{ $product->origin->name ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Reviews --}}
                <div id="tab-reviews" class="tab-pane" style="display:none;">
                    @if(isset($product->ratings) && $product->ratings->count())
                        <div class="reviews-list">
                            @foreach($product->ratings as $rating)
                                <div class="review-item">
                                    <div class="review-head">
                                        <span class="review-user">{{ $rating->user->name ?? 'User' }}</span>
                                        <span class="review-stars">
                                            @for($i=1; $i<=5; $i++)
                                                {{ $i <= (int)$rating->rating ? '★' : '☆' }}
                                            @endfor
                                        </span>
                                    </div>
                                    <p class="review-comment">{{ $rating->comment ?: '-' }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="reviews-empty">
                            {{ __('nav.no_ratings') ?? __('products.reviews_placeholder') ?? 'Ratings & Reviews will appear here.' }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</main>

<div id="deleteModalBackdrop" class="delete-modal-backdrop" aria-hidden="true">
    <div class="delete-modal" role="dialog" aria-modal="true" aria-labelledby="deleteModalTitle">
        <div class="delete-modal-icon">✓</div>
        <h3 id="deleteModalTitle" class="delete-modal-title">
            {{ __('products.delete_product_title') ?? 'Delete Product' }}
        </h3>
        <p class="delete-modal-text">
            {{ __('products.delete_product_message') ?? 'Are you sure you want to delete this product? This action cannot be undone.' }}
        </p>
        <div class="delete-modal-actions">
            <button type="button" id="deleteModalConfirm" class="delete-modal-btn delete-modal-confirm">
                {{ __('nav.delete') ?? 'Delete' }}
            </button>
            <button type="button" id="deleteModalCancel" class="delete-modal-btn delete-modal-cancel">
                {{ __('nav.cancel') ?? 'Cancel' }}
            </button>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    // thumbs -> main image
    (function(){
        const thumbs = document.querySelectorAll('.thumb');
        const main = document.getElementById('mainPreview');
        const thumbsWrap = document.getElementById('thumbsWrap');
        const thumbPrev = document.getElementById('thumbPrev');
        const thumbNext = document.getElementById('thumbNext');
        thumbs.forEach(t => {
            t.addEventListener('click', function(){
                thumbs.forEach(x => x.classList.remove('active'));
                t.classList.add('active');
                if(main) main.src = t.getAttribute('data-src');
            });
        });
        if (thumbPrev && thumbsWrap) {
            thumbPrev.addEventListener('click', function () {
                thumbsWrap.scrollBy({ left: -120, behavior: 'smooth' });
            });
        }
        if (thumbNext && thumbsWrap) {
            thumbNext.addEventListener('click', function () {
                thumbsWrap.scrollBy({ left: 120, behavior: 'smooth' });
            });
        }

        // tabs
        const tabButtons = document.querySelectorAll('.tab-btn');
        const specs = document.getElementById('tab-specs');
        const reviews = document.getElementById('tab-reviews');
        tabButtons.forEach(btn => {
            btn.addEventListener('click', function(){
                tabButtons.forEach(x => x.classList.remove('active'));
                btn.classList.add('active');
                const target = btn.getAttribute('data-tab');
                if(target === 'specs'){
                    specs.style.display = '';
                    reviews.style.display = 'none';
                }else{
                    specs.style.display = 'none';
                    reviews.style.display = '';
                }
            });
        });

        // delete product custom modal
        const deleteForm = document.querySelector('.js-delete-form');
        const modalBackdrop = document.getElementById('deleteModalBackdrop');
        const modalConfirm = document.getElementById('deleteModalConfirm');
        const modalCancel = document.getElementById('deleteModalCancel');
        let pendingDeleteForm = null;

        if (deleteForm && modalBackdrop && modalConfirm && modalCancel) {
            deleteForm.addEventListener('submit', function (e) {
                e.preventDefault();
                pendingDeleteForm = this;
                modalBackdrop.style.display = 'flex';
                modalBackdrop.setAttribute('aria-hidden', 'false');
            });

            modalCancel.addEventListener('click', function () {
                pendingDeleteForm = null;
                modalBackdrop.style.display = 'none';
                modalBackdrop.setAttribute('aria-hidden', 'true');
            });

            modalConfirm.addEventListener('click', function () {
                if (pendingDeleteForm) {
                    pendingDeleteForm.submit();
                }
            });

            modalBackdrop.addEventListener('click', function (e) {
                if (e.target === modalBackdrop) {
                    pendingDeleteForm = null;
                    modalBackdrop.style.display = 'none';
                    modalBackdrop.setAttribute('aria-hidden', 'true');
                }
            });
        }
    })();
</script>
@endsection
