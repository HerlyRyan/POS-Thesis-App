<x-customer-layout>
    <div x-data="cartHandler()" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <x-flash-modal />
        <h2 class="text-white text-xl mb-4">Keranjang Belanja</h2>

        @if (!$cart || $cart->cartItems->isEmpty())
            <p class="text-gray-400">Keranjang kosong.</p>
        @else
            <!-- Desktop View -->
            <div class="hidden md:block overflow-auto mb-6">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-4">
                                <input type="checkbox" @change="toggleAll($event)" />
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Produk</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Harga</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Qty</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Subtotal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y">
                        @foreach ($cart->cartItems as $item)
                            <tr>
                                <td class="px-4 py-2">
                                    <input type="checkbox" class="item-checkbox" value="{{ $item->id }}"
                                        data-subtotal="{{ $item->subtotal }}"
                                        :checked="selected.includes({{ $item->id }})"
                                        @change="toggle({{ $item->id }}, {{ $item->subtotal }})" />

                                </td>
                                <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ $item->product_name }}</td>
                                <td class="px-4 py-2 text-gray-600 dark:text-gray-400">Rp
                                    {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="px-4 py-2">
                                    <form method="POST" action="{{ route('customer.cart.update', $item->id) }}">
                                        @csrf @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}"
                                            min="1"
                                            class="w-16 border rounded px-2 py-1 dark:bg-gray-700 dark:text-white" />
                                        <button type="submit"
                                            class="ml-2 bg-indigo-600 text-white px-2 py-1 text-xs rounded">Update</button>
                                    </form>
                                </td>
                                <td class="px-4 py-2 text-gray-600 dark:text-gray-400">Rp
                                    {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                <td class="px-4 py-2">
                                    <form method="POST" action="{{ route('customer.cart.delete', $item->id) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin hapus item ini?')"
                                            class="text-red-600 dark:text-red-400">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <tr class="font-bold bg-gray-50 dark:bg-gray-800">
                            <td colspan="4" class="px-6 py-4 text-right text-gray-900 dark:text-gray-100">
                                Total Terpilih:
                            </td>
                            <td colspan="2" class="px-6 py-4 text-indigo-600 dark:text-indigo-400">
                                <span x-text="formatRupiah(total)"></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Mobile View -->
            <div class="block md:hidden space-y-4 mb-6">
                @foreach ($cart->cartItems as $item)
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                        <div class="flex justify-between items-center mb-2">
                            <label class="flex items-center">
                                <input type="checkbox" class="item-checkbox" value="{{ $item->id }}"
                                    data-subtotal="{{ $item->subtotal }}"
                                    :checked="selected.includes({{ $item->id }})"
                                    @change="toggle({{ $item->id }}, {{ $item->subtotal }})" />

                                <span
                                    class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $item->product_name }}</span>
                            </label>
                        </div>
                        <div class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                            <p><span class="font-medium">Harga:</span> Rp
                                {{ number_format($item->price, 0, ',', '.') }}</p>
                            <p><span class="font-medium">Jumlah:</span> {{ $item->quantity }}</p>
                            <p><span class="font-medium">Subtotal:</span> Rp
                                {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex justify-between items-center">
                            <form method="POST" action="{{ route('customer.cart.update', $item->id) }}"
                                class="flex items-center">
                                @csrf @method('PUT')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                    class="w-16 border rounded px-2 py-1 text-sm dark:bg-gray-700 dark:text-gray-300 mr-2" />
                                <button type="submit"
                                    class="bg-indigo-600 text-white px-2 py-1 text-xs rounded hover:bg-indigo-700">Update</button>
                            </form>
                            <form method="POST" action="{{ route('customer.cart.delete', $item->id) }}">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin hapus item ini?')"
                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md font-bold">
                    <div class="text-lg text-gray-900 dark:text-gray-100">Total Terpilih:</div>
                    <div class="text-indigo-600 dark:text-indigo-400" x-text="formatRupiah(total)"></div>
                </div>
            </div>

            <!-- Form Checkout -->
            <form method="POST" action="{{ route('customer.cart.checkout') }}"
                onsubmit="return confirm('Selesaikan transaksi ini?')">
                @csrf
                <input type="hidden" name="selected_items" :value="selected.join(',')">

                <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="col-span-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-700 dark:text-gray-200 mb-1">Catatan:</label>
                                <input type="text" name="note" placeholder="Catatan opsional"
                                    class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-300" />
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700 dark:text-gray-200 mb-1">Metode
                                    Pembayaran:</label>
                                <select name="payment_method"
                                    class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-300">
                                    <option value="" selected disabled>Pilih metode pembayaran</option>
                                    <option value="cod">COD (Cash on Delivery)</option>
                                    <option value="transfer">Transfer Bank</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-1 flex items-end">
                        <button type="submit"
                            class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">
                            Checkout Terpilih
                        </button>
                    </div>
                </div>
            </form>
        @endif
    </div>

    <script>
        function cartHandler() {
            return {
                selected: [],
                total: 0,
                toggle(id, subtotal) {
                    if (this.selected.includes(id)) {
                        this.selected = this.selected.filter(i => i !== id);
                        this.total -= subtotal;
                    } else {
                        this.selected.push(id);
                        this.total += subtotal;
                    }
                },
                toggleAll(e) {
                    this.selected = [];
                    this.total = 0;
                    const isChecked = e.target.checked;

                    document.querySelectorAll('.item-checkbox').forEach(cb => {
                        cb.checked = isChecked;

                        const id = parseInt(cb.value);
                        const subtotal = parseFloat(cb.dataset.subtotal || 0);

                        if (isChecked) {
                            if (!this.selected.includes(id)) {
                                this.selected.push(id);
                                this.total += subtotal;
                            }
                        }
                    });
                },
                formatRupiah(angka) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(angka);
                }
            }
        }
    </script>
</x-customer-layout>
