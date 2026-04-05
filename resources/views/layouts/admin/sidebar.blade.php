@php
    $adminId = (int) optional(auth()->guard('admin')->user())->id;
    $superAdminIds = array_map('intval', config('auth.admin_super_ids', []));
    $isSuperAdmin = in_array($adminId, $superAdminIds, true);
    $admin = auth()->guard('admin')->user();
    $adminImage = !empty($admin?->img) ? asset($admin->img) : asset('admin/assets/images/users/avatar-1.jpg');
@endphp

<div class="app-menu navbar-menu">
    <div class="navbar-brand-box">
        <a href="{{ route('admin/index') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('admin/assets/images/logo-sm.png') }}" alt="Hema" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('https://elgmal.dev-x.host/admin/assets/images/settings/169842649442168.png') }}" alt="Hema" height="35">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div class="dropdown sidebar-user rounded">
        <button type="button" class="btn material-shadow-none w-100" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="d-flex align-items-center gap-3">
                <img class="rounded header-profile-user" src="{{ $adminImage }}" alt="Header Avatar">
                <span class="text-start">
                    <span class="d-block fw-medium sidebar-user-name-text">{{ $admin?->name }}</span>
                    <span class="d-block fs-14 sidebar-user-name-sub-text">
                        <i class="ri ri-circle-fill fs-10 text-success align-baseline"></i>
                        <span class="align-middle">Online now</span>
                    </span>
                </span>
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <a class="dropdown-item" href="{{ url(route('admin/admins/info')) }}">
                <i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i>
                <span class="align-middle">Settings</span>
            </a>
            <form method="POST" action="{{ url(route('admin/logout')) }}">
                @csrf
                <button type="submit" class="dropdown-item">
                    <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                    <span class="align-middle">Logout</span>
                </button>
            </form>
        </div>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Operations</span></li>

                @if($isSuperAdmin)
                    <li class="nav-item">
                        <a class="nav-link menu-link sidebaradmins" href="#sidebaradmins" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebaradmins">
                            <i class="ri-shield-user-line"></i>
                            <span data-key="t-admins">Admins</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebaradmins">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('admin/admins/index') }}/0/{{ PAGINATION_COUNT }}" class="nav-link" data-key="t-admins-list">Admins List</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin/admins/create') }}" class="nav-link" data-key="t-admins-add">Add Admin</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link menu-link sidebarinfo" href="#sidebarinfo" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarinfo">
                        <i class="ri-information-line"></i>
                        <span data-key="t-info">Platform Info</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarinfo">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin/info/index') }}/0/{{ PAGINATION_COUNT }}" class="nav-link" data-key="t-info-list">Info Settings</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link sidebarusers" href="#sidebarusers" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarusers">
                        <i class="ri-user-3-line"></i>
                        <span data-key="t-users">Users</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarusers">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin/users/index') }}/0/{{ PAGINATION_COUNT }}" class="nav-link" data-key="t-users-list">Users List</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin/users/create') }}" class="nav-link" data-key="t-users-add">Add User</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link sidebarcoupons" href="#sidebarcoupons" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarcoupons">
                        <i class="ri-coupon-3-line"></i>
                        <span data-key="t-coupons">Coupons</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarcoupons">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin/coupons/index') }}/0/{{ PAGINATION_COUNT }}" class="nav-link" data-key="t-coupons-list">Coupons List</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin/coupons/create') }}" class="nav-link" data-key="t-coupons-add">Add Coupon</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link sidebarcategories" href="#sidebarcategories" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarcategories">
                        <i class="ri-layout-grid-line"></i>
                        <span data-key="t-categories">Categories</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarcategories">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin/categories/index') }}/0/{{ PAGINATION_COUNT }}" class="nav-link" data-key="t-categories-list">Categories List</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin/categories/create') }}" class="nav-link" data-key="t-categories-add">Add Category</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link sidebarcountries" href="#sidebarcountries" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarcountries">
                        <i class="ri-global-line"></i>
                        <span data-key="t-countries">Countries</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarcountries">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin/countries/index') }}/0/{{ PAGINATION_COUNT }}" class="nav-link" data-key="t-countries-list">Countries List</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin/countries/create') }}" class="nav-link" data-key="t-countries-add">Add Country</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link sidebarproducts" href="#sidebarproducts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarproducts">
                        <i class="ri-capsule-line"></i>
                        <span data-key="t-products">Products</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarproducts">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin/products/index') }}/0/{{ PAGINATION_COUNT }}" class="nav-link" data-key="t-products-list">Products List</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin/products/create') }}" class="nav-link" data-key="t-products-add">Add Product</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link sidebarorders" href="#sidebarorders" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarorders">
                        <i class="ri-shopping-bag-3-line"></i>
                        <span data-key="t-orders">Orders</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarorders">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin/orders/index') }}/0/{{ PAGINATION_COUNT }}?tab=orders" class="nav-link" data-key="t-orders-list">Orders List</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin/orders/index') }}/0/{{ PAGINATION_COUNT }}?tab=requests" class="nav-link" data-key="t-requests-list">Requests List</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link sidebarcontacts" href="#sidebarcontacts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarcontacts">
                        <i class="ri-customer-service-2-line"></i>
                        <span data-key="t-contacts">Contacts</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarcontacts">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin/contacts/index') }}/0/{{ PAGINATION_COUNT }}" class="nav-link" data-key="t-contacts-list">Contacts List</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link sidebarratings" href="#sidebarratings" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarratings">
                        <i class="ri-star-smile-line"></i>
                        <span data-key="t-ratings">Ratings</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarratings">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin/ratings/index') }}/0/{{ PAGINATION_COUNT }}" class="nav-link" data-key="t-ratings-list">Ratings List</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="admin-sidebar-footer">
        <div class="d-flex align-items-center justify-content-between gap-2">
            <div>
                <div class="fw-semibold">Healthcare Operations</div>
                <div class="sidebar-footer-copy small text-muted">Clean admin workspace for products, orders, and users.</div>
            </div>
            <span class="badge bg-success-subtle text-success">Live</span>
        </div>
    </div>

    <div class="sidebar-background"></div>
</div>
