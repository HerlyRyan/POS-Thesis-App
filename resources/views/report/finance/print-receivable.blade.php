<x-print-layout title="Laporan Piutang" :reportTitle="'LAPORAN DATA PIUTANG'" :companyName="'Galam Sani'" :companyAddress="'Jl. Jurusan Pelaihari KM. 24, Landasan Ulin Selatan, Liang Anggang,
Kota Banjarbaru, Kalimantan Selatan, 70722, Indonesia'" :companyPhone="'+62 821-5604-8305'"
    :companyEmail="'info@galamsani.co.id'" :period="request('status') ? 
        (request('status') == 'paid' ? 'Status: Lunas' : 
         (request('status') == 'unpaid' ? 'Status: Belum Lunas' : 'Status: Cicil')) :
        (request('start_date') && request('end_date') ?
            \Carbon\Carbon::parse(request('start_date'))->format('d M Y') . ' - ' . \Carbon\Carbon::parse(request('end_date'))->format('d M Y') :
            (request('year') ? 'Tahun: ' . request('year') : 'Semua Data'))">

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pelanggan</th>
                <th>Total Piutang</th>
                <th>Sudah Dibayar</th>
                <th>Sisa Piutang</th>
                <th>Status</th>
                <th>Jatuh Tempo</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($receivables as $receivable)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ Str::title($receivable->customer->user->name) }}</td>
                    <td class="text-right">Rp {{ number_format($receivable->total_amount, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($receivable->paid_amount, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($receivable->remaining_amount, 0, ',', '.') }}</td>
                    <td class="text-center">
                        @if ($receivable->status == 'unpaid')
                            Belum Lunas
                        @elseif ($receivable->status == 'paid')
                            Lunas
                        @else
                            Cicil
                        @endif
                    </td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($receivable->due_date)->format('d M Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data piutang ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-20">
        <div class="text-right">
            <strong>Total Piutang:</strong> Rp {{ number_format($receivables->sum('total_amount'), 0, ',', '.') }}<br>
            <strong>Total Dibayar:</strong> Rp {{ number_format($receivables->sum('paid_amount'), 0, ',', '.') }}<br>
            <strong>Total Sisa:</strong> Rp {{ number_format($receivables->sum('remaining_amount'), 0, ',', '.') }}
        </div>
    </div>

</x-print-layout>
