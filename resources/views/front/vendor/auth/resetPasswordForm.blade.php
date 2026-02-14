@extends('layouts.front.home')

<!-- title page -->
@section('title')
    <title>{{ __('profile.reset_password') }} - HemaPulse</title>
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
            <section class="hp-page active align-items-center">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-6">
                        <div class="hp-card card">
                            <div class="card-body p-4 p-lg-5">
                                <h4 class="mb-4">{{ __('profile.reset_password') }}</h4>

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

                                <form method="POST" action="{{ route('vendor/reset-password', $id) }}">
                                    @csrf
                                    <!-- Verification Code -->
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('profile.verification_code') ?? 'Verification Code' }} <span class="required-star">*</span></label>
                                        <input 
                                            name="code" 
                                            type="text" 
                                            class="form-control hp-input text-center" 
                                            placeholder="Enter 4-digit code"
                                            maxlength="4"
                                            pattern="[0-9]{4}"
                                            required
                                        >
                                        <small class="text-muted d-block mt-1">{{ __('profile.check_email') ?? 'Check your email for the code' }}</small>
                                    </div>

                                    <!-- New Password -->
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('profile.new_password') ?? 'New Password' }} <span class="required-star">*</span></label>
                                        <div class="position-relative">
                                            <input 
                                                name="password" 
                                                type="password" 
                                                class="form-control hp-input hp-input--password" 
                                                placeholder="Enter new password"
                                                required
                                            >
                                            <button class="hp-eye-btn" type="button"><i class="bi bi-eye-slash"></i></button>
                                        </div>
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('profile.confirm_password') ?? 'Confirm Password' }} <span class="required-star">*</span></label>
                                        <div class="position-relative">
                                            <input 
                                                name="password_confirmation" 
                                                type="password" 
                                                class="form-control hp-input hp-input--password" 
                                                placeholder="Confirm new password"
                                                required
                                            >
                                            <button class="hp-eye-btn" type="button"><i class="bi bi-eye-slash"></i></button>
                                        </div>
                                    </div>

                                    <button class="btn hp-btn-gradient w-100" type="submit">
                                        {{ __('profile.reset_password') }}
                                    </button>
                                </form>

                                <div class="mt-4 text-center">
                                    <p class="small text-muted">
                                        {{ __('profile.remember_password') ?? 'Remember your password?' }}
                                        <a href="{{ route('vendor/login') }}" class="hp-link">{{ __('nav.login') }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script>
        // Auto-format numeric code input
        document.querySelector('input[name="code"]').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);
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

        // Validate form on input
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input[required]');
        
        form.addEventListener('input', function() {
            const allFilled = Array.from(inputs).every(input => input.value.trim() !== '');
            // Can add submit button enable/disable logic here if needed
        });
    </script>
@endsection
