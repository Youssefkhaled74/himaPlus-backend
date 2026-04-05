@extends('layouts.admin.home')

@section('title')
    <title>{{ __('admin.pages.admins.title') }}</title>
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
                :badge="__('admin.pages.admins.module_label')"
                :title="__('admin.pages.admins.title')"
                :description="__('admin.pages.admins.description')"
                :breadcrumbs="[
                    ['label' => __('admin.pages.common.home'), 'href' => route('admin/index')],
                    ['label' => __('admin.nav.admins'), 'href' => route('admin/admins/index') . '/0/' . PAGINATION_COUNT],
                    ['label' => __('admin.pages.common.index'), 'active' => true],
                ]"
            >
                <x-slot:actions>
                    <a href="{{ route('admin/admins/archives') . '/0/' . PAGINATION_COUNT }}" class="btn btn-light">
                        <i class="ri-archive-line align-bottom"></i>
                        <span>{{ __('admin.pages.common.archives') }}</span>
                    </a>
                    <a href="{{ route('admin/admins/create') }}" class="btn btn-primary">
                        <i class="ri-add-line align-bottom"></i>
                        <span>{{ __('admin.pages.admins.add_admin') }}</span>
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
                            <span class="admin-card-head__eyebrow">{{ __('admin.pages.admins.module_label') }}</span>
                            <h5 class="admin-card-head__title">{{ __('admin.pages.admins.overview') }}</h5>
                            <p class="admin-card-head__text">{{ __('admin.pages.admins.overview_subtitle') }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6 col-lg-4">
                            <input
                                type="search"
                                class="form-control data_search"
                                placeholder="{{ __('admin.pages.common.search_in', ['label' => __('admin.nav.admins')]) }}"
                                aria-controls="scroll-horizontal"
                            />
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="scroll-horizontal" class="table nowrap align-middle dataTable no-footer" style="width: 100%" aria-describedby="scroll-horizontal_info">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ __('admin.pages.common.id') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.image') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.name') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.email') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.phone') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.activation') }}</th>
                                    <th class="text-center">{{ __('admin.pages.common.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody id="tableShowData">
                                @isset($admins)
                                    @foreach ($admins as $record)
                                        @php
                                            $activationClass = $record->is_activate == 1 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger';
                                            $activationLabel = $record->is_activate == 1 ? __('admin.pages.common.active') : __('admin.pages.common.inactive');
                                        @endphp
                                        <tr class="text-center">
                                            <td class="fw-semibold">#{{ $record->id }}</td>
                                            <td>
                                                <img src="{{ asset($record->img) }}" alt="record image" class="img-fluid rounded-4" width="72" style="height:72px; object-fit:cover;">
                                            </td>
                                            <td class="fw-semibold">{{ $record->name }}</td>
                                            <td>{{ $record->email }}</td>
                                            <td>{{ $record->phone }}</td>
                                            <td>
                                                <div class="admin-activation-toggle">
                                                    <span class="admin-activation-toggle__text {{ $record->is_activate == 1 ? 'is-active' : 'is-inactive' }} admin-status-text-{{ $record->id }}">
                                                        {{ $record->is_activate == 1 ? __('admin.pages.common.active') : __('admin.pages.common.inactive') }}
                                                    </span>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input admin-toggle-activation" type="checkbox" id="activation{{ $record->id }}" {{ $record->is_activate == 1 ? 'checked' : '' }} data-id="{{ $record->id }}" />
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-fill align-middle"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" style="text-align: end;">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin/admins/edit', $record->id) }}">
                                                                <i class="ri-edit-2-fill align-bottom me-2 text-muted"></i> {{ __('admin.pages.common.edit') }}
                                                            </a>
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
                                    @endforeach
                                @endisset
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">
                        <div class="text-muted fw-semibold">
                            <span>{{ __('admin.pages.common.showing') }}</span>
                            <span>1</span>
                            <span>{{ __('admin.pages.common.to') }}</span>
                            <span id="showItems">{{ PAGINATION_COUNT }}</span>
                            <span>{{ __('admin.pages.common.of') }}</span>
                            <span>{{ App\Models\Admin::unArchive()->count() }}</span>
                            <span>{{ __('admin.pages.common.entries') }}</span>
                        </div>
                        <div id="load_more">
                            <button type="button" name="load_more_button" class="btn btn-info px-5" id="load_more_button">
                                {{ __('admin.pages.common.load_more') }}
                            </button>
                        </div>
                    </div>

                    <div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabell" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title f-w-600" id="exampleModalLabell"></h5>
                                </div>
                                <div class="modal-body text-center p-5">
                                    <form role="form" action="{{ url(route('admin/admins/delete')) }}" method="post">
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

                    <div class="modal fade" id="myModalActivation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title f-w-600" id="exampleModalLabel"></h5>
                                </div>
                                <div class="modal-body text-center p-5">
                                    <form role="form" action="{{ url(route('admin/admins/activate')) }}" method="post">
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
        
        // Handle admin activation toggle
        $(document).on('change', '.admin-toggle-activation', function() {
            const checkbox = $(this);
            const adminId = checkbox.data('id');
            const isActive = checkbox.is(':checked') ? 1 : 0;
            const statusText = checkbox.is(':checked') ? '{{ __("admin.pages.common.active") }}' : '{{ __("admin.pages.common.inactive") }}';
            const statusElement = $('.admin-status-text-' + adminId);
            
            $.ajax({
                url: '{{ route("admin/admins/activate") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    record_id: adminId
                },
                success: function(response) {
                    // Update text and classes
                    statusElement.text(statusText);
                    if (isActive) {
                        statusElement.removeClass('is-inactive').addClass('is-active');
                    } else {
                        statusElement.removeClass('is-active').addClass('is-inactive');
                    }
                    // Show success message
                    showSuccessAlert('{{ __("admin.pages.common.success_message") }}');
                },
                error: function(error) {
                    checkbox.prop('checked', !checkbox.is(':checked'));
                    showErrorAlert('{{ __("admin.pages.common.error_message") }}');
                }
            });
        });
        
        function showSuccessAlert(message) {
            const alertHtml = `
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>${message}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            `;
            $('.page-content').prepend(alertHtml);
            setTimeout(() => {
                $('.alert').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 5000);
        }
        
        function showErrorAlert(message) {
            const alertHtml = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>${message}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            `;
            $('.page-content').prepend(alertHtml);
            setTimeout(() => {
                $('.alert').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 5000);
        }
    </script>
    <script>
        var q = '';
        var offset = length = limit = `{{ PAGINATION_COUNT }}`;
        var adminEditBase = `{{ url('admin-panel/admins/edit') }}`;
        var _token = $('input[name="_token"]').val();
        let showItems = document.getElementById("showItems");
        var tableShowData = document.getElementById("tableShowData");
        var activeLabel = @json(__('admin.pages.common.active'));
        var inactiveLabel = @json(__('admin.pages.common.inactive'));
        var editLabel = @json(__('admin.pages.common.edit'));
        var activationLabel = @json(__('admin.pages.common.activation'));
        var deleteLabel = @json(__('admin.pages.common.delete'));
        var loadMoreLabel = @json(__('admin.pages.common.load_more'));
        var noDataLabel = @json(__('admin.pages.common.no_data'));

        showItems.innerHTML = limit;

        $(document).on('click', '#load_more_button', function(event) {
            var urlPath = `{{ route('admin/admins/pagination') }}/${offset}/${limit}`;
            event.preventDefault();
            $('#load_more_button').html('<b>Loading... </b>');
            search_in_data(q, urlPath, 1);
        });

        $(document).on('keyup', '.data_search', function(event) {
            q = $(this).val();
            var urlPath = "{{ route('admin/admins/search') }}";
            event.preventDefault();
            search_in_data(q, urlPath, 2);
        });

        function search_in_data(q, urlPath, action_type, record = '') {
            $.ajax({
                url: urlPath,
                method: "POST",
                data: {
                    q: q,
                    record: record,
                    _token: _token
                },
                success: function(data) {
                    if (data.length > 0) {
                        table_records(data, action_type);
                    } else if (data.length === 0) {
                        if (action_type == 2) {
                            length = data.length;
                            showItems.innerHTML = Number(length);
                            tableShowData.style.display = 'none';
                        }
                        $('#load_more_button').remove();
                        document.getElementById("load_more").innerHTML = `<button type="button" name="load_more_button" class="btn btn-primary px-5" id="load_more_button_remove">${noDataLabel}</button>`;
                    }
                }
            })
        }

        function table_records(data, action_type) {
            let records = ``;
            q == '' && action_type == 2 ? offset = `{{ PAGINATION_COUNT }}` : '';
            for (let i = 0; i < data.length; i++) {
                image_path = "{{ asset('') }}" + data[i].img;
                records += `<tr class="text-center">
                    <td class="fw-semibold">#${data[i].id}</td>
                    <td><img src="${image_path}" alt="record image" class="img-fluid rounded-4" width="72" style="height:72px; object-fit:cover;"></td>
                    <td class="fw-semibold">${data[i].name ?? ''}</td>
                    <td>${data[i].email ?? ''}</td>
                    <td>${data[i].phone ?? ''}</td>
                    <td>${data[i].is_activate == 1 ? '<span class="badge bg-success-subtle text-success">' + activeLabel + '</span>' : '<span class="badge bg-danger-subtle text-danger">' + inactiveLabel + '</span>'}</td>
                    <td>
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" style="text-align: end;">
                                <li><a class="dropdown-item" href="${adminEditBase}/${data[i].id}"><i class="ri-edit-2-fill align-bottom me-2 text-muted"></i> ${editLabel}</a></li>
                                <li><button class="dropdown-item edit-item-btn openActivationFrom" data-bs-toggle="modal" data-bs-target="#myModalActivation" data-id="${data[i].id}"><i class="ri-loop-left-line align-bottom me-2 text-muted"></i> ${activationLabel}</button></li>
                                <li><button class="dropdown-item remove-item-btn openDeleteFrom" data-bs-toggle="modal" data-bs-target="#myModalDelete" data-id="${data[i].id}"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> ${deleteLabel}</button></li>
                            </ul>
                        </div>
                    </td>
                </tr>`;
            }

            $('#load_more_button').remove();
            $('#load_more_button_remove').remove();

            if (action_type == 1) {
                tableShowData.innerHTML += records;
                offset += data.length;
                length += data.length;
                showItems.innerHTML = Number(length);
                document.getElementById("load_more").innerHTML = `<button type="button" name="load_more_button" class="btn btn-info px-5" id="load_more_button">${loadMoreLabel}</button>`;
            } else if (action_type == 2) {
                tableShowData.style.display = null;
                tableShowData.innerHTML = records;
                length = data.length;
                showItems.innerHTML = Number(length);
                if (data[0].searchButton == 1) {
                    document.getElementById("load_more").innerHTML = `<button type="button" name="load_more_button" class="btn btn-info px-5" id="load_more_button">${loadMoreLabel}</button>`;
                }
            }
        }
    </script>
@endsection
