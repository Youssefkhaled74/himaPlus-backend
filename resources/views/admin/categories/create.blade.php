@extends('layouts.admin.home')

@section('title')
    <title>Categories</title>
@endsection

@section('content')
<div class="page-content"><div class="container-fluid"><div class="page-title-box d-sm-flex align-items-center justify-content-between"><div><span class="badge bg-primary-subtle text-primary mb-3">Categories Module</span><h3 class="mb-2">Create Category</h3><p class="text-muted mb-0">Add a new catalog category with the existing create route and upload fields.</p></div><div class="page-title-right"><ol class="breadcrumb m-0"><li class="breadcrumb-item"><a href="{{ route('admin/index') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('admin/categories/index') }}/0/{{ PAGINATION_COUNT }}">Categories</a></li><li class="breadcrumb-item active">Create</li></ol></div></div>@include('flash::message') @if ($errors->any())<div class="card mb-4"><div class="card-body"><ul class="mb-0" dir="ltr">@foreach ($errors->all() as $error)<li class="text-danger">{{ $error }}</li>@endforeach</ul></div></div>@endif <div class="admin-form-shell"><div class="admin-form-main"><div class="card admin-form-card"><div class="card-header"><h4 class="card-title">Category Details</h4><p class="card-subtitle mb-0">Create a category name and branding asset for the storefront catalog.</p></div><div class="card-body"><form role="form" action="{{url(route('admin/categories/create'))}}" method="post" enctype="multipart/form-data">@csrf<div class="row gy-4"><div class="col-xxl-6 col-md-6"><div class="form-floating"><input name="name" type="text" class="form-control" id="namefloatingInput" placeholder="name" value="{{ old('name') }}"><label for="namefloatingInput">Name <span class="text-danger">*</span></label></div></div><div class="col-xxl-6 col-md-6"><label for="filefloatingInput" class="form-label">Logo <span class="text-danger">*</span></label><input name="file" type="file" id="filefloatingInput" class="form-control no-min-height admin-file-input" placeholder="Upload Image"></div><div class="col-12 admin-form-actions"><button class="btn btn-primary" type="submit">Create Category</button><button class="btn btn-light" type="reset">Reset</button></div></div></form></div></div></div><div class="admin-form-side"><div class="admin-side-note"><h5 class="mb-3">Notes</h5><ul><li>The form still submits to the same create endpoint.</li><li>The upload input keeps the same name: `file`.</li></ul></div></div></div></div></div>
@endsection

@section('script')
<script>
    (function () { $('.nav-link.menu-link').removeClass('active'); $('.menu-dropdown').removeClass('show'); $('.sidebarcategories').addClass('active'); var target = $('.sidebarcategories').attr('href'); $(target).addClass('show'); })();
</script>
@endsection
