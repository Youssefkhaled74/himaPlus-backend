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
            <section id="page-reset" class="hp-page" style="display: contents;">
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
                            @isset($id)   
                                <form method="POST" action="{{ route('user/reset-password', $id) }}">
                                    @csrf
                                    <div class="card-body p-4 p-lg-5 text-center">
                                        <h5 class="fw-bold mb-2">{{ __('auth.reset_password') }}</h5>
                                        <p class="text-body-secondary small mb-4">{{ __('auth.create_new_password') }}</p>

                                        <div class="text-start mb-3">
                                            <label class="form-label">{{ __('auth.code_placeholder') }}</label>
                                            <div class="position-relative">
                                                <input name="code" type="text" class="form-control hp-input" placeholder="{{ __('auth.code_placeholder') }}">
                                            </div>
                                        </div>
                                        <div class="text-start mb-3">
                                            <label class="form-label">{{ __('auth.new_password') }}</label>
                                            <div class="position-relative">
                                                <input name="password" type="password" class="form-control hp-input hp-input--password" placeholder="{{ __('auth.new_password') }}">
                                                <button class="hp-eye-btn" type="button"><i class="bi bi-eye-slash"></i></button>
                                            </div>
                                        </div>
                                        <div class="text-start mb-4">
                                            <label class="form-label">{{ __('auth.confirm_password') }}</label>
                                            <div class="position-relative">
                                                <input name="password_confirmation" type="password" class="form-control hp-input hp-input--password" placeholder="{{ __('auth.re_enter_password') }}">
                                                <button class="hp-eye-btn" type="button"><i class="bi bi-eye-slash"></i></button>
                                            </div>
                                        </div>

                                        <button class="btn hp-btn-gradient w-100">{{ __('auth.reset_password') }}</button>
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
</script>
@endsection

