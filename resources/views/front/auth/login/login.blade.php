@extends('layouts.front.home')

<!-- title page -->
@section('title')
    <title>HemaPulse - Smart Medical Procurement</title>
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
    </style>
@endsection

@section('content')
    <main class="hp-main">
        <div class="container">
            <section id="page-login" class="hp-page active align-items-center">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-6">
                        <div class="hp-card card">
                            @include('flash::message')
                            @if ($errors->any())
                                <div style="text-align: left; margin: 15px;">
                                    <ul dir="ltr">
                                        @foreach ($errors->all() as $error)
                                            <li class="text-danger">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="card-body p-4 p-lg-5">
                                <div class="hp-tabs d-flex gap-4 justify-content-center mb-4">
                                    <a class="hp-tab active" data-target="#page-login">Login</a>
                                    <a class="hp-tab" data-target="#page-register">Register</a>
                                </div>

                                <form method="POST" action="{{ route('user/check/login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Email <span class="required-star">*</span></label>
                                        <input name="email" type="email" class="form-control hp-input" placeholder="Enter your Email">
                                    </div>

                                    <div class="mb-2 position-relative">
                                        <label class="form-label">Password <span class="required-star">*</span></label>
                                        <div class="position-relative">
                                            <input name="password" type="password" class="form-control hp-input hp-input--password" placeholder="Enter your password">
                                            <button class="hp-eye-btn" type="button"><i class="bi bi-eye-slash"></i></button>
                                        </div>
                                    </div>
    
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="rememberMe">
                                            <label class="form-check-label small" for="rememberMe">Remember me</label>
                                        </div>
                                        <a class="hp-link small" href="{{ route('user/send-reset-code/form') }}">Forgot Password ?</a>
                                    </div>
    
                                    <button class="btn hp-btn-gradient w-100 hp-btn-disabled" type="submit" disabled>Log In</button>
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
                                    <a class="hp-tab" data-target="#page-login">Login</a>
                                    <a class="hp-tab active" data-target="#page-register">Register</a>
                                </div>

                                <form method="POST" action="{{ route('user/register/store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">User Type Selector <span class="required-star">*</span></label>
                                            <select class="form-select hp-input" name="user_type">
                                                <option selected>Select Account Type</option>
                                                <option value="1">Hospital / Clinic</option>
                                                <option value="2">Supplier</option>
                                                {{-- <option value="3">Logistics</option> --}}
                                            </select>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Hospital / Clinic Name <span class="required-star">*</span></label>
                                            <input name="name" class="form-control hp-input" placeholder="Enter Name">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Branch</label>
                                            <input name="branch" class="form-control hp-input" placeholder="Enter branch">
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Location</label>
                                            <input name="location" class="form-control hp-input" placeholder="Enter location">
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Phone Number <span class="required-star">*</span></label>
                                            <div class="input-group hp-input-group">
                                                <span class="input-group-text hp-cc">+966</span>
                                                <input name="mobile" class="form-control hp-input" placeholder="xxxxxxxxx">
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Email <span class="required-star">*</span></label>
                                            <input name="email" type="email" class="form-control hp-input" placeholder="Enter your email">
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">IBAN</label>
                                            <input name="iban" class="form-control hp-input" placeholder="Enter IBAN">
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Tax Number</label>
                                            <input name="tax_number" class="form-control hp-input" placeholder="Enter Tax Number">
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">CR Number</label>
                                            <input name="cr_number" class="form-control hp-input" placeholder="Enter CR number">
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Upload CR Document</label>
                                            <div class="hp-upload dropzone text-center p-4">
                                                <input name="cr_file_document" type="file" class="d-none" id="crFile">
                                                <button class="btn btn-light border hp-upload-btn" type="button">
                                                    <i class="bi bi-arrow-up-circle me-2"></i>
                                                    Choose file to upload
                                                </button>
                                                <div class="small text-body-tertiary mt-1">Upload CR Certificate (PDF / image)</div>
                                                <div class="small mt-2 hp-file-name d-none"></div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Password <span class="required-star">*</span></label>
                                            <div class="position-relative">
                                                <input name="password" type="password" class="form-control hp-input hp-input--password" placeholder="Enter your password">
                                                <button class="hp-eye-btn" type="button"><i class="bi bi-eye-slash"></i></button>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Confirm Password <span class="required-star">*</span></label>
                                            <div class="position-relative">
                                                <input name="password_confirmation" type="password" class="form-control hp-input hp-input--password" placeholder="Re-enter your password">
                                                <button class="hp-eye-btn" type="button"><i class="bi bi-eye-slash"></i></button>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex align-items-center justify-content-between mt-1">
                                            <div class="form-check">
                                                <input name="terms" class="form-check-input" type="checkbox" id="terms" value="1">
                                                <label class="form-check-label small" for="terms"><span class="required-star">*</span> I agree to <a href="#" class="hp-link">Terms &amp; Privacy Policy</a></label>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn hp-btn-gradient w-100 hp-btn-disabled" disabled>Sign Up</button>
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
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function togglePrimaryButton($context) {
            const inputs = $context.find('input[type="text"], input[type="email"], input[type="password"], select').not(
                ':disabled');
            let filled = true;
            inputs.each(function() {
                const v = $(this).val();
                if (v === null || String(v).trim() === '' || (this.tagName === 'SELECT' && this.selectedIndex ===
                    0)) {
                    filled = false;
                }
            });
            const $btn = $context.find('.hp-btn-gradient').first();
            if ($btn.length) {
                $btn.prop('disabled', !filled).toggleClass('hp-btn-disabled', !filled);
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

            setupOTP($('#page-otp-empty'));
            setupOTP($('#page-otp-filled'));

            startTimer($('#timerFilled'), 33 * 60);
            startTimer($('#timerEmpty'), 33 * 60);
        });
    </script>
@endsection
