@extends('layouts.admin.home')

@section('title')
    <title>{{ __('admin.pages.products.title') }}</title>
@endsection

@section('css')
    <style>
        .admin-activation-toggle {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 8px 12px;
            border-radius: 999px;
            background: #f8fbff;
            border: 1px solid #dbe7f3;
        }

        .admin-activation-toggle__text {
            min-width: 64px;
            font-weight: 800;
            font-size: 0.9rem;
            text-align: center;
            padding: 6px 12px;
            border-radius: 999px;
        }

        .admin-activation-toggle__text.is-active {
            background: #dcfce7;
            color: #15803d;
        }

        .admin-activation-toggle__text.is-inactive {
            background: #fee2e2;
            color: #b91c1c;
        }

        .admin-activation-toggle .form-check.form-switch {
            margin: 0;
            padding: 0;
            min-height: auto;
            display: flex;
            align-items: center;
        }

        .admin-activation-toggle .form-check-input {
            width: 3rem;
            height: 1.5rem;
            margin: 0;
            cursor: pointer;
            border-color: #b8cbe0;
            background-color: #d9e6f3;
            box-shadow: none;
        }

        .admin-activation-toggle .form-check-input:checked {
            background-color: #16a34a;
            border-color: #16a34a;
        }
    </style>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-admin.page-header
                :badge="__('admin.pages.products.module_label')"
                :title="__('admin.pages.products.title')"
                :description="__('admin.pages.products.description')"
                :breadcrumbs="[
                    ['label' => __('admin.pages.common.home'), 'href' => route('admin/index')],
                    ['label' => __('admin.nav.products'), 'href' => route('admin/products/index') . '/0/' . PAGINATION_COUNT],
                    ['label' => __('admin.pages.common.index'), 'active' => true],
                ]"
            >
                <x-slot:actions>
                    <a href="{{ route('admin/products/archives') . '/0/' . PAGINATION_COUNT }}" class="btn btn-light">
                        <i class="ri-archive-line align-bottom"></i>
                        <span>{{ __('admin.pages.common.archives') }}</span>
                    </a>
                    <a href="{{ route('admin/products/create') }}" class="btn btn-primary">
                        <i class="ri-add-line align-bottom"></i>
                        <span>{{ __('admin.pages.products.add_product') }}</span>
                    </a>
                </x-slot:actions>
            </x-admin.page-header>

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

            <div class="card admin-content-card">
                <div class="card-header">
                    <div class="admin-card-head">
                        <div class="admin-card-head__copy">
                            <span class="admin-card-head__eyebrow">{{ __('admin.pages.products.module_label') }}</span>
                            <h5 class="admin-card-head__title">{{ __('admin.pages.products.overview') }}</h5>
                            <p class="admin-card-head__text">{{ __('admin.pages.products.overview_subtitle') }}</p>
                        </div>
                        <div class="admin-card-head__actions"></div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="scroll-horizontal" class="table nowrap align-middle dataTable no-footer" style="width: 100%" aria-describedby="scroll-horizontal_info">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ __('admin.pages.common.id') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.name') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.image') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.category') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.origin') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.price') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.stock_quantity') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.activation') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody id="tableShowData">
                                @isset($products)
                                    @foreach($products as $record)
                                        @php
                                            $activationClass = $record->is_activate == 1 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger';
                                            $activationLabel = $record->is_activate == 1 ? __('admin.pages.common.active') : __('admin.pages.common.inactive');
                                            $activationTone = $record->is_activate == 1 ? 'is-active' : 'is-inactive';
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
                                            <td>
                                                <form action="{{ url(route('admin/products/activate')) }}" method="post" class="d-inline-block">
                                                    @csrf
                                                    <input type="hidden" name="record_id" value="{{ $record->id }}">
                                                    <div class="admin-activation-toggle">
                                                        <span class="admin-activation-toggle__text {{ $activationTone }}">{{ $activationLabel }}</span>
                                                        <div class="form-check form-switch">
                                                            <input
                                                                class="form-check-input"
                                                                type="checkbox"
                                                                role="switch"
                                                                aria-label="Toggle product activation"
                                                                {{ (int) $record->is_activate === 1 ? 'checked' : '' }}
                                                                onchange="this.form.submit()">
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                            <td>
                                                <div class="d-inline-flex align-items-center gap-2">
                                                    <a href="{{ route('admin/products/edit', $record->id) }}" class="btn btn-light btn-sm" title="{{ __('admin.pages.common.edit') }}">
                                                        <i class="ri-pencil-line align-middle"></i>
                                                    </a>
                                                </div>
                                                <div class="dropdown d-inline-block ms-1">
                                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-fill align-middle"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" style="text-align: end;">
                                                        <li>
                                                            <a href="{{ route('admin/products/edit', $record->id) }}" class="dropdown-item edit-item-btn">
                                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> {{ __('admin.pages.common.edit') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item remove-item-btn openDeleteFrom" data-bs-toggle="modal" data-bs-target="#myModalDelete" data-id="{{ $record->id }}">
                                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> {{ __('admin.pages.common.delete') }}
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
                                            <h4>{{ __('admin.pages.common.confirm_delete') }}</h4>
                                            <p class="text-muted">{{ __('admin.pages.common.confirm_delete_message') }}</p>
                                            <input id="delete_record_id" name="record_id" type="hidden">
                                            <button type="submit" class="btn btn-warning">
                                                {{ __('admin.pages.common.continue') }}
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
        $(document).on('click', '.openDeleteFrom', function() {
            var id = $(this).attr('data-id');
            $('#delete_record_id').val(id);
        });
    </script>
@endsection
