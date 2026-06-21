@extends('layouts.admin.home')

@section('title')
    <title>{{ __('admin.pages.users.title') }}</title>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <x-admin.page-header
            :badge="__('admin.pages.users.module_label')"
            :title="__('admin.pages.users.create_title')"
            :description="__('admin.pages.users.create_description')"
            :breadcrumbs="[
                ['label' => __('admin.pages.common.home'), 'href' => route('admin/index')],
                ['label' => __('admin.nav.users'), 'href' => route('admin/users/index') . '/0/' . PAGINATION_COUNT],
                ['label' => __('admin.pages.common.create'), 'active' => true],
            ]"
        />

        @include('flash::message')
        @if ($errors->any())
            <div class="card mb-4"><div class="card-body"><ul class="mb-0" dir="ltr">@foreach ($errors->all() as $error)<li class="text-danger">{{ $error }}</li>@endforeach</ul></div></div>
        @endif

        <div class="admin-form-shell">
            <div class="admin-form-main">
                <div class="card admin-form-card">
                    <div class="card-header"><h4 class="card-title">{{ __('admin.pages.users.user_details') }}</h4><p class="card-subtitle mb-0">{{ __('admin.pages.users.user_details_subtitle') }}</p></div>
                    <div class="card-body">
                        <form role="form" action="{{ route('admin/users/create') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-xxl-6 col-md-6"><div class="form-floating"><input name="name" type="text" class="form-control" id="namefloatingInput" placeholder="{{ __('admin.pages.common.name') }}" value="{{ old('name') }}"><label for="namefloatingInput">{{ __('admin.pages.common.name') }} <span class="text-danger">*</span></label></div></div>
                                <div class="col-xxl-6 col-md-6"><div class="form-floating"><input name="mobile" type="number" class="form-control" id="mobilefloatingInput" placeholder="{{ __('admin.pages.common.mobile') }}" value="{{ old('mobile') }}"><label for="mobilefloatingInput">{{ __('admin.pages.common.mobile') }} <span class="text-danger">*</span></label></div></div>
                                <div class="col-xxl-6 col-md-6"><div class="form-floating"><input name="email" type="email" class="form-control" id="emailfloatingInput" placeholder="{{ __('admin.pages.common.email') }}" value="{{ old('email') }}"><label for="emailfloatingInput">{{ __('admin.pages.common.email') }} <span class="text-danger">*</span></label></div></div>
                                <div class="col-xxl-6 col-md-6"><label for="filefloatingInput" class="form-label">{{ __('admin.pages.common.image') }} <span class="text-danger">*</span></label><input name="file" type="file" id="filefloatingInput" class="form-control no-min-height admin-file-input" placeholder="{{ __('admin.pages.common.upload_image') }}"></div>
                                <div class="col-xxl-6 col-md-6"><div class="form-floating"><input name="password" type="password" class="form-control" id="passwordfloatingInput" placeholder="{{ __('admin.pages.common.enter_new_password') }}"><label for="passwordfloatingInput">{{ __('admin.pages.common.password') }} <span class="text-danger">*</span></label></div></div>
                                <div class="col-xxl-6 col-md-6"><div class="form-floating"><input name="password_confirmation" type="password" class="form-control" id="passwordconfirmationfloatingInput" placeholder="{{ __('admin.pages.common.confirm_password') }}"><label for="passwordconfirmationfloatingInput">{{ __('admin.pages.common.confirm_password') }} <span class="text-danger">*</span></label></div></div>
                                <div class="col-xxl-6 col-md-6"><label for="user_typefloatingInput" class="form-label">{{ __('admin.pages.common.user_type') }} <span class="text-danger">*</span></label><select name="user_type" class="form-control" id="user_typefloatingInput" onchange="onUserTypeChange(this)"><option value=""></option><option value="1" {{ old('user_type') == '1' ? 'selected' : '' }}>{{ __('admin.pages.common.client') }}</option><option value="2" {{ old('user_type') == '2' ? 'selected' : '' }}>{{ __('admin.pages.common.provider') }}</option></select></div>
                                <div class="provider-area {{ old('user_type') == '2' ? '' : 'd-none' }}" id="providerArea"><div class="row"><div class="col-xxl-6 col-md-6 mt-4"><div class="form-floating"><input name="tax_number" type="text" class="form-control" id="tax_numberfloatingInput" placeholder="{{ __('admin.pages.common.tax_number') }}" value="{{ old('tax_number') }}"><label for="tax_numberfloatingInput">{{ __('admin.pages.common.tax_number') }} <span class="text-danger">*</span></label></div></div><div class="col-xxl-6 col-md-6 mt-4"><div class="form-floating"><input name="branch" type="text" class="form-control" id="branchfloatingInput" placeholder="{{ __('admin.pages.common.branch') }}" value="{{ old('branch') }}"><label for="branchfloatingInput">{{ __('admin.pages.common.branch') }} <span class="text-danger">*</span></label></div></div><div class="col-xxl-6 col-md-6 mt-4"><div class="form-floating"><input name="cr_number" type="text" class="form-control" id="cr_numberfloatingInput" placeholder="{{ __('admin.pages.common.cr_number') }}" value="{{ old('cr_number') }}"><label for="cr_numberfloatingInput">{{ __('admin.pages.common.cr_number') }} <span class="text-danger">*</span></label></div></div><div class="col-xxl-6 col-md-6 mt-4"><label for="cr_documentfloatingInput" class="form-label">{{ __('admin.pages.common.cr_document') }} <span class="text-danger">*</span></label><input name="cr_document" type="file" id="cr_documentfloatingInput" class="form-control no-min-height admin-file-input" placeholder="{{ __('admin.pages.common.open_file') }}"></div><div class="col-xxl-6 col-md-6 mt-4"><div class="form-floating"><input name="location" type="text" class="form-control" id="locationfloatingInput" placeholder="{{ __('admin.pages.common.location') }}" value="{{ old('location') }}"><label for="locationfloatingInput">{{ __('admin.pages.common.location') }} <span class="text-danger">*</span></label></div></div></div></div>
                                <div class="col-12 admin-form-actions"><button class="btn btn-primary" type="submit">{{ __('admin.pages.users.create_user') }}</button><button class="btn btn-light" type="reset">{{ __('admin.pages.common.reset') }}</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="admin-form-side"><div class="admin-side-note"><h5 class="mb-3">{{ __('admin.pages.users.form_guide') }}</h5><ul><li>{{ __('admin.pages.users.form_guide_base') }}</li><li>{{ __('admin.pages.users.form_guide_provider') }}</li><li>{{ __('admin.pages.users.form_guide_fields') }}</li></ul></div></div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    (function () { var userTypeSelect = document.getElementById('user_typefloatingInput'); if (userTypeSelect) { onUserTypeChange(userTypeSelect); } })();
    function onUserTypeChange(selectEl) { var isProvider = (selectEl.value === '2' || selectEl.value === 'provider'); var area = document.getElementById('providerArea'); area.classList.toggle('d-none', !isProvider); }
</script>
@endsection
