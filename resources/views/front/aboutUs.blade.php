@extends('layouts.front.home')

<!-- title page -->
@section('title')
    <title>{{ __('about.title') }}</title>
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
        position: relative;
        overflow: hidden;
        padding-left: 9% !important;
        padding-right: 9% !important;
        padding-top: 4% !important;
        padding-bottom: 8% !important;
    }
    .about-intro-row,
    .about-feature-row {
        position: relative;
        z-index: 2;
    }
    .about-text-col {
        margin-top: 3rem !important;
    }
    .about-image-stack {
        margin-top: 3rem;
    }
    .text-muted-soft {
        color: #6f7d92 !important;
        font-size: 20px;
        line-height: 1.55;
    }
    .hp-img-vert {
        width: 345px;
        height: 520px;
        border-radius: 22px;
        object-fit: cover;
    }
    .side-img {
        position: absolute;
        left: 0;
        bottom: 10px;
        z-index: 0;
        opacity: .85;
        pointer-events: none;
    }
    .line-img-1 {
        position: absolute;
        right: 0;
        left: 0;
        top: 38%;
        width: 100%;
        height: 76%;
        z-index: 0;
        opacity: .42;
        pointer-events: none;
    }
    .line-img-2 {
        position: absolute;
        left: 0;
        width: 188%;
        height: -webkit-fill-available;
        top: 5%;
        z-index: 0;
        opacity: .42;
        pointer-events: none;
    }
    .line-img-3 {
        position: absolute;
        left: 0;
        width: 100%;
        height: -webkit-fill-available;
        top: 26%;
        z-index: 0;
        opacity: .42;
        pointer-events: none;
    }
    .line-img-4 {
        position: absolute;
        width: 20%;
        top: 0;
        right: 0;
        height: 34%;
        z-index: 0;
        opacity: .42;
        pointer-events: none;
    }
    .line-img-5 {
        position: absolute;
        width: 40%;
        top: 0;
        right: 0;
        height: 93%;
        z-index: 0;
        opacity: .42;
        pointer-events: none;
    }
    @media (max-width: 991.98px) {
        .about-text-col {
            margin-top: 0 !important;
        }
        .about-image-stack {
            margin-top: 0;
            justify-content: center !important;
        }
        .hp-img-vert {
            width: 100%;
            max-width: 320px;
            height: 400px;
        }
        .text-muted-soft {
            font-size: 18px;
        }
    }
    @media (max-width: 575.98px) {
        .text-muted-soft {
            font-size: 16px;
            line-height: 1.6;
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
                        <span class="eyebrow text-uppercase text-white-50"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-up">{{ __('about.hero_eyebrow') }}</span>
                        <h1 class="display-5 fw-semibold mb-3 text-white"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-up" data-aos-delay="50">{{ __('about.hero_title') }}</h1>
                        <p class="lead text-white-70 mb-4"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-up" data-aos-delay="100">
                            {{ __('about.hero_desc') }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="hp-curves" dir="ltr">
            <div class="custom-container">
                <div class="row g-4 align-items-start about-intro-row">
                    <div class="col-lg-6 about-text-col" data-aos-once="false" data-aos-mirror="true" data-aos="fade-right">
                        {{-- <h4 class="fw-bold mb-3"><span class="text-primary">Who</span> we <span class="hp-green">are</span></h4> --}}
                        <h4 class="fw-bold mb-3"><span class="" style="color: #287d6c; font-size: 36px;">{{ __('about.who_we_are') }}</span></h4>
                        <p class="text-muted-soft">
                            {{ __('about.who_p1') }}
                        </p>
                        <p class="text-muted-soft">
                            {{ __('about.who_p2') }}
                        </p>
                        <p class="text-muted-soft mb-0">
                            {{ __('about.who_p3') }}
                        </p>
                    </div>
                    <div class="col-lg-6" data-aos-once="false" data-aos-mirror="true" data-aos="fade-left">
                        <div class="d-flex gap-3 justify-content-lg-end about-image-stack">
                            <img class="hp-img-vert" src="{{ asset('front/assets/images/close-up-individual-checking-delivery-list 1.png') }}" alt="Medical facility">
                            <img style="margin-top: 10% !important;" class="hp-img-vert second-img" src="{{ asset('front/assets/images/healthcare-worker-protective-gear-handling-medical-supplies-packaging-healthcare-facility-focus-safety-precision 1.png') }}" alt="Team collaboration">
                        </div>
                    </div>
                </div>

                <img class="line-img-5" src="{{ asset('front/assets/images/Vector 1.png') }}" alt="Medical facility">
                <img class="line-img-4" src="{{ asset('front/assets/images/Vector 5.png') }}" alt="Medical facility">
                <img class="line-img-3" src="{{ asset('front/assets/images/Vector 2.png') }}" alt="Medical facility">
                <img class="line-img-2" src="{{ asset('front/assets/images/Vector 3.png') }}" alt="Medical facility">
                <img class="line-img-1" src="{{ asset('front/assets/images/Vector 4.png') }}" alt="Medical facility">
                <img class="side-img" src="{{ asset('front/assets/images/Group 1000002405.png') }}" alt="Medical facility">
                <div class="row g-3 g-lg-4 mt-4 about-feature-row" style="margin-top: 6% !important;" data-aos-once="false" data-aos-mirror="true" data-aos="zoom-in" data-aos-delay="200">
                    <div class="col-lg-6">
                        <div class="hp-feature card h-100" style="padding: 12px;" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                            <div class="card-body p-4 d-flex gap-3">
                                <div style="margin-top: 11px;">
                                    <div class="row" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                                        <div class="col-1">
                                            {{-- <div class="hp-bullet"><i class="bi bi-bullseye"></i></div> --}}
                                            <img src="{{ asset('front/assets/images/fi_1628615.png') }}" alt="Medical facility">
                                        </div>
                                        <div class="col-6">
                                            <h6 class="fw-semibold mb-1 title-hp-bullet">{{ __('about.our_mission') }}</h6>
                                        </div>
                                    </div>
                                    <p class="small text-muted-soft mb-0" style="margin-top: 12px;">
                                        {{ __('about.mission_desc') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="hp-feature card h-100" style="padding: 12px;" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                            <div class="card-body p-4 d-flex gap-3">
                                <div style="margin-top: 11px;">
                                    <div class="row" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                                        <div class="col-1">
                                            {{-- <div class="hp-bullet"><i class="bi bi-brightness-high"></i></div> --}}
                                            <img src="{{ asset('front/assets/images/fi_11259269.png') }}" alt="Medical facility">
                                        </div>
                                        <div class="col-6">
                                            <h6 class="fw-semibold mb-1 title-hp-bullet">{{ __('about.our_vision') }}</h6>
                                        </div>
                                    </div>
                                    <p class="small text-muted-soft mb-0" style="margin-top: 12px;">
                                        {{ __('about.vision_desc') }}
                                    </p>
                                </div>
                            </div>
                        </div>
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
        $('#nav-aboutUs').addClass('active');
    });
</script>
@endsection
