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
    </style>
@endsection

@section('content')
    <main class="hp-main">
        <div class="container">
            <section id="page-forgot" class="hp-page" style="display: contents;">
                <div class="row justify-content-center">
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
                    <div class="col-12 col-md-10 col-lg-6">
                        <div class="hp-card card">
                            <form method="POST" action="{{ route('user/send-reset-code/check') }}">
                                @csrf
                                <div class="card-body p-4 p-lg-5 text-center">
                                    <h5 class="fw-bold mb-2">{{ __('auth.forgot_password') }}</h5>
                                    <p class="text-body-secondary small mb-4">{!! __('auth.forgot_password_text') !!}</p>
                                    <div class="text-start mb-3">
                                        <label class="form-label">{{ __('auth.phone_or_email') }}</label>
                                        <input name="data" class="form-control hp-input" placeholder="{{ __('auth.enter_phone_or_email') }}">
                                    </div>
                                    <button class="btn hp-btn-gradient w-100">{{ __('buttons.confirm') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection

<!-- custom js -->
@section('script')
@endsection

