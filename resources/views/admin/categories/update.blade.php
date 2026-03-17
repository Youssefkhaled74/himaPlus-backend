@extends('layouts.admin.home')

@section('title')
    <title>Categories</title>
@endsection

@section('content')
<div class="page-content"><div class="container-fluid"><div class="page-title-box d-sm-flex align-items-center justify-content-between"><div><span class="badge bg-primary-subtle text-primary mb-3">Categories Module</span><h3 class="mb-2">Update Category</h3><p class="text-muted mb-0">Refresh the category name or logo without changing any backend update behavior.</p></div><div class="page-title-right"><ol class="breadcrumb m-0"><li class="breadcrumb-item"><a href="{{ route('admin/index') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('admin/categories/index') }}/0/{{ PAGINATION_COUNT }}">Categories</a></li><li class="breadcrumb-item active">Update</li></ol></div></div>@include('flash::message') @if ($errors->any())<div class="card mb-4"><div class="card-body"><ul class="mb-0" dir="ltr">@foreach ($errors->all() as $error)<li class="text-danger">{{ $error }}</li>@endforeach</ul></div></div>@endif @isset($category)<div class="admin-form-shell"><div class="admin-form-main"><div class="card admin-form-card"><div class="card-header"><h4 class="card-title">Category Details</h4><p class="card-subtitle mb-0">Update the category presentation while keeping the same form fields and route.</p></div><div class="card-body"><form role="form" action="{{url(route('admin/categories/update', $category->id))}}" method="post" enctype="multipart/form-data">@csrf<div class="row gy-4"><div class="col-xxl-6 col-md-6"><div class="form-floating"><input name="name" type="text" class="form-control" id="namefloatingInput" placeholder="name" value="{{ $category->name }}"><label for="namefloatingInput">Name <span class="text-danger">*</span></label></div></div><div class="col-xxl-6 col-md-6"><label for="filefloatingInput" class="form-label">Logo</label><input name="file" type="file" id="filefloatingInput" class="form-control no-min-height admin-file-input" placeholder="Upload Image"></div><div class="col-12 admin-form-actions"><button class="btn btn-primary" type="submit">Save Changes</button></div></div></form></div></div></div><div class="admin-form-side"><div class="admin-side-note"><h5 class="mb-3">Current Category</h5><ul><li>Name: {{ $category->name }}</li><li>ID: {{ $category->id }}</li></ul></div></div></div>@endisset</div></div>
@endsection

@section('script')
<script>
    (function () { $('.nav-link.menu-link').removeClass('active'); $('.menu-dropdown').removeClass('show'); $('.sidebarcategories').addClass('active'); var target = $('.sidebarcategories').attr('href'); $(target).addClass('show'); })();
</script>
@endsection
