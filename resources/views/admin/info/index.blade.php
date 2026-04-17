@extends('layouts.admin.home')

@section('title')
    <title>{{ __('admin.pages.info.title') }}</title>
@endsection

@section('css')
    <style>
        .info-settings-card .card-header {
            border-bottom: 1px solid rgba(216, 227, 240, 0.86);
        }

        .info-tabs.nav-tabs-custom {
            gap: 8px;
            border-bottom: 0;
            padding: 0;
        }

        .info-tabs .nav-link {
            border: 1px solid #dbe7f3;
            border-radius: 12px;
            background: #fff;
            color: #2b3d58;
            font-weight: 700;
            padding: 10px 14px;
        }

        .info-tabs .nav-link.active {
            background: linear-gradient(135deg, #18326f, #0f4bbf);
            color: #fff;
            border-color: transparent;
        }

        .info-pane {
            border: 1px solid rgba(216, 227, 240, 0.86);
            border-radius: 14px;
            padding: 18px;
            background: #fff;
        }

        .info-repeater-item {
            border: 1px solid rgba(216, 227, 240, 0.86);
            border-radius: 12px;
            padding: 12px;
            background: #fbfdff;
        }

        .info-remove-btn {
            border: 0;
            border-radius: 999px;
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #fee2e2;
            color: #dc2626;
            cursor: pointer;
        }

        .info-save-wrap {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }
    </style>
@endsection

@section('content')
    @php
        $abouts = old('abouts', $info?->abouts ?? []);
        $privacyPolicies = old('privacy_policies', $info?->privacy_policies ?? []);
        $terms = old('terms', $info?->terms ?? []);
    @endphp

    <div class="page-content">
        <div class="container-fluid">
            <x-admin.page-header
                :badge="__('admin.pages.info.module_label')"
                :title="__('admin.pages.info.title')"
                :description="__('admin.pages.info.description')"
                :breadcrumbs="[
                    ['label' => __('admin.pages.common.home'), 'href' => route('admin/index')],
                    ['label' => __('admin.nav.platform_info'), 'href' => route('admin/info/index') . '/0/' . PAGINATION_COUNT],
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

            <div class="card admin-content-card info-settings-card">
                <div class="card-header">
                    <div class="admin-card-head">
                        <div class="admin-card-head__copy">
                            <span class="admin-card-head__eyebrow">{{ __('admin.pages.info.module_label') }}</span>
                            <h5 class="admin-card-head__title">{{ __('admin.pages.info.overview') }}</h5>
                            <p class="admin-card-head__text">{{ __('admin.pages.info.overview_subtitle') }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ url(route('admin/info/update', $info?->id ?? 1)) }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <ul class="nav nav-tabs-custom info-tabs mb-4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#general-info" role="tab">{{ __('admin.pages.info.tabs.general') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#abouts" role="tab">{{ __('admin.pages.info.tabs.abouts') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#privacy-policy" role="tab">{{ __('admin.pages.info.tabs.privacy') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#terms" role="tab">{{ __('admin.pages.info.tabs.terms') }}</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="general-info" role="tabpanel">
                                <div class="info-pane">
                                    <div class="row gy-4">
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="mobile" value="{{ old('mobile', $info?->mobile) }}" type="text" class="form-control" id="mobilefloatingInput" placeholder="mobile">
                                                <label for="mobilefloatingInput">{{ __('admin.pages.common.mobile') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="email" value="{{ old('email', $info?->email) }}" type="text" class="form-control" id="emailfloatingInput" placeholder="email">
                                                <label for="emailfloatingInput">{{ __('admin.pages.common.email') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="location" value="{{ old('location', $info?->location) }}" type="text" class="form-control" id="locationfloatingInput" placeholder="location">
                                                <label for="locationfloatingInput">{{ __('admin.pages.common.location') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="facebook" value="{{ old('facebook', $info?->facebook) }}" type="text" class="form-control" id="facebookfloatingInput" placeholder="facebook">
                                                <label for="facebookfloatingInput">{{ __('admin.pages.info.facebook') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="instagram" value="{{ old('instagram', $info?->instagram) }}" type="text" class="form-control" id="instagramfloatingInput" placeholder="instagram">
                                                <label for="instagramfloatingInput">{{ __('admin.pages.info.instagram') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="twitter" value="{{ old('twitter', $info?->twitter) }}" type="text" class="form-control" id="twitterfloatingInput" placeholder="twitter">
                                                <label for="twitterfloatingInput">{{ __('admin.pages.info.twitter') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="snapchat" value="{{ old('snapchat', $info?->snapchat) }}" type="text" class="form-control" id="snapchatfloatingInput" placeholder="snapchat">
                                                <label for="snapchatfloatingInput">{{ __('admin.pages.info.snapchat') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="tiktok" value="{{ old('tiktok', $info?->tiktok) }}" type="text" class="form-control" id="tiktokfloatingInput" placeholder="tiktok">
                                                <label for="tiktokfloatingInput">{{ __('admin.pages.info.tiktok') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="form-floating">
                                                <input name="vat" value="{{ old('vat', $info?->vat) }}" type="text" class="form-control" id="vatfloatingInput" placeholder="vat">
                                                <label for="vatfloatingInput">{{ __('admin.pages.info.vat') }} <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="abouts" role="tabpanel">
                                <div class="info-pane">
                                    <div class="mb-3">
                                        <button class="btn btn-primary" id="add-input-info-abouts" type="button"><i class="bx bx-plus"></i> {{ __('admin.pages.info.add_about_item') }}</button>
                                    </div>
                                    <div id="info-abouts-area">
                                        @foreach ($abouts as $index => $record)
                                            <div class="info-repeater-item input-container input-container-{{ $index }} mb-3">
                                                <div class="row g-3 align-items-end">
                                                    <div class="col-xxl-4 col-md-4">
                                                        <label class="form-label">{{ __('admin.pages.info.field_title') }} <span class="text-danger">*</span></label>
                                                        <input name="abouts[{{ $index }}][head]" value="{{ $record['head'] ?? '' }}" type="text" class="form-control" placeholder="{{ __('admin.pages.info.about_title_placeholder') }}">
                                                    </div>
                                                    <div class="col-xxl-7 col-md-7">
                                                        <label class="form-label">{{ __('admin.pages.info.field_content') }} <span class="text-danger">*</span></label>
                                                        <input name="abouts[{{ $index }}][body]" value="{{ $record['body'] ?? '' }}" type="text" class="form-control" placeholder="{{ __('admin.pages.info.about_content_placeholder') }}">
                                                    </div>
                                                    <div class="col-xxl-1 col-md-1 d-flex justify-content-end">
                                                        <button type="button" class="info-remove-btn remove-btn" parent-class="input-container-{{ $index }}"><i class="bx bx-trash"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="privacy-policy" role="tabpanel">
                                <div class="info-pane">
                                    <div class="mb-3">
                                        <button class="btn btn-primary" id="add-input-info-privacy-policy" type="button"><i class="bx bx-plus"></i> {{ __('admin.pages.info.add_policy_item') }}</button>
                                    </div>
                                    <div id="info-privacy-policy-area">
                                        @foreach ($privacyPolicies as $index => $record)
                                            <div class="info-repeater-item input-container input-container-privacy-{{ $index }} mb-3">
                                                <div class="row g-3 align-items-end">
                                                    <div class="col-xxl-4 col-md-4">
                                                        <label class="form-label">{{ __('admin.pages.info.field_title') }} <span class="text-danger">*</span></label>
                                                        <input name="privacy_policies[{{ $index }}][head]" value="{{ $record['head'] ?? '' }}" type="text" class="form-control" placeholder="{{ __('admin.pages.info.policy_title_placeholder') }}">
                                                    </div>
                                                    <div class="col-xxl-7 col-md-7">
                                                        <label class="form-label">{{ __('admin.pages.info.field_content') }} <span class="text-danger">*</span></label>
                                                        <input name="privacy_policies[{{ $index }}][body]" value="{{ $record['body'] ?? '' }}" type="text" class="form-control" placeholder="{{ __('admin.pages.info.policy_content_placeholder') }}">
                                                    </div>
                                                    <div class="col-xxl-1 col-md-1 d-flex justify-content-end">
                                                        <button type="button" class="info-remove-btn remove-btn" parent-class="input-container-privacy-{{ $index }}"><i class="bx bx-trash"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="terms" role="tabpanel">
                                <div class="info-pane">
                                    <div class="mb-3">
                                        <button class="btn btn-primary" id="add-input-info-terms" type="button"><i class="bx bx-plus"></i> {{ __('admin.pages.info.add_term_item') }}</button>
                                    </div>
                                    <div id="info-terms-area">
                                        @foreach ($terms as $index => $record)
                                            <div class="info-repeater-item input-container input-container-terms-{{ $index }} mb-3">
                                                <div class="row g-3 align-items-end">
                                                    <div class="col-xxl-4 col-md-4">
                                                        <label class="form-label">{{ __('admin.pages.info.field_title') }} <span class="text-danger">*</span></label>
                                                        <input name="terms[{{ $index }}][head]" value="{{ $record['head'] ?? '' }}" type="text" class="form-control" placeholder="{{ __('admin.pages.info.term_title_placeholder') }}">
                                                    </div>
                                                    <div class="col-xxl-7 col-md-7">
                                                        <label class="form-label">{{ __('admin.pages.info.field_content') }} <span class="text-danger">*</span></label>
                                                        <input name="terms[{{ $index }}][body]" value="{{ $record['body'] ?? '' }}" type="text" class="form-control" placeholder="{{ __('admin.pages.info.term_content_placeholder') }}">
                                                    </div>
                                                    <div class="col-xxl-1 col-md-1 d-flex justify-content-end">
                                                        <button type="button" class="info-remove-btn remove-btn" parent-class="input-container-terms-{{ $index }}"><i class="bx bx-trash"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="info-save-wrap">
                            <button class="btn btn-primary" type="submit">{{ __('admin.pages.common.save_changes') }}</button>
                        </div>
                    </form>
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
        const infoI18n = {
            title: @json(__('admin.pages.info.field_title')),
            content: @json(__('admin.pages.info.field_content')),
            aboutTitle: @json(__('admin.pages.info.about_title_placeholder')),
            aboutContent: @json(__('admin.pages.info.about_content_placeholder')),
            policyTitle: @json(__('admin.pages.info.policy_title_placeholder')),
            policyContent: @json(__('admin.pages.info.policy_content_placeholder')),
            termTitle: @json(__('admin.pages.info.term_title_placeholder')),
            termContent: @json(__('admin.pages.info.term_content_placeholder')),
        };

        $('#add-input-info-abouts').click(function () {
            inputCountInfoAbouts++;
            $('#info-abouts-area').append(`
                <div class="info-repeater-item input-container input-container-${inputCountInfoAbouts} mb-3">
                    <div class="row g-3 align-items-end">
                        <div class="col-xxl-4 col-md-4">
                            <label class="form-label">${infoI18n.title} <span class="text-danger">*</span></label>
                            <input name="abouts[${inputCountInfoAbouts}][head]" type="text" class="form-control" placeholder="${infoI18n.aboutTitle}">
                        </div>
                        <div class="col-xxl-7 col-md-7">
                            <label class="form-label">${infoI18n.content} <span class="text-danger">*</span></label>
                            <input name="abouts[${inputCountInfoAbouts}][body]" type="text" class="form-control" placeholder="${infoI18n.aboutContent}">
                        </div>
                        <div class="col-xxl-1 col-md-1 d-flex justify-content-end">
                            <button type="button" class="info-remove-btn remove-btn" parent-class="input-container-${inputCountInfoAbouts}"><i class="bx bx-trash"></i></button>
                        </div>
                    </div>
                </div>
            `);
        });

        $('#add-input-info-privacy-policy').click(function () {
            inputCountInfoPrivacyPolicy++;
            $('#info-privacy-policy-area').append(`
                <div class="info-repeater-item input-container input-container-privacy-${inputCountInfoPrivacyPolicy} mb-3">
                    <div class="row g-3 align-items-end">
                        <div class="col-xxl-4 col-md-4">
                            <label class="form-label">${infoI18n.title} <span class="text-danger">*</span></label>
                            <input name="privacy_policies[${inputCountInfoPrivacyPolicy}][head]" type="text" class="form-control" placeholder="${infoI18n.policyTitle}">
                        </div>
                        <div class="col-xxl-7 col-md-7">
                            <label class="form-label">${infoI18n.content} <span class="text-danger">*</span></label>
                            <input name="privacy_policies[${inputCountInfoPrivacyPolicy}][body]" type="text" class="form-control" placeholder="${infoI18n.policyContent}">
                        </div>
                        <div class="col-xxl-1 col-md-1 d-flex justify-content-end">
                            <button type="button" class="info-remove-btn remove-btn" parent-class="input-container-privacy-${inputCountInfoPrivacyPolicy}"><i class="bx bx-trash"></i></button>
                        </div>
                    </div>
                </div>
            `);
        });

        $('#add-input-info-terms').click(function () {
            inputCountInfoTerms++;
            $('#info-terms-area').append(`
                <div class="info-repeater-item input-container input-container-terms-${inputCountInfoTerms} mb-3">
                    <div class="row g-3 align-items-end">
                        <div class="col-xxl-4 col-md-4">
                            <label class="form-label">${infoI18n.title} <span class="text-danger">*</span></label>
                            <input name="terms[${inputCountInfoTerms}][head]" type="text" class="form-control" placeholder="${infoI18n.termTitle}">
                        </div>
                        <div class="col-xxl-7 col-md-7">
                            <label class="form-label">${infoI18n.content} <span class="text-danger">*</span></label>
                            <input name="terms[${inputCountInfoTerms}][body]" type="text" class="form-control" placeholder="${infoI18n.termContent}">
                        </div>
                        <div class="col-xxl-1 col-md-1 d-flex justify-content-end">
                            <button type="button" class="info-remove-btn remove-btn" parent-class="input-container-terms-${inputCountInfoTerms}"><i class="bx bx-trash"></i></button>
                        </div>
                    </div>
                </div>
            `);
        });

        $(document).on('click', '.remove-btn', function () {
            const parentClass = $(this).attr('parent-class');
            $('.' + parentClass).remove();
        });
    </script>
@endsection
