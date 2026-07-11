@extends('layouts.front.home')

@section('title')
    <title>{{ __('nav.my_offers') }} - Vendor | Hema</title>
@endsection

@section('css')
<style>
    .vendor-offers,
    .vendor-offers *{font-family:"Poppins","Tajawal",system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;}

    :root{
        --vo-bg:#f5f6f8;
        --vo-card:#ffffff;
        --vo-border:#e8eaee;
        --vo-head:#f2f2f4;
        --vo-text:#1f2937;
        --vo-muted:#6b7280;
        --vo-primary:#0f4bbf;
        --vo-accent:#0ec6a0;
    }

    .vendor-offers{max-width:95%;margin:12px auto 0;background:var(--vo-bg);padding:8px 0 24px;}

    .vo-breadcrumb{font-size:13px;margin-bottom:12px;}
    .vo-breadcrumb a{text-decoration:none;color:#6b7280;}
    .vo-breadcrumb .active{color:var(--vo-primary);font-weight:700;}

    .vo-hero{padding:22px;margin-bottom:16px;}
    .vo-title{margin:0 0 6px;color:#0f2f7f;font-size:34px;line-height:1.08;font-weight:800;letter-spacing:-0.01em;}
    .vo-subtitle{margin:0;color:#475569;font-size:16px;line-height:1.55;max-width:760px;}

    .vo-actions{display:flex;gap:10px;flex-wrap:wrap;}
    .vo-btn-primary{border:0;border-radius:10px;color:#fff;font-weight:700;padding:10px 16px;text-decoration:none;background:linear-gradient(90deg,var(--vo-primary) 0%,var(--vo-accent) 100%);display:inline-flex;align-items:center;gap:8px;}
    .vo-btn-outline{border:1px solid #cbd5e1;border-radius:10px;color:#1e3a8a;font-weight:700;padding:10px 16px;text-decoration:none;background:#fff;display:inline-flex;align-items:center;gap:8px;}
    .vo-btn-primary:hover,.vo-btn-outline:hover{opacity:.95;color:inherit;}

    .vo-stat{padding:16px 18px;height:100%;transition:all .2s ease;}
    .vo-stat:hover{border-color:#93c5fd;box-shadow:0 4px 12px rgba(15,75,191,.08);transform:translateY(-1px);}
    .vo-stat-label{margin:0;color:var(--vo-muted);font-size:13px;font-weight:500;}
    .vo-stat-value{margin:8px 0 0;color:var(--vo-text);font-size:40px;line-height:1;font-weight:800;}

    .vo-panel{background:var(--vo-card);border:1px solid var(--vo-border);border-radius:14px;box-shadow:0 6px 20px rgba(15,23,42,.04);overflow:hidden;}
    .vo-panel-head{border-bottom:1px solid var(--vo-border);padding:14px 18px;display:flex;align-items:center;justify-content:space-between;gap:12px;}
    .vo-panel-title{margin:0;color:#0f172a;font-size:20px;font-weight:700;line-height:1.1;}
    .vo-panel-subtitle{margin:4px 0 0;color:var(--vo-muted);font-size:13px;}

    .vo-filter-body{padding:18px;}
    .vo-filter-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px;align-items:end;}
    .vo-field label{display:block;font-size:13px;font-weight:700;color:#334155;margin-bottom:8px;}
    .vo-field .form-control,.vo-field .form-select{min-height:46px;border-radius:10px;border-color:#d5deeb;box-shadow:none;color:#334155;font-weight:600;}
    .vo-field .form-control:focus,.vo-field .form-select:focus{border-color:rgba(15,75,191,.45);box-shadow:0 0 0 .18rem rgba(15,75,191,.08);}

    .vo-table-wrap{width:100%;overflow-x:auto;}
    .vo-table{width:100%;margin-bottom:0;border-collapse:collapse;}
    .vo-table thead th{background:#f8fbff;color:#334155;font-size:13px;font-weight:800;white-space:nowrap;padding:14px 16px;border-bottom:1px solid var(--vo-border);text-align:start;}
    .vo-table tbody td{color:#111827;font-size:14px;vertical-align:middle;padding:15px 16px;border-bottom:1px solid #edf2f7;white-space:nowrap;}
    .vo-table tbody tr:hover td{background:#f8fbff;}

    .vo-order-link{color:var(--vo-primary);text-decoration:none;font-weight:800;}
    .vo-order-link:hover{color:#1e3a8a;text-decoration:underline;}
    .vo-order-meta{display:block;margin-top:3px;color:var(--vo-muted);font-size:12px;font-weight:600;}

    .vo-chip{display:inline-flex;align-items:center;justify-content:center;gap:6px;border-radius:999px;padding:6px 12px;font-size:12px;font-weight:700;line-height:1;white-space:nowrap;}
    .vo-chip-pending{background:#eef0f4;color:#666d79;}
    .vo-chip-accepted{background:#dcfce7;color:#166534;}
    .vo-chip-rejected{background:#ffe1df;color:#ef5753;}

    .vo-actions-cell{display:flex;gap:6px;flex-wrap:wrap;}
    .vo-actions-cell .btn{border-radius:10px;font-weight:700;font-size:12px;padding:6px 10px;}

    .vo-empty{text-align:center;padding:38px 20px;color:#64748b;}
    .vo-empty i{font-size:38px;color:#94a3b8;margin-bottom:10px;display:inline-block;}
    .vo-empty-title{margin:0 0 5px;color:#0f172a;font-size:17px;font-weight:700;}
    .vo-empty-text{margin:0;color:#64748b;font-size:14px;}

    .vo-pagination{display:flex;justify-content:center;margin-top:26px;}
    .vo-pagination .pagination{gap:8px;}
    .vo-pagination .page-link{min-width:36px;height:36px;border:1px solid #dce6fb;border-radius:10px;color:#2b4a8f;font-weight:600;display:inline-flex;align-items:center;justify-content:center;padding:0 10px;background:#eaf1ff;}
    .vo-pagination .page-item.active .page-link{background:linear-gradient(90deg,#0f4bbf 0%,#10b981 100%);border-color:transparent;color:#fff;}

    @media (max-width:992px){
        .vo-title{font-size:28px;}
        .vo-subtitle{font-size:15px;}
        .vo-stat-value{font-size:32px;}
        .vo-panel-title{font-size:18px;}
        .vo-filter-grid{grid-template-columns:1fr;}
    }
    @media (max-width:576px){
        .vo-hero{padding:18px;}
        .vo-title{font-size:24px;}
        .vo-actions{width:100%;}
        .vo-btn-primary,.vo-btn-outline{width:100%;}
        .vo-panel-head{flex-direction:column;align-items:flex-start;}
        .vo-table thead th,.vo-table tbody td{padding:12px;font-size:13px;}
    }
</style>
@endsection

@section('content')
@php
    $isAr = app()->getLocale() === 'ar';
@endphp

<main class="vendor-offers">
    @include('flash::message')

    <nav class="vo-breadcrumb">
        <a href="{{ route('vendor/dashboard') }}">{{ $isAr ? 'الرئيسية' : 'Home' }}</a>
        <i class="bi bi-chevron-{{ $isAr ? 'left' : 'right' }}"></i>
        <a href="{{ route('vendor/orders') }}">{{ $isAr ? 'الطلبات' : 'Orders' }}</a>
        <i class="bi bi-chevron-{{ $isAr ? 'left' : 'right' }}"></i>
        <span class="active">{{ $isAr ? 'عروضي' : 'My Offers' }}</span>
    </nav>

    <section class="vo-panel vo-hero">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h3 class="vo-title">{{ $isAr ? 'عروضي' : 'My Offers' }}</h3>
                <p class="vo-subtitle">{{ $isAr ? 'تابع جميع العروض التي قدمتها على الطلبات، وحالاتها، وإجراءات التعديل والحذف.' : 'Track all offers you submitted on orders, their statuses, and edit or delete actions.' }}</p>
            </div>
            <div class="vo-actions">
                <a href="{{ route('vendor/dashboard') }}" class="vo-btn-outline">
                    <i class="bi bi-grid-1x2-fill"></i>
                    {{ $isAr ? 'لوحة التحكم' : 'Dashboard' }}
                </a>
                <a href="{{ route('vendor/orders') }}" class="vo-btn-primary">
                    <i class="bi bi-bag-check"></i>
                    {{ $isAr ? 'الطلبات' : 'Orders' }}
                </a>
            </div>
        </div>
    </section>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <a href="{{ route('vendor/orders/my-offers') }}" class="text-decoration-none" style="color:inherit;">
                <div class="vo-panel vo-stat">
                    <p class="vo-stat-label">{{ $isAr ? 'إجمالي العروض' : 'Total Offers' }}</p>
                    <h4 class="vo-stat-value">{{ number_format($counts['all'] ?? 0) }}</h4>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('vendor/orders/my-offers', ['status' => 'pending']) }}" class="text-decoration-none" style="color:inherit;">
                <div class="vo-panel vo-stat">
                    <p class="vo-stat-label">{{ $isAr ? 'قيد الانتظار' : 'Pending' }}</p>
                    <h4 class="vo-stat-value">{{ number_format($counts['pending'] ?? 0) }}</h4>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('vendor/orders/my-offers', ['status' => 'accepted']) }}" class="text-decoration-none" style="color:inherit;">
                <div class="vo-panel vo-stat">
                    <p class="vo-stat-label">{{ $isAr ? 'مقبولة' : 'Accepted' }}</p>
                    <h4 class="vo-stat-value">{{ number_format($counts['accepted'] ?? 0) }}</h4>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('vendor/orders/my-offers', ['status' => 'rejected']) }}" class="text-decoration-none" style="color:inherit;">
                <div class="vo-panel vo-stat">
                    <p class="vo-stat-label">{{ $isAr ? 'مرفوضة' : 'Rejected' }}</p>
                    <h4 class="vo-stat-value">{{ number_format($counts['rejected'] ?? 0) }}</h4>
                </div>
            </a>
        </div>
    </div>

    <section class="vo-panel mb-4">
        <div class="vo-panel-head">
            <div>
                <h5 class="vo-panel-title">{{ $isAr ? 'تصفية العروض' : 'Filter Offers' }}</h5>
                <p class="vo-panel-subtitle">{{ $isAr ? 'حدد حالة العرض أو ابحث برقم الطلب للوصول السريع.' : 'Choose an offer status or search by order number to find offers faster.' }}</p>
            </div>
            @if(request()->hasAny(['status', 'search']))
                <a href="{{ url()->current() }}" class="vo-btn-outline" style="padding:8px 14px;font-size:13px;">
                    <i class="bi bi-arrow-clockwise"></i>
                    {{ $isAr ? 'إعادة ضبط' : 'Reset' }}
                </a>
            @endif
        </div>
        <div class="vo-filter-body">
            <form method="GET" action="{{ route('vendor/orders/my-offers') }}" class="vo-filter-grid">
                <div class="vo-field">
                    <label>{{ $isAr ? 'حالة العرض' : 'Offer Status' }}</label>
                    <select name="status" class="form-select">
                        <option value="">{{ $isAr ? 'كل الحالات' : 'All Statuses' }}</option>
                        <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>{{ $isAr ? 'قيد الانتظار' : 'Pending' }}</option>
                        <option value="accepted" {{ $status === 'accepted' ? 'selected' : '' }}>{{ $isAr ? 'مقبولة' : 'Accepted' }}</option>
                        <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>{{ $isAr ? 'مرفوضة' : 'Rejected' }}</option>
                    </select>
                </div>
                <div class="vo-field">
                    <label>{{ $isAr ? 'بحث برقم الطلب' : 'Search by Order ID' }}</label>
                    <input type="text" name="search" class="form-control" placeholder="{{ $isAr ? 'أدخل رقم الطلب...' : 'Enter order ID...' }}" value="{{ $search }}">
                </div>
                <div>
                    <button class="vo-btn-primary w-100" type="submit" style="justify-content:center;">
                        <i class="bi bi-funnel-fill"></i>
                        {{ $isAr ? 'تصفية' : 'Filter' }}
                    </button>
                </div>
            </form>
        </div>
    </section>

    <section class="vo-panel vo-table-card">
        <div class="vo-panel-head">
            <div>
                <h5 class="vo-panel-title">{{ $isAr ? 'قائمة العروض' : 'Offers List' }}</h5>
                <p class="vo-panel-subtitle">{{ $isAr ? 'كل العروض المرتبطة بطلباتك وحالاتها.' : 'All offers linked to your orders and their statuses.' }}</p>
            </div>
            <span class="vo-chip vo-chip-pending" style="font-size:13px;padding:8px 14px;">
                <i class="bi bi-send"></i>
                {{ method_exists($offers, 'total') ? number_format($offers->total()) : number_format($offers->count()) }}
                {{ $isAr ? 'عرض' : 'Offers' }}
            </span>
        </div>

        <div class="vo-table-wrap">
            <table class="table vo-table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ $isAr ? 'تفاصيل العرض' : 'Offer Details' }}</th>
                        <th>{{ $isAr ? 'العميل' : 'Customer' }}</th>
                        <th>{{ $isAr ? 'التكلفة' : 'Cost' }}</th>
                        <th>{{ $isAr ? 'مدة التوصيل' : 'Delivery' }}</th>
                        <th>{{ $isAr ? 'الحالة' : 'Status' }}</th>
                        <th>{{ $isAr ? 'التاريخ' : 'Date' }}</th>
                        <th>{{ $isAr ? 'إجراءات' : 'Actions' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($offers as $offer)
                        @php
                            $status = strtolower($offer->status_label ?? 'pending');
                            $statusLabel = match($status) {
                                'accepted' => ($isAr ? 'مقبولة' : 'Accepted'),
                                'rejected' => ($isAr ? 'مرفوضة' : 'Rejected'),
                                default => ($isAr ? 'قيد الانتظار' : 'Pending'),
                            };
                            $statusChipClass = match($status) {
                                'accepted' => 'vo-chip-accepted',
                                'rejected' => 'vo-chip-rejected',
                                default => 'vo-chip-pending',
                            };
                            $typeTitle = match((int)($offer->order->order_type ?? 0)) {
                                1 => $isAr ? 'طلب شراء' : 'Purchase Order',
                                3 => $isAr ? 'طلب صيانة' : 'Maintenance Request',
                                default => $isAr ? 'طلب تسعير' : 'Quotation Request',
                            };
                        @endphp
                        <tr>
                            <td>
                                <span class="fw-bold">#{{ $offer->id }}</span>
                            </td>

                            <td>
                                <a class="vo-order-link" href="{{ route('vendor/orders/show', $offer->order_id) }}">
                                    {{ $typeTitle }} #{{ $offer->order_id }}
                                </a>
                                <span class="vo-order-meta">
                                    <i class="bi bi-tag"></i>
                                    {{ $isAr ? 'رقم العرض' : 'Offer' }} #{{ $offer->id }}
                                </span>
                            </td>

                            <td>
                                <span class="fw-semibold">{{ $offer->order->user->name ?? '-' }}</span>
                            </td>

                            <td>
                                <strong>{{ number_format((float)($offer->cost ?? 0), 2) }}</strong>
                                <span class="text-muted small">{{ $isAr ? 'ر.س' : 'SAR' }}</span>
                            </td>

                            <td>
                                <span class="fw-semibold">{{ $offer->delivery_time ?? '-' }} {{ $isAr ? 'يوم' : 'days' }}</span>
                                @if($offer->warranty)
                                    <span class="vo-order-meta">{{ $isAr ? 'ضمان' : 'Warranty' }}: {{ $offer->warranty }}</span>
                                @endif
                            </td>

                            <td>
                                <span class="vo-chip {{ $statusChipClass }}">
                                    <i class="bi {{ $status === 'accepted' ? 'bi-check-circle' : ($status === 'rejected' ? 'bi-x-circle' : 'bi-hourglass-split') }}"></i>
                                    {{ $statusLabel }}
                                </span>
                            </td>

                            <td>
                                <span class="fw-semibold">{{ $offer->created_at->format('Y-m-d') }}</span>
                            </td>

                            <td>
                                <div class="vo-actions-cell">
                                    @if($status === 'pending')
                                        <a href="{{ route('vendor/orders/offer-edit', $offer->id) }}" class="btn btn-outline-primary btn-sm" onclick="event.stopPropagation();">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('vendor/orders/offer-delete', $offer->id) }}" method="POST" style="display:inline;" onsubmit="event.stopPropagation(); return confirm('{{ $isAr ? 'هل تريد حذف هذا العرض؟' : 'Delete this offer?' }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="vo-empty">
                                    <i class="bi bi-send-x"></i>
                                    <h5 class="vo-empty-title">{{ $isAr ? 'لا توجد عروض' : 'No offers found' }}</h5>
                                    <p class="vo-empty-text">{{ $isAr ? 'لم تقدم أي عروض بعد، أو جرّب تغيير الفلاتر.' : 'You haven\'t submitted any offers yet, or try changing the filters.' }}</p>
                                    <a href="{{ route('vendor/orders') }}" class="vo-btn-primary mt-2" style="display:inline-flex;">
                                        <i class="bi bi-bag-check"></i>
                                        {{ $isAr ? 'تصفح الطلبات' : 'Browse Orders' }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($offers, 'hasPages') && $offers->hasPages())
            <div class="vo-pagination" style="padding:18px;border-top:1px solid #edf2f7;">
                {{ $offers->appends(['status' => $status, 'search' => $search])->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </section>
</main>
@endsection
