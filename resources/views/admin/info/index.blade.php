@extends('layouts.admin.home')

@section('title')
    <title>Info</title>
@endsection

@section('css')
@endsection

@section('content')
    @php
        $abouts = old('abouts', $info?->abouts ?? []);
        $privacyPolicies = old('privacy_policies', $info?->privacy_policies ?? []);
        $terms = old('terms', $info?->terms ?? []);
    @endphp

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent" style="direction: ltr;">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin/index') }}">Home</a></li>
                                <li class="breadcrumb-item active"><a href="{{ route('admin/info/index') }}/0/{{ PAGINATION_COUNT }}">Info</a></li>
                                <li class="active" style="color: var(--vz-breadcrumb-item-active-color);">Index</li>
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
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Info Settings</h5>
                        </div>
                        <div class="card-body">
                            <form role="form" action="{{ url(route('admin/info/update', $info?->id ?? 1)) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card mt-xxl-n5 mb-0 shadow-none border-0">
                                    <div class="card-header">
                                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#general-info" role="tab">
                                                    <i class="fas fa-home"></i> General Data
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#abouts" role="tab">
                                                    <i class="far fa-user"></i> About Us
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#privacy-policy" role="tab">
                                                    <i class="far fa-user"></i> Privacy Policy
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#terms" role="tab">
                                                    <i class="far fa-user"></i> Terms
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="general-info" role="tabpanel">
                                                <div class="row gy-4">
                                                    <div class="col-xxl-6 col-md-6">
                                                        <div class="form-floating">
                                                            <input name="mobile" value="{{ old('mobile', $info?->mobile) }}" type="text" class="form-control" id="mobilefloatingInput" placeholder="mobile">
                                                            <label for="mobilefloatingInput">Mobile <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-6 col-md-6">
                                                        <div class="form-floating">
                                                            <input name="email" value="{{ old('email', $info?->email) }}" type="text" class="form-control" id="emailfloatingInput" placeholder="email">
                                                            <label for="emailfloatingInput">Email <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-6 col-md-6">
                                                        <div class="form-floating">
                                                            <input name="location" value="{{ old('location', $info?->location) }}" type="text" class="form-control" id="locationfloatingInput" placeholder="location">
                                                            <label for="locationfloatingInput">Location <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-6 col-md-6">
                                                        <div class="form-floating">
                                                            <input name="facebook" value="{{ old('facebook', $info?->facebook) }}" type="text" class="form-control" id="facebookfloatingInput" placeholder="facebook">
                                                            <label for="facebookfloatingInput">Facebook <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-6 col-md-6">
                                                        <div class="form-floating">
                                                            <input name="instagram" value="{{ old('instagram', $info?->instagram) }}" type="text" class="form-control" id="instagramfloatingInput" placeholder="instagram">
                                                            <label for="instagramfloatingInput">Instagram <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-6 col-md-6">
                                                        <div class="form-floating">
                                                            <input name="twitter" value="{{ old('twitter', $info?->twitter) }}" type="text" class="form-control" id="twitterfloatingInput" placeholder="twitter">
                                                            <label for="twitterfloatingInput">Twitter <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-6 col-md-6">
                                                        <div class="form-floating">
                                                            <input name="snapchat" value="{{ old('snapchat', $info?->snapchat) }}" type="text" class="form-control" id="snapchatfloatingInput" placeholder="snapchat">
                                                            <label for="snapchatfloatingInput">Snapchat <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-6 col-md-6">
                                                        <div class="form-floating">
                                                            <input name="tiktok" value="{{ old('tiktok', $info?->tiktok) }}" type="text" class="form-control" id="tiktokfloatingInput" placeholder="tiktok">
                                                            <label for="tiktokfloatingInput">TikTok <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-6 col-md-6">
                                                        <div class="form-floating">
                                                            <input name="vat" value="{{ old('vat', $info?->vat) }}" type="text" class="form-control" id="vatfloatingInput" placeholder="vat">
                                                            <label for="vatfloatingInput">VAT <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="abouts" role="tabpanel">
                                                <div class="row gy-4">
                                                    <div class="col-12">
                                                        <button class="btn btn-primary mb-3" id="add-input-info-abouts" type="button"><i class="bx bx-plus"></i> Add About Item</button>
                                                    </div>
                                                    <div id="info-abouts-area">
                                                        @foreach ($abouts as $index => $record)
                                                            <div class="input-container input-container-{{ $index }} mb-3">
                                                                <div class="row">
                                                                    <div class="col-xxl-4 col-md-4">
                                                                        <div class="form-group">
                                                                            <label style="margin-bottom: 0px;" for="">Title <span class="text-danger">*</span></label><br/>
                                                                            <input name="abouts[{{ $index }}][head]" value="{{ $record['head'] ?? '' }}" type="text" class="form-control" placeholder="About title">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xxl-6 col-md-6">
                                                                        <div class="form-group">
                                                                            <label style="margin-bottom: 0px;" for="">Content <span class="text-danger">*</span></label><br/>
                                                                            <input name="abouts[{{ $index }}][body]" value="{{ $record['body'] ?? '' }}" type="text" class="form-control" placeholder="About content">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xxl-2 col-md-2">
                                                                        <label for="" class="mb-2"></label>
                                                                        <span class="remove-btn badge bg-danger rounded-pill mt-4" parent-class="input-container-{{ $index }}"><i class="bx bx-trash"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="privacy-policy" role="tabpanel">
                                                <div class="row gy-4">
                                                    <div class="col-12">
                                                        <button class="btn btn-primary mb-3" id="add-input-info-privacy-policy" type="button"><i class="bx bx-plus"></i> Add Policy Item</button>
                                                    </div>
                                                    <div id="info-privacy-policy-area">
                                                        @foreach ($privacyPolicies as $index => $record)
                                                            <div class="input-container input-container-privacy-{{ $index }} mb-3">
                                                                <div class="row">
                                                                    <div class="col-xxl-4 col-md-4">
                                                                        <div class="form-group">
                                                                            <label style="margin-bottom: 0px;" for="">Title <span class="text-danger">*</span></label><br/>
                                                                            <input name="privacy_policies[{{ $index }}][head]" value="{{ $record['head'] ?? '' }}" type="text" class="form-control" placeholder="Policy title">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xxl-6 col-md-6">
                                                                        <div class="form-group">
                                                                            <label style="margin-bottom: 0px;" for="">Content <span class="text-danger">*</span></label><br/>
                                                                            <input name="privacy_policies[{{ $index }}][body]" value="{{ $record['body'] ?? '' }}" type="text" class="form-control" placeholder="Policy content">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xxl-2 col-md-2">
                                                                        <label for="" class="mb-2"></label>
                                                                        <span class="remove-btn badge bg-danger rounded-pill mt-4" parent-class="input-container-privacy-{{ $index }}"><i class="bx bx-trash"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="terms" role="tabpanel">
                                                <div class="row gy-4">
                                                    <div class="col-12">
                                                        <button class="btn btn-primary mb-3" id="add-input-info-terms" type="button"><i class="bx bx-plus"></i> Add Term Item</button>
                                                    </div>
                                                    <div id="info-terms-area">
                                                        @foreach ($terms as $index => $record)
                                                            <div class="input-container input-container-terms-{{ $index }} mb-3">
                                                                <div class="row">
                                                                    <div class="col-xxl-4 col-md-4">
                                                                        <div class="form-group">
                                                                            <label style="margin-bottom: 0px;" for="">Title <span class="text-danger">*</span></label><br/>
                                                                            <input name="terms[{{ $index }}][head]" value="{{ $record['head'] ?? '' }}" type="text" class="form-control" placeholder="Term title">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xxl-6 col-md-6">
                                                                        <div class="form-group">
                                                                            <label style="margin-bottom: 0px;" for="">Content <span class="text-danger">*</span></label><br/>
                                                                            <input name="terms[{{ $index }}][body]" value="{{ $record['body'] ?? '' }}" type="text" class="form-control" placeholder="Term content">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xxl-2 col-md-2">
                                                                        <label for="" class="mb-2"></label>
                                                                        <span class="remove-btn badge bg-danger rounded-pill mt-4" parent-class="input-container-terms-{{ $index }}"><i class="bx bx-trash"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12" style="direction: ltr;">
                                    <button class="btn btn-primary btn-md" style="margin-left: 22px; margin-bottom: 22px;" type="submit">Save</button>
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
            $('.sidebarinfo').addClass('active');
            var target = $('.sidebarinfo').attr('href');
            $(target).addClass('show');
        })();

        let inputCountInfoAbouts = {{ count($abouts) }};
        let inputCountInfoPrivacyPolicy = {{ count($privacyPolicies) }};
        let inputCountInfoTerms = {{ count($terms) }};

        $('#add-input-info-abouts').click(function () {
            inputCountInfoAbouts++;
            $('#info-abouts-area').append(`
                <div class="input-container input-container-${inputCountInfoAbouts} mb-3">
                    <div class="row">
                        <div class="col-xxl-4 col-md-4">
                            <div class="form-group">
                                <label style="margin-bottom: 0px;" for="">Title <span class="text-danger">*</span></label><br/>
                                <input name="abouts[${inputCountInfoAbouts}][head]" type="text" class="form-control" placeholder="About title">
                            </div>
                        </div>
                        <div class="col-xxl-6 col-md-6">
                            <div class="form-group">
                                <label style="margin-bottom: 0px;" for="">Content <span class="text-danger">*</span></label><br/>
                                <input name="abouts[${inputCountInfoAbouts}][body]" type="text" class="form-control" placeholder="About content">
                            </div>
                        </div>
                        <div class="col-xxl-2 col-md-2">
                            <label for="" class="mb-2"></label>
                            <span class="remove-btn badge bg-danger rounded-pill mt-4" parent-class="input-container-${inputCountInfoAbouts}"><i class="bx bx-trash"></i></span>
                        </div>
                    </div>
                </div>
            `);
        });

        $('#add-input-info-privacy-policy').click(function () {
            inputCountInfoPrivacyPolicy++;
            $('#info-privacy-policy-area').append(`
                <div class="input-container input-container-privacy-${inputCountInfoPrivacyPolicy} mb-3">
                    <div class="row">
                        <div class="col-xxl-4 col-md-4">
                            <div class="form-group">
                                <label style="margin-bottom: 0px;" for="">Title <span class="text-danger">*</span></label><br/>
                                <input name="privacy_policies[${inputCountInfoPrivacyPolicy}][head]" type="text" class="form-control" placeholder="Policy title">
                            </div>
                        </div>
                        <div class="col-xxl-6 col-md-6">
                            <div class="form-group">
                                <label style="margin-bottom: 0px;" for="">Content <span class="text-danger">*</span></label><br/>
                                <input name="privacy_policies[${inputCountInfoPrivacyPolicy}][body]" type="text" class="form-control" placeholder="Policy content">
                            </div>
                        </div>
                        <div class="col-xxl-2 col-md-2">
                            <label for="" class="mb-2"></label>
                            <span class="remove-btn badge bg-danger rounded-pill mt-4" parent-class="input-container-privacy-${inputCountInfoPrivacyPolicy}"><i class="bx bx-trash"></i></span>
                        </div>
                    </div>
                </div>
            `);
        });

        $('#add-input-info-terms').click(function () {
            inputCountInfoTerms++;
            $('#info-terms-area').append(`
                <div class="input-container input-container-terms-${inputCountInfoTerms} mb-3">
                    <div class="row">
                        <div class="col-xxl-4 col-md-4">
                            <div class="form-group">
                                <label style="margin-bottom: 0px;" for="">Title <span class="text-danger">*</span></label><br/>
                                <input name="terms[${inputCountInfoTerms}][head]" type="text" class="form-control" placeholder="Term title">
                            </div>
                        </div>
                        <div class="col-xxl-6 col-md-6">
                            <div class="form-group">
                                <label style="margin-bottom: 0px;" for="">Content <span class="text-danger">*</span></label><br/>
                                <input name="terms[${inputCountInfoTerms}][body]" type="text" class="form-control" placeholder="Term content">
                            </div>
                        </div>
                        <div class="col-xxl-2 col-md-2">
                            <label for="" class="mb-2"></label>
                            <span class="remove-btn badge bg-danger rounded-pill mt-4" parent-class="input-container-terms-${inputCountInfoTerms}"><i class="bx bx-trash"></i></span>
                        </div>
                    </div>
                </div>
            `);
        });

        $(document).on('click', '.remove-btn', function () {
            var parentClass = $(this).attr('parent-class');
            $('.' + parentClass).remove();
        });
    </script>
@endsection
