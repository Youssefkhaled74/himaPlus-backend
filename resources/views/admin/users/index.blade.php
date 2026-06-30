@extends('layouts.admin.home')

@section('title')
    <title>{{ __('admin.pages.users.title') }}</title>
@endsection

@section('css')
<style>
    .admin-filter-bar {
        display: flex;
        flex-wrap: wrap;
        gap: .5rem;
        align-items: center;
    }
    .admin-filter-bar .form-control,
    .admin-filter-bar .form-select {
        border-radius: .5rem !important;
        border: 1px solid #e2e5f1;
    }
    .admin-filter-bar .input-group {
        flex-wrap: nowrap;
    }
    .admin-filter-bar .input-group-text {
        border-radius: .5rem 0 0 .5rem !important;
        border: 1px solid #e2e5f1;
        border-right: 0;
    }
    html[dir='rtl'] .admin-filter-bar .input-group-text {
        border-radius: 0 .5rem .5rem 0 !important;
        border: 1px solid #e2e5f1;
        border-left: 0;
    }
    .admin-filter-bar .btn-filter {
        border-radius: .5rem !important;
        padding: .375rem 1rem;
    }
    .admin-filter-tags {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        padding: 12px 0 0;
    }
    .admin-filter-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 999px;
        background: rgba(15, 75, 191, 0.10);
        color: #0f4bbf;
        font-size: 0.82rem;
        font-weight: 700;
    }
    .admin-filter-tag .btn-close-sm {
        width: 16px;
        height: 16px;
        font-size: 0.6rem;
        opacity: 0.6;
        cursor: pointer;
        background: transparent;
        border: 0;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #0f4bbf;
        text-decoration: none;
        line-height: 1;
    }
    .admin-filter-tag .btn-close-sm:hover {
        opacity: 1;
    }
    .admin-filter-tag.is-reset {
        background: rgba(216, 79, 79, 0.10);
        color: #d84f4f;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .admin-filter-tag.is-reset:hover {
        background: rgba(216, 79, 79, 0.18);
    }
    .admin-filter-tag .tag-icon {
        font-size: 0.9rem;
    }
    .admin-filter-count {
        margin-inline-start: auto;
        font-size: 0.8rem;
        color: #6b7280;
        white-space: nowrap;
    }
    .search-clear-btn {
        border: 1px solid #e2e5f1;
        border-left: 0;
        border-radius: 0 .5rem .5rem 0 !important;
        background: transparent;
        color: #9ca3af;
        cursor: pointer;
        display: flex;
        align-items: center;
        padding: 0 .6rem;
        font-size: .9rem;
        transition: color .15s;
    }
    .search-clear-btn:hover {
        color: #d84f4f;
    }
    html[dir='rtl'] .search-clear-btn {
        border-radius: .5rem 0 0 .5rem !important;
        border: 1px solid #e2e5f1;
        border-right: 0;
        border-left: 1px solid #e2e5f1;
    }
    .admin-pagination-wrap {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding-top: 1.25rem;
    }
    .admin-pagination-info {
        font-size: 0.82rem;
        color: #6b7280;
        white-space: nowrap;
    }
    .admin-pagination {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 4px;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .admin-pagination .page-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 .5rem;
        border-radius: 8px !important;
        border: 1px solid #e2e5f1;
        background: #fff;
        color: #4b5563;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        transition: all .15s ease;
    }
    .admin-pagination .page-link:hover {
        background: #f3f6ff;
        border-color: #c4d0e3;
        color: #0f4bbf;
    }
    .admin-pagination .page-item.active .page-link {
        background: #0f4bbf;
        border-color: #0f4bbf;
        color: #fff;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(15, 75, 191, 0.2);
    }
    .admin-pagination .page-item.disabled .page-link {
        opacity: .4;
        pointer-events: none;
    }
    .admin-pagination .page-link.prev-next {
        font-size: 0.75rem;
        gap: 4px;
        padding: 0 .65rem;
    }
    .admin-pagination .page-link.ellipsis {
        border: 0;
        background: transparent;
        min-width: 24px;
        color: #9ca3af;
        pointer-events: none;
    }
    .user-summary {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        text-align: start;
    }
    .user-summary__avatar {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        object-fit: cover;
        flex-shrink: 0;
        background: #f8fafc;
    }
    .user-summary__title {
        font-weight: 700;
        color: #0f172a;
        text-decoration: none;
    }
    .user-summary__meta {
        font-size: 0.8rem;
        color: #6b7280;
    }
    @media (max-width: 767.98px) {
        .admin-filter-bar .input-group,
        .admin-filter-bar .form-select {
            width: 100% !important;
            min-width: 0 !important;
        }
        .admin-filter-bar {
            flex-direction: column;
            align-items: stretch;
        }
        .admin-filter-count {
            margin-inline-start: 0;
            width: 100%;
            text-align: start;
        }
        .admin-pagination-wrap {
            flex-direction: column;
            align-items: center;
        }
    }
</style>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-admin.page-header
                :badge="__('admin.pages.users.module_label')"
                :title="__('admin.pages.users.title')"
                :description="__('admin.pages.users.description')"
                :breadcrumbs="[
                    ['label' => __('admin.pages.common.home'), 'href' => route('admin/index')],
                    ['label' => __('admin.nav.users'), 'href' => route('admin/users/index') . '/0/' . PAGINATION_COUNT],
                    ['label' => __('admin.pages.common.index'), 'active' => true],
                ]"
            >
                <x-slot:actions>
                    <a href="{{ route('admin/users/create') }}" class="btn btn-primary">
                        <i class="ri-add-line align-bottom"></i>
                        <span>{{ __('admin.pages.users.add_user') }}</span>
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
                            <span class="admin-card-head__eyebrow">{{ __('admin.pages.users.module_label') }}</span>
                            <h5 class="admin-card-head__title">{{ __('admin.pages.users.overview') }}</h5>
                            <p class="admin-card-head__text">{{ __('admin.pages.users.overview_subtitle') }}</p>
                        </div>
                        <div class="admin-card-head__actions"></div>
                    </div>
                </div>

                @php
                    $hasActiveFilters = ($search ?? '') !== '' || ($userType ?? '') !== '';
                @endphp

                <div class="card-body" style="padding-bottom:0;">
                    <form method="GET" action="{{ route('admin/users/index', ['offset' => 0, 'limit' => PAGINATION_COUNT]) }}" id="usersFilterForm">
                        <div class="admin-filter-bar">
                            <div class="input-group" style="min-width:200px;">
                                <span class="input-group-text bg-transparent"><i class="ri-search-line"></i></span>
                                <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control" placeholder="{{ __('admin.pages.common.search_in', ['label' => __('admin.nav.users')]) }}" id="userSearchInput">
                                @if(($search ?? '') !== '')
                                    <button type="button" class="search-clear-btn" onclick="clearSearch()">&times;</button>
                                @endif
                            </div>

                            <select name="user_type" class="form-select" style="width:auto;min-width:140px;" onchange="this.form.submit()">
                                <option value="">{{ __('admin.pages.common.user_type') }}</option>
                                <option value="1" {{ ($userType ?? '') === '1' ? 'selected' : '' }}>{{ __('admin.pages.common.client') }}</option>
                                <option value="2" {{ ($userType ?? '') === '2' ? 'selected' : '' }}>{{ __('admin.pages.common.provider') }}</option>
                            </select>

                            <button type="submit" class="btn btn-primary btn-filter">
                                <i class="ri-search-2-line align-bottom"></i>
                            </button>

                            @if($hasActiveFilters)
                                <a href="{{ route('admin/users/index') }}/0/{{ PAGINATION_COUNT }}" class="btn btn-light btn-filter">
                                    <i class="ri-close-line align-bottom"></i>
                                </a>
                            @endif

                            <span class="admin-filter-count">
                                <i class="ri-group-line align-bottom me-1"></i>
                                {{ $users->total() }}
                            </span>
                        </div>

                        @if($hasActiveFilters)
                            <div class="admin-filter-tags">
                                @if(($search ?? '') !== '')
                                    <span class="admin-filter-tag">
                                        <i class="ri-search-line tag-icon"></i>
                                        {{ $search }}
                                        <a href="{{ route('admin/users/index') }}/0/{{ PAGINATION_COUNT }}?search=&user_type={{ $userType ?? '' }}" class="btn-close-sm">&times;</a>
                                    </span>
                                @endif

                                @if(($userType ?? '') !== '')
                                    <span class="admin-filter-tag">
                                        <i class="ri-user-star-line tag-icon"></i>
                                        {{ ($userType ?? '') === '1' ? __('admin.pages.common.client') : __('admin.pages.common.provider') }}
                                        <a href="{{ route('admin/users/index') }}/0/{{ PAGINATION_COUNT }}?search={{ $search ?? '' }}&user_type=" class="btn-close-sm">&times;</a>
                                    </span>
                                @endif

                                <a href="{{ route('admin/users/index') }}/0/{{ PAGINATION_COUNT }}" class="admin-filter-tag is-reset">
                                    <i class="ri-restart-line"></i> {{ __('admin.pages.common.reset') }}
                                </a>
                            </div>
                        @endif
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="scroll-horizontal" class="table nowrap align-middle dataTable no-footer" style="width: 100%" aria-describedby="scroll-horizontal_info">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ __('admin.pages.common.id') }}</th>
                                    <th>{{ __('admin.pages.common.name') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.mobile') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.email') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.user_type') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.activation') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody id="tableShowData">
                                @forelse($users as $record)
                                    @php
                                        $typeClass = $record->user_type == 1 ? 'bg-success-subtle text-success' : 'bg-primary-subtle text-primary';
                                        $typeLabel = $record->user_type == 1 ? __('admin.pages.common.client') : __('admin.pages.common.provider');
                                        $activationClass = $record->is_activate == 1 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger';
                                        $activationLabel = $record->is_activate == 1 ? __('admin.pages.common.active') : __('admin.pages.common.inactive');
                                    @endphp
                                    <tr>
                                        <td class="text-center fw-semibold">#{{ $record->id }}</td>
                                        <td>
                                            <div class="user-summary">
                                                <img
                                                    src="{{ asset($record->img) }}"
                                                    alt="{{ $record->name }}"
                                                    class="user-summary__avatar"
                                                    onerror="this.onerror=null;this.src='{{ asset('front/assets/images/emptyproducts.png') }}'">
                                                <div>
                                                    <a href="{{ route('admin/users/show', $record->id) }}" class="user-summary__title">
                                                        {{ $record->name }}
                                                    </a>
                                                    <div class="user-summary__meta">{{ $record->location ?: '-' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $record->mobile }}</td>
                                        <td class="text-center">{{ $record->email }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $typeClass }}">{{ $typeLabel }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ $activationClass }}">{{ $activationLabel }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill align-middle"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" style="text-align: end;">
                                                    <li>
                                                        <a href="{{ route('admin/users/edit', $record->id) }}" class="dropdown-item edit-item-btn">
                                                            <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> {{ __('admin.pages.common.edit') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('admin/users/show', $record->id) }}" class="dropdown-item edit-item-btn">
                                                            <i class="ri-user-search-line align-bottom me-2 text-muted"></i> {{ __('admin.pages.common.details') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button
                                                            class="dropdown-item edit-item-btn show-user"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#userShowModal"
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
                                                            data-img="{{ $record->img ? asset($record->img) : '' }}">
                                                            <i class="ri-eye-line align-bottom me-2 text-muted"></i> {{ __('admin.pages.common.show') }}
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item edit-item-btn openActivationFrom" data-bs-toggle="modal" data-bs-target="#myModalActivation" data-id="{{ $record->id }}">
                                                            <i class="ri-loop-left-line align-bottom me-2 text-muted"></i> {{ __('admin.pages.common.activation') }}
                                                        </button>
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
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-5">{{ __('admin.pages.common.no_data') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="admin-pagination-wrap">
                        <div class="admin-pagination-info">
                            @php
                                $from = $users->firstItem() ?? 0;
                                $to = $users->lastItem() ?? 0;
                                $total = $users->total();
                            @endphp
                            {{ __('admin.pages.common.showing_entries', ['from' => $from, 'to' => $to, 'total' => $total]) }}
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="admin-pagination">
                                <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link prev-next" href="{{ $users->previousPageUrl() ?? '#' }}" aria-label="Previous">
                                        <i class="ri-arrow-left-s-line"></i> <span>{{ __('admin.pages.common.previous') }}</span>
                                    </a>
                                </li>
                                @php
                                    $current = $users->currentPage();
                                    $last = $users->lastPage();
                                    $start = max(1, $current - 2);
                                    $end = min($last, $current + 2);
                                @endphp
                                @if($start > 1)
                                    <li class="page-item {{ $current == 1 ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $users->url(1) }}">1</a>
                                    </li>
                                    @if($start > 2)
                                        <li class="page-item"><span class="page-link ellipsis">...</span></li>
                                    @endif
                                @endif
                                @for($i = $start; $i <= $end; $i++)
                                    <li class="page-item {{ $i == $current ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                @if($end < $last)
                                    @if($end < $last - 1)
                                        <li class="page-item"><span class="page-link ellipsis">...</span></li>
                                    @endif
                                    <li class="page-item {{ $current == $last ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $users->url($last) }}">{{ $last }}</a>
                                    </li>
                                @endif
                                <li class="page-item {{ !$users->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link prev-next" href="{{ $users->nextPageUrl() ?? '#' }}" aria-label="Next">
                                        <span>{{ __('admin.pages.common.next') }}</span> <i class="ri-arrow-right-s-line"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <div class="modal fade" id="myModalDelete" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">{{ __('admin.pages.common.confirm_delete') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('admin.pages.common.close') }}"></button>
                                </div>
                                <div class="modal-body text-center p-5">
                                    <form role="form" action="{{ route('admin/users/delete') }}" method="post">
                                        {{ csrf_field() }}
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

                    <div class="modal fade" id="myModalActivation" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">{{ __('admin.pages.common.confirm_activate') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('admin.pages.common.close') }}"></button>
                                </div>
                                <div class="modal-body text-center p-5">
                                    <form role="form" action="{{ route('admin/users/activate') }}" method="post">
                                        {{ csrf_field() }}
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

                    <div class="modal fade" id="userShowModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">{{ __('admin.pages.common.details') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('admin.pages.common.close') }}"></button>
                                </div>
                                <div class="modal-body" dir="ltr">
                                    <div class="row g-4 align-items-center">
                                        <div class="col-md-3 text-center">
                                            <img id="uAvatar" class="rounded-circle shadow-sm d-none" style="width:96px;height:96px;object-fit:cover" src="" alt="">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="text-muted small mt-1">{{ __('admin.pages.common.id') }}: <span id="uId">-</span></div>
                                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                                <h4 class="m-0" id="uName">-</h4>
                                                <span id="uTypeBadge" class="badge rounded-pill px-3 py-2"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-4">

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <ul class="list-group small shadow-sm rounded-3" style="padding: 0;">
                                                <li class="list-group-item d-flex justify-content-between"><span class="text-muted">{{ __('admin.pages.common.email') }}</span><span id="uEmail" class="fw-semibold">-</span></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="text-muted">{{ __('admin.pages.common.mobile') }}</span><span id="uMobile" class="fw-semibold">-</span></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="text-muted">{{ __('admin.pages.common.branch') }}</span><span id="uBranch" class="fw-semibold">-</span></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="text-muted">{{ __('admin.pages.common.location') }}</span><span id="uLocation" class="fw-semibold">-</span></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="list-group small shadow-sm rounded-3" style="padding: 0;">
                                                <li class="list-group-item d-flex justify-content-between"><span class="text-muted">{{ __('admin.pages.common.tax_number') }}</span><span id="uTax" class="fw-semibold">-</span></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="text-muted">{{ __('admin.pages.common.cr_number') }}</span><span id="uCrNumber" class="fw-semibold">-</span></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="text-muted">{{ __('admin.pages.common.cr_document') }}</span><a id="uCrDocLink" href="#" target="_blank" class="fw-semibold text-decoration-none">{{ __('admin.pages.common.open_file') }}</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-light" data-bs-dismiss="modal">{{ __('admin.pages.common.close') }}</button>
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
        $('#delete_record_id').val($(this).attr('data-id'));
    });

    $(document).on('click', '.openActivationFrom', function() {
        $('#activation_record_id').val($(this).attr('data-id'));
    });

    function clearSearch() {
        document.getElementById('userSearchInput').value = '';
        document.getElementById('usersFilterForm').submit();
    }

    @if(($search ?? '') !== '')
        document.addEventListener('DOMContentLoaded', function() {
            var input = document.getElementById('userSearchInput');
            if (input) {
                var len = input.value.length;
                input.setSelectionRange(len, len);
                input.focus();
            }
        });
    @endif

    var userTypeLabels = {
        client: @json(__('admin.pages.common.client')),
        provider: @json(__('admin.pages.common.provider')),
        undefined: @json(__('admin.pages.common.undefined'))
    };

    $('#userShowModal').on('show.bs.modal', function(e) {
        var $modal = $(this);
        var $button = $(e.relatedTarget);
        var type = String($button.data('user-type') || '');
        var crDoc = $button.data('cr-doc') || '';
        var img = $button.data('img') || '';

        $modal.find('#uId').text($button.data('id') || '-');
        $modal.find('#uName').text($button.data('name') || '-');
        $modal.find('#uEmail').text($button.data('email') || '-');
        $modal.find('#uMobile').text($button.data('mobile') || '-');
        $modal.find('#uBranch').text($button.data('branch') || '-');
        $modal.find('#uLocation').text($button.data('location') || '-');
        $modal.find('#uTax').text($button.data('tax') || '-');
        $modal.find('#uCrNumber').text($button.data('cr-number') || '-');

        var $avatar = $modal.find('#uAvatar');
        if (img) {
            $avatar.attr('src', img).removeClass('d-none');
        } else {
            $avatar.attr('src', '').addClass('d-none');
        }

        var $badge = $modal.find('#uTypeBadge').removeClass().addClass('badge rounded-pill px-3 py-2');
        if (type === '1') {
            $badge.addClass('bg-success-subtle text-success').text(userTypeLabels.client);
        } else if (type === '2') {
            $badge.addClass('bg-primary-subtle text-primary').text(userTypeLabels.provider);
        } else {
            $badge.addClass('bg-secondary-subtle text-secondary-emphasis').text(userTypeLabels.undefined);
        }

        var $crLink = $modal.find('#uCrDocLink');
        if (crDoc) {
            $crLink.attr('href', crDoc).removeClass('disabled');
        } else {
            $crLink.attr('href', '#').addClass('disabled');
        }
    });
</script>
@endsection
