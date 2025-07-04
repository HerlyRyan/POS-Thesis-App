<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Menipis</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }

        h2 {
            text-align: center;
            margin-top: 0;
        }
    </style>
</head>

<body>
    <h2>Laporan Stok Menipis</h2>
    <p>Tanggal Cetak: {{ now()->format('d M Y H:i') }}</p>

    @if ($lowStockProducts->isEmpty())
        <p>Semua stok aman.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Stok Saat Ini</th>
                    <th>Batas Minimum</th>
                    <th>Rekomendasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lowStockProducts as $index => $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $product->name }}</td>
                        <td style="color: red; font-weight: bold">{{ $product->stock }}</td>
                        <td>{{ $product->minimum_stock ?? 10 }}</td>
                        <td>Segera lakukan pemesanan ulang</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()">🖨️ Cetak</button>
    </div>
</body>

</html>
