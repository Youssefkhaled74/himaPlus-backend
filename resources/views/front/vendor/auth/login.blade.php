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

                                <a href="{{ route('vendor/register/form') }}" class="btn hp-btn-gradient w-100">
                                    {{ __('nav.register_as_vendor') ?? 'Register as Supplier' }}
                                </a>
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

        // Enable submit button when form is filled
        document.querySelectorAll('form').forEach(form => {
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
    </script>
@endsection
