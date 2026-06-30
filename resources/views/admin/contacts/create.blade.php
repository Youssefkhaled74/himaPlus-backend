@extends('layouts.admin.home')

@section('title')
    <title>{{ __('admin.pages.contacts.title') }}</title>
@endsection

@section('content')
<div class="page-content"><div class="container-fluid"><x-admin.page-header badge="{{ __('admin.pages.contacts.module_label') }}" title="{{ __('admin.pages.contacts.add_contact') }}" description="{{ trans_or_fallback('', '') }}" :breadcrumbs="[['label' => __('admin.pages.common.home'), 'href' => route('admin/index')], ['label' => __('admin.pages.contacts.title'), 'href' => route('admin/contacts/index') . '/0/' . PAGINATION_COUNT], ['label' => __('admin.pages.common.create'), 'active' => true]]" />@include('flash::message') @if ($errors->any())<div class="card mb-4"><div class="card-body"><ul class="mb-0" dir="ltr">@foreach ($errors->all() as $error)<li class="text-danger">{{ $error }}</li>@endforeach</ul></div></div>@endif <div class="admin-form-shell"><div class="admin-form-main"><div class="card admin-form-card"><div class="card-header"><h4 class="card-title">{{ trans_or_fallback('', '') }}</h4><p class="card-subtitle mb-0">{{ trans_or_fallback('', '') }}</p></div><div class="card-body"><form role="form" action="{{route('admin/contacts/create')}}" method="post">@csrf<div class="row gy-4"><div class="col-xxl-6 col-md-6"><div class="form-floating"><input name="mobile" type="text" class="form-control" id="mobilefloatingInput" placeholder="mobile" value="{{ old('mobile') }}"><label for="mobilefloatingInput">{{ __('admin.pages.common.mobile') }} <span class="text-danger">*</span></label></div></div><div class="col-xxl-6 col-md-6"><div class="form-floating"><input name="email" type="email" class="form-control" id="emailfloatingInput" placeholder="email" value="{{ old('email') }}"><label for="emailfloatingInput">{{ __('admin.pages.common.email') }} <span class="text-danger">*</span></label></div></div><div class="col-xxl-6 col-md-6"><div class="form-floating"><input name="location" type="text" class="form-control" id="locationfloatingInput" placeholder="location" value="{{ old('location') }}"><label for="locationfloatingInput">{{ __('admin.pages.common.location') }} <span class="text-danger">*</span></label></div></div><div class="col-12"><label for="detailsTextarea" class="form-label">{{ __('admin.pages.common.details') }}</label><textarea name="details" id="detailsTextarea" class="form-control" rows="5">{{ old('details') }}</textarea></div><div class="col-12 admin-form-actions"><button class="btn btn-primary" type="submit">{{ trans_or_fallback('', '') }}</button><button class="btn btn-light" type="reset">{{ __('admin.pages.common.reset_button') }}</button></div></div></form></div></div></div><div class="admin-form-side"><div class="admin-side-note"><h5 class="mb-3">{{ trans_or_fallback('', '') }}</h5><ul><li>{{ trans_or_fallback('', '') }}</li><li>{{ trans_or_fallback('', '') }}</li></ul></div></div></div></div></div>
@endsection

@section('script')
<script>
</script>
@endsection

