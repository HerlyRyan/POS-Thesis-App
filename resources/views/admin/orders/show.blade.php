<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">Detail Pemesanan</h1>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-xl">
        {{-- Section: Informasi Pemesanan --}}
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 border-b-2 border-indigo-500 pb-2">Informasi
            Pemesanan</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6 mb-8">
            {{-- Kolom Kiri: Detail Pesanan & Penjualan --}}
            <div>
                <p class="text-lg text-gray-700 dark:text-gray-300 mb-2">
                    <strong class="font-semibold">Nomor Invoice:</strong>
                    <span
                        class="font-bold text-indigo-600 dark:text-indigo-400">{{ $order->sale->invoice_number ?? '-' }}</span>
                </p>
                <p class="text-lg text-gray-700 dark:text-gray-300 mb-2">
                    <strong class="font-semibold">Tanggal Pemesanan:</strong>
                    <span class="font-medium">{{ $order->created_at->format('d F Y, H:i') }}</span>
                </p>
                <p class="text-lg text-gray-700 dark:text-gray-300 mb-2">
                    <strong class="font-semibold">Tanggal Kirim:</strong>
                    <span
                        class="font-medium">{{ \Carbon\Carbon::parse($order->shipping_date)->format('d F Y, H:i') }}</span>
                </p>
                <p class="text-lg text-gray-700 dark:text-gray-300 mb-2">
                    <strong class="font-semibold">Status Pemesanan:</strong>
                    <span
                        class="font-bold uppercase px-2 py-1 rounded-full text-xs
                        {{ $order->status == 'draft' ? 'bg-red-600 text-white' : 
                           ($order->status == 'persiapan' ? 'bg-yellow-100 text-yellow-800' : 
                           ($order->status == 'pengiriman' ? 'bg-blue-100 text-blue-800' : 
                           'bg-green-100 text-green-800')) }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
                <p class="text-lg text-gray-700 dark:text-gray-300">
                    <strong class="font-semibold">Alamat Pengiriman:</strong>
                    <span
                        class="block mt-1 text-gray-600 dark:text-gray-400 leading-relaxed">{{ $order->sale->customer->address ?? 'Alamat tidak tersedia' }}</span>
                </p>
            </div>

            {{-- Kolom Kanan: Detail Pelanggan & Logistik --}}
            <div>
                <p class="text-lg text-gray-700 dark:text-gray-300 mb-2">
                    <strong class="font-semibold">Pelanggan:</strong>
                    <span class="font-medium">{{ $order->sale->customer->user->name ?? '-' }}</span>
                </p>
                <p class="text-lg text-gray-700 dark:text-gray-300 mb-2">
                    <strong class="font-semibold">Petugas Penjualan:</strong>
                    <span class="font-medium">{{ $order->sale->user->name ?? 'Website' }}</span>
                </p>
                <p class="text-lg text-gray-700 dark:text-gray-300 mb-2">
                    <strong class="font-semibold">Buruh:</strong>
                    <span
                        class="font-medium">{{ $order->workers->pluck('user.name')->map(function ($name) {return ucfirst($name);})->join(', ') ?? '-' }}</span>
                </p>
                <p class="text-lg text-gray-700 dark:text-gray-300 mb-2">
                    <strong class="font-semibold">Supir:</strong>
                    <span
                        class="font-medium">{{ ucfirst(optional(optional($order->driver)->user)->name) ?? '-' }}</span>
                </p>
                <p class="text-lg text-gray-700 dark:text-gray-300">
                    <strong class="font-semibold">Truk:</strong>
                    <span class="font-medium">{{ $order->truck->plate_number ?? '-' }}</span>
                </p>
            </div>
        </div>

        {{-- Section: Daftar Produk --}}
        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 border-b-2 border-indigo-500 pb-2">Daftar
            Produk</h3>
        <div class="overflow-x-auto shadow-md rounded-lg mb-8">
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
                    @forelse($order->sale->details ?? [] as $detail)
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
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                Tidak ada produk terkait dengan pesanan ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Section: Total Harga Penjualan --}}
        <div class="flex justify-end mb-8">
            <div class="text-right">
                <p class="text-xl font-bold text-gray-900 dark:text-gray-100">
                    Total Harga Penjualan: <span class="text-green-600 dark:text-green-400">Rp
                        {{ number_format($order->sale->total_price ?? 0, 0, ',', '.') }}</span>
                </p>
                <p class="text-md text-gray-700 dark:text-gray-300 mt-1">
                    Metode Pembayaran: <span
                        class="font-medium capitalize">{{ str_replace('_', ' ', $order->sale->payment_method ?? '-') }}</span>
                </p>
                <p class="text-md text-gray-700 dark:text-gray-300 mt-1">
                    Status Pembayaran: <span
                        class="font-bold uppercase {{
                        optional($order->sale)->payment_status == 'dibayar' ? 'text-green-500' :
                        (optional($order->sale)->payment_status == 'belum dibayar' ? 'text-orange-500' : 'text-red-500')
                        }}">
                        {{ ucfirst(optional($order->sale)->payment_status ?? '-') }}
                    </span>
                </p>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div
            class="flex flex-col sm:flex-row items-center justify-between mt-8 pt-6 border-t-2 border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.orders.index') }}"
                class="text-gray-600 dark:text-gray-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition duration-300 ease-in-out mb-4 sm:mb-0">
                Kembali ke Daftar Pemesanan
            </a>
            <div class="flex space-x-2">
                {{-- Tombol Aksi Dinamis berdasarkan Status --}}
                @if (Auth::user()->roles->first()?->name === 'admin')
                    @if ($order->status == 'draft')
                        <a href="{{ route('admin.orders.assignWorkerView', $order) }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Tetapkan Buruh
                        </a>
                    @elseif ($order->status == 'persiapan')
                        <a href="{{ route('admin.orders.assign_delivery_form', $order) }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Tetapkan Supir
                        </a>
                    @elseif ($order->status == 'pengiriman')
                        <form method="POST" action="{{ route('admin.orders.complete', $order) }}" class="inline"
                            id="confirm-order-form">
                            @csrf
                            @method('PUT')
                            <button type="submit" x-data
                                @click.prevent="$dispatch('open-modal', 'confirm-order-update')"
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Selesaikan Pengiriman
                            </button>
                        </form>
                        <x-confirm-create-update-button :name="'confirm-order-update'" modalForm="confirm-order-form"
                            confirmMessage="Konfirmasi Pengiriman Selesai"
                            question="Apakah Anda yakin ingin menyelesaikan pengiriman ini?" buttonText="Ya, Selesai" />
                    @endif
                @endif
                {{-- Tombol Edit selalu tersedia (jika ada route edit) --}}
                {{-- <a href="{{ route('admin.orders.edit', $order) }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-gray-800 dark:text-gray-100 text-xs uppercase tracking-widest shadow-sm hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Ubah Pemesanan
                </a> --}}
            </div>
        </div>
    </div>
</x-admin-layout>
