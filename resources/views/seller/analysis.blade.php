<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            売上分析
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">{{ __('月別売上 (直近1年間)') }}</div>
                                    <div class="card-body">
                                        <div>
                                            <canvas id="monthlySalesChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">{{ __('日別売上 (直近30日間)') }}</div>
                                    <div class="card-body">
                                        <div>
                                            <canvas id="dailySalesChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const monthlyChart = document.getElementById('monthlySalesChart')
        const monthLabels = Object.values({{ Js::from($monthLabels) }})
        const monthlySalesData = Object.values({{ Js::from($monthlySalesData) }})

        new Chart(monthlyChart, {
            type: 'bar',
                data: {
                labels: monthLabels,
                datasets: [{
                    label: '売上',
                    data: monthlySalesData,
                    borderWidth: 1
                }]
                },
                options: {
                scales: {
                    y: {
                    beginAtZero: true
                    }
                }
            }
        })

        // const dailyChart = document.getElementById('dailySalesChart')
        // const dateLabels = Object.values()
        // const dailySalesData = Object.values()

        // new Chart(dailyChart, {
        //     type: 'bar',
        //         data: {
        //         labels: dateLabels,
        //         datasets: [{
        //             label: '売上',
        //             data: dailySalesData,
        //             borderWidth: 1
        //         }]
        //         },
        //         options: {
        //         scales: {
        //             y: {
        //             beginAtZero: true
        //             }
        //         }
        //     }
        // })
    </script>
</x-app-layout>
