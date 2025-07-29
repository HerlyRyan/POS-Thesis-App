<x-admin-layout>
    <div class="bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-xl shadow-lg">
        {{-- Header Section --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Riwayat Pembayaran</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Daftar semua pembayaran yang tercatat untuk
                    pegawai.</p>
            </div>
            <a href="{{ route('admin.orders.index') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Kembali
            </a>
        </div>

        {{-- Success Alert --}}
        @if (session('success'))
            <div class="flex items-center p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-900 dark:text-green-400"
                role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 14.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v4.5Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Berhasil!</span> {{ session('success') }}
                </div>
            </div>
        @endif

        {{-- Table Wrapper --}}
        <div class="overflow-x-auto relative">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Tanggal</th>
                        <th scope="col" class="px-6 py-3">Invoice</th>
                        <th scope="col" class="px-6 py-3">Order ID</th>
                        <th scope="col" class="px-6 py-3">Nama Pegawai</th>
                        <th scope="col" class="px-6 py-3">Peran</th>
                        <th scope="col" class="px-6 py-3 text-right">Jumlah</th>
                        <th scope="col" class="px-6 py-3 text-center">Status</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4">{{ $payment->order->sale->invoice_number ?? '-' }}</td>
                            <td class="px-6 py-4">#{{ $payment->order->id }}</td>
                            <td class="px-6 py-4">{{ $payment->employee->user->name ?? '-' }}</td>
                            <td class="px-6 py-4 capitalize">{{ $payment->role }}</td>
                            <td class="px-6 py-4 text-right">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center">
                                @if ($payment->isPaid())
                                    <span
                                        class="px-2 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                        Dibayar
                                    </span>
                                @else
                                    <span
                                        class="px-2 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                                        Belum
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($payment->isPaid())
                                    <a href="{{ route('admin.order_payments.evidence', $payment->id) }}"  target="_blank"
                                        class="inline-flex items-center px-3 py-1.5 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm7-14a2 2 0 10-4 0v-1a2 2 0 00-2-2H9a2 2 0 00-2 2v1a2 2 0 10-4 0h14z">
                                            </path>
                                        </svg>
                                        Cetak
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                    <svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <p class="text-lg font-semibold">Belum ada pembayaran</p>
                                    <p class="text-sm">Saat ini tidak ada data pembayaran yang tercatat.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $payments->links() }}
        </div>
    </div>
</x-admin-layout>
