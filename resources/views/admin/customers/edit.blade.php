<x-admin-layout>
    <x-flash-modal />
    <x-slot name="header">
        <h1 class="text-2xl font-bold">Edit Customer</h1>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-white">Ubah Data Customer</h1>
        <br>
        <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST" id="edit-customer-form">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama</label>
                <div class="flex items-center">
                    <input type="text" id="name" name="name" value="{{ old('name', $customer->user->name) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        required>
                </div>
                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                <div class="flex items-center">
                    <input type="text" id="email" name="email"
                        value="{{ old('email', $customer->user->email) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        required>
                </div>
                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nomor
                    Telepon</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $customer->phone) }}"
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
                    required>{{ old('address', $customer->address) }}</textarea>
                @error('address')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Pilih Lokasi di Peta</label>
                <div id="map" class="w-full h-96 rounded shadow mb-2"></div>
                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $customer->latitude) }}">
                <input type="hidden" name="longitude" id="longitude"
                    value="{{ old('longitude', $customer->longitude) }}">
                <p class="text-smc font-medium text-gray-700 dark:text-gray-200">Klik pada peta untuk menentukan lokasi
                    tujuan pengiriman.</p>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('admin.customers.index') }}"
                    class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    Kembali ke Daftar Pelanggan
                </a>
                <button type="button" x-data @click="$dispatch('open-modal', 'confirm-edit')"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Simpan Perubahan
                </button>
            </div>
        </form>

        <x-confirm-create-update-button :name="'confirm-edit'" modalForm="edit-customer-form"
            confirmMessage="Konfirmasi Edit Customer" question="Apakah kamu yakin ingin mengubah data pelanggan ini?"
            buttonText="Ya, Simpan" />
    </div>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        const defaultLat = -3.328;
        const defaultLng = 114.590;

        let currentLat = latInput.value ? parseFloat(latInput.value) : defaultLat;
        let currentLng = lngInput.value ? parseFloat(lngInput.value) : defaultLng;

        const map = L.map('map').setView([currentLat, currentLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        let marker = L.marker([currentLat, currentLng]).addTo(map).bindPopup("Lokasi Customer").openPopup();

        // Jika latitude kosong, coba ambil dari geolocation browser
        if (!latInput.value || !lngInput.value) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    latInput.value = lat;
                    lngInput.value = lng;

                    if (marker) map.removeLayer(marker);
                    marker = L.marker([lat, lng]).addTo(map).bindPopup("Lokasi Anda Sekarang").openPopup();
                    map.setView([lat, lng], 15);
                });
            }
        }

        // Klik peta untuk ubah lokasi
        map.on('click', function(e) {
            const {
                lat,
                lng
            } = e.latlng;
            latInput.value = lat;
            lngInput.value = lng;

            if (marker) map.removeLayer(marker);
            marker = L.marker([lat, lng]).addTo(map).bindPopup("Lokasi Dipilih").openPopup();
        });
    </script>
</x-admin-layout>
