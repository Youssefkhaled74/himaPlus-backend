@extends('layouts.admin.home')

@section('title')
    <title>{{ __('admin.pages.orders.title') }}</title>
@endsection

@section('css')
    <style>
        .admin-orders-toggle {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px;
            border: 1px solid rgba(216, 227, 240, 0.98);
            border-radius: 22px;
            background: linear-gradient(180deg, #ffffff, #f6faff);
            box-shadow: 0 12px 28px rgba(16, 32, 58, 0.06);
        }

        .admin-orders-toggle__link {
            min-height: 50px;
            min-width: 170px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 0 22px;
            border: 1px solid rgba(216, 227, 240, 0.98);
            border-radius: 16px;
            background: #fff;
            color: #274066;
            font-weight: 800;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.8);
        }

        .admin-orders-toggle__link:hover {
            color: #10203a;
            border-color: rgba(15, 75, 191, 0.28);
            background: #f4f8ff;
            transform: translateY(-1px);
        }

        .admin-orders-toggle__link.is-active {
            border-color: transparent;
            background: linear-gradient(135deg, #18326f, #0f4bbf);
            color: #fff;
            box-shadow: 0 14px 26px rgba(15, 75, 191, 0.24);
        }

        .admin-orders-toggle__link.is-active:hover {
            color: #fff;
        }

        .admin-orders-toggle__link i {
            font-size: 1rem;
        }

        @media (max-width: 767.98px) {
            .admin-orders-toggle {
                width: 100%;
                display: grid;
                grid-template-columns: 1fr;
            }

            .admin-orders-toggle__link {
                width: 100%;
                min-width: 0;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $tab = $tab ?? request('tab', 'orders');
        $isRequestsPage = $tab === 'requests';
    @endphp

    <div class="page-content">
        <div class="container-fluid">
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
                            <h5 class="admin-card-head__title">{{ __('admin.pages.orders.overview') }}</h5>
                            <p class="admin-card-head__text">{{ __('admin.pages.orders.overview_subtitle') }}</p>
                        </div>
                        <div class="admin-card-head__actions">
                            <div class="admin-orders-toggle" role="tablist" aria-label="Orders tabs">
                                <a
                                    href="{{ route('admin/orders/index') }}/0/{{ PAGINATION_COUNT }}?tab=orders"
                                    class="admin-orders-toggle__link {{ $isRequestsPage ? '' : 'is-active' }}"
                                    aria-selected="{{ $isRequestsPage ? 'false' : 'true' }}">
                                    <i class="ri-shopping-bag-3-line"></i>
                                    <span>{{ __('admin.nav.orders') }}</span>
                                </a>
                                <a
                                    href="{{ route('admin/orders/index') }}/0/{{ PAGINATION_COUNT }}?tab=requests"
                                    class="admin-orders-toggle__link {{ $isRequestsPage ? 'is-active' : '' }}"
                                    aria-selected="{{ $isRequestsPage ? 'true' : 'false' }}">
                                    <i class="ri-inbox-archive-line"></i>
                                    <span>{{ __('admin.pages.common.requests') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="scroll-horizontal" class="table nowrap align-middle dataTable no-footer" style="width: 100%" aria-describedby="scroll-horizontal_info">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ __('admin.pages.common.id') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.order_type') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.customer') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.provider') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.status') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.vat_amount') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.total_cost') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody id="tableShowData">
                                @isset($orders)
                                    @foreach($orders as $record)
                                        @php
                                            $orderType = '---';
                                            $orderBadge = 'bg-info-subtle text-info';
                                            $status = $record->resolveAdminStatus((int) ($record->provider_id ?? 0) ?: null);
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
                                            <td>
                                                <a href="{{ route('admin/orders/edit', $record->id) }}" class="text-reset text-decoration-none fw-semibold">
                                                    {{ $record->user?->name }}
                                                </a>
                                            </td>
                                            <td>{{ $record->provider?->name }}</td>
                                            <td><span class="badge {{ $status['class'] }}">{{ $status['text'] }}</span></td>
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
                                                                <i class="ri-eye-line align-bottom me-2 text-muted"></i> {{ __('admin.pages.common.details') }}
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
                                            <h4>{{ __('admin.pages.common.confirm_activate') }}</h4>
                                            <p class="text-muted">{{ __('admin.pages.common.confirm_activate_message') }}</p>
                                            <input id="activation_record_id" name="record_id" type="hidden">
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
        $(document).on('click', '.openActivationFrom', function() {
            var id = $(this).attr('data-id');
            $('#activation_record_id').val(id);
        });
    </script>
@endsection
