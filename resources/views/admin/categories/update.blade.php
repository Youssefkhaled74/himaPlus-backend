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
        
        .form-control[type="text"] {
            text-align: right;
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
        
        /* Warning Alert */
        .alert-warning {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%) !important;
            border-left: 4px solid #ffc107 !important;
            color: #856404 !important;
        }
        
        .alert-warning::before {
            content: '!';
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 24px;
            width: 24px;
            height: 24px;
            background-color: #ffc107;
            color: white;
            border-radius: 50%;
            font-weight: bold;
            font-size: 14px;
            flex-shrink: 0;
        }
        
        /* Info Alert */
        .alert-info {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%) !important;
            border-left: 4px solid #17a2b8 !important;
            color: #0c5460 !important;
        }
        
        .alert-info::before {
            content: 'ℹ';
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 24px;
            width: 24px;
            height: 24px;
            background-color: #17a2b8;
            color: white;
            border-radius: 50%;
            font-weight: bold;
            font-size: 14px;
            flex-shrink: 0;
        }
        
        .alert-message {
            flex: 1;
            padding-top: 0.25rem;
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
        
        @isset($category)
            <div class="admin-form-shell" dir="rtl">
                <div class="admin-form-main">
                    <div class="card admin-form-card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('admin.pages.categories.details') }}</h4>
                            <p class="card-subtitle mb-0">{{ __('admin.pages.categories.details_description') }}</p>
                        </div>
                        <div class="card-body">
                            <form role="form" action="{{url(route('admin/categories/update', $category->id))}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row gy-4">
                                    <div class="col-xxl-6 col-md-6">
                                        <div class="form-floating">
                                            <input name="name" type="text" class="form-control" id="namefloatingInput" placeholder="name" value="{{ $category->name }}">
                                            <label for="namefloatingInput">{{ __('admin.pages.common.name') }} <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        <label class="form-label d-block">{{ __('admin.pages.common.logo') }}</label>
                                        <div class="file-input-wrapper">
                                            <input type="file" id="filefloatingInput" name="file" class="form-control no-min-height admin-file-input" accept="image/*">
                                            <label for="filefloatingInput" class="file-input-label">
                                                <span class="file-input-name" id="fileName">{{ __('admin.pages.common.no_file_chosen') }}</span>
                                                <span class="file-input-btn">{{ __('admin.pages.common.choose_file') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 admin-form-actions">
                                        <button class="btn btn-primary" type="submit">{{ __('admin.pages.common.save_changes') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="admin-form-side">
                    <div class="admin-side-note">
                        <h5 class="mb-3">{{ __('admin.pages.categories.current_category') }}</h5>
                        <ul>
                            <li>{{ __('admin.pages.common.name') }}: {{ $category->name }}</li>
                            <li>{{ __('admin.pages.common.id') }}: {{ $category->id }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        @endisset
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
