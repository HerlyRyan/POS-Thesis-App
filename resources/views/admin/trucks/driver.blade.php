<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tracking Truk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="bg-gray-100 text-center p-6 font-sans">
    <h1 class="text-xl font-bold mb-4">Pelacakan Truk Aktif</h1>
    <p id="status" class="mb-4 text-gray-700">Mengambil lokasi...</p>

    <script>
        const truckId = {{ $truckId }};
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
</body>
</html>
