@extends('layouts.admin.home')

@section('title')
    <title>{{ __('admin.pages.orders.archives') }}</title>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-admin.page-header
                :badge="__('admin.pages.orders.module_label')"
                :title="__('admin.pages.orders.archives')"
                :description="__('admin.pages.orders.overview_subtitle')"
                :breadcrumbs="[
                    ['label' => __('admin.pages.common.home'), 'href' => route('admin/index')],
                    ['label' => __('admin.nav.orders'), 'href' => route('admin/orders/index') . '/0/' . PAGINATION_COUNT],
                    ['label' => __('admin.pages.common.archives'), 'active' => true],
                ]"
            >
                <x-slot:actions>
                    <a href="{{ route('admin/orders/index') . '/0/' . PAGINATION_COUNT }}" class="btn btn-light">
                        <i class="ri-arrow-left-line align-bottom"></i>
                        <span>{{ __('admin.pages.orders.back_to_orders') }}</span>
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
                            <span class="admin-card-head__eyebrow">{{ __('admin.pages.orders.module_label') }}</span>
                            <h5 class="admin-card-head__title">{{ __('admin.pages.orders.archives') }}</h5>
                            <p class="admin-card-head__text">{{ __('admin.pages.orders.overview_subtitle') }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table nowrap align-middle">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ __('admin.pages.common.id') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.order_type') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.customer') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.provider') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.vat_amount') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.total_cost') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $record)
                                    @php
                                        $orderType = '---';
                                        $orderBadge = 'bg-info-subtle text-info';
                                        if ((int) $record->order_type === 1) {
                                            $orderType = __('admin.pages.common.order');
                                            $orderBadge = 'bg-primary-subtle text-primary';
                                        } elseif ((int) $record->order_type === 2) {
                                            $orderType = __('admin.pages.common.quotation');
                                            $orderBadge = 'bg-warning-subtle text-warning';
                                        } elseif ((int) $record->order_type === 3) {
                                            $orderType = __('admin.pages.common.maintenance');
                                            $orderBadge = 'bg-success-subtle text-success';
                                        }
                                    @endphp
                                    <tr class="text-center">
                                        <td class="fw-semibold">#{{ $record->id }}</td>
                                        <td><span class="badge {{ $orderBadge }}">{{ $orderType }}</span></td>
                                        <td>{{ $record->user?->name ?? '-' }}</td>
                                        <td>{{ $record->provider?->name ?? '-' }}</td>
                                        <td>{{ number_format((float) ($record->vat_amount ?? 0), 2) }}</td>
                                        <td class="fw-semibold">{{ number_format((float) ($record->total_cost ?? 0), 2) }}</td>
                                        <td>
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill align-middle"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a href="{{ route('admin/orders/edit', $record->id) }}" class="dropdown-item">
                                                            <i class="ri-eye-line align-bottom me-2 text-muted"></i>
                                                            {{ __('admin.pages.common.details') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button
                                                            class="dropdown-item openBackFrom"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#restoreOrderModal"
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
                                        <td colspan="7" class="text-center text-muted py-5">{{ __('admin.pages.common.no_data') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(method_exists($orders, 'hasPages') && $orders->hasPages())
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
                                            <a class="page-link" href="{{ $orders->url($i) }}" @if ($i == $orders->currentPage()) style="font-weight:bold;" @endif>{{ $i }}</a>
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
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="restoreOrderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title f-w-600">{{ __('admin.pages.common.archive') }}</h5>
                </div>
                <div class="modal-body text-center p-5">
                    <form action="{{ url(route('admin/orders/back')) }}" method="post">
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
