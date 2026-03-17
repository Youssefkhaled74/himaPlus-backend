@php
    $adminLocale = app()->getLocale();
    $isAdminArabic = $adminLocale === 'ar';
@endphp
<!doctype html>
<html lang="{{ $adminLocale }}" dir="{{ $isAdminArabic ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8" />
    <title>{{ __('admin.auth.title') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Admin authentication" name="description" />
    <meta content="HimaPlus" name="author" />
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">

    <script src="{{ asset('admin/assets/js/layout.js') }}"></script>
    <link href="{{ asset($isAdminArabic ? 'admin/assets/css/bootstrap-rtl.min.css' : 'admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset($isAdminArabic ? 'admin/assets/css/app-rtl.min.css' : 'admin/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset($isAdminArabic ? 'admin/assets/css/custom-rtl.min.css' : 'admin/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/assets/css/admin-dashboard.css') }}" rel="stylesheet" type="text/css" />
</head>

<body class="admin-dashboard-shell admin-auth-shell {{ $isAdminArabic ? 'locale-ar' : 'locale-en' }}">
    <main class="admin-auth-page">
        <section class="admin-auth-layout">
            <div class="admin-auth-copy">
                <span class="admin-auth-eyebrow">{{ __('admin.auth.eyebrow') }}</span>
                <a href="{{ url('/') }}" class="admin-auth-brand">
                    <span class="admin-brand-mark">
                        <img src="{{ asset('front/assets/images/newLogo.png') }}" alt="HimaPlus logo">
                    </span>
                    <span class="admin-brand-copy">
                        <span class="admin-brand-title">HimaPlus</span>
                        <span class="admin-brand-subtitle">{{ __('admin.brand.control_center') }}</span>
                    </span>
                </a>
                <h1 class="admin-auth-title">{{ __('admin.auth.headline') }}</h1>
                <p class="admin-auth-text">{{ __('admin.auth.subtitle') }}</p>

                <div class="admin-auth-feature-list">
                    <div class="admin-auth-feature">
                        <i class="ri-layout-grid-line"></i>
                        <span>{{ __('admin.dashboard.quick_actions') }}</span>
                    </div>
                    <div class="admin-auth-feature">
                        <i class="ri-bar-chart-box-line"></i>
                        <span>{{ __('admin.dashboard.monthly_analytics') }}</span>
                    </div>
                    <div class="admin-auth-feature">
                        <i class="ri-shield-check-line"></i>
                        <span>{{ __('admin.dashboard.live_status') }}</span>
                    </div>
                </div>
            </div>

            <div class="admin-auth-card-wrap">
                <div class="card admin-auth-card">
                    <div class="card-body">
                        <div class="admin-auth-card-head">
                            <h2>{{ __('admin.auth.welcome_back') }}</h2>
                            <p>{{ __('admin.auth.sign_in_to_continue') }}</p>
                        </div>

                        @include('flash::message')
                        @if (isset($errors) && $errors->any())
                            <div class="alert alert-danger admin-auth-alert">
                                <ul class="mb-0" dir="ltr">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form role="form" method="POST" action="{{ url(route('admin/check-login')) }}" class="admin-auth-form">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('admin.auth.email') }}</label>
                                <input type="text" name="email" class="form-control" id="email" placeholder="{{ __('admin.auth.email_placeholder') }}">
                            </div>

                            <div class="mb-2">
                                <div class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                    <label class="form-label mb-0" for="password-input">{{ __('admin.auth.password') }}</label>
                                    <a href="#" class="text-muted small">{{ __('admin.auth.forgot_password') }}</a>
                                </div>
                                <div class="position-relative auth-pass-inputgroup">
                                    <input type="password" name="password" class="form-control pe-5 password-input" placeholder="{{ __('admin.auth.password_placeholder') }}" id="password-input">
                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none" type="button" id="password-addon">
                                        <i class="ri-eye-fill align-middle"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="form-check admin-auth-check">
                                <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                <label class="form-check-label" for="auth-remember-check">{{ __('admin.auth.remember_me') }}</label>
                            </div>

                            <button class="btn btn-primary w-100 admin-auth-submit" type="submit">{{ __('admin.auth.sign_in') }}</button>
                        </form>

                        <div class="admin-auth-footer">
                            <p class="mb-0">{{ __('admin.auth.no_account') }} <a href="#" class="fw-semibold">{{ __('admin.auth.signup') }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="{{ asset('admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugins.js') }}"></script>
    <script src="{{ asset('admin/assets/js/pages/password-addon.init.js') }}"></script>
</body>
</html>
