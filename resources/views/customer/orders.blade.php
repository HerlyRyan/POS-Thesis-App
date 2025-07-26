<x-customer-layout>
    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 min-h-screen">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-8 text-center">
            <i class="fas fa-box-open text-indigo-600 mr-3"></i> Pesanan Saya
        </h2>

        <div class="mb-8 border-b border-gray-200">
            <nav class="flex flex-wrap -mb-px text-base font-medium text-center" aria-label="Tabs">
                @php
                    $tabs = [
                        'belum dibayar' => 'Belum Dibayar',
                        'draft' => 'Draft',
                        'persiapan' => 'Persiapan',
                        'pengiriman' => 'Pengiriman',
                        'selesai' => 'Selesai',
                    ];
                    $current = request('status', 'belum dibayar');
                @endphp
                @foreach ($tabs as $key => $label)
                    <a href="{{ route('customer.orders.index', ['status' => $key]) }}"
                        class="inline-flex items-center justify-center px-4 py-3 rounded-t-lg border-b-2 transition-colors duration-200
                        {{ $current === $key ? 'border-indigo-600 text-indigo-600 font-semibold' : 'border-transparent text-gray-600 hover:text-indigo-600 hover:border-indigo-400' }}">
                        @if ($key === 'belum dibayar')
                            <i class="far fa-credit-card mr-2 text-lg"></i>
                        @elseif ($key === 'draft')
                            <i class="fas fa-pencil-alt mr-2 text-lg"></i>
                        @elseif ($key === 'persiapan')
                            <i class="fas fa-box mr-2 text-lg"></i>
                        @elseif ($key === 'pengiriman')
                            <i class="fas fa-truck mr-2 text-lg"></i>
                        @elseif ($key === 'selesai')
                            <i class="fas fa-check-circle mr-2 text-lg"></i>
                        @endif
                        {{ $label }}
                    </a>
                @endforeach
            </nav>
        </div>

        @if ($orders->isEmpty())
            <div class="py-12 text-center bg-gray-50 rounded-lg shadow-inner">
                <p class="text-gray-500 text-lg mb-4">
                    Tidak ada pesanan dengan status <strong class="text-gray-700">{{ $tabs[$current] }}</strong> saat
                    ini.
                </p>
                @if ($current === 'belum dibayar')
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                        <i class="fas fa-shopping-bag mr-2"></i> Mulai Belanja
                    </a>
                @endif
            </div>
        @else
            <div class="space-y-6 max-h-[700px] overflow-y-auto pr-3 custom-scrollbar">
                @foreach ($orders as $order)
                    <div
                        class="p-6 bg-white rounded-xl shadow-md border border-gray-100 flex flex-col md:flex-row md:items-start md:justify-between transition-all duration-200 ease-in-out hover:shadow-lg hover:border-indigo-200">
                        <div class="flex-grow mb-4 md:mb-0">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-receipt text-indigo-600 text-xl mr-3"></i>
                                <h3 class="text-xl font-bold text-gray-800">
                                    {{ $order->invoice_number }}
                                </h3>
                            </div>
                            <p class="text-sm text-gray-500 mb-1">
                                <i class="far fa-calendar-alt mr-2"></i> Tanggal:
                                {{ $order->transaction_date->format('d F Y, H:i') }} WITA
                            </p>
                            <p class="text-md text-gray-700 font-semibold mb-3">
                                Total: <strong class="text-indigo-700">Rp
                                    {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                            </p>

                            <div class="mt-4 pt-3 border-t border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-600 mb-2">Produk:</h4>
                                <ul class="space-y-3 text-sm text-gray-600">
                                    @foreach ($order->details as $detail)
                                        <li class="flex justify-between items-center">
                                            <div>
                                                <i class="fas fa-tag text-gray-400 mr-2"></i>
                                                <span>{{ $detail->product->name }} ({{ $detail->quantity }} pcs)</span>
                                            </div>
                                            @if ($current === 'selesai')
                                                @php
                                                    $product = $detail->product;
                                                    $reviewGiven = $product->reviews->contains(function ($review) use (
                                                        $order,
                                                    ) {
                                                        return $review->sales_id === $order->id;
                                                    });
                                                @endphp
                                                @if (!$reviewGiven)
                                                    <a href="{{ route('customer.product.comments', ['sales' => $order->id, 'product' => $detail->product->id]) }}"
                                                        class="inline-flex items-center px-3 py-1 bg-amber-500 text-white text-xs rounded-md hover:bg-amber-600 transition">
                                                        <i class="fas fa-star mr-1.5"></i> Beri Ulasan
                                                    </a>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 bg-gray-200 text-gray-600 text-xs rounded-md">
                                                        <i class="fas fa-check-circle mr-1.5"></i> Ulasan Diberikan
                                                    </span>
                                                @endif
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="mt-4">
                                <span
                                    class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full {{ $order->payment_status === 'belum dibayar'
                                        ? 'bg-red-100 text-red-800'
                                        : ($order->payment_status === 'dibayar'
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-gray-100 text-gray-700') }}
                                    ">
                                    @if ($order->payment_status === 'belum dibayar')
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                    @elseif($order->payment_status === 'dibayar')
                                        <i class="fas fa-check-circle mr-2"></i>
                                    @endif
                                    Pembayaran: {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                        </div>

                        <div
                            class="flex flex-col sm:flex-row md:flex-col lg:flex-row items-stretch md:items-end space-y-3 sm:space-y-0 sm:space-x-3 md:space-x-0 md:space-y-3 lg:space-x-3 lg:space-y-0 mt-4 md:mt-0">
                            <a href="{{ route('customer.orders.show', $order->id) }}"
                                class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                                <i class="fas fa-info-circle mr-2"></i> Detail Pesanan
                            </a>

                            @if ($order->status === 'pengiriman' && $order->payment_status === 'dibayar')
                                <form method="POST" action="{{ route('customer.orders.complete', $order->id) }}"
                                    onsubmit="return confirm('Konfirmasi bahwa produk telah diterima dan pesanan selesai?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                                        <i class="fas fa-box-open mr-2"></i> Konfirmasi Diterima
                                    </button>
                                </form>
                            @endif

                            @if ($order->payment_method === 'transfer' && $order->payment_status === 'belum dibayar' && $order->snap_url)
                                <a href="{{ $order->snap_url }}" target="_blank"
                                    class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                    <i class="fas fa-money-check-alt mr-2"></i> Bayar Sekarang
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Custom CSS for Scrollbar (if not already in your global CSS) --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
            /* For vertical scrollbar */
            height: 8px;
            /* For horizontal scrollbar */
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            /* Light grey track */
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            /* Medium grey thumb */
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
            /* Darker grey on hover */
        }
    </style>
</x-customer-layout>
