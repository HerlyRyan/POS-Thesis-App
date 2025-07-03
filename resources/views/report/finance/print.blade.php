<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print - Laporan Keuangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
            margin-bottom: 0;
        }

        .text-right {
            text-align: right;
        }

        .mt-20 {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h2>LAPORAN KEUANGAN</h2>
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

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Tipe</th>
                <th>Sumber</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($records as $record)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($record->transaction_date)->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($record->type) }}</td>
                    <td>{{ ucfirst($record->source) }}</td>
                    <td>{{ ucfirst($record->category) }}</td>
                    <td>{{ $record->description }}</td>
                    <td class="text-right">Rp {{ number_format($record->amount, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($record->total, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-20 text-right">
        <strong>Saldo Akhir:</strong> Rp {{ number_format($records->sum('amount'), 0, ',', '.') }}
    </div>

    <script>
        window.print();
    </script>
</body>

</html>
