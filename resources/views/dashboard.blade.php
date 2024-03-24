<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Trading Point App</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

        <!-- Scrips -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>

    <body class="flex flex-wrap justify-center p-6">
        <div class="flex flex-wrap justify-center mt-4 mb-8">
            <div class="w-1/2 md:w-1/5 p-2">
                <div class="bg-white p-4 rounded shadow">
                    AAPL Max:
                    <span id="max_AAPL">MAX_VALUE_AAPL</span> <br/>
                    <span id="max_percentage_AAPL">MAX_VALUE_AAPL</span>
                    <span id="max_icon_AAPL"> ➖</span>
                </div>
            </div>

            <div class="w-1/2 md:w-1/5 p-2">
                <div class="bg-white p-4 rounded shadow">
                    MSFT Max:
                    <span id="max_MSFT">MAX_VALUE_MSFT</span> <br/>
                    <span id="max_percentage_MSFT">MAX_VALUE_MSFT</span>
                    <span id="max_icon_MSFT"> ➖</span>
                </div>
            </div>

            <div class="w-1/2 md:w-1/5 p-2">
                <div class="bg-white p-4 rounded shadow">
                    TSLA Max:
                    <span id="max_TSLA">MAX_VALUE_TSLA</span> <br/>
                    <span id="max_percentage_TSLA">MAX_VALUE_TSLA</span>
                    <span id="max_icon_TSLA"> ➖</span>
                </div>
            </div>

            <div class="w-1/2 md:w-1/5 p-2">
                <div class="bg-white p-4 rounded shadow">
                    PFE Max:
                    <span id="max_PFE">MAX_VALUE_PFE</span> <br/>
                    <span id="max_percentage_PFE">MAX_VALUE_PFE</span>
                    <span id="max_icon_PFE"> ➖</span>
                </div>
            </div>

            <div class="w-1/2 md:w-1/5 p-2">
                <div class="bg-white p-4 rounded shadow">
                    MSI Max:
                    <span id="max_MSI">MAX_VALUE_MSI</span> <br/>
                    <span id="max_percentage_MSI">MAX_VALUE_MSI</span>
                    <span id="max_icon_MSI"> ➖</span>
                </div>
            </div>

            <div class="w-1/2 md:w-1/5 p-2">
                <div class="bg-white p-4 rounded shadow">
                    DIS Max:
                    <span id="max_DIS">MAX_VALUE_DIS</span> <br/>
                    <span id="max_percentage_DIS">MAX_VALUE_DIS</span>
                    <span id="max_icon_DIS"> ➖</span>
                </div>
            </div>

            <div class="w-1/2 md:w-1/5 p-2">
                <div class="bg-white p-4 rounded shadow">
                    UBER Max:
                    <span id="max_UBER">MAX_VALUE_UBER</span> <br/>
                    <span id="max_percentage_UBER">MAX_VALUE_UBER</span>
                    <span id="max_icon_UBER"> ➖</span>
                </div>
            </div>

            <div class="w-1/2 md:w-1/5 p-2">
                <div class="bg-white p-4 rounded shadow">
                    TXN Max:
                    <span id="max_TXN">MAX_VALUE_TXN</span> <br/>
                    <span id="max_percentage_TXN">MAX_VALUE_TXN</span>
                    <span id="max_icon_TXN"> ➖</span>
                </div>
            </div>

            <div class="w-1/2 md:w-1/5 p-2">
                <div class="bg-white p-4 rounded shadow">
                    NVDA Max:
                    <span id="max_NVDA">MAX_VALUE_NVDA</span> <br/>
                    <span id="max_percentage_NVDA">MAX_VALUE_NVDA</span>
                    <span id="max_icon_NVDA"> ➖</span>
                </div>
            </div>

            <div class="w-1/2 md:w-1/5 p-2">
                <div class="bg-white p-4 rounded shadow">
                    NFLX Max:
                    <span id="max_NFLX">MAX_VALUE_NFLX</span> <br/>
                    <span id="max_percentage_NFLX">MAX_VALUE_NFLX</span>
                    <span id="max_icon_NFLX"> ➖</span>
                </div>
            </div>
        </div>


        <!-- Graphs Section -->
        <div class="flex flex-wrap justify-center">
            <div class="w-1/2 p-2"> <canvas id="chart_AAPL"></canvas> </div>

            <div class="w-1/2 p-2"> <canvas id="chart_MSFT"></canvas> </div>

            <div class="w-1/2 p-2"> <canvas id="chart_TSLA"></canvas> </div>

            <div class="w-1/2 p-2"> <canvas id="chart_PFE"></canvas> </div>

            <div class="w-1/2 p-2"> <canvas id="chart_MSI"></canvas> </div>

            <div class="w-1/2 p-2"> <canvas id="chart_DIS"></canvas> </div>

            <div class="w-1/2 p-2"> <canvas id="chart_UBER"></canvas> </div>

            <div class="w-1/2 p-2"> <canvas id="chart_TXN"></canvas> </div>

            <div class="w-1/2 p-2"> <canvas id="chart_NVDA"></canvas> </div>

            <div class="w-1/2 p-2"> <canvas id="chart_NFLX"></canvas> </div>
        </div>


        <script>
            function initChart(canvas, index, dashboardData) {
                /** Set the max value. */
                const maxElement = document.getElementById('max_' + index);
                maxElement.textContent = dashboardData[index]['max'];

                /** Set the new percentage value. */
                const maxPercentageElement = document.getElementById('max_percentage_' + index);
                maxPercentageElement.textContent = dashboardData[index]['movePercentage'];

                /** Set the new icon. */
                const maxIconElement = document.getElementById('max_icon_' + index);
                switch(dashboardData[index]['moveDirection']) {
                    case 'up':
                        maxIconElement.textContent = ' 🔼';
                        break;
                    case 'down':
                        maxIconElement.textContent = ' 🔽';
                        break;
                    case 'same':
                        maxIconElement.textContent = ' ➖';
                        break;
                }

                /** Create the graph. */
                return new Chart(canvas, {
                    type: 'line',
                    data: {
                        labels: dashboardData[index]['graphLabels'],
                        datasets: [{
                            label: index,
                            data: dashboardData[index]['graphData'],
                        }]
                    },
                    options: { scales: { y: { beginAtZero: true } } }
                });
            }

            var aapl = document.getElementById('chart_AAPL').getContext('2d');
            var aaplChart = initChart(aapl, 'AAPL', @json($dashboardData));

            var msft = document.getElementById('chart_MSFT').getContext('2d');
            var msftChart = initChart(msft, 'MSFT', @json($dashboardData));

            var tsla = document.getElementById('chart_TSLA').getContext('2d');
            var tslaChart = initChart(tsla, 'TSLA', @json($dashboardData));

            var pfe = document.getElementById('chart_PFE').getContext('2d');
            var pfeChart = initChart(pfe, 'PFE', @json($dashboardData));

            var msi = document.getElementById('chart_MSI').getContext('2d');
            var msiChart = initChart(msi, 'MSI', @json($dashboardData));

            var dis = document.getElementById('chart_DIS').getContext('2d');
            var disChart = initChart(dis, 'DIS', @json($dashboardData));

            var uber = document.getElementById('chart_UBER').getContext('2d');
            var uberChart = initChart(uber, 'UBER', @json($dashboardData));

            var txn = document.getElementById('chart_TXN').getContext('2d');
            var txnChart = initChart(txn, 'TXN', @json($dashboardData));

            var nvda = document.getElementById('chart_NVDA').getContext('2d');
            var nvdaChart = initChart(nvda, 'NVDA', @json($dashboardData));

            var nflx = document.getElementById('chart_NFLX').getContext('2d');
            var nflxChart = initChart(nflx, 'NFLX', @json($dashboardData));

        </script>

        @vite(['resources/js/app.js'])
    </body>
</html>
