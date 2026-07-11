```blade
@extends('layouts.front.home')

@section('title')
    <title>{{ app()->getLocale() === 'ar' ? 'فواتير المورد' : 'Vendor Invoices' }} - Vendor | Hema</title>
@endsection

@section('css')
<style>
    .vendor-invoices {
        --vi-bg: #f5f6f8;
        --vi-card: #ffffff;
        --vi-border: #e7eaf0;
        --vi-title: #0f2f7f;
        --vi-text: #1f2937;
        --vi-muted: #6b7280;
        --vi-primary: #0f4bbf;
        --vi-accent: #0ec6a0;
        --vi-soft: #eef5ff;
        --vi-soft-2: #f4fbf9;
        --vi-success-bg: #dcfce7;
        --vi-success-text: #166534;
        --vi-warning-bg: #fff7ed;
        --vi-warning-text: #9a3412;
        --vi-scheduled-bg: #e0e7ff;
        --vi-scheduled-text: #3730a3;
        --vi-normal-bg: #ecfeff;
        --vi-normal-text: #155e75;

        max-width: 95%;
        margin: 12px auto 0;
        background: var(--vi-bg);
        padding: 8px 0 24px;
        font-family: "Poppins", "Tajawal", system-ui, -apple-system, "Segoe UI", Arial, sans-serif;
    }

    .vendor-invoices * {
        font-family: inherit;
    }

    .vi-card {
        background: var(--vi-card);
        border: 1px solid var(--vi-border);
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.04);
    }

    .vi-breadcrumb {
        font-size: 13px;
        margin-bottom: 12px;
    }

    .vi-breadcrumb a {
        text-decoration: none;
        color: #6b7280;
    }

    .vi-breadcrumb .active {
        color: var(--vi-primary);
        font-weight: 700;
    }

    .vi-hero {
        padding: 22px;
        margin-bottom: 16px;
    }

    .vi-title {
        margin: 0 0 6px;
        color: var(--vi-title);
        font-size: 34px;
        line-height: 1.08;
        font-weight: 800;
        letter-spacing: -0.01em;
    }

    .vi-subtitle {
        margin: 0;
        color: #475569;
        font-size: 16px;
        line-height: 1.55;
        max-width: 760px;
    }

    .vi-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .vi-btn-primary,
    .vi-btn-outline {
        border-radius: 10px;
        font-weight: 700;
        padding: 10px 16px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all .2s ease;
        min-height: 44px;
    }

    .vi-btn-primary {
        border: 0;
        color: #fff;
        background: linear-gradient(90deg, var(--vi-primary) 0%, var(--vi-accent) 100%);
    }

    .vi-btn-primary:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(15, 75, 191, .14);
    }

    .vi-btn-outline {
        border: 1px solid #cbd5e1;
        color: #1e3a8a;
        background: #fff;
    }

    .vi-btn-outline:hover {
        color: #1e3a8a;
        background: var(--vi-soft);
        transform: translateY(-1px);
    }

    .vi-stat {
        padding: 16px 18px;
        height: 100%;
        transition: all .2s ease;
    }

    .vi-stat:hover {
        border-color: #93c5fd;
        box-shadow: 0 4px 12px rgba(15, 75, 191, .08);
        transform: translateY(-1px);
    }

    .vi-stat-label {
        margin: 0;
        color: var(--vi-muted);
        font-size: 13px;
        font-weight: 500;
    }

    .vi-stat-value {
        margin: 8px 0 0;
        color: var(--vi-text);
        font-size: 40px;
        line-height: 1;
        font-weight: 800;
    }

    .vi-panel-head {
        border-bottom: 1px solid var(--vi-border);
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .vi-panel-title {
        margin: 0;
        color: #0f172a;
        font-size: 20px;
        font-weight: 700;
    }

    .vi-panel-subtitle {
        margin: 4px 0 0;
        color: var(--vi-muted);
        font-size: 13px;
    }

    .vi-body {
        padding: 18px;
    }

    .vi-filter-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        align-items: end;
    }

    .vi-field label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 8px;
    }

    .vi-field .form-control,
    .vi-field .form-select {
        min-height: 46px;
        border-radius: 10px;
        border-color: #d5deeb;
        box-shadow: none;
        color: #334155;
        font-weight: 600;
    }

    .vi-field .form-control:focus,
    .vi-field .form-select:focus {
        border-color: rgba(15, 75, 191, .45);
        box-shadow: 0 0 0 .18rem rgba(15, 75, 191, .08);
    }

    .vi-table-card {
        overflow: hidden;
    }

    .vi-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .vi-table {
        width: 100%;
        margin-bottom: 0;
        border-collapse: collapse;
    }

    .vi-table thead th {
        background: #f8fbff;
        color: #334155;
        font-size: 13px;
        font-weight: 800;
        white-space: nowrap;
        padding: 14px 16px;
        border-bottom: 1px solid var(--vi-border);
        text-align: start;
    }

    .vi-table tbody td {
        color: #111827;
        font-size: 14px;
        vertical-align: middle;
        padding: 15px 16px;
        border-bottom: 1px solid #edf2f7;
        white-space: nowrap;
    }

    .vi-table tbody tr:hover td {
        background: #f8fbff;
    }

    .vi-order-link {
        color: var(--vi-primary);
        text-decoration: none;
        font-weight: 800;
    }

    .vi-order-link:hover {
        color: #1e3a8a;
        text-decoration: underline;
    }

    .vi-order-meta {
        display: block;
        margin-top: 3px;
        color: var(--vi-muted);
        font-size: 12px;
        font-weight: 600;
    }

    .vi-chip {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 700;
        line-height: 1;
        white-space: nowrap;
    }

    .vi-chip-paid {
        background: var(--vi-success-bg);
        color: var(--vi-success-text);
    }

    .vi-chip-pending {
        background: var(--vi-warning-bg);
        color: var(--vi-warning-text);
    }

    .vi-chip-scheduled {
        background: var(--vi-scheduled-bg);
        color: var(--vi-scheduled-text);
    }

    .vi-chip-normal {
        background: var(--vi-normal-bg);
        color: var(--vi-normal-text);
    }

    .vi-chip-primary {
        background: #eaf2ff;
        color: #1d4ed8;
    }

    .vi-chip-confirmed { background: #dbefff; color: #2285e8; }
    .vi-chip-processing { background: #ffefda; color: #e4972d; }
    .vi-chip-completed { background: #dff0e3; color: #4fa464; }
    .vi-chip-active { background: #dbefff; color: #2285e8; }
    .vi-chip-cancelled { background: #ffe1df; color: #ef5753; }
    .vi-chip-rejected { background: #ffe1df; color: #ef5753; }
    .vi-chip-upcoming { background: #e0e7ff; color: #3730a3; }

    .vi-empty {
        text-align: center;
        padding: 38px 20px;
        color: #64748b;
    }

    .vi-empty i {
        font-size: 38px;
        color: #94a3b8;
        margin-bottom: 10px;
        display: inline-block;
    }

    .vi-empty-title {
        margin: 0 0 5px;
        color: #0f172a;
        font-size: 17px;
        font-weight: 700;
    }

    .vi-empty-text {
        margin: 0;
        color: #64748b;
        font-size: 14px;
    }

    .vi-pagination {
        padding: 18px;
        border-top: 1px solid #edf2f7;
    }

    .vi-pagination .pagination {
        justify-content: center;
        gap: 6px;
        margin-bottom: 0;
    }

    .vi-pagination .page-link {
        border-radius: 10px;
        margin: 0 2px;
        color: var(--vi-primary);
        font-weight: 700;
        box-shadow: none;
        border: 1px solid #d8e3f0;
    }

    .vi-pagination .page-item.active .page-link {
        background: var(--vi-primary);
        border-color: var(--vi-primary);
        color: #fff;
    }

    @media (max-width: 992px) {
        .vendor-invoices {
            max-width: 100%;
            padding: 8px 12px 24px;
        }

        .vi-title {
            font-size: 28px;
        }

        .vi-subtitle {
            font-size: 15px;
        }

        .vi-stat-value {
            font-size: 32px;
        }

        .vi-panel-title {
            font-size: 18px;
        }

        .vi-filter-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 992px) {
        .vi-body form {
            grid-template-columns: 1fr !important;
        }
    }

    @media (max-width: 576px) {
        .vi-hero {
            padding: 18px;
        }

        .vi-title {
            font-size: 24px;
        }

        .vi-actions {
            width: 100%;
        }

        .vi-btn-primary,
        .vi-btn-outline {
            width: 100%;
        }

        .vi-panel-head {
            flex-direction: column;
            align-items: flex-start;
        }

        .vi-table thead th,
        .vi-table tbody td {
            padding: 12px;
            font-size: 13px;
        }
    }
</style>
@endsection

@section('content')
@php
    $isAr = app()->getLocale() === 'ar';
@endphp

<main class="vendor-invoices">
    @include('flash::message')

    <nav class="vi-breadcrumb">
        <a href="{{ route('vendor/dashboard') }}">{{ $isAr ? 'الرئيسية' : 'Home' }}</a>
        <i class="bi bi-chevron-{{ $isAr ? 'left' : 'right' }}"></i>
        <span class="active">{{ $isAr ? 'فواتير المورد' : 'Vendor Invoices' }}</span>
    </nav>

    <section class="vi-card vi-hero">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h3 class="vi-title">
                    {{ $isAr ? 'فواتير المورد' : 'Vendor Invoices' }}
                </h3>

                <p class="vi-subtitle">
                    {{ $isAr
                        ? 'راجع فواتير الطلبات، حالة الدفع، والطلبات المجدولة من مكان واحد بتصميم واضح وسهل المتابعة.'
                        : 'Review order invoices, payment status, and scheduled requests from one clean and easy-to-track place.' }}
                </p>
            </div>

            <div class="vi-actions">
                <a href="{{ route('vendor/dashboard') }}" class="vi-btn-outline">
                    <i class="bi bi-grid-1x2-fill"></i>
                    {{ __('nav.dashboard') ?? ($isAr ? 'لوحة التحكم' : 'Dashboard') }}
                </a>

                <a href="{{ route('vendor/orders') }}" class="vi-btn-primary">
                    <i class="bi bi-bag-check"></i>
                    {{ __('nav.orders') ?? ($isAr ? 'الطلبات' : 'Orders') }}
                </a>
            </div>
        </div>
    </section>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="vi-card vi-stat">
                <p class="vi-stat-label">{{ $isAr ? 'مدفوع' : 'Paid' }}</p>
                <h4 class="vi-stat-value">{{ number_format((int) $totals['paid']) }}</h4>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="vi-card vi-stat">
                <p class="vi-stat-label">{{ $isAr ? 'قيد الانتظار' : 'Pending' }}</p>
                <h4 class="vi-stat-value">{{ number_format((int) $totals['pending']) }}</h4>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="vi-card vi-stat">
                <p class="vi-stat-label">{{ $isAr ? 'مكتمل' : 'Completed' }}</p>
                <h4 class="vi-stat-value">{{ number_format((int) $totals['completed']) }}</h4>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="vi-card vi-stat">
                <p class="vi-stat-label">{{ $isAr ? 'ملغي' : 'Cancelled' }}</p>
                <h4 class="vi-stat-value">{{ number_format((int) $totals['cancelled']) }}</h4>
            </div>
        </div>
    </div>

    <section class="vi-card mb-4">
        <div class="vi-panel-head">
            <div>
                <h5 class="vi-panel-title">{{ $isAr ? 'تصفية الفواتير' : 'Filter Invoices' }}</h5>
                <p class="vi-panel-subtitle">
                    {{ $isAr ? 'حدد الفترة أو حالة الطلب أو حالة الدفع للوصول للفواتير المطلوبة بسرعة.' : 'Choose a date range, order status, or payment status to find invoices faster.' }}
                </p>
            </div>

            @if(request()->hasAny(['date_from', 'date_to', 'order_status', 'payment_status']))
                <a href="{{ url()->current() }}" class="vi-btn-outline">
                    <i class="bi bi-arrow-clockwise"></i>
                    {{ $isAr ? 'إعادة ضبط' : 'Reset' }}
                </a>
            @endif
        </div>

        <div class="vi-body">
            <form method="GET" style="display:grid;grid-template-columns:repeat(4, minmax(0, 1fr)) 1fr;gap:14px;align-items:end;">
                <div class="vi-field">
                    <label>{{ $isAr ? 'من تاريخ' : 'From Date' }}</label>
                    <input type="date" name="date_from" value="{{ $dateFrom }}" class="form-control">
                </div>

                <div class="vi-field">
                    <label>{{ $isAr ? 'إلى تاريخ' : 'To Date' }}</label>
                    <input type="date" name="date_to" value="{{ $dateTo }}" class="form-control">
                </div>

                <div class="vi-field">
                    <label>{{ $isAr ? 'حالة الطلب' : 'Order Status' }}</label>
                    <select name="order_status" class="form-select">
                        <option value="">{{ $isAr ? 'كل الحالات' : 'All Statuses' }}</option>
                        <option value="pending" {{ $orderStatus === 'pending' ? 'selected' : '' }}>
                            {{ $isAr ? 'قيد الانتظار' : 'Pending' }}
                        </option>
                        <option value="confirmed" {{ $orderStatus === 'confirmed' ? 'selected' : '' }}>
                            {{ $isAr ? 'تم التأكيد' : 'Confirmed' }}
                        </option>
                        <option value="processing" {{ $orderStatus === 'processing' ? 'selected' : '' }}>
                            {{ $isAr ? 'قيد التنفيذ' : 'Processing' }}
                        </option>
                        <option value="completed" {{ $orderStatus === 'completed' ? 'selected' : '' }}>
                            {{ $isAr ? 'مكتمل' : 'Completed' }}
                        </option>
                        <option value="scheduled" {{ $orderStatus === 'scheduled' ? 'selected' : '' }}>
                            {{ $isAr ? 'مجدول' : 'Scheduled' }}
                        </option>
                        <option value="active_scheduled" {{ $orderStatus === 'active_scheduled' ? 'selected' : '' }}>
                            {{ $isAr ? 'نشط' : 'Active' }}
                        </option>
                        <option value="cancelled" {{ $orderStatus === 'cancelled' ? 'selected' : '' }}>
                            {{ $isAr ? 'ملغي' : 'Cancelled' }}
                        </option>
                        <option value="rejected" {{ $orderStatus === 'rejected' ? 'selected' : '' }}>
                            {{ $isAr ? 'مرفوض' : 'Rejected' }}
                        </option>
                    </select>
                </div>

                <div class="vi-field">
                    <label>{{ $isAr ? 'حالة الدفع' : 'Payment Status' }}</label>
                    <select name="payment_status" class="form-select">
                        <option value="">{{ $isAr ? 'كل الحالات' : 'All' }}</option>
                        <option value="paid" {{ $paymentStatus === 'paid' ? 'selected' : '' }}>
                            {{ $isAr ? 'مدفوع' : 'Paid' }}
                        </option>
                        <option value="unpaid" {{ $paymentStatus === 'unpaid' ? 'selected' : '' }}>
                            {{ $isAr ? 'غير مدفوع' : 'Unpaid' }}
                        </option>
                    </select>
                </div>

                <div>
                    <button class="vi-btn-primary w-100" type="submit">
                        <i class="bi bi-funnel-fill"></i>
                        {{ $isAr ? 'تصفية' : 'Filter' }}
                    </button>
                </div>
            </form>
        </div>
    </section>

    <section class="vi-card vi-table-card">
        <div class="vi-panel-head">
            <div>
                <h5 class="vi-panel-title">{{ $isAr ? 'قائمة الفواتير' : 'Invoice List' }}</h5>
                <p class="vi-panel-subtitle">
                    {{ $isAr ? 'كل الفواتير المرتبطة بطلباتك وحالات الدفع.' : 'All invoices linked to your orders and payment statuses.' }}
                </p>
            </div>

            <span class="vi-chip vi-chip-primary">
                <i class="bi bi-receipt"></i>
                {{ method_exists($invoices, 'total') ? number_format($invoices->total()) : number_format($invoices->count()) }}
                {{ $isAr ? 'فاتورة' : 'Invoices' }}
            </span>
        </div>

        <div class="vi-table-wrap">
            <table class="table vi-table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ $isAr ? 'تفاصيل الطلب' : 'Order Details' }}</th>
                        <th>{{ $isAr ? 'الإجمالي' : 'Total' }}</th>
                        <th>{{ $isAr ? 'الدفع' : 'Payment' }}</th>
                        <th>{{ $isAr ? 'الحالة' : 'Status' }}</th>
                        <th>{{ $isAr ? 'التاريخ' : 'Date' }}</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($invoices as $order)
                        @php
                            $isPaid = (string)($order->payment_status ?? '') === '1' || (string)($order->payment_status ?? '') === 'paid';
                            $statusState = $order->front_status_state ?? ['text' => ($isAr ? 'قيد الانتظار' : 'Pending'), 'class' => 'chip-pending'];
                            $statusChipClass = $statusState['class'] ?? 'chip-pending';
                            if (str_starts_with($statusChipClass, 'chip-')) {
                                $statusChipClass = 'vi-chip-' . substr($statusChipClass, 5);
                            }
                        @endphp

                        <tr>
                            <td>
                                <span class="fw-bold">#{{ $order->id }}</span>
                            </td>

                            <td>
                                <a class="vi-order-link" href="{{ route('vendor/orders/show', $order->id) }}">
                                    {{ $isAr ? 'طلب' : 'Order' }} #{{ $order->id }}
                                </a>
                                <span class="vi-order-meta">
                                    <i class="bi bi-person"></i>
                                    {{ $order->user->name ?? '-' }}
                                </span>
                            </td>

                            <td>
                                <strong>{{ number_format((float)($order->total_cost ?? 0), 2) }}</strong>
                                <span class="text-muted small">SAR</span>
                            </td>

                            <td>
                                <span class="vi-chip {{ $isPaid ? 'vi-chip-paid' : 'vi-chip-pending' }}">
                                    <i class="bi {{ $isPaid ? 'bi-check2-circle' : 'bi-hourglass-split' }}"></i>
                                    {{ $isPaid ? ($isAr ? 'مدفوع' : 'Paid') : ($isAr ? 'غير مدفوع' : 'Unpaid') }}
                                </span>
                            </td>

                            <td>
                                <span class="vi-chip {{ $statusChipClass }}">
                                    {{ $statusState['text'] ?? ($isAr ? 'قيد الانتظار' : 'Pending') }}
                                </span>
                            </td>

                            <td>
                                <span class="fw-semibold">{{ optional($order->created_at)->format('Y-m-d') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="vi-empty">
                                    <i class="bi bi-receipt-cutoff"></i>
                                    <h5 class="vi-empty-title">
                                        {{ $isAr ? 'لا توجد فواتير' : 'No invoices found' }}
                                    </h5>
                                    <p class="vi-empty-text">
                                        {{ $isAr ? 'جرّب تغيير الفلاتر أو راجع الطلبات لاحقاً.' : 'Try changing the filters or check again later.' }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($invoices, 'hasPages') && $invoices->hasPages())
            <div class="vi-pagination">
                {{ $invoices->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </section>
</main>
@endsection
```
