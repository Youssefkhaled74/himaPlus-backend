```blade
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
        transition: all .2s ease;
    }

    .policy-item:hover {
        border-color: rgba(11, 99, 206, .25);
        box-shadow: 0 12px 28px rgba(15, 23, 42, .06);
        transform: translateY(-2px);
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

    .policy-item h3 {
        color: #0f172a;
        line-height: 1.5;
    }

    .text-white-75 {
        color: rgba(255, 255, 255, .78);
    }

    @media (max-width: 576px) {
        .policy-item {
            padding: 1rem;
        }

        .policy-index {
            width: 36px;
            height: 36px;
            font-size: 14px;
        }

        .policy-body {
            font-size: 14px;
        }
    }
</style>
@endsection

@section('content')
@php
    $isAr = app()->getLocale() === 'ar';

    $defaultPrivacyPolicies = [
        [
            'head' => 'مقدمة',
            'body' => 'توضح سياسة الخصوصية هذه كيفية قيام منصة هيما بجمع واستخدام وحماية بيانات المستخدمين عند استخدام الموقع أو الخدمات المرتبطة به، بما في ذلك تصفح المنتجات الطبية، إنشاء الطلبات، طلب عروض الأسعار، طلب خدمات الصيانة، والتواصل مع الموردين.',
        ],
        [
            'head' => 'البيانات التي نقوم بجمعها',
            'body' => 'قد نقوم بجمع بعض البيانات الأساسية مثل الاسم، رقم الجوال، البريد الإلكتروني، العنوان، نوع الحساب، بيانات الشركة أو المنشأة، بيانات الطلبات، تفاصيل المنتجات المطلوبة، الملاحظات، المرفقات، وبيانات الدفع اللازمة لإتمام العمليات داخل المنصة.',
        ],
        [
            'head' => 'استخدام البيانات',
            'body' => 'نستخدم البيانات لتقديم خدمات المنصة بشكل صحيح، مثل إنشاء الحسابات، معالجة الطلبات، إرسال طلبات عروض الأسعار إلى الموردين، متابعة حالات الطلبات، تنظيم مواعيد الصيانة، تحسين تجربة المستخدم، وتقديم الدعم الفني وخدمة العملاء.',
        ],
        [
            'head' => 'مشاركة البيانات مع الموردين',
            'body' => 'عند قيام المستخدم بإنشاء طلب شراء أو طلب عرض سعر أو طلب صيانة، قد تتم مشاركة البيانات اللازمة فقط مع المورد أو مقدم الخدمة المختص، مثل بيانات الطلب، بيانات التواصل، الموقع، والمرفقات المرتبطة بالطلب، وذلك بهدف تنفيذ الخدمة المطلوبة.',
        ],
        [
            'head' => 'بيانات الدفع',
            'body' => 'قد يتم استخدام بيانات الدفع لإتمام عمليات الشراء أو الفواتير أو المدفوعات المرتبطة بالطلبات. لا تقوم منصة هيما بتخزين بيانات البطاقات البنكية الحساسة، ويتم التعامل مع عمليات الدفع من خلال مزودي دفع آمنين ومعتمدين عند توفر ذلك.',
        ],
        [
            'head' => 'المرفقات والملفات',
            'body' => 'قد يسمح النظام للمستخدمين بإرفاق ملفات أو صور مرتبطة بطلبات عروض الأسعار أو الصيانة أو إثباتات الاستلام. يتم استخدام هذه الملفات فقط لمعالجة الطلبات وتحسين دقة الخدمة بين العميل والمورد.',
        ],
        [
            'head' => 'حماية البيانات',
            'body' => 'نلتزم باتخاذ الإجراءات الفنية والتنظيمية المناسبة لحماية بيانات المستخدمين من الوصول غير المصرح به أو الفقدان أو التعديل أو الاستخدام غير المشروع، مع مراعاة أن أي نظام إلكتروني لا يمكن ضمان حمايته بنسبة مطلقة.',
        ],
        [
            'head' => 'صلاحيات الوصول',
            'body' => 'يتم منح صلاحيات الوصول إلى البيانات حسب نوع الحساب والدور داخل المنصة، مثل العميل أو المورد أو مدير النظام. ولا يتم إتاحة البيانات إلا للأطراف التي تحتاج إليها لتنفيذ الخدمة أو إدارة العمليات.',
        ],
        [
            'head' => 'الإشعارات والتواصل',
            'body' => 'قد تستخدم منصة هيما بيانات التواصل لإرسال إشعارات متعلقة بالطلبات، العروض، المدفوعات، مواعيد الصيانة، تحديثات الحساب، أو الرسائل المهمة الخاصة باستخدام المنصة.',
        ],
        [
            'head' => 'الاحتفاظ بالبيانات',
            'body' => 'نحتفظ بالبيانات طوال الفترة اللازمة لتقديم الخدمات، إدارة العمليات، الالتزام بالمتطلبات القانونية أو المحاسبية، وحفظ سجل الطلبات والمعاملات، ما لم يطلب المستخدم حذف بياناته وفقاً للأنظمة والسياسات المعمول بها.',
        ],
        [
            'head' => 'حقوق المستخدم',
            'body' => 'يحق للمستخدم طلب تحديث بياناته الشخصية أو تصحيحها أو الاستفسار عن طريقة استخدامها. كما يمكنه التواصل مع فريق الدعم لطلب المساعدة بخصوص الحساب أو البيانات المرتبطة به.',
        ],
        [
            'head' => 'تحديث سياسة الخصوصية',
            'body' => 'قد يتم تحديث سياسة الخصوصية من وقت لآخر بما يتناسب مع تطوير خدمات المنصة أو المتطلبات النظامية. وسيتم نشر أي تحديثات على هذه الصفحة، ويعد استمرار استخدام المنصة بعد التحديث موافقة على السياسة المعدلة.',
        ],
        [
            'head' => 'التواصل معنا',
            'body' => 'في حال وجود أي استفسار بخصوص سياسة الخصوصية أو طريقة التعامل مع البيانات، يمكن التواصل مع فريق منصة هيما من خلال صفحة تواصل معنا أو عبر قنوات الدعم الرسمية المتاحة في الموقع.',
        ],
    ];

    if (!isset($privacyPolicies) || $privacyPolicies->count() === 0) {
        $privacyPolicies = collect($defaultPrivacyPolicies);
    }
@endphp

<main>
    <section class="hero-landing policy-hero">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-8 col-xl-7">
                    <span class="eyebrow text-uppercase text-white-50">
                        {{ $isAr ? 'الصفحات القانونية' : 'Legal Pages' }}
                    </span>

                    <h1 class="display-5 fw-semibold mb-3 text-white">
                        {{ $isAr ? 'سياسة الخصوصية' : 'Privacy Policy' }}
                    </h1>

                    <p class="lead text-white-75 mb-0">
                        {{ $isAr
                            ? 'توضح هذه الصفحة كيفية تعامل هيما مع بيانات المستخدمين والمعلومات التي يتم جمعها عند استخدام الموقع والخدمات المرتبطة به.'
                            : 'This page explains how Hema handles user data and the information collected when using the website and related services.' }}
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
                            <h2 class="h4 mb-2">
                                {{ $isAr ? 'بنود سياسة الخصوصية' : 'Policy Items' }}
                            </h2>

                            <p class="text-muted mb-0">
                                {{ $isAr
                                    ? 'يمكن للعملاء والموردين ومزودي الدفع مراجعة هذه الصفحة مباشرة عبر الرابط العام في الموقع.'
                                    : 'Customers, vendors, and payment providers can review this page directly through the public website link.' }}
                            </p>
                        </div>

                        @if(isset($info) && $info?->updated_at)
                            <span class="badge text-bg-light border">
                                {{ $isAr ? 'آخر تحديث' : 'Last updated' }}:
                                {{ $info->updated_at->format('Y-m-d') }}
                            </span>
                        @else
                            <span class="badge text-bg-light border">
                                {{ $isAr ? 'آخر تحديث' : 'Last updated' }}:
                                {{ now()->format('Y-m-d') }}
                            </span>
                        @endif
                    </div>

                    <div class="row g-3">
                        @forelse($privacyPolicies as $index => $policy)
                            <div class="col-12">
                                <div class="policy-item">
                                    <div class="d-flex gap-3 align-items-start">
                                        <span class="policy-index">
                                            {{ $index + 1 }}
                                        </span>

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
                                    {{ $isAr
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
```
