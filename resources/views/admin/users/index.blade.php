@extends('layouts.admin.home')

<!-- title page -->
@section('title')
    <title>Users</title>
@endsection

<!-- custom css -->
@section('css')
<style>
    .chip{
  display:inline-flex; align-items:center; gap:.45rem;
  padding:.35rem .65rem; border-radius:999px;
  font-weight:600; font-size:.875rem;
  border:1px solid rgba(0,0,0,.06);
}
.chip-dot{
  width:.5rem; height:.5rem; border-radius:50%;
  display:inline-block;
}

/* تحسين شكل الجدول */
.table tbody tr:hover { background:#f8fafc; }

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
                                <li class="breadcrumb-item active"><a href="{{route('admin/users/index')}}/0/{{PAGINATION_COUNT}}">Users</a></li>
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
                            <h5 class="card-title mb-0">Users Viwes</h5>
                        </div>
                        <div class="card-body">
                            <div id="scroll-horizontal_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div id="scroll-horizontal_filter" class="dataTables_filter">
                                            {{-- <label>
                                                <input type="search" class="form-control form-control-sm data_search" placeholder="Search" aria-controls="scroll-horizontal" />
                                            </label> --}}
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
                                                            <th class="text-center">Name</th>
                                                            <th class="text-center">Img</th>
                                                            <th class="text-center">Mobile</th>
                                                            <th class="text-center">Email</th>
                                                            <th class="text-center">User Type</th>
                                                            <th class="text-center">Activation</th>
                                                            <th class="text-center">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tableShowData">
                                                        @isset($users)
                                                            @foreach($users as $record)
                                                                <!-- $user -->
                                                                <tr class="text-center">
                                                                    <td class="text-center">{{$record->id}}</td>
                                                                    <td class="text-center">{{$record->name}}</td>
                                                                    <td class="text-center">
                                                                        <img src="{{asset($record->img)}}" alt="record image" class="img-fluid img-40 rounded-circle blur-up lazyloaded" width="100">
                                                                    </td>
                                                                    <td class="text-center">{{$record->mobile}}</td>
                                                                    <td class="text-center">{{$record->email}}</td>
                                                                    {{-- <td class="text-center {{ $record->user_type == 1 ? 'table-success' : 'table-primary' }}">
                                                                        {{$record->user_type == 1 ? 'عميل' : 'مورد'}}
                                                                    </td> --}}
                                                                    <td class="text-center">
                                                                        @if($record->user_type == 1)
                                                                            <span class="badge rounded-pill bg-success-subtle text-success-emphasis px-3 py-2">عميل</span>
                                                                        @else
                                                                            <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis px-3 py-2">مورد</span>
                                                                        @endif
                                                                    </td>
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
                                                                                    <button class="dropdown-item edit-item-btn btn btn-sm btn-outline-primary show-user" data-bs-toggle="modal" data-bs-target="#userShowModal"
                                                                                        data-id="{{ $record->id }}"
                                                                                        data-name="{{ $record->name }}"
                                                                                        data-email="{{ $record->email }}"
                                                                                        data-mobile="{{ $record->mobile }}"
                                                                                        data-user-type="{{ $record->user_type }}"
                                                                                        data-tax="{{ $record->tax_number }}"
                                                                                        data-branch="{{ $record->branch }}"
                                                                                        data-cr-number="{{ $record->cr_number }}"
                                                                                        data-cr-doc="{{ $record->cr_document ? asset($record->cr_document) : '' }}"
                                                                                        data-location="{{ $record->location }}"
                                                                                        data-img="{{ $record->img ? asset($record->img) : '' }}"
                                                                                    ><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Show</button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="dropdown-item edit-item-btn openActivationFrom" data-bs-toggle="modal" data-bs-target="#myModalActivation" data-id="{{$record->id}}">
                                                                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> activation
                                                                                    </button>
                                                                                </li>
                                                                                <li>
                                                                                    <button class="dropdown-item remove-item-btn openDeleteFrom" data-bs-toggle="modal" data-bs-target="#myModalDelete" data-id="{{$record->id}}">
                                                                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
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

                                                <div class="ltn__pagination-area text-center mt-5">
                                
                                                    {{-- pagination area --}}
                                                    <div class="d-flex justify-content-center mt-2">
                                                        <div class="d-flex justify-content-center mt-2">
                                                            <nav aria-label="Page navigation">
                                                                <ul class="pagination flex-wrap justify-content-center" style="align-items: center;">
                                                                    <!-- Previous Button -->
                                                                    @if (!$users->onFirstPage())
                                                                        <li class="page-item mt-1">
                                                                            <a class="page-link" href="{{ $users->previousPageUrl() }}"
                                                                            aria-label="Previous">
                                                                                <span aria-hidden="true">&laquo;</span>
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                    
                                                                    <!-- Pagination Numbers -->
                                                                    @for ($i = 1; $i <= $users->lastPage(); $i++)
                                                                        <li class="page-item mt-1 {{ $i == $users->currentPage() ? 'active' : '' }}">
                                                                            <a class="page-link" href="{{ $users->url($i) }}"
                                                                            @if ($i == $users->currentPage()) style="font-weight:bold;" @endif>
                                                                                {{ $i }}
                                                                            </a>
                                                                        </li>
                                                                    @endfor
                                                    
                                                                    <!-- Next Button -->
                                                                    @if ($users->hasMorePages())
                                                                        <li class="page-item mt-1">
                                                                            <a class="page-link" href="{{ $users->nextPageUrl() }}" aria-label="Next">
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
                                                                <form role="form" action="{{url(route('admin/users/delete'))}}" method="get">
                                                                                                
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
                                                                <form role="form" action="{{url(route('admin/users/activate'))}}" method="get">
                                                                                                
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
                                                <div class="modal fade" id="userShowModal" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title fw-bold">بيانات المستخدم</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                                                            </div>
                                                            <div class="modal-body" dir="ltr">
                                                                <div class="row g-4 align-items-center">
                                                                    <div class="col-md-3 text-center">
                                                                        <img id="uAvatar" class="rounded-circle shadow-sm d-none" style="width:96px;height:96px;object-fit:cover" src="" alt="">
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <div class="text-muted small mt-1">ID: <span id="uId">—</span></div>
                                                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                                                            <h4 class="m-0" id="uName">—</h4>
                                                                            <span id="uTypeBadge" class="badge rounded-pill px-3 py-2"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr class="my-4">
                                                                <div class="row g-3">
                                                                    <div class="col-md-6">
                                                                        <ul class="list-group small shadow-sm rounded-3" style="padding: 0;">
                                                                            <li class="list-group-item d-flex justify-content-between">
                                                                                <span class="text-muted">Email</span><span id="uEmail" class="fw-semibold">—</span>
                                                                            </li>
                                                                            <li class="list-group-item d-flex justify-content-between">
                                                                                <span class="text-muted">Mobile</span><span id="uMobile" class="fw-semibold">—</span>
                                                                            </li>
                                                                            <li class="list-group-item d-flex justify-content-between">
                                                                                <span class="text-muted">Branch</span><span id="uBranch" class="fw-semibold">—</span>
                                                                            </li>
                                                                            <li class="list-group-item d-flex justify-content-between">
                                                                                <span class="text-muted">Location</span><span id="uLocation" class="fw-semibold">—</span>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <ul class="list-group small shadow-sm rounded-3" style="padding: 0;">
                                                                            <li class="list-group-item d-flex justify-content-between">
                                                                                <span class="text-muted">Tax Number</span><span id="uTax" class="fw-semibold">—</span>
                                                                            </li>
                                                                            <li class="list-group-item d-flex justify-content-between">
                                                                                <span class="text-muted">CR Number</span><span id="uCrNumber" class="fw-semibold">—</span>
                                                                            </li>
                                                                            <li class="list-group-item d-flex justify-content-between">
                                                                                <span class="text-muted">CR Document</span>
                                                                                <a id="uCrDocLink" href="#" target="_blank" class="fw-semibold text-decoration-none">فتح الملف</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-light" data-bs-dismiss="modal">إغلاق</button>
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
            $('.sidebarusers').addClass('active');
            var target = $('.sidebarusers').attr('href');
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
        
        $('#userShowModal').on('show.bs.modal', function (e) {
            var $m   = $(this);
            var $btn = $(e.relatedTarget);

            var id       = $btn.data('id') || '—';
            var name     = $btn.data('name') || '—';
            var email    = $btn.data('email') || '—';
            var mobile   = $btn.data('mobile') || '—';
            var type     = String($btn.data('user-type') || '');
            var tax      = $btn.data('tax') || '—';
            var branch   = $btn.data('branch') || '—';
            var crNum    = $btn.data('cr-number') || '—';
            var crDoc    = $btn.data('cr-doc') || '';
            var location = $btn.data('location') || '—';
            var img      = $btn.data('img') || '';

            $m.find('#uId').text(id);
            $m.find('#uName').text(name);
            $m.find('#uEmail').text(email);
            $m.find('#uMobile').text(mobile);
            $m.find('#uBranch').text(branch);
            $m.find('#uLocation').text(location);
            $m.find('#uTax').text(tax);
            $m.find('#uCrNumber').text(crNum);

            var $avatar = $m.find('#uAvatar');
            if (img) { $avatar.attr('src', img).removeClass('d-none'); }
            else { $avatar.attr('src', '').addClass('d-none'); }

            var $badge = $m.find('#uTypeBadge').removeClass().addClass('badge rounded-pill px-3 py-2');
            if (type === '1') {
                $badge.addClass('bg-success-subtle text-success-emphasis').text('عميل');
            } else if (type === '2') {
                $badge.addClass('bg-primary-subtle text-primary-emphasis').text('مورد');
            } else {
                $badge.addClass('bg-secondary-subtle text-secondary-emphasis').text('غير محدد');
            }

            var $crLink = $m.find('#uCrDocLink');
            if (crDoc) { $crLink.attr('href', crDoc).removeClass('disabled'); }
            else { $crLink.attr('href', '#').addClass('disabled'); }
        });

    </script>
@endsection
