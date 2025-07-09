<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
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

    <h2>Laporan Penjualan</h2>
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
                <th>No. Invoice</th>
                <th>Customer</th>
                <th>Sales</th>
                <th>Metode Pembayaran</th>
                <th>Status</th>
                <th>Total</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $i => $sale)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $sale->invoice_number }}</td>
                    <td>{{ $sale->customer->user->name ?? 'N/A' }}</td>
                    <td>{{ $sale->user->name ?? 'Website' }}</td>
                    <td>{{ ucfirst($sale->payment_method) }}</td>
                    <td>{{ ucfirst($sale->payment_status) }}</td>
                    <td class="right">Rp {{ number_format($sale->total_price, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($sale->transaction_date)->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()">🖨️ Cetak</button>
    </div>

</body>

</html>
