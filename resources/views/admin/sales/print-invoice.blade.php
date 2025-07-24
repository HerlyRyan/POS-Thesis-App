<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faktur #{{ $sale->invoice_number }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            -webkit-print-color-adjust: exact; /* For better print colors */
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 14px;
            line-height: 24px;
            color: #555;
            background: #fff;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }
        .invoice-box table td {
            padding: 8px 5px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 25px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            padding: 8px 5px;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
            text-align: right;
            padding-top: 10px;
        }
        .invoice-box table tr.total td:nth-child(1) {
            text-align: right;
            padding-top: 10px;
        }
        .invoice-box .header-info {
            float: right;
            text-align: right;
        }
        .invoice-box .customer-info {
            text-align: left;
        }
        .invoice-box .company-info {
            text-align: left;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        /* Responsive Styles (for screens, less critical for print) */
        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }
            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="title">
                                {{-- You can put a logo here if you have one --}}
                                {{-- <img src="your_logo.png" style="width:100%; max-width:150px;"> --}}
                                <h1>FAKTUR</h1>
                            </td>
                            <td>
                                No. Faktur: **{{ $sale->invoice_number }}**<br>
                                Tanggal: {{ \Carbon\Carbon::parse($sale->transaction_date)->format('d F Y H:i') }}<br>
                                Jatuh Tempo: N/A (sesuai status pembayaran)
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="company-info">
                                **Galam Sani**<br>
                                Jl. Jurusan Pelaihari KM. 24, Landasan Ulin Selatan, Liang Anggang<br>
                                Kota Banjarbaru, Kalimantan Selatan, 70722, Indonesia<br>
                                Telepon: +62 821-5604-8305<br>
                                Email: info@galamsani.co.id
                            </td>

                            <td class="customer-info">
                                @if ($sale->customer)
                                    **{{ $sale->customer->name }}**<br>
                                    {{ $sale->customer->address ?? 'N/A' }}<br>
                                    {{ $sale->customer->phone ?? 'N/A' }}
                                @else
                                    **Guest Customer**<br>
                                    N/A<br>
                                    N/A
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Payment Method</td>
                <td colspan="3">Payment Status</td>
            </tr>
            <tr class="details">
                <td>{{ ucfirst($sale->payment_method) }}</td>
                <td colspan="3">{{ ucfirst(str_replace('_', ' ', $sale->payment_status)) }}</td>
            </tr>

            <tr class="heading">
                <td>Product Name</td>
                <td style="text-align: center;">Qty</td>
                <td style="text-align: right;">Unit Price</td>
                <td style="text-align: right;">Subtotal</td>
            </tr>

            @foreach ($sale->details as $detail)
            <tr class="item">
                <td>{{ $detail->product_name }}</td>
                <td style="text-align: center;">{{ $detail->quantity }}</td>
                <td style="text-align: right;">Rp {{ number_format($detail->price, 2, ',', '.') }}</td>
                <td style="text-align: right;">Rp {{ number_format($detail->subtotal, 2, ',', '.') }}</td>
            </tr>
            @endforeach

            <tr class="total">
                <td colspan="3">Total:</td>
                <td>Rp {{ number_format($sale->total_price, 2, ',', '.') }}</td>
            </tr>
        </table>

        <div style="margin-top: 30px; text-align: center;">
            @if ($sale->note)
                <p><strong>Note:</strong> {{ $sale->note }}</p>
            @endif
            <p>Kasir: {{ $sale->user ? $sale->user->name : 'N/A' }}</p>
            <p style="font-size: 11px; margin-top: 20px;">
                Terima kasih telah membeli!<br>
                Tolong simpan faktur ini untuk bukti pembelian.
            </p>
            <p style="font-size: 10px; margin-top: 10px;">
                Tergenerate pada: {{ \Carbon\Carbon::now()->format('d F Y H:i:s') }}
            </p>
        </div>
    </div>
</body>
</html>