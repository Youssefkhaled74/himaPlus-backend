<footer class="footer">
    <div class="container-fluid">
        <div class="admin-footer-shell">
            <div class="admin-footer-main">
                <div class="admin-footer-brand">
                    <span class="admin-footer-dot" aria-hidden="true"></span>
                    <span>{{ __('admin.footer.brand') }}</span>
                </div>
                <p class="admin-footer-subtitle mb-0">{{ __('admin.footer.subtitle') }}</p>
            </div>

            <div class="admin-footer-meta">
                <span class="admin-footer-status">
                    <span class="admin-footer-status__dot" aria-hidden="true"></span>
                    {{ __('admin.footer.status') }}
                </span>
                <div class="admin-footer-copy">{{ __('admin.footer.copyright', ['year' => now()->year]) }}</div>
                <div class="admin-footer-note">{{ __('admin.footer.workflow') }}</div>
            </div>
        </div>
    </div>
</footer>
