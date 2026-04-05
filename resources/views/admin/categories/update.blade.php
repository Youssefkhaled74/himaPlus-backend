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
    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between" dir="rtl">
            <div>
                <span class="badge bg-primary-subtle text-primary mb-3">{{ __('admin.pages.categories.module_label') }}</span>
                <h3 class="mb-2">{{ __('admin.pages.categories.update_title') }}</h3>
                <p class="text-muted mb-0">{{ __('admin.pages.categories.update_description') }}</p>
            </div>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin/index') }}">{{ __('admin.pages.common.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin/categories/index') }}/0/{{ PAGINATION_COUNT }}">{{ __('admin.nav.categories') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('admin.pages.common.update') }}</li>
                </ol>
            </div>
        </div>
        
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
    })();
</script>
@endsection
