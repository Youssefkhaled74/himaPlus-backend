@extends('layouts.admin.home')

@section('title')
    <title>{{ __('admin.pages.countries.title') }}</title>
@endsection

@section('css')
    <style>
        .country-status-toggle-wrap {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .country-status-toggle-wrap .form-check-input {
            width: 2.45rem;
            height: 1.35rem;
            cursor: pointer;
        }

        .country-status-toggle-wrap .status-text {
            min-width: 62px;
            font-weight: 700;
            font-size: 0.82rem;
        }
    </style>
@endsection

@section('content')
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
                            <span class="admin-card-head__eyebrow">{{ __('admin.pages.countries.module_label') }}</span>
                            <h5 class="admin-card-head__title">{{ __('admin.pages.countries.overview') }}</h5>
                            <p class="admin-card-head__text">{{ __('admin.pages.countries.overview_subtitle') }}</p>
                        </div>
                        <div class="admin-card-head__actions">
                            <a href="{{ route('admin/countries/create') }}" class="btn btn-primary">
                                <i class="ri-add-line align-bottom"></i>
                                <span>{{ __('admin.pages.countries.add_country') }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="scroll-horizontal" class="table nowrap align-middle dataTable no-footer" style="width: 100%" aria-describedby="scroll-horizontal_info">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ __('admin.pages.common.id') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.name') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.activation') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody id="tableShowData">
                                @isset($countries)
                                    @foreach ($countries as $record)
                                        @php
                                            $activationLabel = $record->is_activate == 1 ? __('admin.pages.common.active') : __('admin.pages.common.inactive');
                                        @endphp
                                        <tr class="text-center">
                                            <td class="fw-semibold">#{{ $record->id }}</td>
                                            <td class="fw-semibold">{{ $record->name }}</td>
                                            <td>
                                                <form method="post" action="{{ url(route('admin/countries/activate')) }}" class="d-inline-block country-status-toggle-form">
                                                    @csrf
                                                    <input type="hidden" name="record_id" value="{{ $record->id }}">
                                                    <div class="country-status-toggle-wrap">
                                                        <div class="form-check form-switch m-0">
                                                            <input
                                                                class="form-check-input country-status-toggle"
                                                                type="checkbox"
                                                                role="switch"
                                                                aria-label="{{ __('admin.pages.common.toggle_activation') }}"
                                                                {{ $record->is_activate == 1 ? 'checked' : '' }}
                                                            >
                                                        </div>
                                                        <span class="status-text {{ $record->is_activate == 1 ? 'text-success' : 'text-danger' }}">
                                                            {{ $activationLabel }}
                                                        </span>
                                                    </div>
                                                </form>
                                            </td>
                                            <td>
                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-fill align-middle"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" style="text-align: end;">
                                                        <li>
                                                            <a href="{{ route('admin/countries/edit', $record->id) }}" class="dropdown-item edit-item-btn">
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
                                @if (!$countries->onFirstPage())
                                    <li class="page-item mt-1">
                                        <a class="page-link" href="{{ $countries->previousPageUrl() }}" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                @endif

                                @for ($i = 1; $i <= $countries->lastPage(); $i++)
                                    <li class="page-item mt-1 {{ $i == $countries->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $countries->url($i) }}" @if ($i == $countries->currentPage()) style="font-weight:bold;" @endif>
                                            {{ $i }}
                                        </a>
                                    </li>
                                @endfor

                                @if ($countries->hasMorePages())
                                    <li class="page-item mt-1">
                                        <a class="page-link" href="{{ $countries->nextPageUrl() }}" aria-label="Next">
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
                                    <form role="form" action="{{ url(route('admin/countries/delete')) }}" method="post">
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
            $('.sidebarcountries').addClass('active');
            var target = $('.sidebarcountries').attr('href');
            $(target).addClass('show');
        })();

        $(document).on('click', '.openDeleteFrom', function() {
            $('#delete_record_id').val($(this).attr('data-id'));
        });

        $(document).on('change', '.country-status-toggle', function() {
            $(this).closest('form.country-status-toggle-form').submit();
        });
    </script>
@endsection
