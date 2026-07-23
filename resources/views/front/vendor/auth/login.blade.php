@extends('layouts.front.home')

<!-- title page -->
@section('title')
    <title>{{ __('nav.login') }} - Vendor | Hema</title>
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
            <section class="hp-page active align-items-center">
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
                                <div class="text-center mb-4">
                                    <h5 class="fw-bold mb-1">{{ __('nav.login') }}</h5>
                                    <p class="text-muted small">{{ __('nav.dashboard_description') }}</p>
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

                                <div class="text-center mt-4">
                                    <span class="text-muted small">{{ __('auth.dont_have_account') }} </span>
                                    <a href="{{ route('login') }}" class="hp-link small fw-semibold">{{ __('auth.register') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script>
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
        document.querySelector('form').addEventListener('input', function() {
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
    </script>
@endsection
