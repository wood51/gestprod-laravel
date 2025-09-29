<h2 class="text-xl font-bold text-primary mb-4">Indice de Performances - Semaines</h2>
<div id="chartRendementMois" class="w-full h-full"></div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const optionsRendementMois = {
            series: [],
            chart: {
                height: "100%",
                type: "area",
                zoom: {
                    enabled: false,
                },
                toolbar: {
                    show: false,
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {},
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
                    formatter: (val) => {
                        return val.toFixed(2);
                    },
                },
                max: 1.5,

            },
            annotations: {
                yaxis: [{
                    y: 1,
                    y2: 1.01,
                    offsetY: 1,
                    strokeDashArray: 0,
                    borderColor: "#fb7185",
                    fillColor: "#fb7185", 
                    opacity: 1,
                    max: 5,
                    min: 0,
                }, ],
            },
        };

        const el = document.querySelector("#chartRendementMois");
        const chartRendementMois = new ApexCharts(el, optionsRendementMois);
        chartRendementMois.render();
        const week = @json($week);
        const nb_week = @json($nb_week);
        fetch(`/kpi/api/rendement-mois/${week}/${nb_week}`)
            .then((response) => response.json())
            .then((data) => {
                chartRendementMois.updateSeries([data]); // Passe un tableau contenant le nombre
            })
            .catch((error) => {
                console.error("Erreur lors du chargement des données :", error);
            });
    });
</script>
