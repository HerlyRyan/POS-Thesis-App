<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faktur #{{ $sale->invoice_number }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
        }
        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 40px;
            background: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #007bff;
        }
        .invoice-header .logo-container {
            flex: 1;
        }
        .invoice-header .logo-container img {
            max-width: 150px;
        }
        .invoice-header .invoice-details {
            flex: 1;
            text-align: right;
        }
        .invoice-header h1 {
            margin: 0;
            color: #007bff;
            font-size: 2.4em;
            font-weight: 700;
        }
        .invoice-header .invoice-details p {
            margin: 0;
            font-size: 1em;
            line-height: 1.5;
        }
        .company-customer-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }
        .company-customer-info .info-block {
            width: 48%;
        }
        .company-customer-info h3 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #555;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            font-size: 1.1em;
        }
        .company-customer-info p {
            margin: 0;
            line-height: 1.6;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .invoice-table th, .invoice-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        .invoice-table thead th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            font-size: 0.85em;
            border-bottom: 2px solid #ccc;
        }
        .invoice-table tbody tr:last-child td {
            border-bottom: none;
        }
        .invoice-table .text-center { text-align: center; }
        .invoice-table .text-right { text-align: right; }
        .invoice-summary {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
        }
        .invoice-summary table {
            width: 50%;
            border-collapse: collapse;
        }
        .invoice-summary td {
            padding: 10px 15px;
        }
        .invoice-summary .total {
            font-size: 1.4em;
            font-weight: bold;
            color: #007bff;
            border-top: 2px solid #007bff;
            border-bottom: 2px solid #007bff;
        }
        .invoice-footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            font-size: 0.9em;
            color: #777;
        }
        .invoice-footer .notes {
            margin-bottom: 20px;
        }
        .invoice-footer .notes strong {
            color: #333;
        }
        @media print {
            body {
                background-color: #fff;
            }
            .invoice-container {
                box-shadow: none;
                border: none;
                margin: 0;
                padding: 0;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <header class="invoice-header">
            <div class="logo-container">
                <img src="{{ asset('/storage/logo.png') }}" alt="Logo Galam Sani">
            </div>
            <div class="invoice-details">
                <h1>INVOICE</h1>
                <p><strong>No. Faktur:</strong> {{ $sale->invoice_number }}</p>
                <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($sale->transaction_date)->format('d F Y') }}</p>
                <p><strong>Status:</strong> <span style="font-weight:bold; color: {{ $sale->payment_status == 'dibayar' ? '#28a745' : '#dc3545' }};">{{ ucfirst(str_replace('_', ' ', $sale->payment_status)) }}</span></p>
            </div>
        </header>

        <section class="company-customer-info">
            <div class="info-block">
                <h3>Dari:</h3>
                <p><strong>Galam Sani</strong></p>
                <p>Jl. Jurusan Pelaihari KM. 24, Landasan Ulin Selatan, Liang Anggang</p>
                <p>Kota Banjarbaru, Kalimantan Selatan, 70722</p>
                <p>+62 821-5604-8305</p>
            </div>
            <div class="info-block" style="text-align: right;">
                <h3>Untuk:</h3>
                @if ($sale->customer)
                    <p><strong>{{ $sale->customer->user->name }}</strong></p>
                    <p>{{ $sale->customer->address ?? 'Alamat tidak tersedia' }}</p>
                    <p>{{ $sale->customer->phone ?? 'Telepon tidak tersedia' }}</p>
                @else
                    <p><strong>Pelanggan Umum</strong></p>
                @endif
            </div>
        </section>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th class="text-center">Kuantitas</th>
                    <th class="text-right">Harga Satuan</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sale->details as $detail)
                <tr>
                    <td>{{ $detail->product_name }}</td>
                    <td class="text-center">{{ $detail->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <section class="invoice-summary">
            <table>
                <tr>
                    <td class="text-right">Subtotal</td>
                    <td class="text-right">Rp {{ number_format($sale->total_price, 0, ',', '.') }}</td>
                </tr>
                @if($sale->discount > 0)
                <tr>
                    <td class="text-right">
                        Diskon
                        @if($sale->promotion)
                            <br><small>({{ $sale->promotion->title }})</small>
                        @endif
                    </td>
                    <td class="text-right">- Rp {{ number_format($sale->discount, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr>
                    <td class="text-right">Metode Pembayaran:</td>
                    <td class="text-right" style="font-weight: bold;">{{ ucfirst($sale->payment_method) }}</td>
                </tr>
                <tr>
                    <td class="text-right total">Grand Total</td>
                    <td class="text-right total">Rp {{ number_format($sale->grand_price, 0, ',', '.') }}</td>
                </tr>
            </table>
        </section>

        <footer class="invoice-footer">
            @if ($sale->note)
                <div class="notes">
                    <strong>Catatan:</strong>
                    <p>{{ $sale->note }}</p>
                </div>
            @endif
            <p>Kasir: {{ $sale->user ? $sale->user->name : 'N/A' }}</p>
            <p><strong>Terima kasih atas pembelian Anda!</strong></p>
            <p style="font-size: 0.8em; margin-top: 20px;">
                Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y H:i:s') }}
            </p>
        </footer>
    </div>
</body>
</html>