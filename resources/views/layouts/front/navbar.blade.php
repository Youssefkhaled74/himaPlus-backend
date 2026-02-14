<header class="header landing-header">
    <nav class="navbar navbar-expand-lg bg-white fixed-top" style="padding: 0;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('front/assets/images/WhatsApp Image 2025-09-06 at 14.00.40_dfdafdc6 2.png') }}" alt="HemaPulse logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link" id="nav-home" href="{{ route('home') }}">{{ __('nav.home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="nav-aboutUs" href="{{ route('aboutUs') }}">{{ __('nav.about_us') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="nav-providers" href="{{ route('providers') }}">{{ __('nav.service_providers') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="nav-categories" href="{{ route('categories') }}">{{ __('nav.categories') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="nav-orders" href="{{ route('user/myorders', 'all') }}">{{ __('nav.orders') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="nav-contactUs" href="{{ route('contactUs') }}">{{ __('nav.contact_us') }}</a>
                    </li>
                </ul>
                <div class="header-icons d-xl-flex ms-4">
                    @if(auth()->check())
                        @if(auth()->user()->user_type == 2)
                            {{-- Vendor Links (Logged In) --}}
                            <a class="text-decoration-none" href="{{ route('vendor/dashboard') }}" id="nav-dashboard" title="Dashboard"><i class="bi bi-speedometer2"></i></a>
                            <a class="text-decoration-none" href="{{ route('vendor/profile') }}" id="nav-vendor-profile" title="Profile"><i class="bi bi-person"></i></a>
                            <a class="text-decoration-none" href="{{ route('vendor/logout') }}" id="nav-vendor-logout" title="Logout"><i class="bi bi-box-arrow-right"></i></a>
                        @else
                            {{-- User Links --}}
                            <a class="text-decoration-none" href="{{ route('products') }}" id="nav-search"><i class="bi bi-search"></i></a>
                            <a class="text-decoration-none" href="{{ route('user/favorites') }}" id="nav-heart"><i class="bi bi-heart"></i></a>
                            <a class="text-decoration-none" href="{{ route('user/profile') }}" id="nav-user-profile"><i class="bi bi-person"></i></a>
                            <a id="cartIcon" class="text-decoration-none" href="{{ route('user/cart') }}" id="nav-bag"><i class="bi bi-bag"></i><span id="cartCount" class="badge bg-danger">0</span></a>
                        @endif
                    @else
                        {{-- Guest/Unverified Links --}}
                        <a class="text-decoration-none" href="{{ route('products') }}" id="nav-search"><i class="bi bi-search"></i></a>
                        <a class="text-decoration-none" href="{{ route('user/favorites') }}" id="nav-heart"><i class="bi bi-heart"></i></a>
                        <a class="text-decoration-none" href="{{ route('user/loginForm') }}" id="nav-person"><i class="bi bi-person"></i></a>
                        <a id="cartIcon" class="text-decoration-none" href="{{ route('user/cart') }}" id="nav-bag"><i class="bi bi-bag"></i></a>
                    @endif
                    <div class="dropdown lang-dropdown">
                        <a class="text-decoration-none dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" id="nav-lang">
                            <i class="bi bi-globe2"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}" href="{{ url('locale/en') }}">English</a></li>
                            <li><a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'active' : '' }}" href="{{ url('locale/ar') }}">العربية</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
