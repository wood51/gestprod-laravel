<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestprod')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <h1 class="text-xl font-bold">
        Bonjour {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
    </h1>

    <p>Ton rôle : <span class="font-semibold">{{ Auth::user()->role }}</span></p>
    <p>Ton site : <span class="font-semibold">{{ Auth::user()->site }}</span></p>
    <form method='POST' action="{{ url('/logout') }}">
        @csrf
        <button>logout</button>
    </form>
</body>

</html>
