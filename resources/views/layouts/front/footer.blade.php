@php
    $isVendorAuthed = auth()->check() && (int) auth()->user()->user_type === 2;
@endphp

<footer class="footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="logo mb-3">
                    <img src="{{ asset('front/assets/images/WhatsApp Image 2025-09-06 at 14.00.40_dfdafdc6 2.png') }}" alt="HemaPulse">
                </div>
                <p>{{ __('nav.footer_desc') }}</p>
            </div>

            <div class="col-6 col-md-2">
                <h6>{{ __('nav.site_map') }}</h6>
                <ul class="list-unstyled">
                    @if($isVendorAuthed)
                        <li><a href="{{ route('vendor/dashboard') }}">{{ __('nav.home') }}</a></li>
                        <li><a href="{{ route('aboutUs') }}">{{ __('nav.about_us') }}</a></li>
                        <li><a href="{{ route('vendor/products') }}">{{ __('nav.products') }}</a></li>
                        <li><a href="{{ route('vendor/orders', ['tab' => 'quotations']) }}">{{ __('nav.requests') }}</a></li>
                        <li><a href="{{ route('vendor/orders') }}">{{ __('nav.orders') }}</a></li>
                        <li><a href="{{ route('contactUs') }}">{{ __('nav.contact_us') }}</a></li>
                    @else
                        <li><a href="#services" data-anchor="#services">{{ __('nav.services') }}</a></li>
                        <li><a href="{{ route('categories') }}">{{ __('nav.categories') }}</a></li>
                        <li><a href="{{ route('products') }}">{{ __('nav.products') }}</a></li>
                        <li><a href="{{ route('user/myorders', 'all') }}">{{ __('nav.orders') }}</a></li>
                        <li><a href="{{ route('contactUs') }}">{{ __('nav.contact_us') }}</a></li>
                    @endif
                </ul>
            </div>

            <div class="col-6 col-md-3">
                <h6>{{ __('nav.contact_us') }}</h6>
                <p class="mb-1"><i class="bi bi-telephone me-2"></i>+966 1760 2222</p>
                <p class="mb-1"><i class="bi bi-envelope me-2"></i>support@hemapulse.com</p>
                <div class="social">
                    <i class="bi bi-facebook"></i>
                    <i class="bi bi-twitter-x"></i>
                    <i class="bi bi-linkedin"></i>
                    <i class="bi bi-instagram"></i>
                </div>
            </div>

            <div class="col-md-3">
                <h6>{{ __('nav.discover_app') }}</h6>
                <div class="app-badges">
                    <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="App Store">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play">
                </div>
            </div>
        </div>

        <div class="divider"></div>
        <div class="d-flex flex-column flex-md-row justify-content-between small">
            <span>{{ __('nav.copyright') }}</span>
            <span>{{ __('nav.powered_by') }}</span>
        </div>
    </div>

    <a href="#" class="scrolltop btn btn-gradient text-white"><i class="bi bi-arrow-up"></i></a>
</footer>
