@extends('layouts.front.home')

@section('title')
<title>{{ __('nav.notifications') }} - Vendor | Hema</title>
@endsection

@section('css')
<style>
    .vendor-notifications-page {
        --vd-bg: #f5f6f8;
        --vd-card: #ffffff;
        --vd-border: #e7eaf0;
        --vd-title: #0f2f7f;
        --vd-text: #1f2937;
        --vd-muted: #6b7280;
        --vd-primary: #0f4bbf;
        --vd-accent: #0ec6a0;
        max-width: 95%;
        margin: 12px auto 0;
        background: var(--vd-bg);
        padding: 8px 0 24px;
        font-family: "Poppins", "Tajawal", system-ui, -apple-system, "Segoe UI", Arial, sans-serif;
    }

    .vendor-notifications-page * {
        font-family: inherit;
    }

    .vn-shell {
        display: grid;
        gap: 16px;
    }

    .vn-hero,
    .vn-toolbar,
    .vn-list-shell {
        background: var(--vd-card);
        border: 1px solid var(--vd-border);
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.04);
    }

    .vn-hero {
        padding: 22px;
    }

    .vn-hero > .d-flex {
        gap: 16px !important;
    }

    .vn-hero-title {
        margin: 0 0 6px;
        color: var(--vd-title);
        font-size: 34px;
        line-height: 1.08;
        font-weight: 800;
        letter-spacing: -0.01em;
    }

    .vn-hero-text {
        margin: 0;
        color: #475569;
        font-size: 16px;
        line-height: 1.55;
        max-width: 760px;
    }

    .vn-summary-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-top: 18px;
    }

    .vn-summary-card {
        background: #fff;
        border: 1px solid var(--vd-border);
        border-radius: 14px;
        padding: 16px;
        box-shadow: 0 4px 12px rgba(15, 75, 191, .05);
    }

    .vn-summary-card span {
        display: block;
        margin-bottom: 6px;
        color: var(--vd-muted);
        font-size: 13px;
        font-weight: 600;
    }

    .vn-summary-card strong {
        display: block;
        color: var(--vd-text);
        font-size: 34px;
        line-height: 1;
        font-weight: 800;
    }

    .vn-toolbar {
        padding: 18px;
    }

    .vn-toolbar-head,
    .vn-list-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .vn-toolbar-head {
        margin-bottom: 14px;
    }

    .vn-toolbar-title,
    .vn-list-title {
        margin: 0;
        color: #0f172a;
        font-size: 20px;
        font-weight: 700;
        line-height: 1.1;
    }

    .vn-toolbar-text,
    .vn-list-subtitle {
        margin: 4px 0 0;
        color: var(--vd-muted);
        font-size: 14px;
    }

    .vn-toolbar-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .vn-btn,
    .vn-pill,
    .vn-action-btn {
        border-radius: 10px;
        font-weight: 700;
        transition: all .18s ease;
    }

    .vn-btn {
        border: 1px solid transparent;
        padding: 10px 16px;
        font-size: 14px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .vn-btn-primary {
        background: linear-gradient(90deg, var(--vd-primary) 0%, var(--vd-accent) 100%);
        color: #fff;
        box-shadow: 0 10px 22px rgba(15, 75, 191, .14);
    }

    .vn-btn-outline {
        background: #fff;
        color: #1e3a8a;
        border-color: #cbd5e1;
    }

    .vn-filter-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 12px;
    }

    .vn-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border: 1px solid var(--vd-border);
        background: #fff;
        color: var(--vd-muted);
        text-decoration: none;
        font-size: 13px;
    }

    .vn-pill.active,
    .vn-pill:hover {
        color: var(--vd-primary);
        border-color: #bfdbfe;
        background: #eef5ff;
        text-decoration: none;
    }

    .vn-pill-count {
        display: inline-flex;
        min-width: 26px;
        justify-content: center;
        padding: 2px 8px;
        border-radius: 999px;
        background: rgba(15, 75, 191, .08);
        color: var(--vd-primary);
        font-size: 12px;
        font-weight: 800;
    }

    .vn-list-shell {
        overflow: hidden;
    }

    .vn-list-head {
        padding: 14px 18px;
        border-bottom: 1px solid var(--vd-border);
    }

    .vn-list {
        padding: 10px 18px 16px;
        display: grid;
        gap: 12px;
    }

    .vn-item {
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 16px;
        align-items: start;
        padding: 16px;
        border: 1px solid var(--vd-border);
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.03);
    }

    .vn-item.unread {
        border-color: #bfdbfe;
        background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
    }

    .vn-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: grid;
        place-items: center;
        color: #fff;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .vn-icon.primary { background: linear-gradient(135deg, var(--vd-primary), #4f8cff); }
    .vn-icon.success { background: linear-gradient(135deg, var(--vd-accent), #2dd4bf); }
    .vn-icon.warning { background: linear-gradient(135deg, #f59e0b, #f97316); }
    .vn-icon.danger { background: linear-gradient(135deg, #ef4444, #f87171); }

    .vn-item-head {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
    }

    .vn-item-title {
        margin: 0;
        color: var(--vd-text);
        font-size: 17px;
        font-weight: 700;
    }

    .vn-type,
    .vn-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }

    .vn-type {
        background: #f8fafc;
        color: var(--vd-muted);
    }

    .vn-badge.unread {
        background: #eef5ff;
        color: var(--vd-primary);
    }

    .vn-badge.read {
        background: #ecfffb;
        color: #0f9f7a;
    }

    .vn-message {
        margin: 0;
        color: var(--vd-text);
        line-height: 1.65;
        font-size: 15px;
        word-break: break-word;
    }

    .vn-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 12px;
        color: var(--vd-muted);
        font-size: 12px;
    }

    .vn-meta span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .vn-item-side {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 12px;
        min-width: 170px;
    }

    .vn-time {
        color: var(--vd-muted);
        font-size: 12px;
        font-weight: 700;
    }

    .vn-actions {
        display: flex;
        flex-direction: column;
        gap: 8px;
        align-items: stretch;
        width: 100%;
    }

    .vn-action-btn {
        border: 1px solid #cbd5e1;
        background: #fff;
        color: #1f2937;
        padding: 9px 12px;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        text-decoration: none;
    }

    .vn-action-btn.primary {
        background: linear-gradient(90deg, var(--vd-primary) 0%, var(--vd-accent) 100%);
        color: #fff;
        border-color: transparent;
    }

    .vn-action-btn.danger {
        color: #dc2626;
    }

    .vn-action-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(15, 23, 42, .07);
    }

    .vn-pagination {
        padding: 8px 18px 18px;
    }

    .vn-pagination .pagination {
        margin-bottom: 0;
        justify-content: center;
        flex-wrap: wrap;
        gap: 6px;
    }

    .vn-pagination .page-link {
        border-radius: 10px;
        color: var(--vd-primary);
        border-color: var(--vd-border);
        padding: 8px 12px;
        min-width: 40px;
        text-align: center;
    }

    .vn-pagination .page-item.active .page-link {
        background: linear-gradient(90deg, var(--vd-primary) 0%, var(--vd-accent) 100%);
        border-color: transparent;
        color: #fff;
    }

    .vn-empty {
        padding: 54px 20px;
        text-align: center;
    }

    .vn-empty-icon {
        width: 84px;
        height: 84px;
        border-radius: 22px;
        margin: 0 auto 16px;
        display: grid;
        place-items: center;
        background: #eef5ff;
        color: var(--vd-primary);
        font-size: 2rem;
    }

    .vn-empty-title {
        margin: 0;
        color: var(--vd-text);
        font-size: 20px;
        font-weight: 800;
    }

    .vn-empty-text {
        margin: 10px auto 0;
        max-width: 500px;
        color: var(--vd-muted);
        line-height: 1.7;
    }

    @media (max-width: 991.98px) {
        .vn-summary-grid {
            grid-template-columns: 1fr;
        }

        .vn-toolbar-head {
            flex-direction: column;
            align-items: flex-start;
        }

        .vn-item {
            grid-template-columns: 1fr;
        }

        .vn-item-side {
            align-items: flex-start;
            min-width: 0;
        }
    }

    @media (max-width: 767.98px) {
        .vendor-notifications-page {
            max-width: 100%;
            margin-top: 0;
            padding: 0 4px 20px;
        }

        .vn-hero,
        .vn-toolbar,
        .vn-list-shell {
            border-radius: 12px;
        }

        .vn-hero-title {
            font-size: 28px;
        }

        .vn-list-head,
        .vn-list {
            padding-left: 14px;
            padding-right: 14px;
        }

        .vn-list {
            padding-top: 12px;
        }

        .vn-item {
            padding: 14px;
        }

        .vn-actions {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<main class="vendor-notifications-page">
    @include('flash::message')

    <div class="vn-shell">
        <section class="vn-hero">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                <div>
                    <h1 class="vn-hero-title">{{ __('nav.notifications') }}</h1>
                    <p class="vn-hero-text">{{ __('nav.notifications_description') }}</p>
                </div>

                <a href="{{ route('vendor/dashboard') }}" class="vn-btn vn-btn-outline">
                    <i class="bi bi-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
                    {{ __('nav.dashboard') }}
                </a>
            </div>

            <div class="vn-summary-grid">
                <div class="vn-summary-card">
                    <span>{{ __('nav.all') }}</span>
                    <strong>{{ $counts['total'] }}</strong>
                </div>
                <div class="vn-summary-card">
                    <span>{{ __('nav.unread') }}</span>
                    <strong>{{ $counts['unread'] }}</strong>
                </div>
                <div class="vn-summary-card">
                    <span>{{ __('nav.read') }}</span>
                    <strong>{{ $counts['read'] }}</strong>
                </div>
            </div>
        </section>

        <section class="vn-toolbar">
            <div class="vn-toolbar-head">
                <div>
                    <h2 class="vn-toolbar-title">{{ __('nav.notification') }}</h2>
                    <p class="vn-toolbar-text">{{ __('nav.notifications_desc') }}</p>
                </div>

                <div class="vn-toolbar-actions">
                    @if($counts['unread'] > 0)
                        <form method="POST" action="{{ route('vendor/notifications/mark-all-as-read') }}">
                            @csrf
                            <button type="submit" class="vn-btn vn-btn-primary">
                                <i class="bi bi-check2-all"></i>
                                {{ __('nav.mark_all_read') }}
                            </button>
                        </form>
                    @endif

                    @if($selectedType || $filter !== 'all')
                        <a href="{{ route('vendor/notifications') }}" class="vn-btn vn-btn-outline">
                            <i class="bi bi-arrow-clockwise"></i>
                            {{ __('nav.reset') }}
                        </a>
                    @endif
                </div>
            </div>

            <div class="vn-filter-group">
                <a href="{{ route('vendor/notifications', ['filter' => 'all', 'type' => $selectedType]) }}" class="vn-pill {{ $filter === 'all' ? 'active' : '' }}">
                    {{ __('nav.all') }}
                    <span class="vn-pill-count">{{ $counts['total'] }}</span>
                </a>
                <a href="{{ route('vendor/notifications', ['filter' => 'unread', 'type' => $selectedType]) }}" class="vn-pill {{ $filter === 'unread' ? 'active' : '' }}">
                    {{ __('nav.unread') }}
                    <span class="vn-pill-count">{{ $counts['unread'] }}</span>
                </a>
                <a href="{{ route('vendor/notifications', ['filter' => 'read', 'type' => $selectedType]) }}" class="vn-pill {{ $filter === 'read' ? 'active' : '' }}">
                    {{ __('nav.read') }}
                    <span class="vn-pill-count">{{ $counts['read'] }}</span>
                </a>
            </div>

            <div class="vn-filter-group">
                <a href="{{ route('vendor/notifications', ['filter' => $filter]) }}" class="vn-pill {{ !$selectedType ? 'active' : '' }}">
                    {{ __('nav.all') }}
                    <span class="vn-pill-count">{{ $counts['total'] }}</span>
                </a>
                @foreach($typeOptions as $typeKey => $typeLabel)
                    <a href="{{ route('vendor/notifications', ['filter' => $filter, 'type' => $typeKey]) }}" class="vn-pill {{ $selectedType === $typeKey ? 'active' : '' }}">
                        {{ $typeLabel }}
                        <span class="vn-pill-count">{{ $counts['types'][$typeKey] ?? 0 }}</span>
                    </a>
                @endforeach
            </div>
        </section>

        <section class="vn-list-shell">
            <div class="vn-list-head">
                <div>
                    <h3 class="vn-list-title">{{ __('nav.recent_notifications') }}</h3>
                    <p class="vn-list-subtitle">{{ __('nav.notifications_description') }}</p>
                </div>
            </div>

            @if($notifications->count())
                <div class="vn-list">
                    @foreach($notifications as $notification)
                        <article class="vn-item {{ $notification->is_unread ? 'unread' : '' }}">
                            <div class="vn-icon {{ $notification->icon_class }}">
                                <i class="bi {{ $notification->icon }}"></i>
                            </div>

                            <div>
                                <div class="vn-item-head">
                                    <h4 class="vn-item-title">{{ $notification->display_title }}</h4>
                                    <span class="vn-type">{{ $notification->type_label }}</span>
                                    <span class="vn-badge {{ $notification->is_unread ? 'unread' : 'read' }}">
                                        <i class="bi {{ $notification->is_unread ? 'bi-circle-fill' : 'bi-check2-circle' }}"></i>
                                        {{ $notification->is_unread ? __('nav.unread') : __('nav.read') }}
                                    </span>
                                </div>

                                <p class="vn-message">{{ $notification->display_message }}</p>

                                <div class="vn-meta">
                                    <span>
                                        <i class="bi bi-clock-history"></i>
                                        {{ optional($notification->created_at)->diffForHumans() }}
                                    </span>
                                    <span>
                                        <i class="bi bi-calendar2-week"></i>
                                        {{ optional($notification->created_at)->format('Y-m-d H:i') }}
                                    </span>
                                </div>
                            </div>

                            <div class="vn-item-side">
                                <div class="vn-time">{{ optional($notification->created_at)->diffForHumans() }}</div>

                                <div class="vn-actions">
                                    @if($notification->display_url)
                                        <a href="{{ route('vendor/notifications/open', $notification->id) }}" class="vn-action-btn primary">
                                            <i class="bi bi-box-arrow-up-right"></i>
                                            {{ __('nav.view') }}
                                        </a>
                                    @endif

                                    @if($notification->is_unread)
                                        <form method="POST" action="{{ route('vendor/notifications/mark-as-read', $notification->id) }}">
                                            @csrf
                                            <button type="submit" class="vn-action-btn">
                                                <i class="bi bi-check2"></i>
                                                {{ __('nav.mark_read') }}
                                            </button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('vendor/notifications/delete', $notification->id) }}" onsubmit="return confirm('{{ __('nav.delete') }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="vn-action-btn danger">
                                            <i class="bi bi-trash3"></i>
                                            {{ __('nav.delete') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if($notifications->hasPages())
                    <div class="vn-pagination">
                        {{ $notifications->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            @else
                <div class="vn-empty">
                    <div class="vn-empty-icon">
                        <i class="bi bi-bell-slash"></i>
                    </div>
                    <h4 class="vn-empty-title">{{ __('nav.no_notifications') }}</h4>
                    <p class="vn-empty-text">{{ __('nav.notifications_description') }}</p>
                </div>
            @endif
        </section>
    </div>
</main>
@endsection

