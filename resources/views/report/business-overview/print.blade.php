<x-print-layout title="Laporan Perkembangan Bisnis" :reportTitle="'LAPORAN PERKEMBANGAN BISNIS'" :companyName="'Galam Sani'" :companyAddress="'Jl. Jurusan Pelaihari KM. 24, Landasan Ulin Selatan, Liang Anggang,
    Kota Banjarbaru, Kalimantan Selatan, 70722, Indonesia'" :companyPhone="'+62 821-5604-8305'"
    :companyEmail="'info@galamsani.co.id'" :period="request('year')
        ? 'Tahun ' . request('year')
        : (request('start_date') && request('end_date')
            ? \Carbon\Carbon::parse(request('start_date'))->format('d M Y') .
                ' - ' .
                \Carbon\Carbon::parse(request('end_date'))->format('d M Y')
            : 'Semua Waktu')">

    <h3 class="report-subtitle">Ringkasan Perkembangan Bisnis</h3>
    <table class="report-table">
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th class="right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total Penjualan</td>
                <td class="right">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Modal</td>
                <td class="right">Rp {{ number_format($totalModal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Laba</td>
                <td class="right">Rp {{ number_format($totalLaba, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Utang</td>
                <td class="right">Rp {{ number_format($totalUtang, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Piutang</td>
                <td class="right">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <br>

    <h3 class="report-subtitle">Rincian Penjualan Bulanan</h3>
    <table class="report-table">
        <thead>
            <tr>
                <th>Bulan</th>
                <th class="right">Total Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @if (count($labels) > 0)
                @foreach ($labels as $index => $label)
                    <tr>
                        <td>{{ $label }}</td>
                        <td class="right">Rp {{ number_format($values[$index], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2" style="text-align: center;">Tidak ada data untuk periode yang dipilih.</td>
                </tr>
            @endif
        </tbody>
    </table>

</x-print-layout>
