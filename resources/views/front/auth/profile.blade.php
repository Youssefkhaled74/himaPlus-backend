@extends('layouts.front.home')

@section('title')
    <title>{{ __('profile.title') }}</title>
@endsection

@section('css')
    <style>
        .hp-profile-page {
            --hp-bg: #f5f7fb;
            --hp-card: #ffffff;
            --hp-border: #e5eaf2;
            --hp-primary: #0f4bbf;
            --hp-primary-2: #0ec6a0;
            --hp-title: #0f172a;
            --hp-text: #334155;
            --hp-muted: #64748b;
            --hp-soft: #eef5ff;
            --hp-danger: #dc2626;

            max-width: 95%;
            margin: 110px auto 80px;
            padding: 0 12px;
            font-family: "Poppins", "Tajawal", system-ui, -apple-system, "Segoe UI", sans-serif;
        }

        .hp-profile-card {
            background: var(--hp-card);
            border: 1px solid var(--hp-border);
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        }

        .hp-profile-breadcrumb {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            color: var(--hp-muted);
            font-size: 14px;
        }

        .hp-profile-breadcrumb a {
            color: var(--hp-muted);
            text-decoration: none;
        }

        .hp-profile-breadcrumb .is-active {
            color: var(--hp-primary);
            font-weight: 700;
        }

        .hp-profile-hero {
            padding: 28px;
            margin-bottom: 18px;
        }

        .hp-profile-title {
            margin: 0 0 8px;
            color: var(--hp-title);
            font-size: 32px;
            font-weight: 800;
        }

        .hp-profile-subtitle {
            margin: 0;
            max-width: 760px;
            color: var(--hp-muted);
            font-size: 15px;
            line-height: 1.7;
        }

        .hp-profile-shell {
            display: grid;
            grid-template-columns: 280px minmax(0, 1fr);
            gap: 20px;
        }

        .hp-profile-sidebar,
        .hp-profile-panel {
            padding: 22px;
        }

        .hp-profile-sidebar {
            display: flex;
            flex-direction: column;
            gap: 10px;
            position: sticky;
            top: 110px;
        }

        .hp-profile-sidehead {
            padding-bottom: 10px;
            border-bottom: 1px solid var(--hp-border);
            margin-bottom: 6px;
        }

        .hp-profile-sidehead h5 {
            margin: 0 0 4px;
            font-size: 18px;
            font-weight: 800;
            color: var(--hp-title);
        }

        .hp-profile-sidehead p {
            margin: 0;
            color: var(--hp-muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .hp-profile-tab,
        .hp-profile-logout {
            width: 100%;
            border: 1px solid var(--hp-border);
            background: #fff;
            color: var(--hp-text);
            border-radius: 14px;
            padding: 14px 16px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            transition: all .2s ease;
        }

        .hp-profile-tab i,
        .hp-profile-logout i {
            font-size: 1.05rem;
        }

        .hp-profile-tab:hover,
        .hp-profile-tab.is-active {
            color: #fff;
            border-color: transparent;
            background: linear-gradient(90deg, var(--hp-primary), var(--hp-primary-2));
            transform: translateY(-1px);
            box-shadow: 0 12px 24px rgba(15, 75, 191, 0.16);
        }

        .hp-profile-logout {
            color: var(--hp-danger);
            margin-top: 8px;
        }

        .hp-profile-logout:hover {
            background: #fff5f5;
            border-color: #fecaca;
            color: #b91c1c;
        }

        .hp-profile-pane {
            display: none;
        }

        .hp-profile-pane.is-active {
            display: block;
        }

        .hp-profile-panel-head {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 18px;
        }

        .hp-profile-panel-head h4 {
            margin: 0 0 6px;
            color: var(--hp-title);
            font-size: 24px;
            font-weight: 800;
        }

        .hp-profile-panel-head p {
            margin: 0;
            color: var(--hp-muted);
            font-size: 14px;
        }

        .hp-profile-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 999px;
            background: var(--hp-soft);
            color: var(--hp-primary);
            font-weight: 700;
            font-size: 13px;
        }

        .hp-profile-form {
            display: grid;
            gap: 18px;
        }

        .hp-profile-avatar-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 18px;
            padding: 18px;
            border: 1px dashed #cdd9ea;
            border-radius: 16px;
            background: #f8fbff;
        }

        .hp-profile-avatar {
            width: 112px;
            height: 112px;
            border-radius: 24px;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
            background: #e2e8f0;
        }

        .hp-profile-upload {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: 1px solid var(--hp-border);
            background: #fff;
            border-radius: 12px;
            padding: 12px 16px;
            cursor: pointer;
            font-weight: 700;
            color: var(--hp-text);
        }

        .hp-profile-upload small {
            display: block;
            color: var(--hp-muted);
            font-weight: 500;
        }

        .hp-profile-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .hp-profile-field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .hp-profile-field--full {
            grid-column: 1 / -1;
        }

        .hp-profile-label {
            color: var(--hp-title);
            font-size: 14px;
            font-weight: 700;
        }

        .hp-profile-input,
        .hp-profile-select {
            min-height: 52px;
            border: 1px solid #dbe4f0;
            border-radius: 14px;
            background: #fff;
            color: var(--hp-text);
            padding: 0 16px;
            font-size: 14px;
            transition: all .2s ease;
        }

        .hp-profile-input:focus,
        .hp-profile-select:focus {
            border-color: #8db5ff;
            box-shadow: 0 0 0 4px rgba(15, 75, 191, 0.1);
            outline: none;
        }

        .hp-profile-help {
            color: var(--hp-muted);
            font-size: 13px;
            margin: -4px 0 0;
        }

        .hp-profile-password {
            position: relative;
        }

        .hp-profile-password .hp-profile-input {
            padding-inline-end: 52px;
        }

        .hp-profile-eye {
            position: absolute;
            top: 50%;
            inset-inline-end: 12px;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: #64748b;
            width: 34px;
            height: 34px;
            border-radius: 10px;
        }

        .hp-profile-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding-top: 6px;
        }

        .hp-btn-primary,
        .hp-btn-ghost {
            min-height: 48px;
            border-radius: 12px;
            padding: 0 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 700;
            text-decoration: none;
            transition: all .2s ease;
        }

        .hp-btn-primary {
            border: 0;
            color: #fff;
            background: linear-gradient(90deg, var(--hp-primary), var(--hp-primary-2));
        }

        .hp-btn-primary:hover {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 12px 24px rgba(15, 75, 191, 0.16);
        }

        .hp-btn-ghost {
            border: 1px solid #fecaca;
            background: #fff5f5;
            color: #b91c1c;
        }

        .hp-profile-errors {
            margin-bottom: 16px;
            padding: 16px 18px;
        }

        .hp-profile-errors ul {
            margin: 0;
            padding-inline-start: 18px;
        }

        .hp-language-list {
            display: grid;
            gap: 12px;
        }

        .hp-language-option {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border: 1px solid var(--hp-border);
            border-radius: 14px;
            background: #fff;
        }

        .hp-language-option input {
            margin: 0;
        }

        @media (max-width: 992px) {
            .hp-profile-page {
                max-width: 100%;
                margin-top: 92px;
            }

            .hp-profile-shell {
                grid-template-columns: 1fr;
            }

            .hp-profile-sidebar {
                position: static;
            }
        }

        @media (max-width: 767.98px) {
            .hp-profile-hero,
            .hp-profile-sidebar,
            .hp-profile-panel {
                padding: 18px;
            }

            .hp-profile-title {
                font-size: 26px;
            }

            .hp-profile-grid {
                grid-template-columns: 1fr;
            }

            .hp-profile-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .hp-btn-primary,
            .hp-btn-ghost {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $user = auth()->user();
    @endphp

    <main class="hp-profile-page">
        @include('flash::message')

        @if ($errors->any())
            <div class="hp-profile-card hp-profile-errors">
                <ul dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                    @foreach ($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <nav class="hp-profile-breadcrumb">
            <a href="{{ route('user/dashboard') }}">{{ __('nav.dashboard') }}</a>
            <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
            <span class="is-active" id="section-area-name">{{ __('profile.personal_info') }}</span>
        </nav>

        <section class="hp-profile-card hp-profile-hero">
            <h1 class="hp-profile-title">{{ __('profile.my_profile') }}</h1>
            <p class="hp-profile-subtitle">{{ __('profile.profile_overview') }}</p>
        </section>

        <div class="hp-profile-shell">
            <aside class="hp-profile-card hp-profile-sidebar">
                <div class="hp-profile-sidehead">
                    <h5>{{ __('profile.my_profile') }}</h5>
                    <p>{{ __('profile.profile_overview') }}</p>
                </div>

                <a class="hp-profile-tab is-active" data-target="#profile-pane" href="#profile-pane">
                    <i class="bi bi-person"></i>
                    <span>{{ __('profile.personal_info_short') }}</span>
                </a>

                <button type="button" class="hp-profile-tab" data-target="#password-pane">
                    <i class="bi bi-shield-lock"></i>
                    <span>{{ __('profile.change_password') }}</span>
                </button>

                <button type="button" class="hp-profile-tab" data-target="#language-pane">
                    <i class="bi bi-translate"></i>
                    <span>{{ __('profile.language') }}</span>
                </button>

                <a class="hp-profile-logout" href="{{ route('user/logout') }}">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>{{ __('profile.logout') }}</span>
                </a>
            </aside>

            <section class="hp-profile-card hp-profile-panel">
                <div class="hp-profile-pane is-active" id="profile-pane">
                    <div class="hp-profile-panel-head">
                        <div>
                            <h4>{{ __('profile.personal_details') }}</h4>
                            <p>{{ __('profile.profile_overview') }}</p>
                        </div>
                        <span class="hp-profile-chip">
                            <i class="bi bi-person-check"></i>
                            {{ __('profile.edit_profile') }}
                        </span>
                    </div>

                    <form action="{{ route('user/update') }}" method="post" enctype="multipart/form-data" class="hp-profile-form">
                        @csrf

                        <div class="hp-profile-avatar-row">
                            <img id="avatarPreview" class="hp-profile-avatar" src="{{ asset($user?->img) }}" alt="{{ $user?->name }}">

                            <label class="hp-profile-upload">
                                <i class="bi bi-camera"></i>
                                <span>
                                    {{ __('profile.upload_photo') }}
                                    <small>{{ __('profile.select_image_only') }}</small>
                                </span>
                                <input id="avatarInput" type="file" accept="image/*" hidden name="file">
                            </label>
                        </div>

                        <div class="hp-profile-grid">
                            <div class="hp-profile-field hp-profile-field--full">
                                <label class="hp-profile-label">{{ __('profile.name') }}</label>
                                <input name="name" class="hp-profile-input" value="{{ old('name', $user?->name) }}">
                            </div>

                            <div class="hp-profile-field">
                                <label class="hp-profile-label">{{ __('profile.phone_number') }}</label>
                                <input name="mobile" class="hp-profile-input" value="{{ old('mobile', $user?->mobile) }}">
                            </div>

                            <div class="hp-profile-field">
                                <label class="hp-profile-label">{{ __('profile.email') }}</label>
                                <input name="email" class="hp-profile-input" value="{{ old('email', $user?->email) }}">
                            </div>

                            <div class="hp-profile-field hp-profile-field--full">
                                <label class="hp-profile-label">{{ __('profile.location') }}</label>
                                <input name="location" class="hp-profile-input" value="{{ old('location', $user?->location) }}">
                            </div>
                        </div>

                        <div class="hp-profile-actions">
                            <button class="hp-btn-primary" type="submit">{{ __('profile.save_changes') }}</button>
                            <button class="hp-btn-ghost" type="button">
                                <i class="bi bi-trash"></i>
                                {{ __('profile.delete_account') }}
                            </button>
                        </div>
                    </form>
                </div>

                <div class="hp-profile-pane" id="password-pane">
                    <div class="hp-profile-panel-head">
                        <div>
                            <h4>{{ __('profile.security_settings') }}</h4>
                            <p>{{ __('profile.password_help') }}</p>
                        </div>
                        <span class="hp-profile-chip">
                            <i class="bi bi-shield-check"></i>
                            {{ __('profile.change_password') }}
                        </span>
                    </div>

                    <form method="POST" action="{{ route('user/changePassword') }}" class="hp-profile-form">
                        @csrf

                        <div class="hp-profile-field">
                            <label class="hp-profile-label">{{ __('profile.current_password') }}</label>
                            <div class="hp-profile-password">
                                <input name="old_password" type="password" class="hp-profile-input" placeholder="{{ __('profile.enter_password') }}">
                                <button class="hp-profile-eye toggle-pass" type="button" tabindex="-1">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                        </div>

                        <div class="hp-profile-grid">
                            <div class="hp-profile-field">
                                <label class="hp-profile-label">{{ __('profile.new_password') }}</label>
                                <div class="hp-profile-password">
                                    <input name="password" type="password" class="hp-profile-input" placeholder="{{ __('profile.enter_password') }}">
                                    <button class="hp-profile-eye toggle-pass" type="button" tabindex="-1">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="hp-profile-field">
                                <label class="hp-profile-label">{{ __('profile.confirm_new_password') }}</label>
                                <div class="hp-profile-password">
                                    <input name="password_confirmation" type="password" class="hp-profile-input" placeholder="{{ __('profile.enter_password') }}">
                                    <button class="hp-profile-eye toggle-pass" type="button" tabindex="-1">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="hp-profile-actions">
                            <button class="hp-btn-primary" type="submit">{{ __('profile.save_new_password') }}</button>
                        </div>
                    </form>
                </div>

                <div class="hp-profile-pane" id="language-pane">
                    <div class="hp-profile-panel-head">
                        <div>
                            <h4>{{ __('profile.language_preferences') }}</h4>
                            <p>{{ __('profile.language_help') }}</p>
                        </div>
                        <span class="hp-profile-chip">
                            <i class="bi bi-translate"></i>
                            {{ __('profile.language') }}
                        </span>
                    </div>

                    <form method="POST" action="{{ route('user/lang/update') }}" class="hp-profile-form">
                        @csrf

                        <div class="hp-language-list">
                            <label class="hp-language-option">
                                <input class="form-check-input" type="radio" name="lang" value="en" {{ $user->lang == 'en' ? 'checked' : '' }}>
                                <span>{{ __('profile.english') }}</span>
                            </label>

                            <label class="hp-language-option">
                                <input class="form-check-input" type="radio" name="lang" value="ar" {{ $user->lang == 'ar' ? 'checked' : '' }}>
                                <span>{{ __('profile.arabic') }}</span>
                            </label>
                        </div>

                        <div class="hp-profile-actions">
                            <button class="hp-btn-primary" type="submit">{{ __('profile.confirm') }}</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>
@endsection

@section('script')
    <script>
        $(function () {
            const $tabs = $('.hp-profile-tab');
            const $panes = $('.hp-profile-pane');
            const $sectionName = $('#section-area-name');
            const titles = {
                '#profile-pane': @json(__('profile.personal_info')),
                '#password-pane': @json(__('profile.change_password')),
                '#language-pane': @json(__('profile.language'))
            };

            function showPane(target) {
                $panes.removeClass('is-active');
                $(target).addClass('is-active');
                $tabs.removeClass('is-active').filter('[data-target="' + target + '"]').addClass('is-active');
                $sectionName.text(titles[target] || @json(__('profile.personal_info')));
                history.replaceState(null, '', target);
            }

            const hash = window.location.hash;
            if (hash && $(hash).length) {
                showPane(hash);
            }

            $tabs.on('click', function (e) {
                e.preventDefault();
                showPane($(this).data('target'));
            });

            $('#avatarInput').on('change', function () {
                const file = this.files && this.files[0];
                if (!file) return;

                if (!file.type.startsWith('image/')) {
                    alert(@json(__('profile.select_image_only')));
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (event) {
                    $('#avatarPreview').attr('src', event.target.result);
                };
                reader.readAsDataURL(file);
            });

            $(document).on('click', '.toggle-pass', function () {
                const $button = $(this);
                const $input = $button.siblings('input');
                const $icon = $button.find('i');
                const hidden = $input.attr('type') === 'password';

                $input.attr('type', hidden ? 'text' : 'password');
                $icon.toggleClass('bi-eye bi-eye-slash');
            });
        });
    </script>
@endsection
