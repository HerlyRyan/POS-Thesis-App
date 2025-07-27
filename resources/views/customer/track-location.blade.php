<x-customer-layout>
    {{-- Include Leaflet CSS and JS for the map --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        {{-- Header --}}
        <div
            class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 border-b border-gray-200 pb-6">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900">
                    <i class="fas fa-map-marked-alt text-indigo-600 mr-3"></i> Lacak Lokasi Pengiriman
                </h2>
                <p class="mt-2 text-md text-gray-600">
                    Invoice: <span class="font-semibold text-gray-800">{{ $sale->invoice_number }}</span>
                </p>
            </div>
            <a href="{{ route('customer.orders.index', ['status' => 'pengiriman']) }}"
                class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Pesanan
            </a>
        </div>

        {{-- Main Content Area (Grid) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left Side: Map --}}
            <div class="lg:col-span-2">
                <div id="map"
                    class="w-full h-[500px] bg-gray-200 rounded-lg shadow-inner border border-gray-200 z-0">
                    {{-- Map will be initialized here by JavaScript --}}
                    <div class="flex items-center justify-center h-full text-gray-500">
                        Memuat Peta...
                    </div>
                </div>
            </div>

            {{-- Right Side: Tracking Details --}}
            <div class="lg:col-span-1">
                <div class="bg-gray-50 p-6 rounded-lg shadow-inner border border-gray-200 h-full">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Detail Pengiriman</h3>

                    {{-- Driver & Truck Info --}}
                    <div class="mb-6">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-user-circle text-gray-500 text-2xl mr-4"></i>
                            <div>
                                <p class="text-sm text-gray-600">Pengemudi</p>
                                <p class="font-semibold text-gray-900">{{ $sale->orders->driver->user->name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-truck text-gray-500 text-2xl mr-4"></i>
                            <div>
                                <p class="text-sm text-gray-600">Nomor Polisi</p>
                                <p class="font-semibold text-gray-900">{{ $sale->orders->truck->plate_number }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Status Timeline --}}
                    <div>
                        <h4 class="text-lg font-semibold text-gray-700 mb-4">Riwayat Status Pengiriman</h4>
                        <ol class="relative border-l border-gray-300 dark:border-gray-700 ml-1">
                            @php
                                // Get tracking history, sorted from newest to oldest
                                $trackings = $sale->orders->first()?->truck?->trackings->sortByDesc('created_at');
                            @endphp

                            {{-- 1. Latest Tracking Status --}}
                            @if ($trackings && $trackings->isNotEmpty())
                                @foreach ($trackings as $index => $tracking)
                                    <li class="mb-8 ml-6">
                                        <span
                                            class="absolute flex items-center justify-center w-8 h-8 {{ $index == 0 ? 'bg-indigo-100' : 'bg-gray-100' }} rounded-full -left-4 ring-4 ring-white">
                                            <i
                                                class="fas fa-truck text-{{ $index == 0 ? 'indigo' : 'gray' }}-600"></i>
                                        </span>
                                        <h5 class="flex items-center mb-1 text-md font-semibold {{ $index == 0 ? 'text-gray-900' : 'text-gray-700' }}">
                                            @if ($index == 0)
                                                Lokasi Terkini
                                                <span
                                                    class="bg-indigo-100 text-indigo-800 text-sm font-medium ml-3 px-2.5 py-0.5 rounded">Terkini</span>
                                            @else
                                                Riwayat Lokasi
                                            @endif
                                        </h5>
                                        <time class="block mb-2 text-sm font-normal text-gray-500">
                                            {{ $tracking->created_at->isoFormat('dddd, D MMMM YYYY, HH:mm') }} WITA
                                        </time>
                                        <p class="text-sm text-gray-600">
                                            Truk terpantau di dekat lokasi Anda.
                                        </p>
                                    </li>
                                @endforeach
                            @else
                                {{-- Show this if tracking has started but no data points yet --}}
                                <li class="mb-8 ml-6">
                                    <span
                                        class="absolute flex items-center justify-center w-8 h-8 bg-indigo-100 rounded-full -left-4 ring-4 ring-white">
                                        <i class="fas fa-truck text-indigo-600"></i>
                                    </span>
                                    <h5 class="flex items-center mb-1 text-md font-semibold text-gray-900">
                                        Dalam Perjalanan
                                        <span
                                            class="bg-indigo-100 text-indigo-800 text-sm font-medium ml-3 px-2.5 py-0.5 rounded">Terkini</span>
                                    </h5>
                                    <time class="block mb-2 text-sm font-normal text-gray-500">
                                        {{ \Carbon\Carbon::parse($sale->orders->shipping_date)->isoFormat('dddd, D MMMM YYYY') }}
                                    </time>
                                    <p class="text-sm text-gray-600">Menunggu pembaruan lokasi pertama dari pengemudi.
                                    </p>
                                </li>
                            @endif

                            {{-- 2. Shipping Date Status --}}
                            <li class="mb-8 ml-6">
                                <span
                                    class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -left-4 ring-4 ring-white">
                                    <i class="fas fa-box-open text-gray-600"></i>
                                </span>
                                <h5 class="mb-1 text-md font-semibold text-gray-700">Pesanan Dikirim</h5>
                                <time class="block mb-2 text-sm font-normal text-gray-500">
                                    {{ \Carbon\Carbon::parse($sale->orders->shipping_date)->isoFormat('dddd, D MMMM YYYY') }}
                                </time>
                                <p class="text-sm text-gray-600">Pesanan Anda telah diserahkan kepada kurir dan sedang
                                    dalam perjalanan.</p>
                            </li>

                            {{-- 3. Order Creation Status --}}
                            <li class="ml-6">
                                <span
                                    class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -left-4 ring-4 ring-white">
                                    <i class="fas fa-receipt text-gray-600"></i>
                                </span>
                                <h5 class="mb-1 text-md font-semibold text-gray-700">Pesanan Dibuat</h5>
                                <time class="block mb-2 text-sm font-normal text-gray-500">
                                    {{ $sale->orders->created_at->isoFormat('dddd, D MMMM YYYY, HH:mm') }} WITA
                                </time>
                                <p class="text-sm text-gray-600">Pesanan telah berhasil dibuat dan pembayaran
                                    dikonfirmasi.</p>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get data from Blade
        const truck = @json($sale->orders->truck);
        const driver = @json($sale->orders->driver->user->name);
        const customer = @json($sale->customer);

        // Coordinates
        const truckLat = truck.latest_tracking?.latitude;
        const truckLng = truck.latest_tracking?.longitude;
        const customerLat = customer.latitude;
        const customerLng = customer.longitude;

        // Check if truck coordinates are valid before initializing the map
        if (!truckLat || !truckLng || !customerLat || !customerLng) {
            document.getElementById('map').innerHTML =
                `<div class="flex items-center justify-center h-full text-gray-500 p-4 text-center">Lokasi truk atau pelanggan belum tersedia. Peta tidak dapat ditampilkan.</div>`;
        } else {
            // Initialize the map
            const map = L.map('map');

            // Add a tile layer from OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // --- Icons ---
            // Custom icon for the truck
            const truckIcon = L.icon({
                iconUrl: 'https://img.icons8.com/ios-filled/50/4F46E5/truck.png', // Indigo truck icon
                iconSize: [40, 40],
                iconAnchor: [20, 40],
                popupAnchor: [0, -40]
            });

            // Custom icon for the customer's location (destination)
            const customerIcon = L.icon({
                iconUrl: 'https://img.icons8.com/ios-filled/50/34D399/marker.png', // Green marker icon
                iconSize: [40, 40],
                iconAnchor: [20, 40],
                popupAnchor: [0, -40]
            });

            // --- Markers ---
            // Add a marker for the truck's location
            const truckMarker = L.marker([truckLat, truckLng], {
                icon: truckIcon
            }).addTo(map);
            truckMarker.bindPopup(`<b>Lokasi Truk Saat Ini</b><br>Pengemudi: ${driver}`).openPopup();

            // Add a marker for the customer's location
            const customerMarker = L.marker([customerLat, customerLng], {
                icon: customerIcon
            }).addTo(map);
            customerMarker.bindPopup(`<b>Lokasi Anda</b><br>Tujuan Pengiriman`);

            // --- Map View ---
            // Create a bounds object to fit both markers on the map
            const bounds = L.latLngBounds([
                [truckLat, truckLng],
                [customerLat, customerLng]
            ]);

            // Set the map view to fit the bounds with some padding
            map.fitBounds(bounds.pad(0.2));
        }
    </script>
</x-customer-layout>
