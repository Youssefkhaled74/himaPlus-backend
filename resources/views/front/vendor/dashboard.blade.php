
@extends('layouts.front.home')

@php
    $pageTitle = __('nav.dashboard');
    $pageTitle = $pageTitle === 'nav.dashboard' ? 'Dashboard' : $pageTitle;
@endphp

@section('title')
    <title>{{ $pageTitle }} - Vendor | HemaPulse</title>
@endsection

@section('css')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap');

    :root {
        --bg: #edf4fb;
        --surface: rgba(255,255,255,.82);
        --card: #fff;
        --border: rgba(15,23,42,.08);
        --border-strong: rgba(37,99,235,.16);
        --text: #0f172a;
        --muted: #64748b;
        --primary: #175cd3;
        --shadow: 0 24px 60px rgba(15,23,42,.12);
        --shadow-sm: 0 12px 28px rgba(15,23,42,.08);
    }

    body, .vendor-dashboard, .vendor-dashboard * {
        font-family: "Tajawal", system-ui, sans-serif;
    }

    .vendor-dashboard {
        min-height: 100vh;
        padding: 28px 18px 42px;
        background:
            radial-gradient(circle at top right, rgba(37,99,235,.18), transparent 22%),
            linear-gradient(180deg, #f8fbff 0%, var(--bg) 100%);
    }

    .dashboard-shell {
        max-width: 1360px;
        margin: 0 auto;
        padding: 24px;
        border-radius: 30px;
        background: var(--surface);
        backdrop-filter: blur(18px);
        box-shadow: var(--shadow);
    }

    .vendor-dashboard.rtl {
        direction: rtl;
        text-align: right;
    }

    .hero {
        display: grid;
        grid-template-columns: 1.4fr .8fr;
        gap: 16px;
        padding: 28px;
        border-radius: 28px;
        margin-bottom: 20px;
        color: #fff;
        background: linear-gradient(135deg, #0f172a 0%, #123873 45%, #175cd3 100%);
        height: auto;
        align-items: stretch;
    }

    .hero-badge, .hero-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 999px;
        background: rgba(255,255,255,.1);
        border: 1px solid rgba(255,255,255,.14);
        font-weight: 700;
        font-size: 14px;
    }

    .hero h1 {
        margin: 16px 0 10px;
        font-size: 42px;
        line-height: 1.08;
        font-weight: 800;
    }

    .vendor-dashboard.rtl .hero {
        grid-template-columns: .8fr 1.4fr;
    }

    .hero p {
        margin: 0;
        color: rgba(255,255,255,.82);
        line-height: 1.8;
        font-size: 15px;
    }

    .hero-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 18px;
    }

    .vendor-dashboard.rtl .hero-pills {
        justify-content: flex-start;
    }

    .hero-stat {
        min-width: 150px;
        padding: 14px 16px;
        border-radius: 18px;
        background: rgba(255,255,255,.1);
        border: 1px solid rgba(255,255,255,.14);
    }

    .hero-stat span {
        display: block;
    }

    .hero-stat .label {
        color: rgba(255,255,255,.72);
        font-size: 13px;
        margin-bottom: 6px;
    }

    .hero-stat .value, .hero-side .value {
        font-size: 28px;
        font-weight: 800;
    }

    .hero-side {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 14px;
        padding: 22px;
        border-radius: 24px;
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(255,255,255,.14);
    }

    .hero-side .label, .hero-side .meta {
        color: rgba(255,255,255,.78);
        font-size: 14px;
    }

    .section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 12px;
    }

    .section-head h2, .panel-head h5 {
        margin: 0;
        font-size: 22px;
        font-weight: 800;
        color: var(--text);
    }

    .section-head p, .panel-head p {
        margin: 4px 0 0;
        color: var(--muted);
        font-size: 14px;
    }

    .stats-grid, .attention-grid, .actions-grid, .content-grid {
        display: grid;
        gap: 14px;
    }

    .stats-grid { grid-template-columns: repeat(4, minmax(0,1fr)); margin-bottom: 18px; }
    .attention-grid { grid-template-columns: repeat(4, minmax(0,1fr)); padding: 18px; }
    .actions-grid { grid-template-columns: repeat(4, minmax(0,1fr)); padding: 18px; }
    .content-grid { grid-template-columns: repeat(2, minmax(0,1fr)); margin-bottom: 18px; }

    .stat-card, .panel, .attention-card, .action-card {
        background: var(--card);
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
    }

    .stat-card {
        position: relative;
        padding: 18px;
        min-height: 158px;
        border-radius: 22px;
        overflow: hidden;
        transition: .18s ease;
    }

    .stat-card:hover, .attention-card:hover, .action-card:hover {
        transform: translateY(-3px);
        border-color: var(--border-strong);
    }

    .stat-card::before {
        content: "";
        position: absolute;
        top: 0; right: 0; left: 0;
        height: 4px;
        background: var(--accent, #175cd3);
    }

    .stat-top, .attention-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
    }

    .stat-chip {
        display: inline-flex;
        gap: 6px;
        align-items: center;
        padding: 6px 10px;
        border-radius: 999px;
        background: rgba(15,23,42,.04);
        color: var(--muted);
        font-size: 12px;
        font-weight: 700;
    }

    .stat-icon, .attention-icon, .action-icon {
        width: 48px;
        height: 48px;
        border-radius: 15px;
        display: grid;
        place-items: center;
        font-size: 18px;
        color: var(--icon-color, #175cd3);
        background: var(--icon-bg, rgba(23,92,211,.12));
    }
    .stat-value, .attention-value {
        margin: 18px 0 8px;
        font-size: 34px;
        line-height: 1;
        font-weight: 800;
        color: var(--text);
    }

    .stat-label, .attention-label, .action-title {
        color: var(--text);
        font-size: 15px;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .stat-meta, .attention-desc, .action-desc, .list-sub, .list-time {
        color: var(--muted);
        font-size: 13px;
        line-height: 1.7;
    }

    .stat-orders { --accent:#175cd3; --icon-bg:rgba(23,92,211,.12); --icon-color:#175cd3; }
    .stat-offers { --accent:#9333ea; --icon-bg:rgba(147,51,234,.12); --icon-color:#9333ea; }
    .stat-products { --accent:#0891b2; --icon-bg:rgba(8,145,178,.12); --icon-color:#0891b2; }
    .stat-rating { --accent:#16a34a; --icon-bg:rgba(22,163,74,.12); --icon-color:#16a34a; }
    .stat-scheduled { --accent:#ea580c; --icon-bg:rgba(234,88,12,.12); --icon-color:#ea580c; }
    .stat-completed { --accent:#059669; --icon-bg:rgba(5,150,105,.12); --icon-color:#059669; }
    .stat-acceptance { --accent:#0284c7; --icon-bg:rgba(2,132,199,.12); --icon-color:#0284c7; }
    .stat-revenue { --accent:#0f172a; --icon-bg:rgba(15,23,42,.08); --icon-color:#0f172a; }

    .panel {
        border-radius: 22px;
        overflow: hidden;
        margin-bottom: 18px;
    }

    .panel-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 18px 20px;
        border-bottom: 1px solid rgba(15,23,42,.06);
    }

    .panel-link {
        text-decoration: none;
        color: var(--primary);
        font-weight: 700;
        font-size: 14px;
    }

    .vendor-dashboard.rtl .section-head,
    .vendor-dashboard.rtl .panel-head,
    .vendor-dashboard.rtl .list-item,
    .vendor-dashboard.rtl .stat-top,
    .vendor-dashboard.rtl .attention-top {
        text-align: right;
    }

    .vendor-dashboard.rtl .action-card,
    .vendor-dashboard.rtl .tip-card {
        flex-direction: row-reverse;
        text-align: right;
    }

    .vendor-dashboard.rtl .hero-badge,
    .vendor-dashboard.rtl .hero-chip,
    .vendor-dashboard.rtl .stat-chip {
        flex-direction: row-reverse;
    }

    .vendor-dashboard.rtl .panel-link,
    .vendor-dashboard.rtl .list-time,
    .vendor-dashboard.rtl .stat-meta,
    .vendor-dashboard.rtl .action-desc {
        text-align: right;
    }

    .attention-card, .action-card {
        display: block;
        text-decoration: none;
        color: inherit;
        border-radius: 18px;
        padding: 18px;
        transition: .18s ease;
    }

    .attention-card {
        background: linear-gradient(180deg, #fff 0%, #f8fbff 100%);
    }

    .action-card {
        display: flex;
        gap: 14px;
        align-items: flex-start;
    }

    .attention-alert {
        margin: 0 18px 18px;
        padding: 14px 16px;
        border-radius: 16px;
        border: 1px solid rgba(217,119,6,.16);
        background: rgba(251,191,36,.12);
        color: #92400e;
        font-weight: 700;
    }

    .list-wrap { padding: 6px 0; }

    .list-item {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 14px;
        padding: 16px 20px;
        border-top: 1px solid rgba(15,23,42,.06);
    }

    .list-item:first-child { border-top: 0; }
    .list-title { margin: 0; color: var(--text); font-size: 15px; font-weight: 800; }
    .list-time { white-space: nowrap; font-weight: 700; }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 7px 11px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
        border: 1px solid transparent;
    }

    .status-pending { background: rgba(245,158,11,.12); color: #92400e; border-color: rgba(245,158,11,.22); }
    .status-accepted { background: rgba(34,197,94,.12); color: #166534; border-color: rgba(34,197,94,.22); }
    .status-rejected { background: rgba(239,68,68,.12); color: #991b1b; border-color: rgba(239,68,68,.22); }

    .empty-state {
        padding: 34px 20px;
        text-align: center;
        color: var(--muted);
    }

    .empty-state i {
        display: block;
        font-size: 24px;
        margin-bottom: 8px;
        color: #94a3b8;
    }

    .tip-card {
        display: flex;
        gap: 14px;
        align-items: flex-start;
        padding: 18px 20px;
        border-radius: 22px;
        border: 1px solid rgba(23,92,211,.12);
        background: linear-gradient(135deg, rgba(23,92,211,.08), rgba(8,145,178,.05));
    }

    @media (max-width: 1199px) {
        .stats-grid, .attention-grid, .actions-grid { grid-template-columns: repeat(2, minmax(0,1fr)); }
    }

    @media (max-width: 991px) {
        .dashboard-shell { padding: 18px; }
        .hero, .content-grid { grid-template-columns: 1fr; }
        .hero h1 { font-size: 34px; }
    }

    @media (max-width: 767px) {
        .vendor-dashboard { padding: 18px 10px 32px; }
        .dashboard-shell { padding: 14px; border-radius: 22px; }
        .hero { padding: 20px; border-radius: 22px; }
        .hero h1 { font-size: 28px; }
        .stats-grid, .attention-grid, .actions-grid, .content-grid { grid-template-columns: 1fr; }
        .panel-head, .list-item, .section-head { flex-direction: column; align-items: flex-start; }
        .list-time { white-space: normal; }
    }
</style>
@endsection

@section('content')
@php
    $isRtl = app()->getLocale() === 'ar';
    $copy = $isRtl ? [
        'nav.vendor_portal' => 'بوابة الموردين',
        'nav.welcome' => 'مرحبًا',
        'nav.dashboard_description' => 'إدارة أعمالك وعرض التحليلات',
        'nav.relevant_orders' => 'الطلبات المرتبطة بك',
        'nav.active_products' => 'المنتجات النشطة',
        'nav.unread_notifications' => 'الإشعارات غير المقروءة',
        'nav.estimated_revenue' => 'الإيراد التقديري',
        'nav.acceptance_rate' => 'معدل قبول العروض',
        'nav.completed_orders' => 'الطلبات المكتملة',
        'nav.dashboard_overview' => 'نظرة سريعة',
        'nav.dashboard_overview_desc' => 'ملخص مباشر لأهم المؤشرات التي تهمك في إدارة نشاطك اليومي.',
        'nav.live_data' => 'بيانات مباشرة',
        'nav.orders_received' => 'الطلبات المستلمة',
        'nav.orders_received_desc' => 'يشمل الطلبات المسندة لك أو الطلبات التي شاركت فيها بعرض.',
        'nav.pipeline' => 'قيد المتابعة',
        'nav.offers_made' => 'العروض المقدمة',
        'nav.offers_made_desc' => 'جميع العروض التي قدمتها داخل المنصة حتى الآن.',
        'nav.catalog' => 'الكتالوج',
        'nav.active_products_desc' => 'المنتجات الظاهرة والمتاحة حاليًا للعملاء.',
        'nav.customer_feedback' => 'تقييم العملاء',
        'nav.average_rating' => 'متوسط التقييم',
        'nav.review_count' => 'تقييمًا مسجلًا حتى الآن',
        'nav.recurring' => 'متابعة دورية',
        'nav.scheduled_orders' => 'الطلبات المجدولة',
        'nav.scheduled_orders_desc' => 'طلبات تحتاج متابعة متكررة حسب الجدولة.',
        'nav.fulfillment' => 'التنفيذ',
        'nav.completed_orders_desc' => 'طلبات وصلت إلى مرحلة الإكمال داخل دورة العمل.',
        'nav.performance' => 'الأداء',
        'nav.accepted_offers' => 'عرضًا مقبولًا من إجمالي عروضك',
        'nav.finance' => 'الجانب المالي',
        'nav.estimated_revenue_desc' => 'إجمالي قيمة العروض المقبولة حتى الآن.',
        'nav.requires_attention' => 'يحتاج متابعة',
        'nav.priority_actions' => 'هذه العناصر تستحق أولويتك الآن.',
        'nav.new_requests' => 'طلبات تحتاج مراجعة',
        'nav.new_requests_desc' => 'طلبات جديدة أو مفتوحة قد تحتاج عرضًا أو متابعة سريعة.',
        'nav.pending_offers' => 'العروض المعلقة',
        'nav.pending_offers_desc' => 'عروض لا تزال بانتظار رد أو حسم نهائي.',
        'nav.inactive_products' => 'منتجات غير نشطة',
        'nav.inactive_products_desc' => 'منتجاتك المخفية حاليًا والتي لا تظهر للعملاء.',
        'nav.unread_notifications_desc' => 'تنبيهات مهمة داخل لوحة المورد لم تتم مراجعتها بعد.',
        'nav.low_stock_warning' => 'تنبيه مخزون منخفض',
        'nav.products_need_restock' => 'منتج قد يحتاج إلى إعادة تزويد قريبًا.',
        'nav.quick_actions' => 'الإجراءات السريعة',
        'nav.shortcuts' => 'اختصارات مباشرة للمهام الأكثر استخدامًا.',
        'nav.add_product' => 'إضافة منتج',
        'nav.add_product_desc' => 'أنشئ منتجًا جديدًا وابدأ عرضه بسرعة داخل المنصة.',
        'nav.view_products' => 'إدارة المنتجات',
        'nav.view_products_desc' => 'راجع الأسعار والمخزون والتفاصيل من مكان واحد.',
        'nav.view_orders' => 'إدارة الطلبات',
        'nav.view_orders_desc' => 'تابع الطلبات الجديدة والتسليمات وحركة التنفيذ.',
        'nav.view_offers' => 'إدارة العروض',
        'nav.view_offers_desc' => 'راجع العروض المعلقة والمقبولة والمرفوضة.',
        'nav.ratings' => 'التقييمات',
        'nav.ratings_desc' => 'اطلع على تقييمات العملاء وما تعكسه عن الأداء.',
        'profile.profile' => 'الملف الشخصي',
        'nav.profile_desc' => 'حدّث بيانات نشاطك والمعلومات التي تبني الثقة.',
        'nav.analytics' => 'التحليلات',
        'nav.analytics_desc' => 'راجع الاتجاهات والمؤشرات الأعمق للأداء.',
        'nav.recent_orders' => 'أحدث الطلبات',
        'nav.recent_orders_desc' => 'آخر الطلبات المرتبطة بحسابك داخل المنصة.',
        'nav.view_all' => 'عرض الكل',
        'nav.order' => 'طلب',
        'nav.unknown' => 'غير معروف',
        'nav.no_orders' => 'لا توجد طلبات حتى الآن.',
        'nav.pending_offers_panel_desc' => 'العروض التي لا تزال بانتظار الرد النهائي.',
        'nav.offer' => 'عرض',
        'nav.purchase_order' => 'طلب شراء',
        'nav.maintenance_request' => 'طلب صيانة',
        'nav.quotation_request' => 'طلب تسعير',
        'nav.no_pending_offers' => 'لا توجد عروض معلقة حاليًا.',
        'nav.recent_scheduled_orders' => 'أحدث الطلبات المجدولة',
        'nav.recent_scheduled_orders_desc' => 'أقرب الطلبات المتكررة ضمن جدول التنفيذ.',
        'nav.scheduled_order' => 'طلب مجدول',
        'nav.no_scheduled_orders' => 'لا توجد طلبات مجدولة حاليًا.',
        'nav.recent_notifications' => 'أحدث الإشعارات',
        'nav.recent_notifications_desc' => 'آخر التنبيهات والتحديثات التي وصلت إلى حسابك.',
        'nav.notification' => 'إشعار',
        'nav.new' => 'جديد',
        'nav.no_notifications' => 'لا توجد إشعارات حتى الآن.',
        'nav.dashboard_tip_title' => 'نصيحة سريعة',
        'nav.dashboard_info' => 'احرص على تحديث بياناتك والرد السريع على الطلبات والعروض المعلقة لرفع فرص القبول وزيادة العائد.',
    ] : [];

    $t = function ($key, $fallback = null) use ($copy) {
        $value = __($key);
        $broken = $value === $key || str_contains($value, 'Ø') || str_contains($value, 'Ù') || str_contains($value, 'Â');
        return $broken ? ($copy[$key] ?? $fallback ?? $key) : $value;
    };

    $pendingOffersTotal = $pendingOffersCount ?? ($pendingOffers->count() ?? 0);
@endphp

<main class="vendor-dashboard{{ $isRtl ? ' rtl' : '' }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    @include('flash::message')

    <div class="dashboard-shell">
        <section class="hero">
            <div>
                <span class="hero-badge">
                    <i class="bi bi-shield-check"></i>
                    {{ $t('nav.vendor_portal', 'Vendor Portal') }}
                </span>
                <h1>{{ $t('nav.welcome', 'Welcome') }}, {{ auth()->user()->name }}</h1>
                <p>{{ $t('nav.dashboard_description', 'Track store performance, monitor key requests, and move quickly on the actions that need your attention today.') }}</p>

                <div class="hero-pills">
                    <div class="hero-stat">
                        <span class="label">{{ $t('nav.relevant_orders', 'Relevant Orders') }}</span>
                        <span class="value">{{ number_format($ordersCount) }}</span>
                    </div>
                    <div class="hero-stat">
                        <span class="label">{{ $t('nav.active_products', 'Active Products') }}</span>
                        <span class="value">{{ number_format($productsCount) }}</span>
                    </div>
                    <div class="hero-stat">
                        <span class="label">{{ $t('nav.unread_notifications', 'Unread Notifications') }}</span>
                        <span class="value">{{ number_format($unreadNotificationsCount) }}</span>
                    </div>
                </div>
            </div>

            <div class="hero-side">
                <div>
                    <div class="label">{{ $t('nav.estimated_revenue', 'Estimated Revenue') }}</div>
                    <div class="value">{{ number_format((float) $estimatedRevenue, 0) }}</div>
                </div>
                <div class="hero-chip"><i class="bi bi-graph-up-arrow"></i>{{ $t('nav.acceptance_rate', 'Acceptance Rate') }}: {{ $acceptanceRate }}%</div>
                <div class="meta"><i class="bi bi-check2-circle me-1"></i>{{ $t('nav.completed_orders', 'Completed Orders') }}: {{ number_format($completedOrdersCount) }}</div>
            </div>
        </section>

        <div class="section-head">
            <div>
                <h2>{{ $t('nav.dashboard_overview', 'Quick Overview') }}</h2>
                <p>{{ $t('nav.dashboard_overview_desc', 'A direct summary of the metrics that matter most for your daily workflow.') }}</p>
            </div>
        </div>

        <section class="stats-grid">
            <article class="stat-card stat-orders">
                <div class="stat-top">
                    <div class="stat-chip"><i class="bi bi-arrow-repeat"></i>{{ $t('nav.live_data', 'Live Data') }}</div>
                    <div class="stat-icon"><i class="bi bi-bag"></i></div>
                </div>
                <div class="stat-value">{{ number_format($ordersCount) }}</div>
                <div class="stat-label">{{ $t('nav.orders_received', 'Orders Related To You') }}</div>
                <div class="stat-meta">{{ $t('nav.orders_received_desc', 'Includes orders assigned to you or orders where you submitted an offer.') }}</div>
            </article>

            <article class="stat-card stat-offers">
                <div class="stat-top">
                    <div class="stat-chip"><i class="bi bi-chat-dots"></i>{{ $t('nav.pipeline', 'In Progress') }}</div>
                    <div class="stat-icon"><i class="bi bi-chat-left-text"></i></div>
                </div>
                <div class="stat-value">{{ number_format($offersCount) }}</div>
                <div class="stat-label">{{ $t('nav.offers_made', 'Submitted Offers') }}</div>
                <div class="stat-meta">{{ $t('nav.offers_made_desc', 'All offers you have submitted across the platform so far.') }}</div>
            </article>

            <article class="stat-card stat-products">
                <div class="stat-top">
                    <div class="stat-chip"><i class="bi bi-box-seam"></i>{{ $t('nav.catalog', 'Catalog') }}</div>
                    <div class="stat-icon"><i class="bi bi-box"></i></div>
                </div>
                <div class="stat-value">{{ number_format($productsCount) }}</div>
                <div class="stat-label">{{ $t('nav.active_products', 'Active Products') }}</div>
                <div class="stat-meta">{{ $t('nav.active_products_desc', 'Products currently visible and available to customers.') }}</div>
            </article>

            <article class="stat-card stat-rating">
                <div class="stat-top">
                    <div class="stat-chip"><i class="bi bi-star-fill"></i>{{ $t('nav.customer_feedback', 'Customer Rating') }}</div>
                    <div class="stat-icon"><i class="bi bi-award"></i></div>
                </div>
                <div class="stat-value">{{ number_format($avgRating, 1) }}</div>
                <div class="stat-label">{{ $t('nav.average_rating', 'Average Rating') }}</div>
                <div class="stat-meta">{{ $ratingCount }} {{ $t('nav.review_count', 'reviews recorded so far') }}</div>
            </article>

            <article class="stat-card stat-scheduled">
                <div class="stat-top">
                    <div class="stat-chip"><i class="bi bi-calendar-check"></i>{{ $t('nav.recurring', 'Recurring') }}</div>
                    <div class="stat-icon"><i class="bi bi-calendar-event"></i></div>
                </div>
                <div class="stat-value">{{ number_format($scheduledOrdersCount ?? 0) }}</div>
                <div class="stat-label">{{ $t('nav.scheduled_orders', 'Scheduled Orders') }}</div>
                <div class="stat-meta">{{ $t('nav.scheduled_orders_desc', 'Requests that need recurring follow-up on scheduled dates.') }}</div>
            </article>

            <article class="stat-card stat-completed">
                <div class="stat-top">
                    <div class="stat-chip"><i class="bi bi-check2-circle"></i>{{ $t('nav.fulfillment', 'Fulfillment') }}</div>
                    <div class="stat-icon"><i class="bi bi-check2-square"></i></div>
                </div>
                <div class="stat-value">{{ number_format($completedOrdersCount) }}</div>
                <div class="stat-label">{{ $t('nav.completed_orders', 'Completed Orders') }}</div>
                <div class="stat-meta">{{ $t('nav.completed_orders_desc', 'Orders that reached the completed phase in the workflow.') }}</div>
            </article>

            <article class="stat-card stat-acceptance">
                <div class="stat-top">
                    <div class="stat-chip"><i class="bi bi-graph-up-arrow"></i>{{ $t('nav.performance', 'Performance') }}</div>
                    <div class="stat-icon"><i class="bi bi-bar-chart-line"></i></div>
                </div>
                <div class="stat-value">{{ $acceptanceRate }}%</div>
                <div class="stat-label">{{ $t('nav.acceptance_rate', 'Acceptance Rate') }}</div>
                <div class="stat-meta">{{ $acceptedOffersCount }} {{ $t('nav.accepted_offers', 'accepted offers from your total offers') }}</div>
            </article>

            <article class="stat-card stat-revenue">
                <div class="stat-top">
                    <div class="stat-chip"><i class="bi bi-cash-coin"></i>{{ $t('nav.finance', 'Financials') }}</div>
                    <div class="stat-icon"><i class="bi bi-wallet2"></i></div>
                </div>
                <div class="stat-value">{{ number_format((float) $estimatedRevenue, 0) }}</div>
                <div class="stat-label">{{ $t('nav.estimated_revenue', 'Estimated Revenue') }}</div>
                <div class="stat-meta">{{ $t('nav.estimated_revenue_desc', 'Total value of accepted offers so far.') }}</div>
            </article>
        </section>

        <section class="panel">
            <div class="panel-head">
                <div>
                    <h5>{{ $t('nav.requires_attention', 'Requires Attention') }}</h5>
                    <p>{{ $t('nav.priority_actions', 'These items deserve your focus right now.') }}</p>
                </div>
            </div>

            <div class="attention-grid">
                <a href="{{ route('vendor/orders', ['tab' => 'quotations']) }}" class="attention-card">
                    <div class="attention-top">
                        <div class="attention-icon"><i class="bi bi-clipboard-check"></i></div>
                        <div class="attention-value">{{ number_format($newRequestsCount) }}</div>
                    </div>
                    <div class="attention-label">{{ $t('nav.new_requests', 'Requests To Review') }}</div>
                    <div class="attention-desc">{{ $t('nav.new_requests_desc', 'New or open requests that may need a quick quotation or follow-up.') }}</div>
                </a>

                <a href="{{ route('vendor/orders/my-offers') }}" class="attention-card">
                    <div class="attention-top">
                        <div class="attention-icon"><i class="bi bi-hourglass-split"></i></div>
                        <div class="attention-value">{{ number_format($pendingOffersTotal) }}</div>
                    </div>
                    <div class="attention-label">{{ $t('nav.pending_offers', 'Pending Offers') }}</div>
                    <div class="attention-desc">{{ $t('nav.pending_offers_desc', 'Offers that still need a response or decision.') }}</div>
                </a>

                <a href="{{ route('vendor/products', ['status' => 'inactive']) }}" class="attention-card">
                    <div class="attention-top">
                        <div class="attention-icon"><i class="bi bi-eye-slash"></i></div>
                        <div class="attention-value">{{ number_format($inactiveProductsCount) }}</div>
                    </div>
                    <div class="attention-label">{{ $t('nav.inactive_products', 'Inactive Products') }}</div>
                    <div class="attention-desc">{{ $t('nav.inactive_products_desc', 'Hidden products that are not currently visible to customers.') }}</div>
                </a>

                <a href="{{ route('vendor/notifications', ['filter' => 'unread']) }}" class="attention-card">
                    <div class="attention-top">
                        <div class="attention-icon"><i class="bi bi-bell"></i></div>
                        <div class="attention-value">{{ number_format($unreadNotificationsCount) }}</div>
                    </div>
                    <div class="attention-label">{{ $t('nav.unread_notifications', 'Unread Notifications') }}</div>
                    <div class="attention-desc">{{ $t('nav.unread_notifications_desc', 'Important updates inside your vendor panel that still need review.') }}</div>
                </a>
            </div>

            @if($lowStockProductsCount > 0)
                <div class="attention-alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ $t('nav.low_stock_warning', 'Low Stock Warning') }}:
                    {{ number_format($lowStockProductsCount) }}
                    {{ $t('nav.products_need_restock', 'products may need restocking soon.') }}
                </div>
            @endif
        </section>

        <section class="panel">
            <div class="panel-head">
                <div>
                    <h5>{{ $t('nav.quick_actions', 'Quick Actions') }}</h5>
                    <p>{{ $t('nav.shortcuts', 'Direct shortcuts to the tasks you use most.') }}</p>
                </div>
            </div>

            <div class="actions-grid">
                <a href="{{ route('vendor/products/create') }}" class="action-card">
                    <div class="action-icon" style="background: rgba(23,92,211,.12); color:#175cd3;"><i class="bi bi-plus-lg"></i></div>
                    <div><div class="action-title">{{ $t('nav.add_product', 'Add Product') }}</div><div class="action-desc">{{ $t('nav.add_product_desc', 'Create a new product and publish it quickly.') }}</div></div>
                </a>
                <a href="{{ route('vendor/products') }}" class="action-card">
                    <div class="action-icon" style="background: rgba(2,132,199,.12); color:#0284c7;"><i class="bi bi-box-seam"></i></div>
                    <div><div class="action-title">{{ $t('nav.view_products', 'Manage Products') }}</div><div class="action-desc">{{ $t('nav.view_products_desc', 'Review prices, inventory, and product details from one place.') }}</div></div>
                </a>
                <a href="{{ route('vendor/orders') }}" class="action-card">
                    <div class="action-icon" style="background: rgba(234,88,12,.12); color:#ea580c;"><i class="bi bi-receipt"></i></div>
                    <div><div class="action-title">{{ $t('nav.view_orders', 'Manage Orders') }}</div><div class="action-desc">{{ $t('nav.view_orders_desc', 'Follow new requests, deliveries, and active order flow.') }}</div></div>
                </a>
                <a href="{{ route('vendor/orders', ['tab' => 'scheduled']) }}" class="action-card">
                    <div class="action-icon" style="background: rgba(245,158,11,.12); color:#d97706;"><i class="bi bi-calendar-check"></i></div>
                    <div><div class="action-title">{{ $t('nav.scheduled_orders', 'Scheduled Orders') }}</div><div class="action-desc">{{ $t('nav.scheduled_orders_desc', 'Track recurring orders and their upcoming execution dates.') }}</div></div>
                </a>
                <a href="{{ route('vendor/orders/my-offers') }}" class="action-card">
                    <div class="action-icon" style="background: rgba(147,51,234,.12); color:#9333ea;"><i class="bi bi-chat-quote"></i></div>
                    <div><div class="action-title">{{ $t('nav.view_offers', 'Manage Offers') }}</div><div class="action-desc">{{ $t('nav.view_offers_desc', 'Review pending, accepted, and rejected offers.') }}</div></div>
                </a>
                <a href="{{ route('vendor/ratings') }}" class="action-card">
                    <div class="action-icon" style="background: rgba(22,163,74,.12); color:#16a34a;"><i class="bi bi-star-fill"></i></div>
                    <div><div class="action-title">{{ $t('nav.ratings', 'Ratings') }}</div><div class="action-desc">{{ $t('nav.ratings_desc', 'Check customer ratings and what they reflect about performance.') }}</div></div>
                </a>
                <a href="{{ route('vendor/profile') }}" class="action-card">
                    <div class="action-icon" style="background: rgba(15,23,42,.08); color:#0f172a;"><i class="bi bi-person-circle"></i></div>
                    <div><div class="action-title">{{ $t('profile.profile', 'Profile') }}</div><div class="action-desc">{{ $t('nav.profile_desc', 'Keep your business information and trust details updated.') }}</div></div>
                </a>
                <a href="{{ route('vendor/analytics') }}" class="action-card">
                    <div class="action-icon" style="background: rgba(236,72,153,.1); color:#db2777;"><i class="bi bi-graph-up"></i></div>
                    <div><div class="action-title">{{ $t('nav.analytics', 'Analytics') }}</div><div class="action-desc">{{ $t('nav.analytics_desc', 'Review deeper trends and performance insights.') }}</div></div>
                </a>
            </div>
        </section>

        <section class="content-grid">
            <div class="panel">
                <div class="panel-head">
                    <div>
                        <h5>{{ $t('nav.recent_orders', 'Recent Orders') }}</h5>
                        <p>{{ $t('nav.recent_orders_desc', 'Latest orders related to your account in the platform.') }}</p>
                    </div>
                    <a href="{{ route('vendor/orders') }}" class="panel-link">{{ $t('nav.view_all', 'View All') }}</a>
                </div>
                <div class="list-wrap">
                    @forelse($recentOrders as $order)
                        <div class="list-item">
                            <div>
                                <p class="list-title">{{ $t('nav.order', 'Order') }} #{{ $order->id }}</p>
                                <div class="list-sub"><i class="bi bi-person me-1"></i>{{ $order->user->name ?? $t('nav.unknown', 'Unknown') }}</div>
                            </div>
                            <div class="list-time"><i class="bi bi-clock me-1"></i>{{ $order->created_at->diffForHumans() }}</div>
                        </div>
                    @empty
                        <div class="empty-state"><i class="bi bi-inbox"></i>{{ $t('nav.no_orders', 'No orders yet.') }}</div>
                    @endforelse
                </div>
            </div>

            <div class="panel">
                <div class="panel-head">
                    <div>
                        <h5>{{ $t('nav.pending_offers', 'Pending Offers') }}</h5>
                        <p>{{ $t('nav.pending_offers_panel_desc', 'Offers that are still waiting for a final response.') }}</p>
                    </div>
                    <a href="{{ route('vendor/orders/my-offers') }}" class="panel-link">{{ $t('nav.view_all', 'View All') }}</a>
                </div>
                <div class="list-wrap">
                    @forelse($pendingOffers as $offer)
                        @php
                            $offerStatus = (string) $offer->status;
                            $offerStatusLabel = ($offerStatus === '2' || strtolower($offerStatus) === 'accepted') ? 'accepted' : (($offerStatus === '3' || strtolower($offerStatus) === 'rejected') ? 'rejected' : 'pending');
                        @endphp
                        <div class="list-item">
                            <div>
                                <p class="list-title">{{ $t('nav.offer', 'Offer') }} #{{ $offer->id }}</p>
                                <div class="list-sub">
                                    <i class="bi bi-tag me-1"></i>
                                    @if((int) ($offer->order->order_type ?? 0) === 1)
                                        {{ $t('nav.purchase_order', 'Purchase Order') }}
                                    @elseif((int) ($offer->order->order_type ?? 0) === 3)
                                        {{ $t('nav.maintenance_request', 'Maintenance Request') }}
                                    @else
                                        {{ $t('nav.quotation_request', 'Quotation Request') }}
                                    @endif
                                </div>
                            </div>
                            <span class="status-badge status-{{ $offerStatusLabel }}">{{ ucfirst($offerStatusLabel) }}</span>
                        </div>
                    @empty
                        <div class="empty-state"><i class="bi bi-check2-circle"></i>{{ $t('nav.no_pending_offers', 'No pending offers right now.') }}</div>
                    @endforelse
                </div>
            </div>
        </section>
        <section class="content-grid">
            <div class="panel">
                <div class="panel-head">
                    <div>
                        <h5>{{ $t('nav.recent_scheduled_orders', 'Recent Scheduled Orders') }}</h5>
                        <p>{{ $t('nav.recent_scheduled_orders_desc', 'The nearest recurring tasks in your execution schedule.') }}</p>
                    </div>
                    <a href="{{ route('vendor/orders', ['tab' => 'scheduled']) }}" class="panel-link">{{ $t('nav.view_all', 'View All') }}</a>
                </div>
                <div class="list-wrap">
                    @forelse($recentScheduledOrders ?? [] as $order)
                        <div class="list-item">
                            <div>
                                <p class="list-title">{{ $t('nav.scheduled_order', 'Scheduled Order') }} #{{ $order->id }}</p>
                                <div class="list-sub">
                                    <i class="bi bi-calendar me-1"></i>
                                    @if($order->schedule_start_date)
                                        {{ \Carbon\Carbon::parse($order->schedule_start_date)->format('M d, Y') }}
                                    @endif
                                    @if($order->frequency)
                                        - {{ $order->frequency }}
                                    @endif
                                </div>
                            </div>
                            @php $colors = $order->scheduled_status_color; @endphp
                            <span class="status-badge" style="background:{{ $colors['bg'] }};color:{{ $colors['text'] }};border-color:{{ $colors['border'] }};">
                                {{ $t('nav.' . strtolower($order->scheduled_status), ucfirst($order->scheduled_status)) }}
                            </span>
                        </div>
                    @empty
                        <div class="empty-state"><i class="bi bi-calendar-x"></i>{{ $t('nav.no_scheduled_orders', 'No scheduled orders right now.') }}</div>
                    @endforelse
                </div>
            </div>

            <div class="panel">
                <div class="panel-head">
                    <div>
                        <h5>{{ $t('nav.recent_notifications', 'Recent Notifications') }}</h5>
                        <p>{{ $t('nav.recent_notifications_desc', 'The latest alerts and updates delivered to your account.') }}</p>
                    </div>
                    <a href="{{ route('vendor/notifications') }}" class="panel-link">{{ $t('nav.view_all', 'View All') }}</a>
                </div>
                <div class="list-wrap">
                    @forelse($recentNotifications ?? [] as $notification)
                        <div class="list-item">
                            <div>
                                <p class="list-title">
                                    {{ $notification->title ?? $t('nav.notification', 'Notification') }}
                                    @if(is_null($notification->read_at))
                                        <span class="badge bg-warning text-dark ms-2">{{ $t('nav.new', 'New') }}</span>
                                    @endif
                                </p>
                                <div class="list-sub">{{ Str::limit($notification->message ?? $notification->content ?? '', 90) }}</div>
                            </div>
                            <div class="list-time"><i class="bi bi-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}</div>
                        </div>
                    @empty
                        <div class="empty-state"><i class="bi bi-bell-slash"></i>{{ $t('nav.no_notifications', 'No notifications yet.') }}</div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="tip-card">
            <div class="action-icon"><i class="bi bi-lightbulb"></i></div>
            <div>
                <div class="action-title">{{ $t('nav.dashboard_tip_title', 'Quick Tip') }}</div>
                <div class="action-desc">{{ $t('nav.dashboard_info', 'Keep your profile updated and respond quickly to orders and pending offers to improve acceptance and grow revenue.') }}</div>
            </div>
        </section>
    </div>
</main>
@endsection








