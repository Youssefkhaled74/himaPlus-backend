@extends('layouts.admin.home')

@section('title')
    <title>{{ __('admin.pages.users.title') }}</title>
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
                <a href="{{ route('admin/users/archives') . '/0/' . PAGINATION_COUNT }}" class="btn btn-light">
                    <i class="ri-archive-line align-bottom"></i>
                    <span>{{ __('admin.pages.common.archives') }}</span>
                </a>
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
            </div><div class="card-body"><div class="table-responsive"><table id="scroll-horizontal" class="table nowrap align-middle dataTable no-footer" style="width: 100%" aria-describedby="scroll-horizontal_info"><thead><tr><th class="text-center">{{ __('admin.pages.common.id') }}</th><th class="text-center">{{ __('admin.pages.common.name') }}</th><th class="text-center">{{ __('admin.pages.common.image') }}</th><th class="text-center">{{ __('admin.pages.common.mobile') }}</th><th class="text-center">{{ __('admin.pages.common.email') }}</th><th class="text-center">{{ __('admin.pages.common.user_type') }}</th><th class="text-center">{{ __('admin.pages.common.activation') }}</th><th class="text-center">{{ __('admin.pages.common.actions') }}</th></tr></thead><tbody id="tableShowData">@isset($users) @foreach($users as $record) @php $typeClass = $record->user_type == 1 ? 'bg-success-subtle text-success' : 'bg-primary-subtle text-primary'; $typeLabel = $record->user_type == 1 ? __('admin.pages.common.client') : __('admin.pages.common.provider'); $activationClass = $record->is_activate == 1 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'; $activationLabel = $record->is_activate == 1 ? __('admin.pages.common.active') : __('admin.pages.common.inactive'); @endphp <tr class="text-center"><td class="fw-semibold">#{{ $record->id }}</td><td class="fw-semibold">{{ $record->name }}</td><td><img src="{{ asset($record->img) }}" alt="record image" class="img-fluid rounded-4" width="72" style="height:72px; object-fit:cover;"></td><td>{{ $record->mobile }}</td><td>{{ $record->email }}</td><td><span class="badge {{ $typeClass }}">{{ $typeLabel }}</span></td><td><span class="badge {{ $activationClass }}">{{ $activationLabel }}</span></td><td><div class="dropdown d-inline-block"><button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill align-middle"></i></button><ul class="dropdown-menu dropdown-menu-end" style="text-align: end;"><li><a href="{{ route('admin/users/edit', $record->id) }}" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> {{ __('admin.pages.common.edit') }}</a></li><li><button class="dropdown-item edit-item-btn show-user" data-bs-toggle="modal" data-bs-target="#userShowModal" data-id="{{ $record->id }}" data-name="{{ $record->name }}" data-email="{{ $record->email }}" data-mobile="{{ $record->mobile }}" data-user-type="{{ $record->user_type }}" data-tax="{{ $record->tax_number }}" data-branch="{{ $record->branch }}" data-cr-number="{{ $record->cr_number }}" data-cr-doc="{{ $record->cr_document ? asset($record->cr_document) : '' }}" data-location="{{ $record->location }}" data-img="{{ $record->img ? asset($record->img) : '' }}"><i class="ri-eye-line align-bottom me-2 text-muted"></i> {{ __('admin.pages.common.show') }}</button></li><li><button class="dropdown-item edit-item-btn openActivationFrom" data-bs-toggle="modal" data-bs-target="#myModalActivation" data-id="{{ $record->id }}"><i class="ri-loop-left-line align-bottom me-2 text-muted"></i> {{ __('admin.pages.common.activation') }}</button></li><li><button class="dropdown-item remove-item-btn openDeleteFrom" data-bs-toggle="modal" data-bs-target="#myModalDelete" data-id="{{ $record->id }}"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> {{ __('admin.pages.common.delete') }}</button></li></ul></div></td></tr> @endforeach @endisset</tbody></table></div><div class="d-flex justify-content-center mt-4"><nav aria-label="Page navigation"><ul class="pagination flex-wrap justify-content-center align-items-center">@if (!$users->onFirstPage())<li class="page-item mt-1"><a class="page-link" href="{{ $users->previousPageUrl() }}" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>@endif @for ($i = 1; $i <= $users->lastPage(); $i++)<li class="page-item mt-1 {{ $i == $users->currentPage() ? 'active' : '' }}"><a class="page-link" href="{{ $users->url($i) }}" @if ($i == $users->currentPage()) style="font-weight:bold;" @endif>{{ $i }}</a></li>@endfor @if ($users->hasMorePages())<li class="page-item mt-1"><a class="page-link" href="{{ $users->nextPageUrl() }}" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>@endif</ul></nav></div><div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabell" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title f-w-600" id="exampleModalLabell"></h5></div><div class="modal-body text-center p-5"><form role="form" action="{{url(route('admin/users/delete'))}}" method="post">{{ csrf_field() }}<lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f7b84b,secondary:#405189" style="width:130px;height:130px"></lord-icon><div class="mt-4 pt-4"><h4>{{ __('admin.pages.common.confirm_delete') }}</h4><p class="text-muted">{{ __('admin.pages.common.confirm_delete_message') }}</p><input id="delete_record_id" name="record_id" type="hidden"><button type="submit" class="btn btn-warning">{{ __('admin.pages.common.continue') }}</button></div></form></div></div></div></div><div class="modal fade" id="myModalActivation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title f-w-600" id="exampleModalLabel"></h5></div><div class="modal-body text-center p-5"><form role="form" action="{{url(route('admin/users/activate'))}}" method="post">{{ csrf_field() }}<lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f7b84b,secondary:#405189" style="width:130px;height:130px"></lord-icon><div class="mt-4 pt-4"><h4>{{ __('admin.pages.common.confirm_activate') }}</h4><p class="text-muted">{{ __('admin.pages.common.confirm_activate_message') }}</p><input id="activation_record_id" name="record_id" type="hidden"><button type="submit" class="btn btn-warning">{{ __('admin.pages.common.continue') }}</button></div></form></div></div></div></div><div class="modal fade" id="userShowModal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-dialog-centered modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title fw-bold">{{ __('admin.pages.common.details') }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('admin.pages.common.close') }}"></button></div><div class="modal-body" dir="ltr"><div class="row g-4 align-items-center"><div class="col-md-3 text-center"><img id="uAvatar" class="rounded-circle shadow-sm d-none" style="width:96px;height:96px;object-fit:cover" src="" alt=""></div><div class="col-md-9"><div class="text-muted small mt-1">{{ __('admin.pages.common.id') }}: <span id="uId">-</span></div><div class="d-flex flex-wrap gap-2 align-items-center"><h4 class="m-0" id="uName">-</h4><span id="uTypeBadge" class="badge rounded-pill px-3 py-2"></span></div></div></div><hr class="my-4"><div class="row g-3"><div class="col-md-6"><ul class="list-group small shadow-sm rounded-3" style="padding: 0;"><li class="list-group-item d-flex justify-content-between"><span class="text-muted">{{ __('admin.pages.common.email') }}</span><span id="uEmail" class="fw-semibold">-</span></li><li class="list-group-item d-flex justify-content-between"><span class="text-muted">{{ __('admin.pages.common.mobile') }}</span><span id="uMobile" class="fw-semibold">-</span></li><li class="list-group-item d-flex justify-content-between"><span class="text-muted">{{ __('admin.pages.common.branch') }}</span><span id="uBranch" class="fw-semibold">-</span></li><li class="list-group-item d-flex justify-content-between"><span class="text-muted">{{ __('admin.pages.common.location') }}</span><span id="uLocation" class="fw-semibold">-</span></li></ul></div><div class="col-md-6"><ul class="list-group small shadow-sm rounded-3" style="padding: 0;"><li class="list-group-item d-flex justify-content-between"><span class="text-muted">{{ __('admin.pages.common.tax_number') }}</span><span id="uTax" class="fw-semibold">-</span></li><li class="list-group-item d-flex justify-content-between"><span class="text-muted">{{ __('admin.pages.common.cr_number') }}</span><span id="uCrNumber" class="fw-semibold">-</span></li><li class="list-group-item d-flex justify-content-between"><span class="text-muted">{{ __('admin.pages.common.cr_document') }}</span><a id="uCrDocLink" href="#" target="_blank" class="fw-semibold text-decoration-none">{{ __('admin.pages.common.open_file') }}</a></li></ul></div></div></div><div class="modal-footer"><button class="btn btn-light" data-bs-dismiss="modal">{{ __('admin.pages.common.close') }}</button></div></div></div></div></div></div></div></div>
@endsection

@section('script')
<script>
    $(document).on('click', '.openDeleteFrom', function() { $('#delete_record_id').val($(this).attr('data-id')); });
    $(document).on('click', '.openActivationFrom', function() { $('#activation_record_id').val($(this).attr('data-id')); });
    var userTypeLabels = {
        client: @json(__('admin.pages.common.client')),
        provider: @json(__('admin.pages.common.provider')),
        undefined: @json(__('admin.pages.common.undefined'))
    };
    $('#userShowModal').on('show.bs.modal', function (e) { var $m = $(this); var $btn = $(e.relatedTarget); var id = $btn.data('id') || '-'; var name = $btn.data('name') || '-'; var email = $btn.data('email') || '-'; var mobile = $btn.data('mobile') || '-'; var type = String($btn.data('user-type') || ''); var tax = $btn.data('tax') || '-'; var branch = $btn.data('branch') || '-'; var crNum = $btn.data('cr-number') || '-'; var crDoc = $btn.data('cr-doc') || ''; var location = $btn.data('location') || '-'; var img = $btn.data('img') || ''; $m.find('#uId').text(id); $m.find('#uName').text(name); $m.find('#uEmail').text(email); $m.find('#uMobile').text(mobile); $m.find('#uBranch').text(branch); $m.find('#uLocation').text(location); $m.find('#uTax').text(tax); $m.find('#uCrNumber').text(crNum); var $avatar = $m.find('#uAvatar'); if (img) { $avatar.attr('src', img).removeClass('d-none'); } else { $avatar.attr('src', '').addClass('d-none'); } var $badge = $m.find('#uTypeBadge').removeClass().addClass('badge rounded-pill px-3 py-2'); if (type === '1') { $badge.addClass('bg-success-subtle text-success').text(userTypeLabels.client); } else if (type === '2') { $badge.addClass('bg-primary-subtle text-primary').text(userTypeLabels.provider); } else { $badge.addClass('bg-secondary-subtle text-secondary-emphasis').text(userTypeLabels.undefined); } var $crLink = $m.find('#uCrDocLink'); if (crDoc) { $crLink.attr('href', crDoc).removeClass('disabled'); } else { $crLink.attr('href', '#').addClass('disabled'); } });
</script>
@endsection
