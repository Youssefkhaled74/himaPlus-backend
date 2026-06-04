@extends('layouts.admin.home')

@section('title')
    <title>{{ __('admin.pages.coupons.title') }}</title>
@endsection

@section('css')
<style>
    .admin-filter-bar { display: flex; flex-wrap: wrap; gap: .5rem; align-items: center; }
    .admin-filter-bar .form-control,
    .admin-filter-bar .form-select { border-radius: .5rem !important; border: 1px solid #e2e5f1; }
    .admin-filter-bar .input-group { flex-wrap: nowrap; }
    .admin-filter-bar .input-group-text {
        border-radius: .5rem 0 0 .5rem !important;
        border: 1px solid #e2e5f1; border-right: 0;
    }
    html[dir='rtl'] .admin-filter-bar .input-group-text {
        border-radius: 0 .5rem .5rem 0 !important;
        border: 1px solid #e2e5f1; border-left: 0;
    }
    .admin-filter-bar .btn-filter { border-radius: .5rem !important; padding: .375rem 1rem; }
    .admin-filter-tags { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; padding: 12px 0 0; }
    .admin-filter-tag {
        display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px;
        border-radius: 999px; background: rgba(15, 75, 191, 0.10);
        color: #0f4bbf; font-size: 0.82rem; font-weight: 700;
    }
    .admin-filter-tag .btn-close-sm {
        width: 16px; height: 16px; font-size: 0.6rem; opacity: 0.6;
        cursor: pointer; background: transparent; border: 0; padding: 0;
        display: inline-flex; align-items: center; justify-content: center;
        color: #0f4bbf; text-decoration: none; line-height: 1;
    }
    .admin-filter-tag .btn-close-sm:hover { opacity: 1; }
    .admin-filter-tag.is-reset {
        background: rgba(216, 79, 79, 0.10); color: #d84f4f;
        cursor: pointer; text-decoration: none; transition: all 0.2s ease;
    }
    .admin-filter-tag.is-reset:hover { background: rgba(216, 79, 79, 0.18); }
    .admin-filter-tag .tag-icon { font-size: 0.9rem; }
    .admin-filter-count { margin-inline-start: auto; font-size: 0.8rem; color: #6b7280; white-space: nowrap; }
    .search-clear-btn {
        border: 1px solid #e2e5f1; border-left: 0; border-radius: 0 .5rem .5rem 0 !important;
        background: transparent; color: #9ca3af; cursor: pointer;
        display: flex; align-items: center; padding: 0 .6rem;
        font-size: .9rem; transition: color .15s;
    }
    .search-clear-btn:hover { color: #d84f4f; }
    html[dir='rtl'] .search-clear-btn {
        border-radius: .5rem 0 0 .5rem !important;
        border: 1px solid #e2e5f1; border-right: 0; border-left: 1px solid #e2e5f1;
    }
    .admin-pagination-wrap {
        display: flex; flex-wrap: wrap; align-items: center;
        justify-content: space-between; gap: 1rem; padding-top: 1.25rem;
    }
    .admin-pagination-info { font-size: 0.82rem; color: #6b7280; white-space: nowrap; }
    .admin-pagination { display: flex; flex-wrap: wrap; align-items: center; gap: 4px; margin: 0; padding: 0; list-style: none; }
    .admin-pagination .page-link {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 36px; height: 36px; padding: 0 .5rem;
        border-radius: 8px !important; border: 1px solid #e2e5f1;
        background: #fff; color: #4b5563; font-size: 0.82rem;
        font-weight: 600; text-decoration: none; transition: all .15s ease;
    }
    .admin-pagination .page-link:hover { background: #f3f6ff; border-color: #c4d0e3; color: #0f4bbf; }
    .admin-pagination .page-item.active .page-link {
        background: #0f4bbf; border-color: #0f4bbf; color: #fff;
        font-weight: 700; box-shadow: 0 2px 8px rgba(15, 75, 191, 0.2);
    }
    .admin-pagination .page-item.disabled .page-link { opacity: .4; pointer-events: none; }
    .admin-pagination .page-link.prev-next { font-size: 0.75rem; gap: 4px; padding: 0 .65rem; }
    .admin-pagination .page-link.ellipsis {
        border: 0; background: transparent; min-width: 24px; color: #9ca3af; pointer-events: none;
    }
    @media (max-width: 767.98px) {
        .admin-filter-bar .input-group,
        .admin-filter-bar .form-select { width: 100% !important; min-width: 0 !important; }
        .admin-filter-bar { flex-direction: column; align-items: stretch; }
        .admin-filter-count { margin-inline-start: 0; width: 100%; text-align: start; }
        .admin-pagination-wrap { flex-direction: column; align-items: center; }
    }
</style>
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
                @php $hasActiveFilters = ($search ?? '') !== ''; @endphp
                <div class="card-body" style="padding-bottom:0;">
                    <form method="GET" action="{{ route('admin/coupons/index', ['offset' => 0, 'limit' => PAGINATION_COUNT]) }}" id="couponsFilterForm">
                        <div class="admin-filter-bar">
                            <div class="input-group" style="min-width:200px;">
                                <span class="input-group-text bg-transparent"><i class="ri-search-line"></i></span>
                                <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control" placeholder="{{ __('admin.pages.common.search_in', ['label' => __('admin.nav.coupons')]) }}" id="couponsSearchInput">
                                @if(($search ?? '') !== '')
                                <button type="button" class="search-clear-btn" onclick="clearCouponsSearch()">&times;</button>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary btn-filter">
                                <i class="ri-search-2-line align-bottom"></i>
                            </button>
                            @if($hasActiveFilters)
                                <a href="{{ route('admin/coupons/index') }}/0/{{ PAGINATION_COUNT }}" class="btn btn-light btn-filter">
                                    <i class="ri-close-line align-bottom"></i>
                                </a>
                            @endif
                            <span class="admin-filter-count">
                                <i class="ri-coupon-line align-bottom me-1"></i>
                                {{ $coupons->total() }}
                            </span>
                        </div>
                        @if($hasActiveFilters)
                        <div class="admin-filter-tags">
                            @if(($search ?? '') !== '')
                            <span class="admin-filter-tag">
                                <i class="ri-search-line tag-icon"></i>
                                {{ $search }}
                                <a href="{{ route('admin/coupons/index') }}/0/{{ PAGINATION_COUNT }}" class="btn-close-sm">&times;</a>
                            </span>
                            @endif
                            <a href="{{ route('admin/coupons/index') }}/0/{{ PAGINATION_COUNT }}" class="admin-filter-tag is-reset">
                                <i class="ri-restart-line"></i> {{ __('admin.pages.common.reset') }}
                            </a>
                        </div>
                        @endif
                    </form>
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

                    <div class="admin-pagination-wrap">
                        <div class="admin-pagination-info">
                            @php $from = $coupons->firstItem(); $to = $coupons->lastItem(); $total = $coupons->total(); @endphp
                            {{ __('admin.pages.common.showing_entries', ['from' => $from, 'to' => $to, 'total' => $total]) }}
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="admin-pagination">
                                <li class="page-item {{ $coupons->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link prev-next" href="{{ $coupons->previousPageUrl() ?? '#' }}" aria-label="Previous">
                                        <i class="ri-arrow-left-s-line"></i> <span>{{ __('admin.pages.common.previous') }}</span>
                                    </a>
                                </li>
                                @php $current = $coupons->currentPage(); $last = $coupons->lastPage(); $start = max(1, $current - 2); $end = min($last, $current + 2); @endphp
                                @if($start > 1)
                                    <li class="page-item {{ $current == 1 ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $coupons->url(1) }}">1</a>
                                    </li>
                                    @if($start > 2)<li class="page-item"><span class="page-link ellipsis">...</span></li>@endif
                                @endif
                                @for($i = $start; $i <= $end; $i++)
                                    <li class="page-item {{ $i == $current ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $coupons->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                @if($end < $last)
                                    @if($end < $last - 1)<li class="page-item"><span class="page-link ellipsis">...</span></li>@endif
                                    <li class="page-item {{ $current == $last ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $coupons->url($last) }}">{{ $last }}</a>
                                    </li>
                                @endif
                                <li class="page-item {{ !$coupons->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link prev-next" href="{{ $coupons->nextPageUrl() ?? '#' }}" aria-label="Next">
                                        <span>{{ __('admin.pages.common.next') }}</span> <i class="ri-arrow-right-s-line"></i>
                                    </a>
                                </li>
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
        function clearCouponsSearch() {
            document.getElementById('couponsSearchInput').value = '';
            document.getElementById('couponsFilterForm').submit();
        }
        @if(($search ?? '') !== '')
            document.addEventListener('DOMContentLoaded', function() {
                var input = document.getElementById('couponsSearchInput');
                if (input) { var len = input.value.length; input.setSelectionRange(len, len); input.focus(); }
            });
        @endif
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
