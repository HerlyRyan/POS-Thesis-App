<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white md:text-3xl">
            Detail Penjualan
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-8">
                    {{-- Header Informasi Penjualan --}}
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                Invoice #{{ $sale->invoice_number }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Dibuat pada {{ $sale->transaction_date->format('d F Y, H:i') }}
                            </p>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            <span
                                class="px-3 py-1 text-sm font-semibold rounded-full capitalize {{ $sale->payment_status == 'dibayar' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : ($sale->payment_status == 'belum dibayar' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300') }}">
                                {{ $sale->payment_status }}
                            </span>
                        </div>
                    </div>

                    {{-- Detail Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                        {{-- Kolom Kiri: Info Pelanggan & Petugas --}}
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">Informasi Umum</h3>
                            <dl class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                                <div class="flex justify-between">
                                    <dt class="font-medium text-gray-800 dark:text-gray-200">Pelanggan</dt>
                                    <dd>{{ $sale->customer->user->name ?? '-' }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="font-medium text-gray-800 dark:text-gray-200">Petugas</dt>
                                    <dd>{{ $sale->user->name ?? '-' }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="font-medium text-gray-800 dark:text-gray-200">Metode Pembayaran</dt>
                                    <dd class="capitalize">{{ str_replace('_', ' ', $sale->payment_method) }}</dd>
                                </div>
                            </dl>
                        </div>

                        {{-- Kolom Kanan: Info Pembayaran --}}
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">Rincian Pembayaran</h3>
                            <dl class="space-y-3 text-sm text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex justify-between">
                                    <dt>Subtotal</dt>
                                    <dd>Rp {{ number_format($sale->total_price, 0, ',', '.') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt>Promosi</dt>
                                    @if ($sale->promotion)
                                        <dd>- Rp {{ number_format($sale->total_price - $sale->grand_price, 0, ',', '.') }} <span class="text-xs">({{ $sale->promotion->title }})</span></dd>
                                    @else
                                        <dd>Rp 0</dd>
                                    @endif
                                </div>
                                <div class="flex justify-between font-bold text-base text-gray-900 dark:text-white pt-3 border-t border-gray-200 dark:border-gray-700">
                                    <dt>Grand Total</dt>
                                    <dd>Rp {{ number_format($sale->grand_price, 0, ',', '.') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    {{-- Daftar Produk --}}
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Daftar Produk</h3>
                    <div class="flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr>
                                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-100 sm:pl-6">Produk</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">Harga Satuan</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">Jumlah</th>
                                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 text-right text-sm font-semibold text-gray-900 dark:text-gray-100">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-800 bg-white dark:bg-gray-900">
                                            @forelse ($sale->details as $detail)
                                                <tr>
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-gray-100 sm:pl-6">{{ $detail->product_name }}</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $detail->quantity }}</td>
                                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 text-gray-800 dark:text-gray-200">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                                        Tidak ada produk dalam penjualan ini.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('admin.sales.index') }}"
                            class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                            Kembali ke Daftar Penjualan
                        </a>
                        <a href="{{ route('admin.sales.print-invoice', $sale) }}" target="_blank"
                            class="inline-flex items-center gap-x-2 rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            <svg class="-ml-0.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5 2.75C5 1.784 5.784 1 6.75 1h6.5c.966 0 1.75.784 1.75 1.75v3.552c.377.135.74.34 1.057.592C17.044 8.62 17.5 9.738 17.5 11c0 1.552-.83 2.94-2.056 3.692A1.749 1.749 0 0114.25 16h-8.5a1.75 1.75 0 01-1.194-1.308C3.33 13.94 2.5 12.552 2.5 11c0-1.262.456-2.38 1.193-3.156a2.734 2.734 0 011.057-.592V2.75zM6.5 2.5a.25.25 0 00-.25.25v3.552c0 .342.118.668.327.922l.21.254.21-.254A1.75 1.75 0 018.25 6h3.5a1.75 1.75 0 011.253.524l.21.254.21-.254a1.75 1.75 0 00.327-.922V2.75a.25.25 0 00-.25-.25h-6.5zM4.005 8.373A1.25 1.25 0 004 8.5v1a1.25 1.25 0 00.005.127C4.02 9.994 4.25 10.353 4.5 10.62V11c0 .966.784 1.75 1.75 1.75h7.5A1.75 1.75 0 0015.5 11v-.38c.25-.267.48-.626.495-.973A1.25 1.25 0 0016 8.5v-1a1.25 1.25 0 00-.005-.127c-.015-.347-.245-.706-.495-.973V6.75a.25.25 0 00-.25-.25h-1.5a.25.25 0 00-.25.25v.5a.75.75 0 01-1.5 0v-.5a.25.25 0 00-.25-.25h-2.5a.25.25 0 00-.25.25v.5a.75.75 0 01-1.5 0v-.5a.25.25 0 00-.25-.25h-1.5a.25.25 0 00-.25.25v.62c-.25.267-.48.626-.495.973z" clip-rule="evenodd" />
                            </svg>
                            Cetak Invoice
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
