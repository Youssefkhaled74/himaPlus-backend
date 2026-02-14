@extends('layouts.admin.home')

<!-- title page -->
@section('title')
    <title>Info</title>
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
                                <li class="breadcrumb-item active"><a href="{{route('admin/info/index')}}/0/{{PAGINATION_COUNT}}">Info</a></li>
                                <li class="active" style="color: var(--vz-breadcrumb-item-active-color);">Index</li>
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
                        <div class="card-header">
                            <h5 class="card-title mb-0">Info Viwes</h5>
                        </div>
                        <div class="card-body">
                            <div id="scroll-horizontal_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div id="scroll-horizontal_filter" class="dataTables_filter">
                                            <label>
                                                <input type="search" class="form-control form-control-sm data_search" placeholder="Search" aria-controls="scroll-horizontal" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="card mt-xxl-n5">
                                        <div class="card-header">
                                            <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-bs-toggle="tab" href="#info" role="tab">
                                                        <i class="fas fa-home"></i> Genral Data
                                                    </a>
                                                </li>
                                                {{-- <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#asks" role="tab">
                                                        <i class="far fa-user"></i> Asks
                                                    </a>
                                                </li> --}}
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#abouts" role="tab">
                                                        <i class="far fa-user"></i> About Us
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#privacyPolicy" role="tab">
                                                        <i class="far fa-user"></i> Privacy Policy
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#terms" role="tab">
                                                        <i class="far fa-user"></i> Terms
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <form role="form" action="{{url(route('admin/info/update', 1))}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @php 
                                                $abouts = $info?->abouts ?? [];
                                                $terms = $info?->terms ?? [];
                                                $privacyPolicies = $info?->privacy_policies ?? [];
                                            @endphp
                                            <div class="card-body p-4">
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="info" role="tabpanel">
                                                        <div class="row gy-4">
                                                            <div class="col-xxl-6 col-md-6">
                                                                <div class="form-floating">
                                                                    <input name="mobile" value="{{ $info?->mobile }}" type="text" class="form-control" id="mobilefloatingInput" placeholder="mobile">
                                                                    <label for="mobilefloatingInput">mobile <span class="text-danger">*</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-6 col-md-6">
                                                                <div class="form-floating">
                                                                    <input name="email" value="{{ $info?->email }}" type="text" class="form-control" id="emailfloatingInput" placeholder="email">
                                                                    <label for="emailfloatingInput">email <span class="text-danger">*</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-6 col-md-6">
                                                                <div class="form-floating">
                                                                    <input name="location" value="{{ $info?->location }}" type="text" class="form-control" id="locationfloatingInput" placeholder="location">
                                                                    <label for="locationfloatingInput">location <span class="text-danger">*</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-6 col-md-6">
                                                                <div class="form-floating">
                                                                    <input name="facebook" value="{{ $info?->facebook }}" type="text" class="form-control" id="facebookfloatingInput" placeholder="facebook">
                                                                    <label for="facebookfloatingInput">facebook <span class="text-danger">*</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-6 col-md-6">
                                                                <div class="form-floating">
                                                                    <input name="instagram" value="{{ $info?->instagram }}" type="text" class="form-control" id="instagramfloatingInput" placeholder="instagram">
                                                                    <label for="instagramfloatingInput">instagram <span class="text-danger">*</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-6 col-md-6">
                                                                <div class="form-floating">
                                                                    <input name="twitter" value="{{ $info?->twitter }}" type="text" class="form-control" id="twitterfloatingInput" placeholder="twitter">
                                                                    <label for="twitterfloatingInput">twitter <span class="text-danger">*</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-6 col-md-6">
                                                                <div class="form-floating">
                                                                    <input name="snapchat" value="{{ $info?->snapchat }}" type="text" class="form-control" id="snapchatfloatingInput" placeholder="snapchat">
                                                                    <label for="snapchatfloatingInput">snapchat <span class="text-danger">*</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-6 col-md-6">
                                                                <div class="form-floating">
                                                                    <input name="tiktok" value="{{ $info?->tiktok }}" type="text" class="form-control" id="tiktokfloatingInput" placeholder="tiktok">
                                                                    <label for="tiktokfloatingInput">tiktok <span class="text-danger">*</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-6 col-md-6">
                                                                <div class="form-floating">
                                                                    <input name="vat" value="{{ $info?->vat }}" type="text" class="form-control" id="vatfloatingInput" placeholder="vat">
                                                                    <label for="vatfloatingInput">vat <span class="text-danger">*</span></label>
                                                                </div>
                                                            </div>
                                                            {{-- <div class="col-xxl-12 col-md-12">
                                                                <div class="form-group">
                                                                    <label style="margin-bottom: 0px;" for="">نبذة تعريفية <span class="text-danger">*</span></label><br/>
                                                                    <textarea class="form-control" name="desc" aria-label="With textarea" rows="3">{{ $info?->desc ?? '' }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-12 col-md-12">
                                                                <div class="form-group">
                                                                    <label style="margin-bottom: 0px;" for="">الرسالة <span class="text-danger">*</span></label><br/>
                                                                    <textarea class="form-control" name="message" aria-label="With textarea" rows="3">{{ $info?->message ?? '' }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-12 col-md-12">
                                                                <div class="form-group">
                                                                    <label style="margin-bottom: 0px;" for="">الرؤية <span class="text-danger">*</span></label><br/>
                                                                    <textarea class="form-control" name="vision" aria-label="With textarea" rows="3">{{ $info?->vision ?? '' }}</textarea>
                                                                </div>
                                                            </div> --}}
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="abouts" role="tabpanel">
                                                        <div class="row gy-4">
                                                            <div class="col-xxl-6 col-md-6">
                                                                <button class="btn btn-primary mb-3" id="add-input-info-abouts" type="button"><i class="bx bx-plus"></i> About Us</button>
                                                            </div>
                                                            <div id="info-abouts-area">
                                                                @isset($abouts)
                                                                    @foreach ($abouts as $index => $record)
                                                                        {{-- @dd($record)
                                                                        @dd($record,$record['head']) --}}
                                                                        <div class="input-container input-container-{{ $index }} mb-3">
                                                                            <div class="row">
                                                                                <div class="col-xxl-4 col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label style="margin-bottom: 0px;" for="">العنوان <span class="text-danger">*</span></label><br/>
                                                                                        <input name="abouts[{{ $index }}][head]" value="{{ $record['head'] }}" type="text" class="form-control" id="namefloatingInput" placeholder="info about">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xxl-4 col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label style="margin-bottom: 0px;" for="">المحتوي <span class="text-danger">*</span></label><br/>
                                                                                        <input name="abouts[{{ $index }}][body]" value="{{ $record['body'] }}" type="text" class="form-control" id="namefloatingInput" placeholder="info about">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xxl-2 col-md-2">
                                                                                    <label for="" class="mb-2"></label>
                                                                                    <span class="remove-btn badge bg-danger rounded-pill mt-4" parent-class="input-container-{{ $index }}"><i class="bx bx-trash"></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endisset
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="privacyPolicy" role="tabpanel">
                                                        <div class="row gy-4">
                                                            <div class="col-xxl-6 col-md-6">
                                                                <button class="btn btn-primary mb-3" id="add-input-info-privacy-policy" type="button"><i class="bx bx-plus"></i> Privacy Policy</button>
                                                            </div>
                                                            <div id="info-privacy-policy-area">
                                                                @isset($privacyPolicies)
                                                                    @foreach ($privacyPolicies as $index => $record)
                                                                        @php
                                                                            $index += 10000;
                                                                        @endphp
                                                                        <div class="input-container input-container-{{ $index }} mb-3">
                                                                            <div class="row">
                                                                                <div class="col-xxl-4 col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label style="margin-bottom: 0px;" for="">العنوان <span class="text-danger">*</span></label><br/>
                                                                                        <input name="privacy_policies[{{ $index }}][head]" value="{{ $record['head'] }}" type="text" class="form-control" id="namefloatingInput" placeholder="info privacy policy">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xxl-4 col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label style="margin-bottom: 0px;" for="">المحتوي <span class="text-danger">*</span></label><br/>
                                                                                        <input name="privacy_policies[{{ $index }}][body]" value="{{ $record['body'] }}" type="text" class="form-control" id="namefloatingInput" placeholder="info privacy policy">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xxl-2 col-md-2">
                                                                                    <label for="" class="mb-2"></label>
                                                                                    <span class="remove-btn badge bg-danger rounded-pill mt-4" parent-class="input-container-{{ $index }}"><i class="bx bx-trash"></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endisset
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="terms" role="tabpanel">
                                                        <div class="row gy-4">
                                                            <div class="col-xxl-6 col-md-6">
                                                                <button class="btn btn-primary mb-3" id="add-input-info-terms" type="button"><i class="bx bx-plus"></i> Terms</button>
                                                            </div>
                                                            <div id="info-terms-area">
                                                                @isset($terms)
                                                                    @foreach ($terms as $index => $record)
                                                                        @php
                                                                            $index += 100000;
                                                                        @endphp
                                                                        <div class="input-container input-container-{{ $index }} mb-3">
                                                                            <div class="row">
                                                                                <div class="col-xxl-4 col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label style="margin-bottom: 0px;" for="">العنوان <span class="text-danger">*</span></label><br/>
                                                                                        <input name="terms[{{ $index }}][head]" value="{{ $record['head'] }}" type="text" class="form-control" id="namefloatingInput" placeholder="info terms">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xxl-4 col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label style="margin-bottom: 0px;" for="">المحتوي <span class="text-danger">*</span></label><br/>
                                                                                        <input name="terms[{{ $index }}][body]" value="{{ $record['body'] }}" type="text" class="form-control" id="namefloatingInput" placeholder="info terms">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xxl-2 col-md-2">
                                                                                    <label for="" class="mb-2"></label>
                                                                                    <span class="remove-btn badge bg-danger rounded-pill mt-4" parent-class="input-container-{{ $index }}"><i class="bx bx-trash"></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endisset
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12" style="direction: ltr;">
                                                <button class="btn btn-primary btn-md" style="margin-left: 22px; margin-bottom: 22px;" type="submit">تاكيد</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
            $('.sidebarinfo').addClass('active');
            var target = $('.sidebarinfo').attr('href');
            $(target).addClass('show');
        })();
        $(document).on('click', '.openDeleteFrom', function() {
            var id = $(this).attr('data-id');
            $('#delete_record_id').val(id);
        });
        $(document).on('click', '.openActivationFrom', function() {
            var id = $(this).attr('data-id');
            $('#activation_record_id').val(id);
        });
        let inputCountInfoAbouts = 10000000;
        $('#add-input-info-abouts').click(function () {

            inputCountInfoAbouts++;
            $('#info-abouts-area').append(`
                <div class="input-container input-container-${inputCountInfoAbouts} mb-3">
                    <div class="row">
                        <div class="col-xxl-4 col-md-4">
                            <div class="form-group">
                                <label style="margin-bottom: 0px;" for="">العنوان <span class="text-danger">*</span></label><br/>
                                <input name="abouts[${inputCountInfoAbouts}][head]" type="text" class="form-control" id="namefloatingInput" placeholder="info abouts">
                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-4">
                            <div class="form-group">
                                <label style="margin-bottom: 0px;" for="">المحتوي <span class="text-danger">*</span></label><br/>
                                <input name="abouts[${inputCountInfoAbouts}][body]" type="text" class="form-control" id="namefloatingInput" placeholder="info abouts">
                            </div>
                        </div>
                        <div class="col-xxl-2 col-md-2">
                            <label for="" class="mb-2"></label>
                            <span class="remove-btn badge bg-danger rounded-pill mt-4" parent-class="input-container-${inputCountInfoAbouts}"><i class="bx bx-trash"></i></span>
                        </div>
                    </div>
                </div>
            `);
        });
        let inputCountInfoPrivacyPolicy = 100000000;
        $('#add-input-info-privacy-policy').click(function () {

            inputCountInfoPrivacyPolicy++;
            $('#info-privacy-policy-area').append(`
                <div class="input-container input-container-${inputCountInfoPrivacyPolicy} mb-3">
                    <div class="row">
                        <div class="col-xxl-4 col-md-4">
                            <div class="form-group">
                                <label style="margin-bottom: 0px;" for="">العنوان <span class="text-danger">*</span></label><br/>
                                <input name="privacy_policies[${inputCountInfoPrivacyPolicy}][head]" type="text" class="form-control" id="namefloatingInput" placeholder="info privacy policy">
                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-4">
                            <div class="form-group">
                                <label style="margin-bottom: 0px;" for="">المحتوي <span class="text-danger">*</span></label><br/>
                                <input name="privacy_policies[${inputCountInfoPrivacyPolicy}][body]" type="text" class="form-control" id="namefloatingInput" placeholder="info privacy policy">
                            </div>
                        </div>
                        <div class="col-xxl-2 col-md-2">
                            <label for="" class="mb-2"></label>
                            <span class="remove-btn badge bg-danger rounded-pill mt-4" parent-class="input-container-${inputCountInfoPrivacyPolicy}"><i class="bx bx-trash"></i></span>
                        </div>
                    </div>
                </div>
            `);
        });
        let inputCountInfoTerms = 1000000000;
        $('#add-input-info-terms').click(function () {

            inputCountInfoTerms++;
            $('#info-terms-area').append(`
                <div class="input-container input-container-${inputCountInfoTerms} mb-3">
                    <div class="row">
                        <div class="col-xxl-4 col-md-4">
                            <div class="form-group">
                                <label style="margin-bottom: 0px;" for="">العنوان <span class="text-danger">*</span></label><br/>
                                <input name="terms[${inputCountInfoTerms}][head]" type="text" class="form-control" id="namefloatingInput" placeholder="info terms">
                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-4">
                            <div class="form-group">
                                <label style="margin-bottom: 0px;" for="">المحتوي <span class="text-danger">*</span></label><br/>
                                <input name="terms[${inputCountInfoTerms}][body]" type="text" class="form-control" id="namefloatingInput" placeholder="info terms">
                            </div>
                        </div>
                        <div class="col-xxl-2 col-md-2">
                            <label for="" class="mb-2"></label>
                            <span class="remove-btn badge bg-danger rounded-pill mt-4" parent-class="input-container-${inputCountInfoTerms}"><i class="bx bx-trash"></i></span>
                        </div>
                    </div>
                </div>
            `);
        });
        $(document).on('click', '.remove-btn', function () {
            var parentClass = $(this).attr('parent-class');
            $('.'+parentClass).remove();
        });
    </script>
    <script>
        var q = '';
        var offset = length = limit = `{{ PAGINATION_COUNT }}`;
        var _token = $('input[name="_token"]').val();
        let showItems = document.getElementById("showItems");
        var tableShowData = document.getElementById("tableShowData");
        showItems.innerHTML = limit;

        $(document).on('click', '#load_more_button', function() {
            var urlPath = `{{ route("admin/info/pagination")}}/${offset}/${limit}`;
            event.preventDefault();
            $('#load_more_button').html('<b>Loading... </b>');
            search_in_data(q, urlPath, 1);
        });

        $(document).on('keyup', '.data_search', function() {
            q = $(this).val();
            var urlPath = "{{ route('admin/info/search') }}";
            event.preventDefault();
            search_in_data(q, urlPath, 2);
        });

        // $(document).on('change', '.data_search', function() {
        //     q = $(this).val();
        //     var record = $(this).attr('name');
        //     var urlPath = "{{ route('admin/info/search/byColumn') }}";
        //     event.preventDefault();
        //     search_in_data(q, urlPath, 2, record);
        // });

        function search_in_data(q, urlPath, action_type, record = '') {
            let records = ``;
            $.ajax({
                url: urlPath,
                method: "POST",
                data: {
                    q: q,
                    record: record,
                    _token: _token
                },
                success: function(data) {
                    if (data.length > 0) {
                        records = table_records(data, action_type);
                    } else if (data.length === 0) {
                        if (action_type == 2) {
                            length = data.length;
                            showItems.innerHTML = Number(length);
                            tableShowData.style.display = 'none';
                        }
                        $('#load_more_button').remove();
                        let btnNoData = `<button type="button" name="load_more_button" style="width: 350px;" class="btn btn-primary form-control px-5" id="load_more_button_remove">No Data</button>`;
                        document.getElementById("load_more").innerHTML = btnNoData;
                    }
                }
            })
        }

        // action type => 1 from pagination , 2 from search
        function table_records(data, action_type)
        {
            let records = ``;
            q == '' && action_type == 2 ? offset = `{{ PAGINATION_COUNT }}` : '';
            for (let i = 0; i < data.length; i++) {

                image_path =  "{{ asset('') }}" + data[i].img;
                edit_route =  "{{ route('admin/info/edit') }}" + '/' + data[i].id;
                records += `
                    <tr class="text-center">
                        <td class="text-center">${data[i].id}</td>
                        <td class="text-center">${data[i].name}</td>
                        <!-- <td class="text-center">
                            <img src="${image_path}" alt="record image" class="img-fluid img-40 rounded-circle blur-up lazyloaded" width="100">
                        </td> -->
                        <td class="text-center">${data[i].is_activate == 1 ? '<span class="badge bg-info-subtle text-info">active</span>' : '<span class="badge bg-info-subtle text-danger">un active</span>'}</td>
                        <td class="text-center">
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-fill align-middle"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" style="text-align: end;">
                                    <li>
                                        <a href="${edit_route}" class="dropdown-item edit-item-btn">
                                            <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> edit
                                        </a>
                                    </li>
                                    <li>
                                        <button class="dropdown-item edit-item-btn openActivationFrom" data-bs-toggle="modal" data-bs-target="#myModalActivation" data-id="${data[i].id}">
                                            <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> activation
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item remove-item-btn openDeleteFrom" data-bs-toggle="modal" data-bs-target="#myModalDelete" data-id="${data[i].id}">
                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                `
            }
            $('#load_more_button').remove();
            $('#load_more_button_remove').remove();
            if (action_type == 1) {
                tableShowData.innerHTML += records;
                offset += data.length;
                length += data.length;
                showItems.innerHTML = Number(length);
                let btnData = `<button type="button" name="load_more_button" style="width: 350px;" class="btn btn-info form-control px-5"id="load_more_button">Load More</button>`;
                document.getElementById("load_more").innerHTML = btnData;
            }else if (action_type == 2) {
                tableShowData.style.display = null;
                tableShowData.innerHTML = records;
                length = data.length;
                showItems.innerHTML = Number(length);
                if (data[0].searchButton == 1) {
                    let btnData = `<button type="button" name="load_more_button" style="width: 350px;" class="btn btn-info form-control px-5"id="load_more_button">Load More</button>`;
                    document.getElementById("load_more").innerHTML = btnData;
                }
            }
        }
    </script>
@endsection
