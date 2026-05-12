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
        max-width: 95%;
        margin: 12px auto 0;
        background: var(--vi-bg);
        padding: 8px 0 24px;
    }

    .vi-title {
        font-size: 34px;
        font-weight: 600;
        color: var(--vi-title);
        margin: 0 0 14px;
    }

    .vi-filter {
        background: var(--vi-card);
        border: 1px solid var(--vi-border);
        border-radius: 14px;
        padding: 14px;
        margin-bottom: 18px;
    }

    .vi-filter .form-control,
    .vi-filter .form-select {
        height: 48px;
        border: 1px solid #dbe2ee;
        border-radius: 10px;
    }

    .vi-filter .btn {
        height: 48px;
        border: 0;
        border-radius: 10px;
        font-weight: 600;
        background: linear-gradient(90deg, var(--vi-primary) 0%, var(--vi-accent) 100%);
    }

    .vi-stat-card {
        background: var(--vi-card);
        border: 1px solid var(--vi-border);
        border-radius: 12px;
        padding: 16px 18px;
        height: 100%;
    }

    .vi-stat-label {
        margin: 0;
        color: var(--vi-muted);
        font-size: 14px;
        font-weight: 500;
    }

    .vi-stat-value {
        margin: 6px 0 0;
        color: var(--vi-text);
        font-size: 30px;
        line-height: 1;
        font-weight: 700;
    }

    .vi-table-wrap {
        background: var(--vi-card);
        border: 1px solid var(--vi-border);
        border-radius: 14px;
        padding: 12px;
    }

    .vi-table {
        margin-bottom: 0;
    }

    .vi-table thead th {
        border-bottom-width: 1px;
        font-size: 18px;
        font-weight: 700;
        color: #111827;
        white-space: nowrap;
    }

    .vi-table tbody td {
        font-size: 17px;
        vertical-align: middle;
        color: #111827;
    }

    .vi-order-link {
        color: #1f63eb;
        text-decoration: none;
        font-weight: 500;
    }

    .vi-order-link:hover {
        text-decoration: underline;
    }

    .vi-chip {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 700;
        line-height: 1;
    }

    .vi-chip-paid { background: #dcfce7; color: #166534; }
    .vi-chip-pending { background: #ffedd5; color: #9a3412; }
    .vi-chip-scheduled { background: #e0e7ff; color: #3730a3; }
    .vi-chip-normal { background: #ecfeff; color: #155e75; }

    .vi-empty {
        color: var(--vi-muted);
        text-align: center;
        padding: 20px 0;
    }

    .vi-pagination {
        margin-top: 16px;
    }

    .vi-pagination .pagination {
        justify-content: center;
        gap: 8px;
    }

    .vi-pagination .page-link {
        min-width: 36px;
        height: 36px;
        border: 1px solid #dce6fb;
        border-radius: 10px;
        color: #2b4a8f;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 10px;
        background: #eaf1ff;
    }

    .vi-pagination .page-item.active .page-link {
        background: linear-gradient(90deg, #0f4bbf 0%, #10b981 100%);
        border-color: transparent;
        color: #fff;
    }

    @media (max-width: 992px) {
        .vendor-invoices { max-width: 100%; padding: 8px 12px 24px; }
        .vi-title { font-size: 28px; }
        .vi-table thead th { font-size: 15px; }
        .vi-table tbody td { font-size: 14px; }
        .vi-stat-value { font-size: 24px; }
    }
</style>
@endsection

@section('content')
@php
    $isAr = app()->getLocale() === 'ar';
@endphp
<main class="vendor-invoices">
    <h3 class="vi-title">{{ $isAr ? 'فواتير المورد' : 'Vendor Invoices' }}</h3>

    <form class="row g-2 vi-filter" method="GET">
        <div class="col-md-3">
            <input type="date" name="date_from" value="{{ $dateFrom }}" class="form-control">
        </div>
        <div class="col-md-3">
            <input type="date" name="date_to" value="{{ $dateTo }}" class="form-control">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">{{ $isAr ? 'كل الحالات' : 'All Statuses' }}</option>
                <option value="paid" {{ $status === 'paid' ? 'selected' : '' }}>{{ $isAr ? 'مدفوع' : 'Paid' }}</option>
                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>{{ $isAr ? 'قيد الانتظار' : 'Pending' }}</option>
                <option value="2" {{ $status === '2' ? 'selected' : '' }}>{{ $isAr ? 'مجدول' : 'Scheduled' }}</option>
            </select>
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary w-100">{{ $isAr ? 'تصفية' : 'Filter' }}</button>
        </div>
    </form>

    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="vi-stat-card"><p class="vi-stat-label">{{ $isAr ? 'مدفوع' : 'Paid' }}</p><h5 class="vi-stat-value">{{ $totals['paid'] }}</h5></div>
        </div>
        <div class="col-md-3">
            <div class="vi-stat-card"><p class="vi-stat-label">{{ $isAr ? 'قيد الانتظار' : 'Pending' }}</p><h5 class="vi-stat-value">{{ $totals['pending'] }}</h5></div>
        </div>
        <div class="col-md-3">
            <div class="vi-stat-card"><p class="vi-stat-label">{{ $isAr ? 'مجدول' : 'Scheduled' }}</p><h5 class="vi-stat-value">{{ $totals['scheduled'] }}</h5></div>
        </div>
        <div class="col-md-3">
            <div class="vi-stat-card"><p class="vi-stat-label">{{ $isAr ? 'مكتمل' : 'Completed' }}</p><h5 class="vi-stat-value">{{ $totals['completed'] }}</h5></div>
        </div>
    </div>

    <div class="vi-table-wrap">
        <div class="table-responsive">
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
                            $isScheduled = (int)($order->request_type ?? 0) === 2;
                        @endphp
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>
                                <a class="vi-order-link" href="{{ route('vendor/orders/show', $order->id) }}">
                                    {{ $isAr ? 'طلب' : 'Order' }} {{ $order->id }} - {{ $order->user->name ?? '-' }}
                                </a>
                            </td>
                            <td>{{ number_format((float)($order->total_cost ?? 0), 2) }} SAR</td>
                            <td>
                                <span class="vi-chip {{ $isPaid ? 'vi-chip-paid' : 'vi-chip-pending' }}">
                                    {{ $isPaid ? ($isAr ? 'مدفوع' : 'Paid') : ($isAr ? 'قيد الانتظار' : 'Pending') }}
                                </span>
                            </td>
                            <td>
                                <span class="vi-chip {{ $isScheduled ? 'vi-chip-scheduled' : 'vi-chip-normal' }}">
                                    {{ $isScheduled ? ($isAr ? 'مجدول' : 'Scheduled') : ($isAr ? 'عادي' : 'Normal') }}
                                </span>
                            </td>
                            <td>{{ optional($order->created_at)->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="vi-empty">{{ $isAr ? 'لا توجد فواتير' : 'No invoices found.' }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="vi-pagination">
            {{ $invoices->links('pagination::bootstrap-5') }}
        </div>
    </div>
</main>
@endsection

