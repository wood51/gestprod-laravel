<h2 class="text-xl font-bold text-primary mb-4">Objectif Semaine En Cours</h2>
<div id="chartRespectEngagement" class="w-full h-full"></div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const optionsRespectEngagement = {
      chart: {
        type: "radialBar",
        height: "100%",
        offsetY: 0,
      },
      //series: [10], // Pourcentage de performance
      plotOptions: {
        radialBar: {
          track: {
            background: "#e7e7e7",
            strokeWidth: "97%",
            margin: 5, // space between track and bar
          },
          dataLabels: {
            name: {
              show: false,
            },
            value: {
              fontSize: "40px",
              offsetY: 10,
              formatter: (val) => {
                return val + "%";
              },
            },
          },
        },
      },
      colors: [({ value }) => (value < 30 ? "#ff637e" : value < 75 ? "#ffb900" : "#00d492")],
    };

    const el = document.querySelector("#chartRespectEngagement");
    const chartRespectEngagement = new ApexCharts(el, optionsRespectEngagement);
    chartRespectEngagement.render();
    const week = @json($week);
    fetch(`/kpi/api/respect-engagement/${week}`) 
      .then((response) => response.json())
      .then((data) => {
        const value = Math.min(Math.ceil(Number(data.respectEngagement)), 100);
        chartRespectEngagement.updateSeries([value]); // Passe un tableau contenant le nombre
      })
      .catch((error) => {
        console.error("Erreur lors du chargement des données :", error);
      });
  });
</script>