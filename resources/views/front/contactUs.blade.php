@extends('layouts.front.home')

<!-- title page -->
@section('title')
    <title>{{ __('contact.title') }}</title>
@endsection

<!-- custom page -->
@section('css')
<style>
    .hero-contact {
        text-align: center;
    }
    .hero-contact .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .hero-contact p {
        max-width: 700px;
    }
</style>
@endsection

@section('content')

    <main>
        <section class="hero hero-contact">
            <div class="container">
                <h1 class="mb-2">{{ __('contact.hero_title') }}</h1>
                <p class="mb-0">{{ __('contact.hero_desc') }}</p>
            </div>
        </section>

        <section class="container py-5">
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
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="card shadow-soft border-0">
                        <div class="card-body p-4">
                            <h5 class="fw-semibold mb-3">{{ __('contact.send_message') }}</h5>
                            <form class="row g-3" method="post" action="{{ route('user/store/contact-us') }}">
                                @csrf
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">{{ __('contact.full_name') }}</label>
                                    <input name="name" type="text" class="form-control" placeholder="{{ __('contact.your_name') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">{{ __('contact.phone_number') }}</label>
                                    <input name="mobile" type="text" class="form-control" placeholder="+966 1760 2222">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">{{ __('contact.email') }}</label>
                                    <input name="email" type="email" class="form-control" placeholder="name@mail.sa">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">{{ __('contact.location') }}</label>
                                    <input name="location" type="text" class="form-control" placeholder="{{ __('contact.location_placeholder') }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-semibold">{{ __('contact.message') }}</label>
                                    <textarea name="details" class="form-control" rows="5" placeholder="{{ __('contact.message_placeholder') }}"></textarea>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-gradient px-4">{{ __('contact.submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="aside-card">
                        <h5 class="fw-semibold mb-3">{{ __('contact.contact_channels') }}</h5>
                        <div class="item">
                            <div class="item-title">{{ __('contact.phone') }}</div>
                            <div>+966 1760 2222</div>
                        </div>
                        <div class="item">
                            <div class="item-title">{{ __('contact.email') }}</div>
                            <div>support@hemapulse.com</div>
                        </div>
                        <div class="item">
                            <div class="item-title">{{ __('contact.office_hours') }}</div>
                            <div>{{ __('contact.office_hours_value') }}</div>
                        </div>
                        {{-- <div class="item">
                            <div class="item-title">Location</div>
                            <div>King Abdullah Financial District, Riyadh, Saudi Arabia</div>
                        </div> --}}
                        <div class="item">
                            <div class="item-title mb-2">{{ __('contact.follow_us') }}</div>
                            <div class="social">
                                <i class="bi bi-facebook"></i>
                                <i class="bi bi-twitter-x"></i>
                                <i class="bi bi-linkedin"></i>
                                <i class="bi bi-instagram"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
        
@endsection

<!-- custom js -->
@section('script')
<script>
    $(function(){
        $('#nav-contactUs').addClass('active');
    });
</script>
@endsection
