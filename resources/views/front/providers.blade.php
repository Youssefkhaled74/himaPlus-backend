@extends('layouts.front.home')

<!-- title page -->
@section('title')
    <title>{{ __('providers.title') }}</title>
@endsection

<!-- custom page -->
@section('css')
<style>
    .title-hp-bullet {
        margin-top: 9px;
        margin-left: 13px;
        font-size: 20px;
    }
    .custom-container {
        padding-left: 9% !important;
        padding-right: 9% !important;
        padding-bottom: 8% !important;
    }
    .text-muted-soft {
        color: #6f7d92 !important;
        font-size: 22px;
    }
    .hp-img-vert {
        width: 345px;
        height: 520px;
    }
    .side-img {
        position: absolute;
        left: 0;
        bottom: 10px;
    }
    .line-img-1 {
        position: absolute;
        right: 0;
        left: 0;
        top: 38%;
        width: 100%;
        height: 76%;
    }
    .line-img-2 {
        position: absolute;
        left: 0;
        width: 188%;
        height: -webkit-fill-available;
        top: 5%;
    }
    .line-img-3 {
        position: absolute;
        left: 0;
        width: 100%;
        height: -webkit-fill-available;
        top: 26%;
    }
    .line-img-4 {
        position: absolute;
        width: 20%;
        top: 0;
        right: 0;
        height: 34%;
    }
    .line-img-5 {
        position: absolute;
        width: 40%;
        top: 0;
        right: 0;
        height: 93%;
    }
    .nb-btn-outline {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 190px;
        height: 42px;
        padding: 0 18px;
        border-radius: 8px;
        color: #fff;
        font-weight: 700;
        background: transparent;
        border: 2px solid rgba(255, 255, 255, 0.7);
        transition: all 0.2s ease;
    }
    .nb-btn-outline:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: #fff;
        color: #fff;
    }
    #new-banar .nb__title {
        white-space: nowrap;
    }
    .new-banar-fonts .nb__title {
        letter-spacing: 0;
    }
    @media (max-width: 768px) {
        #new-banar .nb__title {
            white-space: normal;
            font-size: 1.5rem;
        }
        #new-banar .nb__subtitle {
            font-size: 0.95rem;
        }
        #new-banar .nb-btn,
        #new-banar .nb-btn-outline {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 250px;
            margin: 0 auto 10px auto;
        }
        #new-banar .nb-btn.me-3 {
            margin-right: auto !important;
        }
    }
</style>
@endsection

@section('content')

    <main>

        <section id="hero" class="hero-landing hero-home" style="background-image:url({{ asset('front/assets/images/men-girls-are-surfing.png') }});">
            <div class="container position-relative">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-xl-6">
                        <span class="eyebrow text-uppercase text-white-50"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-up">{{ __('providers.hero_eyebrow') }}</span>
                        <h1 class="display-5 fw-semibold mb-3 text-white"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-up" data-aos-delay="50">{{ __('providers.hero_title') }}</h1>
                        <p class="lead text-white-70 mb-4"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-up" data-aos-delay="100">
                            {{ __('providers.hero_desc') }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section id="new-categories" class="section section--pad-lg mt-5 mb-5">
            <div class="container">

                <!-- Header -->
                <div class="text-center mb-4">
                    <h2 class="nc-title m-0" style="font-size: 40px;"><span>{{ __('providers.who_can_join') }}</span></h2>
                    <p class="mt-2 mb-0" style="color: #0F254A; font-weight: 500;">{{ __('providers.who_can_join_sub') }}</p>
                </div>

                <!-- Cards -->
                <div class="row g-4">
                    <div class="col-md-4" data-aos="fade-up" data-aos-once="false" data-aos-mirror="true">
                        <a class="nc-card" href="#">
                            <div class="nc-card__media">
                                <img src="{{ asset('front/assets/images/empty-medical-office-with-desktop-pc 11111.png') }}" alt="Medical Suppliers">
                                <span class="nc-card__overlay"></span>
                            </div>
                            <div class="nc-card__title">{{ __('providers.medical_suppliers') }}</div>
                        </a>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-once="false" data-aos-mirror="true" data-aos-delay="100">
                        <a class="nc-card" href="#">
                            <div class="nc-card__media">
                                <img src="{{ asset('front/assets/images/acoustic-engineering-hospitals-minimize-noise-pollution 1.png') }}" alt="Medical Suppliers">
                                <span class="nc-card__overlay"></span>
                            </div>
                            <div class="nc-card__title">{{ __('providers.pharmaceutical_companies') }}</div>
                        </a>
                    </div>
                    <div class="col-md-4" data-aos="fade-up" data-aos-once="false" data-aos-mirror="true" data-aos-delay="200">
                        <a class="nc-card" href="#">
                            <div class="nc-card__media">
                                <img src="{{ asset('front/assets/images/hospital-lab-with-sterile-test-tubes-glass-vials-sample-analysis 2.png') }}" alt="Medical Suppliers">
                                <span class="nc-card__overlay"></span>
                            </div>
                            <div class="nc-card__title">{{ __('providers.medical_logistics') }}</div>
                        </a>
                    </div>
                </div>

                <!-- See More -->
                <div class="text-center mt-4">
                    <a href="{{ route('user/loginForm') }}" class="nc-btn-outline" style="text-decoration: none;">{{ __('providers.join_with_us') }}</a>
                </div>
            </div>
        </section>

        <section id="services" class="section-padding services-section">
            <div class="container">
                <div class="section-heading section-heading-center text-center"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-up">
                    <span class="eyebrow eyebrow-custom">{{ __('providers.our_services') }}</span>
                </div>
                <div class="row g-4 mt-1">
                    <div class="col-md-4"  data-aos-once="false" data-aos-mirror="true" data-aos="zoom-in">
                        <a href="{{ route('products') }}" class="rq-card text-decoration-none">
                            <div class="hp-service-card h-100 text-center mt-3">
                                <div class="rq-icon">
                                    <span class="hp-service-icon">
                                        <img class="img-fluid rounded-4 shadow-lg" src="{{ asset('front/assets/images/icon3_transparent.png') }}" alt="{{ __('providers.product_listing') }}">
                                    </span>
                                </div>
                                <h6 class="rq-title">{{ __('providers.product_listing') }}</h6>
                                <p class="rq-sub text-muted">{{ __('providers.product_listing_desc') }}</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4"  data-aos-once="false" data-aos-mirror="true" data-aos="zoom-in" data-aos-delay="100">
                        <a href="#" class="rq-card text-decoration-none" data-bs-toggle="modal" data-bs-target="#rqModal">
                            <div class="hp-service-card h-100 text-center mt-3" style="padding: 44px 30px;">
                                <div class="rq-icon">
                                    <span class="hp-service-icon">
                                        <img class="img-fluid rounded-4 shadow-lg" src="{{ asset('front/assets/images/icon2_transparent.png') }}" alt="{{ __('providers.receive_requests') }}">
                                    </span>
                                </div>
                                <h6 class="rq-title">{{ __('providers.receive_requests') }}</h6>
                                <p class="rq-sub text-muted">{{ __('providers.receive_requests_desc') }}</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4"  data-aos-once="false" data-aos-mirror="true" data-aos="zoom-in" data-aos-delay="200">
                        <a href="#" class="rq-card text-decoration-none" data-bs-toggle="modal" data-bs-target="#mtModal">
                            <div class="hp-service-card h-100 text-center mt-3" style="padding: 44px 30px;">
                                <div class="rq-icon">
                                    <span class="hp-service-icon">
                                        <img class="img-fluid rounded-4 shadow-lg" src="{{ asset('front/assets/images/icon1_transparent.png') }}" alt="{{ __('providers.secure_payments') }}">
                                    </span>
                                </div>
                                <h6 class="rq-title">{{ __('providers.secure_payments') }}</h6>
                                <p class="rq-sub text-muted">{{ __('providers.secure_payments_desc') }}</p>
                            </div>
                        </a>
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
                            <li class="how-it-works-tabs" data-aos-once="false" data-aos-mirror="true" data-aos="fade-up" data-aos-delay="0">
                                <span class="hp-check-icon"><i class="bi bi-check2"></i></span>
                                <div>
                                    <h6 class="mb-1">{{ __('providers.step1_title') }}</h6>
                                    <p class="text-muted mb-0 small">{{ __('providers.step1_desc') }}</p>
                                </div>
                            </li>
                            <li class="how-it-works-tabs" data-aos-once="false" data-aos-mirror="true" data-aos="fade-up" data-aos-delay="80">
                                <span class="hp-check-icon"><i class="bi bi-check2"></i></span>
                                <div>
                                    <h6 class="mb-1">{{ __('providers.step2_title') }}</h6>
                                    <p class="text-muted mb-0 small">{{ __('providers.step2_desc') }}</p>
                                </div>
                            </li>
                            <li class="how-it-works-tabs" data-aos-once="false" data-aos-mirror="true" data-aos="fade-up" data-aos-delay="160">
                                <span class="hp-check-icon"><i class="bi bi-check2"></i></span>
                                <div>
                                    <h6 class="mb-1">{{ __('providers.step3_title') }}</h6>
                                    <p class="text-muted mb-0 small">{{ __('providers.step3_desc') }}</p>
                                </div>
                            </li>
                            <li class="how-it-works-tabs" data-aos-once="false" data-aos-mirror="true" data-aos="fade-up" data-aos-delay="160">
                                <span class="hp-check-icon"><i class="bi bi-check2"></i></span>
                                <div>
                                    <h6 class="mb-1">{{ __('providers.step4_title') }}</h6>
                                    <p class="text-muted mb-0 small">{{ __('providers.step4_desc') }}</p>
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

        <section id="new-downloads" class="ndl">
            <div class="container">
                <div class="ndl__wrap">
                    <!-- Card Left -->
                    <div class="ndl__card" data-aos="fade-right" data-aos-once="false" data-aos-mirror="true">
                        <h3 class="ndl__title">{!! __('providers.download_title') !!}</h3>
                        <p class="ndl__desc">
                            {{ __('providers.download_desc') }}
                        </p>
                        <div class="ndl__stores">
                        <a href="#" class="ndl__store">
                            <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="App Store">
                        </a>
                        <a href="#" class="ndl__store">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play">
                        </a>
                        </div>
                    </div>

                    <div class="ndl__scene" data-aos="fade-left" data-aos-once="false" data-aos-mirror="true" data-aos-delay="100">
                        <div class="ndl__tray"></div>
                        <div class="ndl__phones">
                        <img class="ndl__phone ndl__phone--center" src="{{ asset('front/assets/images/Group 1171275716.png') }}" alt="app center">
                        </div>
                        <div class="ndl__decor">
                            <span></span><span></span><span></span><span></span><span></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="new-banar" class="nb new-banar-fonts">
            <div class="nb__bg" style="background-image:url({{ asset('front/assets/images/doctor-is-analyzing-treatment.png') }});"></div>
            <div class="nb__hex"></div>
            <div class="container position-relative">
                <div class="row justify-content-center">
                    <div class="col-11 col-lg-9 text-center">
                        <h2 class="nb__title">{{ __('providers.banner_title') }}</h2>
                        <p class="nb__subtitle">
                            {{ __('providers.banner_desc') }}
                        </p>
                        <a href="{{ route('user/loginForm') }}" class="nb-btn me-3" aria-label="{{ __('providers.register_now') }}" style="text-decoration: none;"><span>{{ __('providers.register_now') }}</span></a>
                        <a href="{{ route('contactUs') }}" class="nb-btn-outline" aria-label="{{ __('providers.contact_us') }}" style="text-decoration: none;"><span>{{ __('providers.contact_us') }}</span></a>
                    </div>
                </div>
            </div>
        </section>

    </main>
        
@endsection

<!-- custom js -->
@section('script')
<script>
    $(function(){
        $('#nav-providers').addClass('active');
    });
</script>
@endsection
