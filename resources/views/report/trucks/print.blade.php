<x-print-layout title="Laporan Data Truk" :reportTitle="'LAPORAN DATA TRUK'" :companyName="'Galam Sani'" :companyAddress="'Jl. Jurusan Pelaihari KM. 24, Landasan Ulin Selatan, Liang Anggang,
Kota Banjarbaru, Kalimantan Selatan, 70722, Indonesia'" :companyPhone="'+62 821-5604-8305'"
    :companyEmail="'info@galamsani.co.id'" :period="'Semua Waktu'">

    @if (request('status'))
        <div class="mb-10">
            <p>Status: <strong>{{ ucfirst(request('status')) }}</strong></p>
        </div>
    @endif

    <table>
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
            @forelse ($trucks as $truck)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $truck->plate_number }}</td>
                    <td>{{ $truck->type }}</td>
                    <td class="text-right">{{ $truck->capacity }} Ton</td>
                    <td>
                        <span class="status {{ $truck->status }}">
                            {{ ucfirst($truck->status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data truk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</x-print-layout>
