@extends('layouts.front.home')

<!-- title page -->
@section('title')
    <title>{{ __('profile.title') }}</title>
@endsection

<!-- custom page -->
@section('css')
    <style></style>
@endsection

@section('content')

    @php
        $user = auth()->user();
    @endphp
    <main class="container my-4" style="max-width: 80%;">
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
        <nav class="breadcrumb-custom mb-3" style="margin-top: 8%;">
            <a href="#" class="text-decoration-none text-muted">{{ __('profile.my_profile') }}</a>
            <i class="bi bi-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
            <span class="text-primary fw-semibold" id="section-area-name">{{ __('profile.personal_info') }}</span>
        </nav>

        <div class="row g-4" style="margin-bottom: 12%;">
            <div class="col-lg-3">
                <div class="profile-side">
                    <a class="btn-tab active" section-name="{{ __('profile.personal_info') }}" data-target="#profile-pane" href="#profile-pane">
                        <i class="bi bi-person"></i> <span>{{ __('profile.personal_info_short') }}</span>
                    </a>
                    <a class="btn-tab" section-name="{{ __('profile.change_password') }}" data-target="#password-pane" href="#password-pane">
                        <i class="bi bi-shield-lock"></i> <span>{{ __('profile.change_password') }}</span>
                    </a>
                    <a class="btn-tab" section-name="{{ __('profile.language') }}" data-target="#language-pane" href="#language-pane">
                        <i class="bi bi-translate"></i> <span>{{ __('profile.language') }}</span>
                    </a>
                    <a class="custom-btn-tab" href="{{ route('user/logout') }}">
                        <i class="bi bi-box-arrow-right"></i> <span>{{ __('profile.logout') }}</span>
                    </a>
                </div>
            </div>

            <div class="col-lg-9 tab-pane" id="profile-pane">
                <div class="detail-card reveal">
                    <form action="{{ route('user/update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="avatar rounded-circle mx-auto mb-2" style="width:72px;height:72px;background:#E9EDF7;display:flex;align-items:center;justify-content:center;cursor:pointer;overflow:hidden;position:relative;">
                                <i class="bi bi-person" style="font-size:28px;color:#456;"></i>
                                <input id="avatarInput" type="file" accept="image/*" hidden name="file">
                            </label>
                            <img id="avatarPreview" alt="preview" style="width:120px;height:120px;border-radius:50%;object-fit:cover;" src="{{ asset($user?->img) }}">
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">{{ __('profile.name') }}</label>
                                <input name="name" class="form-control" value="{{ $user?->name }}">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">{{ __('profile.phone_number') }}</label>
                                <div class="input-group">
                                    {{-- <span class="input-group-text bg-light border">+966</span> --}}
                                    <input name="mobile" class="form-control" value="{{ $user?->mobile }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ __('profile.email') }}</label>
                                <input name="email" class="form-control" value="{{ $user?->email }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ __('profile.location') }}</label>
                                <input name="location" class="form-control" value="{{ $user?->location }}">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <button class="btn btn-gradient" type="submit">{{ __('profile.edit_profile') }}</button>
                            <button class="btn btn-ghost"><i class="bi bi-trash me-1 text-danger"></i> {{ __('profile.delete_account') }}</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-9 tab-pane d-none" id="password-pane">
                <form method="POST" action="{{ route('user/changePassword') }}">
                    @csrf
                    <div class="detail-card reveal">
                        <h6 class="mb-3">{{ __('profile.create_new_password') }}</h6>
                        <label class="form-label">{{ __('profile.current_password') }}</label>
                        {{-- <div class="input-group mb-3">
                            <input name="old_password" type="password" class="form-control" placeholder="Enter Password">
                            <span class="input-group-text"><i class="bi bi-eye-slash"></i></span>
                        </div> --}}
                        <div class="input-group mb-3 password-field">
                            <input name="old_password" type="password" class="form-control" placeholder="{{ __('profile.enter_password') }}">
                            <button class="btn btn-outline-secondary toggle-pass" type="button" tabindex="-1">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>

                        <label class="form-label">{{ __('profile.new_password') }}</label>
                        <div class="input-group mb-3">
                            <div class="input-group mb-3 password-field">
                                <input name="password" type="password" class="form-control" placeholder="{{ __('profile.enter_password') }}">
                                <button class="btn btn-outline-secondary toggle-pass" type="button" tabindex="-1">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                            {{-- <input name="new_password" type="password" class="form-control" placeholder="Enter Password">
                            <span class="input-group-text"><i class="bi bi-eye-slash"></i></span> --}}
                        </div>
                        <label class="form-label">{{ __('profile.confirm_new_password') }}</label>
                        <div class="input-group mb-3">
                            <div class="input-group mb-3 password-field">
                                <input name="password_confirmation" type="password" class="form-control" placeholder="{{ __('profile.enter_password') }}">
                                <button class="btn btn-outline-secondary toggle-pass" type="button" tabindex="-1">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                            {{-- <input name="password_confirmation" type="password" class="form-control" placeholder="Enter Password">
                            <span class="input-group-text"><i class="bi bi-eye-slash"></i></span> --}}
                        </div>
                        <button class="btn btn-gradient px-4">{{ __('profile.save_new_password') }}</button>
                    </div>
                </form>
            </div>

            <div class="col-lg-9 tab-pane d-none" id="language-pane">
                <form method="POST" action="{{ route('user/lang/update') }}">
                    @csrf
                    <div class="detail-card reveal">
                        <h6 class="mb-3">{{ __('profile.change_language') }}</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="lang" id="langEn" value="en" {{ $user->lang == 'en' ? 'checked' : '' }}>
                            <label class="form-check-label" for="langEn">{{ __('profile.english') }}</label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="lang" id="langAr" value="ar" {{ $user->lang == 'ar' ? 'checked' : '' }}>
                            <label class="form-check-label" for="langAr">{{ __('profile.arabic') }}</label>
                        </div>
                        <button class="btn btn-gradient px-4">{{ __('profile.confirm') }}</button>
                    </div>
                </form>
            </div>

        </div>
    </main>
@endsection

<!-- custom js -->
@section('script')
    <script>
        $(function(){
            const $wrapper = $('.avatar');
            const $icon = $wrapper.find('i');
            const $input = $('#avatarInput');
            const $imgPreview = $('#avatarPreview');

            $wrapper.attr('tabindex', 0).on('keydown', function(e){
                if (e.key === 'Enter' || e.key === ' ') $input.trigger('click');
            });

            $input.on('change', function(){
                const file = this.files && this.files[0];
                if (!file) return;
                if (!file.type.startsWith('image/')) {
                    alert('{{ __('profile.select_image_only') }}');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e){
                    // $icon.remove();
                    // $wrapper.css({
                    //     backgroundImage: `url('${e.target.result}')`,
                    //     backgroundSize: 'cover',
                    //     backgroundPosition: 'center'
                    // });
                    $imgPreview.attr('src', e.target.result).show();
                };
                reader.readAsDataURL(file);
            });
            
            const $tabs = $('.btn-tab');
            const $panes = $('.tab-pane');
            const $bc = $('.breadcrumb-custom .fw-semibold');

            const titles = {
                '#profile-pane': '{{ __('profile.personal_info') }}',
                '#password-pane': '{{ __('profile.change_password') }}',
                '#language-pane': '{{ __('profile.language') }}'
            };

            function showPane(sel) {
                $panes.addClass('d-none');
                $(sel).removeClass('d-none');
                $tabs.removeClass('active').filter('[data-target="' + sel + '"]').addClass('active');
                $bc.text(titles[sel] || '{{ __('profile.personal_info') }}');
                history.replaceState(null, '', sel);
            }

            const hash = window.location.hash;
            if (hash && $(hash).length) showPane(hash);
            else showPane($tabs.first().data('target'));

            $tabs.on('click', function(e) {
                e.preventDefault();
                showPane($(this).data('target'));
            });

            $(document).on('click', '.password-field .toggle-pass', function () {
                const $group = $(this).closest('.password-field');
                const $input = $group.find('input');
                const $icon  = $(this).find('i');

                const isHidden = $input.attr('type') === 'password';
                $input.attr('type', isHidden ? 'text' : 'password');

                $icon.toggleClass('bi-eye bi-eye-slash');
            });



        });
    </script>
@endsection
