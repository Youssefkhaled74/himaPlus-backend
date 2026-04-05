@php
    $admin = auth()->guard('admin')->user();
    $adminLocale = app()->getLocale();
    $adminId = (int) optional($admin)->id;
    $superAdminIds = array_map('intval', config('auth.admin_super_ids', []));
    $isSuperAdmin = in_array($adminId, $superAdminIds, true);
    $navGroups = [
        [
            'label' => __('admin.nav.home'),
            'icon' => 'ri-home-5-line',
            'active' => request()->routeIs('admin/index'),
            'primary_route' => route('admin/index'),
            'links' => [
                ['label' => __('admin.nav.dashboard'), 'route' => route('admin/index'), 'match' => request()->routeIs('admin/index')],
                ['label' => __('admin.nav.platform_info'), 'route' => route('admin/info/index') . '/0/' . PAGINATION_COUNT, 'match' => request()->routeIs('admin/info/*')],
            ],
        ],
        [
            'label' => __('admin.nav.catalog'),
            'icon' => 'ri-layout-grid-line',
            'active' => request()->routeIs('admin/products/*') || request()->routeIs('admin/categories/*') || request()->routeIs('admin/countries/*'),
            'primary_route' => route('admin/products/index') . '/0/' . PAGINATION_COUNT,
            'links' => [
                ['label' => __('admin.nav.products'), 'route' => route('admin/products/index') . '/0/' . PAGINATION_COUNT, 'match' => request()->routeIs('admin/products/*')],
                ['label' => __('admin.nav.categories'), 'route' => route('admin/categories/index') . '/0/' . PAGINATION_COUNT, 'match' => request()->routeIs('admin/categories/*')],
                ['label' => __('admin.nav.countries'), 'route' => route('admin/countries/index') . '/0/' . PAGINATION_COUNT, 'match' => request()->routeIs('admin/countries/*')],
            ],
        ],
        [
            'label' => __('admin.nav.orders'),
            'icon' => 'ri-shopping-bag-3-line',
            'active' => request()->routeIs('admin/orders/*') || request()->routeIs('admin/ratings/*'),
            'primary_route' => route('admin/orders/index') . '/0/' . PAGINATION_COUNT,
            'links' => [
                ['label' => __('admin.nav.orders'), 'route' => route('admin/orders/index') . '/0/' . PAGINATION_COUNT, 'match' => request()->routeIs('admin/orders/*')],
                ['label' => __('admin.nav.ratings'), 'route' => route('admin/ratings/index') . '/0/' . PAGINATION_COUNT, 'match' => request()->routeIs('admin/ratings/*')],
            ],
        ],
        [
            'label' => __('admin.nav.users'),
            'icon' => 'ri-team-line',
            'active' => request()->routeIs('admin/users/*') || request()->routeIs('admin/contacts/*'),
            'primary_route' => route('admin/users/index') . '/0/' . PAGINATION_COUNT,
            'links' => [
                ['label' => __('admin.nav.users'), 'route' => route('admin/users/index') . '/0/' . PAGINATION_COUNT, 'match' => request()->routeIs('admin/users/*')],
                ['label' => __('admin.nav.contacts'), 'route' => route('admin/contacts/index') . '/0/' . PAGINATION_COUNT, 'match' => request()->routeIs('admin/contacts/*')],
            ],
        ],
    ];

    $settingsLinks = array_values(array_filter([
        ['label' => __('admin.nav.platform_info'), 'route' => route('admin/info/index') . '/0/' . PAGINATION_COUNT, 'match' => request()->routeIs('admin/info/*'), 'icon' => 'ri-settings-3-line'],
        ['label' => __('admin.nav.coupons'), 'route' => route('admin/coupons/index') . '/0/' . PAGINATION_COUNT, 'match' => request()->routeIs('admin/coupons/*'), 'icon' => 'ri-coupon-3-line'],
        $isSuperAdmin ? ['label' => __('admin.nav.admins'), 'route' => route('admin/admins/index') . '/0/' . PAGINATION_COUNT, 'match' => request()->routeIs('admin/admins/*'), 'icon' => 'ri-shield-user-line'] : null,
    ]));
@endphp

<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header admin-navbar-rebuilt">
            <div class="admin-navbar-brand">
                <a href="{{ route('admin/index') }}" class="admin-brand-link">
                    <span class="admin-brand-mark">
                        <img src="{{ asset('front/assets/images/newLogo.png') }}" alt="Hema logo">
                    </span>
                    <span class="admin-brand-copy">
                        <span class="admin-brand-title">Hema</span>
                        <span class="admin-brand-subtitle">{{ __('admin.brand.control_center') }}</span>
                    </span>
                </a>
            </div>

            <button
                class="btn admin-navbar-mobile-toggle d-xl-none"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#adminTopbarCollapse"
                aria-controls="adminTopbarCollapse"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="ri-menu-line"></i>
            </button>

            <div class="collapse admin-navbar-collapse" id="adminTopbarCollapse">
                <div class="admin-navbar-center">
                    <nav class="admin-topnav" aria-label="Primary">
                        @foreach($navGroups as $group)
                            <div class="dropdown admin-topnav-item {{ count($group['links']) > 0 ? 'has-submenu' : '' }}">
                                <a
                                    href="{{ $group['primary_route'] }}"
                                    class="btn admin-nav-button {{ $group['active'] ? 'active' : '' }}">
                                    <i class="{{ $group['icon'] }}"></i>
                                    <span>{{ $group['label'] }}</span>
                                </a>

                                @if (count($group['links']) > 0)
                                    <button
                                        class="btn admin-nav-toggle {{ $group['active'] ? 'active' : '' }}"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        aria-label="{{ $group['label'] }}">
                                        <i class="ri-arrow-down-s-line"></i>
                                    </button>
                                    <div class="dropdown-menu admin-topnav-menu dropdown-menu-end">
                                        @foreach($group['links'] as $link)
                                            <a href="{{ $link['route'] }}" class="dropdown-item {{ !empty($link['match']) ? 'active' : '' }}">
                                                <span>{{ $link['label'] }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </nav>
                </div>

                <div class="admin-navbar-actions">
                    <div class="dropdown admin-utility-dropdown">
                        <button
                            class="btn admin-utility-button {{ request()->routeIs('admin/info/*') || request()->routeIs('admin/coupons/*') || request()->routeIs('admin/admins/*') ? 'active' : '' }}"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            aria-label="{{ __('admin.nav.settings') }}">
                            <i class="ri-settings-3-line"></i>
                        </button>
                        <div class="dropdown-menu admin-topnav-menu dropdown-menu-end">
                            @foreach($settingsLinks as $link)
                                <a href="{{ $link['route'] }}" class="dropdown-item {{ !empty($link['match']) ? 'active' : '' }}">
                                    <i class="{{ $link['icon'] }}"></i>
                                    <span>{{ $link['label'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="dropdown admin-utility-dropdown">
                        <button
                            class="btn admin-utility-button"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            aria-label="{{ __('admin.nav.language') }}">
                            <i class="ri-global-line"></i>
                        </button>
                        <div class="dropdown-menu admin-topnav-menu dropdown-menu-end">
                            <a href="{{ route('locale.switch', 'en') }}" class="dropdown-item {{ $adminLocale === 'en' ? 'active' : '' }}">
                                <i class="ri-global-line"></i>
                                <span>{{ __('admin.nav.english') }}</span>
                            </a>
                            <a href="{{ route('locale.switch', 'ar') }}" class="dropdown-item {{ $adminLocale === 'ar' ? 'active' : '' }}">
                                <i class="ri-global-line"></i>
                                <span>{{ __('admin.nav.arabic') }}</span>
                            </a>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin/logout') }}" class="admin-logout-form">
                        @csrf
                        <button type="submit" class="btn admin-logout-pill">
                            <i class="ri-logout-box-r-line"></i>
                            <span>{{ __('admin.nav.logout') }}</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
