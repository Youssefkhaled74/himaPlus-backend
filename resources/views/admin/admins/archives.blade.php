@extends('layouts.admin.home')

<!-- title page -->
@section('title')
    <title>Admins</title>
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
                                <li class="breadcrumb-item active"><a href="{{route('admin/admins/index')}}/0/{{PAGINATION_COUNT}}">Admins</a></li>
                                <li class="active" style="color: var(--vz-breadcrumb-item-active-color);">Archive</li>
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
                            <h5 class="card-title mb-0">Admins Viwes</h5>
                        </div>
                        <div class="card-body">
                            <div id="scroll-horizontal_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div id="scroll-horizontal_filter" class="dataTables_filter">
                                            <label>
                                                <input type="search" class="form-control form-control-sm data_search" placeholder="Search" aria-controls="scroll-horizontal" />
                                            </label>
                                            <label>
                                                <div class="form-group">
                                                    <select class="form-control data_search" name="job_id" id="jobs" aria-controls="dataTables-example" style="width: 220px">
                                                        <option value="">الوظائف</option>
                                                    </select>
                                                </div>
                                            </label>
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
                                                            <th class="text-center">ID</th>
                                                            <th class="text-center">Img</th>
                                                            <th class="text-center">Name</th>
                                                            <th class="text-center">Email</th>
                                                            <th class="text-center">Phone</th>
                                                            <th class="text-center">Activation</th>
                                                            <th class="text-center">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tableShowData">
                                                        @isset($admins)
                                                            @foreach($admins as $record)
                                                                <tr class="text-center">
                                                                    <td class="text-center">{{$record->id}}</td>
                                                                    <td class="text-center">
                                                                        <img src="{{asset($record->img)}}" alt="record image" class="img-fluid img-40 rounded-circle blur-up lazyloaded" width="100">
                                                                    </td>
                                                                    <td class="text-center">{{$record->name}}</td>
                                                                    <td class="text-center">{{$record->email}}</td>
                                                                    <td class="text-center">{{$record->phone}}</td>
                                                                    <?php
                                                                        if($record->is_activate == 1){$activate = '<span class="badge bg-info-subtle text-info">active</span>';}
                                                                        else{$activate = '<span class="badge bg-info-subtle text-danger">un active</span>';}
                                                                    ?>
                                                                    <td class="center">{!! $activate !!}</td>
                                                                    <td class="text-center">
                                                                        <div class="dropdown d-inline-block">
                                                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                <i class="ri-more-fill align-middle"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu dropdown-menu-end" style="text-align: end;">
                                                                                <li>
                                                                                    <button class="dropdown-item edit-item-btn openBackFrom" data-bs-toggle="modal" data-bs-target="#myModalBack" data-id="{{$record->id}}">
                                                                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> back
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
                                                    Showing 1 to <span id="showItems"></span> of <span>{{App\Models\Admin::archive()->count()}}</span> entries
                                                </div>
                                                <div class="ltn__pagination-area text-center mt-5">
                                                    <div class="ltn__pagination text-center">
                                                        <div id="load_more">
                                                            <button type="button" name="load_more_button" style="width: 350px;" class="btn btn-info form-control px-5" data-id="'.$last_id.'" id="load_more_button">Load More</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="myModalBack" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabell" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title f-w-600" id="exampleModalLabell">Back Confirmation</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form role="form" action="{{url(route('admin/admins/back'))}}" method="get">
                                                                    {{ csrf_field() }}
                                                                    <p>Are You Sure To Update This Record ?</p>
                                                                    <input id="back_record_id" name="record_id" type="hidden">
                                                                    <div class="modal-footer">
                                                                        <button class="btn btn-primary" type="submit">Sure</button>
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
            $('.sidebaradmins').addClass('active');
            var target = $('.sidebaradmins').attr('href');
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
            var urlPath = `{{ route("admin/admins/pagination/archives")}}/${offset}/${limit}`;
            event.preventDefault();
            $('#load_more_button').html('<b>Loading... </b>');
            search_in_data(q, urlPath, 1);
        });

        $(document).on('keyup', '.data_search', function() {
            q = $(this).val();
            var urlPath = "{{ route('admin/admins/search/archives') }}";
            event.preventDefault();
            search_in_data(q, urlPath, 2)
        });

        $(document).on('change', '.data_search', function() {
            q = $(this).val();
            var record = $(this).attr('name');
            var urlPath = "{{ route('admin/admins/search/byColumn/archives') }}";
            event.preventDefault();
            search_in_data(q, urlPath, 2, record)
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
                records += `
                    <tr class="text-center">
                        <td class="text-center">${data[i].id}</td>
                        <td class="text-center">
                            <img src="${image_path}" alt="record image" class="img-fluid img-40 rounded-circle blur-up lazyloaded" width="100">
                        </td>
                        <td class="text-center">${data[i].name ?? ''}</td>
                        <td class="text-center">${data[i].email ?? ''}</td>
                        <td class="text-center">${data[i].phone ?? ''}</td>
                        <td class="center">${data[i].is_activate == 1 ? '<span class="badge bg-info-subtle text-info">active</span>' : '<span class="badge bg-info-subtle text-danger">un active</span>'}</td>
                        <td class="text-center">
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-fill align-middle"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" style="text-align: end;">
                                    <li>
                                        <button class="dropdown-item edit-item-btn openBackFrom" data-bs-toggle="modal" data-bs-target="#myModalBack" data-id="${data[i].id}">
                                            <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> back
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
