@extends('layouts.front.home')

@section('title')
    <title>{{ __('contact.title') }}</title>
@endsection

@section('css')
<style>
    .contact-page,
    .contact-page * {
        font-family: "Poppins", "Tajawal", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
    }

    .contact-page {
        background: #f7f8fa;
    }

    .contact-hero {
        min-height: 375px;
        display: grid;
        place-items: center;
        text-align: center;
        color: #fff;
        background:
            linear-gradient(180deg, rgba(13, 20, 38, .42), rgba(13, 20, 38, .42)),
            url('{{ asset('front/assets/images/men-girls-are-surfing.png') }}') center/cover no-repeat;
    }

    .contact-hero__inner {
        width: min(860px, calc(100% - 32px));
        margin: 0 auto;
    }

    .contact-hero h1 {
        margin: 0;
        font-size: clamp(40px, 5vw, 68px);
        line-height: 1.1;
        font-weight: 700;
        letter-spacing: -.03em;
    }

    .contact-hero p {
        margin: 20px auto 0;
        max-width: 860px;
        font-size: 18px;
        line-height: 1.65;
        color: rgba(255, 255, 255, .9);
    }

    .contact-shell {
        width: min(1240px, calc(100% - 48px));
        margin: 0 auto;
        padding: 88px 0 96px;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 400px;
        gap: 26px;
        align-items: start;
    }

    .contact-form-wrap {
        padding: 0 20px 0 0;
    }

    [dir="rtl"] .contact-form-wrap {
        padding: 0 0 0 20px;
    }

    .contact-heading {
        margin: 0 0 30px;
        font-size: clamp(38px, 4vw, 58px);
        line-height: 1.08;
        font-weight: 700;
        letter-spacing: -.03em;
        color: #133f9b;
    }

    .contact-heading .accent {
        color: #08b89b;
    }

    .contact-form {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px 24px;
    }

    .field-full {
        grid-column: 1 / -1;
    }

    .contact-field label {
        display: block;
        margin-bottom: 10px;
        color: #1f2937;
        font-size: 18px;
        font-weight: 500;
    }

    .contact-field input,
    .contact-field textarea,
    .phone-field {
        width: 100%;
        border: 1px solid #e2e8f0;
        background: #fff;
        border-radius: 12px;
        color: #0f172a;
        box-shadow: none;
        outline: 0;
    }

    .contact-field input,
    .phone-field {
        height: 62px;
        padding: 0 18px;
        font-size: 17px;
    }

    .contact-field textarea {
        min-height: 220px;
        padding: 18px;
        resize: vertical;
        font-size: 17px;
    }

    .contact-field input::placeholder,
    .contact-field textarea::placeholder,
    .phone-number-input::placeholder {
        color: #9ca3af;
    }

    .phone-field {
        display: grid;
        grid-template-columns: 100px 1fr;
        padding: 0;
        overflow: hidden;
    }

    .phone-prefix {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border-inline-end: 1px solid #e2e8f0;
        color: #334155;
        font-size: 16px;
        background: #fff;
        padding: 0 10px;
    }

    .phone-number-input {
        border: 0;
        outline: 0;
        width: 100%;
        padding: 0 16px;
        font-size: 17px;
        color: #0f172a;
    }

    .submit-wrap {
        margin-top: 22px;
    }

    .btn-send {
        min-width: 266px;
        height: 62px;
        border: 0;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 0 28px;
        color: #fff;
        text-decoration: none;
        font-size: 18px;
        font-weight: 600;
        background: linear-gradient(90deg, #0a46a3 0%, #08c49a 100%);
    }

    .btn-send:hover {
        color: #fff;
        filter: brightness(.98);
    }

    .contact-card {
        position: relative;
        overflow: hidden;
        min-height: 700px;
        border-radius: 22px;
        padding: 40px 34px;
        color: #fff;
        background: linear-gradient(180deg, #0a46a3 0%, #08c49a 100%);
    }

    .contact-card::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image:
            radial-gradient(circle at 20% 18%, rgba(255,255,255,.08) 0, rgba(255,255,255,.08) 2px, transparent 2px),
            radial-gradient(circle at 85% 22%, rgba(255,255,255,.08) 0, rgba(255,255,255,.08) 2px, transparent 2px),
            radial-gradient(circle at 32% 72%, rgba(255,255,255,.08) 0, rgba(255,255,255,.08) 2px, transparent 2px),
            linear-gradient(135deg, transparent 0%, rgba(255,255,255,.05) 100%);
        background-size: 120px 120px, 160px 160px, 140px 140px, auto;
        opacity: .9;
        pointer-events: none;
    }

    .contact-card > * {
        position: relative;
        z-index: 1;
    }

    .contact-card__group + .contact-card__group {
        margin-top: 34px;
    }

    .contact-card__label {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 16px;
        font-size: 24px;
        font-weight: 600;
    }

    .contact-card__icon {
        width: 28px;
        text-align: center;
        font-size: 24px;
    }

    .contact-card__text {
        padding-inline-start: 42px;
        font-size: 16px;
        line-height: 1.7;
        color: rgba(255,255,255,.96);
    }

    [dir="rtl"] .contact-card__text {
        padding-inline-start: 0;
        padding-inline-end: 42px;
    }

    .contact-social {
        display: flex;
        gap: 14px;
        padding-inline-start: 42px;
        margin-top: 12px;
        flex-wrap: wrap;
    }

    [dir="rtl"] .contact-social {
        padding-inline-start: 0;
        padding-inline-end: 42px;
    }

    .contact-social a {
        width: 50px;
        height: 50px;
        border-radius: 999px;
        display: grid;
        place-items: center;
        text-decoration: none;
        color: #0a46a3;
        background: rgba(255,255,255,.95);
        font-size: 26px;
    }

    @media (max-width: 991.98px) {
        .contact-hero {
            min-height: 300px;
        }

        .contact-hero p {
            font-size: 16px;
        }

        .contact-shell {
            width: min(100% - 24px, 1240px);
            padding: 46px 0 56px;
        }

        .contact-grid {
            grid-template-columns: 1fr;
        }

        .contact-form-wrap,
        [dir="rtl"] .contact-form-wrap {
            padding: 0;
        }

        .contact-card {
            min-height: auto;
        }
    }

    @media (max-width: 767.98px) {
        .contact-form {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .contact-heading {
            margin-bottom: 22px;
        }

        .contact-field label {
            font-size: 16px;
        }

        .contact-field input,
        .phone-field,
        .contact-field textarea,
        .phone-number-input,
        .btn-send {
            font-size: 16px;
        }

        .phone-field {
            grid-template-columns: 88px 1fr;
        }

        .btn-send {
            width: 100%;
            min-width: 0;
        }
    }
</style>
@endsection

@section('content')
<main class="contact-page">
    <section class="contact-hero">
        <div class="contact-hero__inner">
            <h1>{{ __('contact.hero_title') }}</h1>
            <p>{{ __('contact.hero_desc') }}</p>
        </div>
    </section>

    <section class="contact-shell">
        @include('flash::message')

        @if ($errors->any())
            <div class="mb-4" style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};">
                <ul class="mb-0" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                    @foreach ($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="contact-grid">
            <div class="contact-form-wrap">
                <h2 class="contact-heading">
                    <span>{{ __('contact.get_in') }}</span> <span class="accent">{{ __('contact.touch') }}</span>
                </h2>

                <form method="post" action="{{ route('user/store/contact-us') }}">
                    @csrf

                    <div class="contact-form">
                        <div class="contact-field">
                            <label for="contact-name">{{ __('contact.full_name') }}</label>
                            <input id="contact-name" name="name" type="text" value="{{ old('name') }}" placeholder="{{ __('contact.your_name') }}">
                        </div>

                        <div class="contact-field">
                            <label for="contact-mobile">{{ __('contact.phone_number') }}</label>
                            <div class="phone-field">
                                <div class="phone-prefix">
                                    <span>🇸🇦</span>
                                    <span>+966</span>
                                </div>
                                <input id="contact-mobile" class="phone-number-input" name="mobile" type="text" value="{{ old('mobile') }}" placeholder="xxxxxxxxx">
                            </div>
                        </div>

                        <div class="contact-field field-full">
                            <label for="contact-email">{{ __('contact.email') }}</label>
                            <input id="contact-email" name="email" type="email" value="{{ old('email') }}" placeholder="{{ __('contact.email_placeholder') }}">
                        </div>

                        <div class="contact-field field-full">
                            <label for="contact-message">{{ __('contact.message') }}</label>
                            <textarea id="contact-message" name="details" placeholder="{{ __('contact.message_placeholder') }}">{{ old('details') }}</textarea>
                        </div>
                    </div>

                    <div class="submit-wrap">
                        <button type="submit" class="btn-send">
                            <span>{{ __('contact.send_message_cta') }}</span>
                            <i class="bi bi-arrow-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
                        </button>
                    </div>
                </form>
            </div>

            <aside class="contact-card">
                <div class="contact-card__group">
                    <div class="contact-card__label">
                        <span class="contact-card__icon"><i class="bi bi-send"></i></span>
                        <span>{{ __('contact.address') }}</span>
                    </div>
                    <div class="contact-card__text">{{ __('contact.address_value') }}</div>
                </div>

                <div class="contact-card__group">
                    <div class="contact-card__label">
                        <span class="contact-card__icon"><i class="bi bi-telephone"></i></span>
                        <span>{{ __('contact.contact_label') }}</span>
                    </div>
                    <div class="contact-card__text">+966 33865828</div>
                </div>

                <div class="contact-card__group">
                    <div class="contact-card__label">
                        <span class="contact-card__icon"><i class="bi bi-envelope"></i></span>
                        <span>{{ __('contact.email') }}</span>
                    </div>
                    <div class="contact-card__text">+966 33865828</div>
                </div>

                <div class="contact-card__group">
                    <div class="contact-card__label">
                        <span class="contact-card__icon"><i class="bi bi-globe2"></i></span>
                        <span>{{ __('contact.stay_connected') }}</span>
                    </div>
                    <div class="contact-social">
                        <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" aria-label="X"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </aside>
        </div>
    </section>
</main>
@endsection

@section('script')
<script>
    $(function(){
        $('#nav-contactUs').addClass('active');
    });
</script>
@endsection
