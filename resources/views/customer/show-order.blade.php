<x-customer-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white p-8 rounded-lg shadow-xl border border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-extrabold text-gray-800">Detail Pesanan</h2>
                <a href="{{ url()->previous() }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    Kembali ke Daftar Pesanan
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Informasi Pesanan</h3>
                    <div class="space-y-2">
                        <p class="text-gray-700"><span class="font-medium text-gray-900">Invoice:</span>
                            <span class="ml-2 font-mono text-gray-800">{{ $order->invoice_number }}</span>
                        </p>
                        <p class="text-gray-700"><span class="font-medium text-gray-900">Tanggal Transaksi:</span>
                            <span
                                class="ml-2">{{ $order->transaction_date->locale('id')->translatedFormat('d F Y, H:i') }}</span>
                        </p>
                        <p class="text-gray-700"><span class="font-medium text-gray-900">Metode Pembayaran:</span>
                            <span class="ml-2 font-semibold">{{ ucfirst($order->payment_method) }}</span>
                        </p>
                        <p class="text-gray-700"><span class="font-medium text-gray-900">Status Pembayaran:</span>
                            <span
                                class="ml-2 px-3 py-1 rounded-full text-xs font-semibold {{ $order->payment_status === 'dibayar' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </p>
                        @if ($order->orders)
                            <p class="text-gray-700"><span class="font-medium text-gray-900">Status Pengiriman:</span>
                                <span
                                    class="ml-2 px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $order->orders->status === 'persiapan' ? 'bg-blue-100 text-blue-800' : 
                                       ($order->orders->status === 'pengiriman' ? 'bg-orange-100 text-orange-800' : 
                                        ($order->orders->status === 'selesai' ? 'bg-green-100 text-green-800' : 
                                         'bg-gray-100 text-gray-800')) }}">
                                    {{ ucfirst($order->orders->status ?? 'Belum dikirim') }}
                                </span>
                            </p>
                        @else
                            <p class="text-sm text-gray-500 italic mt-2">Pesanan belum diproses (menunggu pembayaran).
                            </p>
                        @endif

                        @if ($order->orders && $order->orders->status === 'pengiriman')
                            <form method="POST" action="{{ route('customer.orders.complete', $order->orders->id) }}"
                                onsubmit="return confirm('Konfirmasi bahwa produk telah diterima? Tindakan ini tidak dapat diurungkan.')"
                                class="mt-4">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="w-full md:w-auto bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                    Konfirmasi Pesanan Diterima
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                @if ($order->note)
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Catatan</h3>
                        <p class="text-gray-700 bg-gray-50 p-4 rounded-md border border-gray-200">
                            {{ $order->note }}
                        </p>
                    </div>
                @endif
            </div>

            ---

            <h3 class="text-xl font-semibold text-gray-800 mb-4 mt-8">Rincian Produk</h3>
            <div class="overflow-x-auto shadow-sm rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Produk</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Harga</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Kuantitas</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($order->details as $detail)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $detail->product_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp
                                    {{ number_format($detail->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $detail->quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp
                                    {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-100">
                        <tr>
                            <td colspan="3" class="px-6 py-3 text-right text-base font-bold text-gray-900 uppercase">
                                Total Pesanan:
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-base font-bold text-indigo-700">Rp
                                {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-customer-layout>
