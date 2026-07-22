@extends('layouts.admin.home')

<!-- title page -->
@section('title')
    <title>{{ __('admin.pages.coupons.title') }}</title>
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
                                <li class="breadcrumb-item"><a href="{{route('admin/coupons/index')}}/0/{{PAGINATION_COUNT}}">{{ __('admin.nav.coupons') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('admin.pages.common.update') }}</li>
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
                            <h4 class="card-title mb-0 flex-grow-1">{{ __('admin.pages.coupons.update_title') }}</h4>
                        </div>
                        <div class="card-body">
                            @isset($coupon)
                                <form role="form" action="{{ route('admin/coupons/update', $coupon->id) }}" method="post" enctype="multipart/form-data">
                                    <div class="live-preview">
                                        @csrf
                                        <div class="row gy-4">

                                            <div class="col-xxl-6 col-md-6">
                                                <div class="form-floating">
                                                    <input name="name" type="text" class="form-control" id="namefloatingInput" placeholder="name" value="{{$coupon->name}}">
                                                    <label for="namefloatingInput">{{ __('admin.pages.common.name') }} <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-md-6">
                                                <div class="form-floating">
                                                    <input name="amount" type="number" class="form-control" id="amountfloatingInput" placeholder="amount" value="{{$coupon->amount}}">
                                                    <label for="amountfloatingInput">{{ __('admin.pages.coupons.discount_value') }} <span class="text-danger">*</span></label>
                                                </div>
                                            </div>      
                                            <div class="col-xxl-6 col-md-6">
                                                <div class="form-group">
                                                    <label>{{ __('admin.pages.coupons.coupon_type') }} <span class="input-group-addon" style="color: red;">*</span></label>
                                                    <div class="input-group">
                                                        <select class="form-control" name="type" id="coupons">
                                                            <option value="">{{ __('admin.pages.coupons.select_type') }}</option>
                                                            <option value="1" {{$coupon->type == 1 ? 'selected' : ''}}>{{ __('admin.pages.coupons.type_amount') }}</option>
                                                            <option value="2" {{$coupon->type == 2 ? 'selected' : ''}}>{{ __('admin.pages.coupons.type_percentage') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <button class="btn btn-primary" type="submit">{{ __('admin.pages.common.submit_form') }}</button>
                                            </div>

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

<!-- custom js -->
@section('script')
<script>
    (function () {
        $('.nav-link.menu-link').removeClass('active');
        $('.menu-dropdown').removeClass('show');
        $('.sidebarcoupons').addClass('active');
        var target = $('.sidebarcoupons').attr('href');
        $(target).addClass('show');
    })();
</script>
@endsection

