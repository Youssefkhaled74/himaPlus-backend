@php
    $isVendorAuthed = auth()->check() && (int) auth()->user()->user_type === 2;
    $routeName = request()->route() ? request()->route()->getName() : '';
    $cartCount = 0;
    $vendorUnreadNotificationsCount = 0;
    $vendorRecentNotifications = collect();
    if (auth()->check() && (int) auth()->user()->user_type !== 2) {
        $cartCount = (int) auth()->user()->cart()->sum('quantity');
    }
    if ($isVendorAuthed) {
        $vendorUnreadNotificationsCount = (int) \App\Models\Notification::query()
            ->where('user_id', auth()->id())
            ->where(function ($query) {
                $query->whereIn('type', ['order', 'payment', 'status_change', 'product_approval', 'product_rejection'])
                    ->orWhereNull('type');
            })
            ->unread()
            ->count();

        $vendorRecentNotifications = \App\Models\Notification::query()
            ->where('user_id', auth()->id())
            ->where(function ($query) {
                $query->whereIn('type', ['order', 'payment', 'status_change', 'product_approval', 'product_rejection'])
                    ->orWhereNull('type');
            })
            ->latest()
            ->take(5)
            ->get();
    }
@endphp

<header class="header landing-header">
    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ $isVendorAuthed ? route('vendor/dashboard') : route('home') }}">
                <img src="{{ asset('front/assets/images/newLogo.png') }}" alt="Hema logo">
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
                            <a class="nav-link {{ request()->routeIs('vendor/orders/my-offers') || (request()->routeIs('vendor/orders') && request('tab') === 'quotations') ? 'active' : '' }}" href="{{ route('vendor/orders', ['tab' => 'quotations']) }}">{{ __('nav.quotations') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ str_contains($routeName, 'vendor/orders') && !(request()->routeIs('vendor/orders') && request('tab') === 'quotations') ? 'active' : '' }}" href="{{ route('vendor/orders') }}">{{ __('nav.orders') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('vendor/invoices') ? 'active' : '' }}" href="{{ route('vendor/invoices') }}">{{ __('nav.invoices') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('vendor/categories') ? 'active' : '' }}" href="{{ route('vendor/categories') }}">{{ __('nav.categories') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ str_contains($routeName, 'vendor/branches') ? 'active' : '' }}" href="{{ route('vendor/branches') }}">{{ __('vendor_branches.branches') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('vendor/analytics') ? 'active' : '' }}" href="{{ route('vendor/analytics') }}">{{ __('nav.analytics') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('vendor/ratings') ? 'active' : '' }}" href="{{ route('vendor/ratings') }}">{{ __('nav.ratings_reviews') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('contactUs') ? 'active' : '' }}" href="{{ route('contactUs') }}">{{ __('nav.contact_us') }}</a>
                        </li>
                    </ul>

                    <div class="header-icons d-xl-flex ms-4">
                        <div class="dropdown lang-dropdown me-3">
                            <a class="text-decoration-none dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" id="nav-lang-vendor">
                                <i class="bi bi-globe2"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}" href="{{ url('locale/en') }}">English</a></li>
                                <li><a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'active' : '' }}" href="{{ url('locale/ar') }}">العربية</a></li>
                            </ul>
                        </div>
                        <div class="dropdown me-3">
                            <a class="text-decoration-none position-relative d-inline-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="{{ __('nav.notifications') }}">
                                <i class="bi bi-bell" style="font-size:1.25rem;"></i>
                                @if($vendorUnreadNotificationsCount > 0)
                                    <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle" style="font-size:.65rem;min-width:18px;">{{ $vendorUnreadNotificationsCount > 99 ? '99+' : $vendorUnreadNotificationsCount }}</span>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-end hp-notification-menu">
                                <div class="hp-notification-menu__head">
                                    <strong>{{ __('nav.notifications') }}</strong>
                                    <a href="{{ route('vendor/notifications') }}">{{ __('nav.all') }}</a>
                                </div>
                                <div class="hp-notification-menu__list">
                                    @forelse($vendorRecentNotifications as $notification)
                                        <a href="{{ route('vendor/notifications') }}" class="hp-notification-menu__item">
                                            <span class="hp-notification-menu__icon {{ $notification->read_at ? 'is-read' : 'is-unread' }}">
                                                <i class="bi bi-bell{{ $notification->read_at ? '' : '-fill' }}"></i>
                                            </span>
                                            <span class="hp-notification-menu__body">
                                                <span class="hp-notification-menu__title">{{ $notification->title }}</span>
                                                <span class="hp-notification-menu__text">{{ \Illuminate\Support\Str::limit($notification->content ?? $notification->message ?? '-', 70) }}</span>
                                            </span>
                                        </a>
                                    @empty
                                        <div class="hp-notification-menu__empty">{{ __('nav.no_notifications') ?? 'No notifications yet' }}</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="dropdown">
                            <a class="text-decoration-none d-inline-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person" style="font-size:1.35rem;"></i>
                                <i class="bi bi-chevron-down" style="font-size:.95rem;"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('vendor/profile') }}">{{ __('profile.my_profile') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('vendor/notifications') }}">{{ __('nav.notifications') }}</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('vendor/logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">{{ __('profile.logout') }}</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @else
                    <ul class="navbar-nav ms-auto align-items-lg-center">
                        @if(auth()->check() && (int) auth()->user()->user_type !== 2)
                        <li class="nav-item">
                            <a class="nav-link" id="nav-dashboard" href="{{ route('user/dashboard') }}">{{ __('nav.dashboard') }}</a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" id="nav-home" href="{{ route('home') }}">{{ __('nav.home') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="nav-aboutUs" href="{{ route('aboutUs') }}">{{ __('nav.about_us') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="nav-products" href="{{ route('products') }}">{{ __('nav.products') }}</a>
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
                            <a id="cartIcon" class="text-decoration-none" href="{{ route('user/cart') }}"><i class="bi bi-bag"></i><span id="cartCount" class="badge bg-danger">{{ $cartCount }}</span></a>
                        @else
                            <a class="text-decoration-none" href="{{ route('products') }}" id="nav-search"><i class="bi bi-search"></i></a>
                            <a class="text-decoration-none" href="{{ route('user/favorites') }}" id="nav-heart"><i class="bi bi-heart"></i></a>
                            <a class="text-decoration-none" href="{{ route('login') }}" id="nav-person"><i class="bi bi-person"></i></a>
                            <a id="cartIcon" class="text-decoration-none" href="{{ route('user/cart') }}"><i class="bi bi-bag"></i></a>
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
                @endif
            </div>
        </div>
    </nav>
</header>
