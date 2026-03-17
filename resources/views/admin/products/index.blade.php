@extends('layouts.admin.home')

@section('title')
    <title>{{ __('admin.pages.products.title') }}</title>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <span class="badge bg-primary-subtle text-primary mb-3">{{ __('admin.pages.products.module_label') }}</span>
                    <h3 class="mb-2">{{ __('admin.pages.products.title') }}</h3>
                    <p class="text-muted mb-0">{{ __('admin.pages.products.description') }}</p>
                </div>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin/index') }}">{{ __('admin.pages.common.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin/products/index') }}/0/{{ PAGINATION_COUNT }}">{{ __('admin.nav.products') }}</a></li>
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
                            <h5 class="card-title mb-1">{{ __('admin.pages.products.overview') }}</h5>
                            <p class="text-muted mb-0">{{ __('admin.pages.products.overview_subtitle') }}</p>
                        </div>
                        <a href="{{ route('admin/products/create') }}" class="btn btn-primary btn-sm">
                            <i class="ri-add-line align-bottom me-1"></i> {{ __('admin.pages.products.add_product') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="scroll-horizontal" class="table nowrap align-middle dataTable no-footer" style="width: 100%" aria-describedby="scroll-horizontal_info">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Img</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Origin</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Stock Quantity</th>
                                    <th class="text-center">Activation</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="tableShowData">
                                @isset($products)
                                    @foreach($products as $record)
                                        @php
                                            $activationClass = $record->is_activate == 1 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger';
                                            $activationLabel = $record->is_activate == 1 ? 'Active' : 'Inactive';
                                            $stockClass = (int) $record->stock_quantity > 10 ? 'bg-success-subtle text-success' : ((int) $record->stock_quantity > 0 ? 'bg-warning-subtle text-warning' : 'bg-danger-subtle text-danger');
                                        @endphp
                                        <tr class="text-center">
                                            <td class="fw-semibold">#{{ $record->id }}</td>
                                            <td class="fw-semibold">{{ $record->name }}</td>
                                            <td>
                                                <img src="{{ asset($record->img) }}" alt="record image" class="img-fluid rounded-4" width="72" style="height:72px; object-fit:cover;">
                                            </td>
                                            <td>{{ $record->category?->name }}</td>
                                            <td>{{ $record->origin?->name }}</td>
                                            <td class="fw-semibold">{{ $record->price }}</td>
                                            <td>
                                                <span class="badge {{ $stockClass }}">{{ $record->stock_quantity }}</span>
                                            </td>
                                            <td><span class="badge {{ $activationClass }}">{{ $activationLabel }}</span></td>
                                            <td>
                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-fill align-middle"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" style="text-align: end;">
                                                        <li>
                                                            <a href="{{ route('admin/products/edit', $record->id) }}" class="dropdown-item edit-item-btn">
                                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item edit-item-btn openActivationFrom" data-bs-toggle="modal" data-bs-target="#myModalActivation" data-id="{{ $record->id }}">
                                                                <i class="ri-loop-left-line align-bottom me-2 text-muted"></i> Toggle Activation
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item remove-item-btn openDeleteFrom" data-bs-toggle="modal" data-bs-target="#myModalDelete" data-id="{{ $record->id }}">
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
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <nav aria-label="Page navigation">
                            <ul class="pagination flex-wrap justify-content-center align-items-center">
                                @if (!$products->onFirstPage())
                                    <li class="page-item mt-1">
                                        <a class="page-link" href="{{ $products->previousPageUrl() }}" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                @endif

                                @for ($i = 1; $i <= $products->lastPage(); $i++)
                                    <li class="page-item mt-1 {{ $i == $products->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $products->url($i) }}" @if ($i == $products->currentPage()) style="font-weight:bold;" @endif>
                                            {{ $i }}
                                        </a>
                                    </li>
                                @endfor

                                @if ($products->hasMorePages())
                                    <li class="page-item mt-1">
                                        <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next">
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
                                    <form role="form" action="{{ url(route('admin/products/delete')) }}" method="post">
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
                                    <form role="form" action="{{ url(route('admin/products/activate')) }}" method="post">
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
            $('.sidebarproducts').addClass('active');
            var target = $('.sidebarproducts').attr('href');
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
