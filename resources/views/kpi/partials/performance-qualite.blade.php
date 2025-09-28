<div class="grid grid-cols-3 grid-rows-2 gap-4 h-full w-full p-6">
  <!-- Respect engagement -->
  <div class="col-span-1 row-span-1 bg-white shadow-xl rounded-lg p-6 flex flex-col items-center justify-center">
    @include('kpi.partials.respect-engagement')
  </div>

  <!-- Performance mois -->
  <div class="col-span-2 row-span-1 bg-white shadow-xl rounded-lg p-6 flex flex-col justify-center">
    @include('kpi.partials.rendement-mois')
    {{-- <include href="/kpi-dashboard/partials/_chart_performance_mois.html" /> --}}
  </div>

  <!-- Qualité mois -->
  <div class="col-span-2 row-span-1 bg-white shadow-xl rounded-lg p-6 flex flex-col justify-center">
    {{-- <include href="/kpi-dashboard/partials/_chart_qualite_mois.html" /> --}}
  </div>

  <!--Qualité actuelle -->
  <div class="col-span-1 row-span-1 bg-white shadow-xl rounded-lg p-6 flex flex-col items-center justify-center">
    {{-- <include href="/kpi-dashboard/partials/_chart_qualite.html"  /> --}}
  </div>
</div>