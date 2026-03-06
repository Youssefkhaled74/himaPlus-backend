@extends('layouts.admin.home')

@section('title')
    <title>Users</title>
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
                                <li class="breadcrumb-item"><a href="{{route('admin/index')}}">Home</a></li>
                                <li class="breadcrumb-item active"><a href="{{route('admin/users/index')}}/0/{{PAGINATION_COUNT}}">Users</a></li>
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
                            <li class="text-danger">{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Update User</h4>
                        </div>
                        <div class="card-body">
                            @isset($user)
                                <form role="form" action="{{url(route('admin/users/update', $user->id))}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row gy-4">
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="name" type="text" class="form-control" id="namefloatingInput" placeholder="name" value="{{ old('name', $user->name) }}">
                                                <label for="namefloatingInput">Name <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="mobile" type="text" class="form-control" id="mobilefloatingInput" placeholder="mobile" value="{{ old('mobile', $user->mobile) }}">
                                                <label for="mobilefloatingInput">Mobile <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="email" type="email" class="form-control" id="emailfloatingInput" placeholder="email" value="{{ old('email', $user->email) }}">
                                                <label for="emailfloatingInput">Email <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="iban" type="text" class="form-control" id="ibanfloatingInput" placeholder="iban" value="{{ old('iban', $user->iban) }}">
                                                <label for="ibanfloatingInput">IBAN</label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <label for="filefloatingInput">Profile Image</label>
                                            <div class="form-floating">
                                                <input name="file" type="file" id="filefloatingInput" class="form-control no-min-height" placeholder="Upload Image">
                                            </div>
                                            @if($user->img)
                                                <small class="d-block mt-2">
                                                    <a href="{{ asset($user->img) }}" target="_blank">Open current image</a>
                                                </small>
                                            @endif
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="password" type="password" class="form-control" id="passwordfloatingInput" placeholder="Enter new password">
                                                <label for="passwordfloatingInput">New Password</label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <label for="user_typefloatingInput">User Type <span class="text-danger">*</span></label>
                                                <select name="user_type" class="form-control" id="user_typefloatingInput" onchange="onUserTypeChange(this)">
                                                    <option value=""></option>
                                                    <option value="1" {{ (string) old('user_type', $user->user_type) === '1' ? 'selected' : '' }}>عميل</option>
                                                    <option value="2" {{ (string) old('user_type', $user->user_type) === '2' ? 'selected' : '' }}>مورد</option>
                                                    <option value="3" {{ (string) old('user_type', $user->user_type) === '3' ? 'selected' : '' }}>غير محدد</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="password_confirmation" type="password" class="form-control" id="passwordconfirmationfloatingInput" placeholder="Confirm password">
                                                <label for="passwordconfirmationfloatingInput">Confirm Password</label>
                                            </div>
                                        </div>

                                        <div class="provider-area {{ (string) old('user_type', $user->user_type) === '2' ? '' : 'd-none' }}" id="providerArea">
                                            <div class="row">
                                                <div class="col-xxl-6 col-md-6 mt-4">
                                                    <div class="form-floating">
                                                        <input name="tax_number" type="text" class="form-control" id="tax_numberfloatingInput" placeholder="tax_number" value="{{ old('tax_number', $user->tax_number) }}">
                                                        <label for="tax_numberfloatingInput">Tax Number</label>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-6 col-md-6 mt-4">
                                                    <div class="form-floating">
                                                        <input name="branch" type="text" class="form-control" id="branchfloatingInput" placeholder="branch" value="{{ old('branch', $user->branch) }}">
                                                        <label for="branchfloatingInput">Branch</label>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-6 col-md-6 mt-4">
                                                    <div class="form-floating">
                                                        <input name="cr_number" type="text" class="form-control" id="cr_numberfloatingInput" placeholder="cr_number" value="{{ old('cr_number', $user->cr_number) }}">
                                                        <label for="cr_numberfloatingInput">CR Number</label>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-6 col-md-6 mt-4">
                                                    <label for="cr_documentfloatingInput">CR Document</label>
                                                    <div class="form-floating">
                                                        <input name="cr_document" type="file" id="cr_documentfloatingInput" class="form-control no-min-height" placeholder="Upload Document">
                                                    </div>
                                                    @if($user->cr_document)
                                                        <small class="d-block mt-2">
                                                            <a href="{{ asset($user->cr_document) }}" target="_blank">Open current document</a>
                                                        </small>
                                                    @endif
                                                </div>
                                                <div class="col-xxl-6 col-md-6 mt-4">
                                                    <div class="form-floating">
                                                        <input name="location" type="text" class="form-control" id="locationfloatingInput" placeholder="location" value="{{ old('location', $user->location) }}">
                                                        <label for="locationfloatingInput">Location</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Save Changes</button>
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
        $('.sidebarusers').addClass('active');
        var target = $('.sidebarusers').attr('href');
        $(target).addClass('show');

        var userTypeSelect = document.getElementById('user_typefloatingInput');
        if (userTypeSelect) {
            onUserTypeChange(userTypeSelect);
        }
    })();

    function onUserTypeChange(selectEl) {
        var isProvider = selectEl.value === '2';
        var area = document.getElementById('providerArea');
        area.classList.toggle('d-none', !isProvider);
    }
</script>
@endsection
