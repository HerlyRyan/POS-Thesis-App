<x-print-layout title="Laporan Stok Menipis" :reportTitle="'LAPORAN STOK MENIPIS'" :companyName="'Galam Sani'" :companyAddress="'Jl. Jurusan Pelaihari KM. 24, Landasan Ulin Selatan, Liang Anggang,
Kota Banjarbaru, Kalimantan Selatan, 70722, Indonesia'" :companyPhone="'+62 821-5604-8305'"
    :companyEmail="'info@galamsani.co.id'" :period="now()->format('d M Y H:i')">

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Stok Saat Ini</th>
                <th>Batas Minimum</th>
                <th>Rekomendasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($lowStockProducts as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->name }}</td>
                    <td style="color: red; font-weight: bold">{{ $product->stock }}</td>
                    <td>{{ $product->minimum_stock ?? 10 }}</td>
                    <td>Segera lakukan pemesanan ulang</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Semua stok aman.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</x-print-layout>
