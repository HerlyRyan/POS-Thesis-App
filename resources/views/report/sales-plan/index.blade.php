<x-admin-layout>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4">Laporan Perencanaan Penjualan</h2>

        <!-- Filter Component -->
        <x-filter-report-table :action="route('admin.report_sales_plan.index')" :printRoute="route('admin.report_sales_plan.print')" :year="true" />

        <canvas id="salesChart" height="120"></canvas>

        <div class="mt-6">
            <h3 class="text-lg font-semibold">Prediksi Penjualan Bulan Depan</h3>
            <p class="text-gray-700">
                Rp {{ number_format($prediction, 0, ',', '.') }}
            </p>
        </div>

        <div class="mt-6">
            <h3 class="text-lg font-semibold">Insight</h3>
            @php
                $latestSales = $salesPerMonth->last();
                $latestTarget = $targets[$salesPerMonth->keys()->last()] ?? 0;
            @endphp

            @if ($latestSales < $latestTarget)
                <p class="text-red-600">⚠️ Penjualan bulan terakhir belum mencapai target. Perlu strategi promo.</p>
            @else
                <p class="text-green-600">✅ Target penjualan bulan terakhir tercapai. Pertahankan strategi saat ini.</p>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');

        const labels = {!! json_encode($salesPerMonth->keys()) !!};
        const salesData = {!! json_encode($salesPerMonth->values()) !!};
        const targets = {!! json_encode($targets) !!};

        const targetData = labels.map(bulan => targets[bulan] ?? null);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Penjualan',
                        data: salesData,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderRadius: 5
                    },
                    {
                        label: 'Target Penjualan',
                        data: targetData,
                        type: 'line',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.2
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    </script>
</x-admin-layout>
