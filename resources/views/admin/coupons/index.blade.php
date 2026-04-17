@extends('layouts.admin.home')

@section('title')
    <title>{{ __('admin.pages.coupons.title') }}</title>
@endsection

@section('css')
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-admin.page-header
                :badge="__('admin.pages.coupons.module_label')"
                :title="__('admin.pages.coupons.title')"
                :description="__('admin.pages.coupons.description')"
                :breadcrumbs="[
                    ['label' => __('admin.pages.common.home'), 'href' => route('admin/index')],
                    ['label' => __('admin.nav.coupons'), 'href' => route('admin/coupons/index') . '/0/' . PAGINATION_COUNT],
                    ['label' => __('admin.pages.common.index'), 'active' => true],
                ]"
            />

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
                            <span class="admin-card-head__eyebrow">{{ __('admin.pages.coupons.module_label') }}</span>
                            <h5 class="admin-card-head__title">{{ __('admin.pages.coupons.overview') }}</h5>
                            <p class="admin-card-head__text">{{ __('admin.pages.coupons.overview_subtitle') }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table nowrap align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ __('admin.pages.common.id') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.name') }}</th>
                                    <th class="text-center">{{ __('admin.pages.coupons.discount_value') }}</th>
                                    <th class="text-center">{{ __('admin.pages.coupons.coupon_type') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.status') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody id="tableShowData">
                                @isset($coupons)
                                    @foreach ($coupons as $record)
                                        <tr class="text-center">
                                            <td>{{ $record->id }}</td>
                                            <td>{{ $record->name }}</td>
                                            <td>{{ $record->amount }}</td>
                                            <td>
                                                {{ $record->type == 1 ? __('admin.pages.coupons.type_amount') : __('admin.pages.coupons.type_percentage') }}
                                            </td>
                                            <td>
                                                @if ($record->is_activate == 1)
                                                    <span class="badge bg-info-subtle text-info">{{ __('admin.pages.common.active') }}</span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger">{{ __('admin.pages.common.inactive') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-fill align-middle"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a href="{{ route('admin/coupons/edit', $record->id) }}" class="dropdown-item edit-item-btn">
                                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>{{ __('admin.pages.common.edit') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item edit-item-btn openActivationFrom" data-bs-toggle="modal" data-bs-target="#myModalActivation" data-id="{{ $record->id }}">
                                                                <i class="ri-flashlight-line align-bottom me-2 text-muted"></i>{{ __('admin.pages.common.activate') }}
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item remove-item-btn openDeleteFrom" data-bs-toggle="modal" data-bs-target="#myModalDelete" data-id="{{ $record->id }}">
                                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>{{ __('admin.pages.common.delete') }}
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
                                @if (!$coupons->onFirstPage())
                                    <li class="page-item mt-1">
                                        <a class="page-link" href="{{ $coupons->previousPageUrl() }}" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                @endif

                                @for ($i = 1; $i <= $coupons->lastPage(); $i++)
                                    <li class="page-item mt-1 {{ $i == $coupons->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $coupons->url($i) }}" @if ($i == $coupons->currentPage()) style="font-weight:bold;" @endif>
                                            {{ $i }}
                                        </a>
                                    </li>
                                @endfor

                                @if ($coupons->hasMorePages())
                                    <li class="page-item mt-1">
                                        <a class="page-link" href="{{ $coupons->nextPageUrl() }}" aria-label="Next">
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
                            <form role="form" action="{{ url(route('admin/coupons/delete')) }}" method="post">
                                @csrf
                                <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f7b84b,secondary:#405189" style="width:130px;height:130px"></lord-icon>
                                <div class="mt-4 pt-4">
                                    <h4>{{ __('admin.pages.common.confirm_delete') }}</h4>
                                    <p class="text-muted">{{ __('admin.pages.common.confirm_delete_message') }}</p>
                                    <input id="delete_record_id" name="record_id" type="hidden">
                                    <button type="submit" class="btn btn-warning">{{ __('admin.pages.common.continue') }}</button>
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
                            <form role="form" action="{{ url(route('admin/coupons/activate')) }}" method="post">
                                @csrf
                                <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f7b84b,secondary:#405189" style="width:130px;height:130px"></lord-icon>
                                <div class="mt-4 pt-4">
                                    <h4>{{ __('admin.pages.common.confirm_activate') }}</h4>
                                    <p class="text-muted">{{ __('admin.pages.common.confirm_activate_message') }}</p>
                                    <input id="activation_record_id" name="record_id" type="hidden">
                                    <button type="submit" class="btn btn-warning">{{ __('admin.pages.common.continue') }}</button>
                                </div>
                            </form>
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
            $('.sidebarcoupons').addClass('active');
            var target = $('.sidebarcoupons').attr('href');
            $(target).addClass('show');
        })();

        $(document).on('click', '.openDeleteFrom', function () {
            var id = $(this).attr('data-id');
            $('#delete_record_id').val(id);
        });

        $(document).on('click', '.openActivationFrom', function () {
            var id = $(this).attr('data-id');
            $('#activation_record_id').val(id);
        });
    </script>
@endsection
