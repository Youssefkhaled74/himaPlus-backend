@extends('layouts.admin.home')

@section('title')
    <title>{{ __('admin.pages.contacts.title') }}</title>
@endsection

@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent" style="direction: ltr;">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('admin/index')}}">{{ __('admin.pages.common.home') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{route('admin/contacts/index')}}/0/{{PAGINATION_COUNT}}">{{ __('admin.nav.contacts') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('admin.pages.common.update') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            @include('flash::message')
            @if ($errors->any())
                <div style="text-align: left; margin: 15px;">
                    <ul dir="ltr">
                        @foreach ($errors->all() as $error)
                            <li class="text-danger">{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">{{ trans_or_fallback('', '') }}</h4>
                        </div>
                        <div class="card-body">
                            @isset($contact)
                                <form role="form" action="{{ route('admin/contacts/update', $contact->id) }}" method="post">
                                    @csrf
                                    <div class="row gy-4">
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="mobile" type="text" class="form-control" id="mobilefloatingInput" placeholder="mobile" value="{{ old('mobile', $contact->mobile) }}">
                                                <label for="mobilefloatingInput">{{ __('admin.pages.common.mobile') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="email" type="email" class="form-control" id="emailfloatingInput" placeholder="email" value="{{ old('email', $contact->email) }}">
                                                <label for="emailfloatingInput">{{ __('admin.pages.common.email') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="location" type="text" class="form-control" id="locationfloatingInput" placeholder="location" value="{{ old('location', $contact->location) }}">
                                                <label for="locationfloatingInput">{{ __('admin.pages.common.location') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="detailsTextarea">{{ __('admin.pages.common.details') }}</label>
                                                <textarea name="details" id="detailsTextarea" class="form-control" rows="5">{{ old('details', $contact->details) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">{{ __('admin.pages.common.save_changes') }}</button>
                                        </div>
                                    </div>
                                </form>
                            @endisset
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
        $('.sidebarcontacts').addClass('active');
        var target = $('.sidebarcontacts').attr('href');
        $(target).addClass('show');
    })();
</script>
@endsection

