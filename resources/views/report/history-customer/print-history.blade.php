<x-print-layout title="Laporan Pemesanan " :reportTitle="'LAPORAN PEMESANAN'" :companyName="'Galam Sani'" :companyAddress="'Jl. Jurusan Pelaihari KM. 24, Landasan Ulin Selatan, Liang Anggang,
    Kota Banjarbaru, Kalimantan Selatan, 70722, Indonesia'" :companyPhone="'+62 821-5604-8305'"
    :companyEmail="'info@galamsani.co.id'" :period="is_numeric(request('month')) && (int) request('month') >= 1 && (int) request('month') <= 12
        ? \Carbon\Carbon::create(date('Y'), (int) request('month'))->translatedFormat('F Y')
        : (request('start_date') && request('end_date')
            ? \Carbon\Carbon::parse(request('start_date'))->format('d M Y') .
                ' - ' .
                \Carbon\Carbon::parse(request('end_date'))->format('d M Y')
            : 'Semua Waktu')">

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Invoice</th>
                <th>Produk: Kuantitas</th>
                <th>Buruh</th>
                <th>Supir</th>
                <th>Truk</th>
                <th>Tanggal Kirim</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->sale->invoice_number ?? '-' }}</td>
                    <td>
                        @if ($order->sale && $order->sale->details)
                            <ul>
                                @foreach ($order->sale->details as $detail)
                                    <li>{{ $detail->product_name }}: {{ $detail->quantity }}
                                        {{ $detail->product->unit }}</li>
                                @endforeach
                            </ul>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $order->workers->pluck('user.name')->map(function ($name) {return ucfirst($name);})->join(', ') ?? '-' }}
                    </td>
                    <td>{{ ucfirst(optional(optional($order->driver)->user)->name) ?? '-' }}</td>
                    <td>{{ $order->truck->plate_number ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->shipping_date)->format('d M Y') }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data pemesanan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</x-print-layout>
