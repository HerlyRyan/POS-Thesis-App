<x-admin-layout>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h1 class="text-2xl text-white font-bold">Tambah Data Pelanggan</h1>
        <br>
        <form action="{{ route('admin.customers.store') }}" method="POST" id="customer-form">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                @error('email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nomor
                    Telepon</label>
                <input type="text" pattern="\d*" inputmode="numeric" id="phone" name="phone"
                    value="{{ old('phone') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                @error('phone')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Alamat</label>
                <textarea id="address" name="address" rows="3"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>{{ old('address') }}</textarea>
                @error('address')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Pilih Lokasi di Peta</label>
                <div id="map" class="w-full h-96 rounded shadow mb-2"></div>
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
                <p class="text-smc font-medium text-gray-700 dark:text-gray-200">Klik pada peta untuk menentukan lokasi
                    tujuan pengiriman.</p>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('admin.customers.index') }}"
                    class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    Kembali ke Daftar Pelanggan
                </a>
                <button type="button" x-data @click="$dispatch('open-modal', 'confirm-create')"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Tambah Pelanggan
                </button>
            </div>
        </form>

        <x-confirm-create-update-button :name="'confirm-create'" modalForm="customer-form"
            confirmMessage="Konfirmasi Tambah Customer" question="Apakah kamu yakin ingin menyimpan data customer ini?"
            buttonText="Ya, Tambah" />
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const defaultLat = -3.328; // fallback location
        const defaultLng = 114.590;
        let map = L.map('map').setView([defaultLat, defaultLng], 13);
        let marker;

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        function dismissLocationError() {
            const notification = document.getElementById('location-error-notification');
            if (notification) {
                notification.style.transition = 'opacity 0.5s';
                notification.style.opacity = '0';
                setTimeout(function() {
                    notification.style.display = 'none';
                }, 500);
            }
        }

        // Ambil lokasi dari browser
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                // Set input
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;

                // Update peta
                map.setView([lat, lng], 15);
                marker = L.marker([lat, lng]).addTo(map).bindPopup("Lokasi Anda").openPopup();
            }, function(error) {
                // Create error notification modal
                const notificationDiv = document.createElement('div');
                notificationDiv.id = 'location-error-notification';
                notificationDiv.className = 'py-4 mb-4 fixed top-16 right-0 z-50 w-auto max-w-[calc(100%-2rem)]';

                notificationDiv.innerHTML = `
                    <div class="mr-4">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-red-500">
                            <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between items-center">
                                <div>
                                    Gagal mendapatkan lokasi. Silakan izinkan akses lokasi atau pilih manual di peta.
                                </div>
                                <button onclick="dismissLocationError()" class="text-gray-500 hover:text-gray-700">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                document.body.appendChild(notificationDiv);

                // Auto dismiss after 5 seconds
                setTimeout(() => {
                    dismissLocationError();
                }, 5000);
            });
        } else {
            alert("Browser tidak mendukung geolocation.");
        }

        // Update lokasi saat peta diklik
        map.on('click', function(e) {
            const {
                lat,
                lng
            } = e.latlng;

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            if (marker) map.removeLayer(marker);
            marker = L.marker([lat, lng]).addTo(map).bindPopup("Lokasi dipilih di sini").openPopup();
        });
    </script>
</x-admin-layout>
