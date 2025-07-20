<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">Detail Penjualan</h1>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-xl">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 border-b-2 border-indigo-500 pb-2">Informasi
            Penjualan</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6 mb-8">
            {{-- Kolom Kiri: Informasi Umum Penjualan --}}
            <div>
                <p class="text-lg text-gray-700 dark:text-gray-300 mb-2">
                    <strong class="font-semibold">Nomor Invoice:</strong>
                    <span class="font-bold text-indigo-600 dark:text-indigo-400">{{ $sale->invoice_number }}</span>
                </p>
                <p class="text-lg text-gray-700 dark:text-gray-300 mb-2">
                    <strong class="font-semibold">Pelanggan:</strong>
                    <span class="font-medium">{{ $sale->customer->user->name ?? '-' }}</span>
                </p>
                <p class="text-lg text-gray-700 dark:text-gray-300">
                    <strong class="font-semibold">Petugas Penjualan:</strong>
                    <span class="font-medium">{{ $sale->user->name ?? '-' }}</span>
                </p>
            </div>

            {{-- Kolom Kanan: Detail Finansial dan Status --}}
            <div>
                <p class="text-lg text-gray-700 dark:text-gray-300 mb-2">
                    <strong class="font-semibold">Total Harga:</strong>
                    <span class="font-bold text-green-600 dark:text-green-400 text-xl">Rp
                        {{ number_format($sale->total_price, 0, ',', '.') }}</span>
                </p>
                <p class="text-lg text-gray-700 dark:text-gray-300 mb-2">
                    <strong class="font-semibold">Metode Pembayaran:</strong>
                    <span class="font-medium capitalize">{{ str_replace('_', ' ', $sale->payment_method) }}</span>
                </p>
                <p class="text-lg text-gray-700 dark:text-gray-300 mb-2">
                    <strong class="font-semibold">Status Pembayaran:</strong>
                    <span
                        class="font-bold uppercase {{ $sale->payment_status == 'dibayar' ? 'text-green-500' : ($sale->payment_status == 'belum dibayar' ? 'text-orange-500' : 'text-red-500') }}">
                        {{ ucfirst($sale->payment_status) }}
                    </span>
                </p>
                <p class="text-lg text-gray-700 dark:text-gray-300">
                    <strong class="font-semibold">Tanggal Transaksi:</strong>
                    <span class="font-medium">{{ $sale->transaction_date->format('d F Y, H:i') }}</span>
                </p>
            </div>
        </div>

        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 border-b-2 border-indigo-500 pb-2">Daftar
            Produk</h3>
        <div class="overflow-x-auto shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                            Produk</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                            Harga Satuan</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                            Jumlah</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                            Subtotal</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                    @foreach ($sale->details as $detail)
                        <tr>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-100">
                                {{ $detail->product_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">Rp
                                {{ number_format($detail->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">
                                {{ $detail->quantity }}</td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800 dark:text-gray-100">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    @if ($sale->details->isEmpty())
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                Tidak ada produk dalam penjualan ini.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="flex justify-between items-center mt-8 pt-6 border-t-2 border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.sales.index') }}"
                class="text-gray-600 dark:text-gray-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition duration-300 ease-in-out">
                Kembali ke Daftar Penjualan
            </a>
            <a href="{{ route('admin.sales.print-invoice', $sale) }}" target="_blank"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Cetak Invoice
            </a>
        </div>
    </div>
</x-admin-layout>
