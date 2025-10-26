<!DOCTYPE html>
<html lang="fr" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Document</title>
</head>

<body class="bg-gray-100 dark:bg-gray-800 dark:text-gray-200 font-sans text-gray-800 h-full overflow-auto">

    <!-- Layout principal -->
    <div class="flex h-full">

        <!-- Sidebar -->
        <aside class="w-72 bg-gray-700 shadow-md hidden md:block pb-6 px-4">
            <div>
                <div class="flex flex-col items-center m-4">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('img/gears.svg') }}" width="50" alt="Logo GestProd" />
                        <span class="text-2xl sm:text-3xl font-semibold text-indigo-400">GESTPROD</span>
                    </div>
                    <span class="text-base text-gray-500 text-center font-semibold italic">Gestion de production
                        DEE</span>
                    <div id="clock" class="font-mono font-bold text-xs text-gray-500 mt-2">&nbsp;</div>
                </div>
            </div>

            <!-- Menu -->
            <nav>
                <ul class="space-y-2 text-white" hx-ext="multi-swap">

                    <!-- Menu Icone -->
                    <li>
                        <hr class="border-t border-gray-500 mb-2" /> <!-- Séparateur  -->
                    </li>
                    <li class="flex items-center justify-around gap-4 w-full py-2">

                        <a href="/" class="text-gray-500 hover:text-indigo-500 text-xl" title="Acceuil">
                            <i class="fas fa-home"></i>
                        </a>

                        <a href="#" class="text-gray-500 hover:text-indigo-500 text-xl"
                        {{-- FIXME --}}
                            title="{{ ucfirst(Auth::user()->prenom)  }} - Paramètres"> 
                            <i class="fa-solid fa-user"></i>
                        </a>

                        <form action="/logout" method="post">
                            @csrf
                            <button href="/logout" onclick="this.form.submit()"
                                class="text-gray-500 hover:text-indigo-500 text-xl cursor-pointer" title="Déconnexion">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>

                    </li>


                    <li>
                        <hr class="border-t border-gray-500 my-2" /> <!-- Séparateur -->
                    </li>
                    @if (Auth::user()->role === 'admin')
                        <li>
                            <a href="/kpi/dashboard" target="_blank" class="btn btn-ghost">Dashboard KPI</a>
                        </li>
                        <li>
                            <a href="/planning" class="btn btn-ghost">Planning</a>
                        </li>
                        <li>
                            <a href="/bl" class="btn btn-ghost">Bon de livraisons</a>
                        </li>
                        <li>
                            <hr class="border-t border-gray-500 my-2" />
                        </li>
                    @endif
                </ul>
            </nav>
        </aside>


        <script>
            setInterval(() => {
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
            }, 1000);
        </script>

        <!-- Contenu principal -->
        <main class="flex flex-col flex-1 min-h-0">

            <!-- Main Content-->
            <div id="content" class="flex flex-col flex-1 min-h-0 p-4">
                <!-- contenu injecté ici -->
                @yield('content')
            </div>

        </main>
    </div>
</body>

</html>
