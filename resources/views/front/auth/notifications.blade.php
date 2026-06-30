@extends('layouts.front.home')

@section('title')
<title>{{ __('nav.notifications') }} - {{ __('nav.dashboard') }}</title>
@endsection

@section('css')
<style>
    .user-notifications-page {
        --brand-primary: #0f4bbf;
        --brand-primary-dark: #0b3a94;
        --brand-accent: #10c7a5;
        --shell-bg: #f3f7fc;
        --card-bg: #ffffff;
        --card-border: #d8e3f0;
        --text-main: #10203a;
        --text-muted: #6d7d93;
        --soft-blue: #eef5ff;
        --soft-green: #ecfffb;
        --soft-slate: #f8fafc;
        --shadow: 0 18px 40px rgba(15, 75, 191, .08);
        max-width: 95%;
        margin: 16px auto 32px;
        padding: 0 10px;
    }

    .un-shell {
        background:
            radial-gradient(circle at top left, rgba(16, 199, 165, .10), transparent 26%),
            radial-gradient(circle at top right, rgba(15, 75, 191, .10), transparent 30%),
            var(--shell-bg);
        border: 1px solid rgba(216, 227, 240, .9);
        border-radius: 28px;
        padding: 18px;
    }

    .un-hero,
    .un-toolbar,
    .un-list-shell {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 22px;
        box-shadow: 0 10px 25px rgba(16, 32, 58, .05);
    }

    .un-hero {
        background: linear-gradient(135deg, var(--brand-primary) 0%, #1565d8 52%, var(--brand-accent) 100%);
        color: #fff;
        border: 0;
        padding: 26px;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow);
    }

    .un-hero::before {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .10);
        top: -120px;
        {{ app()->getLocale() === 'ar' ? 'left' : 'right' }}: -60px;
    }

    .un-hero > * {
        position: relative;
        z-index: 1;
    }

    .un-hero-title {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 900;
    }

    .un-hero-text {
        margin: 8px 0 0;
        max-width: 680px;
        opacity: .94;
        line-height: 1.8;
        font-size: .95rem;
    }

    .un-summary-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-top: 18px;
    }

    .un-summary-card {
        background: rgba(255, 255, 255, .14);
        border: 1px solid rgba(255, 255, 255, .24);
        border-radius: 18px;
        padding: 16px;
        backdrop-filter: blur(8px);
    }

    .un-summary-card span {
        display: block;
        font-size: .78rem;
        font-weight: 700;
        opacity: .88;
        margin-bottom: 6px;
    }

    .un-summary-card strong {
        display: block;
        font-size: 1.7rem;
        font-weight: 900;
        line-height: 1;
    }

    .un-toolbar {
        margin-top: 18px;
        padding: 18px;
    }

    .un-toolbar-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
    }

    .un-toolbar-title {
        margin: 0;
        font-size: 1rem;
        font-weight: 900;
        color: var(--text-main);
    }

    .un-toolbar-text {
        margin: 4px 0 0;
        color: var(--text-muted);
        font-size: .86rem;
    }

    .un-toolbar-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .un-btn,
    .un-pill,
    .un-action-btn {
        border-radius: 999px;
        font-weight: 800;
        transition: all .18s ease;
    }

    .un-btn {
        border: 1px solid transparent;
        padding: 10px 16px;
        font-size: .84rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .un-btn-primary {
        background: linear-gradient(135deg, var(--brand-primary), var(--brand-accent));
        color: #fff;
        box-shadow: 0 12px 24px rgba(15, 75, 191, .16);
    }

    .un-btn-outline {
        background: #fff;
        color: var(--brand-primary);
        border-color: rgba(15, 75, 191, .20);
    }

    .un-btn-outline:hover,
    .un-btn-primary:hover,
    .un-action-btn:hover,
    .un-pill:hover {
        transform: translateY(-1px);
        text-decoration: none;
    }

    .un-filter-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 12px;
    }

    .un-pill {
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

    .un-pill.active,
    .un-pill:hover {
        color: var(--brand-primary);
        border-color: rgba(15, 75, 191, .24);
        background: var(--soft-blue);
        text-decoration: none;
    }

    .un-pill-count {
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

    .un-list-shell {
        margin-top: 18px;
        overflow: hidden;
    }

    .un-list-head {
        padding: 18px 20px;
        border-bottom: 1px solid #edf2f7;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
    }

    .un-list-title {
        margin: 0;
        font-size: 1rem;
        font-weight: 900;
        color: var(--text-main);
    }

    .un-list-subtitle {
        margin: 4px 0 0;
        color: var(--text-muted);
        font-size: .84rem;
    }

    .un-list {
        padding: 18px;
        display: grid;
        gap: 14px;
    }

    .un-item {
        background: #fff;
        border: 1px solid #e5edf6;
        border-radius: 20px;
        padding: 18px;
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 16px;
        align-items: start;
        position: relative;
    }

    .un-item.unread {
        background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
        border-color: #cfe0ff;
        box-shadow: inset 4px 0 0 var(--brand-primary);
    }

    .un-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: #fff;
        box-shadow: 0 12px 24px rgba(15, 23, 42, .12);
        background: linear-gradient(135deg, var(--brand-primary), var(--brand-accent));
    }

    .un-item-head {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        margin-bottom: 6px;
    }

    .un-item-title {
        margin: 0;
        color: var(--text-main);
        font-size: 1rem;
        font-weight: 900;
    }

    .un-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 900;
    }

    .un-badge.unread {
        background: var(--soft-green);
        color: #047857;
        border: 1px solid #b8efe3;
    }

    .un-badge.read {
        background: var(--soft-slate);
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    .un-message {
        margin: 0;
        color: var(--text-muted);
        line-height: 1.8;
        font-size: .9rem;
        word-break: break-word;
    }

    .un-meta {
        margin-top: 10px;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        color: #8a99ad;
        font-size: .78rem;
        font-weight: 700;
    }

    .un-item-side {
        min-width: 180px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: flex-end;
    }

    .un-time {
        color: var(--text-muted);
        font-size: .78rem;
        font-weight: 700;
    }

    .un-actions {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 8px;
    }

    .un-action-btn {
        border: 1px solid #d8e3f0;
        background: #fff;
        color: var(--text-main);
        border-radius: 12px;
        padding: 8px 12px;
        font-size: .78rem;
        font-weight: 800;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .un-action-btn.primary {
        color: var(--brand-primary);
        border-color: rgba(15, 75, 191, .18);
        background: var(--soft-blue);
    }

    .un-action-btn.danger {
        color: #b91c1c;
        border-color: rgba(220, 38, 38, .18);
        background: #fff5f5;
    }

    .un-empty {
        padding: 48px 20px;
        text-align: center;
    }

    .un-empty-icon {
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

    .un-empty-title {
        margin: 0;
        color: var(--text-main);
        font-size: 1.05rem;
        font-weight: 900;
    }

    .un-empty-text {
        margin: 8px auto 0;
        max-width: 460px;
        color: var(--text-muted);
        line-height: 1.8;
        font-size: .88rem;
    }

    .un-pagination {
        padding: 0 18px 18px;
    }

    .un-pagination .pagination {
        justify-content: center;
        gap: 6px;
    }

    .un-pagination .page-link {
        border-radius: 10px !important;
        border: 1px solid #d8e3f0;
        color: var(--text-main);
        font-weight: 800;
        box-shadow: none;
    }

    .un-pagination .page-item.active .page-link {
        background: var(--brand-primary);
        border-color: var(--brand-primary);
        color: #fff;
    }

    @media (max-width: 991.98px) {
        .un-summary-grid {
            grid-template-columns: 1fr;
        }

        .un-item {
            grid-template-columns: 1fr;
        }

        .un-item-side {
            min-width: 0;
            align-items: flex-start;
        }

        .un-actions {
            justify-content: flex-start;
        }
    }

    @media (max-width: 767.98px) {
        .user-notifications-page {
            margin-top: 10px;
        }

        .un-shell {
            padding: 12px;
            border-radius: 22px;
        }

        .un-hero {
            padding: 20px;
            border-radius: 18px;
        }

        .un-hero-title {
            font-size: 1.25rem;
        }

        .un-toolbar-head {
            align-items: flex-start;
            flex-direction: column;
        }

        .un-list-head {
            align-items: flex-start;
            flex-direction: column;
        }

        .un-item {
            padding: 14px;
        }
    }
</style>
@endsection

@section('content')
<main class="container user-notifications-page">
    @include('flash::message')

    @php
        $currentFilter = $filter ?? request('filter', 'all');
        $allNotificationsUrl = route('user/notifications', [0, PAGINATION_COUNT]);
        $resetNotificationsUrl = request()->url();
        $allTabUrl = $allNotificationsUrl;
        $readTabUrl = request()->url() . '?filter=read';
        $unreadTabUrl = request()->url() . '?filter=unread';
    @endphp

    <div class="un-shell">
        <section class="un-hero">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                <div>
                    <h1 class="un-hero-title">{{ __('nav.notifications') }}</h1>
                    <p class="un-hero-text">{{ __('nav.notifications_description') }}</p>
                </div>

                <a href="{{ route('user/dashboard') }}" class="un-btn un-btn-outline">
                    <i class="bi bi-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
                    {{ __('nav.dashboard') }}
                </a>
            </div>

            <div class="un-summary-grid">
                <div class="un-summary-card">
                    <span>{{ __('nav.all') }}</span>
                    <strong>{{ $totalNotifications }}</strong>
                </div>
                <div class="un-summary-card">
                    <span>{{ __('nav.unread') }}</span>
                    <strong>{{ $unreadNotifications }}</strong>
                </div>
                <div class="un-summary-card">
                    <span>{{ __('nav.read') }}</span>
                    <strong>{{ max($totalNotifications - $unreadNotifications, 0) }}</strong>
                </div>
            </div>
        </section>

        <section class="un-toolbar">
            <div class="un-toolbar-head">
                <div>
                    <h2 class="un-toolbar-title">{{ __('nav.recent_notifications') }}</h2>
                    <p class="un-toolbar-text">{{ __('nav.notifications_description') }}</p>
                </div>

                <div class="un-toolbar-actions">
                    @if($unreadNotifications > 0)
                        <form method="POST" action="{{ route('user/notifications/mark-all-as-read') }}">
                            @csrf
                            <button type="submit" class="un-btn un-btn-primary">
                                <i class="bi bi-check2-all"></i>
                                {{ __('nav.mark_all_as_read') }}
                            </button>
                        </form>
                    @endif

                    @if($currentFilter !== 'all')
                        <a href="{{ $resetNotificationsUrl }}" class="un-btn un-btn-outline">
                            <i class="bi bi-arrow-clockwise"></i>
                            {{ __('nav.reset') }}
                        </a>
                    @endif
                </div>
            </div>

            <div class="un-filter-group">
                <a href="{{ $allTabUrl }}" class="un-pill {{ $currentFilter === 'all' ? 'active' : '' }}">
                    {{ __('nav.all') }}
                    <span class="un-pill-count">{{ $totalNotifications }}</span>
                </a>
                <a href="{{ $readTabUrl }}" class="un-pill {{ $currentFilter === 'read' ? 'active' : '' }}">
                    {{ __('nav.read') }}
                    <span class="un-pill-count">{{ max($totalNotifications - $unreadNotifications, 0) }}</span>
                </a>
                <a href="{{ $unreadTabUrl }}" class="un-pill {{ $currentFilter === 'unread' ? 'active' : '' }}">
                    {{ __('nav.unread') }}
                    <span class="un-pill-count">{{ $unreadNotifications }}</span>
                </a>
            </div>
        </section>

        <section class="un-list-shell">
            <div class="un-list-head">
                <div>
                    <h3 class="un-list-title">{{ __('nav.notification') }}</h3>
                    <p class="un-list-subtitle">{{ __('nav.notifications_description') }}</p>
                </div>
            </div>

            @if($notifications->count())
                <div class="un-list">
                    @foreach($notifications as $notification)
                        @php
                            $isUnread = is_null($notification->read_at);
                            $title = $notification->display_title ?? ($notification->title ?: __('nav.notification'));
                            $message = $notification->display_message ?? ($notification->content ?: ($notification->message ?: ''));
                            $actionUrl = $notification->display_url ?? $notification->action_url;
                            $timestamp = $notification->created_at;
                            $timeLabel = $timestamp ? $timestamp->diffForHumans() : '';
                        @endphp

                        <article class="un-item {{ $isUnread ? 'unread' : '' }}">
                            <div class="un-icon">
                                <i class="bi {{ $notification->icon ?? ($isUnread ? 'bi-bell-fill' : 'bi-bell') }}"></i>
                            </div>

                            <div>
                                <div class="un-item-head">
                                    <h4 class="un-item-title">{{ $title }}</h4>
                                    <span class="un-badge {{ $isUnread ? 'unread' : 'read' }}">
                                        <i class="bi {{ $isUnread ? 'bi-circle-fill' : 'bi-check2-circle' }}"></i>
                                        {{ $isUnread ? __('nav.unread') : __('nav.read') }}
                                    </span>
                                </div>

                                @if($message)
                                    <p class="un-message">{{ $message }}</p>
                                @endif

                                <div class="un-meta">
                                    <span>
                                        <i class="bi bi-clock-history"></i>
                                        {{ $timeLabel }}
                                    </span>
                                    @if($notification->created_at)
                                        <span>
                                            <i class="bi bi-calendar2-week"></i>
                                            {{ $timestamp->format('Y-m-d H:i') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="un-item-side">
                                <div class="un-time">{{ $timeLabel }}</div>

                                <div class="un-actions">
                                    @if($actionUrl)
                                        <a href="{{ $actionUrl }}" class="un-action-btn primary">
                                            <i class="bi bi-box-arrow-up-right"></i>
                                            {{ __('nav.view') }}
                                        </a>
                                    @endif

                                    @if($isUnread)
                                        <form method="POST" action="{{ route('user/notifications/mark-as-read', $notification->id) }}">
                                            @csrf
                                            <button type="submit" class="un-action-btn">
                                                <i class="bi bi-check2"></i>
                                                {{ __('nav.mark_as_read') }}
                                            </button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('user/notifications/delete', $notification->id) }}" onsubmit="return confirm('{{ __('nav.confirm_delete') }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="un-action-btn danger">
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
                    <div class="un-pagination">
                        {{ $notifications->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @else
                <div class="un-empty">
                    <div class="un-empty-icon">
                        <i class="bi bi-bell-slash"></i>
                    </div>
                    <h4 class="un-empty-title">{{ __('nav.no_notifications') }}</h4>
                    <p class="un-empty-text">{{ __('nav.notifications_description') }}</p>
                </div>
            @endif
        </section>
    </div>
</main>
@endsection

@section('script')
<script>
    $(function () {
        $('#nav-dashboard').addClass('active');
    });
</script>
@endsection
