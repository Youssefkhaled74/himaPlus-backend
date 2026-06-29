@extends('layouts.front.home')

@section('title')
<title>{{ __('nav.notifications') }} - Vendor | Hema</title>
@endsection

@section('css')
<style>
    .vendor-notifications-page {
        --brand-primary: #0f4bbf;
        --brand-primary-dark: #0b3a94;
        --brand-accent: #10c7a5;
        --shell-bg: #f3f7fc;
        --card-bg: #ffffff;
        --card-border: #d8e3f0;
        --card-shadow: 0 18px 40px rgba(15, 75, 191, .08);
        --text-main: #10203a;
        --text-muted: #6d7d93;
        --soft-blue: #eef5ff;
        --soft-green: #ecfffb;
        --soft-slate: #f8fafc;
        max-width: 95%;
        margin: 16px auto 32px;
        padding: 0 10px;
    }

    .vn-shell {
        background:
            radial-gradient(circle at top left, rgba(16, 199, 165, .10), transparent 26%),
            radial-gradient(circle at top right, rgba(15, 75, 191, .10), transparent 30%),
            var(--shell-bg);
        border: 1px solid rgba(216, 227, 240, .9);
        border-radius: 28px;
        padding: 18px;
    }

    .vn-hero {
        background: linear-gradient(135deg, var(--brand-primary) 0%, #1565d8 52%, var(--brand-accent) 100%);
        border-radius: 24px;
        padding: 26px;
        color: #fff;
        position: relative;
        overflow: hidden;
        box-shadow: var(--card-shadow);
    }

    .vn-hero::before,
    .vn-hero::after {
        content: "";
        position: absolute;
        border-radius: 999px;
        background: rgba(255, 255, 255, .10);
    }

    .vn-hero::before {
        width: 220px;
        height: 220px;
        top: -120px;
        right: -60px;
    }

    .vn-hero::after {
        width: 160px;
        height: 160px;
        bottom: -70px;
        left: -40px;
    }

    .vn-hero > * {
        position: relative;
        z-index: 1;
    }

    .vn-hero-title {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 900;
    }

    .vn-hero-text {
        margin: 8px 0 0;
        max-width: 680px;
        opacity: .92;
        line-height: 1.8;
        font-size: .95rem;
    }

    .vn-summary-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-top: 18px;
    }

    .vn-summary-card {
        background: rgba(255, 255, 255, .15);
        border: 1px solid rgba(255, 255, 255, .24);
        border-radius: 18px;
        padding: 16px;
        backdrop-filter: blur(8px);
    }

    .vn-summary-card span {
        display: block;
        font-size: .78rem;
        font-weight: 700;
        opacity: .88;
        margin-bottom: 6px;
    }

    .vn-summary-card strong {
        display: block;
        font-size: 1.7rem;
        font-weight: 900;
        line-height: 1;
    }

    .vn-toolbar,
    .vn-list-shell {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 22px;
        box-shadow: 0 10px 25px rgba(16, 32, 58, .05);
    }

    .vn-toolbar {
        margin-top: 18px;
        padding: 18px;
    }

    .vn-toolbar-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
    }

    .vn-toolbar-title {
        font-size: 1rem;
        font-weight: 900;
        color: var(--text-main);
        margin: 0;
    }

    .vn-toolbar-text {
        color: var(--text-muted);
        font-size: .86rem;
        margin: 4px 0 0;
    }

    .vn-toolbar-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .vn-btn,
    .vn-pill {
        border-radius: 999px;
        font-weight: 800;
        transition: all .18s ease;
    }

    .vn-btn {
        border: 1px solid transparent;
        padding: 10px 16px;
        font-size: .84rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .vn-btn-primary {
        background: linear-gradient(135deg, var(--brand-primary), var(--brand-accent));
        color: #fff;
        box-shadow: 0 12px 24px rgba(15, 75, 191, .16);
    }

    .vn-btn-outline {
        background: #fff;
        color: var(--brand-primary);
        border-color: rgba(15, 75, 191, .20);
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
        border: 1px solid var(--card-border);
        background: #fff;
        color: var(--text-muted);
        text-decoration: none;
        font-size: .82rem;
    }

    .vn-pill.active,
    .vn-pill:hover {
        color: var(--brand-primary);
        border-color: rgba(15, 75, 191, .24);
        background: var(--soft-blue);
        text-decoration: none;
    }

    .vn-pill-count {
        display: inline-flex;
        min-width: 26px;
        justify-content: center;
        padding: 2px 8px;
        border-radius: 999px;
        background: rgba(15, 75, 191, .08);
        color: var(--brand-primary);
        font-size: .75rem;
        font-weight: 900;
    }

    .vn-list-shell {
        margin-top: 18px;
        overflow: hidden;
    }

    .vn-list-head {
        padding: 18px 20px;
        border-bottom: 1px solid #edf2f7;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
    }

    .vn-list-title {
        margin: 0;
        font-size: 1rem;
        font-weight: 900;
        color: var(--text-main);
    }

    .vn-list-subtitle {
        margin: 4px 0 0;
        color: var(--text-muted);
        font-size: .84rem;
    }

    .vn-list {
        padding: 18px;
        display: grid;
        gap: 14px;
    }

    .vn-item {
        background: #fff;
        border: 1px solid #e5edf6;
        border-radius: 20px;
        padding: 18px;
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 16px;
        align-items: start;
    }

    .vn-item.unread {
        background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
        border-color: #cfe0ff;
    }

    .vn-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: #fff;
        box-shadow: 0 12px 24px rgba(15, 23, 42, .12);
    }

    .vn-icon.order { background: linear-gradient(135deg, #2563eb, #3b82f6); }
    .vn-icon.payment { background: linear-gradient(135deg, #059669, #10b981); }
    .vn-icon.status-change { background: linear-gradient(135deg, #7c3aed, #8b5cf6); }
    .vn-icon.product-approval { background: linear-gradient(135deg, #0f766e, #14b8a6); }
    .vn-icon.product-rejection { background: linear-gradient(135deg, #dc2626, #f97316); }
    .vn-icon.system { background: linear-gradient(135deg, #64748b, #94a3b8); }

    .vn-item-head {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        margin-bottom: 6px;
    }

    .vn-item-title {
        margin: 0;
        color: var(--text-main);
        font-size: 1rem;
        font-weight: 900;
    }

    .vn-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 900;
    }

    .vn-badge.unread {
        background: var(--soft-green);
        color: #047857;
        border: 1px solid #b8efe3;
    }

    .vn-badge.read {
        background: var(--soft-slate);
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    .vn-type {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 999px;
        background: var(--soft-blue);
        color: var(--brand-primary);
        font-size: .74rem;
        font-weight: 800;
    }

    .vn-message {
        margin: 0;
        color: var(--text-muted);
        line-height: 1.8;
        font-size: .9rem;
        word-break: break-word;
    }

    .vn-meta {
        margin-top: 10px;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        color: #8a99ad;
        font-size: .78rem;
        font-weight: 700;
    }

    .vn-item-side {
        min-width: 180px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: flex-end;
    }

    .vn-time {
        color: var(--text-muted);
        font-size: .78rem;
        font-weight: 700;
    }

    .vn-actions {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 8px;
    }

    .vn-action-btn {
        border: 1px solid #d8e3f0;
        background: #fff;
        color: var(--text-main);
        border-radius: 12px;
        padding: 8px 12px;
        font-size: .78rem;
        font-weight: 800;
        text-decoration: none;
    }

    .vn-action-btn.primary {
        color: var(--brand-primary);
        border-color: rgba(15, 75, 191, .18);
        background: var(--soft-blue);
    }

    .vn-action-btn.danger {
        color: #b91c1c;
        border-color: rgba(220, 38, 38, .18);
        background: #fff5f5;
    }

    .vn-action-btn:hover {
        text-decoration: none;
        transform: translateY(-1px);
    }

    .vn-empty {
        padding: 48px 20px;
        text-align: center;
    }

    .vn-empty-icon {
        width: 72px;
        height: 72px;
        margin: 0 auto 16px;
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--soft-blue);
        color: var(--brand-primary);
        font-size: 1.7rem;
    }

    .vn-empty-title {
        margin: 0;
        color: var(--text-main);
        font-size: 1.05rem;
        font-weight: 900;
    }

    .vn-empty-text {
        margin: 8px auto 0;
        max-width: 460px;
        color: var(--text-muted);
        line-height: 1.8;
        font-size: .88rem;
    }

    .vn-pagination {
        padding: 0 18px 18px;
    }

    .vn-pagination .pagination {
        justify-content: center;
        gap: 6px;
    }

    .vn-pagination .page-link {
        border-radius: 10px !important;
        border: 1px solid #d8e3f0;
        color: var(--text-main);
        font-weight: 800;
        box-shadow: none;
    }

    .vn-pagination .page-item.active .page-link {
        background: var(--brand-primary);
        border-color: var(--brand-primary);
        color: #fff;
    }

    @media (max-width: 991.98px) {
        .vn-summary-grid {
            grid-template-columns: 1fr;
        }

        .vn-item {
            grid-template-columns: 1fr;
        }

        .vn-item-side {
            min-width: 0;
            align-items: flex-start;
        }

        .vn-actions {
            justify-content: flex-start;
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
                                        <a href="{{ $notification->display_url }}" class="vn-action-btn primary">
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
