<!DOCTYPE html>
<html lang="fr" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Document</title>
</head>





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
    <div id="content" class="flex flex-col flex-1 min-h-0 p-4" hx-get="{{ url('/planning') }}" hx-trigger="load">
        <!-- contenu injecté ici -->
    </div>
</main>
</div>
</body>

</html>