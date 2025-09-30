<x-admin-layout>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <div class="space-y-6">
            {{-- Main Card --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Laporan Perencanaan Penjualan</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Analisis dan prediksi penjualan berdasarkan data
                        historis.</p>
                </div>
            </div>

            <!-- Filter Component -->
            <x-filter-report-table :action="route('admin.report_sales_plan.index')" :printRoute="route('admin.report_sales_plan.print')" :year="true" />

            {{-- Chart Card --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="relative h-96">
                    <canvas id="salesChart"></canvas>
                </div>
                <div class="mt-6">
                    <h2 class="text-lg font-semibold">Perencanaan Peningkatan Penjualan</h2>
                    <ul class="list-disc ml-5 mt-2">
                        @forelse($promotions as $promo)
                            <li class="py-3 border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $promo->title }}</p>
                                        <p class="text-sm text-gray-500 flex items-center mt-1">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            {{ \Carbon\Carbon::parse($promo->start_date)->isoFormat('D MMM') }} -
                                            {{ \Carbon\Carbon::parse($promo->end_date)->isoFormat('D MMM YYYY') }}
                                        </p>
                                    </div>
                                    <div class="mt-2 sm:mt-0">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                            Target: {{ $promo->expected_increase ?? 'N/A' }}%
                                        </span>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li>Belum ada rencana promo</li>
                        @endforelse
                    </ul>
                </div>

            </div>

            {{-- Stats and Insights Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Prediction Card --}}
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Prediksi Penjualan Bulan
                        Depan
                    </h3>
                    <p class="text-3xl font-bold text-gray-900">
                        Rp {{ number_format($prediction, 0, ',', '.') }}
                    </p>
                </div>

                {{-- Insight Card --}}
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-700">Insight Bulan Terakhir</h3>
                    @php
                        $latestSales = $salesPerMonth->last();
                        $latestTarget = $targets[$salesPerMonth->keys()->last()] ?? 0;
                    @endphp

                    @if ($latestSales < $latestTarget)
                        <div class="flex items-center space-x-3">
                            <span
                                class="flex-shrink-0 w-8 h-8 rounded-full bg-red-500/20 flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                </svg>
                            </span>
                            <p class="text-red-500">Penjualan belum mencapai target. Perlu strategi
                                promo.
                            </p>
                        </div>
                    @else
                        <div class="flex items-center space-x-3">
                            <span
                                class="flex-shrink-0 w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <p class="text-green-500">Target penjualan tercapai. Pertahankan
                                strategi
                                saat ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            const isDarkMode = document.documentElement.classList.contains('dark');

            const labels = {!! json_encode($salesPerMonth->keys()) !!};
            const salesData = {!! json_encode($salesPerMonth->values()) !!};
            const targets = {!! json_encode($targets) !!};

            const targetData = labels.map(bulan => targets[bulan] ?? null);

            // Create gradient for sales bars
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(79, 70, 229, 0.8)');
            gradient.addColorStop(1, 'rgba(79, 70, 229, 0.2)');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Penjualan',
                            data: salesData,
                            backgroundColor: gradient,
                            borderColor: 'rgba(79, 70, 229, 1)',
                            borderWidth: 1.5,
                            borderRadius: 6,
                            borderSkipped: false,
                        },
                        {
                            label: 'Target Penjualan',
                            data: targetData,
                            type: 'line',
                            borderColor: 'rgba(239, 68, 68, 1)',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(239, 68, 68, 1)',
                            pointBorderColor: isDarkMode ? '#1f2937' : '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgba(239, 68, 68, 1)',
                            fill: false,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'end',
                            labels: {
                                padding: 20,
                                boxWidth: 12,
                                color: isDarkMode ? '#9ca3af' : '#6b7280',
                                font: {
                                    size: 14
                                }
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: isDarkMode ? '#111827' : '#fff',
                            titleColor: isDarkMode ? '#e5e7eb' : '#111827',
                            bodyColor: isDarkMode ? '#d1d5db' : '#374151',
                            borderColor: isDarkMode ? '#374151' : '#e5e7eb',
                            borderWidth: 1,
                            padding: 12,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context
                                            .parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: isDarkMode ? 'rgba(255, 255, 255, 0.1)' : '#e5e7eb'
                            },
                            ticks: {
                                color: isDarkMode ? '#9ca3af' : '#6b7280',
                                callback: function(value) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID', {
                                        notation: 'compact',
                                        compactDisplay: 'short'
                                    }).format(value);
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: isDarkMode ? '#9ca3af' : '#6b7280'
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-admin-layout>
