<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title', 'GestProd')</title>
</head>

<body class="bg-base-200 dark:bg-gray-800 dark:text-gray-200 font-sans text-gray-800 h-full overflow-auto">

    <!-- Layout principal -->
    <div class="flex h-full min-h-screen">

        <!-- Sidebar -->
        <aside class="w-72 bg-neutral shadow-md hidden md:block pb-6 px-4">
            <x-sidebar />
        </aside>

        <!-- Contenu principal -->
        <main class="flex flex-col flex-1 min-h-0">
            <div id="content" class="flex flex-col flex-1 min-h-0 p-4">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
