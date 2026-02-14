@extends('layouts.front.home')

<!-- title page -->
@section('title')
    <title>HemaPulse - Smart Medical Procurement</title>
@endsection

<!-- custom page -->
@section('css')
@endsection

@section('content')

    <main>
        <section id="hero" class="hero-landing hero-home" style="background-image:url({{ asset('front/assets/images/still-life-ophthalmologist-s-office1.png') }});">
            <div class="container position-relative">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-xl-6">
                        <span class="eyebrow text-uppercase text-white-50" data-aos="fade-up">Smart Healthcare Marketplace</span>
                        <h1 class="display-5 fw-semibold mb-3 text-white" data-aos="fade-up" data-aos-delay="50">Your Smart Medical Procurement Platform</h1>
                        <p class="lead text-white-70 mb-4" data-aos="fade-up" data-aos-delay="100">
                            Request quotations, manage maintenance, and connect with trusted suppliers across Saudi Arabia.
                        </p>
                        <div class="d-flex flex-wrap gap-3" data-aos="fade-up" data-aos-delay="200">
                            <a href="#" class="btn btn-gradient px-4 py-2">Explore Marketplace</a>
                            <a href="#" class="btn btn-outline-light px-4 py-2">Request Maintenance</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="services" class="section-padding services-section">
            <div class="container">
                <div class="section-heading section-heading-center text-center" data-aos="fade-up">
                    <span class="eyebrow eyebrow-custom">Our Services</span>
                </div>
                <div class="row g-4 mt-1">
                    <div class="col-md-4" data-aos="zoom-in">
                        <div class="hp-service-card h-100 text-center">
                            <span class="hp-service-icon">
                                {{-- <i class="bi bi-bag-check"></i> --}}
                                <img class="img-fluid rounded-4 shadow-lg" src="{{ asset('front/assets/images/icon3_transparent.png') }}" alt="Direct Shopping">
                            </span>
                            <h5 class="mt-3">Direct Shopping</h5>
                            <p class="text-muted">Browse ready-to-buy medical products from trusted suppliers and order instantly with secure payment.</p>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                        <div class="hp-service-card h-100 text-center">
                            <span class="hp-service-icon">
                                {{-- <i class="bi bi-receipt"></i> --}}
                                <img class="img-fluid rounded-4 shadow-lg" src="{{ asset('front/assets/images/icon2_transparent.png') }}" alt="Request Quotation">
                            </span>
                            <h5 class="mt-3">Request Quotation</h5>
                            <p class="text-muted">Send one request and get multiple offers — compare prices and choose what suits you best.”</p>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                        <div class="hp-service-card h-100 text-center">
                            <span class="hp-service-icon">
                                {{-- <i class="bi bi-tools"></i> --}}
                                <img class="img-fluid rounded-4 shadow-lg" src="{{ asset('front/assets/images/icon1_transparent.png') }}" alt="Maintenance Request">
                            </span>
                            <h5 class="mt-3">Maintenance Request</h5>
                            <p class="text-muted">Easily request maintenance for your medical devices and monitor every step until it’s fixed.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="how" class="section-padding how-section">
            <div class="container">
                <div class="section-heading section-heading-center mb-3" data-aos="fade-right">
                    <span class="eyebrow eyebrow-custom">How It Works</span>
                </div>
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6">
                        <ul class="hp-checklist mt-4">
                            <li class="how-it-works-tabs" data-aos="fade-up" data-aos-delay="0">
                                <span class="hp-check-icon"><i class="bi bi-check2"></i></span>
                                <div>
                                    <h6 class="mb-1">Submit Your Request</h6>
                                    <p class="text-muted mb-0 small">Send a detailed request for the medical products or maintenance services you need — all from your dashboard.</p>
                                </div>
                            </li>
                            <li class="how-it-works-tabs" data-aos="fade-up" data-aos-delay="80">
                                <span class="hp-check-icon"><i class="bi bi-check2"></i></span>
                                <div>
                                    <h6 class="mb-1">Receive Multiple Offers</h6>
                                    <p class="text-muted mb-0 small">Get quotations from multiple trusted suppliers. Compare prices, delivery times, and warranties before making a decision.</p>
                                </div>
                            </li>
                            <li class="how-it-works-tabs" data-aos="fade-up" data-aos-delay="160">
                                <span class="hp-check-icon"><i class="bi bi-check2"></i></span>
                                <div>
                                    <h6 class="mb-1">Review & Accept</h6>
                                    <p class="text-muted mb-0 small">Evaluate offers side by side, negotiate if needed, and accept the one that best fits your needs.</p>
                                </div>
                            </li>
                            <li class="how-it-works-tabs" data-aos="fade-up" data-aos-delay="160">
                                <span class="hp-check-icon"><i class="bi bi-check2"></i></span>
                                <div>
                                    <h6 class="mb-1">Track Your Order</h6>
                                    <p class="text-muted mb-0 small">Monitor your order or maintenance request in real time — from confirmation to completion.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6" data-aos="fade-left">
                        <img class="img-fluid rounded-4 shadow-lg how-it-works-img" src="{{ asset('front/assets/images/man-special-equipment-surfing-hawaii 1.png') }}" alt="Healthcare logistics">
                        {{-- <div class="how-image-wrap">
                            <img class="img-fluid rounded-4 shadow-lg" src="{{ asset('front/assets/images/man-special-equipment-surfing-hawaii 1.png') }}" alt="Healthcare logistics">
                        </div> --}}
                    </div>
                </div>
            </div>
        </section>

        
        <section id="new-categories" class="section section--pad-lg reveal mt-5 mb-5">
            <div class="container">

                <!-- Header -->
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="nc-title m-0">Our <span>Categories</span></h2>
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
                <div id="newCatCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="7000">
                    <div class="carousel-inner">

                        <!-- Slide 1 -->
                        <div class="carousel-item active">
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <a class="nc-card" href="#">
                                        <div class="nc-card__media">
                                            <img src="https://images.unsplash.com/photo-1584988299601-c10fa8d93d2b?q=80&w=1600&auto=format&fit=crop" alt="">
                                            <span class="nc-card__overlay"></span>
                                        </div>
                                        <div class="nc-card__title">Medical Devices</div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a class="nc-card" href="#">
                                        <div class="nc-card__media">
                                            <img src="https://images.unsplash.com/photo-1582714320637-6cfb0c0d3b3e?q=80&w=1600&auto=format&fit=crop" alt="">
                                            <span class="nc-card__overlay"></span>
                                        </div>
                                        <div class="nc-card__title">Pharmaceuticals</div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a class="nc-card" href="#">
                                        <div class="nc-card__media">
                                            <img src="https://images.unsplash.com/photo-1581093588401-16f8b8a9a21a?q=80&w=1600&auto=format&fit=crop" alt="">
                                            <span class="nc-card__overlay"></span>
                                        </div>
                                        <div class="nc-card__title">Lab Equipment</div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 2 -->
                        <div class="carousel-item">
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <a class="nc-card" href="#">
                                        <div class="nc-card__media">
                                            <img src="https://images.unsplash.com/photo-1583912086096-8b0eb9d38a59?q=80&w=1600&auto=format&fit=crop" alt="">
                                            <span class="nc-card__overlay"></span>
                                        </div>
                                        <div class="nc-card__title">Surgical</div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a class="nc-card" href="#">
                                        <div class="nc-card__media">
                                            <img src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?q=80&w=1600&auto=format&fit=crop" alt="">
                                            <span class="nc-card__overlay"></span>
                                        </div>
                                        <div class="nc-card__title">Consumables</div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a class="nc-card" href="#">
                                        <div class="nc-card__media">
                                            <img src="https://images.unsplash.com/photo-1583912268912-b96c82147fe3?q=80&w=1600&auto=format&fit=crop" alt="">
                                            <span class="nc-card__overlay"></span>
                                        </div>
                                        <div class="nc-card__title">Diagnostics</div>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- See More -->
                <div class="text-center mt-4">
                    <a href="#" class="nc-btn-outline" style="text-decoration: none;">See More</a>
                </div>
            </div>
        </section>

        <section id="new-banar" class="nb new-banar-fonts">
            <div class="nb__bg" style="background-image:url({{ asset('front/assets/images/doctor-is-analyzing-treatment.png') }});"></div>
            <div class="nb__hex"></div>
            <div class="container position-relative">
                <div class="row justify-content-center">
                    <div class="col-11 col-lg-9 text-center">
                        <h2 class="nb__title">Special Medical Offers Are Here!</h2>
                        <p class="nb__subtitle"> 
                            Get exclusive discounts and limited-time deals from trusted suppliers across
                            <br>Saudi Arabia.
                        </p>
                        <a href="#" class="nb-btn" aria-label="View Offers" style="text-decoration: none;"><span>View Offers</span></a>
                    </div>
                </div>
            </div>
        </section>

        <section id="popular" class="section-padding popular-section bg-white">
            <div class="container">
                <div class="row align-items-end mb-4">
                    <div class="col-md-8">
                        <span class="section-tag text-uppercase">Popular Medical Equipment</span>
                        <h2 class="section-title mt-2">Trusted devices from verified suppliers</h2>
                        <p class="section-subtitle mt-2 mb-0 text-muted-soft">Explore top-rated equipment frequently ordered by hospitals across the Kingdom.</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="products.html" class="btn btn-outline-success px-4">See all products</a>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4">
                        <article class="equipment-card h-100" data-aos="fade-up">
                            <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=900&auto=format&fit=crop" class="equipment-card__image" alt="Digital X-Ray">
                            <div class="equipment-card__body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1">Digital X-Ray Machine</h6>
                                        <span class="badge bg-light text-primary fw-semibold">Imaging</span>
                                    </div>
                                    <span class="rating-badge"><i class="bi bi-star-fill me-1"></i>5.0</span>
                                </div>
                                <p class="text-muted small mb-3">High-capacity digital unit with low radiation exposure and PACS integration.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="equipment-price">25,000 SAR</span>
                                    <a href="product-details.html" class="btn btn-gradient btn-sm px-3">Details</a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <article class="equipment-card h-100" data-aos="fade-up" data-aos-delay="100">
                            <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=900&auto=format&fit=crop" class="equipment-card__image" alt="Digital X-Ray">
                            <div class="equipment-card__body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1">ICU Ventilator</h6>
                                        <span class="badge bg-light text-primary fw-semibold">Critical Care</span>
                                    </div>
                                    <span class="rating-badge"><i class="bi bi-star-fill me-1"></i>4.8</span>
                                </div>
                                <p class="text-muted small mb-3">Adaptive ventilation modes with advanced monitoring dashboards.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="equipment-price">48,900 SAR</span>
                                    <a href="product-details.html" class="btn btn-gradient btn-sm px-3">Details</a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <article class="equipment-card h-100" data-aos="fade-up" data-aos-delay="200">
                            <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=900&auto=format&fit=crop" class="equipment-card__image" alt="Digital X-Ray">
                            <div class="equipment-card__body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1">Infusion Pump</h6>
                                        <span class="badge bg-light text-primary fw-semibold">Nursing Care</span>
                                    </div>
                                    <span class="rating-badge"><i class="bi bi-star-fill me-1"></i>4.7</span>
                                </div>
                                <p class="text-muted small mb-3">Smart drug libraries and safety protocols ideal for critical care units.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="equipment-price">6,450 SAR</span>
                                    <a href="product-details.html" class="btn btn-gradient btn-sm px-3">Details</a>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- =================== New Downloads =================== -->
        <section id="new-downloads" class="ndl">
            <div class="container">
                <div class="ndl__wrap">
                    <!-- Card Left -->
                    <div class="ndl__card">
                        <h3 class="ndl__title">Smart & Seamless —<br>Download HemaPulse Now</h3>
                        <p class="ndl__desc">
                        Simplify how hospitals and suppliers connect. With HemaPulse, you can request
                        quotations, compare offers, and manage medical product orders — all in one smart,
                        secure, and easy-to-use platform.
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
                <p class="text-center text-muted mb-4 small">Everything you need to know — right here.</p>
                <div class="faq-box mx-auto">
                    <div class="accordion accordion-clean" id="faqAcc">
                        <div class="accordion-item faq-item">
                            <h2 class="accordion-header" id="q1">
                                <button class="accordion-button faq-item__btn" type="button" data-bs-toggle="collapse" data-bs-target="#a1" aria-expanded="true">
                                    <span class="faq-item__text">1. What is Hemapulse?</span>
                                    <span class="faq-item__badge faq-item__badge--active"><i class="bi bi-check-lg"></i></span>
                                </button>
                            </h2>
                            <div id="a1" class="accordion-collapse collapse show" data-bs-parent="#faqAcc">
                                <div class="accordion-body faq-item__body">
                                    Hemapulse is a smart medical platform that connects healthcare providers with trusted 
                                    suppliers across Saudi Arabia. It allows users to request quotations, order medical products, 
                                    and manage maintenance services — all in one place.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item faq-item">
                            <h2 class="accordion-header" id="q2">
                                <button class="accordion-button collapsed faq-item__btn" type="button" data-bs-toggle="collapse" data-bs-target="#a2">
                                    <span class="faq-item__text">2. Who can use HemaPulse?</span>
                                    <span class="faq-item__badge"><i class="bi bi-info-lg"></i></span>
                                </button>
                            </h2>
                            <div id="a2" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
                                <div class="accordion-body faq-item__body">Hospitals, clinics, and verified suppliers.</div>
                            </div>
                        </div>
                        <div class="accordion-item faq-item">
                            <h2 class="accordion-header" id="q3">
                                <button class="accordion-button collapsed faq-item__btn" type="button" data-bs-toggle="collapse" data-bs-target="#a3">
                                    <span class="faq-item__text">3. How does the quotation request process work?</span>
                                    <span class="faq-item__badge"><i class="bi bi-info-lg"></i></span>
                                </button>
                            </h2>
                            <div id="a3" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
                                <div class="accordion-body faq-item__body">Create RFQ → receive multiple offers → compare → accept → track.</div>
                            </div>
                        </div>
                        <div class="accordion-item faq-item">
                            <h2 class="accordion-header" id="q4">
                                <button class="accordion-button collapsed faq-item__btn" type="button" data-bs-toggle="collapse" data-bs-target="#a4">
                                    <span class="faq-item__text">4. How can I track orders or maintenance requests?</span>
                                    <span class="faq-item__badge"><i class="bi bi-info-lg"></i></span>
                                </button>
                            </h2>
                            <div id="a4" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
                                <div class="accordion-body faq-item__body">Track status, delivery and technician visits from your dashboard.</div>
                            </div>
                        </div>
                        <div class="accordion-item faq-item">
                            <h2 class="accordion-header" id="q5">
                                <button class="accordion-button collapsed faq-item__btn" type="button" data-bs-toggle="collapse" data-bs-target="#a5">
                                    <span class="faq-item__text">5. What payment methods are available on HemaPulse?</span>
                                    <span class="faq-item__badge"><i class="bi bi-info-lg"></i></span>
                                </button>
                            </h2>
                            <div id="a5" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
                                <div class="accordion-body faq-item__body">Bank transfer, corporate card, and POs with approved suppliers.</div>
                            </div>
                        </div>
                        <div class="accordion-item faq-item">
                            <h2 class="accordion-header" id="q6">
                                <button class="accordion-button collapsed faq-item__btn" type="button" data-bs-toggle="collapse" data-bs-target="#a6">
                                    <span class="faq-item__text">6. How can I contact HemaPulse for support?</span>
                                    <span class="faq-item__badge"><i class="bi bi-info-lg"></i></span>
                                </button>
                            </h2>
                            <div id="a6" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
                                <div class="accordion-body faq-item__body">Email support@hemapulse.com or use in-app chat.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="clients" class="clients-wrap section section--pad-lg reveal">
            <div class="clients-blob pulse" style="bottom: 6px;left: 88%;"></div>
            <div class="container-testimonials position-relative" style="top: 96px;height: 463px;">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-3">
                        <h2 class="section-title">
                            <h2 class="clients-title text-center">
                                <span class="clients-title__muted">What Our </span>
                                <span class="clients-title__color">Clients</span>
                                <span class="clients-title__muted"> Say?</span>
                            </h2>   
                        </h2>
                    </div>
                    <div class="col-lg-9">
                        <div class="row g-4 mt-2 justify-content-center">
                            <!-- Slider -->
                            <div id="newCatCarouselTestimonials" class="carousel slide" data-bs-ride="carousel" data-bs-interval="7000">
                                <div class="carousel-inner">

                                    <!-- Slide 1 -->
                                    <div class="carousel-item active" style="padding: 20px 0px 20px 20px;">
                                        <div class="row g-4">


                                            <div class="col-lg-6">
                                                <div class="testi-card anim-pop">
                                                    <div class="testi-card__stars mb-2">
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star"></i>
                                                    </div>
                                                    <p class="testi-card__text mb-2">
                                                        <strong>Reliable and Efficient</strong><br>
                                                        Their supplier network delivered competitive quotations quickly and a smooth experience.
                                                    </p>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <img class="avatar" src="https://i.pravatar.cc/60?img=18" alt="">
                                                        <div>
                                                            <div class="fw-semibold">Eng. Faisal Alsobai</div>
                                                            <small class="text-muted">King Faisal Hospital, Riyadh</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 position-relative" style="padding-right: 0px;">
                                                <div class="testi-card anim-pop">
                                                    <div class="testi-card__stars mb-2">
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-half"></i>
                                                    </div>
                                                    <p class="testi-card__text mb-2">
                                                        <strong>Great Experience</strong><br>
                                                        Fast response to maintenance requests and transparent progress updates.
                                                    </p>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <img class="avatar" src="https://i.pravatar.cc/60?img=31" alt="">
                                                        <div>
                                                            <div class="fw-semibold">Dr. Sara Almuttalib</div>
                                                            <small class="text-muted">King Fahd Hospital, Riyadh</small>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>


                                        </div>
                                    </div>

                                    <!-- Slide 2 -->
                                    <div class="carousel-item" style="padding: 20px 0px 20px 20px;">
                                        <div class="row g-4">

                                            
                                            <div class="col-lg-6">
                                                <div class="testi-card anim-pop">
                                                    <div class="testi-card__stars mb-2">
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star"></i>
                                                    </div>
                                                    <p class="testi-card__text mb-2">
                                                        <strong>Reliable and Efficient</strong><br>
                                                        Their supplier network delivered competitive quotations quickly and a smooth experience.
                                                    </p>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <img class="avatar" src="https://i.pravatar.cc/60?img=18" alt="">
                                                        <div>
                                                            <div class="fw-semibold">Eng. Faisal Alsobai</div>
                                                            <small class="text-muted">King Faisal Hospital, Riyadh</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 position-relative" style="padding-right: 0px;">
                                                <div class="testi-card anim-pop">
                                                    <div class="testi-card__stars mb-2">
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-half"></i>
                                                    </div>
                                                    <p class="testi-card__text mb-2">
                                                        <strong>Great Experience</strong><br>
                                                        Fast response to maintenance requests and transparent progress updates.
                                                    </p>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <img class="avatar" src="https://i.pravatar.cc/60?img=31" alt="">
                                                        <div>
                                                            <div class="fw-semibold">Dr. Sara Almuttalib</div>
                                                            <small class="text-muted">King Fahd Hospital, Riyadh</small>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>


                                        </div>
                                    </div>

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
    </main>
        
@endsection
<!-- custom js -->
@section('script')
<script>

    $(function(){
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
    });

</script>
@endsection
