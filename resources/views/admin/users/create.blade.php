@extends('layouts.admin.home')

<!-- title page -->
@section('title')
    <title>Users</title>
@endsection

<!-- custom css -->
@section('css')
@endsection

@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent" style="direction: ltr;">
                        {{-- <h4 class="mb-sm-0">Team</h4> --}}

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"></li>
                                <li class="breadcrumb-item"><a href="{{route('admin/index')}}">Home</a></li>
                                <li class="breadcrumb-item active"><a href="{{route('admin/users/index')}}/0/{{PAGINATION_COUNT}}">Users</a></li>
                                <li class="active" style="color: var(--vz-breadcrumb-item-active-color);">Create</li>
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
                            <h4 class="card-title mb-0 flex-grow-1">User Form</h4>
                        </div>
                        <div class="card-body">
                            <form role="form" action="{{url(route('admin/users/create'))}}" method="post" enctype="multipart/form-data">
                                <div class="live-preview">
                                    @csrf
                                    <div class="row gy-4">

                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="name" type="text" class="form-control" id="namefloatingInput" placeholder="name">
                                                <label for="namefloatingInput">name <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="mobile" type="number" class="form-control" id="mobilefloatingInput" placeholder="mobile">
                                                <label for="mobilefloatingInput">mobile <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="email" type="email" class="form-control" id="namefloatingInput" placeholder="email">
                                                <label for="namefloatingInput">email <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <label for="filefloatingInput">Img<span class="text-danger"> *</span></label>
                                            <div class="form-floating">
                                                <input name="file" type="file" id="filefloatingInput" class="form-control no-min-height" placeholder="Upload Image">
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="password" type="password" class="form-control" id="namefloatingInput" placeholder="Enter your password">
                                                <label for="namefloatingInput">password<span class="text-danger"> *</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="password_confirmation" type="password" class="form-control" id="namefloatingInput" placeholder="Enter your password confirmation">
                                                <label for="namefloatingInput">password confirmation<span class="text-danger"> *</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="col-xxl-12 col-md-12">
                                                <div class="form-floating">
                                                    <label for="user_typefloatingInput">User Type <span class="text-danger">*</span></label>
                                                    <select name="user_type" class="form-control" id="user_typefloatingInput" onchange="onUserTypeChange(this)">
                                                        <option value=""></option>
                                                        <option value="1">عميل</option>
                                                        <option value="2">مورد</option>
                                                    </select>                                                
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="provider-area d-none" id="providerArea">
                                        <div class="live-preview">
                                        <div class="row">
                                            <div class="col-xxl-6 col-md-6 mt-4">
                                                <div class="form-floating">
                                                    <input name="tax_number" type="text" class="form-control" id="tax_numberfloatingInput" placeholder="tax_number">
                                                    <label for="tax_numberfloatingInput">tax_number <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-md-6 mt-4">
                                                <div class="form-floating">
                                                    <input name="branch" type="text" class="form-control" id="branchfloatingInput" placeholder="branch">
                                                    <label for="branchfloatingInput">branch <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-md-6 mt-4">
                                                <div class="form-floating">
                                                    <input name="cr_number" type="text" class="form-control" id="cr_numberfloatingInput" placeholder="cr_number">
                                                    <label for="cr_numberfloatingInput">CR number <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-md-6 mt-4">
                                                <label for="cr_documentfloatingInput">CR document<span class="text-danger"> *</span></label>
                                                <div class="form-floating">
                                                    <input name="cr_document" type="file" id="cr_documentfloatingInput" class="form-control no-min-height" placeholder="Upload Image">
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-md-6 mt-4">
                                                <div class="form-floating">
                                                    <input name="location" type="text" class="form-control" id="locationfloatingInput" placeholder="location">
                                                    <label for="locationfloatingInput">location <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Submit form</button>
                                            <button class="btn btn-success" type="reset">Reset Button</button>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

<!-- custom js -->
@section('script')
<script>
    (function () {
        $('.nav-link.menu-link').removeClass('active');
        $('.menu-dropdown').removeClass('show');
        $('.sidebarusers').addClass('active');
        // $('#sidebarApps').addClass('show').siblings().removeClass('collapsed').attr('aria-expanded', 'true');
        // $('#sidebarusers').addClass('show').siblings().removeClass('collapsed').attr('aria-expanded', 'true');
        var target = $('.sidebarusers').attr('href');
        $(target).addClass('show');
    })();
    function onUserTypeChange(selectEl) {
        var isProvider = (selectEl.value === '2' || selectEl.value === 'provider');
        var area = document.getElementById('providerArea');
        area.classList.toggle('d-none', !isProvider);
    }
</script>
@endsection
