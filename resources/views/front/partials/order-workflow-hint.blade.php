@php
    $role = $role ?? 'customer';
    $activeTab = $activeTab ?? null;

    $workflows = [
        'purchase' => [
            'label' => __('products.workflow_purchase'),
            'customer' => __('products.workflow_customer_purchase'),
            'vendor' => __('products.workflow_vendor_purchase'),
        ],
        'quotation' => [
            'label' => __('products.workflow_quotation'),
            'customer' => __('products.workflow_customer_quotation'),
            'vendor' => __('products.workflow_vendor_quotation'),
        ],
        'maintenance' => [
            'label' => __('products.workflow_maintenance'),
            'customer' => __('products.workflow_customer_maintenance'),
            'vendor' => __('products.workflow_vendor_maintenance'),
        ],
        'scheduled' => [
            'label' => __('products.workflow_scheduled'),
            'customer' => __('products.workflow_customer_scheduled'),
            'vendor' => __('products.workflow_vendor_scheduled'),
        ],
    ];
@endphp

<div class="wf-card">
    <style>
        .wf-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: .9rem 1.2rem;
            margin-bottom: 1.2rem;
        }
        .wf-title {
            font-weight: 700;
            color: #0f2f7f;
            font-size: .88rem;
            margin-bottom: .6rem;
        }
        .wf-title i {
            margin-inline-end: 5px;
        }
        .wf-row {
            font-size: .82rem;
            padding: .25rem 0;
            display: flex;
            align-items: center;
            gap: .4rem;
            flex-wrap: wrap;
        }
        .wf-label {
            font-weight: 600;
            color: #6b7280;
            flex-shrink: 0;
        }
        .wf-steps {
            color: #1f2937;
            font-weight: 500;
        }
        .wf-steps .arrow {
            color: #94a3b8;
            margin: 0 .15rem;
        }
    </style>

    <div class="wf-title"><i class="bi bi-info-circle"></i>{{ __('products.workflow_title') }}</div>

    @foreach($workflows as $key => $wf)
        @php
            $show = true;
            if ($activeTab && $activeTab !== 'all') {
                $tabMap = [
                    'purchase-orders' => 'purchase',
                    'quotations' => 'quotation',
                    'maintenances' => 'maintenance',
                    'scheduled-orders' => 'scheduled',
                    'purchase' => 'purchase',
                    'quotation' => 'quotation',
                    'maintenance' => 'maintenance',
                    'scheduled' => 'scheduled',
                ];
                $mapped = $tabMap[$activeTab] ?? null;
                $show = $mapped === $key;
            }
        @endphp
        @if($show)
            <div class="wf-row">
                <span class="wf-label">{{ $wf['label'] }}:</span>
                <span class="wf-steps">
                    @foreach(explode(' → ', $wf[$role]) as $i => $step)
                        @if($i > 0)<span class="arrow">→</span>@endif
                        <span>{{ $step }}</span>
                    @endforeach
                </span>
            </div>
        @endif
    @endforeach
</div>
