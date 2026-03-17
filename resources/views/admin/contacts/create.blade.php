@extends('layouts.admin.home')

@section('title')
    <title>Contacts</title>
@endsection

@section('content')
<div class="page-content"><div class="container-fluid"><x-admin.page-header badge="Contacts Module" title="Create Contact" description="Add a new contact record without changing the current backend save behavior." :breadcrumbs="[['label' => 'Home', 'href' => route('admin/index')], ['label' => 'Contacts', 'href' => route('admin/contacts/index') . '/0/' . PAGINATION_COUNT], ['label' => 'Create', 'active' => true]]" />@include('flash::message') @if ($errors->any())<div class="card mb-4"><div class="card-body"><ul class="mb-0" dir="ltr">@foreach ($errors->all() as $error)<li class="text-danger">{{ $error }}</li>@endforeach</ul></div></div>@endif <div class="admin-form-shell"><div class="admin-form-main"><div class="card admin-form-card"><div class="card-header"><h4 class="card-title">Contact Details</h4><p class="card-subtitle mb-0">Capture mobile, email, location, and notes in a cleaner card layout.</p></div><div class="card-body"><form role="form" action="{{url(route('admin/contacts/create'))}}" method="post">@csrf<div class="row gy-4"><div class="col-xxl-6 col-md-6"><div class="form-floating"><input name="mobile" type="text" class="form-control" id="mobilefloatingInput" placeholder="mobile" value="{{ old('mobile') }}"><label for="mobilefloatingInput">Mobile <span class="text-danger">*</span></label></div></div><div class="col-xxl-6 col-md-6"><div class="form-floating"><input name="email" type="email" class="form-control" id="emailfloatingInput" placeholder="email" value="{{ old('email') }}"><label for="emailfloatingInput">Email <span class="text-danger">*</span></label></div></div><div class="col-xxl-6 col-md-6"><div class="form-floating"><input name="location" type="text" class="form-control" id="locationfloatingInput" placeholder="location" value="{{ old('location') }}"><label for="locationfloatingInput">Location <span class="text-danger">*</span></label></div></div><div class="col-12"><label for="detailsTextarea" class="form-label">Details</label><textarea name="details" id="detailsTextarea" class="form-control" rows="5">{{ old('details') }}</textarea></div><div class="col-12 admin-form-actions"><button class="btn btn-primary" type="submit">Create Contact</button><button class="btn btn-light" type="reset">Reset</button></div></div></form></div></div></div><div class="admin-form-side"><div class="admin-side-note"><h5 class="mb-3">Notes</h5><ul><li>This screen keeps the same route and field names.</li><li>Textarea content still posts through `details`.</li></ul></div></div></div></div></div>
@endsection

@section('script')
<script>
</script>
@endsection
