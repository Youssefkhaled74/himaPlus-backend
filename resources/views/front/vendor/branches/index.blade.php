@extends('layouts.front.home')

@section('title')
    <title>{{ __('vendor_branches.my_branches') }} - Vendor | Hema</title>
@endsection

@section('css')
<style>
    .vendor-branches,
    .vendor-branches *{font-family:"Poppins","Tajawal",system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;}

    :root{
        --vb-bg:#f5f6f8;
        --vb-card:#ffffff;
        --vb-border:#e8eaee;
        --vb-head:#f2f2f4;
        --vb-text:#1f2937;
        --vb-muted:#6b7280;
        --vb-primary:#0f4bbf;
        --vb-accent:#0ec6a0;
    }

    .vendor-branches{max-width:95%;margin:12px auto 0;background:var(--vb-bg);padding:8px 0 24px;}
    .vb-title{font-size:34px;font-weight:600;color:#0f2f7f;margin:0 0 14px;}
    .vb-card{background:var(--vb-card);border:1px solid var(--vb-border);border-radius:14px;box-shadow:0 6px 20px rgba(15,23,42,.04);overflow:hidden;margin-bottom:18px;}
    .vb-card-head{background:var(--vb-head);padding:16px 22px;display:flex;align-items:center;justify-content:space-between;gap:12px;border-bottom:1px solid var(--vb-border);}
    .vb-card-head h6{margin:0;font-size:18px;font-weight:600;color:#21242c;}
    .vb-body{padding:18px 22px;}

    .vb-hero{padding:22px;margin-bottom:16px;}
    .vb-hero-subtitle{margin:6px 0 0;color:#475569;font-size:16px;line-height:1.55;}

    .vb-btn{border-radius:10px;font-weight:700;padding:10px 18px;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;gap:8px;transition:all .2s ease;min-height:44px;border:0;color:#fff;background:linear-gradient(90deg,var(--vb-primary) 0%,var(--vb-accent) 100%);}
    .vb-btn:hover{color:#fff;transform:translateY(-1px);box-shadow:0 8px 18px rgba(15,75,191,.14);}
    .vb-btn-outline{border:1px solid #cbd5e1;color:#1e3a8a;background:#fff;}
    .vb-btn-outline:hover{color:#1e3a8a;background:#eef5ff;transform:translateY(-1px);}
    .vb-btn-sm{padding:6px 12px;font-size:13px;min-height:34px;}
    .vb-btn-danger{background:linear-gradient(90deg,#ef4444,#dc2626);}
    .vb-btn-success{background:linear-gradient(90deg,#10b981,#059669);}

    .vb-branch{display:grid;grid-template-columns:1fr auto;align-items:start;gap:14px;padding:18px 0;}
    .vb-branch+.vb-branch{border-top:1px solid #edf2f7;}
    .vb-branch-name{margin:0 0 6px;font-size:17px;font-weight:700;color:#111827;}
    .vb-branch-meta{margin:0;color:#64748b;font-size:14px;line-height:1.6;display:flex;flex-wrap:wrap;align-items:center;gap:10px;}
    .vb-branch-meta i{width:16px;text-align:center;}
    .vb-branch-actions{display:flex;gap:8px;flex-wrap:wrap;}

    .vb-chip{display:inline-flex;align-items:center;justify-content:center;gap:5px;border-radius:999px;padding:5px 11px;font-size:12px;font-weight:700;line-height:1;white-space:nowrap;}
    .vb-chip-active{background:#dcfce7;color:#166534;}
    .vb-chip-inactive{background:#ffe1df;color:#ef5753;}
    .vb-chip-default{background:#dbefff;color:#2285e8;}
    .vb-chip-archived{background:#f1f5f9;color:#64748b;}

    .vb-pagination .pagination{justify-content:center;}
    .vb-pagination .page-link{border-radius:10px;margin:0 4px;color:var(--vb-primary);font-weight:700;}
    .vb-pagination .page-item.active .page-link{background:var(--vb-primary);border-color:var(--vb-primary);color:#fff;}

    .vb-empty{text-align:center;padding:38px 20px;color:#64748b;}
    .vb-empty i{font-size:38px;color:#94a3b8;margin-bottom:10px;display:inline-block;}
    .vb-empty-title{margin:0 0 5px;color:#0f172a;font-size:17px;font-weight:700;}
    .vb-empty-text{margin:0;color:#64748b;font-size:14px;}

    @media(max-width:992px){
        .vb-title{font-size:28px;}
        .vb-branch{grid-template-columns:1fr;}
    }
    @media(max-width:576px){
        .vb-branch{padding:14px 0;}
        .vb-branch-actions{width:100%;}
        .vb-card-head{flex-direction:column;align-items:flex-start;}
    }
</style>
@endsection

@section('content')
@php
    $isAr = app()->getLocale() === 'ar';
    $branchesCount = method_exists($branches, 'total') ? $branches->total() : $branches->count();
@endphp

<main class="vendor-branches">
    @include('flash::message')

    <nav class="vb-breadcrumb mb-3" style="font-size:13px;">
        <a href="{{ route('vendor/dashboard') }}" style="text-decoration:none;color:#6b7280;">{{ $isAr ? 'الرئيسية' : 'Home' }}</a>
        <i class="bi bi-chevron-{{ $isAr ? 'left' : 'right' }}" style="color:#94a3b8;"></i>
        <span style="color:var(--vb-primary);font-weight:700;">{{ __('vendor_branches.my_branches') }}</span>
    </nav>

    <div class="vb-card vb-hero">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h3 class="vb-title">{{ __('vendor_branches.my_branches') }}</h3>
                <p class="vb-hero-subtitle">{{ __('vendor_branches.branches_description') }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('vendor/branches/create') }}" class="vb-btn">
                    <i class="bi bi-plus-lg"></i>
                    {{ __('vendor_branches.add_branch') }}
                </a>
            </div>
        </div>
    </div>

    <div class="vb-card">
        <div class="vb-card-head">
            <div>
                <h6>{{ __('vendor_branches.all_branches') }}</h6>
            </div>
            <span class="vb-chip vb-chip-active">
                <i class="bi bi-geo-alt"></i>
                {{ $branchesCount }} {{ __('vendor_branches.branches') }}
            </span>
        </div>
        <div class="vb-body">
            @forelse($branches as $branch)
                <article class="vb-branch">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h5 class="vb-branch-name">{{ $branch->display_name }}</h5>
                            @if($branch->trashed())
                                <span class="vb-chip vb-chip-archived"><i class="bi bi-archive"></i> {{ $isAr ? 'مؤرشفة' : 'Archived' }}</span>
                            @elseif($branch->is_active)
                                <span class="vb-chip vb-chip-active"><i class="bi bi-check-circle"></i> {{ $isAr ? 'نشط' : 'Active' }}</span>
                            @else
                                <span class="vb-chip vb-chip-inactive"><i class="bi bi-x-circle"></i> {{ $isAr ? 'معطل' : 'Inactive' }}</span>
                            @endif
                            @if($branch->is_default && !$branch->trashed())
                                <span class="vb-chip vb-chip-default"><i class="bi bi-star-fill"></i> {{ $isAr ? 'افتراضي' : 'Default' }}</span>
                            @endif
                        </div>
                        <p class="vb-branch-meta">
                            @if($branch->address)
                                <span><i class="bi bi-geo-alt"></i> {{ $branch->address }}</span>
                            @endif
                            @if($branch->city)
                                <span><i class="bi bi-building"></i> {{ $branch->city }}</span>
                            @endif
                            @if($branch->phone)
                                <span><i class="bi bi-telephone"></i> {{ $branch->phone }}</span>
                            @endif
                            @if($branch->latitude && $branch->longitude)
                                <span><i class="bi bi-pin-map"></i> {{ $branch->latitude }}, {{ $branch->longitude }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="vb-branch-actions">
                        @if($branch->trashed())
                            <form method="POST" action="{{ route('vendor/branches/restore', $branch->id) }}" class="d-inline">
                                @csrf
                                <button class="vb-btn vb-btn-sm vb-btn-success" type="submit">
                                    <i class="bi bi-arrow-counterclockwise"></i> {{ $isAr ? 'استعادة' : 'Restore' }}
                                </button>
                            </form>
                        @else
                            <a href="{{ route('vendor/branches/edit', $branch->id) }}" class="vb-btn vb-btn-sm vb-btn-outline">
                                <i class="bi bi-pencil"></i> {{ $isAr ? 'تعديل' : 'Edit' }}
                            </a>
                            <form method="POST" action="{{ route('vendor/branches/toggle', $branch->id) }}" class="d-inline">
                                @csrf
                                <button class="vb-btn vb-btn-sm {{ $branch->is_active ? 'vb-btn-outline' : 'vb-btn-success' }}" type="submit" title="{{ $branch->is_active ? ($isAr ? 'تعطيل' : 'Deactivate') : ($isAr ? 'تفعيل' : 'Activate') }}">
                                    <i class="bi bi-{{ $branch->is_active ? 'pause-circle' : 'play-circle' }}"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('vendor/branches/delete', $branch->id) }}" class="d-inline" onsubmit="return confirm('{{ $isAr ? 'هل أنت متأكد من حذف هذا الفرع؟' : 'Are you sure you want to delete this branch?' }}');">
                                @csrf
                                @method('DELETE')
                                <button class="vb-btn vb-btn-sm vb-btn-danger" type="submit">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </article>
            @empty
                <div class="vb-empty">
                    <i class="bi bi-geo-alt"></i>
                    <h5 class="vb-empty-title">{{ $isAr ? 'لا توجد فروع' : 'No Branches Yet' }}</h5>
                    <p class="vb-empty-text">{{ $isAr ? 'أضف أول فرع لشركتك باستخدام الزر أعلاه.' : 'Add your first branch using the button above.' }}</p>
                </div>
            @endforelse

            @if(method_exists($branches, 'hasPages') && $branches->hasPages())
                <div class="vb-pagination mt-4">
                    {{ $branches->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</main>
@endsection
