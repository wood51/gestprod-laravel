@php
    // Section principale : Production
    $menuSections = [
        [
            'title' => 'Production',
            'items' => [
                [
                    'label' => 'Dashboard KPI',
                    'href' => url('/kpi/dashboard'),
                    'pattern' => 'kpi/dashboard*',
                    'icon' => 'fa-solid fa-chart-line',
                    'target' => '_blank',
                ],
            ],
        ],
    ];

    // Section Admin
    $adminSection = [
        'title' => 'Admin',
        'items' => [
            [
                'label' => 'Commandes',
                'href' => url('/commandes'),
                'pattern' => 'commandes*',
                'icon' => 'fa-solid fa-list',
            ],
            [
                'label' => 'Parse Cmde Test',
                'href' => url('/pa/import'),
                'pattern' => 'parse*',
                'icon' => 'fa-solid fa-list',
            ],
            [
                'label' => 'Planning',
                'href' => url('/planning'),
                'pattern' => 'planning*',
                'icon' => 'fa-regular fa-calendar',
            ],
            [
                'label' => 'Engagements',
                'href' => url('/engagements'),
                'pattern' => 'engagements*',
                'icon' => 'fa-solid fa-handshake',
            ],
            [
                'label' => 'Réalisations',
                'href' => url('/realisation'),
                'pattern' => 'realisation*',
                'icon' => 'fa-solid fa-check-double',
            ],
            [
                'label' => 'Bons de livraison',
                'href' => url('/bl'),
                'pattern' => 'bl*',
                'icon' => 'fa-solid fa-truck-ramp-box',
            ],
        ],
    ];
@endphp

<div>
    {{-- Header : logo + titre + sous-titre + horloge --}}
    <div class="flex flex-col items-center m-4">
        <div class="flex items-center gap-4">
            <img src="{{ asset('img/gears.svg') }}" width="50" alt="Logo GestProd" />
            <span class="text-2xl sm:text-3xl font-semibold text-indigo-400">GESTPROD</span>
        </div>
        <span class="text-xs text-gray-300 text-center font-semibold italic mt-1">
            Gestion de production DEE
        </span>
        {{-- <div id="clock" class="font-mono font-bold text-[11px] text-gray-400 mt-2">&nbsp;</div> --}}
        <x-clock class="font-mono font-bold text-[11px] text-gray-400 mt-2" />
    </div>

    {{-- Bandeau icônes haut --}}
    <nav>
        <ul class="space-y-2 text-white">
            <li>
                <hr class="border-t border-gray-600 mb-2" />
            </li>

            <li class="flex items-center justify-around gap-4 w-full py-2">
                {{-- Accueil --}}
                <a href="{{ url('/') }}" class="text-gray-400 hover:text-indigo-400 text-xl" title="Accueil">
                    <i class="fas fa-home"></i>
                </a>

                {{-- User / paramètres --}}
                @auth
                    <a href="#" class="text-gray-400 hover:text-indigo-400 text-xl"
                        title="{{ ucfirst(Auth::user()->prenom ?? Auth::user()->name) }} - Paramètres">
                        <i class="fa-solid fa-user"></i>
                    </a>

                    {{-- Logout --}}
                    <form action="{{ url('/logout') }}" method="post">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-indigo-400 text-xl cursor-pointer"
                            title="Déconnexion">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                @endauth
            </li>

            <li>
                <hr class="border-t border-gray-600 my-2" />
            </li>
        </ul>

        {{-- Menu principal --}}
        <ul class="mt-2 space-y-2 text-sm text-gray-200">

            {{-- SECTION PRODUCTION (collapse DaisyUI) --}}
            @foreach ($menuSections as $section)
                @php
                    $sectionActive = false;
                    foreach ($section['items'] as $item) {
                        if (request()->is($item['pattern'])) {
                            $sectionActive = true;
                            break;
                        }
                    }
                @endphp

                <li>
                    <details class="collapse collapse-arrow bg-base-100/0"
                        @if ($sectionActive) open @endif>
                        <summary
                            class="collapse-title font-semibold text-[12px] tracking-wider uppercase text-gray-300 px-2 py-2">
                            {{ $section['title'] }}
                        </summary>

                        <div class="collapse-content px-0 pt-0 pb-2">
                            <ul class="pl-2 space-y-1">
                                @foreach ($section['items'] as $item)
                                    @php
                                        $isActive = request()->is($item['pattern']);
                                    @endphp

                                    <li>
                                        <a href="{{ $item['href'] }}" @class([
                                            'flex items-center gap-2 px-3 py-2 rounded-lg transition-colors duration-200',
                                            'bg-base-100 text-primary font-semibold' => $isActive,
                                            'hover:bg-base-100 hover:text-primary/90' => !$isActive,
                                        ])>
                                            @if (!empty($item['icon']))
                                                <i class="{{ $item['icon'] }} text-sm"></i>
                                            @endif
                                            <span>{{ $item['label'] }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </details>
                </li>
            @endforeach

            {{-- SECTION ADMIN (si admin) --}}
            @if (Auth::user()?->role === 'admin')
                @php
                    $adminActive = false;
                    foreach ($adminSection['items'] as $item) {
                        if (request()->is($item['pattern'])) {
                            $adminActive = true;
                            break;
                        }
                    }
                @endphp

                <li>
                    <details class="collapse collapse-arrow bg-base-100/0 mt-2"
                        @if ($adminActive) open @endif>
                        <summary
                            class="collapse-title font-semibold text-[12px] tracking-wider uppercase text-gray-300 px-2 py-2">
                            {{ $adminSection['title'] }}
                        </summary>

                        <div class="collapse-content px-0 pt-0 pb-2">
                            <ul class="pl-2 space-y-1">
                                @foreach ($adminSection['items'] as $item)
                                    @php
                                        $isActive = request()->is($item['pattern']);
                                    @endphp

                                    <li>
                                        <a href="{{ $item['href'] }}"
                                            @if (!empty($item['target'])) target="{{ $item['target'] }}" @endif
                                            @class([
                                                'flex items-center gap-2 px-3 py-2 rounded-lg transition-colors duration-200',
                                                'bg-base-100 text-primary font-semibold' => $isActive,
                                                'hover:bg-base-100 hover:text-primary/90' => !$isActive,
                                            ])>
                                            @if (!empty($item['icon']))
                                                <i class="{{ $item['icon'] }} text-sm"></i>
                                            @endif
                                            <span>{{ $item['label'] }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </details>
                </li>
            @endif
        </ul>
    </nav>
</div>

{{-- Horloge --}}
<script>
    (function() {
        function updateClock() {
            const options = {
                day: "2-digit",
                month: "2-digit",
                year: "numeric",
                hour: "2-digit",
                minute: "2-digit"
            };
            const now = new Date();
            const clock = document.getElementById("clock");
            if (clock) {
                clock.innerText = now.toLocaleString("fr-FR", options);
            }
        }
        updateClock();
        setInterval(updateClock, 60 * 1000);
    })();
</script>
