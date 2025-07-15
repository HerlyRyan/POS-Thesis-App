<x-print-layout title="Laporan Keuangan" :reportTitle="'LAPORAN KEUANGAN'" :companyName="'Galam Sani'" :companyAddress="'Jl. Jurusan Pelaihari KM. 24, Landasan Ulin Selatan, Liang Anggang,
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
                <th>Tanggal</th>
                <th>Tipe</th>
                <th>Sumber</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th>Debit</th>
                <th>Kredit</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($records as $record)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($record->transaction_date)->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($record->type) }}</td>
                    <td>{{ ucfirst($record->source) }}</td>
                    <td>{{ ucfirst($record->category) }}</td>
                    <td>{{ $record->description }}</td>
                    <td class="text-right">
                        @if ($record->type === 'income')
                            Rp {{ number_format($record->amount, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-right">
                        @if ($record->type === 'expense')
                            Rp {{ number_format($record->amount, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-right">Rp {{ number_format($record->total, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-20 text-right">
        <strong>Saldo Akhir:</strong> Rp {{ number_format($records->sum('amount'), 0, ',', '.') }}
    </div>

</x-print-layout>
