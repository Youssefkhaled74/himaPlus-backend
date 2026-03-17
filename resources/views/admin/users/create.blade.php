@extends('layouts.admin.home')

@section('title')
    <title>Users</title>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <div>
                <span class="badge bg-primary-subtle text-primary mb-3">Users Module</span>
                <h3 class="mb-2">Create User</h3>
                <p class="text-muted mb-0">Add a new customer or provider profile while keeping the existing registration and provider fields untouched.</p>
            </div>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin/index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin/users/index') }}/0/{{ PAGINATION_COUNT }}">Users</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
        </div>

        @include('flash::message')
        @if ($errors->any())
            <div class="card mb-4"><div class="card-body"><ul class="mb-0" dir="ltr">@foreach ($errors->all() as $error)<li class="text-danger">{{ $error }}</li>@endforeach</ul></div></div>
        @endif

        <div class="admin-form-shell">
            <div class="admin-form-main">
                <div class="card admin-form-card">
                    <div class="card-header"><h4 class="card-title">User Details</h4><p class="card-subtitle mb-0">Core account fields and provider-specific information live in the same form as before.</p></div>
                    <div class="card-body">
                        <form role="form" action="{{ url(route('admin/users/create')) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-xxl-6 col-md-6"><div class="form-floating"><input name="name" type="text" class="form-control" id="namefloatingInput" placeholder="name" value="{{ old('name') }}"><label for="namefloatingInput">Name <span class="text-danger">*</span></label></div></div>
                                <div class="col-xxl-6 col-md-6"><div class="form-floating"><input name="mobile" type="number" class="form-control" id="mobilefloatingInput" placeholder="mobile" value="{{ old('mobile') }}"><label for="mobilefloatingInput">Mobile <span class="text-danger">*</span></label></div></div>
                                <div class="col-xxl-6 col-md-6"><div class="form-floating"><input name="email" type="email" class="form-control" id="emailfloatingInput" placeholder="email" value="{{ old('email') }}"><label for="emailfloatingInput">Email <span class="text-danger">*</span></label></div></div>
                                <div class="col-xxl-6 col-md-6"><label for="filefloatingInput" class="form-label">Profile Image <span class="text-danger">*</span></label><input name="file" type="file" id="filefloatingInput" class="form-control no-min-height admin-file-input" placeholder="Upload Image"></div>
                                <div class="col-xxl-6 col-md-6"><div class="form-floating"><input name="password" type="password" class="form-control" id="passwordfloatingInput" placeholder="Enter your password"><label for="passwordfloatingInput">Password <span class="text-danger">*</span></label></div></div>
                                <div class="col-xxl-6 col-md-6"><div class="form-floating"><input name="password_confirmation" type="password" class="form-control" id="passwordconfirmationfloatingInput" placeholder="Enter your password confirmation"><label for="passwordconfirmationfloatingInput">Password Confirmation <span class="text-danger">*</span></label></div></div>
                                <div class="col-xxl-6 col-md-6"><label for="user_typefloatingInput" class="form-label">User Type <span class="text-danger">*</span></label><select name="user_type" class="form-control" id="user_typefloatingInput" onchange="onUserTypeChange(this)"><option value=""></option><option value="1" {{ old('user_type') == '1' ? 'selected' : '' }}>Client</option><option value="2" {{ old('user_type') == '2' ? 'selected' : '' }}>Provider</option></select></div>
                                <div class="provider-area {{ old('user_type') == '2' ? '' : 'd-none' }}" id="providerArea"><div class="row"><div class="col-xxl-6 col-md-6 mt-4"><div class="form-floating"><input name="tax_number" type="text" class="form-control" id="tax_numberfloatingInput" placeholder="tax_number" value="{{ old('tax_number') }}"><label for="tax_numberfloatingInput">Tax Number <span class="text-danger">*</span></label></div></div><div class="col-xxl-6 col-md-6 mt-4"><div class="form-floating"><input name="branch" type="text" class="form-control" id="branchfloatingInput" placeholder="branch" value="{{ old('branch') }}"><label for="branchfloatingInput">Branch <span class="text-danger">*</span></label></div></div><div class="col-xxl-6 col-md-6 mt-4"><div class="form-floating"><input name="cr_number" type="text" class="form-control" id="cr_numberfloatingInput" placeholder="cr_number" value="{{ old('cr_number') }}"><label for="cr_numberfloatingInput">CR Number <span class="text-danger">*</span></label></div></div><div class="col-xxl-6 col-md-6 mt-4"><label for="cr_documentfloatingInput" class="form-label">CR Document <span class="text-danger">*</span></label><input name="cr_document" type="file" id="cr_documentfloatingInput" class="form-control no-min-height admin-file-input" placeholder="Upload Document"></div><div class="col-xxl-6 col-md-6 mt-4"><div class="form-floating"><input name="location" type="text" class="form-control" id="locationfloatingInput" placeholder="location" value="{{ old('location') }}"><label for="locationfloatingInput">Location <span class="text-danger">*</span></label></div></div></div></div>
                                <div class="col-12 admin-form-actions"><button class="btn btn-primary" type="submit">Create User</button><button class="btn btn-light" type="reset">Reset</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="admin-form-side"><div class="admin-side-note"><h5 class="mb-3">Form Guide</h5><ul><li>Use the base fields for all users.</li><li>Provider details only appear when `User Type` is `Provider`.</li><li>Field names and form submission routes remain unchanged.</li></ul></div></div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    (function () { $('.nav-link.menu-link').removeClass('active'); $('.menu-dropdown').removeClass('show'); $('.sidebarusers').addClass('active'); var target = $('.sidebarusers').attr('href'); $(target).addClass('show'); var userTypeSelect = document.getElementById('user_typefloatingInput'); if (userTypeSelect) { onUserTypeChange(userTypeSelect); } })();
    function onUserTypeChange(selectEl) { var isProvider = (selectEl.value === '2' || selectEl.value === 'provider'); var area = document.getElementById('providerArea'); area.classList.toggle('d-none', !isProvider); }
</script>
@endsection
