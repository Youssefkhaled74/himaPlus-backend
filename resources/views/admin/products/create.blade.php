@extends('layouts.admin.home')

<!-- title page -->
@section('title')
    <title>{{ __('admin.pages.products.title') }}</title>
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
                                <li class="breadcrumb-item"><a href="{{route('admin/products/index')}}/0/{{PAGINATION_COUNT}}">{{ __('admin.nav.products') }}</a></li>
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
                            <h4 class="card-title mb-0 flex-grow-1">{{ __('admin.pages.products.create_title') }}</h4>
                        </div>
                        <div class="card-body">
                            <form role="form" action="{{ route('admin/products/create') }}" method="post" enctype="multipart/form-data">
                                <div class="live-preview">
                                    @csrf
                                    <div class="row gy-4">

                                        <div class="col-xxl-12 col-md-12">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_offer" value="1" id="offerflexSwitchCheckDefault">
                                                <label class="form-check-label" for="offerflexSwitchCheckDefault">{{ __('admin.pages.products.has_offer') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-12 col-md-12">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_special" value="1" id="specialflexSwitchCheckDefault">
                                                <label class="form-check-label" for="specialflexSwitchCheckDefault">{{ __('admin.pages.products.is_special') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="name" type="text" class="form-control" id="namefloatingInput" placeholder="{{ __('admin.pages.common.name') }}">
                                                <label for="namefloatingInput">{{ __('admin.pages.common.name') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-group">
                                                <label>{{ __('admin.pages.common.provider') }} <span class="input-group-addon" style="color: red;">*</span></label>
                                                <div class="input-group">
                                                    <select class="form-control" name="provider_id" id="providers">
                                                        <option value="">select</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-group">
                                                <label>{{ __('admin.pages.common.category') }} <span class="input-group-addon" style="color: red;">*</span></label>
                                                <div class="input-group">
                                                    <select class="form-control" name="category_id" id="categories">
                                                        <option value="">select</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="desc" type="text" class="form-control" id="descfloatingInput" placeholder="{{ __('admin.pages.products.description_label') }}">
                                                <label for="descfloatingInput">{{ __('admin.pages.products.description_label') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="price" type="number" class="form-control" id="namefloatingInput" placeholder="{{ __('admin.pages.common.price') }}">
                                                <label for="pricefloatingInput">{{ __('admin.pages.common.price') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <label for="filefloatingInput">{{ __('admin.pages.products.main_image') }} <span class="text-danger">*</span></label>
                                            <div class="form-floating">
                                                <input name="file" type="file" id="filefloatingInput" class="form-control no-min-height" placeholder="{{ __('admin.pages.common.upload_image') }}">
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <label for="filefloatingInput">{{ __('admin.pages.products.gallery_images') }}</label>
                                            <div class="form-floating">
                                                <input name="files[]" type="file" id="filefloatingInput" class="form-control no-min-height" placeholder="{{ __('admin.pages.common.upload_image') }}" multiple>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="stock_quantity" type="number" class="form-control" id="namefloatingInput" placeholder="{{ __('admin.pages.common.stock_quantity') }}">
                                                <label for="stock_quantityfloatingInput">{{ __('admin.pages.common.stock_quantity') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="imaging_type" type="text" class="form-control" id="imaging_typefloatingInput" placeholder="{{ __('admin.pages.products.imaging_type') }}">
                                                <label for="imaging_typefloatingInput">{{ __('admin.pages.products.imaging_type') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="power" type="text" class="form-control" id="powerfloatingInput" placeholder="{{ __('admin.pages.products.power') }}">
                                                <label for="powerfloatingInput">{{ __('admin.pages.products.power') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="manufacture_date" type="date" class="form-control" id="manufacture_datefloatingInput" placeholder="{{ __('admin.pages.products.manufacture_date') }}">
                                                <label for="manufacture_datefloatingInput">{{ __('admin.pages.products.manufacture_date') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="production_date" type="date" class="form-control" id="production_datefloatingInput" placeholder="{{ __('admin.pages.products.production_date') }}">
                                                <label for="production_datefloatingInput">{{ __('admin.pages.products.production_date') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="expiry_date" type="date" class="form-control" id="expiry_datefloatingInput" placeholder="{{ __('admin.pages.products.expiry_date') }}">
                                                <label for="expiry_datefloatingInput">{{ __('admin.pages.products.expiry_date') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="weight" type="text" class="form-control" id="weightfloatingInput" placeholder="{{ __('admin.pages.products.weight') }}">
                                                <label for="weightfloatingInput">{{ __('admin.pages.products.weight') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="dimensions" type="text" class="form-control" id="dimensionsfloatingInput" placeholder="{{ __('admin.pages.products.dimensions') }}">
                                                <label for="dimensionsfloatingInput">{{ __('admin.pages.products.dimensions') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="warranty" type="text" class="form-control" id="warrantyfloatingInput" placeholder="{{ __('admin.pages.products.warranty') }}">
                                                <label for="warrantyfloatingInput">{{ __('admin.pages.products.warranty') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-group">
                                                <label>{{ __('admin.pages.common.origin') }} <span class="input-group-addon" style="color: red;">*</span></label>
                                                <div class="input-group">
                                                    <select class="form-control" name="origin_id" id="origins">
                                                        <option value="">select</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-group">
                                                <label>{{ __('admin.pages.products.registration_type') }} <span class="input-group-addon" style="color: red;">*</span></label>
                                                <select class="form-control" name="registration_type" required>
                                                    <option value="">select</option>
                                                    <option value="sfda">SFDA</option>
                                                    <option value="saber">SABER</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <label>{{ __('admin.pages.products.guarantee_file') }} <span class="text-danger">*</span></label>
                                            <input name="guarantee_file" type="file" class="form-control no-min-height" accept=".jpg,.jpeg,.png,.webp,.pdf" required>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <label>{{ __('admin.pages.products.product_pdf') }}</label>
                                            <input name="product_pdf" type="file" class="form-control no-min-height" accept=".pdf">
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="registration_number" type="text" class="form-control" placeholder="{{ __('admin.pages.products.registration_number') }}" maxlength="100" required>
                                                <label>{{ __('admin.pages.products.registration_number') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="registration_expiry_date" type="date" class="form-control" required>
                                                <label>{{ __('admin.pages.products.registration_expiry_date') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="factory_name" type="text" class="form-control" placeholder="{{ __('admin.pages.products.factory_name') }}" maxlength="100" required>
                                                <label>{{ __('admin.pages.products.factory_name') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-group">
                                                <label>{{ __('admin.pages.products.factory_country') }} <span class="input-group-addon" style="color: red;">*</span></label>
                                                <select class="form-control" name="factory_country" id="factory_countries" required>
                                                    <option value="">select</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="uom" type="text" class="form-control" placeholder="{{ __('admin.pages.products.uom') }}" maxlength="100" required>
                                                <label>{{ __('admin.pages.products.uom') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        

                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">{{ __('admin.pages.products.submit') }}</button>
                                            <button class="btn btn-success" type="reset">{{ __('admin.pages.common.reset') }}</button>
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
        $('.sidebarproducts').addClass('active');
        // $('#sidebarApps').addClass('show').siblings().removeClass('collapsed').attr('aria-expanded', 'true');
        // $('#sidebarproducts').addClass('show').siblings().removeClass('collapsed').attr('aria-expanded', 'true');
        var target = $('.sidebarproducts').attr('href');
        $(target).addClass('show');
    })();
    $('#providers').select2({
        ajax: {
            url: "{{ route('get/users') }}",
            dataType: 'json',
            data: function (params) {
                return {
                    q: params.term || ''
                };
            },
            processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                        return {
                            id: item.id,
                            text: item.name
                        }
                    })
                };
            },
            cache: true,
            width: '100%'
        }
    });
    $('#categories').select2({
        ajax: {
            url: "{{ route('get/categories') }}",
            dataType: 'json',
            data: function (params) {
                return {
                    q: params.term || ''
                };
            },
            processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                        return {
                            id: item.id,
                            text: item.name
                        }
                    })
                };
            },
            cache: true,
            width: '100%'
        }
    });
    $('#origins').select2({
        ajax: {
            url: "{{ route('get/countries') }}",
            dataType: 'json',
            data: function (params) {
                return {
                    q: params.term || ''
                };
            },
            processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                        return {
                            id: item.id,
                            text: item.name
                        }
                    })
                };
            },
            cache: true,
            width: '100%'
        }
    });
    $('#factory_countries').select2({
        ajax: {
            url: "{{ route('get/countries') }}",
            dataType: 'json',
            data: function (params) { return { q: params.term || '' }; },
            processResults: function (data) {
                return { results: $.map(data, function (item) { return { id: item.name, text: item.name } }) };
            },
            cache: true,
            width: '100%'
        }
    });
    $('[name=\"imaging_type\"],[name=\"dimensions\"]').prop('disabled', true).closest('.col-xxl-6').hide();
</script>
@endsection
