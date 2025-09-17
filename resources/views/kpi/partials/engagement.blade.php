   <div class="flex flex-col h-full w-full">
       <div class="flex-grow bg-base-100 shadow-xl rounded-lg p-6">
           <div id="chartEngagement" class="h-full w-full"></div>
       </div>
   </div>

   <script>
       document.addEventListener("DOMContentLoaded", function() {
           const optionsEngagement = {
               chart: {
                   type: "bar",
                   height: "100%",
                   width: "100%",
                   toolbar: {
                       show: false,
                   },
                   events: {
                       updated: (chartContext, config) => {
                           const excludedSeries = ["Engagement", "Vide"];
                           document.querySelectorAll(".apexcharts-legend-series").forEach((element) => {
                               // Vérifier si le nom de la série est dans la liste à exclure
                               if (excludedSeries.includes(element.getAttribute("seriesname"))) {
                                   element.remove(); // Supprimer l'élément
                               }
                           });
                       },
                   },
               },
               plotOptions: {
                   bar: {
                       // columnWidth: "50%",
                       borderRadius: 3,
                       distributed: false,
                       borderRadiusApplication: "end",
                       hideZeroBarsWhenGrouped: true,
                   },
               },

               noData: {
                   text: "Chargement ...",
                   fontSize: "24px",
               },
               legend: {
                   show: true,
                   position: "bottom",
                   horizontalAlign: "center",
                   fontSize: "20px",
                   fontWeight: "bold",
                   showForSingleSeries: true,
                   customLegendItems: ["Réalisés", "Objectifs"],
                   // offsetY: -40,
                   markers: {
                       size: 10,
                       fillColors: ["#00E396", "#775DD0"],
                   },
               },

               title: {
                   text: "Engagement Semaine",
                   align: "center",
                   style: {
                       fontSize: "22px",
                       color: "#4B4B4B",
                       fontWeight: "bold",
                   },
               },
               subtitle: {
                   text: "Détails par modèle",
                   align: "center",
                   style: {
                       fontSize: "18px",
                       color: "#666",
                   },
               },
               dataLabels: {
                   enabled: true,
                   enabledOnSeries: [0, 2],
                   formatter: function(val, opt) {
                       if (val >= 1) {
                           return val;
                       }
                       return;
                   },
                   style: {
                       fontSize: "24px",
                       fontFamily: "Helvetica, Arial, sans-serif",
                       fontWeight: "bold",
                       colors: [
                           function(opt) {
                               // Récupère la couleur de la barre et applique la couleur du texte
                               let barColor = opt.w.config.series[opt.seriesIndex].data[opt.dataPointIndex]
                                   .fillColor;
                               let textColor = getLuminance(barColor) > 0.5 ? "black" : "white";
                               return textColor; // Retourne la couleur appropriée pour le texte
                           },
                       ],
                   },
               },
               series: [],
               xaxis: {
                   type: "category",
                   labels: {
                       // rotate :45,
                       // rotateAlways: true,
                       style: {
                           colors: "#333", // Couleur des étiquettes
                           fontSize: "18px", // Taille de la police
                           fontWeight: "bold",
                       },
                   },
               },
               yaxis: {
                   min: 0,

                   labels: {
                       style: {
                           colors: "#333",
                           fontSize: "20px",
                           fontWeight: "bold",
                       },
                       formatter: function(val, index) {
                           return val.toFixed(0);
                       },
                   },
                   stepSize: 1,
               },
           };

           // Fonction pour calculer la luminance d'une couleur
           function getLuminance(hex) {
               var r = parseInt(hex.substr(1, 2), 16) / 255;
               var g = parseInt(hex.substr(3, 2), 16) / 255;
               var b = parseInt(hex.substr(5, 2), 16) / 255;
               var luminance = 0.2126 * r + 0.7152 * g + 0.0722 * b;
               return luminance;
           }

           const chartEngagement = new ApexCharts(document.querySelector(`#chartEngagement`), optionsEngagement);
           chartEngagement.render();
           // const now = new Date();
           // const week = dateFns.format(now, "RRRR-II");
           const week = @json($week);
           fetch(`/kpi/api/engagement/${week}`)
               .then((response) => response.json())
               .then((data) => {
                   chartEngagement.updateOptions({
                       title: {
                           text: data.title.text
                       },
                       plotOptions: {
                           bar: {
                               columnWidth: data.barWidth
                           }
                       },
                       series: data.series,
                       annotations: data.annotations,
                   });
               })
               .catch((error) => {
                   console.error("Erreur lors du chargement des données :", error);
               });
       });
   </script>
