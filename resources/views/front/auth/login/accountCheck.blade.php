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
    </style>
@endsection

@section('content')
    <main class="hp-main">
        <div class="container">
            <section id="page-otp-filled" class="hp-page" style="display: contents;">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-6">
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
                        <div class="hp-card card">
                            @isset($user)   
                                <form method="post" action="{{ route('user/account-check', $user->id) }}">
                                    @csrf
                                    <div class="card-body p-4 p-lg-5 text-center">
                                        <h5 class="fw-bold mb-2">Verify Your Number</h5>
                                        <p class="text-body-secondary small mb-4">Enter the 4-digit code sent to your phone and email<br>number.</p>

                                        <div class="d-flex justify-content-center gap-3 mb-3 hp-otp" data-filled="1">
                                            <input type="text" class="hp-otp-input" maxlength="1" value="">
                                            <input type="text" class="hp-otp-input" maxlength="1" value="">
                                            <input type="text" class="hp-otp-input" maxlength="1" value="">
                                            <input type="text" class="hp-otp-input" maxlength="1" value="">
                                        </div>
                                        <input name="code" id="hp-otp-input-val" type="hidden" value="">

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <a class="hp-link small" href="{{ route('user/regenerate-code', $user->id) }}" id="resendFilled">Resend Code</a>
                                            <div class="small text-primary" id="timerFilled">60:00</div>
                                        </div>

                                        <button class="btn hp-btn-gradient w-100">Verify</button>
                                    </div>
                                </form>
                            @endisset
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
                if (!/^\d{4}$/.test(clip)) return;
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
            const enabled = /^\d{4}$/.test(code);
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

            startTimer($('#timerFilled'), 60 * 60);
            startTimer($('#timerEmpty'), 60 * 60);
        });

        $(document).on('input', '.hp-otp-input', function () {

            this.value = this.value.replace(/\D/g, '').slice(0, 1);
            if (this.value && this.nextElementSibling?.classList.contains('hp-otp-input')) {
                this.nextElementSibling.focus();
            }
            const code = $('.hp-otp-input').map(function () { return this.value; }).get().join('');
            $('#hp-otp-input-val').val(code);
        });
    </script>
@endsection
