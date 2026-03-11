@extends('layouts.front.home')

@section('title')
    <title>{{ __('nav.home') }} - Vendor | HemaPulse</title>
@endsection

@section('css')
<style>
    .vendor-home,
    .vendor-home * {
        font-family: "Poppins", "Tajawal", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
    }

    .vendor-home {
        background: #f6f8fb;
        color: #1f2a37;
    }

    .vh-container {
        width: min(1160px, calc(100% - 32px));
        margin-inline: auto;
    }

    .vh-hero {
        min-height: 430px;
        display: grid;
        place-items: center;
        text-align: center;
        color: #fff;
        background: linear-gradient(180deg, rgba(8, 20, 42, .45), rgba(8, 20, 42, .45)),
                    url('{{ asset('front/assets/images/still-life-ophthalmologist-s-office1.png') }}') center/cover no-repeat;
    }

    .vh-hero h1 {
        margin: 0;
        font-size: clamp(32px, 4.5vw, 52px);
        font-weight: 700;
        line-height: 1.15;
    }

    .vh-hero p {
        margin: 12px auto 0;
        max-width: 760px;
        font-size: 16px;
        line-height: 1.7;
        color: rgba(255,255,255,.92);
    }

    .btn-gradient {
        margin-top: 20px;
        min-width: 190px;
        height: 48px;
        border: 0;
        border-radius: 10px;
        font-weight: 600;
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        background: linear-gradient(90deg, #0a46a3 0%, #08c49a 100%);
    }

    .btn-gradient:hover { color: #fff; filter: brightness(.98); }

    .vh-section {
        padding: 72px 0;
    }

    .vh-title {
        margin: 0 0 28px;
        text-align: center;
        color: #0b847d;
        font-size: clamp(28px, 4vw, 40px);
        font-weight: 700;
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .service-card {
        background: #fff;
        border: 1px solid #e6edf8;
        border-radius: 18px;
        padding: 24px 20px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(22, 38, 74, .06);
    }

    .service-card img {
        width: 72px;
        height: 72px;
        object-fit: contain;
        margin-bottom: 14px;
    }

    .service-card h3 {
        margin: 0 0 10px;
        font-size: 24px;
        font-weight: 700;
        color: #153a8a;
    }

    .service-card p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.8;
    }

    .work-grid {
        display: grid;
        grid-template-columns: 1.1fr .9fr;
        gap: 26px;
        align-items: center;
    }

    .work-list {
        display: grid;
        gap: 14px;
    }

    .work-item {
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .work-badge {
        width: 26px;
        height: 26px;
        border-radius: 999px;
        color: #fff;
        font-size: 13px;
        display: grid;
        place-items: center;
        background: linear-gradient(180deg, #0a4aa8 0%, #08c59b 100%);
        flex-shrink: 0;
        margin-top: 2px;
    }

    .work-item h4 {
        margin: 0;
        color: #123c91;
        font-size: 17px;
        font-weight: 700;
    }

    .work-item p {
        margin: 5px 0 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.75;
    }

    .work-media {
        border-radius: 18px;
        overflow: hidden;
        min-height: 350px;
    }

    .work-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .cta-banner {
        padding: 70px 0;
        color: #fff;
        text-align: center;
        background: linear-gradient(180deg, rgba(9, 16, 31, .46), rgba(9, 16, 31, .46)),
                    url('{{ asset('front/assets/images/healthcare-worker-protective-gear-handling-medical-supplies-packaging-healthcare-facility-focus-safety-precision 1.png') }}') center/cover no-repeat;
    }

    .cta-banner h2 {
        margin: 0;
        font-size: clamp(30px, 4vw, 48px);
        font-weight: 700;
    }

    .cta-banner p {
        margin: 10px 0 0;
        color: rgba(255,255,255,.9);
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .product-card {
        background: #fff;
        border: 1px solid #e6edf8;
        border-radius: 14px;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        box-shadow: 0 10px 26px rgba(22, 38, 74, .06);
    }

    .product-card:hover { color: inherit; }

    .product-card .thumb {
        height: 210px;
        background: #ecf2fb;
    }

    .product-card .thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .product-card .body {
        padding: 14px 14px 16px;
    }

    .product-card h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
    }

    .product-card p {
        margin: 8px 0 0;
        font-size: 16px;
        font-weight: 700;
        color: #0a46a3;
    }

    .faq-wrap {
        max-width: 900px;
        margin: 0 auto;
    }

    .faq-wrap .accordion-item {
        border: 1px solid #d9e4f4;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 12px;
    }

    .faq-wrap .accordion-button {
        font-weight: 600;
        font-size: 16px;
        color: #193e91;
    }

    .faq-wrap .accordion-button:not(.collapsed) {
        color: #fff;
        background: linear-gradient(90deg, #0a46a3 0%, #08c49a 100%);
    }

    .testimonials {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .test-card {
        background: #fff;
        border: 1px solid #e6edf8;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(22, 38, 74, .06);
    }

    .test-stars {
        color: #f4b400;
        margin-bottom: 10px;
        letter-spacing: 1px;
    }

    .test-card p {
        color: #475569;
        margin: 0 0 14px;
        line-height: 1.75;
    }

    .test-user {
        font-weight: 700;
        color: #123c91;
        margin: 0;
    }

    .mobile-card {
        background: linear-gradient(100deg, #eafaf6 0%, #f3f8ff 100%);
        border: 1px solid #d8e7f9;
        border-radius: 18px;
        padding: 24px;
        display: grid;
        gap: 18px;
        grid-template-columns: 1fr 1fr;
        align-items: center;
    }

    .mobile-card h3 {
        margin: 0 0 10px;
        color: #0d3e8f;
        font-size: clamp(24px, 3vw, 34px);
        font-weight: 700;
    }

    .mobile-card p {
        margin: 0;
        color: #475569;
        line-height: 1.8;
    }

    .mobile-img {
        text-align: center;
    }

    .mobile-img img {
        max-width: 100%;
        height: auto;
    }

    .stores {
        display: flex;
        gap: 10px;
        margin-top: 14px;
        flex-wrap: wrap;
    }

    .stores img { height: 40px; width: auto; }

    @media (max-width: 991.98px) {
        .vh-section { padding: 48px 0; }
        .services-grid, .products-grid, .testimonials { grid-template-columns: 1fr; }
        .work-grid, .mobile-card { grid-template-columns: 1fr; }
        .work-media { min-height: 250px; }
    }
</style>
@endsection

@section('content')
@php
    $isAr = app()->getLocale() === 'ar';
@endphp

<main class="vendor-home">
    @include('flash::message')

    <section class="vh-hero">
        <div class="vh-container">
            <h1>{{ $isAr ? 'مرحبًا، موردي الأجهزة الطبية' : 'Welcome, Medical Suppliers' }}</h1>
            <p>
                {{ $isAr ? 'أدر منتجاتك الطبية وتابع طلبات المستشفيات والعيادات في مكان واحد بكل سهولة.' : 'Track your medical products and connect directly with hospitals and clinics looking for verified suppliers.' }}
            </p>
            <a href="{{ route('vendor/products/create') }}" class="btn-gradient">
                {{ $isAr ? 'إضافة منتج جديد' : 'Add New Product' }}
            </a>
        </div>
    </section>

    <section class="vh-section">
        <div class="vh-container">
            <h2 class="vh-title">{{ $isAr ? 'خدماتنا' : 'Our Services' }}</h2>

            <div class="services-grid">
                <article class="service-card">
                    <img src="{{ asset('front/assets/images/icon1_transparent.png') }}" alt="Service 1">
                    <h3>{{ $isAr ? 'عرض المنتجات' : 'Product Listing' }}</h3>
                    <p>{{ $isAr ? 'أضف منتجاتك الطبية واعرضها بطريقة احترافية لتصل للمشترين بسرعة.' : 'List your products with complete details and clear pricing for buyers.' }}</p>
                </article>

                <article class="service-card">
                    <img src="{{ asset('front/assets/images/icon2_transparent.png') }}" alt="Service 2">
                    <h3>{{ $isAr ? 'استقبال الطلبات' : 'Receive Requests' }}</h3>
                    <p>{{ $isAr ? 'استقبل طلبات الشراء والتسعير من الجهات الصحية مباشرة من لوحة المورد.' : 'Receive order and quotation requests directly from healthcare buyers.' }}</p>
                </article>

                <article class="service-card">
                    <img src="{{ asset('front/assets/images/icon3_transparent.png') }}" alt="Service 3">
                    <h3>{{ $isAr ? 'دفع آمن' : 'Secure Payments' }}</h3>
                    <p>{{ $isAr ? 'تعاملات مالية موثوقة وآمنة مع متابعة كاملة لحالة الطلب.' : 'Reliable and secure payment flow with transparent order tracking.' }}</p>
                </article>
            </div>
        </div>
    </section>

    <section class="vh-section pt-0">
        <div class="vh-container">
            <h2 class="vh-title">{{ $isAr ? 'كيف تعمل المنصة' : 'How It Works' }}</h2>

            <div class="work-grid">
                <div class="work-list">
                    <div class="work-item">
                        <div class="work-badge"><i class="bi bi-check-lg"></i></div>
                        <div>
                            <h4>{{ $isAr ? 'التسجيل كمورد' : 'Register as a Supplier' }}</h4>
                            <p>{{ $isAr ? 'أنشئ حسابك واملأ بيانات النشاط التجاري لبدء العمل.' : 'Create your account and complete your company details.' }}</p>
                        </div>
                    </div>
                    <div class="work-item">
                        <div class="work-badge"><i class="bi bi-check-lg"></i></div>
                        <div>
                            <h4>{{ $isAr ? 'اعتماد الحساب' : 'Get Approved' }}</h4>
                            <p>{{ $isAr ? 'بعد مراجعة البيانات يتم تفعيل حسابك كمورد موثوق.' : 'Your account is reviewed and approved for trusted selling.' }}</p>
                        </div>
                    </div>
                    <div class="work-item">
                        <div class="work-badge"><i class="bi bi-check-lg"></i></div>
                        <div>
                            <h4>{{ $isAr ? 'استلام الطلبات' : 'Receive Requests' }}</h4>
                            <p>{{ $isAr ? 'تابع طلبات المنتجات من المستشفيات والعيادات مباشرة.' : 'Receive incoming product requests from hospitals and clinics.' }}</p>
                        </div>
                    </div>
                    <div class="work-item">
                        <div class="work-badge"><i class="bi bi-check-lg"></i></div>
                        <div>
                            <h4>{{ $isAr ? 'تقديم العروض والتسليم' : 'Submit Offers & Deliver' }}</h4>
                            <p>{{ $isAr ? 'أرسل عروضك، اتفق على الأسعار، وأدر عمليات التسليم.' : 'Send quotations, finalize deals, and complete delivery.' }}</p>
                        </div>
                    </div>
                </div>

                <div class="work-media">
                    <img src="{{ asset('front/assets/images/image.png') }}" alt="How It Works">
                </div>
            </div>
        </div>
    </section>

    <section class="cta-banner">
        <div class="vh-container">
            <h2>{{ $isAr ? 'نمِّ مبيعاتك مع HemaPulse' : 'Grow Your Sales with Hemapulse' }}</h2>
            <p>{{ $isAr ? 'تواصل مع الجهات الصحية الباحثة عن موردين مثلك.' : 'Connect with hospitals actively looking for suppliers like you.' }}</p>
            <a href="{{ route('vendor/products') }}" class="btn-gradient">
                {{ $isAr ? 'إدارة المنتجات' : 'Join as a Supplier' }}
            </a>
        </div>
    </section>

    <section class="vh-section">
        <div class="vh-container">
            <h2 class="vh-title">{{ $isAr ? 'الأكثر طلبًا' : 'Most Requested Products' }}</h2>

            <div class="products-grid">
                @forelse($featuredProducts as $product)
                    @php
                        $imgUrl = asset('front/assets/images/emptyproducts.png');
                        if (!empty($product->img)) {
                            $imgPath = ltrim((string) $product->img, '/');
                            if (!str_starts_with($imgPath, 'http') && !str_contains($imgPath, '/')) {
                                $imgPath = 'products/' . $imgPath;
                            }
                            if (str_starts_with((string) $product->img, 'http')) {
                                $imgUrl = (string) $product->img;
                            } elseif (file_exists(storage_path('app/public/' . $imgPath))) {
                                $imgUrl = asset('storage/' . $imgPath);
                            } elseif (file_exists(public_path($imgPath))) {
                                $imgUrl = asset($imgPath);
                            } else {
                                $imgUrl = asset('storage/' . $imgPath);
                            }
                        }
                    @endphp
                    <a href="{{ route('vendor/products/show', $product->id) }}" class="product-card">
                        <div class="thumb">
                            <img src="{{ $imgUrl }}" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='{{ asset('front/assets/images/emptyproducts.png') }}';">
                        </div>
                        <div class="body">
                            <h3>{{ $product->name }}</h3>
                            <p>{{ number_format((float) $product->price, 2) }} {{ __('products.currency_sar') ?: 'SAR' }}</p>
                        </div>
                    </a>
                @empty
                    <article class="service-card" style="grid-column: 1/-1;">
                        <h3>{{ $isAr ? 'لا توجد منتجات بعد' : 'No products yet' }}</h3>
                        <p>{{ $isAr ? 'ابدأ بإضافة أول منتج لعرضه هنا.' : 'Add your first product to show it here.' }}</p>
                        <a href="{{ route('vendor/products/create') }}" class="btn-gradient">{{ $isAr ? 'إضافة منتج' : 'Add Product' }}</a>
                    </article>
                @endforelse
            </div>
        </div>
    </section>

    <section class="vh-section pt-0">
        <div class="vh-container">
            <div class="mobile-card">
                <div>
                    <h3>{{ $isAr ? 'إدارة الطلبات أثناء التنقل' : 'Manage Requests On the Go' }}</h3>
                    <p>{{ $isAr ? 'تابع الطلبات والعروض بسرعة من خلال تطبيق HemaPulse على هاتفك.' : 'Monitor requests and offers from your phone with the HemaPulse app.' }}</p>
                    <div class="stores">
                        <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="App Store">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play">
                    </div>
                </div>
                <div class="mobile-img">
                    <img src="{{ asset('front/assets/images/Group 1171275716.png') }}" alt="Mobile App">
                </div>
            </div>
        </div>
    </section>

    <section class="vh-section pt-0">
        <div class="vh-container">
            <h2 class="vh-title">FAQ</h2>
            <div class="faq-wrap">
                <div class="accordion" id="dashboardFaq">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                {{ $isAr ? 'كيف أضيف منتجًا جديدًا؟' : 'How do I add a new product?' }}
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#dashboardFaq">
                            <div class="accordion-body">
                                {{ $isAr ? 'اذهب إلى صفحة المنتجات ثم اضغط إضافة منتج وأدخل البيانات المطلوبة.' : 'Open Products, click Add Product, then fill all required details.' }}
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                {{ $isAr ? 'هل يمكن تعديل المنتج بعد حفظه؟' : 'Can I edit a product after saving?' }}
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#dashboardFaq">
                            <div class="accordion-body">
                                {{ $isAr ? 'نعم، يمكنك تعديل كل تفاصيل المنتج من صفحة عرض المنتج.' : 'Yes, you can edit all product details from the product page.' }}
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                {{ $isAr ? 'كيف أتابع الطلبات الواردة؟' : 'How can I track incoming requests?' }}
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#dashboardFaq">
                            <div class="accordion-body">
                                {{ $isAr ? 'يمكنك متابعة كل الطلبات والعروض من صفحة الطلبات داخل لوحة المورد.' : 'You can track all requests and offers from the Orders section.' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="vh-section pt-0">
        <div class="vh-container">
            <h2 class="vh-title">{{ $isAr ? 'ماذا يقول عملاؤنا؟' : 'What Our Clients Say?' }}</h2>
            <div class="testimonials">
                <article class="test-card">
                    <div class="test-stars">★★★★★</div>
                    <p>{{ $isAr ? 'المنصة سهلت علينا الوصول لموردين موثوقين بسرعة وجودة عالية.' : 'This platform made it easy to find reliable suppliers quickly.' }}</p>
                    <p class="test-user">{{ $isAr ? 'د. فاطمة العتيبي' : 'Dr. Fatima Al-Otaibi' }}</p>
                </article>
                <article class="test-card">
                    <div class="test-stars">★★★★★</div>
                    <p>{{ $isAr ? 'تجربة ممتازة في إدارة الطلبات وتقديم العروض بطريقة احترافية.' : 'Excellent experience for managing requests and sending offers.' }}</p>
                    <p class="test-user">{{ $isAr ? 'د. سامي ناصر' : 'Dr. Sami Nasser' }}</p>
                </article>
            </div>
        </div>
    </section>
</main>
@endsection
