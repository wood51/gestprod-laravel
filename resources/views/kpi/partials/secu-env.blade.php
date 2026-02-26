<div class="w-full h-full p-6 md:p-10 flex flex-col gap-12">

    <!-- TITRE -->
    <div>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 text-center">Sécurité & Environnement</h1>
    </div>

    <!-- LIGNE KPI : Responsive -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10 xl:gap-16">

        <!-- KPI AT -->
        <div class="card bg-red-100 shadow p-6 md:p-8 flex flex-col">
            <h2 class="text-xl md:text-2xl font-bold text-red-800">Jours sans AT</h2>
            <p class="text-4xl md:text-6xl font-bold text-red-900 mt-4">128 jours</p>
            <p class="text-sm md:text-base opacity-70 mt-auto pt-4">Record : 231 jours</p>
        </div>

        <!-- KPI ENV -->
        <div class="card bg-green-100 shadow p-6 md:p-8 flex flex-col">
            <h2 class="text-xl md:text-2xl font-bold text-green-800">Jours sans problème Environnement</h2>
            <p class="text-4xl md:text-6xl font-bold text-green-900 mt-4">94 jours</p>
            <p class="text-sm md:text-base opacity-70 mt-auto pt-4">Record : 164 jours</p>
        </div>

    </div>

    <!-- LIGNE CALENDRIERS : Responsive -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10 xl:gap-16">

        <!-- CALENDRIER AT -->
        <div class="card bg-white shadow p-6 md:p-10">
            {{-- <h2 class="text-xl md:text-2xl font-bold mb-4 md:mb-6 text-gray-700 text-center">Calendrier – AT</h2> --}}
            <div id="calendarAT" class="text-sm md:text-lg"></div>
        </div>

        <!-- CALENDRIER ENV -->
        <div class="card bg-white shadow p-6 md:p-10">
            {{-- <h2 class="text-xl md:text-2xl font-bold mb-4 md:mb-6 text-gray-700 text-center">Calendrier – Environnement</h2> --}}
            <div id="calendarENV" class="text-sm md:text-lg"></div>
        </div>

    </div>

</div>

<script>
function generateCalendar(targetId) {
    const container = document.getElementById(targetId);
    const today = new Date();
    const month = today.toLocaleString("fr-FR", { month: "long" });
    const year = today.getFullYear();

    const firstDay = new Date(year, today.getMonth(), 1).getDay();
    const daysInMonth = new Date(year, today.getMonth() + 1, 0).getDate();
    const offset = (firstDay === 0 ? 6 : firstDay - 1);

    let html = `
        <div class="text-center font-bold text-base md:text-xl mb-2 md:mb-4 capitalize">${month} ${year}</div>
        <div class="grid grid-cols-7 text-center text-xs md:text-sm font-bold mb-2">
            <div>Lun</div><div>Mar</div><div>Mer</div><div>Jeu</div>
            <div>Ven</div><div>Sam</div><div>Dim</div>
        </div>
        <div class="grid grid-cols-7 gap-1 md:gap-2 text-center">
    `;

    for (let i = 0; i < offset; i++) html += `<div></div>`;

    for (let day = 1; day <= daysInMonth; day++) {
        html += `<div class="py-1 md:py-2 bg-base-200 rounded">${day}</div>`;
    }

    html += `</div>`;
    container.innerHTML = html;
}

generateCalendar("calendarAT");
generateCalendar("calendarENV");
</script>