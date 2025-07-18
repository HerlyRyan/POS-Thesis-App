<div id="addToCartModal" x-data="{ open: false }" x-show="open" x-cloak
    @open-modal.window="open = true; document.body.classList.add('overflow-hidden')"
    @close-modal.window="open = false; setTimeout(() => document.body.classList.remove('overflow-hidden'), 300);"
    class="fixed inset-0 bg-black/75 flex items-center justify-center z-[9999] p-4">

    <div @click.away="closeAddToCartModal()" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-lg relative border border-gray-100 transform transition-all">

        <button type="button" onclick="closeAddToCartModal()"
            class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-full p-1">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <h2 class="text-3xl font-extrabold text-gray-900 mb-6 text-center">
            <i class="fas fa-cart-plus text-indigo-600 mr-3"></i> Tambah ke Keranjang
        </h2>

        <form action="{{ route('customer.cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" id="modalProductId">
            <input type="hidden" name="product_price" id="modalHiddenPrice">

            <div class="space-y-5 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                    <input id="modalProductName"
                        class="w-full px-4 py-2 bg-gray-50 text-gray-800 rounded-lg border border-gray-200 cursor-not-allowed font-semibold" readonly>
                    </input>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Satuan</label>
                    <input id="modalProductPrice"
                        class="w-full px-4 py-2 bg-gray-50 text-gray-800 rounded-lg border border-gray-200 cursor-not-allowed font-semibold" readonly>
                    </input>
                </div>

                <div>
                    <label for="modalQuantity"
                        class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                    <input type="number" id="modalQuantity" name="quantity" min="1" max=""
                        value="1" required oninput="updateModalTotal()"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm">
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <label class="block text-lg font-bold text-gray-700 mb-1">Total Harga</label>
                    <input id="modalTotal"
                        class="w-full px-4 py-3 bg-indigo-50 text-indigo-800 text-xl font-extrabold rounded-lg border border-indigo-200" readonly>
                    </input>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3 mt-6">
                <button type="button" onclick="closeAddToCartModal()"
                    class="w-full sm:w-auto px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 font-semibold transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Batal
                </button>
                <button type="submit" id="addToCartSubmitBtn"
                    class="w-full sm:w-auto px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center justify-center space-x-2">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah
                </button>
            </div>
        </form>
    </div>
</div>
