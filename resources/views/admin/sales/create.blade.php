<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold">Tambah Penjualan</h1>
    </x-slot>

    <form action="{{ route('admin.sales.store') }}" method="POST" id="sale-form">
        @csrf

        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md">
            <div class="mb-4">
                <label for="invoice" class="block font-medium text-gray-700 dark:text-gray-200">Invoice Number</label>
                <input type="text" id="invoice" name="invoice" value="{{ $invoiceNumber }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" readonly>
            </div>

            <div class="flex gap-4">
                <select name="customer_id" class="product-select w-full rounded border-gray-300">
                    <option value="">-- Pilih Customer --</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div id="product-container" class="space-y-4 mt-6">
                <div class="product-row flex gap-4">
                    <select name="products[0][product_id]" class="product-select w-full rounded border-gray-300">
                        <option value="">-- Pilih Produk --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                {{ $product->name }} - Rp {{ number_format($product->price, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    <input type="number" name="products[0][quantity]" min="1" value="1"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                    <button type="button" class="remove-btn text-red-500 font-bold">×</button>
                </div>
            </div>

            <button type="button" id="add-product" class="mt-4 text-sm text-indigo-600 hover:underline">+ Tambah
                Produk</button>

            <div class="mt-6">
                <label for="payment_method" class="block font-medium text-gray-700 dark:text-gray-200">Metode
                    Pembayaran</label>
                <select name="payment_method" id="payment_method"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                    <option value="cash">Cash</option>
                    <option value="transfer">Transfer</option>
                    <option value="ewallet">E-Wallet</option>
                </select>
            </div>

            <div class="mt-6">
                <label class="block font-medium text-gray-700 dark:text-gray-200">Total Harga</label>
                <p id="total-price" class="mt-1 text-lg font-bold text-green-600 dark:text-green-400">Rp 0</p>
            </div>


            <div class="mt-6 flex justify-between">
                <a href="{{ route('admin.sales.index') }}"
                    class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">← Kembali</a>

                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Simpan
                    Penjualan</button>
            </div>
        </div>
    </form>

    {{-- Script Dinamis Produk --}}
    <script>
        let productIndex = 1;

        document.getElementById('add-product').addEventListener('click', function() {
            const container = document.getElementById('product-container');
            const row = document.createElement('div');
            row.className = 'product-row flex gap-4 mt-2';
            row.innerHTML = `
                <select name="products[${productIndex}][product_id]" class="product-select w-full rounded border-gray-300">
                    <option value="">-- Pilih Produk --</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }} - Rp {{ number_format($product->price, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                <input type="number" name="products[${productIndex}][quantity]" min="1" value="1"
                    class="quantity-input w-24 rounded border-gray-300">
                <button type="button" class="remove-btn text-red-500 font-bold">×</button>
            `;
            container.appendChild(row);
            productIndex++;
            calculateTotal;
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-btn')) {
                e.target.parentElement.remove();
            }
        });

        function formatRupiah(number) {
            return 'Rp ' + number.toLocaleString('id-ID');
        }

        function calculateTotal() {
            let total = 0;

            document.querySelectorAll('.product-row').forEach(function(row) {
                const select = row.querySelector('.product-select');
                const quantityInput = row.querySelector('.quantity-input');

                const price = parseInt(select.selectedOptions[0]?.getAttribute('data-price')) || 0;
                const quantity = parseInt(quantityInput.value) || 0;

                total += price * quantity;
            });

            document.getElementById('total-price').textContent = formatRupiah(Math.max(total, 0));
        }

        // Event listeners
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('product-select') || e.target.classList.contains('quantity-input')) {
                calculateTotal();
            }
        });    
    </script>
</x-admin-layout>
