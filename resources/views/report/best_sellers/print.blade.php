<x-print-layout title="Laporan Produk Terlaris" :reportTitle="'LAPORAN PRODUK TERLARIS'" :companyName="'Galam Sani'" :companyAddress="'Jl. Jurusan Pelaihari KM. 24, Landasan Ulin Selatan, Liang Anggang,
Kota Banjarbaru, Kalimantan Selatan, 70722, Indonesia'" :companyPhone="'+62 821-5604-8305'"
    :companyEmail="'info@galamsani.co.id'" :period="is_numeric(request('month')) && (int) request('month') >= 1 && (int) request('month') <= 12
        ? \Carbon\Carbon::create(date('Y'), (int) request('month'))->translatedFormat('F Y')
        : (request('start_date') && request('end_date')
            ? \Carbon\Carbon::parse(request('start_date'))->format('d M Y') .
                ' - ' .
                \Carbon\Carbon::parse(request('end_date'))->format('d M Y')
            : 'Semua Waktu')">

    @if (request('search'))
        <div class="mb-10">
            <p>Pencarian: <strong>{{ request('search') }}</strong></p>
        </div>
    @endif

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
                    <td class="text-right">{{ $product->total_sold ?? 0 }} {{ $product->unit }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Tidak ada data produk terlaris.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</x-print-layout>
