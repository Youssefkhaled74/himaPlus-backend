@extends('layouts.admin.home')

@section('title')
    <title>{{ __('admin.pages.admins.title') }}</title>
@endsection

@section('css')
    <style>
        .page-title-box {
            direction: rtl;
            text-align: right;
        }
        
        .page-content {
            direction: rtl;
        }
        
        .form-floating > label {
            right: var(--bs-body-font-size);
            left: auto;
        }
        
        .form-control {
            text-align: right;
        }
        
        .file-input-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        
        .file-input-wrapper input[type="file"] {
            display: none;
        }
        
        .file-input-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            background-color: #fff;
            cursor: pointer;
            text-align: right;
        }
        
        .file-input-label:hover {
            background-color: #f8f9fa;
        }
        
        .file-input-name {
            flex: 1;
            margin-right: 1rem;
            color: #6c757d;
        }
        
        .file-input-name.active {
            color: #212529;
        }
        
        .file-input-btn {
            padding: 0.375rem 0.75rem;
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
            font-size: 0.875rem;
            white-space: nowrap;
        }
        
        .file-input-btn:hover {
            background-color: #0b5ed7;
        }
        
        /* Enhanced Alert Styles */
        .alert {
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.25rem 1.5rem !important;
            border: none !important;
            border-radius: 0.5rem !important;
            animation: slideDown 0.4s ease-out;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Success Alert */
        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%) !important;
            border-left: 4px solid #28a745 !important;
            color: #155724 !important;
        }
        
        .alert-success::before {
            content: '✓';
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 24px;
            width: 24px;
            height: 24px;
            background-color: #28a745;
            color: white;
            border-radius: 50%;
            font-weight: bold;
            font-size: 14px;
            flex-shrink: 0;
        }
        
        .alert-success strong {
            color: #155724;
            font-weight: 600;
        }
        
        /* Close Button */
        .alert .close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            opacity: 0.6;
            cursor: pointer;
            padding: 0;
            color: #155724;
        }
        
        .alert .close:hover {
            opacity: 1;
        }
        
        /* Error Alert */
        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%) !important;
            border-left: 4px solid #dc3545 !important;
            color: #721c24 !important;
        }
        
        .alert-danger::before {
            content: '⚠';
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 24px;
            width: 24px;
            height: 24px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            font-weight: bold;
            font-size: 14px;
            flex-shrink: 0;
        }
        
        .breadcrumb {
            flex-direction: row-reverse;
        }
        
        .breadcrumb-item + .breadcrumb-item::before {
            margin: 0 0.5rem 0 0;
        }
    </style>
@endsection

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent" dir="rtl">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin/index') }}">{{ __('admin.pages.common.home') }}</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('admin/admins/index') }}/0/{{ PAGINATION_COUNT }}">{{ __('admin.nav.admins') }}</a></li>
                            <li class="active" style="color: var(--vz-breadcrumb-item-active-color);">{{ __('admin.pages.common.update') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        @include('flash::message')
        @if ($errors->any())
            <div style="text-align: right; margin: 15px;" dir="rtl">
                <ul dir="rtl">
                    @foreach ($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">{{ __('admin.pages.admins.update_admin') }}</h4>
                    </div>
                    <div class="card-body">
                        @isset($admin)
                            <form role="form" action="{{ url(route('admin/admins/update', $admin->id)) }}" method="post" enctype="multipart/form-data" dir="rtl">
                                <div class="live-preview">
                                    @csrf
                                    <div class="row gy-4">

                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="name" type="text" class="form-control" id="namefloatingInput" placeholder="Enter your name" value="{{ old('name', $admin->name) }}">
                                                <label for="namefloatingInput">{{ __('admin.pages.common.name') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="email" type="email" class="form-control" id="emailfloatingInput" placeholder="Enter your email" value="{{ old('email', $admin->email) }}">
                                                <label for="emailfloatingInput">{{ __('admin.pages.common.email') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="phone" type="text" class="form-control" id="phonefloatingInput" placeholder="Enter your phone" value="{{ old('phone', $admin->phone) }}">
                                                <label for="phonefloatingInput">{{ __('admin.pages.admins.phone') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <label class="form-label d-block">{{ __('admin.pages.admins.profile_image') }}</label>
                                            <div class="file-input-wrapper">
                                                <input type="file" id="filefloatingInput" name="file" class="form-control no-min-height admin-file-input" accept="image/*">
                                                <label for="filefloatingInput" class="file-input-label">
                                                    <span class="file-input-name" id="fileName">{{ __('admin.pages.common.no_file_chosen') }}</span>
                                                    <span class="file-input-btn">{{ __('admin.pages.common.choose_file') }}</span>
                                                </label>
                                            </div>
                                            @if($admin->img)
                                                <small class="d-block mt-2">
                                                    <a href="{{ asset($admin->img) }}" target="_blank">{{ __('admin.pages.admins.open_current_image') }}</a>
                                                </small>
                                            @endif
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="password" type="password" class="form-control" id="passwordfloatingInput" placeholder="Enter new password">
                                                <label for="passwordfloatingInput">{{ __('admin.pages.admins.password') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="password_confirmation" type="password" class="form-control" id="passwordconfirmationfloatingInput" placeholder="Confirm password">
                                                <label for="passwordconfirmationfloatingInput">{{ __('admin.pages.admins.password_confirmation') }}</label>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">{{ __('admin.pages.common.save_changes') }}</button>
                                            <a href="{{ route('admin/admins/index') }}/0/{{ PAGINATION_COUNT }}" class="btn btn-success">{{ __('admin.pages.admins.back') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endisset
                    </div>
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
        $('.sidebaradmins').addClass('active');
        var target = $('.sidebaradmins').attr('href');
        $(target).addClass('show');
        
        // Handle file input change
        $('#filefloatingInput').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            if (fileName) {
                $('#fileName').text(fileName).addClass('active');
            } else {
                $('#fileName').text('{{ __("admin.pages.common.no_file_chosen") }}').removeClass('active');
            }
        });
        
        // Auto-hide success/info alerts after 5 seconds
        setTimeout(function() {
            $('.alert-success, .alert-info').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
        
        // Add close button handler
        $(document).on('click', '.alert .close', function() {
            $(this).closest('.alert').fadeOut('slow', function() {
                $(this).remove();
            });
        });
    })();
</script>
@endsection

