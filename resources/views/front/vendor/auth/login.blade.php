@extends('layouts.front.home')

<!-- title page -->
@section('title')
    <title>{{ __('nav.login') }} - Vendor | HemaPulse</title>
@endsection

<!-- custom page -->
@section('css')
    <style>
        .footer {
            display: none;
        }
        .required-star {
            color: #dc3545;
            margin-left: 2px;
        }

        /* Register form extras */
        .hp-dropzone {
            border: 1px dashed #dfe6ef;
            border-radius: 14px;
            background: #f8fafc;
            padding: 28px 18px 22px;
            text-align: center;
            cursor: pointer;
            transition: border-color .2s;
        }
        .hp-dropzone:hover { border-color: #0ea5a4; }
        .hp-upload-circle {
            width: 46px; height: 46px; border-radius: 999px;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(180deg, #11c5b6, #0ea5a4);
            box-shadow: 0 10px 22px rgba(14,165,164,.25);
            margin: 0 auto 10px;
        }
        .hp-drop-hint { font-size: 12px; color: #9aa3af; margin-top: 6px; }
        .hp-drop-link { font-size: 14px; font-weight: 600; color: #2563eb; cursor: pointer; text-decoration: none; }
        .hp-drop-link:hover { text-decoration: underline; }
        #registerForm .form-label { font-size: 14px; font-weight: 700; color: #111827; margin-bottom: 6px; }
        .reg-phone-group { display: flex; border: 1px solid #e0e7ef; border-radius: 12px; overflow: hidden; background: #f4f7fb; }
        .reg-phone-prefix { display: flex; align-items: center; gap: 6px; padding: 0 14px; background: #f0f4fa; border-right: 1px solid #e0e7ef; font-size: 14px; color: #374151; white-space: nowrap; }
        .reg-phone-prefix .flag { display: inline-flex; width: 22px; height: 15px; align-items: center; justify-content: center; background: #16a34a; color: #fff; font-size: 9px; font-weight: 700; border-radius: 3px; }
        .reg-phone-group .hp-input { border: none !important; border-radius: 0 !important; background: transparent !important; box-shadow: none !important; }
        #crFilePreview { font-size: 12px; font-weight: 600; color: #0ea5a4; margin-top: 8px; }

        /* Enhanced flash notification */
        .hp-flash-wrap {
            padding: 16px 20px 0;
        }
        .hp-flash {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            border-radius: 14px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            margin: 0;
            animation: hp-flash-in .35s cubic-bezier(.22,.68,0,1.2) both;
        }
        .hp-flash.alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #ecfdf5 100%);
            color: #065f46;
            border-left: 4px solid #10b981;
            box-shadow: 0 4px 16px rgba(16,185,129,.15);
        }
        .hp-flash.alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fff5f5 100%);
            color: #991b1b;
            border-left: 4px solid #ef4444;
            box-shadow: 0 4px 16px rgba(239,68,68,.15);
        }
        .hp-flash.alert-warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fffbeb 100%);
            color: #92400e;
            border-left: 4px solid #f59e0b;
            box-shadow: 0 4px 16px rgba(245,158,11,.15);
        }
        .hp-flash.alert-info {
            background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
            color: #1e40af;
            border-left: 4px solid #3b82f6;
            box-shadow: 0 4px 16px rgba(59,130,246,.15);
        }
        .hp-flash-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }
        .alert-success .hp-flash-icon  { background: rgba(16,185,129,.15); color: #059669; }
        .alert-danger  .hp-flash-icon  { background: rgba(239,68,68,.15);  color: #dc2626; }
        .alert-warning .hp-flash-icon  { background: rgba(245,158,11,.15); color: #d97706; }
        .alert-info    .hp-flash-icon  { background: rgba(59,130,246,.15); color: #2563eb; }
        .hp-flash-text { flex: 1; line-height: 1.5; }
        @keyframes hp-flash-in {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0);    }
        }
    </style>
@endsection

@section('content')
    <main class="hp-main">
        <div class="container">
            <section id="page-login" class="hp-page active align-items-center">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-6">
                        <div class="hp-card card">
                            @php
                                $flashMessages = session('flash_notification', collect())->toArray();
                            @endphp
                            @if(!empty($flashMessages))
                                <div class="hp-flash-wrap">
                                    @foreach($flashMessages as $msg)
                                        @php
                                            $icons = [
                                                'success' => 'bi-check-circle-fill',
                                                'danger'  => 'bi-x-circle-fill',
                                                'warning' => 'bi-exclamation-triangle-fill',
                                                'info'    => 'bi-info-circle-fill',
                                            ];
                                            $icon = $icons[$msg['level']] ?? 'bi-info-circle-fill';
                                        @endphp
                                        <div class="hp-flash alert alert-{{ $msg['level'] }}" role="alert">
                                            <div class="hp-flash-icon"><i class="bi {{ $icon }}"></i></div>
                                            <div class="hp-flash-text">{!! $msg['message'] !!}</div>
                                        </div>
                                    @endforeach
                                </div>
                                {{ session()->forget('flash_notification') }}
                            @endif
                            @if ($errors->any())
                                <div style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}; margin: 15px;">
                                    <ul dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                                        @foreach ($errors->all() as $error)
                                            <li class="text-danger">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="card-body p-4 p-lg-5">
                                <div class="hp-tabs d-flex gap-4 justify-content-center mb-4">
                                    <a class="hp-tab active" data-target="#page-login">{{ __('nav.login') }}</a>
                                    <a class="hp-tab" data-target="#page-register">{{ __('nav.register') }}</a>
                                </div>

                                <form method="POST" action="{{ route('vendor/check/login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('profile.email') }} <span class="required-star">*</span></label>
                                        <input name="email" type="email" class="form-control hp-input" placeholder="Enter your Email">
                                    </div>

                                    <div class="mb-2 position-relative">
                                        <label class="form-label">{{ __('profile.password') }} <span class="required-star">*</span></label>
                                        <div class="position-relative">
                                            <input name="password" type="password" class="form-control hp-input hp-input--password" placeholder="Enter your password">
                                            <button class="hp-eye-btn" type="button"><i class="bi bi-eye-slash"></i></button>
                                        </div>
                                    </div>
    
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="rememberMe">
                                            <label class="form-check-label small" for="rememberMe">{{ __('profile.remember_me') }}</label>
                                        </div>
                                        <a class="hp-link small" href="{{ route('vendor/send-reset-code/form') }}">{{ __('profile.forgot_password') }}?</a>
                                    </div>
    
                                    <button class="btn hp-btn-gradient w-100 hp-btn-disabled" type="submit" disabled>{{ __('nav.login') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="page-register" class="hp-page align-items-center">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-7">
                        <div class="hp-card card">
                            <div class="card-body p-4 p-lg-5">
                                <div class="hp-tabs d-flex gap-4 justify-content-center mb-4">
                                    <a class="hp-tab" data-target="#page-login">{{ __('nav.login') }}</a>
                                    <a class="hp-tab active" data-target="#page-register">{{ __('nav.register') }}</a>
                                </div>

                                @if ($errors->any())
                                    <div class="mb-3" style="text-align:{{ app()->getLocale()=='ar'?'right':'left' }}">
                                        <ul dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}" class="ps-3">
                                            @foreach ($errors->all() as $error)
                                                <li class="text-danger small">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form id="registerForm" method="POST"
                                      action="{{ route('vendor/register/store') }}"
                                      enctype="multipart/form-data">
                                    @csrf

                                    {{-- User Type --}}
                                    <div class="mb-3">
                                        <label class="form-label">User Type Selector <span class="required-star">*</span></label>
                                        <select name="user_type" id="regUserType" required class="form-control hp-input">
                                            <option value="" disabled {{ old('user_type') ? '' : 'selected' }}>Select Account Type</option>
                                            <option value="1" {{ old('user_type')==1?'selected':'' }}>User</option>
                                            <option value="2" {{ old('user_type')==2?'selected':'' }}>Vendor</option>
                                        </select>
                                    </div>

                                    {{-- User fields (Hospital name) --}}
                                    <div id="userFields" style="display:none;">
                                        <div class="mb-3">
                                            <label class="form-label">Hospital / Clinic Name <span class="required-star">*</span></label>
                                            <input name="name" value="{{ old('name') }}" data-required-user="1"
                                                   placeholder="Enter Name" class="form-control hp-input">
                                        </div>
                                    </div>

                                    {{-- Vendor fields --}}
                                    <div id="vendorFields" style="display:none;">
                                        <div class="mb-3">
                                            <label class="form-label">Supplier Name <span class="required-star">*</span></label>
                                            <input name="name" value="{{ old('name') }}" data-required-vendor="1"
                                                   placeholder="e.g., SaudiMed Co." class="form-control hp-input">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">IBAN <span class="required-star">*</span></label>
                                                <input name="iban" value="{{ old('iban') }}" data-required-vendor="1"
                                                       placeholder="Enter IBAN" class="form-control hp-input">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">CR Number <span class="required-star">*</span></label>
                                                <input name="cr_number" value="{{ old('cr_number') }}" data-required-vendor="1"
                                                       placeholder="Enter CR number" class="form-control hp-input">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Tax Number <span class="text-muted small">(Optional)</span></label>
                                                <input name="tax_number" value="{{ old('tax_number') }}"
                                                       placeholder="Enter tax number" class="form-control hp-input">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Location <span class="required-star">*</span></label>
                                                <input name="location" value="{{ old('location') }}" data-required-vendor="1"
                                                       placeholder="Enter location" class="form-control hp-input">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Phone --}}
                                    <div class="mb-3">
                                        <label class="form-label">Phone Number <span class="required-star">*</span></label>
                                        <div class="reg-phone-group">
                                            <div class="reg-phone-prefix">
                                                <span class="flag">SA</span>
                                                <span>+966</span>
                                            </div>
                                            <input name="mobile" value="{{ old('mobile') }}" required
                                                   placeholder="xxxxxxxxx" class="form-control hp-input">
                                        </div>
                                    </div>

                                    {{-- Email --}}
                                    <div class="mb-3">
                                        <label class="form-label">Email <span class="required-star">*</span></label>
                                        <input name="email" type="email" value="{{ old('email') }}" required
                                               placeholder="Enter your email" class="form-control hp-input">
                                    </div>

                                    {{-- CR Document upload (Vendor only) --}}
                                    <div id="vendorUpload" style="display:none;" class="mb-3">
                                        <label class="form-label">Upload CR Document <span class="required-star">*</span></label>
                                        <div class="hp-dropzone" id="crDropzone">
                                            <input name="cr_file_document" type="file" class="d-none" id="crDocInput" accept="image/*,.pdf">
                                            <div class="hp-upload-circle">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                                    <path d="M12 16V4" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                                    <path d="M7 9L12 4L17 9" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </div>
                                            <a id="crDocLink" class="hp-drop-link d-block mt-1">Choose file to upload</a>
                                            <div class="hp-drop-hint">PDF or Image (JPG, PNG)</div>
                                            <div id="crFilePreview" class="d-none"></div>
                                        </div>
                                    </div>

                                    {{-- Password --}}
                                    <div class="mb-3 position-relative">
                                        <label class="form-label">Password <span class="required-star">*</span></label>
                                        <div class="position-relative">
                                            <input name="password" id="regPassword" type="password" required
                                                   placeholder="Enter your password" class="form-control hp-input hp-input--password">
                                            <button class="hp-eye-btn" type="button" data-target="regPassword"><i class="bi bi-eye-slash"></i></button>
                                        </div>
                                    </div>

                                    {{-- Confirm Password --}}
                                    <div class="mb-3 position-relative">
                                        <label class="form-label">Confirm Password <span class="required-star">*</span></label>
                                        <div class="position-relative">
                                            <input name="password_confirmation" id="regPasswordConfirm" type="password" required
                                                   placeholder="Re-enter your password" class="form-control hp-input hp-input--password">
                                            <button class="hp-eye-btn" type="button" data-target="regPasswordConfirm"><i class="bi bi-eye-slash"></i></button>
                                        </div>
                                    </div>

                                    {{-- Terms --}}
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="terms" id="regTerms" value="1" required>
                                        <label class="form-check-label small" for="regTerms">
                                            <span class="required-star">*</span> I agree to
                                            <a href="#" class="hp-link">Terms</a> &amp;
                                            <a href="#" class="hp-link">Privacy Policy</a>
                                        </label>
                                    </div>

                                    <button id="regSubmitBtn" type="submit" disabled
                                            class="btn hp-btn-gradient w-100 hp-btn-disabled">
                                        {{ __('nav.register') ?? 'Sign Up' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script>
        // Tab switching functionality
        document.querySelectorAll('.hp-tab').forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all tabs
                document.querySelectorAll('.hp-tab').forEach(t => t.classList.remove('active'));
                
                // Add active class to clicked tab
                this.classList.add('active');
                
                // Hide all sections
                document.querySelectorAll('.hp-page').forEach(section => {
                    section.classList.remove('active');
                });
                
                // Show target section
                const target = this.getAttribute('data-target');
                document.querySelector(target).classList.add('active');
            });
        });

        // Password visibility toggle
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

        // Enable submit button when login form is filled
        document.querySelectorAll('form').forEach(form => {
            if (form.id === 'registerForm') return; // handled separately
            form.addEventListener('input', function() {
                const inputs = this.querySelectorAll('input[type="email"], input[type="password"]');
                const allFilled = Array.from(inputs).every(input => input.value.trim() !== '');
                const submitBtn = this.querySelector('button[type="submit"]');
                if (allFilled) {
                    submitBtn.classList.remove('hp-btn-disabled');
                    submitBtn.disabled = false;
                } else {
                    submitBtn.classList.add('hp-btn-disabled');
                    submitBtn.disabled = true;
                }
            });
        });

        // ── Register form logic ──────────────────────────────────────────────
        (function () {
            const regUserType  = document.getElementById('regUserType');
            const userFields   = document.getElementById('userFields');
            const vendorFields = document.getElementById('vendorFields');
            const vendorUpload = document.getElementById('vendorUpload');
            const crDocInput   = document.getElementById('crDocInput');
            const crDocLink    = document.getElementById('crDocLink');
            const crDropzone   = document.getElementById('crDropzone');
            const crFilePreview= document.getElementById('crFilePreview');
            const regForm      = document.getElementById('registerForm');
            const regSubmit    = document.getElementById('regSubmitBtn');
            const regTerms     = document.getElementById('regTerms');

            function vendorRequired() {
                return Array.from(regForm.querySelectorAll('[data-required-vendor="1"]'));
            }
            function userRequired() {
                return Array.from(regForm.querySelectorAll('[data-required-user="1"]'));
            }

            function setMode(type) {
                const isVendor = type === '2';
                const isUser   = type === '1';
                vendorFields.style.display = isVendor ? '' : 'none';
                vendorUpload.style.display = isVendor ? '' : 'none';
                userFields.style.display   = isUser   ? '' : 'none';
                vendorRequired().forEach(el => el.required = isVendor);
                userRequired().forEach(el => el.required = isUser);
                if (crDocInput) crDocInput.required = isVendor;
                validate();
            }

            function setSubmit(ok) {
                regSubmit.disabled = !ok;
                if (ok) {
                    regSubmit.classList.remove('hp-btn-disabled');
                } else {
                    regSubmit.classList.add('hp-btn-disabled');
                }
            }

            function validate() {
                const type = regUserType ? regUserType.value : '';
                const isVendor = type === '2';
                let ok = true;

                ['mobile', 'email', 'password', 'password_confirmation'].forEach(name => {
                    const el = regForm.querySelector(`[name="${name}"]`);
                    if (!el || !el.value.trim()) ok = false;
                });
                if (!type) ok = false;

                if (isVendor) {
                    vendorRequired().forEach(el => { if (!el.value.trim()) ok = false; });
                    if (!crDocInput || !crDocInput.files || crDocInput.files.length === 0) ok = false;
                } else if (type === '1') {
                    userRequired().forEach(el => { if (!el.value.trim()) ok = false; });
                }

                if (!regTerms || !regTerms.checked) ok = false;
                setSubmit(ok);
            }

            regUserType && regUserType.addEventListener('change', () => setMode(regUserType.value));
            regForm.addEventListener('input', validate);
            regForm.addEventListener('change', validate);

            // Dropzone click
            if (crDocLink && crDocInput) {
                crDocLink.addEventListener('click', e => { e.preventDefault(); crDocInput.click(); });
            }
            if (crDropzone && crDocInput) {
                crDropzone.addEventListener('click', e => {
                    if (e.target !== crDocLink) crDocInput.click();
                });
            }
            if (crDocInput) {
                crDocInput.addEventListener('change', () => {
                    if (crDocInput.files.length) {
                        crFilePreview.textContent = '✓ ' + crDocInput.files[0].name;
                        crFilePreview.classList.remove('d-none');
                    } else {
                        crFilePreview.classList.add('d-none');
                    }
                    validate();
                });
            }

            // Eye toggle for register passwords
            document.querySelectorAll('.hp-eye-btn[data-target]').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const input = document.getElementById(this.getAttribute('data-target'));
                    const icon  = this.querySelector('i');
                    if (!input) return;
                    const isPass = input.type === 'password';
                    input.type = isPass ? 'text' : 'password';
                    icon.classList.toggle('bi-eye-slash', !isPass);
                    icon.classList.toggle('bi-eye', isPass);
                });
            });

            // Auto-open register tab when there are old inputs (after failed register submit)
            const hasOld = {{ old('user_type') || old('email') || old('mobile') || old('name') ? 'true' : 'false' }};
            if (hasOld) {
                document.querySelectorAll('.hp-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.hp-page').forEach(s => s.classList.remove('active'));
                document.querySelectorAll('[data-target="#page-register"]').forEach(t => t.classList.add('active'));
                document.querySelector('#page-register').classList.add('active');
            }

            // Restore mode from old input
            if (regUserType && regUserType.value) setMode(regUserType.value);
        })();
    </script>
@endsection
