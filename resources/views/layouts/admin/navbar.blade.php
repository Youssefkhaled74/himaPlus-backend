@php
    $admin = auth()->guard('admin')->user();
    $adminLocale = app()->getLocale();
    $adminId = (int) optional($admin)->id;
    $superAdminIds = array_map('intval', config('auth.admin_super_ids', []));
    $isSuperAdmin = in_array($adminId, $superAdminIds, true);
    $pendingOrdersCount = \App\Models\Order::query()->whereNull('deleted_at')->where('payment_status', 0)->count();
    $lowStockCount = \App\Models\Product::query()->whereNull('deleted_at')->where('stock_quantity', '<', 20)->count();
    $newUsersTodayCount = \App\Models\User::query()->whereNull('deleted_at')->whereDate('created_at', now()->toDateString())->count();
    $notificationCount = $pendingOrdersCount + $lowStockCount + $newUsersTodayCount;
    $navGroups = [
        [
            'label' => __('admin.nav.home'),
            'icon' => 'ri-home-5-line',
            'button_class' => 'sidebardashboard',
            'active' => request()->routeIs('admin/index'),
            'links' => [
                ['label' => __('admin.nav.dashboard'), 'route' => route('admin/index'), 'match' => request()->routeIs('admin/index')],
            ],
        ],
        [
            'label' => __('admin.nav.catalog'),
            'icon' => 'ri-layout-grid-line',
            'button_class' => 'sidebarcategories sidebarcountries sidebarproducts',
            'active' => request()->routeIs('admin/categories/*') || request()->routeIs('admin/products/*') || request()->routeIs('admin/countries/*'),
            'links' => [
                ['label' => __('admin.nav.categories'), 'route' => route('admin/categories/index') . '/0/' . PAGINATION_COUNT, 'match' => request()->routeIs('admin/categories/*')],
                ['label' => __('admin.nav.products'), 'route' => route('admin/products/index') . '/0/' . PAGINATION_COUNT, 'match' => request()->routeIs('admin/products/*')],
                ['label' => __('admin.nav.countries'), 'route' => route('admin/countries/index') . '/0/' . PAGINATION_COUNT, 'match' => request()->routeIs('admin/countries/*')],
            ],
        ],
        [
            'label' => __('admin.nav.orders'),
            'icon' => 'ri-shopping-bag-3-line',
            'button_class' => 'sidebarorders sidebarusers sidebarcontacts sidebarratings',
            'active' => request()->routeIs('admin/orders/*') || request()->routeIs('admin/users/*') || request()->routeIs('admin/contacts/*') || request()->routeIs('admin/ratings/*'),
            'links' => [
                ['label' => __('admin.nav.orders'), 'route' => route('admin/orders/index') . '/0/' . PAGINATION_COUNT, 'match' => request()->routeIs('admin/orders/*')],
                ['label' => __('admin.nav.users'), 'route' => route('admin/users/index') . '/0/' . PAGINATION_COUNT, 'match' => request()->routeIs('admin/users/*')],
                ['label' => __('admin.nav.contacts'), 'route' => route('admin/contacts/index') . '/0/' . PAGINATION_COUNT, 'match' => request()->routeIs('admin/contacts/*')],
                ['label' => __('admin.nav.ratings'), 'route' => route('admin/ratings/index') . '/0/' . PAGINATION_COUNT, 'match' => request()->routeIs('admin/ratings/*')],
            ],
        ],
        [
            'label' => __('admin.nav.settings'),
            'icon' => 'ri-settings-3-line',
            'button_class' => 'sidebarcoupons sidebarinfo sidebaradmins',
            'active' => request()->routeIs('admin/coupons/*') || request()->routeIs('admin/info/*') || request()->routeIs('admin/admins/*'),
            'links' => array_values(array_filter([
                ['label' => __('admin.nav.coupons'), 'route' => route('admin/coupons/index') . '/0/' . PAGINATION_COUNT, 'match' => request()->routeIs('admin/coupons/*')],
                ['label' => __('admin.nav.platform_info'), 'route' => route('admin/info/index') . '/0/' . PAGINATION_COUNT, 'match' => request()->routeIs('admin/info/*')],
                $isSuperAdmin ? ['label' => __('admin.nav.admins'), 'route' => route('admin/admins/index') . '/0/' . PAGINATION_COUNT, 'match' => request()->routeIs('admin/admins/*')] : null,
            ])),
        ],
    ];
@endphp

<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header admin-navbar-rebuilt">
            <div class="admin-navbar-brand">
                <a href="{{ route('admin/index') }}" class="admin-brand-link">
                    <span class="admin-brand-mark">
                        <img src="{{ asset('front/assets/images/newLogo.png') }}" alt="HimaPlus logo">
                    </span>
                    <span class="admin-brand-copy">
                        <span class="admin-brand-title">HimaPlus</span>
                        <span class="admin-brand-subtitle">{{ __('admin.brand.control_center') }}</span>
                    </span>
                </a>
            </div>

            <div class="admin-navbar-center">
                <nav class="admin-topnav" aria-label="Primary">
                    @foreach($navGroups as $group)
                        <div class="dropdown admin-topnav-item">
                            <button
                                class="btn admin-nav-button nav-link menu-link {{ $group['button_class'] }} {{ $group['active'] ? 'active' : '' }}"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="{{ $group['icon'] }}"></i>
                                <span>{{ $group['label'] }}</span>
                            </button>
                            <div class="dropdown-menu admin-topnav-menu dropdown-menu-end">
                                @foreach($group['links'] as $link)
                                    <a href="{{ $link['route'] }}" class="dropdown-item {{ $link['match'] ? 'active' : '' }}">
                                        {{ $link['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </nav>
            </div>

            <div class="admin-navbar-tools">
                <div class="admin-search-shell">
                    <form class="app-search">
                        <div class="position-relative">
                            <input type="text" class="form-control admin-search-input" placeholder="{{ __('admin.nav.search_placeholder') }}" autocomplete="off" id="search-options" value="">
                            <span class="mdi mdi-magnify search-widget-icon"></span>
                            <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" id="search-close-options"></span>
                        </div>
                    </form>
                </div>

                <div class="dropdown admin-locale-dropdown">
                    <button type="button" class="btn admin-locale-button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-global-line"></i>
                        <span>{{ strtoupper($adminLocale) }}</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end admin-topnav-menu">
                        <a href="{{ route('locale.switch', 'en') }}" class="dropdown-item {{ $adminLocale === 'en' ? 'active' : '' }}">{{ __('admin.nav.english') }}</a>
                        <a href="{{ route('locale.switch', 'ar') }}" class="dropdown-item {{ $adminLocale === 'ar' ? 'active' : '' }}">{{ __('admin.nav.arabic') }}</a>
                    </div>
                </div>

                <div class="dropdown topbar-head-dropdown header-item" id="notificationDropdown">
                    <button type="button" class="btn btn-icon btn-topbar material-shadow-none rounded-circle" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                        <i class='bx bx-bell fs-22'></i>
                        @if ($notificationCount > 0)
                            <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">{{ $notificationCount > 99 ? '99+' : $notificationCount }}</span>
                        @endif
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                        <div class="p-3 border-bottom">
                            <h6 class="mb-1">{{ __('admin.notifications.title') }}</h6>
                            <p class="mb-0 text-muted small">{{ __('admin.notifications.subtitle') }}</p>
                        </div>
                        <div class="p-2">
                            <a href="{{ route('admin/orders/index') }}/0/{{ PAGINATION_COUNT }}" class="dropdown-item rounded-3">
                                <div class="fw-semibold">{{ __('admin.notifications.orders') }}</div>
                                <div class="small text-muted">{{ __('admin.notifications.pending_orders', ['count' => number_format($pendingOrdersCount)]) }}</div>
                            </a>
                            <a href="{{ route('admin/products/index') }}/0/{{ PAGINATION_COUNT }}" class="dropdown-item rounded-3">
                                <div class="fw-semibold">{{ __('admin.notifications.products') }}</div>
                                <div class="small text-muted">{{ __('admin.notifications.low_stock', ['count' => number_format($lowStockCount)]) }}</div>
                            </a>
                            <a href="{{ route('admin/users/index') }}/0/{{ PAGINATION_COUNT }}" class="dropdown-item rounded-3">
                                <div class="fw-semibold">{{ __('admin.notifications.users') }}</div>
                                <div class="small text-muted">{{ __('admin.notifications.new_users', ['count' => number_format($newUsersTodayCount)]) }}</div>
                            </a>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ url(route('admin/logout')) }}">
                    @csrf
                    <button type="submit" class="btn admin-logout-button">
                        <i class="mdi mdi-logout"></i>
                        <span>{{ __('admin.nav.logout') }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
