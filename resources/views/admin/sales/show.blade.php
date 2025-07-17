<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold">Detail Penjualan</h1>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Informasi Penjualan</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <p class="text-gray-600 dark:text-gray-100">Invoice Number: <span class="font-semibold">{{ $sale->invoice_number }}</span></p>
                <p class="text-gray-600 dark:text-gray-100">Customer: <span class="font-semibold">{{ $sale->customer->user->name ?? '-' }}</span></p>
                <p class="text-gray-600 dark:text-gray-100">Sales Person: <span class="font-semibold">{{ $sale->user->name ?? '-' }}</span></p>
            </div>
            <div>
                <p class="text-gray-600 dark:text-gray-100">Total Harga: <span class="font-semibold">Rp {{ number_format($sale->total_price, 0, ',', '.') }}</span></p>
                <p class="text-gray-600 dark:text-gray-100">Metode Pembayaran: <span class="font-semibold">{{ ucfirst($sale->payment_method) }}</span></p>
                <p class="text-gray-600 dark:text-gray-100">Status Pembayaran: <span class="font-semibold">{{ ucfirst($sale->payment_status) }}</span></p>
                <p class="text-gray-600 dark:text-gray-100">Tanggal Transaksi: <span class="font-semibold">{{ $sale->transaction_date->format('d M Y') }}</span></p>
            </div>
        </div>

        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Daftar Produk</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Produk</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Harga</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Jumlah</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                    @foreach($sale->details as $detail)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-100">{{ $detail->product_name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-100">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-100">{{ $detail->quantity }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-100">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-between mt-6">
            <a href="{{ route('admin.sales.index') }}"
               class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                Kembali ke Daftar Penjualan
            </a>
        </div>
    </div>
</x-admin-layout>
