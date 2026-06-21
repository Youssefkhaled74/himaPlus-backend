@extends('layouts.admin.home')

<!-- title page -->
@section('title')
    <title>{{ __('admin.pages.orders.title') }}</title>
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
                                <li class="breadcrumb-item"><a href="{{route('admin/index')}}">{{ __('admin.pages.common.home') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{route('admin/orders/index')}}/0/{{PAGINATION_COUNT}}">{{ __('admin.nav.orders') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('admin.pages.common.create') }}</li>
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
                            <h4 class="card-title mb-0 flex-grow-1">{{ __('admin.pages.orders.order_form') ?? 'Order Form' }}</h4>
                        </div>
                        <div class="card-body">
                            <form role="form" action="{{ route('admin/orders/create') }}" method="post" enctype="multipart/form-data">
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
                                                <label>orders</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon" style="color: red;">*</span>
                                                    <select class="form-control" name="Order_id" id="orders">
                                                        <option value="">select</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div> -->

                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">{{ __('admin.pages.common.submit_form') }}</button>
                                            <button class="btn btn-success" type="reset">{{ __('admin.pages.common.reset_button') }}</button>
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
        $('.sidebarorders').addClass('active');
        // $('#sidebarApps').addClass('show').siblings().removeClass('collapsed').attr('aria-expanded', 'true');
        // $('#sidebarorders').addClass('show').siblings().removeClass('collapsed').attr('aria-expanded', 'true');
        var target = $('.sidebarorders').attr('href');
        $(target).addClass('show');
    })();
    // $('#orders').select2({
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
