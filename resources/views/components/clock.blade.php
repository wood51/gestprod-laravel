@php
    $clockId = $attributes->get('id') ?? 'clock-' . \Illuminate\Support\Str::uuid();
@endphp

<div id="{{ $clockId }}" {{ $attributes }}>&nbsp;</div>

<script>
    (function() {
        const clock = document.getElementById("{{ $clockId }}");

        function updateClock() {
            const options = {
                day: "2-digit",
                month: "2-digit",
                year: "numeric",
                hour: "2-digit",
                minute: "2-digit"
            };
            clock.innerText = new Date().toLocaleString("fr-FR", options);
        }

        updateClock();
        setInterval(updateClock, 60 * 1000);
    })();
</script>
