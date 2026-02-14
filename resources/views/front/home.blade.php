@extends('layouts.front.home')

<!-- title page -->
@section('title')
    <title>{{ __('home.title') }}</title>
@endsection

<!-- custom page -->
@section('css')
<style>
    .rq-card {
        display:block; text-align:center; padding:22px 18px; border-radius:16px;
        background:#fff; box-shadow:0 6px 24px rgba(16,24,40,.06);
        transition:transform .15s, box-shadow .15s; color:inherit;
    }
    .rq-card:hover{ transform:translateY(-2px); box-shadow:0 10px 28px rgba(16,24,40,.10); }
    .rq-icon{
        width:64px; height:64px; margin:0 auto 12px; border-radius:16px;
        background:linear-gradient(180deg,#eef6ff,#f2fbf7); position:relative;
        display:flex; align-items:center; justify-content:center; color:#0b63ce;
    }
    .rq-icon .bi-cash-coin{ font-size:28px; }
    .rq-icon .thumb{ position:absolute; right:6px; bottom:6px; font-size:16px; color:#0b63ce; opacity:.85; }
    .rq-title{ margin:8px 0 4px; font-weight:700; color:#1f2937; }
    .rq-sub{ font-size:.92rem; margin:0; }
    .modal-content { padding: 20px; }
    .input-group .select2-container--default .select2-selection--single{
        height: 100%; min-height: 38px; border: 1px solid #ced4da; border-left: 0; 
        border-radius: 0 .375rem .375rem 0; display: flex; align-items: center;
    }
    .input-group .select2-container--default .select2-selection__rendered{ 
        line-height: 1.5; padding-left: .75rem; padding-right: 2rem; 
    }
    .input-group .select2-container--default .select2-selection__arrow{ height: 100%; right: .5rem; }
    .input-group .input-group-text{ min-height: 38px; }
</style>
@endsection

@section('content')

    <main>
        <section id="hero" class="hero-landing hero-home" style="background-image:url({{ asset('front/assets/images/still-life-ophthalmologist-s-office1.png') }});">
            <div class="container position-relative">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-xl-6">
                        <span class="eyebrow text-uppercase text-white-50"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-up">{{ __('home.hero_eyebrow') }}</span>
                        <h1 class="display-5 fw-semibold mb-3 text-white"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-up" data-aos-delay="50">{{ __('home.hero_title') }}</h1>
                        <p class="lead text-white-70 mb-4"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-up" data-aos-delay="100">
                            {{ __('home.hero_description') }}
                        </p>
                        <div class="d-flex flex-wrap gap-3"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-up" data-aos-delay="200">
                            <a href="#" class="btn btn-gradient px-4 py-2">{{ __('home.hero_btn_explore') }}</a>
                            <a href="#" class="btn btn-outline-light px-4 py-2">{{ __('home.hero_btn_maintenance') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('flash::message')
        @if ($errors->any())
            <div style="text-align: left; margin: 15px;">
                <ul dir="ltr">
                    @foreach ($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section id="services" class="section-padding services-section">
            <div class="container">
                <div class="section-heading section-heading-center text-center"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-up">
                    <span class="eyebrow eyebrow-custom">{{ __('home.services_title') }}</span>
                </div>
                <div class="row g-4 mt-1">
                    <div class="col-md-4"  data-aos-once="false" data-aos-mirror="true" data-aos="zoom-in">
                        <a href="{{ route('products') }}" class="rq-card text-decoration-none">
                            <div class="hp-service-card h-100 text-center mt-3">
                                <div class="rq-icon">
                                    <span class="hp-service-icon">
                                        <img class="img-fluid rounded-4 shadow-lg" src="{{ asset('front/assets/images/icon3_transparent.png') }}" alt="{{ __('home.service_shopping_title') }}">
                                    </span>
                                </div>
                                <h6 class="rq-title">{{ __('home.service_shopping_title') }}</h6>
                                <p class="rq-sub text-muted">{{ __('home.service_shopping_desc') }}</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4"  data-aos-once="false" data-aos-mirror="true" data-aos="zoom-in" data-aos-delay="100">
                        <a href="#" class="rq-card text-decoration-none" data-bs-toggle="modal" data-bs-target="#rqModal">
                            <div class="hp-service-card h-100 text-center mt-3" style="padding: 44px 30px;">
                                <div class="rq-icon">
                                    <span class="hp-service-icon">
                                        <img class="img-fluid rounded-4 shadow-lg" src="{{ asset('front/assets/images/icon2_transparent.png') }}" alt="{{ __('home.service_quotation_title') }}">
                                    </span>
                                </div>
                                <h6 class="rq-title">{{ __('home.service_quotation_title') }}</h6>
                                <p class="rq-sub text-muted">
                                    {{ __('home.service_quotation_desc') }}
                                </p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4"  data-aos-once="false" data-aos-mirror="true" data-aos="zoom-in" data-aos-delay="200">
                        <a href="#" class="rq-card text-decoration-none" data-bs-toggle="modal" data-bs-target="#mtModal">
                            <div class="hp-service-card h-100 text-center mt-3" style="padding: 44px 30px;">
                                <div class="rq-icon">
                                    <span class="hp-service-icon">
                                        <img class="img-fluid rounded-4 shadow-lg" src="{{ asset('front/assets/images/icon1_transparent.png') }}" alt="{{ __('home.service_maintenance_title') }}">
                                    </span>
                                </div>
                                <h6 class="rq-title">{{ __('home.service_maintenance_title') }}</h6>
                                <p class="rq-sub text-muted">{{ __('home.service_maintenance_desc') }}</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="rqModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content border-0 rounded-3">
                        <div class="modal-header border-0">
                            <h5 class="modal-title">{{ __('home.modal_quotation_title') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('user/quotations/store') }}" enctype="multipart/form-data" id="quotations-request">
                            @csrf

                            <div class="modal-body">
                                <div class="row g-3">

                                    <div class="col-12">
                                        <label class="form-label d-block mb-2">{{ __('home.select_request_type') }} <span class="text-danger">*</span></label>
                                        <div class="d-flex flex-column gap-2">
                                            <label class="form-check">
                                                <input class="form-check-input request-type-input" type="radio" name="request_type" value="1" checked>
                                                <span class="form-check-label">{{ __('home.immediate_request') }}</span>
                                            </label>
                                            <label class="form-check">
                                                <input class="form-check-input request-type-input" type="radio" name="request_type" value="2">
                                                <span class="form-check-label">{{ __('home.scheduled_request') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">{{ __('home.supplier') }} <span class="text-muted">({{ __('home.optional') }})</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-people"></i></span>
                                            <select class="form-select" name="provider_id" id="providers" style="width: 100%">
                                                <option value="">{{ __('home.select_supplier') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">{{ __('home.attach_file') }}</label>
                                        <div class="border rounded p-3 text-center position-relative">
                                            <input type="file" name="files[]" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.webp,.webm" multiple>
                                            <small class="text-muted d-block mt-2">{{ __('home.attach_hint') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">{{ __('home.note') }}</label>
                                        <textarea name="notes" class="form-control" rows="4" placeholder="{{ __('home.write_note') }}"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('home.date_time_picker') }}</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                                            <input type="datetime-local" name="date_time_picker" class="form-control" placeholder="{{ __('home.select_date_time') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('home.location') }}</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                            <input type="text" name="address" class="form-control" placeholder="{{ __('home.enter_address') }}">
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <label class="form-label">Budget <span class="text-muted">(Optional)</span></label>
                                        <div class="input-group">
                                            <input type="number" name="budget" step="0.01" class="form-control" placeholder="Enter estimated budget">
                                            <span class="input-group-text">SAR</span>
                                        </div>
                                    </div> --}}

                                    <!-- Scheduled section -->
                                    <div id="scheduled-fields" class="border rounded-3 p-3" style="display: none;">
                                        <h6 class="mb-3">{{ __('home.scheduled_fields_title') }}</h6>

                                        <div class="mb-3">
                                            <label class="form-label">{{ __('home.delivery_duration') }}</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-clock-history"></i></span>
                                                <input type="text" class="form-select" name="delivery_duration">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">{{ __('home.frequency') }}</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-repeat"></i></span>
                                                <input type="text" class="form-select" name="frequency">
                                            </div>
                                        </div>

                                        <div class="mb-1">
                                            <label class="form-label">{{ __('home.start_date') }}</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                                                <input type="date" class="form-control" name="schedule_start_date" placeholder="Date Picker">
                                            </div>
                                        </div>

                                        <small class="text-muted">{{ __('home.scheduled_hint') }}</small>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('home.cancel') }}</button>
                                <button type="submit" class="btn btn-gradient">
                                    <i class="bi bi-send-fill me-1"></i> {{ __('home.submit_request') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="mtModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content border-0 rounded-3">
                        <div class="modal-header border-0">
                            <h5 class="modal-title">{{ __('home.modal_maintenance_title') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('user/maintenances/store') }}" enctype="multipart/form-data" id="maintenances-request">
                            @csrf

                            <div class="modal-body pt-0">
                                <div class="col-12">
                                    <label class="form-label">{{ __('home.supplier') }} <span class="text-muted">({{ __('home.optional') }})</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-people"></i></span>
                                        <select class="form-select" name="provider_id" id="providers2" style="width: 100%">
                                            <option value="">{{ __('home.select_supplier') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">{{ __('home.category') }} <span class="text-muted">({{ __('home.optional') }})</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-diagram-3-fill"></i></span>
                                        <select class="form-select" name="device_category_id" id="device_categories" style="width: 100%">
                                            <option value="">{{ __('home.select_category') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small text-muted mb-1">{{ __('home.device_name') }} <span class="text-danger">*</span></label>
                                    <input name="device_name" type="text" class="form-control" placeholder="{{ __('home.enter_device_name') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small text-muted mb-1">{{ __('home.serial_number') }}</label>
                                    <input name="serial_number" type="text" class="form-control" placeholder="{{ __('home.enter_serial') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small text-muted mb-1">{{ __('home.issue_description') }}</label>
                                    <textarea name="issue_description" class="form-control" rows="3" placeholder="{{ __('home.describe_issue') }}"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small text-muted mb-1">{{ __('home.upload_media') }}</label>
                                    <div class="border rounded-3 p-4 text-center bg-light">
                                        <input name="files[]" class="form-control" type="file" id="issueFiles" multiple accept="image/*,video/*">
                                        <div class="small text-muted mt-2">{{ __('home.upload_media_hint') }}</div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small text-muted mb-1">{{ __('home.device_location') }}</label>
                                    <input name="address" type="text" class="form-control" placeholder="{{ __('home.enter_location') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small text-muted mb-1">{{ __('home.preferred_time') }}</label>
                                    <div class="position-relative">
                                        <input name="preferred_service_time" type="datetime-local" class="form-control pe-5">
                                        <i class="bi bi-calendar3 position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('home.cancel') }}</button>
                                <button type="submit" class="btn btn-gradient">
                                    <i class="bi bi-send-fill me-1"></i> {{ __('home.submit_request') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section id="how" class="section-padding how-section">
            <div class="container">
                <div class="section-heading section-heading-center mb-3"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-right">
                    <span class="eyebrow eyebrow-custom">{{ __('home.how_title') }}</span>
                </div>
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6">
                        <ul class="hp-checklist mt-4">
                            <li class="how-it-works-tabs"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-up" data-aos-delay="0">
                                <span class="hp-check-icon"><i class="bi bi-check2"></i></span>
                                <div>
                                    <h6 class="mb-1">{{ __('home.how_step1_title') }}</h6>
                                    <p class="text-muted mb-0 small">{{ __('home.how_step1_desc') }}</p>
                                </div>
                            </li>
                            <li class="how-it-works-tabs"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-up" data-aos-delay="80">
                                <span class="hp-check-icon"><i class="bi bi-check2"></i></span>
                                <div>
                                    <h6 class="mb-1">{{ __('home.how_step2_title') }}</h6>
                                    <p class="text-muted mb-0 small">{{ __('home.how_step2_desc') }}</p>
                                </div>
                            </li>
                            <li class="how-it-works-tabs"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-up" data-aos-delay="160">
                                <span class="hp-check-icon"><i class="bi bi-check2"></i></span>
                                <div>
                                    <h6 class="mb-1">{{ __('home.how_step3_title') }}</h6>
                                    <p class="text-muted mb-0 small">{{ __('home.how_step3_desc') }}</p>
                                </div>
                            </li>
                            <li class="how-it-works-tabs"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-up" data-aos-delay="160">
                                <span class="hp-check-icon"><i class="bi bi-check2"></i></span>
                                <div>
                                    <h6 class="mb-1">{{ __('home.how_step4_title') }}</h6>
                                    <p class="text-muted mb-0 small">{{ __('home.how_step4_desc') }}</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-left">
                        <img class="img-fluid rounded-4 shadow-lg how-it-works-img" src="{{ asset('front/assets/images/man-special-equipment-surfing-hawaii 1.png') }}" alt="Healthcare logistics">
                        {{-- <div class="how-image-wrap">
                            <img class="img-fluid rounded-4 shadow-lg" src="{{ asset('front/assets/images/man-special-equipment-surfing-hawaii 1.png') }}" alt="Healthcare logistics">
                        </div> --}}
                    </div>
                </div>
            </div>
        </section>

        @isset($report['categories'])
            <section id="new-categories" class="section section--pad-lg reveal mt-5 mb-5">
                <div class="container">

                    <!-- Header -->
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h2 class="nc-title m-0">{{ __('home.categories_title') }} <span>{{ __('home.categories_highlight') }}</span></h2>
                        <div class="d-flex gap-2">
                            <button class="nc-arrow" data-bs-target="#newCatCarousel" data-bs-slide="prev" aria-label="Prev">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <button class="nc-arrow" data-bs-target="#newCatCarousel" data-bs-slide="next" aria-label="Next">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Slider -->
                    <div id="newCatCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="7000" data-aos-once="false" data-aos-mirror="true" data-aos="fade-up" data-aos-delay="100">
                        <div class="carousel-inner">

                            <!-- Slide 1 -->
                            @foreach (collect($report['categories'])->chunk(3) as $g => $chunk)
                                <div class="carousel-item {{ $g === 0 ? 'active' : '' }}">
                                    <div class="row g-4">
                                        @foreach ($chunk as $category)
                                            <div class="col-md-4">
                                                <a class="nc-card" href="{{ route('categoryProducts', [$category->id]) }}">
                                                    <div class="nc-card__media">
                                                        <img src="{{ asset($category->img) }}" alt="{{ $category->name }}">
                                                        <span class="nc-card__overlay"></span>
                                                    </div>
                                                    <div class="nc-card__title">{{ $category->name }}</div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <!-- See More -->
                    <div class="text-center mt-4">
                        <a href="{{ route('categories') }}" class="nc-btn-outline" style="text-decoration: none;">{{ __('home.see_more') }}</a>
                    </div>
                </div>
            </section>
        @endisset

        <section id="new-banar" class="nb new-banar-fonts">
            <div class="nb__bg" style="background-image:url({{ asset('front/assets/images/doctor-is-analyzing-treatment.png') }});"></div>
            <div class="nb__hex"></div>
            <div class="container position-relative">
                <div class="row justify-content-center">
                    <div class="col-11 col-lg-9 text-center">
                        <h2 class="nb__title">{{ __('home.banner_title') }}</h2>
                        <p class="nb__subtitle"> 
                            {{ __('home.banner_desc') }}
                        </p>
                        <a href="#" class="nb-btn" aria-label="View Offers" style="text-decoration: none;"><span>{{ __('home.view_offers') }}</span></a>
                    </div>
                </div>
            </div>
        </section>

        @isset($report['featured'])
            <section id="popular" class="section-padding popular-section bg-white">
                <div class="container">
                    <div class="row align-items-end mb-4">
                        <div class="col-md-8">
                            <span class="section-tag text-uppercase">{{ __('home.popular_tag') }}</span>
                            <h2 class="section-title mt-2">{{ __('home.popular_title') }}</h2>
                            <p class="section-subtitle mt-2 mb-0 text-muted-soft">{{ __('home.popular_desc') }}</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <a href="{{ route('products') }}" class="btn btn-outline-success px-4">{{ __('home.see_all_products') }}</a>
                        </div>
                    </div>
                    <div class="row g-4">

                        @foreach($report['featured'] as $i => $product)
                            {{-- <div class="col-md-6 col-lg-4">
                                <article class="equipment-card h-100"  data-aos-once="false" data-aos-mirror="true" data-aos="{{ $product->name }}">
                                    <img src="{{ asset($product->img) }}" class="equipment-card__image" alt="Digital X-Ray">
                                    <div class="equipment-card__body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1">{{ $product->name }}</h6>
                                                <span class="badge bg-light text-primary fw-semibold">{{ $product?->category->name }}</span>
                                            </div>
                                            <span class="rating-badge">
                                                <i class="bi bi-star-fill me-1"></i>
                                                {{ substr(number_format((float) $product->ratings_avg_rating, 1, '.', ''), 0) }}
                                            </span>
                                        </div>
                                        <p class="text-muted small mb-3">{{ $product->desc }}</p>
                                        <div class="d-flex align-items-center">
                                            <span class="equipment-price me-3">{{ $product->price }} SAR</span>

                                            <button class="hp-pill-btn ms-auto me-2" title="Add to cart"><i class="bi bi-cart-plus-fill"></i></button>
                                            <a href="{{ route('product', [$product->id]) }}" class="btn btn-gradient btn-sm px-3 me-2">{{ __('home.details') }}</a>
                                        </div>
                                    </div>
                                </article>
                            </div> --}}

                            <div class="col-md-6 col-lg-4">
                                <article class="equipment-card h-100"  data-aos-once="false" data-aos-mirror="true" data-aos="zoom-in" data-aos-delay="100" data-aos="{{ $product->name }}">
                                    {{-- <img src="{{ asset($product->img) }}" class="equipment-card__image" alt="Digital X-Ray"> --}}
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $product->img) }}" class="equipment-card__image" alt="{{ $product->name }}">
                                        @if (is_null($product->is_favorite))
                                            <button class="wishlist-btn btn p-0 position-absolute top-0 end-0 m-2" data-id="{{ $product->id }}" aria-label="Add to wishlist">
                                                <i class="bi bi-heart fs-5"></i>
                                            </button>
                                        @else
                                            <button class="wishlist-btn btn p-0 position-absolute top-0 end-0 m-2 active" data-id="{{ $product->id }}" aria-label="Add to wishlist">
                                                <i class="bi fs-5 bi-heart-fill"></i>
                                            </button>
                                        @endif
                                    </DIV>
                                    <div class="equipment-card__body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1">{{ $product->name }}</h6>
                                                <span class="badge bg-light text-primary fw-semibold">{{ $product?->category->name }}</span>
                                            </div>
                                            <span class="rating-badge">
                                                <i class="bi bi-star-fill me-1"></i>
                                                {{ substr(number_format((float) $product->ratings_avg_rating, 1, '.', ''), 0) }}
                                            </span>
                                        </div>
                                        <p class="text-muted small mb-3">{{ $product->desc }}</p>
                                        <div class="d-flex align-items-center">
                                            <span class="equipment-price me-3">{{ $product->price }} SAR</span>

                                            <button class="hp-pill-btn ms-auto me-2 add-to-cart" data-id="{{ $product->id }}" data-img="{{ asset('storage/' . $product->img) }}" title="Add to cart">
                                                <i class="bi bi-cart-plus-fill"></i>
                                            </button>
                                            <a href="{{ route('product', [$product->id]) }}" class="btn btn-gradient btn-sm px-3 me-2">{{ __('home.details') }}</a>
                                        </div>
                                    </div>
                                </article>
                            </div>


                        @endforeach

                    </div>
                </div>
            </section>
        @endisset
        
        <!-- =================== New Downloads =================== -->
        <section id="new-downloads" class="ndl">
            <div class="container">
                <div class="ndl__wrap">
                    <!-- Card Left -->
                    <div class="ndl__card">
                        <h3 class="ndl__title">{!! __('home.download_title') !!}</h3>
                        <p class="ndl__desc">{{ __('home.download_desc') }}</p>
                        <div class="ndl__stores">
                        <a href="#" class="ndl__store">
                            <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="App Store">
                        </a>
                        <a href="#" class="ndl__store">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play">
                        </a>
                        </div>
                    </div>

                    <!-- Phones Right -->
                    <div class="ndl__scene">
                        <div class="ndl__tray"></div>
                        <div class="ndl__phones">
                        {{-- <img class="ndl__phone ndl__phone--left" src="https://dummyimage.com/260x520/ffffff/cccccc.png&text=App+UI" alt="app left"> --}}
                        <img class="ndl__phone ndl__phone--center" src="{{ asset('front/assets/images/Group 1171275716.png') }}" alt="app center">
                        {{-- <img class="ndl__phone ndl__phone--right" src="https://dummyimage.com/260x520/ffffff/cccccc.png&text=RFQ+Form" alt="app right"> --}}
                        </div>
                        <div class="ndl__decor">
                            <span></span><span></span><span></span><span></span><span></span>
                            {{-- <img class="group-5-icon" src="{{ asset('front/assets/images/Group 5.png') }}" alt="app right"> --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== FAQ ===== -->
        <section id="faq" class="section section--pad-lg reveal">
            <div class="container-sm">
                <p class="faq-head text-center">FA<span class="special-q">Q</span></p>
                <p class="text-center text-muted mb-4 small">{{ __('home.faq_subtitle') }}</p>
                <div class="faq-box mx-auto">
                    <div class="accordion accordion-clean" id="faqAcc">
                        <div class="accordion-item faq-item">
                            <h2 class="accordion-header" id="q1">
                                <button class="accordion-button faq-item__btn" type="button" data-bs-toggle="collapse" data-bs-target="#a1" aria-expanded="true">
                                    <span class="faq-item__text">{{ __('home.faq_q1') }}</span>
                                    <span class="faq-item__badge faq-item__badge--active"><i class="bi bi-check-lg"></i></span>
                                </button>
                            </h2>
                            <div id="a1" class="accordion-collapse collapse show" data-bs-parent="#faqAcc">
                                <div class="accordion-body faq-item__body">{{ __('home.faq_a1') }}</div>
                            </div>
                        </div>
                        <div class="accordion-item faq-item">
                            <h2 class="accordion-header" id="q2">
                                <button class="accordion-button collapsed faq-item__btn" type="button" data-bs-toggle="collapse" data-bs-target="#a2">
                                    <span class="faq-item__text">{{ __('home.faq_q2') }}</span>
                                    <span class="faq-item__badge"><i class="bi bi-info-lg"></i></span>
                                </button>
                            </h2>
                            <div id="a2" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
                                <div class="accordion-body faq-item__body">{{ __('home.faq_a2') }}</div>
                            </div>
                        </div>
                        <div class="accordion-item faq-item">
                            <h2 class="accordion-header" id="q3">
                                <button class="accordion-button collapsed faq-item__btn" type="button" data-bs-toggle="collapse" data-bs-target="#a3">
                                    <span class="faq-item__text">{{ __('home.faq_q3') }}</span>
                                    <span class="faq-item__badge"><i class="bi bi-info-lg"></i></span>
                                </button>
                            </h2>
                            <div id="a3" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
                                <div class="accordion-body faq-item__body">{{ __('home.faq_a3') }}</div>
                            </div>
                        </div>
                        <div class="accordion-item faq-item">
                            <h2 class="accordion-header" id="q4">
                                <button class="accordion-button collapsed faq-item__btn" type="button" data-bs-toggle="collapse" data-bs-target="#a4">
                                    <span class="faq-item__text">{{ __('home.faq_q4') }}</span>
                                    <span class="faq-item__badge"><i class="bi bi-info-lg"></i></span>
                                </button>
                            </h2>
                            <div id="a4" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
                                <div class="accordion-body faq-item__body">{{ __('home.faq_a4') }}</div>
                            </div>
                        </div>
                        <div class="accordion-item faq-item">
                            <h2 class="accordion-header" id="q5">
                                <button class="accordion-button collapsed faq-item__btn" type="button" data-bs-toggle="collapse" data-bs-target="#a5">
                                    <span class="faq-item__text">{{ __('home.faq_q5') }}</span>
                                    <span class="faq-item__badge"><i class="bi bi-info-lg"></i></span>
                                </button>
                            </h2>
                            <div id="a5" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
                                <div class="accordion-body faq-item__body">{{ __('home.faq_a5') }}</div>
                            </div>
                        </div>
                        <div class="accordion-item faq-item">
                            <h2 class="accordion-header" id="q6">
                                <button class="accordion-button collapsed faq-item__btn" type="button" data-bs-toggle="collapse" data-bs-target="#a6">
                                    <span class="faq-item__text">{{ __('home.faq_q6') }}</span>
                                    <span class="faq-item__badge"><i class="bi bi-info-lg"></i></span>
                                </button>
                            </h2>
                            <div id="a6" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
                                <div class="accordion-body faq-item__body">{{ __('home.faq_a6') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @isset($report['ratings'])
            <section id="clients" class="clients-wrap section section--pad-lg reveal" dir="ltr">
                <div class="clients-blob pulse" style="bottom: 6px;left: 88%;"></div>
                <div class="container-testimonials position-relative" style="top: 96px;height: 463px;">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-3">
                            <h2 class="section-title">
                                <h2 class="clients-title text-center">
                                    <span class="clients-title__muted">{{ __('home.clients_title_1') }} </span>
                                    <span class="clients-title__color">{{ __('home.clients_title_2') }}</span>
                                    <span class="clients-title__muted">{{ __('home.clients_title_3') }}</span>
                                </h2>   
                            </h2>
                        </div>
                        <div class="col-lg-9">
                            <div class="row g-4 mt-2 justify-content-center">
                                <!-- Slider -->
                                <div id="newCatCarouselTestimonials" class="carousel slide" data-bs-ride="carousel" data-bs-interval="7000">
                                    <div class="carousel-inner">

                                        @foreach (collect($report['ratings'])->chunk(2) as $g => $chunk)
                                            <div class="carousel-item {{ $g === 0 ? 'active' : '' }}" style="padding: 20px 0px 20px 20px;">
                                                <div class="row g-4">
                                                    @foreach ($chunk as $i => $rating)
                                                        @php
                                                            $user = $rating?->user;
                                                            $raw = (float) ($rating->rating ?? 0);
                                                            $val = (int) round( max(0, min(5, $raw)) );
                                                        @endphp
                                                        <div class="col-lg-6 position-relative" style="@if($i == 2) padding-right: 0px; @endif">
                                                            <div class="testi-card anim-pop">
                                                                <div class="testi-card__stars mb-2">
                                                                    {{-- <i class="bi bi-star-fill"></i>
                                                                    <i class="bi bi-star-fill"></i>
                                                                    <i class="bi bi-star-fill"></i>
                                                                    <i class="bi bi-star-fill"></i>
                                                                    <i class="bi bi-star-half"></i> --}}
                                                                    @for ($i = 0; $i < $val; $i++)
                                                                        <i class="bi bi-star-fill"></i>
                                                                    @endfor
                                                                    @for ($i = 0; $i < 5 - $val; $i++)
                                                                        <i class="bi bi-star"></i>
                                                                    @endfor
                                                                </div>
                                                                <p class="testi-card__text mb-2">
                                                                    {{-- <strong>Great Experience</strong><br> --}}
                                                                    {{ $rating->comment }}
                                                                </p>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <img class="avatar" src="{{ optional($user)->img ? asset(optional($user)->img) : 'https://i.pravatar.cc/60?img=31' }}" alt="">
                                                                    <div>
                                                                        <div class="fw-semibold">{{ optional($user)->name ?? 'user' }}</div>
                                                                        <small class="text-muted">{{ optional($user)->location ?? 'King Fahd Hospital, Riyadh' }}</small>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            <div class="in-card-arrows">
                                <div class="d-flex gap-2">
                                    <button class="nc-arrow" data-bs-target="#newCatCarouselTestimonials" data-bs-slide="prev" aria-label="Prev">
                                        <i class="bi bi-chevron-left"></i>
                                    </button>
                                    <button class="nc-arrow" data-bs-target="#newCatCarouselTestimonials" data-bs-slide="next" aria-label="Next">
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endisset
    </main>
        
@endsection
<!-- custom js -->
@section('script')

<script>

    $(function(){
        $('#nav-home').addClass('active');
        const $nc = $('#newCatCarousel'); 
        $nc.on('mouseenter', function(){
            bootstrap.Carousel.getOrCreateInstance(this).pause();
        }).on('mouseleave', function(){
            bootstrap.Carousel.getOrCreateInstance(this).cycle();
        });

        const revealNC = () => {
            const el = document.getElementById('new-categories');
            if(!el) return;
            const r = el.getBoundingClientRect();
            const inView = r.top < window.innerHeight * 0.86 && r.bottom > 0;
            if(inView) el.classList.add('in-view');
        };
        revealNC();
        window.addEventListener('scroll', revealNC, {passive:true});

        
        const $header = $('.js-sticky');
        const onScroll = () => {
            if (window.scrollY > 10) $header.addClass('scrolled');
            else $header.removeClass('scrolled');
        };
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });

        const reveal = () => {
            $('.reveal').each(function () {
                const rect = this.getBoundingClientRect();
                const inView = rect.top < window.innerHeight * 0.86 && rect.bottom > 0;
                if (inView) this.classList.add('in-view');
            });
        };
        reveal();
        window.addEventListener('scroll', reveal, { passive: true });

        $('#faqAcc').on('show.bs.collapse', function (e) {
            const $btn = $(e.target).prev().find('.faq-item__btn');
            $btn.find('.faq-item__badge').addClass('faq-item__badge--active').html('<i class="bi bi-check-lg"></i>');
        });
        $('#faqAcc').on('hide.bs.collapse', function (e) {
            const $btn = $(e.target).prev().find('.faq-item__btn');
            $btn.find('.faq-item__badge').removeClass('faq-item__badge--active').html('<i class="bi bi-info-lg"></i>');
        });

        $('.in-card-arrows .in-arrow').on('click', function(e){
            e.preventDefault();
            $(this).addClass('clicked');
            setTimeout(()=>$(this).removeClass('clicked'),150);
        });

        $(document).on('change', '.request-type-input', function (){
            if($(this).val() == 2) {
                $('#scheduled-fields').css('display', 'block');
            } else {
                $('#scheduled-fields').css('display', 'none');
            }
        })
        
        const $modalquotations = $('#quotations-request');
        const $modalmaintenances = $('#maintenances-request');
        $('#providers').select2({
            ajax: {
                url: `{{ route('user/get/providers',[0,10]) }}`,
                dataType: 'json',
                delay: 250,
                data: params => ({ q: params.term }),
                processResults: function (data) {
                    const items = Array.isArray(data.data) ? data.data : [];
                    return {
                        results: items.map(item => ({
                        id: item.id,
                        text: item.name
                    }))};
                },
                cache: true
            },
            width: '90%',
            allowClear: true,
            dropdownParent: $modalquotations,
            placeholder: 'Select Supplier',
        });
        $('#providers2').select2({
            ajax: {
                url: `{{ route('user/get/providers',[0,10]) }}`,
                dataType: 'json',
                delay: 250,
                data: params => ({ q: params.term }),
                processResults: function (data) {
                    const items = Array.isArray(data.data) ? data.data : [];
                    return {
                        results: items.map(item => ({
                        id: item.id,
                        text: item.name
                    }))};
                },
                cache: true
            },
            width: '90%',
            allowClear: true,
            dropdownParent: $modalmaintenances,
            placeholder: 'Select Supplier',
        });
        $('#device_categories').select2({
            ajax: {
                url: `{{ route('user/get/categories',[0,10]) }}`,
                dataType: 'json',
                delay: 250,
                data: params => ({ q: params.term }),
                processResults: function (data) {
                    const items = Array.isArray(data.data) ? data.data : [];
                    return {
                        results: items.map(item => ({
                        id: item.id,
                        text: item.name
                    }))};
                },
                cache: true
            },
            width: '90%',
            allowClear: true,
            dropdownParent: $modalmaintenances,
            placeholder: 'Select Supplier',
        });
    });

</script>

@endsection
