@extends('layouts.admin.home')

<!-- title page -->
@section('title')
    <title>Ratings</title>
@endsection

<!-- custom css -->
@section('css')
<link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
    .stars .star{color:#ddd;font-size:14px}
    .stars .star.filled{color:#ffc107}
</style>
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
                                <li class="breadcrumb-item active"><a href="{{route('admin/ratings/index')}}/0/{{PAGINATION_COUNT}}">Ratings</a></li>
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
                            <h5 class="card-title mb-0">Ratings Viwes</h5>
                        </div>
                        <div class="card-body">
                            <div id="scroll-horizontal_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        {{-- <div id="scroll-horizontal_filter" class="dataTables_filter">
                                            <label>
                                                <input type="search" class="form-control form-control-sm data_search" placeholder="Search" aria-controls="scroll-horizontal" />
                                            </label>
                                        </div> --}}
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
                                                            <th class="text-center">User</th>
                                                            <th class="text-center">Rating</th>
                                                            <th class="text-center">Comment</th>
                                                            <th class="text-center">For</th>
                                                            <th class="text-center">Service</th>
                                                            <th class="text-center">Activation</th>
                                                            <th class="text-center">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tableShowData">
                                                        @isset($ratings)
                                                            @foreach($ratings as $record)

                                                                @php
                                                                    $r = (float)$record->rating;
                                                                    $full = floor($r);
                                                                    $half = ($r - $full) >= 0.5 ? 1 : 0;
                                                                    $empty = 5 - $full - $half;
                                                                @endphp

                                                                <!-- $rating -->
                                                                <tr class="text-center">
                                                                    <td class="text-center">{{$record->id}}</td>
                                                                    <td class="text-center">{{$record->user?->name}}</td>
                                                                    <td class="text-center">
                                                                        <span class="text-warning">
                                                                            @for($i = 0; $i < $full; $i++) <i class="fa-solid fa-star"></i> @endfor
                                                                            @if($half) <i class="fa-regular fa-star-half-stroke"></i> @endif
                                                                            @for($i = 0; $i < $empty; $i++) <i class="fa-regular fa-star"></i> @endfor
                                                                        </span>
                                                                    </td>
                                                                    {{-- <td class="text-center">{{$record->rating}}</td> --}}
                                                                    <td class="text-center">{{$record->comment}}</td>
                                                                    <td class="text-center">
                                                                        <span class="badge bg-info-subtle @if($record->for == "Provider") text-info @else text-primary @endif">
                                                                            {{$record->for}}
                                                                        </span>
                                                                    </td>
                                                                    <td class="text-center">{{$record->forable?->name}}</td>
                                                                    <?php
                                                                        if($record->is_activate == 1){$activate = '<span class="badge bg-info-subtle text-info">active</span>';}
                                                                        else{$activate = '<span class="badge bg-info-subtle text-danger">un active</span>';}
                                                                    ?>
                                                                    <td class="text-center">{!! $activate !!}</td>
                                                                    <td class="text-center">
                                                                        <div class="dropdown d-inline-block">
                                                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                <i class="ri-more-fill align-middle"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu dropdown-menu-end" style="text-align: end;">
                                                                                <li>
                                                                                    <a href="{{route('admin/ratings/edit', $record->id)}}" class="dropdown-item edit-item-btn">
                                                                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="dropdown-item edit-item-btn openActivationFrom" data-bs-toggle="modal" data-bs-target="#myModalActivation" data-id="{{$record->id}}">
                                                                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> activation
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

                                                {{-- <div style="margin-top: 20px; font-weight: 600; font-size: 16px;">
                                                    Showing 1 to <span id="showItems"></span> of <span>{{App\Models\Rating::unArchive()->count()}}</span> entries
                                                </div> --}}
                                                <div class="ltn__pagination-area text-center mt-5">
                                                
                                                    {{-- <div class="ltn__pagination text-center">
                                                        <div id="load_more">
                                                            <button type="button" name="load_more_button" style="width: 350px;" class="btn btn-info form-control px-5" data-id="'.$last_id.'" id="load_more_button">Read more</button>
                                                        </div>
                                                    </div> --}}
                                
                                                    {{-- pagination are --}}
                                                    <div class="d-flex justify-content-center mt-2">
                                                        <div class="d-flex justify-content-center mt-2">
                                                            <nav aria-label="Page navigation">
                                                                <ul class="pagination flex-wrap justify-content-center" style="align-items: center;">
                                                                    <!-- Previous Button -->
                                                                    @if (!$ratings->onFirstPage())
                                                                        <li class="page-item mt-1">
                                                                            <a class="page-link" href="{{ $ratings->previousPageUrl() }}"
                                                                            aria-label="Previous">
                                                                                <span aria-hidden="true">&laquo;</span>
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                    
                                                                    <!-- Pagination Numbers -->
                                                                    @for ($i = 1; $i <= $ratings->lastPage(); $i++)
                                                                        <li class="page-item mt-1 {{ $i == $ratings->currentPage() ? 'active' : '' }}">
                                                                            <a class="page-link" href="{{ $ratings->url($i) }}"
                                                                            @if ($i == $ratings->currentPage()) style="font-weight:bold;" @endif>
                                                                                {{ $i }}
                                                                            </a>
                                                                        </li>
                                                                    @endfor
                                                    
                                                                    <!-- Next Button -->
                                                                    @if ($ratings->hasMorePages())
                                                                        <li class="page-item mt-1">
                                                                            <a class="page-link" href="{{ $ratings->nextPageUrl() }}" aria-label="Next">
                                                                                <span aria-hidden="true">&raquo;</span>
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                                </ul>
                                                            </nav>
                                                        </div>
                                                    </div>

                                                </div>
                                                
                                                <div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabell" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title f-w-600" id="exampleModalLabell"></h5>
                                                            </div>
                                                            <div class="modal-body text-center p-5">
                                                                <form role="form" action="{{url(route('admin/ratings/delete'))}}" method="post">
                                                                                                
                                                                    {{ csrf_field() }}
                                                                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json"  trigger="loop" colors="primary:#f7b84b,secondary:#405189" style="width:130px;height:130px"></lord-icon>
                                                                    <div class="mt-4 pt-4">
                                                                        <h4>! Delete Confirmation</h4>
                                                                        <p class="text-muted">Are You Sure To Update This Record.</p>
                                                                        <input id="delete_record_id" name="record_id" type="hidden">
                                                                        <button type="submit" class="btn btn-warning">
                                                                            Continue
                                                                        </button>
                                                                    </div>
                                                                                                
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="myModalActivation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title f-w-600" id="exampleModalLabel"></h5>
                                                            </div>
                                                            <div class="modal-body text-center p-5">
                                                                <form role="form" action="{{url(route('admin/ratings/activate'))}}" method="post">
                                                                                                
                                                                    {{ csrf_field() }}
                                                                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json"  trigger="loop" colors="primary:#f7b84b,secondary:#405189" style="width:130px;height:130px"></lord-icon>
                                                                    <div class="mt-4 pt-4">
                                                                        <h4>! Activation Confirmation</h4>
                                                                        <p class="text-muted">Are You Sure To Update This Record.</p>
                                                                        <input id="activation_record_id" name="record_id" type="hidden">
                                                                        <button type="submit" class="btn btn-warning">
                                                                            Continue
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
            $('.sidebarratings').addClass('active');
            var target = $('.sidebarratings').attr('href');
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
    </script>
@endsection
