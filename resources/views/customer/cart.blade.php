<x-customer-layout>
    <div x-data="cartHandler()" class="bg-white p-6 rounded-xl shadow-lg min-h-screen border border-gray-100">
        <x-flash-modal />
        <h2 class="text-3xl font-extrabold text-gray-900 mb-6 text-center">
            <i class="fas fa-shopping-cart text-indigo-600 mr-3"></i> Keranjang Belanja Anda
        </h2>

        @if ($cartItems->isEmpty())
            <div class="py-12 text-center">
                <p class="text-gray-500 text-lg mb-4">Keranjang belanja Anda masih kosong.</p>
                <a href="{{ route('welcome') }}"
                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                    Mulai Belanja Sekarang <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        @else
            <div class="hidden md:block overflow-x-auto mb-8">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-lg">
                                <input type="checkbox" @change="toggleAll($event)"
                                    class="rounded text-indigo-600 focus:ring-indigo-500" />
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Qty</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Subtotal</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-lg">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($cartItems as $item)
                            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox"
                                        class="item-checkbox rounded text-indigo-600 focus:ring-indigo-500"
                                        value="{{ $item->id }}" data-subtotal="{{ $item->subtotal }}"
                                        :checked="selected.includes({{ $item->id }})"
                                        @change="toggle({{ $item->id }}, {{ $item->subtotal }})" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $item->product_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ number_format($item->price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <form method="POST" action="{{ route('customer.cart.update', $item->id) }}"
                                        class="flex items-center space-x-2">
                                        @csrf @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}"
                                            min="1"
                                            class="w-20 border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm bg-white text-gray-900 focus:ring-indigo-500 focus:border-indigo-500" />
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                                            <i class="fas fa-sync-alt mr-1"></i> Update
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">
                                    {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form method="POST" action="{{ route('customer.cart.delete', $item->id) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')"
                                            class="text-red-600 hover:text-red-900 transition duration-200">
                                            <i class="fas fa-trash-alt mr-1"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <tr class="font-bold bg-gray-50">
                            <td colspan="4" class="px-6 py-4 text-right text-gray-900 text-lg">
                                Total Terpilih:
                            </td>
                            <td colspan="2" class="px-6 py-4 text-indigo-700 text-2xl">
                                <span x-text="formatRupiah(total)"></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="block md:hidden space-y-6 mb-8">
                @foreach ($cartItems as $item)
                    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                        <div class="flex items-center justify-between mb-3">
                            <label class="flex items-center space-x-3">
                                <input type="checkbox"
                                    class="item-checkbox rounded text-indigo-600 focus:ring-indigo-500"
                                    value="{{ $item->id }}" data-subtotal="{{ $item->subtotal }}"
                                    :checked="selected.includes({{ $item->id }})"
                                    @change="toggle({{ $item->id }}, {{ $item->subtotal }})" />
                                <span class="text-xl font-bold text-gray-900">{{ $item->product_name }}</span>
                            </label>
                            <form method="POST" action="{{ route('customer.cart.delete', $item->id) }}">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')"
                                    class="text-red-600 hover:text-red-900 p-1 rounded-full">
                                    <i class="fas fa-times-circle text-2xl"></i>
                                </button>
                            </form>
                        </div>

                        <div class="grid grid-cols-2 gap-2 text-sm text-gray-700 mb-4">
                            <div><span class="font-semibold">Harga Satuan:</span></div>
                            <div class="text-right">{{ number_format($item->price, 0, ',', '.') }}</div>

                            <div><span class="font-semibold">Jumlah:</span></div>
                            <div class="text-right">
                                <form method="POST" action="{{ route('customer.cart.update', $item->id) }}"
                                    class="flex items-center justify-end">
                                    @csrf @method('PUT')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                        class="w-24 border-gray-300 rounded-md shadow-sm px-3 py-1 text-sm bg-white text-gray-900 focus:ring-indigo-500 focus:border-indigo-500" />
                                    <button type="submit"
                                        class="ml-2 bg-indigo-600 text-white px-3 py-1 text-xs rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                                        Update
                                    </button>
                                </form>
                            </div>

                            <div class="col-span-2 border-t border-gray-200 pt-3 mt-3"></div>

                            <div class="font-bold text-lg text-gray-900">Subtotal:</div>
                            <div class="text-right font-bold text-lg text-indigo-600">
                                {{ number_format($item->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="bg-indigo-50 p-6 rounded-lg shadow-xl font-bold text-center">
                    <div class="text-xl text-indigo-800 mb-2">Total Terpilih:</div>
                    <div class="text-3xl text-indigo-700" x-text="formatRupiah(total)"></div>
                </div>
            </div>

            <form method="POST" action="{{ route('customer.cart.checkout') }}"
                onsubmit="return confirm('Apakah Anda yakin ingin menyelesaikan transaksi dengan item yang terpilih?')">
                @csrf
                <input type="hidden" name="selected_items" :value="selected.join(',')">

                <div class="mt-8 p-6 bg-gray-50 rounded-xl shadow-inner border border-gray-100">
                    <h3 class="text-xl font-semibold text-gray-900 mb-5">Detail Pesanan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="note" class="block text-sm font-medium text-gray-700 mb-1">Catatan
                                Tambahan (Opsional):</label>
                            <textarea id="note" name="note" placeholder="Contoh: Tolong dikirim setelah jam 5 sore..."
                                class="w-full h-24 border-gray-300 rounded-md shadow-sm px-3 py-2 text-gray-900 bg-white focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Metode
                                Pembayaran:</label>
                            <select id="payment_method" name="payment_method" required
                                class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 text-gray-900 bg-white focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="" selected disabled>Pilih metode pembayaran</option>
                                <option value="cod">COD (Cash on Delivery)</option>
                                <option value="transfer">Transfer Bank</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-6 text-right">
                        <button type="submit" :disabled="selected.length === 0"
                            class="inline-flex items-center px-8 py-3 border border-transparent text-lg font-bold rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-check-circle mr-2"></i> Checkout (<span x-text="selected.length"></span>
                            Item)
                        </button>
                    </div>
                </div>
            </form>
        @endif
    </div>

    {{-- Script untuk Alpine.js --}}
    <script>
        function cartHandler() {
            return {
                selected: [],
                total: 0,
                // Inisialisasi: Panggil ini untuk menghitung total awal dari item yang mungkin sudah tercentang
                init() {
                    this.$nextTick(() => {
                        this.updateInitialSelection();
                    });
                },
                updateInitialSelection() {
                    const checkboxes = document.querySelectorAll('.item-checkbox:checked');
                    checkboxes.forEach(cb => {
                        const id = parseInt(cb.value);
                        const subtotal = parseFloat(cb.dataset.subtotal || 0);
                        if (!this.selected.includes(id)) {
                            this.selected.push(id);
                            this.total += subtotal;
                        }
                    });
                },
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
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(angka);
                }
            }
        }
    </script>
</x-customer-layout>
