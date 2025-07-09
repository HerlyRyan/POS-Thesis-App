<x-customer-layout>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Detail Pesanan</h2>

        <div class="mb-6">
            <p class="text-gray-700 dark:text-gray-300"><span class="font-semibold">Invoice:</span>
                {{ $order->invoice_number }}</p>
            <p class="text-gray-700 dark:text-gray-300"><span class="font-semibold">Tanggal Transaksi:</span>
                {{ $order->transaction_date->format('d M Y, H:i') }}</p>
            <p class="text-gray-700 dark:text-gray-300"><span class="font-semibold">Metode Pembayaran:</span>
                {{ ucfirst($order->payment_method) }}</p>
            <p class="text-gray-700 dark:text-gray-300"><span class="font-semibold">Status Pembayaran:</span>
                <span
                    class="px-2 py-1 rounded text-sm 
                    {{ $order->payment_status === 'lunas' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                    {{ ucfirst($order->payment_status) }}
                </span>
            </p>
            @if ($order->orders)
                <p class="text-gray-700 dark:text-gray-300"><span class="font-semibold">Status Pengiriman:</span>
                    <span
                        class="px-2 py-1 rounded text-sm 
                    {{ $order->orders->status === 'persiapan'
                        ? 'bg-blue-200 text-blue-800'
                        : ($order->orders->status === 'pengiriman'
                            ? 'bg-orange-200 text-orange-800'
                            : ($order->orders->status === 'selesai'
                                ? 'bg-green-200 text-green-800'
                                : 'bg-gray-200 text-gray-800')) }}">
                        {{ ucfirst($order->orders->status ?? 'Belum dikirim') }}
                    </span>
                @else
                <p class="text-sm text-gray-500 italic">Belum diproses (menunggu pembayaran)</p>
            @endif
            @if ($order->orders->status === 'pengiriman' && $order->orders)
                <form method="POST" action="{{ route('customer.orders.complete', $order->orders->id) }}"
                    onsubmit="return confirm('Konfirmasi bahwa produk telah diterima?')">
                    @csrf
                    @method('PATCH')
                    <button class="mt-2 bg-green-600 text-white text-sm px-3 py-1 rounded hover:bg-green-700">
                        Selesai
                    </button>
                </form>
            @endif

            </p>
            @if ($order->note)
                <p class="text-gray-700 dark:text-gray-300"><span class="font-semibold">Catatan:</span>
                    {{ $order->note }}</p>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y dark:divide-gray-800">
                    @foreach ($order->details as $detail)
                        <tr>
                            <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ $detail->product_name }}</td>
                            <td class="px-4 py-2 text-gray-600 dark:text-gray-400">Rp
                                {{ number_format($detail->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 text-gray-600 dark:text-gray-400">{{ $detail->quantity }}</td>
                            <td class="px-4 py-2 text-gray-600 dark:text-gray-400">Rp
                                {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 dark:bg-gray-800 font-bold">
                    <tr>
                        <td colspan="3" class="px-4 py-2 text-right text-gray-900 dark:text-gray-100">Total:</td>
                        <td class="px-4 py-2 text-indigo-600 dark:text-indigo-400">Rp
                            {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mt-6">
            <a href="{{ url()->previous() }}" class="text-blue-600 hover:underline">Kembali ke daftar
                pesanan</a>
        </div>
    </div>
</x-customer-layout>
