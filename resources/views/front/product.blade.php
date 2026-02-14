@extends('layouts.front.home')

<!-- title page -->
@section('title')
    <title>{{ __('products.products_title') }}</title>
@endsection

<!-- custom page -->
@section('css')
    <style>
        .thumbs-scroll{ overflow-x:auto; scroll-behavior:smooth; -ms-overflow-style:none; scrollbar-width:none; }
        .thumbs-scroll::-webkit-scrollbar{ display:none; }
        .hp-thumb{ width:110px; height:70px; object-fit:cover; border-radius:12px; flex:0 0 auto; }

        .new-ratings {
        --blue: #1f3bff;
        --track: #e9ecef;
        --gold: #ffc107;
        --text-muted: #6c757d;
        --title: #0b0c0d;
        --card-border: #e8e8e8;
        --card-shadow: 0 2px 10px rgba(0,0,0,.05);
        --radius: 14px;
        }

        /
        .new-ratings .rating-value{
        font-weight: 700;
        font-size: 56px;
        line-height: 1;
        color: var(--title);
        }
        .new-ratings .rating-count{
        color: var(--text-muted);
        font-size: 14px;
        }
        .new-ratings .rating-stars i{
        color: var(--gold);
        font-size: 18px;
        }

        .new-ratings .rating-row{
        display: grid;
        grid-template-columns: 24px 1fr 48px;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        font-size: 14px;
        }
        .new-ratings .rating-row .label{
        color: #111;
        font-weight: 600;
        }
        .new-ratings .rating-row .percent{
        color: var(--text-muted);
        text-align: right;
        }
        .new-ratings .bar{
        position: relative;
        height: 8px;
        background: var(--track);
        border-radius: 999px;
        overflow: hidden;
        }
        .new-ratings .bar > span{
        position: absolute;
        left: 0; top: 0; bottom: 0;
        background: var(--blue);
        border-radius: inherit;
        }

        .new-ratings .testi-card{
        border: 1px solid var(--card-border);
        border-radius: var(--radius);
        padding: 22px 22px;
        background: #fff;
        box-shadow: var(--card-shadow);
        }
        .new-ratings .testi-card .stars i{
        color: var(--gold);
        font-size: 16px;
        }
        .new-ratings .testi-card h6{
        margin: 0;
        font-weight: 700;
        color: #222;
        letter-spacing: .2px;
        }
        .new-ratings .testi-card p{
        color: #4b4f56;
        margin: 10px 0 14px;
        line-height: 1.6;
        }
        .new-ratings .person{
        display: flex;
        align-items: center;
        gap: 12px;
        }
        .new-ratings .person img{
        width: 42px; height: 42px;
        border-radius: 50%;
        object-fit: cover;
        }
        .new-ratings .person strong{
        display: block;
        font-size: 14px;
        color: #111;
        }
        .new-ratings .person small{
        display: block;
        font-size: 12px;
        color: var(--text-muted);
        }

        @media (min-width: 992px){
        .new-ratings .rating-summary{padding-right: 24px;}
        }
        .hp-thumb.is-active{ outline:2px solid #3b82f6; border-radius:10px; }

    </style>
@endsection

@section('content')

    <main class="hp-main">
        <section class="py-4">

            @isset($product)
                <div class="container">
                    <nav class="hp-breadcrumb small mb-3">
                        <a href="{{ route('categories') }}" class="hp-crumb">{{ __('products.categories') }}</a>
                        <i class="bi bi-chevron-right"></i>
                        <a href="{{ route('categoryProducts', [$product->category_id]) }}" class="hp-crumb">{{ $product?->category->name }}</a>
                        <i class="bi bi-chevron-right"></i>
                        <span class="hp-crumb text-body-secondary">{{ $product->name }}</span>
                    </nav>

                    <div class="row g-4">
                        <div class="col-lg-7">
                            <div class="hp-product-view card overflow-hidden mb-3">
                                <img id="pd-main" src="{{ asset('storage/' . $product->img) }}" class="w-100" alt="{{ $product?->category->name }}">
                            </div>
                            
                            <div class="d-flex align-items-center justify-content-between">
                                <button id="thumbPrev" class="btn btn-outline-secondary btn-sm rounded-4 hp-prev" aria-label="Previous image"><i class="bi bi-chevron-left"></i></button>
                                <div id="thumbs" class="d-flex gap-2 thumbs-scroll mx-3">
                                    <img class="hp-thumb" src="{{ asset('storage/' . $product->img) }}" alt="Thumbnail 1">
                                    @foreach ($product->imgs as $i => $img)
                                        @if (!$img == "")
                                            <img class="hp-thumb" src="{{ asset('storage/' . $img) }}" alt="Thumbnail {{ $i+2 }}">
                                        @endif
                                    @endforeach
                                </div>
                                <button id="thumbNext" class="btn btn-outline-secondary btn-sm rounded-4 hp-next" aria-label="Next image"><i class="bi bi-chevron-right"></i></button>
                            </div>

                        </div>

                        <div class="col-lg-5">
                            <h4 class="fw-bold mb-2">{{ $product->name }}</h4>
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-2">{{ $product?->category->name }}</span>
                                <span class="text-warning small"><i class="bi bi-star-fill me-1"></i>
                                    {{ substr(number_format((float) $product->ratings_avg_rating, 1, '.', ''), 0) }} 
                                    ({{ count($product?->ratings) }})
                                </span>
                            </div>
                            <p class="text-muted-soft">{{ $product->desc }}</p>
                            <div class="small mb-3">
                                <span class="fw-semibold">{{ __('products.stock_status') }}:</span>
                                <a href="#" class="hp-link">{{ $product->stock_quantity }} {{ __('products.units_available') }}</a>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-4">
                                <img src="{{ $product?->provider->img && !is_null($product?->provider->img) ? $product?->provider->img : 'https://i.pravatar.cc/44?img=13' }}" class="rounded-circle" width="44" height="44" alt="Supplier avatar">
                                <div class="small">
                                    <div class="fw-semibold">{{ $product?->provider->name }}</div>
                                    <div class="text-muted-soft">{{ $product?->provider->location }}</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    {{-- <div class="text-muted-soft small">Starting price</div> --}}
                                    <div class="h4 mb-0">{{ $product->price }} SAR</div>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-gradient px-4">{{ __('products.add_to_cart') }}</a>
                                    {{-- <button class="hp-pill-btn ms-auto me-2 add-to-cart" data-id="{{ $product->id }}" data-img="{{ asset($product->img) }}" title="Add to cart">
                                        <i class="bi bi-cart-plus-fill"></i>
                                    </button> --}}
                                    {{-- <a href="#" class="btn btn-ghost px-4">Request Quote</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-tabs hp-tabs mt-4" id="pdTabs" role="tablist">
                        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-specs" type="button">{{ __('products.specifications') }}</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#new-tab-reviews" type="button">{{ __('products.ratings_reviews') }}</button></li>
                    </ul>

                    <div class="tab-content hp-tab-content mt-3" id="pdTabContent">
                        <div class="tab-pane fade show active" id="tab-specs">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="hp-spec">
                                        <span class="text-muted-soft">{{ __('products.imaging_type') }}:</span>
                                        <span class="fw-semibold">{{ $product->imaging_type }}</span>
                                    </div>
                                    <div class="hp-spec">
                                        <span class="text-muted-soft">{{ __('products.power') }}:</span>
                                        <span class="fw-semibold">{{ $product->power }}</span>
                                    </div>
                                    <div class="hp-spec">
                                        <span class="text-muted-soft">{{ __('products.weight') }}:</span>
                                        <span class="fw-semibold">{{ $product->weight }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="hp-spec">
                                        <span class="text-muted-soft">{{ __('products.dimensions') }}:</span>
                                        <span class="fw-semibold">{{ $product->dimensions }}</span>
                                    </div>
                                    <div class="hp-spec">
                                        <span class="text-muted-soft">{{ __('products.warranty') }}:</span>
                                        <span class="fw-semibold">{{ $product->warranty }}</span>
                                    </div>
                                    <div class="hp-spec">
                                        <span class="text-muted-soft">{{ __('products.origin') }}:</span>
                                        <span class="fw-semibold">{{ $product->origin?->name ?? '' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="new-tab-reviews">
                            <section id="new-ratings" class="new-ratings py-5">
                                <div class="container">
                                    <div class="row g-4 align-items-start">
                                        <div class="col-lg-12">
                                            <div class="rating-summary">
                                                <div class="d-flex align-items-end gap-2">
                                                    <span class="rating-value">{{ substr(number_format((float) $product->ratings_avg_rating, 1, '.', ''), 0) }}</span>
                                                </div>
                                                <div class="rating-count mt-1">({{ count($product?->ratings) }}) {{ __('products.reviews') }}</div>
                                                @php
                                                    $total = max(1, $product->ratings->count());
                                                    $counts = $product->ratings->groupBy('rating')->map->count();
                                                    $dist = collect([5,4,3,2,1])->map(function ($star) use ($counts, $total) {
                                                        $count = (int) ($counts[$star] ?? 0);
                                                        $pct   = round(($count / $total) * 100);
                                                        return ['count' => $count, 'pct' => $pct];
                                                    })->keyBy(function($v,$k){ return [5,4,3,2,1][$k]; });
                                                    $raw_ratings_avg_rating = (float) (substr(number_format((float) $product->ratings_avg_rating, 1, '.', ''), 0) ?? 0);
                                                    $val_ratings_avg_rating = (int) round( max(0, min(5, $raw_ratings_avg_rating)) );
                                                @endphp
                                                <div class="rating-stars mt-2" aria-label="4.5 out of 5">
                                                    {{-- <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-half"></i> --}}
                                                    @for ($i = 0; $i < $val_ratings_avg_rating; $i++)
                                                        <i class="bi bi-star-fill"></i>
                                                    @endfor
                                                    @for ($i = 0; $i < 5 - $val_ratings_avg_rating; $i++)
                                                        <i class="bi bi-star"></i>
                                                    @endfor
                                                </div>

                                                <!-- Bars -->
                                                <div class="rating-rows mt-4">
                                                    <!-- row -->
                                                    {{-- <div class="rating-row">
                                                        <span class="label">5</span>
                                                        <div class="bar"><span style="width:80%"></span></div>
                                                        <span class="percent">80%</span>
                                                    </div>
                                                    <div class="rating-row">
                                                        <span class="label">4</span>
                                                        <div class="bar"><span style="width:72%"></span></div>
                                                        <span class="percent">72%</span>
                                                    </div>
                                                    <div class="rating-row">
                                                        <span class="label">3</span>
                                                        <div class="bar"><span style="width:50%"></span></div>
                                                        <span class="percent">50%</span>
                                                    </div>
                                                    <div class="rating-row">
                                                        <span class="label">2</span>
                                                        <div class="bar"><span style="width:21%"></span></div>
                                                        <span class="percent">21%</span>
                                                    </div>
                                                    <div class="rating-row">
                                                        <span class="label">1</span>
                                                        <div class="bar"><span style="width:10%"></span></div>
                                                        <span class="percent">10%</span>
                                                    </div> --}}
                                                    @foreach ([5,4,3,2,1] as $star)
                                                        <div class="rating-row">
                                                            <span class="label">{{ $star }}</span>
                                                            <div class="bar">
                                                                <span style="width: {{ $dist[$star]['pct'] ?? 0 }}%"></span>
                                                            </div>
                                                            <span class="percent">{{ $dist[$star]['pct'] ?? 0 }}%</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="row g-3">
                                                @foreach ($product->top_rating as $rating)
                                                    @php
                                                        $user = $rating?->user;
                                                        $raw = (float) ($rating->rating ?? 0);
                                                        $val = (int) round( max(0, min(5, $raw)) );
                                                    @endphp
                                                    <div class="col-6">
                                                        <div class="testi-card">
                                                            <div class="stars mb-2">
                                                                {{-- <i class="bi bi-star-fill"></i>
                                                                <i class="bi bi-star-fill"></i>
                                                                <i class="bi bi-star-fill"></i>
                                                                <i class="bi bi-star-fill"></i>
                                                                <i class="bi bi-star"></i> --}}
                                                                @for ($i = 0; $i < $val; $i++)
                                                                    <i class="bi bi-star-fill"></i>
                                                                @endfor
                                                                @for ($i = 0; $i < 5 - $val; $i++)
                                                                    <i class="bi bi-star"></i>
                                                                @endfor
                                                            </div>
                                                            {{-- <h6 class="mb-2">{{ $rating?->user->name }}</h6> --}}
                                                            <p class="mb-3">{{ $rating->comment }}</p>
                                                            <div class="person">
                                                                <img src="{{ $user->img ? asset($user->img) : 'https://i.pravatar.cc/80?img=12' }}" alt="avatar">
                                                                <div>
                                                                    <strong>{{ $user->name }}</strong>
                                                                    <small>{{ $user->location }}</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>

                    <h5 class="fw-bold mt-5 mb-3">{{ __('products.explore_similar') }} <span class="hp-green">{{ __('products.products') }}</span></h5>
                    <div class="row g-3 g-lg-4">
                        @foreach ($product->related_products as $related)
                            <div class="col-md-6 col-lg-4">
                                <article class="equipment-card h-100"  data-aos-once="false" data-aos-mirror="true" data-aos="{{ $related->name }}">
                                    {{-- <img src="{{ asset($related->img) }}" class="equipment-card__image" alt="Digital X-Ray"> --}}
                                    <div class="position-relative">
                                        <img src="{{ asset($related->img) }}" class="equipment-card__image" alt="{{ $related->name }}">
                                        @if (is_null($related->is_favorite))
                                            <button class="wishlist-btn btn p-0 position-absolute top-0 end-0 m-2" data-id="{{ $related->id }}" aria-label="Add to wishlist">
                                                <i class="bi bi-heart fs-5"></i>
                                            </button>
                                        @else
                                            <button class="wishlist-btn btn p-0 position-absolute top-0 end-0 m-2 active" data-id="{{ $related->id }}" aria-label="Add to wishlist">
                                                <i class="bi fs-5 bi-heart-fill"></i>
                                            </button>
                                        @endif
                                    </DIV>
                                    <div class="equipment-card__body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1">{{ $related->name }}</h6>
                                                <span class="badge bg-light text-primary fw-semibold">{{ $product?->category->name }}</span>
                                            </div>
                                            <span class="rating-badge">
                                                <i class="bi bi-star-fill me-1"></i>
                                                {{ substr(number_format((float) $related->ratings_avg_rating, 1, '.', ''), 0) }}
                                            </span>
                                        </div>
                                        <p class="text-muted small mb-3">{{ $related->desc }}</p>
                                        <div class="d-flex align-items-center">
                                            <span class="equipment-price me-3">{{ $related->price }} SAR</span>

                                            <button class="hp-pill-btn ms-auto me-2" title="Add to cart"><i class="bi bi-cart-plus-fill"></i></button>
                                            <a href="{{ route('product', [$related->id]) }}" class="btn btn-gradient btn-sm px-3 me-2">{{ __('products.details') }}</a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endisset

        </section>
    </main>
        
@endsection

<!-- custom js -->
@section('script')
<script>
$(function () {
    $('#nav-categories').addClass('active');
    const $thumbsBox = $('#thumbs');
    const $thumbs    = $thumbsBox.find('.hp-thumb');
    const $main      = $('#pd-main');

    if (!$thumbs.length) return;

    let idx = 0;

    function setActive(newIdx){
        idx = (newIdx + $thumbs.length) % $thumbs.length;
        const src = $thumbs.eq(idx).attr('src');
        $main.attr('src', src);
        $thumbs.removeClass('is-active').eq(idx).addClass('is-active').get(0).scrollIntoView({inline:'center', block:'nearest', behavior:'smooth'});
    }

    setActive(0);
    $thumbsBox.on('click', '.hp-thumb', function(){
        setActive($(this).index());
    });

    $('#thumbPrev').on('click', function(e){ e.preventDefault(); setActive(idx - 1); });
    $('#thumbNext').on('click', function(e){ e.preventDefault(); setActive(idx + 1); });
});
</script>
@endsection
