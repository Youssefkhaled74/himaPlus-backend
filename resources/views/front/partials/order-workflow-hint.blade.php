<div class="wf-card">
    <style>
        .wf-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 1.3rem 1.4rem;
            margin-bottom: 1.5rem;
        }
        .wf-title {
            font-weight: 700;
            color: #0f2f7f;
            margin-bottom: 1rem;
            font-size: .95rem;
        }
        .wf-title i {
            margin-inline-end: 6px;
        }
        .wf-group {
            margin-bottom: .9rem;
        }
        .wf-group:last-child {
            margin-bottom: 0;
        }
        .wf-group-label {
            display: inline-block;
            font-size: .78rem;
            font-weight: 700;
            padding: 2px 10px;
            border-radius: 999px;
            margin-bottom: .4rem;
        }
        .wf-group-label.purchase { background: #dbeafe; color: #1e40af; }
        .wf-group-label.quotation { background: #fef3c7; color: #92400e; }
        .wf-group-label.maintenance { background: #e0e7ff; color: #3730a3; }
        .wf-group-label.scheduled { background: #d1fae5; color: #065f46; }

        .wf-row {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: .8rem;
            padding: .2rem 0;
            flex-wrap: wrap;
        }
        .wf-row-label {
            font-weight: 600;
            color: #6b7280;
            min-width: 60px;
            flex-shrink: 0;
        }
        .wf-step {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
        }
        .wf-step-badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 999px;
            font-size: .75rem;
            font-weight: 600;
            white-space: nowrap;
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #e2e8f0;
        }
        .wf-step-arrow {
            color: #94a3b8;
            font-size: .8rem;
        }
        .wf-step-badge.active {
            background: #dbeafe;
            border-color: #93c5fd;
            color: #1e40af;
        }
        .wf-step-badge.done {
            background: #d1fae5;
            border-color: #6ee7b7;
            color: #065f46;
        }
    </style>

    <div class="wf-title"><i class="bi bi-info-circle"></i>{{ __('products.workflow_title') }}</div>

    @php
        $isAr = app()->getLocale() === 'ar';
    @endphp

    <div class="wf-group">
        <span class="wf-group-label purchase">{{ __('products.workflow_purchase') }}</span>
        <div class="wf-row">
            <span class="wf-row-label">{{ __('products.workflow_customer_view') }}:</span>
            <span class="wf-step">
                @foreach(explode(' → ', __('products.workflow_customer_purchase')) as $i => $step)
                    @if($i > 0)<span class="wf-step-arrow">→</span>@endif
                    <span class="wf-step-badge">{{ $step }}</span>
                @endforeach
            </span>
        </div>
        <div class="wf-row">
            <span class="wf-row-label">{{ __('products.workflow_vendor_view') }}:</span>
            <span class="wf-step">
                @foreach(explode(' → ', __('products.workflow_vendor_purchase')) as $i => $step)
                    @if($i > 0)<span class="wf-step-arrow">→</span>@endif
                    <span class="wf-step-badge">{{ $step }}</span>
                @endforeach
            </span>
        </div>
    </div>

    <div class="wf-group">
        <span class="wf-group-label quotation">{{ __('products.workflow_quotation') }}</span>
        <div class="wf-row">
            <span class="wf-row-label">{{ __('products.workflow_customer_view') }}:</span>
            <span class="wf-step">
                @foreach(explode(' → ', __('products.workflow_customer_quotation')) as $i => $step)
                    @if($i > 0)<span class="wf-step-arrow">→</span>@endif
                    <span class="wf-step-badge">{{ $step }}</span>
                @endforeach
            </span>
        </div>
        <div class="wf-row">
            <span class="wf-row-label">{{ __('products.workflow_vendor_view') }}:</span>
            <span class="wf-step">
                @foreach(explode(' → ', __('products.workflow_vendor_quotation')) as $i => $step)
                    @if($i > 0)<span class="wf-step-arrow">→</span>@endif
                    <span class="wf-step-badge">{{ $step }}</span>
                @endforeach
            </span>
        </div>
    </div>

    <div class="wf-group">
        <span class="wf-group-label maintenance">{{ __('products.workflow_maintenance') }}</span>
        <div class="wf-row">
            <span class="wf-row-label">{{ __('products.workflow_customer_view') }}:</span>
            <span class="wf-step">
                @foreach(explode(' → ', __('products.workflow_customer_maintenance')) as $i => $step)
                    @if($i > 0)<span class="wf-step-arrow">→</span>@endif
                    <span class="wf-step-badge">{{ $step }}</span>
                @endforeach
            </span>
        </div>
        <div class="wf-row">
            <span class="wf-row-label">{{ __('products.workflow_vendor_view') }}:</span>
            <span class="wf-step">
                @foreach(explode(' → ', __('products.workflow_vendor_maintenance')) as $i => $step)
                    @if($i > 0)<span class="wf-step-arrow">→</span>@endif
                    <span class="wf-step-badge">{{ $step }}</span>
                @endforeach
            </span>
        </div>
    </div>

    <div class="wf-group">
        <span class="wf-group-label scheduled">{{ __('products.workflow_scheduled') }}</span>
        <div class="wf-row">
            <span class="wf-row-label">{{ __('products.workflow_customer_view') }}:</span>
            <span class="wf-step">
                @foreach(explode(' → ', __('products.workflow_customer_scheduled')) as $i => $step)
                    @if($i > 0)<span class="wf-step-arrow">→</span>@endif
                    <span class="wf-step-badge">{{ $step }}</span>
                @endforeach
            </span>
        </div>
        <div class="wf-row">
            <span class="wf-row-label">{{ __('products.workflow_vendor_view') }}:</span>
            <span class="wf-step">
                @foreach(explode(' → ', __('products.workflow_vendor_scheduled')) as $i => $step)
                    @if($i > 0)<span class="wf-step-arrow">→</span>@endif
                    <span class="wf-step-badge">{{ $step }}</span>
                @endforeach
            </span>
        </div>
    </div>
</div>