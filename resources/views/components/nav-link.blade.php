@props([
    'route',         // nom de route
])

@php
    $isActive = request()->routeIs($route);
@endphp

<li>
    <a
        href="{{ route($route) }}"
        @class([
            'px-3 py-2 rounded-btn text-sm whitespace-nowrap transition-colors duration-150',
            'bg-base-200 font-semibold text-primary' => $isActive,
            'hover:bg-base-200' => ! $isActive,
        ])
    >
        {{ $slot }}
    </a>
</li>
