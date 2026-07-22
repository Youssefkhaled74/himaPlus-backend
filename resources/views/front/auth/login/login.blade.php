@extends('layouts.front.home')

<!-- title page -->
@section('title')
    <title>{{ __('auth.title') }}</title>
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

        /* Enhanced flash notification */
        .hp-flash-wrap { padding: 16px 20px 0; }
        .hp-flash {
            display: flex; align-items: center; gap: 12px;
            padding: 14px 18px; border-radius: 14px;
            font-size: 14px; font-weight: 600; border: none; margin: 0;
            animation: hp-flash-in .35s cubic-bezier(.22,.68,0,1.2) both;
        }
        .hp-flash.alert-success { background: linear-gradient(135deg,#d1fae5,#ecfdf5); color:#065f46; border-left:4px solid #10b981; box-shadow:0 4px 16px rgba(16,185,129,.15); }
        .hp-flash.alert-danger  { background: linear-gradient(135deg,#fee2e2,#fff5f5); color:#991b1b; border-left:4px solid #ef4444; box-shadow:0 4px 16px rgba(239,68,68,.15); }
        .hp-flash.alert-warning { background: linear-gradient(135deg,#fef3c7,#fffbeb); color:#92400e; border-left:4px solid #f59e0b; box-shadow:0 4px 16px rgba(245,158,11,.15); }
        .hp-flash.alert-info    { background: linear-gradient(135deg,#dbeafe,#eff6ff); color:#1e40af; border-left:4px solid #3b82f6; box-shadow:0 4px 16px rgba(59,130,246,.15); }
        .hp-flash-icon { width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0; }
        .alert-success .hp-flash-icon { background:rgba(16,185,129,.15); color:#059669; }
        .alert-danger  .hp-flash-icon { background:rgba(239,68,68,.15);  color:#dc2626; }
        .alert-warning .hp-flash-icon { background:rgba(245,158,11,.15); color:#d97706; }
        .alert-info    .hp-flash-icon { background:rgba(59,130,246,.15); color:#2563eb; }
        .hp-flash-text { flex:1; line-height:1.5; }
        @keyframes hp-flash-in { from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }

        /* Validation errors block inside card */
        .hp-errors {
            margin: 16px 20px 0;
            padding: 14px 18px;
            border-radius: 14px;
            background: linear-gradient(135deg,#fee2e2,#fff5f5);
            border-left: 4px solid #ef4444;
            box-shadow: 0 4px 16px rgba(239,68,68,.15);
            animation: hp-flash-in .35s cubic-bezier(.22,.68,0,1.2) both;
        }
        .hp-errors ul { margin: 0; padding: 0 0 0 18px; }
        .hp-errors li { color: #991b1b; font-size: 13px; font-weight: 600; line-height: 1.8; }
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
                                        @php $icons=['success'=>'bi-check-circle-fill','danger'=>'bi-x-circle-fill','warning'=>'bi-exclamation-triangle-fill','info'=>'bi-info-circle-fill']; @endphp
                                        <div class="hp-flash alert alert-{{ $msg['level'] }}" role="alert">
                                            <div class="hp-flash-icon"><i class="bi {{ $icons[$msg['level']] ?? 'bi-info-circle-fill' }}"></i></div>
                                            <div class="hp-flash-text">{!! $msg['message'] !!}</div>
                                        </div>
                                    @endforeach
                                </div>
                                {{ session()->forget('flash_notification') }}
                            @endif
                            <div class="card-body p-4 p-lg-5">
                                <div class="hp-tabs d-flex gap-4 justify-content-center mb-4">
                                    <a class="hp-tab active" data-target="#page-login">{{ __('auth.login') }}</a>
                                    <a class="hp-tab" data-target="#page-register">{{ __('auth.register') }}</a>
                                </div>

                                <form method="POST" action="{{ route('user/check/login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('auth.email') }} <span class="required-star">*</span></label>
                                        <input name="email" type="email" class="form-control hp-input" placeholder="{{ __('auth.enter_email') }}">
                                    </div>

                                    <div class="mb-2 position-relative">
                                        <label class="form-label">{{ __('auth.password') }} <span class="required-star">*</span></label>
                                        <div class="position-relative">
                                            <input name="password" type="password" class="form-control hp-input hp-input--password" placeholder="{{ __('auth.enter_password') }}">
                                            <button class="hp-eye-btn" type="button"><i class="bi bi-eye-slash"></i></button>
                                        </div>
                                    </div>
    
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="rememberMe">
                                            <label class="form-check-label small" for="rememberMe">{{ __('auth.remember_me') }}</label>
                                        </div>
                                        <a class="hp-link small" href="{{ route('user/send-reset-code/form') }}">{{ __('auth.forgot_password') }}</a>
                                    </div>
    
                                    <button class="btn hp-btn-gradient w-100 hp-btn-disabled" type="submit" disabled>{{ __('auth.login') }}</button>
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
                                    <a class="hp-tab" data-target="#page-login">{{ __('auth.login') }}</a>
                                    <a class="hp-tab active" data-target="#page-register">{{ __('auth.register') }}</a>
                                </div>

                                <form method="POST" action="{{ route('user/register/store') }}" enctype="multipart/form-data">
                                    @csrf

                                    @if ($errors->any())
                                        <div class="hp-errors mb-3">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">{{ __('auth.user_type_selector') }} <span class="required-star">*</span></label>
                                            <select class="form-select hp-input" name="user_type">
                                                <option value="" selected>{{ __('auth.select_account_type') }}</option>
                                                <option value="1" {{ old('user_type') == '1' ? 'selected' : '' }}>{{ __('auth.hospital_clinic') }}</option>
                                                <option value="2" {{ old('user_type') == '2' ? 'selected' : '' }}>{{ __('auth.supplier') }}</option>
                                                {{-- <option value="3">Logistics</option> --}}
                                            </select>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label"><span id="account-name-label">{{ __('auth.hospital_clinic_name') }}</span> <span class="required-star">*</span></label>
                                            <input name="name" value="{{ old('name') }}" class="form-control hp-input" placeholder="{{ __('auth.enter_name') }}">
                                        </div>
                                        <div class="col-12 col-md-6 supplier-only">
                                            <label class="form-label">{{ __('auth.branch') }} <span class="required-star">*</span></label>
                                            <input name="branch" value="{{ old('branch') }}" class="form-control hp-input" placeholder="{{ __('auth.enter_branch') }}">
                                        </div>

                                        <div class="col-12 supplier-only">
                                            <label class="form-label">{{ __('auth.location') }} <span class="required-star">*</span></label>
                                            <input name="location" value="{{ old('location') }}" class="form-control hp-input" placeholder="{{ __('auth.enter_location') }}">
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">{{ __('auth.phone_number') }} <span class="required-star">*</span></label>
                                            <div class="input-group hp-input-group">
                                                <span class="input-group-text hp-cc">+966</span>
                                                <input name="mobile" value="{{ old('mobile') }}" class="form-control hp-input" placeholder="xxxxxxxxx">
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">{{ __('auth.email') }} <span class="required-star">*</span></label>
                                            <input name="email" type="email" class="form-control hp-input" placeholder="{{ __('auth.enter_your_email') }}">
                                        </div>

                                        <div class="col-12 col-md-6 supplier-only">
                                            <label class="form-label">{{ __('auth.iban') }} <span class="required-star">*</span></label>
                                            <input name="iban" value="{{ old('iban') }}" class="form-control hp-input" placeholder="{{ __('auth.enter_iban') }}">
                                        </div>

                                        <div class="col-12 col-md-6 supplier-only">
                                            <label class="form-label">{{ __('auth.tax_number') }} <span class="required-star">*</span></label>
                                            <input name="tax_number" value="{{ old('tax_number') }}" class="form-control hp-input" placeholder="{{ __('auth.enter_tax_number') }}">
                                        </div>

                                        <div class="col-12 col-md-6 supplier-only">
                                            <label class="form-label">{{ __('auth.cr_number') }} <span class="required-star">*</span></label>
                                            <input name="cr_number" value="{{ old('cr_number') }}" class="form-control hp-input" placeholder="{{ __('auth.enter_cr_number') }}">
                                        </div>

                                        <div class="col-12 supplier-only">
                                            <label class="form-label">{{ __('auth.upload_cr_document') }}</label>
                                            <div class="hp-upload dropzone text-center p-4">
                                                <input name="cr_file_document" type="file" class="d-none" id="crFile">
                                                <button class="btn btn-light border hp-upload-btn" type="button">
                                                    <i class="bi bi-arrow-up-circle me-2"></i>
                                                    {{ __('auth.choose_file') }}
                                                </button>
                                                <div class="small text-body-tertiary mt-1">{{ __('auth.upload_cr_certificate') }}</div>
                                                <div class="small mt-2 hp-file-name d-none"></div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">{{ __('auth.password') }} <span class="required-star">*</span></label>
                                            <div class="position-relative">
                                            <input name="password" type="password" class="form-control hp-input hp-input--password" placeholder="{{ __('auth.enter_password') }}">
                                                <button class="hp-eye-btn" type="button"><i class="bi bi-eye-slash"></i></button>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">{{ __('auth.confirm_password') }} <span class="required-star">*</span></label>
                                            <div class="position-relative">
                                            <input name="password_confirmation" type="password" class="form-control hp-input hp-input--password" placeholder="{{ __('auth.re_enter_password') }}">
                                                <button class="hp-eye-btn" type="button"><i class="bi bi-eye-slash"></i></button>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex align-items-center justify-content-between mt-1">
                                            <div class="form-check">
                                                <input name="terms" class="form-check-input" type="checkbox" id="terms" value="1">
                                                <label class="form-check-label small" for="terms">
                                                    <span class="required-star">*</span> {{ __('auth.i_agree_to') }}
                                                    <a href="{{ route('termsConditions') }}" class="hp-link">{{ __('auth.terms_conditions') }}</a>
                                                    &amp;
                                                    <a href="{{ route('privacyPolicy') }}" class="hp-link">{{ __('auth.privacy_policy') }}</a>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn hp-btn-gradient w-100 hp-btn-disabled" disabled>{{ __('auth.sign_up') }}</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection

<!-- custom js -->
@section('script')
    <script>
        function switchPage(target) {
            const $target = $(target);
            if (!$target.length) return;
            $('.hp-page').removeClass('active');
            $target.addClass('active');
            // Sync all tab links
            $('.hp-tab').each(function(){
                $(this).toggleClass('active', $(this).data('target') === target);
            });
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Auto-open register tab when there are validation errors or old input
        $(function() {
            const hasErrors = {{ $errors->any() ? 'true' : 'false' }};
            const hasOld    = {{ (old('user_type') || old('email') || old('mobile') || old('name')) ? 'true' : 'false' }};
            if (hasErrors || hasOld) {
                switchPage('#page-register');
            }
        });

        function togglePrimaryButton($context) {
            const isRegister = $context.attr('id') === 'page-register';
            let filled = true;

            if (isRegister) {
                const userType = String($context.find('[name="user_type"]').val() || '');
                const requiredSelectors = [
                    '[name="user_type"]',
                    '[name="name"]',
                    '[name="mobile"]',
                    '[name="email"]',
                    '[name="password"]',
                    '[name="password_confirmation"]',
                    '[name="terms"]'
                ];

                if (userType === '2') {
                    requiredSelectors.push(
                        '[name="branch"]',
                        '[name="location"]',
                        '[name="iban"]',
                        '[name="tax_number"]',
                        '[name="cr_number"]',
                        '[name="cr_file_document"]'
                    );
                }

                requiredSelectors.forEach(function(sel){
                    const $field = $context.find(sel).first();
                    if (!$field.length) return;
                    if ($field.attr('type') === 'checkbox') {
                        if (!$field.is(':checked')) filled = false;
                        return;
                    }
                    if ($field.attr('type') === 'file') {
                        if (!$field[0].files || !$field[0].files.length) filled = false;
                        return;
                    }
                    const v = $field.val();
                    if (v === null || String(v).trim() === '' || ($field.is('select') && (v === '' || v === '0'))) {
                        filled = false;
                    }
                });
            } else {
                const inputs = $context.find('input[type="email"], input[type="password"]').not(':disabled');
                inputs.each(function() {
                    const v = $(this).val();
                    if (v === null || String(v).trim() === '') {
                        filled = false;
                    }
                });
            }

            const $btn = $context.find('.hp-btn-gradient').first();
            if ($btn.length) {
                $btn.prop('disabled', !filled).toggleClass('hp-btn-disabled', !filled);
            }
        }

        function toggleRegisterTypeFields() {
            const $register = $('#page-register');
            const selectedType = String($register.find('[name="user_type"]').val() || '');
            const supplierSelected = selectedType === '2';
            const $supplierFields = $register.find('.supplier-only');
            const $nameLabel = $('#account-name-label');

            $supplierFields.toggle(supplierSelected);
            if ($nameLabel.length) {
                $nameLabel.text(supplierSelected ? '{{ __("auth.supplier_name") }}' : '{{ __("auth.hospital_clinic_name") }}');
            }
        }

        function setupOTP($section) {
            const $inputs = $section.find('.hp-otp-input');
            $inputs.on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value && this.nextElementSibling) {
                    this.nextElementSibling.focus();
                }
                checkOTPState($section);
            });
            $inputs.on('keydown', function(e) {
                if (e.key === 'Backspace' && !this.value && this.previousElementSibling) {
                    this.previousElementSibling.focus();
                }
                if (e.key === 'ArrowLeft' && this.previousElementSibling) this.previousElementSibling.focus();
                if (e.key === 'ArrowRight' && this.nextElementSibling) this.nextElementSibling.focus();
            });

            $inputs.on('paste', function(e) {
                const clip = (e.originalEvent || e).clipboardData.getData('text');
                if (!/^\d{6}$/.test(clip)) return;
                e.preventDefault();
                $inputs.each(function(i) {
                    this.value = clip[i] || '';
                });
                checkOTPState($section);
            });
            checkOTPState($section);
        }

        function checkOTPState($section) {
            const code = $section.find('.hp-otp-input').map(function() {
                return this.value;
            }).get().join('');
            const $btn = $section.find('.hp-btn-gradient');
            const enabled = /^\d{6}$/.test(code);
            $btn.prop('disabled', !enabled).toggleClass('hp-btn-disabled', !enabled);
        }

        function startTimer($el, seconds) {
            let remaining = seconds;

            function tick() {
                const m = String(Math.floor(remaining / 60)).padStart(2, '0');
                const s = String(remaining % 60).padStart(2, '0');
                $el.text(`${m}:${s}`);
                remaining--;
                if (remaining >= 0) {
                    setTimeout(tick, 1000);
                }
            }
            tick();
        }

        $(function() {
            $('.hp-page-switch .btn, .hp-tabs .hp-tab, .hp-link[data-target]').on('click', function() {
                const target = $(this).data('target');
                if (target) {
                    switchPage(target);
                }
            });

            $(document).on('click', '.hp-eye-btn', function() {
                const input = $(this).siblings('input')[0];
                const icon = $(this).find('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.removeClass('bi-eye-slash').addClass('bi-eye');
                } else {
                    input.type = 'password';
                    icon.removeClass('bi-eye').addClass('bi-eye-slash');
                }
            });

            $('.hp-upload-btn').on('click', function() {
                $(this).closest('.hp-upload').find('input[type="file"]').trigger('click');
            });
            $('#crFile').on('change', function() {
                const name = this.files?.[0]?.name || '';
                const $nameEl = $('.hp-file-name');
                if (name) {
                    $nameEl.text(name).removeClass('d-none');
                }
            });

            ['#page-login', '#page-register', '#page-forgot', '#page-reset'].forEach(function(sel) {
                const $sec = $(sel);
                togglePrimaryButton($sec);
                $sec.on('input change', 'input, select', function() {
                    togglePrimaryButton($sec);
                });
            });

            $('#page-register [name="user_type"]').on('change', function(){
                toggleRegisterTypeFields();
                togglePrimaryButton($('#page-register'));
            });

            setupOTP($('#page-otp-empty'));
            setupOTP($('#page-otp-filled'));

            startTimer($('#timerFilled'), 33 * 60);
            startTimer($('#timerEmpty'), 33 * 60);

            toggleRegisterTypeFields();
            togglePrimaryButton($('#page-register'));
        });
    </script>
@endsection

