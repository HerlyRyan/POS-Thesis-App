<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold">Tambah Data Penjualan</h1>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-md">
        <h1 class="text-2xl text-gray-900 dark:text-gray-100 font-bold">Tambah Data Penjualan</h1>
        <br>

        <form action="{{ route('admin.sales.store') }}" method="POST" id="sale-form" x-data="saleForm({{ Js::from($products) }}, {{ Js::from($promotions) }})">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Invoice -->
                <div class="mb-4">
                    <label for="invoice" class="block font-medium text-sm text-gray-700 dark:text-gray-200">Nomor
                        Invoice</label>
                    <input type="text" id="invoice" name="invoice" value="{{ $invoiceNumber }}"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        readonly>
                </div>

                <!-- Customer -->
                <div x-data="customerSearch({{ Js::from($customers->map(function ($customer) {return ['id' => $customer->id, 'name' => $customer->user->name, 'phone' => $customer->phone];})) }})" class="relative mb-4">
                    <label for="customer_search"
                        class="block font-medium text-sm text-gray-700 dark:text-gray-200">Pelanggan</label>

                    <!-- Hidden select for form submission -->
                    <select name="customer_id" x-model="selectedCustomerId" class="hidden">
                        <option value=""></option>
                        <template x-for="customer in customers" :key="customer.id">
                            <option :value="customer.id" x-text="customer.name"></option>
                        </template>
                    </select>

                    <!-- Searchable input -->
                    <div class="relative" @click.away="open = false">
                        <input type="text" id="customer_search" x-model="search" @focus="open = true"
                            @input="open = true" placeholder="Cari nama atau nomor telepon..."
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">

                        <!-- Dropdown -->
                        <div x-show="open" x-transition
                            class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto">
                            <ul>
                                <template x-for="customer in filteredCustomers" :key="customer.id">
                                    <li @click="selectCustomer(customer)"
                                        class="px-4 py-2 cursor-pointer hover:bg-gray-100">
                                        <span x-text="customer.name"></span>
                                        <span class="text-sm text-gray-500" x-text="`(${customer.phone})`"></span>
                                    </li>
                                </template>
                                <template x-if="filteredCustomers.length === 0 && search.length > 0">
                                    <li class="px-4 py-2 text-gray-500">Pelanggan tidak ditemukan.</li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Produk -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-2">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Detail Produk</h3>
                <div class="space-y-4">
                    <template x-for="(item, index) in products" :key="index">
                        <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="grid grid-cols-1 sm:grid-cols-[1fr_auto_auto] gap-4 items-start">
                                <!-- Dropdown Produk -->
                                <div class="w-full">
                                    <select :name="`products[${index}][product_id]`" x-model="item.product_id"
                                        @change="validateQuantity(index)"
                                        class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">-- Pilih Produk --</option>
                                        <template x-for="product in allProducts" :key="product.id">
                                            <option :value="product.id"
                                                x-text="`${product.name} - Rp ${formatRupiah(product.price)} (Stok: ${product.stock})`">
                                            </option>
                                        </template>
                                    </select>
                                </div>

                                <!-- Input Quantity -->
                                <input type="number" min="1" :max="getMaxStock(item.product_id)"
                                    :name="`products[${index}][quantity]`" x-model.number="item.quantity"
                                    @input="validateQuantity(index)" placeholder="Qty"
                                    class="w-full sm:w-24 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">

                                <!-- Tombol Hapus -->
                                <button type="button" @click="removeProduct(index)"
                                    class="p-2 text-gray-500 hover:text-red-600 hover:bg-gray-100 rounded-full transition-colors justify-self-end sm:justify-self-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 012 0v6a1 1 0 11-2 0V8z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Pesan Error -->
                            <template x-if="item.error">
                                <p class="text-sm text-red-600 dark:text-red-400 mt-2" x-text="item.error"></p>
                            </template>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Tambah Produk -->
            <button type="button" @click="addProduct()"
                class="inline-flex items-center gap-2 mt-4 px-3 py-2 text-sm font-medium text-indigo-600 hover:text-indigo-800 bg-indigo-100 rounded-md hover:bg-indigo-200 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Produk
            </button>

            <!-- Rincian Pembayaran -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Rincian Pembayaran</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Metode Pembayaran -->
                    <div>
                        <label for="payment_method" class="block font-medium text-sm text-gray-700 dark:text-gray-200">
                            Metode Pembayaran
                        </label>
                        <select name="payment_method" id="payment_method" x-model="payment_method"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">-- Pilih Metode Pembayaran --</option>
                            <option value="cash">Cash</option>
                            <option value="transfer">Transfer</option>
                        </select>
                    </div>

                    <!-- Diskon -->
                    <div>
                        <label for="promotion_id"
                            class="block font-medium text-sm text-gray-700 dark:text-gray-200">Diskon</label>
                        <select name="promotion_id" x-model="promotion_id"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">-- Pilih Diskon --</option>
                            <template x-for="promo in filteredPromotions" :key="promo.id">
                                <option :value="promo.id"
                                    x-text="`${promo.title} (${promo.discount_percentage}%)`">
                                </option>
                            </template>
                        </select>
                    </div>
                </div>

                <!-- Total Harga -->
                <div class="mt-6 bg-gray-50 p-4 rounded-lg space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Subtotal:</span>
                        <span x-text="formatRupiah(subtotal)" class="font-medium text-gray-900"></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Diskon:</span>
                        <span x-text="`- ${formatRupiah(discountAmount)}`" class="font-medium text-red-600"></span>
                    </div>
                    <div class="flex justify-between items-center border-t border-gray-200 pt-2 mt-2">
                        <span class="text-base font-bold text-gray-900">Total Bayar:</span>
                        <span x-text="formatRupiah(totalPrice)" class="text-xl font-bold text-green-600"></span>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-4 mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                <a href="{{ route('admin.sales.index') }}"
                    class="w-full sm:w-auto inline-flex justify-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                    Batal
                </a>
                <button type="button" x-data @click="$dispatch('open-modal', 'confirm-create')"
                    class="w-full sm:w-auto inline-flex justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Buat Penjualan
                </button>
            </div>
            <x-confirm-create-update-button :name="'confirm-create'" modalForm="sale-form"
                confirmMessage="Konfirmasi Buat Penjualan" question="Apakah kamu yakin ingin menyimpan penjualan ini?"
                buttonText="Ya, Buat" />
        </form>
    </div>

    <!-- Alpine.js Script -->
    <script>
        function customerSearch(customers) {
            return {
                open: false,
                search: '',
                selectedCustomerId: '',
                customers: customers,
                get filteredCustomers() {
                    if (this.search === '') {
                        return this.customers;
                    }
                    return this.customers.filter(customer =>
                        customer.name.toLowerCase().includes(this.search.toLowerCase()) ||
                        customer.phone.toLowerCase().includes(this.search.toLowerCase())
                    );
                },
                selectCustomer(customer) {
                    this.selectedCustomerId = customer.id;
                    this.search = customer.id ? `${customer.name} (${customer.phone})` : '';
                    this.open = false;
                }
            }
        }

        function saleForm(allProducts, allPromotions) {
            return {
                allProducts: allProducts,
                allPromotions: allPromotions,
                payment_method: '',
                promotion_id: '',
                products: [{
                    product_id: '',
                    quantity: 1,
                    error: ''
                }],

                get filteredPromotions() {
                    if (!this.payment_method) {
                        return this.allPromotions;
                    }
                    return this.allPromotions.filter(promo =>
                        promo.payment_method === 'all' || promo.payment_method === this.payment_method
                    );
                },

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
                        } else if (item.quantity < 1) {
                            item.error = `Kuantitas minimum adalah 1`;
                            item.quantity = 1;
                        } else {
                            item.error = '';
                        }
                    } else {
                        item.error = '';
                    }
                },

                // Hitung subtotal
                get subtotal() {
                    return this.products.reduce((total, item) => {
                        const product = this.allProducts.find(p => p.id == item.product_id);
                        const price = product ? product.price : 0;
                        const qty = item.quantity || 0;
                        return total + price * qty;
                    }, 0);
                },

                // Hitung diskon
                get discountAmount() {
                    if (this.promotion_id) {
                        const promo = this.allPromotions.find(p => p.id == this.promotion_id);
                        if (promo) {
                            return (promo.discount_percentage / 100) * this.subtotal;
                        }
                    }
                    return 0;
                },

                // Total akhir setelah diskon
                get totalPrice() {
                    return this.subtotal - this.discountAmount;
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
