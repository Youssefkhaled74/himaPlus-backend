<footer class="footer footer--brand">
    <div class="footer-container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="/" class="footer-brand__link" aria-label="HemaPulse">
                    <img src="{{ asset('front/assets/images/newLogo.png') }}" alt="HemaPulse logo" class="footer-brand__logo">
                </a>
                <p class="footer-brand__desc">{{ __('nav.footer_desc') }}</p>
            </div>

            <nav class="footer-links" aria-label="{{ __('nav.site_map') }}">
                <h3 class="footer-title">{{ __('nav.site_map') }}</h3>
                <a href="/">{{ __('nav.home') }}</a>
                <a href="/">{{ __('nav.about_us') }}</a>
                <a href="/">{{ __('nav.categories') }}</a>
                <a href="/">{{ __('nav.orders') }}</a>
                <a href="/">{{ __('nav.contact_us') }}</a>
            </nav>

            <div class="footer-contact-block">
                <h3 class="footer-title">{{ __('nav.contact_us') }}</h3>
                <a href="tel:+96617602222" class="footer-contact-item">
                    <i class="fas fa-phone-alt"></i>
                    <span>+966 17602222</span>
                </a>
                <a href="mailto:HemaPulse@gmail.com" class="footer-contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>HemaPulse@gmail.com</span>
                </a>
                <span class="footer-contact-item footer-contact-address">
                    <i class="fas fa-location-arrow"></i>
                    <span>{{ __('nav.footer_address') }}</span>
                </span>
            </div>

            <div class="footer-social-block">
                <div class="footer-socials" aria-label="Social links">
                    <a href="#" aria-label="X">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                    <a href="#" aria-label="Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="#" aria-label="LinkedIn">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                    <a href="#" aria-label="Instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </div>

                <h3 class="footer-title footer-title--apps">{{ __('nav.discover_app') }}</h3>
                <div class="footer-apps">
                    <a href="#" class="footer-app-badge" aria-label="Download on the App Store">
                        <i class="fa-brands fa-apple"></i>
                        <span>
                            <small>Download on the</small>
                            <strong>App Store</strong>
                        </span>
                    </a>
                    <a href="#" class="footer-app-badge" aria-label="Get it on Google Play">
                        <i class="fa-brands fa-google-play"></i>
                        <span>
                            <small>GET IT ON</small>
                            <strong>Google Play</strong>
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <div class="footer-divider"></div>

        <div class="footer-bottom">
            <p class="footer-copyright">{{ __('nav.copyright') }}</p>
            <p class="footer-powered">{{ __('nav.powered_by') }}</p>
        </div>
    </div>

    <a href="#" class="scrolltop btn btn-gradient text-white"><i class="bi bi-arrow-up"></i></a>
</footer>
