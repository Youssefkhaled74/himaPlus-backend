@extends('layouts.admin.home')

@section('title')
    <title>Admins</title>
@endsection

@section('css')
@endsection

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent" style="direction: ltr;">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin/index') }}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('admin/admins/index') }}/0/{{ PAGINATION_COUNT }}">Admins</a></li>
                            <li class="active" style="color: var(--vz-breadcrumb-item-active-color);">Update</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

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

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Update Admin</h4>
                    </div>
                    <div class="card-body">
                        @isset($admin)
                            <form role="form" action="{{ url(route('admin/admins/update', $admin->id)) }}" method="post" enctype="multipart/form-data">
                                <div class="live-preview">
                                    @csrf
                                    <div class="row gy-4">

                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="name" type="text" class="form-control" id="namefloatingInput" placeholder="Enter your name" value="{{ old('name', $admin->name) }}">
                                                <label for="namefloatingInput">name</label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="email" type="email" class="form-control" id="emailfloatingInput" placeholder="Enter your email" value="{{ old('email', $admin->email) }}">
                                                <label for="emailfloatingInput">email</label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="phone" type="text" class="form-control" id="phonefloatingInput" placeholder="Enter your phone" value="{{ old('phone', $admin->phone) }}">
                                                <label for="phonefloatingInput">phone</label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <label for="filefloatingInput">Profile Image</label>
                                            <div class="form-floating">
                                                <input name="file" type="file" id="filefloatingInput" class="form-control no-min-height" placeholder="Upload Image">
                                            </div>
                                            @if($admin->img)
                                                <small class="d-block mt-2">
                                                    <a href="{{ asset($admin->img) }}" target="_blank">Open current image</a>
                                                </small>
                                            @endif
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="password" type="password" class="form-control" id="passwordfloatingInput" placeholder="Enter new password">
                                                <label for="passwordfloatingInput">password</label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="password_confirmation" type="password" class="form-control" id="passwordconfirmationfloatingInput" placeholder="Confirm password">
                                                <label for="passwordconfirmationfloatingInput">password confirmation</label>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Save Changes</button>
                                            <a href="{{ route('admin/admins/index') }}/0/{{ PAGINATION_COUNT }}" class="btn btn-success">Back</a>
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
    })();
</script>
@endsection

