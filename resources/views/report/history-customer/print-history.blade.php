<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pemesanan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            padding: 8px 10px;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #f0f0f0;
        }

        h2 {
            text-align: center;
            margin-bottom: 0;
        }

        .meta {
            margin-top: 5px;
            text-align: center;
            font-size: 14px;
        }

        .right {
            text-align: right;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <h2>Laporan Pemesanan</h2>
    <div class="meta">
        Periode:
        @if (request('month'))
            {{ \Carbon\Carbon::create()->month(request('month'))->translatedFormat('F Y') }}
        @elseif(request('start_date') && request('end_date'))
            {{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }} -
            {{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }}
        @else
            Semua Waktu
        @endif
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Invoice</th>
                <th>Buruh</th>
                <th>Supir</th>
                <th>Truk</th>
                <th>Tanggal Kirim</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $i => $order)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $order->sale->invoice_number ?? '-' }}</td>
                    <td>{{ $order->workers->pluck('user.name')->map(function ($name) {return ucfirst($name);})->join(', ') ?? '-' }}
                    </td>
                    <td>{{ ucfirst(optional(optional($order->driver)->user)->name) ?? '-' }}</td>
                    <td>{{ $order->truck->plate_number ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->shipping_date)->format('d M Y') }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()">🖨️ Cetak</button>
    </div>

</body>

</html>
