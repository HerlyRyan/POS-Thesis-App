<x-admin-layout>
    <h1 class="text-2xl font-bold mb-4">Live Tracking Truk</h1>

    <div id="map" class="w-full h-[500px] rounded-lg shadow"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <script>
        let map = L.map('map').setView([-3.3194, 114.5907], 13); // posisi awal, misal Banjarmasin

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data © OpenStreetMap contributors',
        }).addTo(map);

        const trucks = @json($trucks);

        trucks.forEach(truck => {
            if (truck.latest_tracking) {
                const lat = truck.latest_tracking.latitude;
                const lng = truck.latest_tracking.longitude;

                let marker = L.marker([lat, lng]).addTo(map);
                marker.bindPopup(`<b>${truck.name}</b><br>Status: ${truck.latest_tracking.status}`);
            }
        });
    </script>
</x-admin-layout>
