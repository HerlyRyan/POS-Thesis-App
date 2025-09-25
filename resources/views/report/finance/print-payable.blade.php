<x-print-layout title="Laporan Hutang" :reportTitle="'LAPORAN DATA HUTANG'" :companyName="'Galam Sani'" :companyAddress="'Jl. Jurusan Pelaihari KM. 24, Landasan Ulin Selatan, Liang Anggang,
Kota Banjarbaru, Kalimantan Selatan, 70722, Indonesia'" :companyPhone="'+62 821-5604-8305'"
    :companyEmail="'info@galamsani.co.id'" :period="request('status') ? 
        (request('status') == 'paid' ? 'Status: Lunas' : 
         (request('status') == 'unpaid' ? 'Status: Belum Dibayar' : 'Status: Dibayar Sebagian')) :
        (request('start_date') && request('end_date') ?
            \Carbon\Carbon::parse(request('start_date'))->format('d M Y') . ' - ' . \Carbon\Carbon::parse(request('end_date'))->format('d M Y') :
            (request('year') ? 'Tahun: ' . request('year') : 'Semua Data'))">

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pemberi Pinjaman</th>
                <th>Total Pinjaman</th>
                <th>Angsuran</th>
                <th>Sisa Pinjaman</th>
                <th>Status</th>
                <th>Jatuh Tempo</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payables as $payable)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ Str::title($payable->lender_name) }}</td>
                    <td class="text-right">Rp {{ number_format($payable->total_amount, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($payable->installment_amount, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($payable->remaining_amount, 0, ',', '.') }}</td>
                    <td class="text-center">
                        @if ($payable->status == 'unpaid')
                            Belum Dibayar
                        @elseif ($payable->status == 'paid')
                            Lunas
                        @else
                            Dibayar Sebagian
                        @endif
                    </td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($payable->due_date)->format('d M Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data hutang ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-20">
        <div class="text-right">
            <strong>Total Pinjaman:</strong> Rp {{ number_format($payables->sum('total_amount'), 0, ',', '.') }}<br>
            <strong>Total Angsuran:</strong> Rp {{ number_format($payables->sum('installment_amount'), 0, ',', '.') }}<br>
            <strong>Total Sisa:</strong> Rp {{ number_format($payables->sum('remaining_amount'), 0, ',', '.') }}
        </div>
    </div>

</x-print-layout>
