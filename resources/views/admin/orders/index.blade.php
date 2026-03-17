@extends('layouts.admin.home')

@section('title')
    <title>{{ __('admin.pages.orders.title') }}</title>
@endsection

@section('content')
    @php
        $tab = $tab ?? request('tab', 'orders');
        $isRequestsPage = $tab === 'requests';
        $pageTitle = $isRequestsPage ? __('admin.nav.orders') : __('admin.pages.orders.title');
    @endphp

    <div class="page-content">
        <div class="container-fluid">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <span class="badge bg-primary-subtle text-primary mb-3">{{ __('admin.pages.orders.module_label') }}</span>
                    <h3 class="mb-2">{{ __('admin.pages.orders.title') }}</h3>
                    <p class="text-muted mb-0">{{ __('admin.pages.orders.description') }}</p>
                </div>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin/index') }}">{{ __('admin.pages.common.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin/orders/index') }}/0/{{ PAGINATION_COUNT }}?tab={{ $tab }}">{{ __('admin.nav.orders') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('admin.pages.common.index') }}</li>
                    </ol>
                </div>
            </div>

            @include('flash::message')
            @if ($errors->any())
                <div class="card mb-4">
                    <div class="card-body">
                        <ul class="mb-0" dir="ltr">
                            @foreach ($errors->all() as $error)
                                <li class="text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                        <div>
                            <h5 class="card-title mb-1">{{ __('admin.pages.orders.overview') }}</h5>
                            <p class="text-muted mb-0">{{ __('admin.pages.orders.overview_subtitle') }}</p>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('admin/orders/index') }}/0/{{ PAGINATION_COUNT }}?tab=orders" class="btn btn-sm {{ $isRequestsPage ? 'btn-soft-secondary' : 'btn-primary' }}">Orders</a>
                            <a href="{{ route('admin/orders/index') }}/0/{{ PAGINATION_COUNT }}?tab=requests" class="btn btn-sm {{ $isRequestsPage ? 'btn-primary' : 'btn-soft-secondary' }}">Requests</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="scroll-horizontal" class="table nowrap align-middle dataTable no-footer" style="width: 100%" aria-describedby="scroll-horizontal_info">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Order Type</th>
                                    <th class="text-center">User</th>
                                    <th class="text-center">Provider</th>
                                    <th class="text-center">Vat Amount</th>
                                    <th class="text-center">Total Cost</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="tableShowData">
                                @isset($orders)
                                    @foreach($orders as $record)
                                        @php
                                            $orderType = '---';
                                            $orderBadge = 'bg-info-subtle text-info';
                                            if ((int) $record->order_type === 1) {
                                                $orderType = 'Order';
                                                $orderBadge = 'bg-primary-subtle text-primary';
                                            } elseif ((int) $record->order_type === 2) {
                                                $orderType = 'Quotation';
                                                $orderBadge = 'bg-warning-subtle text-warning';
                                            } elseif ((int) $record->order_type === 3) {
                                                $orderType = 'Maintenance';
                                                $orderBadge = 'bg-success-subtle text-success';
                                            }
                                        @endphp
                                        <tr class="text-center">
                                            <td class="fw-semibold">#{{ $record->id }}</td>
                                            <td><span class="badge {{ $orderBadge }}">{{ $orderType }}</span></td>
                                            <td>
                                                <a href="{{ route('admin/orders/edit', $record->id) }}" class="text-reset text-decoration-none fw-semibold">
                                                    {{ $record->user?->name }}
                                                </a>
                                            </td>
                                            <td>{{ $record->provider?->name }}</td>
                                            <td>{{ $record->vat_amount }}</td>
                                            <td class="fw-semibold">{{ $record->total_cost }}</td>
                                            <td>
                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-fill align-middle"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" style="text-align: end;">
                                                        <li>
                                                            <a href="{{ route('admin/orders/edit', $record->id) }}" class="dropdown-item edit-item-btn">
                                                                <i class="ri-eye-line align-bottom me-2 text-muted"></i> Details
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endisset
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <nav aria-label="Page navigation">
                            <ul class="pagination flex-wrap justify-content-center align-items-center">
                                @if (!$orders->onFirstPage())
                                    <li class="page-item mt-1">
                                        <a class="page-link" href="{{ $orders->previousPageUrl() }}" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                @endif

                                @for ($i = 1; $i <= $orders->lastPage(); $i++)
                                    <li class="page-item mt-1 {{ $i == $orders->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $orders->url($i) }}" @if ($i == $orders->currentPage()) style="font-weight:bold;" @endif>
                                            {{ $i }}
                                        </a>
                                    </li>
                                @endfor

                                @if ($orders->hasMorePages())
                                    <li class="page-item mt-1">
                                        <a class="page-link" href="{{ $orders->nextPageUrl() }}" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>

                    <div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabell" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title f-w-600" id="exampleModalLabell"></h5>
                                </div>
                                <div class="modal-body text-center p-5">
                                    <form role="form" action="{{ url(route('admin/orders/delete')) }}" method="post">
                                        {{ csrf_field() }}
                                        <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f7b84b,secondary:#405189" style="width:130px;height:130px"></lord-icon>
                                        <div class="mt-4 pt-4">
                                            <h4>Delete Confirmation</h4>
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
                                    <form role="form" action="{{ url(route('admin/orders/activate')) }}" method="post">
                                        {{ csrf_field() }}
                                        <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f7b84b,secondary:#405189" style="width:130px;height:130px"></lord-icon>
                                        <div class="mt-4 pt-4">
                                            <h4>Activation Confirmation</h4>
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
@endsection

@section('script')
    <script>
        (function () {
            $('.nav-link.menu-link').removeClass('active');
            $('.menu-dropdown').removeClass('show');
            $('.sidebarorders').addClass('active');
            var target = $('.sidebarorders').attr('href');
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
