@extends('layouts.admin.home')

@section('title')
    <title>{{ __('admin.pages.users.archives') }}</title>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-admin.page-header
                :badge="__('admin.pages.users.module_label')"
                :title="__('admin.pages.users.archives')"
                :description="__('admin.pages.users.overview_subtitle')"
                :breadcrumbs="[
                    ['label' => __('admin.pages.common.home'), 'href' => route('admin/index')],
                    ['label' => __('admin.nav.users'), 'href' => route('admin/users/index') . '/0/' . PAGINATION_COUNT],
                    ['label' => __('admin.pages.common.archives'), 'active' => true],
                ]"
            >
                <x-slot:actions>
                    <a href="{{ route('admin/users/index') . '/0/' . PAGINATION_COUNT }}" class="btn btn-light">
                        <i class="ri-arrow-left-line align-bottom"></i>
                        <span>{{ __('admin.pages.users.back_to_users') }}</span>
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
                            <h5 class="admin-card-head__title">{{ __('admin.pages.users.archives') }}</h5>
                            <p class="admin-card-head__text">{{ __('admin.pages.users.overview_subtitle') }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table nowrap align-middle">
                            <thead>
                            <tr>
                                <th class="text-center">{{ __('admin.pages.common.id') }}</th>
                                <th class="text-center">{{ __('admin.pages.common.name') }}</th>
                                <th class="text-center">{{ __('admin.pages.common.email') }}</th>
                                <th class="text-center">{{ __('admin.pages.common.mobile') }}</th>
                                <th class="text-center">{{ __('admin.pages.common.activation') }}</th>
                                <th class="text-center">{{ __('admin.pages.common.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $record)
                                @php
                                    $activationClass = (int) $record->is_activate === 1
                                        ? 'bg-success-subtle text-success'
                                        : 'bg-danger-subtle text-danger';
                                    $activationLabel = (int) $record->is_activate === 1
                                        ? __('admin.pages.common.active')
                                        : __('admin.pages.common.inactive');
                                @endphp
                                <tr class="text-center">
                                    <td class="fw-semibold">#{{ $record->id }}</td>
                                    <td class="fw-semibold">{{ $record->name }}</td>
                                    <td>{{ $record->email ?? '-' }}</td>
                                    <td>{{ $record->mobile ?? '-' }}</td>
                                    <td><span class="badge {{ $activationClass }}">{{ $activationLabel }}</span></td>
                                    <td>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <button
                                                        class="dropdown-item openBackFrom"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#restoreUserModal"
                                                        data-id="{{ $record->id }}">
                                                        <i class="ri-arrow-go-back-line align-bottom me-2 text-muted"></i>
                                                        {{ __('admin.pages.common.continue') }}
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">{{ __('admin.pages.common.no_data') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(method_exists($users, 'hasPages') && $users->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            <nav aria-label="Page navigation">
                                <ul class="pagination flex-wrap justify-content-center align-items-center">
                                    @if (!$users->onFirstPage())
                                        <li class="page-item mt-1">
                                            <a class="page-link" href="{{ $users->previousPageUrl() }}" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    @endif
                                    @for ($i = 1; $i <= $users->lastPage(); $i++)
                                        <li class="page-item mt-1 {{ $i == $users->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $users->url($i) }}" @if ($i == $users->currentPage()) style="font-weight:bold;" @endif>{{ $i }}</a>
                                        </li>
                                    @endfor
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
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="restoreUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title f-w-600">{{ __('admin.pages.common.archive') }}</h5>
                </div>
                <div class="modal-body text-center p-5">
                    <form action="{{ url(route('admin/users/back')) }}" method="post">
                        @csrf
                        <lord-icon
                            src="https://cdn.lordicon.com/tdrtiskw.json"
                            trigger="loop"
                            colors="primary:#f7b84b,secondary:#405189"
                            style="width:130px;height:130px">
                        </lord-icon>
                        <div class="mt-4 pt-4">
                            <h4>{{ __('admin.pages.common.confirm_activate') }}</h4>
                            <p class="text-muted">{{ __('admin.pages.common.confirm_activate_message') }}</p>
                            <input id="back_record_id" name="record_id" type="hidden">
                            <button type="submit" class="btn btn-warning">{{ __('admin.pages.common.continue') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).on('click', '.openBackFrom', function () {
            $('#back_record_id').val($(this).data('id'));
        });
    </script>
@endsection
