<x-customer-layout>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Pesanan Saya</h2>

        <!-- Filter Tabs -->
        <div class="mb-6 border-b border-gray-200 dark:border-gray-600">
            <nav class="flex flex-wrap -mb-px space-x-4 text-sm font-medium text-center" aria-label="Tabs">
                @php
                    $tabs = [
                        'belum_dibayar' => 'Belum Dibayar',
                        'draft' => 'Dibayar',
                        'persiapan' => 'Persiapan',
                        'pengiriman' => 'Pengiriman',
                        'selesai' => 'Selesai',
                    ];
                    $current = request('status', 'belum_dibayar');
                @endphp
                @foreach ($tabs as $key => $label)
                    <a href="{{ route('customer.orders.index', ['status' => $key]) }}"
                        class="inline-block px-4 py-2 rounded-t-lg border-b-2 {{ $current === $key ? 'border-indigo-600 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-indigo-600 hover:border-indigo-400' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </nav>
        </div>

        <!-- List Pesanan -->
        @if ($orders->isEmpty())
            <p class="text-gray-500 dark:text-gray-400">Tidak ada pesanan dengan status
                <strong>{{ $tabs[$current] }}</strong>.
            </p>
        @else
            <div class="space-y-4 max-h-[600px] overflow-y-auto pr-2 scrollbar scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-100 dark:scrollbar-thumb-gray-600 dark:scrollbar-track-gray-800">
                @foreach ($orders as $order)
                    <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded shadow">
                        <div class="space-y-4 flex justify-between items-center mb-2">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                                    {{ $order->invoice_number }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    Tanggal: {{ $order->transaction_date->format('d M Y, H:i') }}
                                </p>
                            </div>
                            <span
                                class="px-2 py-1 text-xs rounded {{ $order->payment_status === 'belum dibayar' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-200' : 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-200' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-700 dark:text-gray-200 mb-2">
                            Total: <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                        </p>
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('customer.orders.show', $order->id) }}"
                                class="text-sm text-indigo-600 hover:underline dark:text-indigo-400">Lihat Detail</a>
                            @if ($current === 'pengiriman' && $order->orders)
                                <form method="POST"
                                    action="{{ route('customer.orders.complete', $order->orders->id) }}"
                                    onsubmit="return confirm('Konfirmasi bahwa produk telah diterima?')">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        class="mt-2 bg-green-600 text-white text-sm px-3 py-1 rounded hover:bg-green-700">
                                        Selesai
                                    </button>
                                </form>
                            @endif

                            @if ($order->payment_method === 'transfer' && $order->payment_status === 'belum dibayar' && $order->snap_url)
                                <a href="{{ $order->snap_url }}" target="_blank"
                                    class="text-sm bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">
                                    Bayar Sekarang
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-customer-layout>
