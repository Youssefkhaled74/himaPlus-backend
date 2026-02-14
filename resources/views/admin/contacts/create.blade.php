@extends('layouts.admin.home')

<!-- title page -->
@section('title')
    <title>Contacts</title>
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
                                <li class="breadcrumb-item active"><a href="{{route('admin/contacts/index')}}/0/{{PAGINATION_COUNT}}">Contacts</a></li>
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
                            <h4 class="card-title mb-0 flex-grow-1">Contact Form</h4>
                        </div>
                        <div class="card-body">
                            <form role="form" action="{{url(route('admin/contacts/create'))}}" method="post" enctype="multipart/form-data">
                                <div class="live-preview">
                                    @csrf
                                    <div class="row gy-4">

                                        <!-- <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="name" type="text" class="form-control" id="namefloatingInput" placeholder="name">
                                                <label for="namefloatingInput">name <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="email" type="email" class="form-control" id="namefloatingInput" placeholder="email">
                                                <label for="namefloatingInput">email <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="file" type="file" id="filefloatingInput" class="form-control" placeholder="Upload Image">
                                                <label for="filefloatingInput"><span class="text-danger"></span></label>
                                            </div>
                                        </div>      
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-group">
                                                <label>contacts</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon" style="color: red;">*</span>
                                                    <select class="form-control" name="Contact_id" id="contacts">
                                                        <option value="">select</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div> -->

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
        $('.sidebarcontacts').addClass('active');
        // $('#sidebarApps').addClass('show').siblings().removeClass('collapsed').attr('aria-expanded', 'true');
        // $('#sidebarcontacts').addClass('show').siblings().removeClass('collapsed').attr('aria-expanded', 'true');
        var target = $('.sidebarcontacts').attr('href');
        $(target).addClass('show');
    })();
    // $('#contacts').select2({
    //     ajax: {
    //         url: "#",
    //         dataType: 'json',
    //         processResults: function (data) {
    //             return {
    //                 results:  $.map(data, function (item) {
    //                     return {
    //                         id: item.id,
    //                         text: item.name
    //                     }
    //                 })
    //             };
    //         },
    //         cache: true
    //     }
    // });
</script>
@endsection
