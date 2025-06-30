<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold">Tambah Penjualan</h1>
    </x-slot>

    <form action="{{ route('admin.sales.store') }}" method="POST" id="sale-form" x-data="saleForm({{ Js::from($products) }})">
        @csrf

        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md">
            <!-- Invoice -->
            <div class="mb-4">
                <label for="invoice" class="block font-medium text-gray-700 dark:text-gray-200">Invoice Number</label>
                <input type="text" id="invoice" name="invoice" value="{{ $invoiceNumber }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly>
            </div>

            <!-- Customer -->
            <div class="flex gap-4">
                <select name="customer_id" class="product-select w-full rounded border-gray-300">
                    <option value="">-- Pilih Customer --</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Produk -->
            <div class="space-y-4 mt-6">
                <template x-for="(item, index) in products" :key="index">
                    <div class="flex flex-col gap-2">
                        <div class="flex gap-4 items-start">
                            <!-- Dropdown Produk -->
                            <select :name="`products[${index}][product_id]`" x-model="item.product_id"
                                @change="validateQuantity(index)" class="w-full rounded border-gray-300">
                                <option value="">-- Pilih Produk --</option>
                                <template x-for="product in allProducts" :key="product.id">
                                    <option :value="product.id"
                                        x-text="`${product.name} - Rp ${formatRupiah(product.price)} (Stok: ${product.stock})`">
                                    </option>
                                </template>
                            </select>

                            <!-- Input Quantity -->
                            <input type="number" min="1" :max="getMaxStock(item.product_id)"
                                :name="`products[${index}][quantity]`" x-model.number="item.quantity"
                                @input="validateQuantity(index)" class="w-24 rounded border-gray-300">

                            <!-- Tombol Hapus -->
                            <button type="button" @click="removeProduct(index)"
                                class="text-red-500 font-bold">×</button>
                        </div>

                        <!-- Pesan Error -->
                        <template x-if="item.error">
                            <p class="text-sm text-red-600" x-text="item.error"></p>
                        </template>
                    </div>
                </template>

            </div>

            <!-- Tambah Produk -->
            <button type="button" @click="addProduct()" class="mt-4 text-sm text-indigo-600 hover:underline">
                + Tambah Produk
            </button>

            <!-- Metode Pembayaran -->
            <div class="mt-6">
                <label for="payment_method" class="block font-medium text-gray-700 dark:text-gray-200">Metode
                    Pembayaran</label>
                <select name="payment_method" id="payment_method" x-model="payment_method"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="cash">Cash</option>
                    <option value="transfer">Transfer</option>
                    <option value="ewallet">E-Wallet</option>
                </select>
            </div>

            <!-- Total Harga -->
            <div class="mt-6">
                <label class="block font-medium text-gray-700 dark:text-gray-200">Total Harga</label>
                <p class="mt-1 text-lg font-bold text-green-600 dark:text-green-400" x-text="formatRupiah(totalPrice)">
                </p>
            </div>

            <!-- Submit -->
            <div class="mt-6 flex justify-between">
                <a href="{{ route('admin.sales.index') }}"
                    class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">← Kembali</a>

                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Simpan Penjualan
                </button>
            </div>
        </div>
    </form>

    <!-- Alpine.js Script -->
    <script>
        function saleForm(allProducts) {
            return {
                allProducts: allProducts,
                products: [{
                    product_id: '',
                    quantity: 1,
                    error: ''
                }],

                addProduct() {
                    this.products.push({
                        product_id: '',
                        quantity: 1,
                        error: ''
                    });
                },

                removeProduct(index) {
                    this.products.splice(index, 1);
                },

                getMaxStock(productId) {
                    const product = this.allProducts.find(p => p.id == productId);
                    return product ? product.stock : Infinity;
                },

                validateQuantity(index) {
                    const item = this.products[index];
                    const product = this.allProducts.find(p => p.id == item.product_id);
                    if (product) {
                        const max = product.stock;
                        if (item.quantity > max) {
                            item.error = `Stok maksimum hanya ${max}`;
                            item.quantity = max;
                        } else {
                            item.error = '';
                        }
                    } else {
                        item.error = '';
                    }
                },

                get totalPrice() {
                    return this.products.reduce((total, item) => {
                        const product = this.allProducts.find(p => p.id == item.product_id);
                        const price = product ? product.price : 0;
                        const qty = item.quantity || 0;
                        return total + price * qty;
                    }, 0);
                },

                formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(number);
                }
            }
        }
    </script>
</x-admin-layout>
