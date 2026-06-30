@extends('layouts.front.home')

<!-- title page -->
@section('title')
    <title>{{ __('profile.reset_password') }} - Hema</title>
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
                                <p class="text-muted mb-4">{{ trans_or_fallback('', '') }}</p>

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

                                <form method="POST" action="{{ route('vendor/send-reset-code/check') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">{{ trans_or_fallback('', '') }} <span class="required-star">*</span></label>
                                        <input 
                                            name="data" 
                                            type="text" 
                                            class="form-control hp-input" 
                                            placeholder="Enter your email or phone number"
                                            value="{{ old('data') }}"
                                            required
                                        >
                                    </div>

                                    <button class="btn hp-btn-gradient w-100" type="submit">
                                        {{ trans_or_fallback('', '') }}
                                    </button>
                                </form>

                                <div class="mt-4 text-center">
                                    <p class="small text-muted">
                                        {{ trans_or_fallback('', '') }}
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
@endsection


