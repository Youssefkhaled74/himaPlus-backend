@extends('layouts.front.home')

@section('title')
    <title>{{ app()->getLocale() === 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy' }}</title>
@endsection

@section('css')
<style>
    .policy-hero {
        background: linear-gradient(135deg, rgba(11,99,206,.96), rgba(39,125,108,.96));
    }
    .policy-card {
        border: 0;
        border-radius: 22px;
        box-shadow: 0 16px 40px rgba(15, 23, 42, .08);
    }
    .policy-item {
        border: 1px solid rgba(148, 163, 184, .2);
        border-radius: 18px;
        padding: 1.25rem 1.4rem;
        background: #fff;
        height: 100%;
    }
    .policy-index {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(11,99,206,.12);
        color: #0b63ce;
        font-weight: 700;
        flex-shrink: 0;
    }
    .policy-body {
        color: #64748b;
        line-height: 1.85;
        margin: 0;
    }
</style>
@endsection

@section('content')
    <main>
        <section class="hero-landing policy-hero">
            <div class="container position-relative">
                <div class="row align-items-center">
                    <div class="col-lg-8 col-xl-7">
                        <span class="eyebrow text-uppercase text-white-50">
                            {{ app()->getLocale() === 'ar' ? 'الصفحات القانونية' : 'Legal Pages' }}
                        </span>
                        <h1 class="display-5 fw-semibold mb-3 text-white">
                            {{ app()->getLocale() === 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy' }}
                        </h1>
                        <p class="lead text-white-75 mb-0">
                            {{ app()->getLocale() === 'ar'
                                ? 'توضح هذه الصفحة كيفية تعامل هيما مع بيانات المستخدمين والمعلومات التي يتم جمعها عند استخدام الموقع.'
                                : 'This page explains how Hema handles user data and the information collected when using the website.' }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-padding">
            <div class="container">
                <div class="card policy-card">
                    <div class="card-body p-4 p-lg-5">
                        <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-4">
                            <div>
                                <h2 class="h4 mb-2">{{ app()->getLocale() === 'ar' ? 'بنود سياسة الخصوصية' : 'Policy Items' }}</h2>
                                <p class="text-muted mb-0">
                                    {{ app()->getLocale() === 'ar'
                                        ? 'يمكن لشركة مدفوعات مراجعة هذه الصفحة مباشرة عبر الرابط العام في الموقع.'
                                        : 'Payment providers can review this page directly through the public website link.' }}
                                </p>
                            </div>
                            @if($info?->updated_at)
                                <span class="badge text-bg-light border">
                                    {{ app()->getLocale() === 'ar' ? 'آخر تحديث' : 'Last updated' }}: {{ $info->updated_at->format('Y-m-d') }}
                                </span>
                            @endif
                        </div>

                        <div class="row g-3">
                            @forelse($privacyPolicies as $index => $policy)
                                <div class="col-12">
                                    <div class="policy-item">
                                        <div class="d-flex gap-3 align-items-start">
                                            <span class="policy-index">{{ $index + 1 }}</span>
                                            <div class="flex-grow-1">
                                                <h3 class="h6 fw-bold mb-2">
                                                    {{ $policy['head'] ?? ($policy->head ?? '') }}
                                                </h3>
                                                <p class="policy-body">
                                                    {{ $policy['body'] ?? ($policy->body ?? '') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-info mb-0">
                                        {{ app()->getLocale() === 'ar'
                                            ? 'لم يتم إضافة بنود سياسة الخصوصية بعد.'
                                            : 'No privacy policy items have been added yet.' }}
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('script')
<script>
    $(function () {
        $('body').attr('data-page', 'privacy-policy');
    });
</script>
@endsection
