<x-guest-layout>   
    <div class="bg-white p-8 rounded-lg shadow-xl">
        <div class="flex flex-col items-center mb-6">
            <a href="/">
                <img src="{{ asset('/storage/logo.png') }}" alt="Galam Sani Logo" class="h-13 w-13 mb-4">
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Daftar Akun Baru</h1>
        </div>

        <form action="{{ route('register') }}" method="POST" id="register-form">
            @csrf

            {{-- Nama --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama
                    Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-50 text-gray-900"
                    required autofocus>
                @error('name')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat
                    Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-50 text-gray-900"
                    required>
                @error('email')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Nomor Telepon --}}
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor
                    Telepon</label>
                <input type="text" pattern="\d*" inputmode="numeric" id="phone" name="phone"
                    value="{{ old('phone') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-50 text-gray-900"
                    required>
                @error('phone')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Alamat --}}
            <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat
                    Lengkap</label>
                <textarea id="address" name="address" rows="3"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-50 text-gray-900"
                    required>{{ old('address') }}</textarea>
                @error('address')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-50 text-gray-900"
                    required autocomplete="new-password">
                @error('password')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi
                    Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-50 text-gray-900"
                    required autocomplete="new-password">
                @error('password_confirmation')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Peta Lokasi --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Lokasi Pengiriman
                    di Peta</label>
                <div id="map" class="w-full h-80 rounded shadow mb-2"></div>
                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                <p class="text-sm text-gray-600">Klik pada peta untuk menentukan lokasi alamat Anda.
                </p>
                @error('latitude')
                    <span class="text-red-600 text-sm mt-1 block">Lokasi di peta wajib diisi.</span>
                @enderror
                @error('longitude')
                    {{-- Biasanya error latitude/longitude digabung saja --}}
                @enderror
            </div>

            {{-- Tombol Daftar --}}
            <div class="flex items-center justify-end mt-4">
                <button type="submit"
                    class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-base uppercase tracking-wider shadow-lg hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-300 w-full justify-center">
                    Daftar Akun
                </button>
            </div>
        </form>

        {{-- Link ke Halaman Login --}}
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Masuk di sini
                </a>
            </p>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha2d8-jpEezuL+LAqXg7bLh7qfT2XoW/lC+7nF5K5s5J0X0Q=" crossorigin=""></script>
    <script>
        const defaultLat = -3.328; // Default to Bengkulu, Indonesia
        const defaultLng = 114.590;
        let map = L.map('map').setView([defaultLat, defaultLng], 13);
        let marker;

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Function to set marker and update hidden inputs
        function setMapMarker(lat, lng) {
            if (marker) map.removeLayer(marker);
            marker = L.marker([lat, lng]).addTo(map).bindPopup("Lokasi dipilih di sini").openPopup();
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        }

        // Try to get current user location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                map.setView([lat, lng], 15);
                setMapMarker(lat, lng);
            }, function(error) {
                console.error("Error getting location: ", error);
                // Set default marker if there's no old input
                if (!document.getElementById('latitude').value || !document.getElementById('longitude').value) {
                    setMapMarker(defaultLat, defaultLng);
                }
            });
        } else {
            console.warn("Browser tidak mendukung geolocation.");
            // Set default marker if there's no old input
            if (!document.getElementById('latitude').value || !document.getElementById('longitude').value) {
                setMapMarker(defaultLat, defaultLng);
            }
        }

        // If old input values exist (e.g., from validation error), set the marker
        const oldLat = document.getElementById('latitude').value;
        const oldLng = document.getElementById('longitude').value;
        if (oldLat && oldLng) {
            map.setView([oldLat, oldLng], 15);
            setMapMarker(oldLat, oldLng);
        } else if (!navigator.geolocation) { // Fallback if no old input and no geolocation support
            setMapMarker(defaultLat, defaultLng);
        }

        // Update location when map is clicked
        map.on('click', function(e) {
            const {
                lat,
                lng
            } = e.latlng;
            setMapMarker(lat, lng);
        });
    </script>
</x-guest-layout>
