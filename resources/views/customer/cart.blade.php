<x-customer-layout>
    <div x-data="cartHandler({{ Js::from($promotions ?? []) }}, {{ Js::from($cartItems->map(fn($i) => ['id' => $i->id, 'subtotal' => (float) $i->subtotal])->values()) }})" class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-4 lg:p-8">

        <x-flash-modal />

        <!-- Header Section -->
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-shopping-cart text-indigo-600 mr-3"></i>
                    Keranjang Belanja
                </h1>
                <p class="text-gray-600 text-lg">Kelola produk pilihan Anda sebelum checkout</p>
            </div>

            @if ($cartItems->isEmpty())
                <!-- Empty Cart State -->
                <div class="bg-white rounded-2xl shadow-xl p-12 text-center max-w-md mx-auto">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shopping-cart text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Keranjang Kosong</h3>
                    <p class="text-gray-600 mb-8">Belum ada produk dalam keranjang Anda</p>
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Mulai Belanja
                    </a>
                </div>
            @else
                <!-- Cart Items Section -->
                <div class="mb-8">
                    <!-- Desktop Table View -->
                    <div class="hidden lg:block bg-white rounded-2xl shadow-xl overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6">
                            <div class="flex items-center justify-between">
                                <h2 class="text-xl font-semibold text-white">Daftar Produk</h2>
                                <label class="flex items-center space-x-3 text-white">
                                    <input type="checkbox" @change="toggleAll($event.target.checked)"
                                        class="w-5 h-5 rounded text-indigo-600 focus:ring-indigo-500 focus:ring-offset-2" />
                                    <span class="font-medium">Pilih Semua</span>
                                </label>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Pilih</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Produk</th>
                                        <th
                                            class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Harga</th>
                                        <th
                                            class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Qty</th>
                                        <th
                                            class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Subtotal</th>
                                        <th
                                            class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($cartItems as $item)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            <td class="px-6 py-6">
                                                <input type="checkbox"
                                                    class="item-checkbox w-5 h-5 rounded text-indigo-600 focus:ring-indigo-500"
                                                    value="{{ $item->id }}" x-model="selected" />
                                            </td>
                                            <td class="px-6 py-6">
                                                <div class="flex items-center space-x-4">
                                                    <div
                                                        class="w-16 h-16 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-xl flex items-center justify-center">
                                                        <i class="fas fa-box text-indigo-600 text-xl"></i>
                                                    </div>
                                                    <div>
                                                        <h3 class="text-lg font-semibold text-gray-900">
                                                            {{ $item->product_name }}</h3>
                                                        <p class="text-sm text-gray-500">SKU: #{{ $item->id }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-6 text-center">
                                                <span class="text-lg font-semibold text-gray-900">
                                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-6">
                                                <form method="POST"
                                                    action="{{ route('customer.cart.update', $item->id) }}"
                                                    class="flex items-center justify-center space-x-2">
                                                    @csrf @method('PUT')
                                                    <div
                                                        class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                                        <input type="number" name="quantity"
                                                            value="{{ $item->quantity }}" min="1" max="99"
                                                            class="w-20 px-3 py-2 text-center border-0 focus:ring-0 text-gray-900 bg-white" />
                                                    </div>
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition duration-200">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="px-6 py-6 text-center">
                                                <span class="text-xl font-bold text-indigo-600">
                                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-6 text-center">
                                                <form method="POST"
                                                    action="{{ route('customer.cart.delete', $item->id) }}">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')"
                                                        class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition duration-200">
                                                        <i class="fas fa-trash-alt text-lg"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="lg:hidden space-y-4">
                        @foreach ($cartItems as $item)
                            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                                <div class="flex items-start justify-between mb-4">
                                    <label class="flex items-center space-x-3">
                                        <input type="checkbox"
                                            class="item-checkbox w-5 h-5 rounded text-indigo-600 focus:ring-indigo-500"
                                            value="{{ $item->id }}" x-model="selected" />
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $item->product_name }}
                                            </h3>
                                            <p class="text-sm text-gray-500">SKU: #{{ $item->id }}</p>
                                        </div>
                                    </label>
                                    <form method="POST" action="{{ route('customer.cart.delete', $item->id) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus item ini?')"
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-full transition duration-200">
                                            <i class="fas fa-times text-xl"></i>
                                        </button>
                                    </form>
                                </div>

                                <div class="space-y-3">
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-gray-600">Harga Satuan</span>
                                        <span class="font-semibold text-gray-900">Rp
                                            {{ number_format($item->price, 0, ',', '.') }}</span>
                                    </div>

                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-gray-600">Jumlah</span>
                                        <form method="POST" action="{{ route('customer.cart.update', $item->id) }}"
                                            class="flex items-center space-x-2">
                                            @csrf @method('PUT')
                                            <div
                                                class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                                <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                    min="1"
                                                    class="w-16 px-3 py-1 text-center border-0 focus:ring-0" />
                                            </div>
                                            <button type="submit"
                                                class="px-3 py-1 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700">
                                                Update
                                            </button>
                                        </form>
                                    </div>

                                    <div class="flex justify-between items-center py-3 border-t border-gray-200">
                                        <span class="text-lg font-semibold text-gray-900">Subtotal</span>
                                        <span class="text-xl font-bold text-indigo-600">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Checkout and Summary Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Checkout Form (Left) -->
                    <div>
                        <form method="POST" action="{{ route('customer.cart.checkout') }}" id="confirm-checkout"
                            class="bg-white rounded-2xl shadow-xl p-6">
                            @csrf
                            <input type="hidden" name="selected_items" :value="selected.join(',')">
                            <input type="hidden" name="promotion_id" :value="selectedPromotionId">
                            <input type="hidden" name="payment_method" :value="paymentMethod">

                            <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-credit-card text-indigo-600 mr-3"></i>
                                Detail Checkout
                            </h3>

                            <div class="space-y-6">
                                <!-- Payment Method -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Metode
                                        Pembayaran</label>
                                    <div class="space-y-3">
                                        <label
                                            class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition duration-200">
                                            <input type="radio" name="payment_method" value="cod"
                                                x-model="paymentMethod" @change="resetPromotion()"
                                                class="text-indigo-600 focus:ring-indigo-500" />
                                            <div class="ml-3">
                                                <div class="font-medium text-gray-900">Cash on Delivery</div>
                                                <div class="text-sm text-gray-500">Bayar saat barang diterima</div>
                                            </div>
                                        </label>
                                        <label
                                            class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition duration-200">
                                            <input type="radio" name="payment_method" value="transfer"
                                                x-model="paymentMethod" @change="resetPromotion()"
                                                class="text-indigo-600 focus:ring-indigo-500" />
                                            <div class="ml-3">
                                                <div class="font-medium text-gray-900">Transfer Bank</div>
                                                <div class="text-sm text-gray-500">Transfer ke rekening toko</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Promotion -->
                                <div>
                                    <label for="promotion_id"
                                        class="block text-sm font-semibold text-gray-700 mb-3">Pilih Diskon</label>
                                    <select id="promotion_id" name="promotion_id" x-model="selectedPromotionId"
                                        :disabled="!paymentMethod"
                                        class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-3 text-gray-900 bg-white disabled:bg-gray-100 disabled:cursor-not-allowed focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">
                                            <span
                                                x-text="paymentMethod ? 'Tanpa Diskon' : 'Pilih metode pembayaran dulu'"></span>
                                        </option>
                                        <template x-for="promo in filteredPromotions" :key="promo.id">
                                            <option :value="promo.id"
                                                x-text="`${promo.title} - ${promo.discount_percentage}%`"></option>
                                        </template>
                                    </select>
                                </div>

                                <!-- Note -->
                                <div>
                                    <label for="note"
                                        class="block text-sm font-semibold text-gray-700 mb-3">Catatan
                                        (Opsional)</label>
                                    <textarea id="note" name="note" rows="3" placeholder="Tambahkan catatan untuk pesanan Anda..."
                                        class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-3 text-gray-900 bg-white focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                                </div>

                                <!-- Checkout Button -->
                                <button type="button" :disabled="selected.length === 0" x-data @click="$dispatch('open-modal', 'confirm-checkout')"
                                    class="w-full flex items-center justify-center px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold text-lg rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:from-gray-400 disabled:to-gray-400">
                                    <i class="fas fa-shopping-bag mr-3"></i>
                                    Checkout (<span x-text="selected.length"></span> Item)
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Order Summary (Right) -->
                    <div>
                        <div class="bg-white rounded-2xl shadow-xl p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-calculator text-indigo-600 mr-3"></i>
                                Ringkasan Pesanan
                            </h3>

                            <div class="space-y-4">
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-semibold text-gray-900"
                                        x-text="formatRupiah(totalSelectedSubtotal)"></span>
                                </div>

                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-600">Diskon</span>
                                    <span class="font-semibold text-red-600"
                                        x-text="`- ${formatRupiah(discountAmount)}`"></span>
                                </div>

                                <div class="border-t border-gray-200 pt-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xl font-bold text-gray-900">Total</span>
                                        <span class="text-2xl font-bold text-indigo-600"
                                            x-text="formatRupiah(totalAfterDiscount)"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <x-modal-checkout :name="'confirm-checkout'" modalForm="confirm-checkout" confirmMessage="Konfirmasi Buat Produk"
        question="Apakah kamu yakin ingin menyimpan produk ini?" buttonText="Ya, Buat" />


    {{-- Alpine.js Script (unchanged) --}}
    <script>
        function cartHandler(promotionsData = [], itemsData = []) {
            return {
                selected: [],
                promotions: promotionsData || [],
                itemsMap: {},
                paymentMethod: '',
                selectedPromotionId: '',

                init() {
                    itemsData.forEach(i => {
                        this.itemsMap[i.id] = parseFloat(i.subtotal) || 0;
                    });
                },

                get filteredPromotions() {
                    if (!this.paymentMethod) return [];
                    return this.promotions.filter(promo =>
                        promo.payment_method === 'all' || promo.payment_method === this.paymentMethod
                    );
                },

                get totalSelectedSubtotal() {
                    return this.selected.reduce((acc, id) => {
                        const s = this.itemsMap[id] ?? 0;
                        return acc + s;
                    }, 0);
                },

                get selectedPromotion() {
                    if (!this.selectedPromotionId) return null;
                    return this.promotions.find(p => String(p.id) === String(this.selectedPromotionId)) || null;
                },

                get discountAmount() {
                    const promo = this.selectedPromotion;
                    if (!promo) return 0;
                    const subtotal = this.totalSelectedSubtotal;
                    if (promo.discount_percentage != null) {
                        const pct = parseFloat(promo.discount_percentage) || 0;
                        return Math.round((pct / 100) * subtotal);
                    }
                    if (promo.discount_value != null) {
                        return Math.round(parseFloat(promo.discount_value) || 0);
                    }
                    return 0;
                },

                get totalAfterDiscount() {
                    const total = this.totalSelectedSubtotal - this.discountAmount;
                    return total > 0 ? total : 0;
                },

                toggleAll(isChecked) {
                    if (isChecked) {
                        this.selected = Object.keys(this.itemsMap).map(k => Number(k));
                    } else {
                        this.selected = [];
                    }
                },

                resetPromotion() {
                    this.selectedPromotionId = '';
                },

                formatRupiah(value) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(value || 0);
                }
            }
        }
    </script>
</x-customer-layout>
