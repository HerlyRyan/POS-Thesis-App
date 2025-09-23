<x-admin-layout>
    <x-flash-modal />

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">

        <div class="space-y-6">
            <!-- Page Title -->
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">Perkembangan Bisnis</h1>
            </div>

            <!-- Filter Component -->
            <x-filter-report-table :action="route('admin.report_business_growth.index')" :printRoute="route('admin.report_business_growth.print')" :year="true" />

            <!-- Summary Cards -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <!-- Penjualan Card -->
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h3 class="text-sm font-medium text-gray-500">Penjualan</h3>
                    <p class="mt-1 font-semibold text-indigo-600">
                        Rp {{ number_format($totalPenjualan) }}
                    </p>
                </div>
                <!-- Modal Card -->
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h3 class="text-sm font-medium text-gray-500">Modal</h3>
                    <p class="mt-1 font-semibold text-green-600">
                        Rp {{ number_format($totalModal) }}
                    </p>
                </div>
                <!-- Laba Card -->
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h3 class="text-sm font-medium text-gray-500">Laba</h3>
                    <p class="mt-1 font-semibold text-yellow-600">
                        Rp {{ number_format($totalLaba) }}
                    </p>
                </div>
                <!-- Utang Card -->
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h3 class="text-sm font-medium text-gray-500">Utang</h3>
                    <p class="mt-1 font-semibold text-red-600">
                        Rp {{ number_format($totalUtang) }}
                    </p>
                </div>
                <!-- Piutang Card -->
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h3 class="text-sm font-medium text-gray-500">Piutang</h3>
                    <p class="mt-1 font-semibold text-purple-600">
                        Rp {{ number_format($totalPiutang) }}
                    </p>
                </div>
            </div>

            <!-- Sales Chart -->
            <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-700">Grafik Penjualan Bulanan</h2>
                <div class="h-80"> {{-- Set a fixed height for the container to ensure proper rendering --}}
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart');
            if (!ctx) return;

            const salesChart = new Chart(ctx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        label: 'Penjualan',
                        data: @json($values),
                        borderColor: 'rgba(79, 70, 229, 1)', // Indigo-500
                        backgroundColor: 'rgba(79, 70, 229, 0.2)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(79, 70, 229, 1)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgba(79, 70, 229, 1)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Legend can be redundant if there's only one dataset
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('id-ID', {
                                            style: 'currency',
                                            currency: 'IDR',
                                            minimumFractionDigits: 0
                                        }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, ticks) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                },
                                color: '#6b7280' // Gray-500
                            },
                            grid: {
                                color: '#e5e7eb', // Gray-200
                                drawBorder: false,
                            }
                        },
                        x: {
                            ticks: {
                                color: '#6b7280' // Gray-500
                            },
                            grid: {
                                display: false,
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    }
                }
            });
        });
    </script>
</x-admin-layout>
