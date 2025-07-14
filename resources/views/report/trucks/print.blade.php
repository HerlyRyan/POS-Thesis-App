<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Data Truk</title>
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

        .status {
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: bold;
        }

        .tersedia {
            background-color: #d1fae5;
            color: #065f46;
        }

        .dipakai {
            background-color: #fef3c7;
            color: #92400e;
        }

        .diperbaiki {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <h2>Laporan Data Truk</h2>
    <div class="meta">
        Status:
        @if (request('status'))
            {{ ucfirst(request('status')) }}
        @else
            Semua Status
        @endif
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Plat</th>
                <th>Tipe</th>
                <th>Kapasitas</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trucks as $i => $truck)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $truck->plate_number }}</td>
                    <td>{{ $truck->type }}</td>
                    <td>{{ $truck->capacity }} Ton</td>
                    <td>
                        <span class="status {{ $truck->status }}">
                            {{ ucfirst($truck->status) }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()">🖨️ Cetak</button>
    </div>

</body>

</html>
