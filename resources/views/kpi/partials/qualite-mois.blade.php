<h2 class="text-xl font-bold text-primary mb-4">Indice de Qualité - Semaines</h2>
<div id="month-qualite-chart" class="w-full h-full"></div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const optionsMonthQualite = {
      series: [],
      chart: {
        height: "100%",
        type: "bar",
        stacked: true,
        stackType: "100%",
        zoom: {
          enabled: false,
        },
        toolbar: {
          show: false,
        },
      },
      dataLabels: {
        enabled: true,
        style: {
          colors: ["#fff"],
        },
      },
      stroke: {
        show: true,
        width: 1,
        colors: ["#fff"],
      },
      xaxis: {
        type: "category",
        labels: {
          style: {
            fontSize: "14px",
            fontWeight: "bold",
          },
        },
      },
      yaxis: {
        labels: {
          style: {
            fontSize: "14px",
            fontWeight: "bold",
          },
        },
      },
      legend: {
        position: "top",
        horizontalAlign: "left",
        fontSize: "14px",
        fontWeight: "bold",
      },
      plotOptions: {
        bar: {
          horizontal: true,
          barHeight: "30px",
          dataLabels: {
            position: "center",
          },
        },
      },
    };

    const el = document.querySelector("#month-qualite-chart");
    const monthQualiteChart = new ApexCharts(el, optionsMonthQualite);
    monthQualiteChart.render();
    // fetch(`/defauts/historique/${week}/${nb_week}`)
    //   .then((response) => response.json())
    //   .then((data) => {
    //     monthQualiteChart.updateSeries(data);
    //   })
    //   .catch((error) => {
    //     console.error("Erreur lors du chargement des données :", error);
    //   });
  });
</script>