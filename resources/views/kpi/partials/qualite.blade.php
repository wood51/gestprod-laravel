<h2 class="text-xl font-bold text-primary mb-4 text-center">Indice Qualité Semaine En Cours</h2>
<div id="qualite-chart" class="w-full h-full"></div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const optionsQualite = {
      chart: {
        type: "radialBar",
        height: "100%",
        offsetY: 0,
      },
      series: [0], // Pourcentage de performance
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
    const el = document.querySelector("#qualite-chart");
    const qualiteChart = new ApexCharts(el, optionsQualite);
    qualiteChart.render();
    // fetch(`/defauts/${week}`)
    //   .then((response) => response.json())
    //   .then((data) => {
    //     const value = Math.min(Math.ceil(Number(data.iq)), 100);
    //     qualiteChart.updateSeries([value]);
    //   })
    //   .catch((error) => {
    //     console.error("Erreur lors du chargement des données :", error);
    //   });
  });
</script>