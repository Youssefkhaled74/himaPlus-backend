@extends('layouts.front.home')

@section('title')
<title>{{ app()->getLocale() === 'ar' ? 'الإشعارات' : 'Notifications' }}</title>
@endsection

@section('css')
<style>
    .notif-page {
        --brand-primary: #0f4bbf;
        --brand-primary-dark: #0b3a94;
        --brand-accent: #10c7a5;
        --dash-bg: #f3f7fc;
        --dash-card: #ffffff;
        --dash-border: #d8e3f0;
        --dash-title: #10203a;
        --dash-text: #1f2937;
        --dash-muted: #6d7d93;
        --dash-soft: #eef6ff;
        --dash-shadow: 0 14px 35px rgba(15, 75, 191, 0.08);
        margin-top: 1.5rem;
        margin-bottom: 3rem;
        color: var(--dash-text);
    }

    .notif-shell {
        background:
            radial-gradient(circle at top left, rgba(16, 199, 165, .12), transparent 32%),
            radial-gradient(circle at top right, rgba(15, 75, 191, .11), transparent 35%),
            var(--dash-bg);
        border: 1px solid rgba(216, 227, 240, .8);
        border-radius: 26px;
        padding: 1.2rem;
    }

    .notif-hero {
        background: linear-gradient(135deg, var(--brand-primary) 0%, #1565d8 52%, var(--brand-accent) 100%);
        border-radius: 22px;
        padding: 1.6rem 1.8rem;
        color: #fff;
        position: relative;
        overflow: hidden;
        box-shadow: var(--dash-shadow);
    }

    .notif-hero::before {
        content: '';
        position: absolute;
        width: 230px;
        height: 230px;
        border-radius: 50%;
        background: rgba(255,255,255,.11);
        top: -110px;
        {{ app()->getLocale() === 'ar' ? 'left' : 'right' }}: -70px;
    }

    .notif-hero > * {
        position: relative;
        z-index: 1;
    }

    .notif-title {
        margin: 0;
        font-size: 1.45rem;
        font-weight: 850;
        letter-spacing: -.02em;
    }

    .notif-subtitle {
        margin: .4rem 0 0;
        max-width: 650px;
        opacity: .9;
        font-size: .92rem;
        line-height: 1.7;
    }

    .notif-summary {
        display: flex;
        flex-wrap: wrap;
        gap: .75rem;
        justify-content: flex-end;
    }

    .notif-pill {
        min-width: 120px;
        border: 1px solid rgba(255,255,255,.26);
        background: rgba(255,255,255,.13);
        border-radius: 16px;
        padding: .75rem .95rem;
        backdrop-filter: blur(8px);
    }

    .notif-pill span {
        display: block;
        font-size: .72rem;
        font-weight: 750;
        opacity: .85;
        margin-bottom: .2rem;
    }

    .notif-pill strong {
        display: block;
        font-size: 1.35rem;
        line-height: 1;
        font-weight: 900;
    }

    .notif-card {
        background: var(--dash-card);
        border: 1px solid var(--dash-border);
        border-radius: 20px;
        box-shadow: 0 8px 22px rgba(16, 32, 58, .04);
        overflow: hidden;
    }

    .notif-card-header {
        padding: 1.05rem 1.15rem;
        border-bottom: 1px solid #edf2f7;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .notif-card-header strong {
        color: var(--dash-title);
        font-weight: 850;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .notif-card-header strong i {
        color: var(--brand-primary);
    }

    .notif-back {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        color: var(--brand-primary);
        font-size: .84rem;
        font-weight: 800;
        text-decoration: none;
    }

    .notif-back:hover {
        color: var(--brand-primary-dark);
        text-decoration: none;
    }

    .notif-list {
        display: flex;
        flex-direction: column;
    }

    .notif-item {
        display: flex;
        align-items: flex-start;
        gap: .85rem;
        padding: 1rem 1.15rem;
        border-bottom: 1px solid #edf2f7;
        color: inherit;
        text-decoration: none;
        transition: background .18s ease;
    }

    .notif-item:last-child {
        border-bottom: 0;
    }

    .notif-item:hover {
        background: #f8fbff;
        color: inherit;
        text-decoration: none;
    }

    .notif-icon {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: linear-gradient(135deg, var(--brand-primary), var(--brand-accent));
        color: #fff;
        box-shadow: 0 10px 20px rgba(15, 75, 191, .14);
    }

    .notif-body {
        flex: 1;
        min-width: 0;
    }

    .notif-name {
        color: var(--dash-title);
        font-weight: 850;
        font-size: .92rem;
        margin-bottom: .25rem;
    }

    .notif-message {
        color: var(--dash-muted);
        font-size: .82rem;
        line-height: 1.65;
        margin-bottom: .45rem;
        word-break: break-word;
    }

    .notif-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: .55rem;
        color: #8a99ad;
        font-size: .75rem;
        font-weight: 650;
    }

    .notif-status {
        display: inline-flex;
        align-items: center;
        gap: .25rem;
        border-radius: 999px;
        padding: .25rem .62rem;
        font-size: .7rem;
        font-weight: 850;
    }

    .notif-status.unread {
        background: #ecfffb;
        color: #047b68;
        border: 1px solid #b8efe3;
    }

    .notif-status.read {
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    .notif-empty {
        text-align: center;
        padding: 2.4rem 1rem;
        color: var(--dash-muted);
    }

    .notif-empty-icon {
        width: 58px;
        height: 58px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 18px;
        color: var(--brand-primary);
        background: var(--dash-soft);
        font-size: 1.45rem;
        margin-bottom: .8rem;
    }

    .notif-empty h6 {
        color: var(--dash-title);
        font-weight: 850;
        margin-bottom: .25rem;
    }

    .notif-pagination {
        padding: 1rem 1.15rem;
        border-top: 1px solid #edf2f7;
    }

    @media (max-width: 767.98px) {
        .notif-page {
            margin-top: .75rem;
        }

        .notif-shell {
            padding: .75rem;
            border-radius: 20px;
        }

        .notif-hero {
            padding: 1.25rem;
            border-radius: 18px;
        }

        .notif-title {
            font-size: 1.18rem;
        }

        .notif-summary {
            justify-content: flex-start;
            width: 100%;
        }

        .notif-pill {
            min-width: 0;
            flex: 1;
        }

        .notif-card-header {
            align-items: flex-start;
        }

        .notif-item {
            padding: .9rem;
        }
    }
</style>
@endsection

@section('content')
<main class="container notif-page">
    @include('flash::message')

    <div class="notif-shell">
        <section class="notif-hero mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h4 class="notif-title">
                        {{ app()->getLocale() === 'ar' ? 'الإشعارات' : 'Notifications' }}
                    </h4>
                    <p class="notif-subtitle">
                        {{ app()->getLocale() === 'ar'
                            ? 'تابع آخر تحديثات طلباتك وحسابك من مكان واحد.'
                            : 'Follow the latest updates about your orders and account from one place.' }}
                    </p>
                </div>

                <div class="notif-summary">
                    <div class="notif-pill">
                        <span>{{ app()->getLocale() === 'ar' ? 'كل الإشعارات' : 'Total' }}</span>
                        <strong>{{ $totalNotifications }}</strong>
                    </div>
                    <div class="notif-pill">
                        <span>{{ app()->getLocale() === 'ar' ? 'غير مقروءة' : 'Unread' }}</span>
                        <strong>{{ $unreadNotifications }}</strong>
                    </div>
                </div>
            </div>
        </section>

        <section class="notif-card">
            <div class="notif-card-header">
                <strong>
                    <i class="bi bi-bell-fill"></i>
                    {{ app()->getLocale() === 'ar' ? 'قائمة الإشعارات' : 'Notification List' }}
                </strong>

                <a href="{{ route('user/dashboard') }}" class="notif-back">
                    <i class="bi bi-chevron-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
                    {{ app()->getLocale() === 'ar' ? 'الرجوع للوحة التحكم' : 'Back to Dashboard' }}
                </a>
            </div>

            @if($notifications->count())
                <div class="notif-list">
                    @foreach($notifications as $notification)
                        @php
                            $title = $notification->title ?: (app()->getLocale() === 'ar' ? 'إشعار جديد' : 'New notification');
                            $message = $notification->content ?: ($notification->message ?: '');
                            $isUnread = is_null($notification->read_at);
                            $url = $notification->action_url;

                            if (!$url && $notification->order_id) {
                                $url = route('user/get/order', $notification->order_id);
                            }
                        @endphp

                        <a href="{{ $url ?: 'javascript:void(0)' }}" class="notif-item">
                            <div class="notif-icon">
                                <i class="bi {{ $isUnread ? 'bi-bell-fill' : 'bi-bell' }}"></i>
                            </div>

                            <div class="notif-body">
                                <div class="notif-name">{{ $title }}</div>

                                @if($message)
                                    <div class="notif-message">{{ $message }}</div>
                                @endif

                                <div class="notif-meta">
                                    <span>
                                        <i class="bi bi-calendar2-week"></i>
                                        {{ optional($notification->created_at)->format('Y-m-d H:i') }}
                                    </span>

                                    <span class="notif-status {{ $isUnread ? 'unread' : 'read' }}">
                                        <i class="bi {{ $isUnread ? 'bi-circle-fill' : 'bi-check2-circle' }}"></i>
                                        {{ $isUnread
                                            ? (app()->getLocale() === 'ar' ? 'غير مقروء' : 'Unread')
                                            : (app()->getLocale() === 'ar' ? 'مقروء' : 'Read') }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="notif-pagination">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="notif-empty">
                    <div class="notif-empty-icon">
                        <i class="bi bi-bell-slash"></i>
                    </div>
                    <h6>{{ app()->getLocale() === 'ar' ? 'لا توجد إشعارات' : 'No notifications' }}</h6>
                    <p class="mb-0 small">
                        {{ app()->getLocale() === 'ar'
                            ? 'عند وصول أي تحديث جديد سيظهر هنا.'
                            : 'When new updates arrive, they will appear here.' }}
                    </p>
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
