@extends('layouts.front.home')

@section('title')
<title>{{ __('nav.notifications') ?? 'Notifications' }} - Vendor | HemaPulse</title>
@endsection

@section('css')
<style>
    :root {
        --vn-bg: #f1f3f7;
        --vn-card: #ffffff;
        --vn-border: #dfe4ed;
        --vn-text: #102a43;
        --vn-muted: #6b7280;
        --vn-shadow: 0 18px 40px rgba(15, 23, 42, .12);
        --vn-radius: 18px;
        --vn-primary: #0d6efd;
        --vn-notify-bg: #e9f0ff;
    }

    .vn-page {
        background: var(--vn-card);
        border-radius: 32px;
        padding: 40px;
        box-shadow: 0 24px 60px rgba(15, 23, 42, .12);
        border: none;
    }

    .vn-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }

    .vn-title {
        font-size: 32px;
        font-weight: 700;
        color: #0f4c8c;
        margin: 0;
        letter-spacing: .3px;
    }

    .vn-actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    /* Notification Card */
    .vn-card {
        background: var(--vn-notify-bg);
        border-radius: 16px;
        padding: 18px 24px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 18px;
        transition: transform .12s ease, box-shadow .12s ease;
        text-decoration: none;
        color: inherit;
        position: relative;
        border: none;
    }

    .vn-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 26px rgba(16, 24, 40, .10);
        border-color: rgba(13, 110, 253, .30);
    }

    .vn-card.unread {
        background: #eaf2ff;
    }

    .vn-card.read {
        background: #f8fafc;
        opacity: 0.95;
    }

    /* Icon Container */
    .vn-icon {
        width: 54px;
        height: 54px;
        border-radius: 18px;
        display: grid;
        place-items: center;
        flex: 0 0 auto;
        font-size: 22px;
        box-shadow: 0 12px 24px rgba(15, 23, 42, .12);
    }

    .vn-icon.order {
        background: rgba(59, 130, 246, .12);
        color: #1e40af;
        border: 1px solid rgba(59, 130, 246, .20);
    }

    .vn-icon.offer {
        background: rgba(168, 85, 247, .12);
        color: #7c3aed;
        border: 1px solid rgba(168, 85, 247, .20);
    }

    .vn-icon.scheduled {
        background: rgba(251, 191, 36, .12);
        color: #92400e;
        border: 1px solid rgba(251, 191, 36, .20);
    }

    .vn-icon.rating {
        background: rgba(34, 197, 94, .12);
        color: #166534;
        border: 1px solid rgba(34, 197, 94, .20);
    }

    .vn-icon.system {
        background: rgba(148, 163, 184, .12);
        color: #475569;
        border: 1px solid rgba(148, 163, 184, .20);
    }

    /* Content */
    .vn-content {
        flex: 1;
        min-width: 0;
    }

    .vn-header-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 6px;
    }

    .vn-card-title {
        font-weight: 700;
        font-size: 16px;
        color: var(--vn-text);
        margin: 0;
    }

    .vn-badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 8px;
        font-size: 10px;
        font-weight: 800;
        border-radius: 999px;
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .vn-message {
        font-size: 14px;
        color: var(--vn-muted);
        margin: 4px 0 0 0;
        line-height: 1.6;
    }

    /* Time */
    .vn-time {
        flex: 0 0 auto;
        text-align: right;
        font-size: 12px;
        color: var(--vn-muted);
        white-space: nowrap;
        min-width: 110px;
    }

    /* Filter buttons */
    .vn-filters {
        display: flex;
        gap: 10px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 8px 16px;
        border-radius: 999px;
        border: 1px solid var(--vn-border);
        background: var(--vn-card);
        color: var(--vn-muted);
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        transition: all .15s ease;
    }

    .filter-btn:hover {
        border-color: rgba(13, 110, 253, .22);
        color: var(--vn-primary);
    }

    .filter-btn.active {
        background: var(--vn-primary);
        border-color: var(--vn-primary);
        color: #fff;
    }

    /* Pagination */
    .vn-pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .vn-pagination .pagination {
        gap: 6px;
    }

    .vn-pagination .page-link {
        border-radius: 8px !important;
        border: 1px solid var(--vn-border);
        color: #374151;
        padding: 6px 10px;
        font-weight: 700;
        box-shadow: none;
    }

    .vn-pagination .page-item.active .page-link {
        background: #0b5ed7;
        border-color: #0b5ed7;
        color: #fff;
    }

    @media (max-width: 768px) {
        .vn-card {
            padding: 14px;
            flex-direction: column;
            align-items: flex-start;
        }

        .vn-time {
            text-align: left;
            margin-top: 8px;
        }
    }
</style>
@endsection

@section('content')
<main class="container-fluid my-5" style="max-width: 1200px;">
    @include('flash::message')

    <div class="vn-page">
        <!-- Breadcrumb -->
        <nav class="mb-3" style="font-size:12px;">
            <a href="{{ route('vendor/dashboard') }}" class="text-decoration-none text-muted">{{ __('nav.dashboard') ?? 'Dashboard' }}</a>
            <span class="text-muted mx-1">/</span>
            <span class="text-primary fw-bold">{{ __('nav.notifications') ?? 'Notifications' }}</span>
        </nav>

        <!-- Header -->
        <div class="vn-header">
            <h4 class="vn-title">{{ __('nav.notifications') ?? 'Notifications' }}</h4>
            <div class="vn-actions">
                @if($counts['unread'] > 0)
                <form method="POST" action="{{ route('vendor/notifications/mark-all-as-read') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-primary" style="border-radius:10px;font-weight:800;">
                        <i class="bi bi-check-all"></i> {{ __('nav.mark_all_read') ?? 'Mark All as Read' }}
                    </button>
                </form>
                @endif
            </div>
        </div>

        <!-- Filters -->
        <div class="vn-filters">
            <a href="{{ route('vendor/notifications', ['filter' => 'all']) }}"
                class="filter-btn {{ $filter === 'all' ? 'active' : '' }}">
                {{ __('nav.all') ?? 'All' }} ({{ $counts['total'] }})
            </a>
            <a href="{{ route('vendor/notifications', ['filter' => 'unread']) }}"
                class="filter-btn {{ $filter === 'unread' ? 'active' : '' }}">
                {{ __('nav.unread') ?? 'Unread' }} ({{ $counts['unread'] }})
            </a>
            <a href="{{ route('vendor/notifications', ['filter' => 'read']) }}"
                class="filter-btn {{ $filter === 'read' ? 'active' : '' }}">
                {{ __('nav.read') ?? 'Read' }}
            </a>
        </div>

        <!-- Notifications List -->
        @forelse($notifications as $notification)
        <div class="vn-card {{ is_null($notification->read_at) ? 'unread' : 'read' }}">
            <!-- Icon -->
            <div class="vn-icon {{ $notification->type ?? 'system' }}">
                @switch($notification->type)
                @case('order')
                <i class="bi bi-receipt"></i>
                @break
                @case('offer')
                <i class="bi bi-chat-quote"></i>
                @break
                @case('scheduled')
                <i class="bi bi-calendar-check"></i>
                @break
                @case('rating')
                <i class="bi bi-star-fill"></i>
                @break
                @default
                <i class="bi bi-bell-fill"></i>
                @endswitch
            </div>

            <!-- Content -->
            <div class="vn-content">
                <div class="vn-header-row">
                    <h6 class="vn-card-title">{{ $notification->title ?? __('nav.notification') ?? 'Notification' }}</h6>
                    @if(is_null($notification->read_at))
                    <span class="vn-badge">{{ __('nav.new') ?? 'New' }}</span>
                    @endif
                </div>
                <p class="vn-message">{{ $notification->message ?? $notification->content ?? '—' }}</p>
            </div>

            <!-- Time & Actions -->
            <div class="vn-time">
                {{ $notification->created_at->diffForHumans() }}

                @if(is_null($notification->read_at))
                <form method="POST" action="{{ route('vendor/notifications/mark-as-read', $notification->id) }}" style="display:inline;margin-top:8px;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-link p-0" style="font-size:11px;">
                        <i class="bi bi-check"></i> {{ __('nav.mark_read') ?? 'Mark Read' }}
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <i class="bi bi-bell-slash" style="font-size:48px;color:#cbd5e1;"></i>
            <p class="text-muted mt-3">{{ __('nav.no_notifications') ?? 'No notifications yet' }}</p>
        </div>
        @endforelse

        <!-- Pagination -->
        @if($notifications->hasPages())
        <div class="vn-pagination">
            {{ $notifications->appends(['filter' => $filter])->links('pagination::bootstrap-4') }}
        </div>
        @endif

    </div>
</main>
@endsection
