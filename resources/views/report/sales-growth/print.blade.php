<x-print-layout title="Laporan Penjualan" :reportTitle="'LAPORAN PENJUALAN'" :companyName="'Galam Sani'" :companyAddress="'Jl. Jurusan Pelaihari KM. 24, Landasan Ulin Selatan, Liang Anggang,
    Kota Banjarbaru, Kalimantan Selatan, 70722, Indonesia'" :companyPhone="'+62 821-5604-8305'"
    :companyEmail="'info@galamsani.co.id'" :period="is_numeric(request('month')) && (int) request('month') >= 1 && (int) request('month') <= 12
        ? \Carbon\Carbon::create(date('Y'), (int) request('month'))->translatedFormat('F Y')
        : (request('start_date') && request('end_date')
            ? \Carbon\Carbon::parse(request('start_date'))->format('d M Y') .
                ' - ' .
                \Carbon\Carbon::parse(request('end_date'))->format('d M Y')
            : 'Semua Waktu')">

    <table class="report-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No. Invoice</th>
                <th>Pelanggan</th>
                <th>Penjual</th>
                <th>Metode Pembayaran</th>
                <th>Status</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $i => $sale)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($sale->transaction_date)->format('d-m-Y') }}</td>
                    <td>{{ $sale->invoice_number }}</td>
                    <td>{{ $sale->customer->user->name ?? 'N/A' }}</td>
                    <td>{{ $sale->user->name ?? 'Website' }}</td>
                    <td>{{ ucfirst($sale->payment_method) }}</td>
                    <td>{{ ucfirst($sale->payment_status) }}</td>
                    <td class="right">Rp {{ number_format($sale->total_price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</x-print-layout>
