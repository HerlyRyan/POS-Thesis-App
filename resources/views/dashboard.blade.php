<x-admin-layout>
    @php
        $user = Auth::user();
        $role = $user->roles->first()?->name;
    @endphp
    @if ($role === 'employee')
        @php
            $position = $user->employee->position;
            $employee = $user->employee;
            $truckId = $employee?->activeOrder?->truck_id;
        @endphp
        @if ($role === 'employee' && $position === 'supir')
            <script>
                const truckId = @json($truckId);
                console.log(truckId)
                const token = '{{ csrf_token() }}';

                function updateLocation(position) {
                    fetch('/api/truck-location/update', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                            },
                            body: JSON.stringify({
                                latitude: position.coords.latitude,
                                longitude: position.coords.longitude,
                                truck_id: truckId
                            })
                        })
                        .then(() => {
                            document.getElementById('status').innerText = 'Lokasi terkirim';
                        })
                        .catch(() => {
                            document.getElementById('status').innerText = 'Gagal kirim lokasi';
                        });
                }

                function errorHandler(error) {
                    document.getElementById('status').innerText = 'Error: ' + error.message;
                    console.log(error)
                }

                setInterval(() => {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(updateLocation, errorHandler);
                    } else {
                        document.getElementById('status').innerText = 'Browser tidak mendukung lokasi.';
                    }
                }, 15000); // 15 detik
            </script>
        @endif
    @endif

    @if (session('login_success'))
        <div class="py-4 mb-4 fixed top-16 right-0 z-50 w-auto max-w-[calc(100%-16rem)]" id="login-notification">
            <div class="mr-4">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500">
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between items-center">
                        <div>
                            {{ __("You're logged in as ") }} <span class="font-bold">{{ Auth::user()->name }}</span>
                            <span
                                class="ml-1 px-2 py-1 bg-indigo-600 text-white text-xs rounded-full">{{ Auth::user()->role }}</span>
                        </div>
                        <button onclick="dismissNotification()" class="text-gray-500 hover:text-gray-700">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{ session()->forget('login_success') }}
    @endif

    <h3 class="text-gray-700 text-3xl font-medium">Dashboard</h3>

    @if ($role === 'admin' || $role === 'owner')
        <div class="mt-4">
            <div class="flex flex-wrap -mx-6">
                <div class="w-full px-6 sm:w-1/2 xl:w-1/3">
                    <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
                        <div class="p-3 rounded-full bg-indigo-600 bg-opacity-75">
                            <svg class="h-8 w-8 text-white" viewBox="0 0 28 30" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18.2 9.08889C18.2 11.5373 16.3196 13.5222 14 13.5222C11.6804 13.5222 9.79999 11.5373 9.79999 9.08889C9.79999 6.64043 11.6804 4.65556 14 4.65556C16.3196 4.65556 18.2 6.64043 18.2 9.08889Z"
                                    fill="currentColor" />
                                <path
                                    d="M25.2 12.0444C25.2 13.6768 23.9464 15 22.4 15C20.8536 15 19.6 13.6768 19.6 12.0444C19.6 10.4121 20.8536 9.08889 22.4 9.08889C23.9464 9.08889 25.2 10.4121 25.2 12.0444Z"
                                    fill="currentColor" />
                                <path
                                    d="M19.6 22.3889C19.6 19.1243 17.0927 16.4778 14 16.4778C10.9072 16.4778 8.39999 19.1243 8.39999 22.3889V26.8222H19.6V22.3889Z"
                                    fill="currentColor" />
                                <path
                                    d="M8.39999 12.0444C8.39999 13.6768 7.14639 15 5.59999 15C4.05359 15 2.79999 13.6768 2.79999 12.0444C2.79999 10.4121 4.05359 9.08889 5.59999 9.08889C7.14639 9.08889 8.39999 10.4121 8.39999 12.0444Z"
                                    fill="currentColor" />
                                <path
                                    d="M22.4 26.8222V22.3889C22.4 20.8312 22.0195 19.3671 21.351 18.0949C21.6863 18.0039 22.0378 17.9556 22.4 17.9556C24.7197 17.9556 26.6 19.9404 26.6 22.3889V26.8222H22.4Z"
                                    fill="currentColor" />
                                <path
                                    d="M6.64896 18.0949C5.98058 19.3671 5.59999 20.8312 5.59999 22.3889V26.8222H1.39999V22.3889C1.39999 19.9404 3.2804 17.9556 5.59999 17.9556C5.96219 17.9556 6.31367 18.0039 6.64896 18.0949Z"
                                    fill="currentColor" />
                            </svg>
                        </div>

                        <div class="mx-5">
                            <h4 class="text-2xl font-semibold text-gray-700">{{ $totalUsers }}</h4>
                            <div class="text-gray-500">Users</div>
                        </div>
                    </div>
                </div>

                <div class="w-full mt-6 px-6 sm:w-1/2 xl:w-1/3 sm:mt-0">
                    <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
                        <div class="p-3 rounded-full bg-orange-600 bg-opacity-75">
                            <svg class="h-8 w-8 text-white" viewBox="0 0 28 28" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4.19999 1.4C3.4268 1.4 2.79999 2.02681 2.79999 2.8C2.79999 3.57319 3.4268 4.2 4.19999 4.2H5.9069L6.33468 5.91114C6.33917 5.93092 6.34409 5.95055 6.34941 5.97001L8.24953 13.5705L6.99992 14.8201C5.23602 16.584 6.48528 19.6 8.97981 19.6H21C21.7731 19.6 22.4 18.9732 22.4 18.2C22.4 17.4268 21.7731 16.8 21 16.8H8.97983L10.3798 15.4H19.6C20.1303 15.4 20.615 15.1004 20.8521 14.6261L25.0521 6.22609C25.2691 5.79212 25.246 5.27673 24.991 4.86398C24.7357 4.45123 24.2852 4.2 23.8 4.2H8.79308L8.35818 2.46044C8.20238 1.83722 7.64241 1.4 6.99999 1.4H4.19999Z"
                                    fill="currentColor" />
                                <path
                                    d="M22.4 23.1C22.4 24.2598 21.4598 25.2 20.3 25.2C19.1403 25.2 18.2 24.2598 18.2 23.1C18.2 21.9402 19.1403 21 20.3 21C21.4598 21 22.4 21.9402 22.4 23.1Z"
                                    fill="currentColor" />
                                <path
                                    d="M9.1 25.2C10.2598 25.2 11.2 24.2598 11.2 23.1C11.2 21.9402 10.2598 21 9.1 21C7.9402 21 7 21.9402 7 23.1C7 24.2598 7.9402 25.2 9.1 25.2Z"
                                    fill="currentColor" />
                            </svg>
                        </div>

                        <div class="mx-5">
                            <h4 class="text-2xl font-semibold text-gray-700">{{ $totalSales }}</h4>
                            <div class="text-gray-500">Total Orders</div>
                        </div>
                    </div>
                </div>

                <div class="w-full mt-6 px-6 sm:w-1/2 xl:w-1/3 xl:mt-0">
                    <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
                        <div class="p-3 rounded-full bg-pink-600 bg-opacity-75">
                            <svg class="h-8 w-8 text-white" viewBox="0 0 28 28" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.99998 11.2H21L22.4 23.8H5.59998L6.99998 11.2Z" fill="currentColor"
                                    stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                <path
                                    d="M9.79999 8.4C9.79999 6.08041 11.6804 4.2 14 4.2C16.3196 4.2 18.2 6.08041 18.2 8.4V12.6C18.2 14.9197 16.3196 16.8 14 16.8C11.6804 16.8 9.79999 14.9197 9.79999 12.6V8.4Z"
                                    stroke="currentColor" stroke-width="2" />
                            </svg>
                        </div>

                        <div class="mx-5">
                            <h4 class="text-2xl font-semibold text-gray-700">{{ $totalProducts }}</h4>
                            <div class="text-gray-500">Available Products</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-700">Sales Performance</h2>
                        <p class="text-sm text-gray-500">Grafik penjualan bulanan untuk tahun {{ $selectedYear }}</p>
                    </div>
                    <form method="GET" action="{{ route('dashboard') }}" class="mt-4 sm:mt-0">
                        <label for="year" class="sr-only">Pilih Tahun:</label>
                        <select name="year" id="year" onchange="this.form.submit()"
                            class="block w-full sm:w-auto rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @foreach ($availableYears as $year)
                                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <div class="relative h-80">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>

        @php
            $monthlySales = $monthlySales ?? [
                ['January', 0],
                ['February', 0],
                ['March', 0],
                ['April', 0],
                ['May', 0],
                ['June', 0],
                ['July', 0],
                ['August', 0],
                ['September', 0],
                ['October', 0],
                ['November', 0],
                ['December', 0],
            ];
        @endphp

        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Distribusi Lokasi Pelanggan</h2>
            <div id="customerMap" style="height: 400px;"></div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Status Pengiriman</h2>
            <div class="relative" style="height: 300px;">
                <canvas id="shippingStatusChart"></canvas>
            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Sales Performance Chart
                const salesCtx = document.getElementById('salesChart')?.getContext('2d');
                if (salesCtx) {
                    const salesData = @json($monthlySales);
                    const salesLabels = salesData.map(item => item[0]);
                    const salesValues = salesData.map(item => item[1]);

                    const gradient = salesCtx.createLinearGradient(0, 0, 0, 300);
                    gradient.addColorStop(0, 'rgba(79, 70, 229, 0.5)');
                    gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

                    new Chart(salesCtx, {
                        type: 'line',
                        data: {
                            labels: salesLabels,
                            datasets: [{
                                label: 'Penjualan Bulanan',
                                data: salesValues,
                                backgroundColor: gradient,
                                borderColor: 'rgba(79, 70, 229, 1)',
                                borderWidth: 2,
                                pointBackgroundColor: 'rgba(79, 70, 229, 1)',
                                pointBorderColor: '#fff',
                                pointHoverBackgroundColor: '#fff',
                                pointHoverBorderColor: 'rgba(79, 70, 229, 1)',
                                tension: 0.4,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(200, 200, 200, 0.2)'
                                    },
                                    ticks: {
                                        callback: function(value) {
                                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                        }
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    mode: 'index',
                                    intersect: false,
                                    backgroundColor: '#fff',
                                    titleColor: '#333',
                                    bodyColor: '#666',
                                    borderColor: '#ddd',
                                    borderWidth: 1,
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.dataset.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            if (context.parsed.y !== null) {
                                                label += 'Rp ' + new Intl.NumberFormat('id-ID').format(
                                                    context.parsed.y);
                                            }
                                            return label;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

                // Customer Location Distribution Map
                const customerMap = L.map('customerMap').setView([-3.3, 114.6], 8);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(customerMap);

                const customerData = @json($customerLocations);

                // Inisialisasi cluster group
                const markers = L.markerClusterGroup();

                customerData.forEach(customer => {
                    if (customer.latitude && customer.longitude) {
                        const marker = L.marker([customer.latitude, customer.longitude])
                            .bindPopup(`<strong>${customer.name}</strong><br>${customer.address}`);
                        markers.addLayer(marker);
                    }
                });

                customerMap.addLayer(markers);

                // Shipping Status Chart
                const shippingCtx = document.getElementById('shippingStatusChart')?.getContext('2d');
                if (shippingCtx) {
                    const shippingStatusData = @json($shippingStatusChartData);
                    const statusLabels = shippingStatusData.map(item => item.status.charAt(0).toUpperCase() + item
                        .status.slice(1));
                    const statusCounts = shippingStatusData.map(item => item.total);

                    new Chart(shippingCtx, {
                        type: 'doughnut',
                        data: {
                            labels: statusLabels,
                            datasets: [{
                                data: statusCounts,
                                backgroundColor: [
                                    'rgba(251, 191, 36, 0.8)', // draft (amber-400)
                                    'rgba(59, 130, 246, 0.8)', // persiapan (blue-500)
                                    'rgba(16, 185, 129, 0.8)', // pengiriman (emerald-500)
                                    'rgba(139, 92, 246, 0.8)', // selesai (violet-500)
                                ],
                                borderColor: [
                                    'rgba(251, 191, 36, 1)',
                                    'rgba(59, 130, 246, 1)',
                                    'rgba(16, 185, 129, 1)',
                                    'rgba(139, 92, 246, 1)',
                                ],
                                borderWidth: 1,
                                hoverOffset: 8
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '80%',
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 20,
                                        boxWidth: 12,
                                        font: {
                                            size: 14
                                        }
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return `${context.label}: ${context.raw}`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            });

            function dismissNotification() {
                const notification = document.getElementById('login-notification');
                if (notification) {
                    notification.style.transition = 'opacity 0.5s';
                    notification.style.opacity = '0';
                    setTimeout(function() {
                        notification.style.display = 'none';
                    }, 500);
                }
            }

            // Auto-hide after 5 seconds
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    dismissNotification();
                }, 5000);
            });
        </script>
    @endif

    @if ($role === 'employee')
        <div class="mt-4">
            <div class="w-full mt-6 px-6 sm:w-1/2 xl:w-1/3 sm:mt-0">
                <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
                    <div class="p-3 rounded-full bg-orange-600 bg-opacity-75">
                        <svg class="h-8 w-8 text-white" viewBox="0 0 28 28" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M4.19999 1.4C3.4268 1.4 2.79999 2.02681 2.79999 2.8C2.79999 3.57319 3.4268 4.2 4.19999 4.2H5.9069L6.33468 5.91114C6.33917 5.93092 6.34409 5.95055 6.34941 5.97001L8.24953 13.5705L6.99992 14.8201C5.23602 16.584 6.48528 19.6 8.97981 19.6H21C21.7731 19.6 22.4 18.9732 22.4 18.2C22.4 17.4268 21.7731 16.8 21 16.8H8.97983L10.3798 15.4H19.6C20.1303 15.4 20.615 15.1004 20.8521 14.6261L25.0521 6.22609C25.2691 5.79212 25.246 5.27673 24.991 4.86398C24.7357 4.45123 24.2852 4.2 23.8 4.2H8.79308L8.35818 2.46044C8.20238 1.83722 7.64241 1.4 6.99999 1.4H4.19999Z"
                                fill="currentColor" />
                            <path
                                d="M22.4 23.1C22.4 24.2598 21.4598 25.2 20.3 25.2C19.1403 25.2 18.2 24.2598 18.2 23.1C18.2 21.9402 19.1403 21 20.3 21C21.4598 21 22.4 21.9402 22.4 23.1Z"
                                fill="currentColor" />
                            <path
                                d="M9.1 25.2C10.2598 25.2 11.2 24.2598 11.2 23.1C11.2 21.9402 10.2598 21 9.1 21C7.9402 21 7 21.9402 7 23.1C7 24.2598 7.9402 25.2 9.1 25.2Z"
                                fill="currentColor" />
                        </svg>
                    </div>

                    <div class="mx-5">
                        <h4 class="text-2xl font-semibold text-gray-700">{{ $totalSales }}</h4>
                        <div class="text-gray-500">Total Orders</div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-admin-layout>
