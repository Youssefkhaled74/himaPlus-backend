@extends('layouts.admin.home')

@section('title')
    <title>{{ __('admin.pages.categories.title') }}</title>
@endsection

@section('css')
    <style>
        .page-title-box {
            direction: rtl;
            text-align: right;
        }

        .page-title-box .page-title-right {
            flex-direction: row-reverse;
        }

        .admin-form-shell {
            direction: rtl;
        }

        .admin-form-card .form-floating > label {
            right: var(--bs-body-font-size);
            left: auto;
        }

        .form-control[type="text"] {
            text-align: right;
        }

        .uploader-card {
            border: 1px dashed #b8c7de;
            border-radius: 16px;
            background: linear-gradient(180deg, #fbfdff 0%, #f5f9ff 100%);
            padding: 14px;
            transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
        }

        .uploader-card:hover,
        .uploader-card.is-active {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.12);
            background: #f8fbff;
        }

        .uploader-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 10px;
        }

        .uploader-title {
            margin: 0;
            font-weight: 700;
            color: #1f2a44;
            font-size: 0.95rem;
        }

        .uploader-btn {
            border: 0;
            border-radius: 12px;
            padding: 10px 14px;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, #2352b7 0%, #1f4293 100%);
            cursor: pointer;
            white-space: nowrap;
        }

        .uploader-btn:hover {
            filter: brightness(1.03);
        }

        .uploader-meta {
            margin: 0;
            font-size: 0.86rem;
            color: #6f7f98;
        }

        .uploader-file-name {
            display: inline-block;
            margin-top: 8px;
            padding: 6px 10px;
            border-radius: 999px;
            background-color: #e8f0ff;
            color: #173b84;
            font-weight: 700;
            font-size: 0.83rem;
        }

        .uploader-native-input {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            border: 0;
        }
    </style>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @include('flash::message')

        @if ($errors->any())
            <div class="card mb-4">
                <div class="card-body">
                    <ul class="mb-0" dir="ltr">
                        @foreach ($errors->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="admin-form-shell" dir="rtl">
            <div class="admin-form-main">
                <div class="card admin-form-card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('admin.pages.categories.details') }}</h4>
                        <p class="card-subtitle mb-0">{{ __('admin.pages.categories.create_details_description') }}</p>
                    </div>
                    <div class="card-body">
                        <form role="form" action="{{ url(route('admin/categories/create')) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-xxl-6 col-md-6">
                                    <div class="form-floating">
                                        <input name="name" type="text" class="form-control" id="namefloatingInput" placeholder="name" value="{{ old('name') }}">
                                        <label for="namefloatingInput">{{ __('admin.pages.common.name') }} <span class="text-danger">*</span></label>
                                    </div>
                                </div>

                                <div class="col-xxl-6 col-md-6">
                                    <label for="filefloatingInput" class="form-label">{{ __('admin.pages.common.logo') }} <span class="text-danger">*</span></label>
                                    <div class="uploader-card" id="categoryUploaderCard">
                                        <input name="file" type="file" id="filefloatingInput" class="uploader-native-input" accept="image/*">
                                        <div class="uploader-head">
                                            <p class="uploader-title">{{ __('admin.pages.categories.upload_logo') }}</p>
                                            <button type="button" class="uploader-btn" id="chooseLogoBtn">{{ __('admin.pages.common.choose_file') }}</button>
                                        </div>
                                        <p class="uploader-meta">{{ __('admin.pages.categories.upload_logo_hint') }}</p>
                                        <span class="uploader-file-name" id="fileName">{{ __('admin.pages.common.no_file_chosen') }}</span>
                                    </div>
                                </div>

                                <div class="col-12 admin-form-actions">
                                    <button class="btn btn-primary" type="submit">{{ __('admin.pages.categories.create_title') }}</button>
                                    <button class="btn btn-light" type="reset">{{ __('admin.pages.common.reset') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="admin-form-side">
                <div class="admin-side-note">
                    <h5 class="mb-3">{{ __('admin.pages.categories.notes_title') }}</h5>
                    <ul>
                        <li>{{ __('admin.pages.categories.note_endpoint') }}</li>
                        <li>{{ __('admin.pages.categories.note_upload_field') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    (function () {
        $('.nav-link.menu-link').removeClass('active');
        $('.menu-dropdown').removeClass('show');
        $('.sidebarcategories').addClass('active');
        var target = $('.sidebarcategories').attr('href');
        $(target).addClass('show');

        var $fileInput = $('#filefloatingInput');
        var $fileName = $('#fileName');
        var $uploaderCard = $('#categoryUploaderCard');

        $('#chooseLogoBtn').on('click', function () {
            $fileInput.trigger('click');
        });

        $fileInput.on('change', function () {
            var selectedName = this.files && this.files.length ? this.files[0].name : '';
            $fileName.text(selectedName || '{{ __("admin.pages.common.no_file_chosen") }}');
        });

        $uploaderCard.on('dragover', function (event) {
            event.preventDefault();
            event.stopPropagation();
            $uploaderCard.addClass('is-active');
        });

        $uploaderCard.on('dragleave drop', function (event) {
            event.preventDefault();
            event.stopPropagation();
            $uploaderCard.removeClass('is-active');
        });

        $uploaderCard.on('click', function (event) {
            if ($(event.target).closest('#chooseLogoBtn').length === 0) {
                $fileInput.trigger('click');
            }
        });
    })();
</script>
@endsection
