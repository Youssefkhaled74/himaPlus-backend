@extends('layouts.admin.home')

<!-- title page -->
@section('title')
    <title>{{ __('admin.pages.countries.title') }}</title>
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
                                <li class="breadcrumb-item"><a href="{{route('admin/countries/index')}}/0/{{PAGINATION_COUNT}}">{{ __('admin.nav.countries') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('admin.pages.common.archive') }}</li>
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
                            <h5 class="card-title mb-0">{{ __('admin.pages.countries.archives') }}</h5>
                        </div>
                        <div class="card-body">
                            <div id="scroll-horizontal_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div id="scroll-horizontal_filter" class="dataTables_filter">
                                            <label>
                                                <input type="search" class="form-control form-control-sm data_search" placeholder="{{ __('crud.search_placeholder', ['entity' => __('crud.countries')]) }}" aria-controls="scroll-horizontal" />
                                            </label>
                                            <!-- <label>
                                                <div class="form-group">
                                                    <select class="form-control data_search" name="job_id" id="jobs" aria-controls="dataTables-example" style="width: 220px">
                                                        <option value="">Select</option>
                                                    </select>
                                                </div>
                                            </label> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="dataTables_scroll">
                                            <div class="dataTables_scrollBody" style="position: relative; overflow: auto; width: 100%">
                                                <table id="scroll-horizontal" class="table nowrap align-middle dataTable no-footer" style="width: 100%" aria-describedby="scroll-horizontal_info">
                                                    <thead>
                                                        <tr>
                                                             <th class="text-center">{{ __('crud.id') }}</th>
                                                             <th class="text-center">{{ __('crud.name') }}</th>
                                                             <th class="text-center">{{ __('admin.pages.common.activation') }}</th>
                                                             <th class="text-center">{{ __('crud.actions') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tableShowData">
                                                        @isset($countries)
                                                            @foreach($countries as $record)
                                                                <!-- $country -->
                                                                <tr class="text-center">
                                                                    <td class="text-center">{{$record->id}}</td>
                                                                    <td class="text-center">{{$record->name}}</td>
                                                                    <!-- <td class="text-center">
                                                                        <img src="{{asset($record->img)}}" alt="record image" class="img-fluid img-40 rounded-circle blur-up lazyloaded" width="100">
                                                                    </td> -->
                                                                    <?php
                                                                        if($record->is_activate == 1){$activate = '<span class="badge bg-info-subtle text-info">' . __('admin.pages.common.active') . '</span>';}
                                                                        else{$activate = '<span class="badge bg-info-subtle text-danger">' . __('admin.pages.common.inactive') . '</span>';}
                                                                    ?>
                                                                    <td class="text-center">{!! $activate !!}</td>
                                                                    <td class="text-center">
                                                                        <div class="dropdown d-inline-block">
                                                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                <i class="ri-more-fill align-middle"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu dropdown-menu-end" style="text-align: end;">
                                                                                <li>
                                                                                    <button class="dropdown-item edit-item-btn openBackFrom" data-bs-toggle="modal" data-bs-target="#myModalBack" data-id="{{$record->id}}">
                                                                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> {{ __('buttons.back') }}
                                                                                    </button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endisset
                                                    </tbody>
                                                </table>

                                                <div style="margin-top: 20px; font-weight: 600; font-size: 16px;">
                                                    {{ __('admin.pages.common.showing_entries', ['from' => 1, 'to' => App\Models\Country::archive()->count(), 'total' => App\Models\Country::archive()->count()]) }}
                                                </div>
                                                <div class="ltn__pagination-area text-center mt-5">
                                                
                                                    <div class="ltn__pagination text-center">
                                                        <div id="load_more">
                                                            <button type="button" name="load_more_button" style="width: 350px;" class="btn btn-info form-control px-5" data-id="'.$last_id.'" id="load_more_button">{{ __('admin.pages.common.load_more') }}</button>
                                                        </div>
                                                    </div>
                                
                                                    {{-- pagination are --}}
                                                    {{-- <div class="d-flex justify-content-center mt-2">
                                                        <div class="d-flex justify-content-center mt-2">
                                                            <nav aria-label="Page navigation">
                                                                <ul class="pagination flex-wrap justify-content-center" style="align-items: center;">
                                                                    <!-- Previous Button -->
                                                                    @if (!$countries->onFirstPage())
                                                                        <li class="page-item mt-1">
                                                                            <a class="page-link" href="{{ $countries->previousPageUrl() }}"
                                                                            aria-label="Previous">
                                                                                <span aria-hidden="true">&laquo;</span>
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                    
                                                                    <!-- Pagination Numbers -->
                                                                    @for ($i = 1; $i <= $countries->lastPage(); $i++)
                                                                        <li class="page-item mt-1 {{ $i == $countries->currentPage() ? 'active' : '' }}">
                                                                            <a class="page-link" href="{{ $countries->url($i) }}"
                                                                            @if ($i == $countries->currentPage()) style="font-weight:bold;" @endif>
                                                                                {{ $i }}
                                                                            </a>
                                                                        </li>
                                                                    @endfor
                                                    
                                                                    <!-- Next Button -->
                                                                    @if ($countries->hasMorePages())
                                                                        <li class="page-item mt-1">
                                                                            <a class="page-link" href="{{ $countries->nextPageUrl() }}" aria-label="Next">
                                                                                <span aria-hidden="true">&raquo;</span>
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                                </ul>
                                                            </nav>
                                                        </div>
                                                    </div> --}}

                                                </div>
                                                <div class="modal fade" id="myModalBack" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabell" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title f-w-600" id="exampleModalLabell"></h5>
                                                            </div>
                                                            <div class="modal-body text-center p-5">
                                                                <form role="form" action="{{ route('admin/countries/back') }}" method="post">
                                                          
                                                                    {{ csrf_field() }}
                                                                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json"  trigger="loop" colors="primary:#f7b84b,secondary:#405189" style="width:130px;height:130px"></lord-icon>
                                                                    <div class="mt-4 pt-4">
                                                                        <h4>{{ __('admin.pages.common.back_confirmation') }}</h4>
                                                                        <p class="text-muted">{{ __('admin.pages.common.back_confirm_message') }}</p>
                                                                        <input id="back_record_id" name="record_id" type="hidden">
                                                                        <button type="submit" class="btn btn-warning">
                                                                            {{ __('buttons.continue') }}
                                                                        </button>
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
            $('.sidebarcountries').addClass('active');
            var target = $('.sidebarcountries').attr('href');
            $(target).addClass('show');
        })();
        $(document).on('click', '.openBackFrom', function() {
            var id = $(this).attr('data-id');
            $('#back_record_id').val(id);
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
            var urlPath = `{{ route("admin/countries/pagination/archives")}}/${offset}/${limit}`;
            event.preventDefault();
            $('#load_more_button').html('<b>{{ __("admin.pages.common.loading") }} </b>');
            search_in_data(q, urlPath, 1);
        });

        $(document).on('keyup', '.data_search', function() {
            var q = $(this).val();
            var urlPath = "{{ route('admin/countries/search/archives') }}";
            event.preventDefault();
            search_in_data(q, urlPath, 2)
        });

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
                        let btnNoData = `<button type="button" name="load_more_button" style="width: 350px;" class="btn btn-primary form-control px-5" id="load_more_button_remove">{{ __("admin.pages.common.no_data") }}</button>`;
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

                image_path = "{{ asset('') }}" + data[i].img;
                records += `
                    <tr class="text-center">
                        <td class="text-center">${data[i].id}</td>
                        <td class="text-center">${data[i].name}</td>
                        <!-- <td class="text-center">
                            <img src="${image_path}" alt="record image" class="img-fluid img-40 rounded-circle blur-up lazyloaded" width="100">
                        </td> -->
                        <td class="center">${data[i].is_activate == 1 ? '<span class="badge bg-info-subtle text-info">{{ __("admin.pages.common.active") }}</span>' : '<span class="badge bg-info-subtle text-danger">{{ __("admin.pages.common.inactive") }}</span>'}</td>
                        <td class="text-center">
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-fill align-middle"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" style="text-align: end;">
                                    <li>
                                        <button class="dropdown-item edit-item-btn openBackFrom" data-bs-toggle="modal" data-bs-target="#myModalBack" data-id="${data[i].id}">
                                            <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> {{ __("buttons.back") }}
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
                let btnData = `<button type="button" name="load_more_button" style="width: 350px;" class="btn btn-info form-control px-5"id="load_more_button">{{ __("admin.pages.common.load_more") }}</button>`;
                document.getElementById("load_more").innerHTML = btnData;
            }else if (action_type == 2) {
                tableShowData.style.display = null;
                tableShowData.innerHTML = records;
                length = data.length;
                showItems.innerHTML = Number(length);
                if (data[0].searchButton == 1) {
                    let btnData = `<button type="button" name="load_more_button" style="width: 350px;" class="btn btn-info form-control px-5"id="load_more_button">{{ __("admin.pages.common.load_more") }}</button>`;
                    document.getElementById("load_more").innerHTML = btnData;
                }
            }
        }
    </script>
@endsection

