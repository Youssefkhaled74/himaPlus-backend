@props([
    'badge' => null,
    'title' => '',
    'description' => null,
    'breadcrumbs' => [],
    'actionLabel' => null,
    'actionHref' => null,
    'actionIcon' => 'ri-add-line',
    'actionClass' => 'btn btn-primary',
])

<section {{ $attributes->class(['admin-page-header']) }}>
    <div class="admin-page-header__main">
        @if ($badge)
            <span class="admin-page-header__badge">{{ $badge }}</span>
        @endif

        @if ($breadcrumbs)
            <nav class="admin-page-header__breadcrumbs" aria-label="Breadcrumb">
                <ol class="breadcrumb m-0">
                    @foreach ($breadcrumbs as $breadcrumb)
                        @php
                            $label = is_array($breadcrumb) ? ($breadcrumb['label'] ?? '') : $breadcrumb;
                            $href = is_array($breadcrumb) ? ($breadcrumb['href'] ?? null) : null;
                            $active = (bool) (is_array($breadcrumb) ? ($breadcrumb['active'] ?? false) : false);
                        @endphp
                        <li class="breadcrumb-item {{ $active ? 'active' : '' }}">
                            @if ($href && !$active)
                                <a href="{{ $href }}">{{ $label }}</a>
                            @else
                                <span>{{ $label }}</span>
                            @endif
                        </li>
                    @endforeach
                </ol>
            </nav>
        @endif

        <div class="admin-page-header__copy">
            <div>
                <h1 class="admin-page-header__title">{{ $title }}</h1>
                @if ($description)
                    <p class="admin-page-header__description mb-0">{{ $description }}</p>
                @endif
            </div>

            @if (isset($actions) || ($actionLabel && $actionHref))
                <div class="admin-page-header__actions">
                    @isset($actions)
                        {{ $actions }}
                    @else
                        <a href="{{ $actionHref }}" class="{{ $actionClass }}">
                            @if ($actionIcon)
                                <i class="{{ $actionIcon }} align-bottom"></i>
                            @endif
                            <span>{{ $actionLabel }}</span>
                        </a>
                    @endisset
                </div>
            @endif
        </div>
    </div>
</section>
