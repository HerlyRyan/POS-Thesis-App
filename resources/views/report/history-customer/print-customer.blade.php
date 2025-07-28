<x-print-layout title="Laporan Data Pelanggan" :reportTitle="'LAPORAN DATA PELANGGAN'" :companyName="'Galam Sani'" :companyAddress="'Jl. Jurusan Pelaihari KM. 24, Landasan Ulin Selatan, Liang Anggang,
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
                <th>Nama</th>
                <th>Email</th>
                <th>Nomor Handphone</th>
                <th>Alamat</th>
                <th>Total Pembelian</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($customers as $customer)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ Str::title($customer->user->name) }}</td>
                    <td>{{ $customer->user->email }}</td>
                    <td>{{ $customer->phone ?? '-' }}</td>
                    <td>{{ $customer->address ?? '-' }}</td>
                    <td>{{ $customer->sales_count ?? '0' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data pelanggan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</x-print-layout>
