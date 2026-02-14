@extends('layouts.admin.home')

<!-- title page -->
@section('title')
    <title>Products</title>
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
                                <li class="breadcrumb-item active"><a href="{{route('admin/products/index')}}/0/{{PAGINATION_COUNT}}">Products</a></li>
                                <li class="active" style="color: var(--vz-breadcrumb-item-active-color);">Update</li>
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
                            <h4 class="card-title mb-0 flex-grow-1">Product Update</h4>
                        </div>
                        <div class="card-body">
                            @isset($product)
                                <form role="form" action="{{url(route('admin/products/update', $product->id))}}" method="post" enctype="multipart/form-data">
                                    <div class="live-preview">
                                        @csrf
                                        <div class="row gy-4">

                                        <div class="col-xxl-12 col-md-12">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_offer" value="1" id="offerflexSwitchCheckDefault" {{ $product->is_offer == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="offerflexSwitchCheckDefault">has offer</label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-12 col-md-12">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_special" value="1" id="specialflexSwitchCheckDefault" {{ $product->is_special == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="specialflexSwitchCheckDefault">is special</label>
                                            </div>
                                        </div>
                                            <div class="col-xxl-6 col-md-6">
                                                <div class="form-floating">
                                                    <input name="name" value="{{$product->name}}" type="text" class="form-control" id="namefloatingInput" placeholder="name">
                                                    <label for="namefloatingInput">name <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-md-6">
                                                <div class="form-group">
                                                    <label>provider <span class="input-group-addon" style="color: red;">*</span></label>
                                                    <div class="input-group">
                                                        <select class="form-control" name="provider_id" id="providers">
                                                            <option value="{{$product->provider_id}}">{{$product->provider?->name ?? 'select'}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-md-6">
                                                <div class="form-group">
                                                    <label>categories <span class="input-group-addon" style="color: red;">*</span></label>
                                                    <div class="input-group">
                                                        <select class="form-control" name="category_id" id="categories">
                                                            <option value="{{$product->category_id}}">{{$product->category?->name ?? 'select'}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-md-6">
                                                <div class="form-floating">
                                                    <input name="desc" value="{{$product->desc}}" type="text" class="form-control" id="descfloatingInput" placeholder="desc">
                                                    <label for="descfloatingInput">description <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-md-6">
                                                <div class="form-floating">
                                                    <input name="price" value="{{$product->price}}" type="number" class="form-control" id="namefloatingInput" placeholder="price">
                                                    <label for="pricefloatingInput">price <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-md-6">
                                                <label for="filefloatingInput">Img  <span class="text-danger">*</span></label>
                                                <div class="form-floating">
                                                    <input name="file" type="file" id="filefloatingInput" class="form-control no-min-height" placeholder="Upload Image">
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-md-6">
                                                <label for="filefloatingInput">Imgs <span class="text-danger"></span></label>
                                                <div class="form-floating">
                                                    <input name="files[]" type="file" id="filefloatingInput" class="form-control no-min-height" placeholder="Upload Image" multiple>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-md-6">
                                                <div class="form-floating">
                                                    <input name="stock_quantity" value="{{$product->stock_quantity}}" type="number" class="form-control" id="namefloatingInput" placeholder="stock_quantity">
                                                    <label for="stock_quantityfloatingInput">Stock Quantity <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-md-6">
                                                <div class="form-floating">
                                                    <input name="imaging_type" value="{{$product->imaging_type}}" type="text" class="form-control" id="imaging_typefloatingInput" placeholder="imaging_type">
                                                    <label for="imaging_typefloatingInput">Imaging Type <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-md-6">
                                                <div class="form-floating">
                                                    <input name="power" value="{{$product->power}}" type="text" class="form-control" id="powerfloatingInput" placeholder="power">
                                                    <label for="powerfloatingInput">power <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-md-6">
                                                <div class="form-floating">
                                                    <input name="manufacture_date" value="{{$product->manufacture_date}}" type="date" class="form-control" id="manufacture_datefloatingInput" placeholder="manufacture_date">
                                                    <label for="manufacture_datefloatingInput">Manufacture Date <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-md-6">
                                                <div class="form-floating">
                                                    <input name="production_date" value="{{$product->production_date}}" type="date" class="form-control" id="production_datefloatingInput" placeholder="production_date">
                                                    <label for="production_datefloatingInput">Production Date <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-md-6">
                                                <div class="form-floating">
                                                    <input name="expiry_date" value="{{$product->expiry_date}}" type="date" class="form-control" id="expiry_datefloatingInput" placeholder="expiry_date">
                                                    <label for="expiry_datefloatingInput">Expiry Date <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-md-6">
                                                <div class="form-floating">
                                                    <input name="weight" value="{{$product->weight}}" type="text" class="form-control" id="weightfloatingInput" placeholder="weight">
                                                    <label for="weightfloatingInput">Weight <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-md-6">
                                                <div class="form-floating">
                                                    <input name="dimensions" value="{{$product->dimensions}}" type="text" class="form-control" id="dimensionsfloatingInput" placeholder="dimensions">
                                                    <label for="dimensionsfloatingInput">Dimensions <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-md-6">
                                                <div class="form-floating">
                                                    <input name="warranty" value="{{$product->warranty}}" type="text" class="form-control" id="warrantyfloatingInput" placeholder="warranty">
                                                    <label for="warrantyfloatingInput">Warranty <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Origin <span class="input-group-addon" style="color: red;">*</span></label>
                                                    <div class="input-group">
                                                        <select class="form-control" name="origin_id" id="origins">
                                                            <option value="{{$product->origin_id}}">{{$product->origin?->name ?? 'select'}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <button class="btn btn-primary" type="submit">Submit form</button>
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
        $('.sidebarproducts').addClass('active');
        var target = $('.sidebarproducts').attr('href');
        $(target).addClass('show');
    })();
    $('#providers').select2({
        ajax: {
            url: "{{ route('get/users') }}",
            dataType: 'json',
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
</script>
@endsection
