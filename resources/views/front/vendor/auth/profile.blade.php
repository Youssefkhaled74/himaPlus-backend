@extends('layouts.front.home')

<!-- title page -->
@section('title')
    <title>{{ __('profile.my_profile') }} - Vendor | HemaPulse</title>
@endsection

<!-- custom page -->
@section('css')
    <style></style>
@endsection

@section('content')

    @php
        $user = auth()->user();
    @endphp
    <main class="container my-4" style="max-width: 80%;">
        @include('flash::message')
        @if ($errors->any())
            <div style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}; margin: 15px;">
                <ul dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                    @foreach ($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <nav class="breadcrumb-custom mb-3" style="margin-top: 8%;">
            <a href="{{ route('vendor/dashboard') }}" class="text-decoration-none text-muted">{{ __('nav.dashboard') ?? 'Dashboard' }}</a>
            <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
            <span class="text-primary fw-semibold" id="section-area-name">{{ __('profile.my_profile') }}</span>
        </nav>

        <div class="row g-4" style="margin-bottom: 12%;">
            <div class="col-lg-3">
                <div class="profile-side">
                    <a class="btn-tab active" section-name="{{ __('profile.personal_info') }}" data-target="#profile-pane" href="#profile-pane">
                        <i class="bi bi-person"></i> <span>{{ __('profile.personal_info_short') }}</span>
                    </a>
                    <a class="btn-tab" section-name="{{ __('profile.company_info') ?? 'Company Info' }}" data-target="#company-pane" href="#company-pane">
                        <i class="bi bi-building"></i> <span>{{ __('profile.company_info') ?? 'Company Info' }}</span>
                    </a>
                    <a class="btn-tab" section-name="{{ __('profile.change_password') }}" data-target="#password-pane" href="#password-pane">
                        <i class="bi bi-shield-lock"></i> <span>{{ __('profile.change_password') }}</span>
                    </a>
                    <a class="btn-tab" section-name="{{ __('profile.language') }}" data-target="#language-pane" href="#language-pane">
                        <i class="bi bi-translate"></i> <span>{{ __('profile.language') }}</span>
                    </a>
                    <a class="custom-btn-tab" href="{{ route('vendor/logout') }}">
                        <i class="bi bi-box-arrow-right"></i> <span>{{ __('profile.logout') }}</span>
                    </a>
                </div>
            </div>

            <!-- Personal Info Pane -->
            <div class="col-lg-9 tab-pane" id="profile-pane">
                <div class="detail-card reveal">
                    <form action="{{ route('vendor/update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="avatar rounded-circle mx-auto mb-2" style="width:72px;height:72px;background:#E9EDF7;display:flex;align-items:center;justify-content:center;cursor:pointer;overflow:hidden;position:relative;">
                                <i class="bi bi-person" style="font-size:28px;color:#456;"></i>
                                <input id="avatarInput" type="file" accept="image/*" hidden name="file">
                            </label>
                            <img id="avatarPreview" alt="preview" style="width:120px;height:120px;border-radius:50%;object-fit:cover;" src="{{ asset($user?->img) }}">
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">{{ __('profile.company_name') ?? 'Company Name' }}</label>
                                <input name="name" class="form-control" value="{{ $user?->name }}">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">{{ __('profile.phone_number') }}</label>
                                <div class="input-group">
                                    <input name="mobile" class="form-control" value="{{ $user?->mobile }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ __('profile.email') }}</label>
                                <input name="email" class="form-control" value="{{ $user?->email }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ __('profile.location') }}</label>
                                <input name="location" class="form-control" value="{{ $user?->location }}">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <button class="btn btn-gradient" type="submit">{{ __('profile.edit_profile') }}</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Company Info Pane -->
            <div class="col-lg-9 tab-pane d-none" id="company-pane">
                <div class="detail-card reveal">
                    <form action="{{ route('vendor/update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <h6 class="mb-3">{{ __('profile.company_info') ?? 'Company Information' }}</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('profile.branch') ?? 'Branch' }}</label>
                                <input name="branch" class="form-control" value="{{ $user?->branch }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('profile.iban') ?? 'IBAN' }}</label>
                                <input name="iban" class="form-control" value="{{ $user?->iban }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('profile.tax_number') ?? 'Tax Number' }}</label>
                                <input name="tax_number" class="form-control" value="{{ $user?->tax_number }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('profile.cr_number') ?? 'CR Number' }}</label>
                                <input name="cr_number" class="form-control" value="{{ $user?->cr_number }}">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <button class="btn btn-gradient" type="submit">{{ __('profile.edit_profile') }}</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password Pane -->
            <div class="col-lg-9 tab-pane d-none" id="password-pane">
                <form method="POST" action="{{ route('vendor/changePassword') }}">
                    @csrf
                    <div class="detail-card reveal">
                        <h6 class="mb-3">{{ __('profile.create_new_password') }}</h6>
                        <label class="form-label">{{ __('profile.current_password') }}</label>
                        <div class="position-relative mb-3">
                            <input name="old_password" type="password" class="form-control hp-input--password" placeholder="Enter current password">
                            <button class="hp-eye-btn" type="button"><i class="bi bi-eye-slash"></i></button>
                        </div>

                        <label class="form-label">{{ __('profile.new_password') ?? 'New Password' }}</label>
                        <div class="position-relative mb-3">
                            <input name="password" type="password" class="form-control hp-input--password" placeholder="Enter new password">
                            <button class="hp-eye-btn" type="button"><i class="bi bi-eye-slash"></i></button>
                        </div>

                        <label class="form-label">{{ __('profile.confirm_password') ?? 'Confirm Password' }}</label>
                        <div class="position-relative mb-3">
                            <input name="password_confirmation" type="password" class="form-control hp-input--password" placeholder="Confirm new password">
                            <button class="hp-eye-btn" type="button"><i class="bi bi-eye-slash"></i></button>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="btn btn-gradient" type="submit">{{ __('profile.change_password') }}</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Language Pane -->
            <div class="col-lg-9 tab-pane d-none" id="language-pane">
                <form method="POST" action="{{ route('vendor/lang/update') }}">
                    @csrf
                    <div class="detail-card reveal">
                        <h6 class="mb-3">{{ __('profile.language') }}</h6>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">{{ __('profile.select_language') ?? 'Select Language' }}</label>
                                <select name="lang" class="form-select">
                                    <option value="en" {{ $user?->lang == 'en' ? 'selected' : '' }}>English</option>
                                    <option value="ar" {{ $user?->lang == 'ar' ? 'selected' : '' }}>العربية</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <button class="btn btn-gradient" type="submit">{{ __('profile.update') ?? 'Update' }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        // Tab switching
        document.querySelectorAll('.btn-tab').forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Update breadcrumb
                const sectionName = this.getAttribute('section-name');
                document.getElementById('section-area-name').textContent = sectionName;
                
                // Remove active class from all tabs
                document.querySelectorAll('.btn-tab').forEach(t => t.classList.remove('active'));
                
                // Add active class to clicked tab
                this.classList.add('active');
                
                // Hide all panes
                document.querySelectorAll('.tab-pane').forEach(pane => {
                    pane.classList.add('d-none');
                });
                
                // Show target pane
                const target = this.getAttribute('data-target');
                document.querySelector(target).classList.remove('d-none');
            });
        });

        // Avatar upload preview
        document.getElementById('avatarInput')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('avatarPreview').src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Password eye button toggle
        document.querySelectorAll('.hp-eye-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const input = this.parentElement.querySelector('input');
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                }
            });
        });
    </script>
@endsection
