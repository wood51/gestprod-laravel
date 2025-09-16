    <div class="flex flex-col h-full w-full">
        <div class="flex-grow bg-base-100 shadow-xl rounded-lg p-6">
            <div id="chartEngagementType" class="h-full w-full"></div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", async () => {
            const week = @json($week);
            const res = await fetch(`/kpi/api/engagement-type/${week}`); // ← ton contrôleur JSON
            const cfg = await res.json(); // { title, series, annotations }

            const options = {
                chart: {
                    type: 'bar',
                    height: '100%',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        columnWidth: '55%',
                        distributed: true
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    type: 'category'
                },
                yaxis: {
                    min: 0,
                    forceNiceScale: true
                },
                legend: {
                    show: false
                },
                title: cfg.title,
                series: cfg.series,
                annotations: cfg.annotations,
            };

            const chart = new ApexCharts(document.querySelector("#chartEngagementType"), options);
            chart.render();
        });
    </script>
