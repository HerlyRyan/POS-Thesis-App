<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white md:text-3xl">
            Detail Pemesanan
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-8">
                    {{-- Header Informasi Pemesanan --}}
                    <div
                        class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                Invoice #{{ $order->sale->invoice_number ?? $order->id }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Dipesan pada {{ $order->created_at->format('d F Y, H:i') }}
                            </p>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            <span
                                class="px-3 py-1 text-sm font-semibold rounded-full capitalize
                                {{ $order->status == 'draft' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : 
                                   ($order->status == 'persiapan' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : 
                                   ($order->status == 'pengiriman' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 
                                   'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300')) }}">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>

                    {{-- Detail Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                        {{-- Kolom Kiri: Info Pengiriman & Pelanggan --}}
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">Informasi Pengiriman
                            </h3>
                            <dl class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                                <div class="flex justify-between">
                                    <dt class="font-medium text-gray-800 dark:text-gray-200">Pelanggan</dt>
                                    <dd>{{ $order->sale->customer->user->name ?? '-' }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="font-medium text-gray-800 dark:text-gray-200">Tanggal Kirim</dt>
                                    <dd>{{ \Carbon\Carbon::parse($order->shipping_date)->format('d F Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-800 dark:text-gray-200">Alamat</dt>
                                    <dd class="mt-1">{{ $order->sale->customer->address ?? 'Alamat tidak tersedia' }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        {{-- Kolom Kanan: Info Logistik --}}
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">Informasi Logistik
                            </h3>
                            <dl
                                class="space-y-3 text-sm text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex justify-between">
                                    <dt>Supir</dt>
                                    <dd>{{ ucfirst(optional(optional($order->driver)->user)->name) ?? '-' }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt>Truk</dt>
                                    <dd>{{ $order->truck->plate_number ?? '-' }}</dd>
                                </div>
                                <div
                                    class="flex justify-between pt-3 border-t border-gray-200 dark:border-gray-700">
                                    <dt>Buruh</dt>
                                    <dd>{{ $order->workers->pluck('user.name')->map(function ($name) {return ucfirst($name);})->join(', ') ?: '-' }}
                                    </dd>
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
                                                <th scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-100 sm:pl-6">
                                                    Produk</th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                    Harga Satuan</th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                    Jumlah</th>
                                                <th scope="col"
                                                    class="relative py-3.5 pl-3 pr-4 sm:pr-6 text-right text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                    Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="divide-y divide-gray-200 dark:divide-gray-800 bg-white dark:bg-gray-900">
                                            @forelse($order->sale->details ?? [] as $detail)
                                                <tr>
                                                    <td
                                                        class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-gray-100 sm:pl-6">
                                                        {{ $detail->product_name }}</td>
                                                    <td
                                                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                        Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                                    <td
                                                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $detail->quantity }}</td>
                                                    <td
                                                        class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 text-gray-800 dark:text-gray-200">
                                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4"
                                                        class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                                        Tidak ada produk dalam pesanan ini.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                        @if (optional($order->sale)->details)
                                            <tfoot class="bg-gray-50 dark:bg-gray-800/50">
                                                <tr class="text-gray-700 dark:text-gray-300">
                                                    <th scope="row" colspan="3"
                                                        class="hidden pl-6 pr-3 pt-4 text-right text-sm font-normal sm:table-cell">
                                                        Subtotal</th>
                                                    <th scope="row"
                                                        class="pl-4 pr-3 pt-4 text-left text-sm font-normal sm:hidden">
                                                        Subtotal</th>
                                                    <td class="pl-3 pr-4 pt-4 text-right text-sm sm:pr-6">
                                                        Rp
                                                        {{ number_format($order->sale->total_price ?? 0, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                                <tr class="text-gray-700 dark:text-gray-300">
                                                    <th scope="row" colspan="3"
                                                        class="hidden pl-6 pr-3 pt-2 text-right text-sm font-normal sm:table-cell">
                                                        Promosi
                                                        @if ($order->sale->promotion)
                                                            <span
                                                                class="text-xs">({{ $order->sale->promotion->title }})</span>
                                                        @endif
                                                    </th>
                                                    <th scope="row"
                                                        class="pl-4 pr-3 pt-2 text-left text-sm font-normal sm:hidden">
                                                        Promosi
                                                        @if ($order->sale->promotion)
                                                            <br><span
                                                                class="text-xs">({{ $order->sale->promotion->title }})</span>
                                                        @endif
                                                    </th>
                                                    <td class="pl-3 pr-4 pt-2 text-right text-sm sm:pr-6">
                                                        @if ($order->sale->promotion)
                                                            - Rp
                                                            {{ number_format($order->sale->total_price - $order->sale->grand_price, 0, ',', '.') }}
                                                        @else
                                                            Rp 0
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr class="font-semibold text-gray-900 dark:text-white">
                                                    <th scope="row" colspan="3"
                                                        class="hidden pl-6 pr-3 pt-3 pb-4 text-right text-sm sm:table-cell">
                                                        Grand Total</th>
                                                    <th scope="row"
                                                        class="pl-4 pr-3 pt-3 pb-4 text-left text-sm sm:hidden">Grand
                                                        Total</th>
                                                    <td class="pl-3 pr-4 pt-3 pb-4 text-right text-sm sm:pr-6">
                                                        Rp
                                                        {{ number_format($order->sale->grand_price ?? 0, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div
                        class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('admin.orders.index') }}"
                            class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                            Kembali ke Daftar Pemesanan
                        </a>
                        <div class="flex space-x-3">
                            @if (Auth::user()->roles->first()?->name === 'admin')
                                @if ($order->status == 'draft')
                                    <a href="{{ route('admin.orders.assignWorkerView', $order) }}"
                                        class="inline-flex items-center gap-x-2 rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        Tetapkan Buruh
                                    </a>
                                @elseif ($order->status == 'persiapan')
                                    <a href="{{ route('admin.orders.assign_delivery_form', $order) }}"
                                        class="inline-flex items-center gap-x-2 rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        Tetapkan Supir
                                    </a>
                                @elseif ($order->status == 'pengiriman')
                                    <form method="POST" action="{{ route('admin.orders.complete', $order) }}"
                                        class="inline" id="confirm-order-form">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" x-data
                                            @click.prevent="$dispatch('open-modal', 'confirm-order-update')"
                                            class="inline-flex items-center gap-x-2 rounded-md bg-green-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                                            Selesaikan Pengiriman
                                        </button>
                                    </form>
                                    <x-confirm-create-update-button :name="'confirm-order-update'"
                                        modalForm="confirm-order-form" confirmMessage="Konfirmasi Pengiriman Selesai"
                                        question="Apakah Anda yakin ingin menyelesaikan pengiriman ini?"
                                        buttonText="Ya, Selesai" />
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
