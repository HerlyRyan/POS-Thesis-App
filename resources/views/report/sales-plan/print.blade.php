<x-print-layout title="Laporan Perkembangan Bisnis" :reportTitle="'LAPORAN PERKEMBANGAN BISNIS'" :companyName="'Galam Sani'" :companyAddress="'Jl. Jurusan Pelaihari KM. 24, Landasan Ulin Selatan, Liang Anggang,
    Kota Banjarbaru, Kalimantan Selatan, 70722, Indonesia'"
    :companyPhone="'+62 821-5604-8305'" :companyEmail="'info@galamsani.co.id'" :period="request('year') ? 'Tahun ' . request('year') : 'Semua Waktu'">
    <h3 class="report-subtitle">Rincian Penjualan Bulanan</h3>
    <table class="report-table">
        <thead>
            <tr>
                <th>Bulan</th>
                <th class="right">Total Penjualan</th>
                <th class="right">Target</th>
                <th class="right">Insight</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($salesPerMonth as $bulan => $total)
                <tr>
                    <td>{{ $bulan }}</td>
                    <td class="right">Rp {{ number_format($total, 0, ',', '.') }}</td>
                    <td class="right">Rp {{ number_format($targets[$bulan] ?? 0, 0, ',', '.') }}</td>
                    <td class="right">
                        @if ($total < $targets[$bulan])
                            <p class="text-red">⚠️ Penjualan bulan ini belum mencapai target. Perlu strategi
                                promo.</p>
                        @else
                            <p class="text-green">✅ Target penjualan bulan ini tercapai. Pertahankan strategi
                                saat ini.</p>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-print-layout>
