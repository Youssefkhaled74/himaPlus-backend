@php
    $isVendorAuthed = auth()->check() && (int) auth()->user()->user_type === 2;
    $routeName = request()->route() ? request()->route()->getName() : '';
@endphp

<header class="header landing-header">
    <nav class="navbar navbar-expand-lg bg-white fixed-top" style="padding: 0;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ $isVendorAuthed ? route('vendor/dashboard') : route('home') }}">
                <img src="{{ asset('front/assets/images/WhatsApp Image 2025-09-06 at 14.00.40_dfdafdc6 2.png') }}" alt="HemaPulse logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                @if($isVendorAuthed)
                    <ul class="navbar-nav ms-auto align-items-lg-center">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('vendor/dashboard') ? 'active' : '' }}" href="{{ route('vendor/dashboard') }}">{{ __('nav.home') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('aboutUs') ? 'active' : '' }}" href="{{ route('aboutUs') }}">{{ __('nav.about_us') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ str_contains($routeName, 'vendor/products') ? 'active' : '' }}" href="{{ route('vendor/products') }}">{{ __('nav.products') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('vendor/orders/my-offers') || (request()->routeIs('vendor/orders') && request('tab') === 'quotations') ? 'active' : '' }}" href="{{ route('vendor/orders', ['tab' => 'quotations']) }}">{{ __('nav.requests') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ str_contains($routeName, 'vendor/orders') && !(request()->routeIs('vendor/orders') && request('tab') === 'quotations') ? 'active' : '' }}" href="{{ route('vendor/orders') }}">{{ __('nav.orders') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('contactUs') ? 'active' : '' }}" href="{{ route('contactUs') }}">{{ __('nav.contact_us') }}</a>
                        </li>
                    </ul>

                    <div class="header-icons d-xl-flex ms-4">
                        <div class="dropdown">
                            <a class="text-decoration-none d-inline-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person" style="font-size:1.35rem;"></i>
                                <i class="bi bi-chevron-down" style="font-size:.95rem;"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('vendor/profile') }}">{{ __('profile.my_profile') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('vendor/notifications') }}">{{ __('nav.notifications') ?? 'Notifications' }}</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="{{ route('vendor/logout') }}">{{ __('profile.logout') }}</a></li>
                            </ul>
                        </div>
                    </div>
                @else
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
                            <a class="text-decoration-none" href="{{ route('products') }}" id="nav-search"><i class="bi bi-search"></i></a>
                            <a class="text-decoration-none" href="{{ route('user/favorites') }}" id="nav-heart"><i class="bi bi-heart"></i></a>
                            <a class="text-decoration-none" href="{{ route('user/profile') }}" id="nav-user-profile"><i class="bi bi-person"></i></a>
                            <a id="cartIcon" class="text-decoration-none" href="{{ route('user/cart') }}" id="nav-bag"><i class="bi bi-bag"></i><span id="cartCount" class="badge bg-danger">0</span></a>
                        @else
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
                                <li><a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'active' : '' }}" href="{{ url('locale/ar') }}">???????</a></li>
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </nav>
</header>
