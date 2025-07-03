<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Produk Terlaris</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .info {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th,
        table td {
            border: 1px solid #444;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        @media print {
            body {
                margin: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <h2>Laporan Produk Terlaris</h2>

    <div class="info">
        @if (request('start_date') && request('end_date'))
            <p>Periode: {{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }} -
                {{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }}</p>
        @endif
        @if (request('search'))
            <p>Pencarian: <strong>{{ request('search') }}</strong></p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Total Terjual</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($topProducts as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->total_sold ?? 0 }} unit</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Tidak ada data produk terlaris.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <br><br>
    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()">🖨️ Cetak</button>
    </div>
</body>

</html>
