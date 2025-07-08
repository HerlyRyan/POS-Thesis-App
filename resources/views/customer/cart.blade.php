<x-customer-layout>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <x-flash-modal />
        <h2 class="text-white text-xl">Keranjang Belanja</h2>
        <br>
        @if (!$cart)
            <p class="text-gray-400 dark:text-gray-400">Keranjang kosong.</p>
        @else
            <!-- Desktop View -->
            <div class="hidden md:block">
                <div class="overflow-auto mb-6">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Produk</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Harga</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Qty</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Subtotal</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                            @foreach ($cart->cartItems as $item)
                                <tr>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $item->product_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        Rp
                                        {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <form method="POST" action="{{ route('customer.cart.update', $item->id) }}"
                                            class="flex items-center gap-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                min="1"
                                                class="w-16 border rounded px-2 py-1 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" />
                                            <button type="submit"
                                                class="bg-indigo-600 text-white px-2 py-1 text-xs rounded hover:bg-indigo-700 transition">Update</button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        Rp
                                        {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form method="POST" action="{{ route('customer.cart.delete', $item->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                onclick="return confirm('Yakin hapus item ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="font-bold bg-gray-50 dark:bg-gray-800">
                                <td colspan="3" class="px-6 py-4 text-right text-gray-900 dark:text-gray-100">
                                    Total:
                                </td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                                    Rp {{ number_format($cart->cartItems->sum('subtotal'), 0, ',', '.') }}
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile View -->
            <div class="block md:hidden space-y-4">
                @foreach ($cart->cartItems as $item)
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                        <div class="flex justify-between items-center mb-2">
                            <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                {{ $item->product_name }}</div>
                        </div>
                        <div class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                            <p><span class="font-medium">Harga:</span> Rp
                                {{ number_format($item->price, 0, ',', '.') }}
                            </p>
                            <p><span class="font-medium">Jumlah:</span> {{ $item->quantity }}</p>
                            <p><span class="font-medium">Subtotal:</span> Rp
                                {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex space-x-4 mt-3">
                            <form method="POST" action="{{ route('customer.cart.update', $item->id) }}"
                                class="flex items-center gap-2">
                                @csrf
                                @method('PUT')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                    class="w-16 border rounded px-2 py-1 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" />
                                <button type="submit"
                                    class="bg-indigo-600 text-white px-2 py-1 text-xs rounded hover:bg-indigo-700 transition">Update</button>
                            </form>
                            <form method="POST" action="{{ route('customer.cart.delete', $item->id) }}">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                    onclick="return confirm('Yakin hapus item ini?')">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Total: Rp {{ number_format($cart->cartItems->sum('subtotal'), 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <!-- Form Checkout -->
            <div class="mt-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                <form method="POST" action="{{ route('customer.cart.checkout') }}"
                    onsubmit="return confirm('Selesaikan transaksi ini?')">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Metode
                                Pembayaran:</label>
                            <select name="payment_method"
                                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                                <option value="cash">Tunai</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>

                        <div class="col-span-1">
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan:</label>
                            <input type="text" name="note" placeholder="Opsional"
                                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" />
                        </div>

                        <div class="col-span-1 flex items-end">
                            <button type="submit"
                                class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition w-full">
                                Checkout
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endif
    </div>
</x-customer-layout>
