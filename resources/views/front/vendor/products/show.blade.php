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

    .hp-main{ background:#f7f9fc; }

    .hp-wrap{
        max-width: 95%;
        margin: 0 auto;
        padding: 28px 0 60px;
    }

    /* Breadcrumb */
    .hp-bc{
        font-size: 13px;
        color: #94a3b8;
        display:flex;
        align-items:center;
        gap: 8px;
        margin-bottom: 14px;
    }
    .hp-bc a{ color:#94a3b8; text-decoration:none; }
    .hp-bc a:hover{ color:#0b3a82; }
    .hp-bc .sep{ color:#cbd5e1; }

    /* Top grid */
    .hp-top{
        display:grid;
        grid-template-columns: 1.15fr .85fr;
        gap: 26px;
        align-items:start;
    }
    @media (max-width: 992px){
        .hp-top{ grid-template-columns: 1fr; }
    }

    /* Image card */
    .img-card{
        background:#fff;
        border: 1px solid #eef2f7;
        border-radius: 16px;
        overflow:hidden;
        box-shadow: 0 12px 30px rgba(15, 23, 42, .06);
    }
    .img-main{
        width:100%;
        height: 330px;
        background:#f1f5f9;
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
    .thumbs{
        display:flex;
        gap: 10px;
        padding: 12px;
        align-items:center;
        overflow:auto;
        border-top: 1px solid #eef2f7;
    }
    .thumb{
        width: 66px;
        height: 52px;
        border-radius: 10px;
        overflow:hidden;
        border: 2px solid transparent;
        flex: 0 0 auto;
        cursor:pointer;
        background:#f1f5f9;
    }
    .thumb img{ width:100%; height:100%; object-fit:cover; display:block; }
    .thumb.active{ border-color:#0e5bd8; }

    /* Right side */
    .info-card{
        background:#fff;
        border: 1px solid #eef2f7;
        border-radius: 16px;
        padding: 18px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, .06);
    }
    .prod-title{
        font-size: 22px;
        font-weight: 800;
        color:#0f172a;
        margin:0 0 10px;
        line-height:1.25;
    }
    .sec-label{
        font-size: 12px;
        font-weight: 700;
        color:#64748b;
        text-transform:none;
        margin-bottom:6px;
    }
    .desc{
        color:#64748b;
        font-size: 13px;
        line-height:1.7;
        margin:0 0 14px;
    }

    .meta-line{
        display:flex;
        gap: 6px;
        align-items:center;
        font-size: 12px;
        color:#64748b;
        margin-bottom: 8px;
    }
    .meta-line b{ color:#0f172a; }

    .vendor-mini{
        display:flex;
        gap: 10px;
        align-items:center;
        padding: 10px 12px;
        border:1px solid #eef2f7;
        border-radius: 12px;
        margin: 12px 0;
        background:#fbfdff;
    }
    .vendor-ico{
        width:36px;height:36px;border-radius:10px;
        display:flex;align-items:center;justify-content:center;
        background:#eef6ff;color:#0e5bd8;
    }
    .vendor-name{ font-weight: 700; font-size: 12.5px; color:#0f172a; margin:0; }
    .vendor-loc{ font-size: 11.5px; color:#64748b; margin:0; }

    .price{
        font-size: 18px;
        font-weight: 800;
        color:#0e5bd8;
        margin: 8px 0 14px;
    }

    /* Buttons */
    .btn-hp{
        height: 44px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        padding: 0 18px;
        border: 1px solid transparent;
        white-space:nowrap;
        gap: 10px;
        width: 100%;
    }
    .btn-row{ display:flex; gap: 12px; }
    @media (max-width: 480px){
        .btn-row{ flex-direction:column; }
    }

    .btn-grad{
        background: linear-gradient(90deg, #0b3a82 0%, #0e5bd8 55%, #10b981 120%);
        color:#fff;
        box-shadow: 0 12px 26px rgba(14, 91, 216, .18);
    }
    .btn-grad:hover{ filter: brightness(.97); color:#fff; }
    .btn-outline{
        background:#fff;
        border-color:#0ea5e9;
        color:#0ea5e9;
    }
    .btn-outline:hover{ background:#f0fbff; }

    /* Tabs */
    .hp-tabs{
        margin-top: 22px;
        background:#fff;
        border:1px solid #eef2f7;
        border-radius: 16px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, .06);
        padding: 14px 16px 18px;
    }
    .tab-head{
        display:flex;
        gap: 26px;
        border-bottom: 1px solid #eef2f7;
        padding: 0 4px;
    }
    .tab-btn{
        background:transparent;
        border:0;
        padding: 12px 0;
        font-weight:700;
        font-size: 13px;
        color:#94a3b8;
        position:relative;
        cursor:pointer;
    }
    .tab-btn.active{
        color:#0e5bd8;
    }
    .tab-btn.active::after{
        content:"";
        position:absolute;
        left:0; right:0; bottom:-1px;
        height:2px;
        background:#0e5bd8;
        border-radius: 2px;
    }
    .tab-body{ padding: 16px 4px 0; }

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
        border: 1px solid #eef2f7;
        border-radius: 12px;
        background:#fbfdff;
        padding: 12px 14px;
    }
    .spec-row{
        display:flex;
        justify-content:space-between;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #eef2f7;
        font-size: 13px;
    }
    .spec-row:last-child{ border-bottom:0; }
    .spec-row .k{ color:#0f172a; font-weight:700; }
    .spec-row .v{ color:#64748b; text-align:right; }

    /* Reviews placeholder */
    .reviews-empty{
        color:#64748b;
        font-size: 13px;
    }
</style>
@endsection

@section('content')
<main class="hp-main">
    <div class="hp-wrap">

        {{-- Breadcrumb --}}
        <div class="hp-bc">
            <a href="{{ route('vendor/products') }}">{{ __('nav.products') ?? 'Products' }}</a>
            <span class="sep">›</span>
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
                    @endphp

                    @if($firstImg)
                        <img id="mainPreview" src="{{ asset('storage/' . $firstImg) }}" alt="{{ $product->name }}">
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
                    <div class="thumbs" id="thumbsWrap">
                        @foreach($thumbs as $idx => $img)
                            <div class="thumb {{ $idx==0 ? 'active' : '' }}" data-src="{{ asset('storage/' . $img) }}">
                                <img src="{{ asset('storage/' . $img) }}" alt="thumb">
                            </div>
                        @endforeach
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
                            {{ $product->provider->location ?? '—' }}
                        </p>
                    </div>
                </div>

                <div class="price">
                    {{ number_format((float)($product->price ?? 0), 0) }} {{ app()->getLocale()=='ar' ? 'ر.س' : 'SAR' }}
                </div>

                <div class="btn-row">
                    <a href="{{ route('vendor/products/edit', $product->id) }}" class="btn-hp btn-grad">
                        {{ app()->getLocale()=='ar' ? 'تعديل' : 'Edit' }}
                    </a>

                    <form action="{{ route('vendor/products/delete', $product->id) }}" method="POST"
                          onsubmit="return confirm('{{ app()->getLocale()=='ar' ? 'هل تريد حذف هذا المنتج؟' : 'Delete this product?' }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-hp btn-outline">
                            {{ app()->getLocale()=='ar' ? 'حذف' : 'Delete' }}
                        </button>
                    </form>
                </div>
            </div>

        </div>

        {{-- Tabs --}}
        <div class="hp-tabs">
            <div class="tab-head">
                <button type="button" class="tab-btn active" data-tab="specs">
                    {{ app()->getLocale()=='ar' ? 'المواصفات' : 'Specifications' }}
                </button>
                <button type="button" class="tab-btn" data-tab="reviews">
                    {{ app()->getLocale()=='ar' ? 'التقييمات والمراجعات' : 'Ratings & Reviews' }}
                </button>
            </div>

            <div class="tab-body">
                {{-- Specifications --}}
                <div id="tab-specs" class="tab-pane">
                    <div class="spec-grid">
                        <div class="spec-box">
                            <div class="spec-row">
                                <div class="k">Imaging Type:</div>
                                <div class="v">{{ $product->imaging_type ?? '—' }}</div>
                            </div>
                            <div class="spec-row">
                                <div class="k">Production Date (MFG):</div>
                                <div class="v">{{ $product->manufacture_date ? \Carbon\Carbon::parse($product->manufacture_date)->format('Y-m-d') : '—' }}</div>
                            </div>
                            <div class="spec-row">
                                <div class="k">Weight:</div>
                                <div class="v">{{ $product->weight ?? '—' }}</div>
                            </div>
                        </div>

                        <div class="spec-box">
                            <div class="spec-row">
                                <div class="k">Dimensions:</div>
                                <div class="v">{{ $product->dimensions ?? '—' }}</div>
                            </div>
                            <div class="spec-row">
                                <div class="k">Warranty:</div>
                                <div class="v">{{ $product->warranty ?? '—' }}</div>
                            </div>
                            <div class="spec-row">
                                <div class="k">Expiry Date:</div>
                                <div class="v">{{ $product->expiry_date ? \Carbon\Carbon::parse($product->expiry_date)->format('Y-m-d') : '—' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Reviews --}}
                <div id="tab-reviews" class="tab-pane" style="display:none;">
                    <div class="reviews-empty">
                        {{ app()->getLocale()=='ar'
                            ? 'سيتم عرض التقييمات والمراجعات هنا.'
                            : 'Ratings & Reviews will appear here.' }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection

@section('scripts')
<script>
    // thumbs -> main image
    (function(){
        const thumbs = document.querySelectorAll('.thumb');
        const main = document.getElementById('mainPreview');
        thumbs.forEach(t => {
            t.addEventListener('click', function(){
                thumbs.forEach(x => x.classList.remove('active'));
                t.classList.add('active');
                if(main) main.src = t.getAttribute('data-src');
            });
        });

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
    })();
</script>
@endsection
