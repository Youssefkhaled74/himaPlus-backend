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
                                    <h5 class="fw-bold mb-2">Forgot Password</h5>
                                    <p class="text-body-secondary small mb-4">Don't worry! Just enter your phone number or email, and we'll<br>send you a code.</p>
                                    <div class="text-start mb-3">
                                        <label class="form-label">Phone Number or Email</label>
                                        <input name="data" class="form-control hp-input" placeholder="Enter phone number or email">
                                    </div>
                                    <button class="btn hp-btn-gradient w-100">Confirm</button>
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
