<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Document</title>
</head>

<body class="min-h-screen bg-base-200 flex items-center justify-center">
    <include href="/themes/base/components/toast/_toast.html" />
    <div class="w-full max-w-sm shadow-xl bg-base-100 rounded-xl p-6">
        <h1 class="text-2xl font-bold text-center mb-4">Connexion</h1>

        <form method="POST" action="{{ url('/login') }}" class="space-y-4">
            @csrf
            <div>
                <label class="label" for="username">Nom d'utilisateur</label>
                <input type="text" name="username" id="username" class="input input-bordered w-full" required>
            </div>

            <div>
                <label class="label" for="password">Mot de passe</label>
                <input type="password" name="password" id="password" class="input input-bordered w-full" required>
            </div>

            <button type="submit" class="btn bg-indigo-600 text-white w-full">Se connecter</button>
            @if ($errors->any())
            <div class="text-red-500 text-sm mt-2">
                {{ $errors->first() }}
            </div>
            @endif
        </form>


    </div>

</body>

</html>