<div id="addToCartModal" class="fixed inset-0 bg-black/50 hidden justify-center items-center z-50">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl w-[90%] max-w-md shadow-lg relative">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Tambah ke Keranjang</h2>

        <input type="hidden" id="modal_product_id">
        <div class="mt-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Produk</label>
            <input id="modal_product_name" type="text" 
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed" readonly>
        </div>
        <div class="mt-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Harga</label>
            <input id="modal_product_price" type="text" 
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed" readonly>
        </div>
        <div class="mt-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Stok</label>
            <div id="modal_product_stock" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 px-3 py-2">Stok: -</div>
        </div>
        <div class="mt-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Jumlah</label>
            <input id="modal_quantity" type="number" min="1" value="1"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                oninput="updateModalTotal()">
        </div>
        <div class="mt-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Total</label>
            <input id="modal_total" type="text" 
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed" readonly>
        </div>

        <div class="mt-6 flex justify-end">
            <button onclick="closeAddToCartModal()" 
                class="mr-3 px-4 py-2 bg-gray-400 dark:bg-gray-600 text-gray-800 dark:text-white rounded-md hover:bg-gray-500 dark:hover:bg-gray-700">
                Batal
            </button>
            
            <form id="form_add_to_cart" method="POST" action="{{ route('customer.cart.add') }}" class="inline">
                @csrf
                <input type="hidden" name="product_id" id="form_product_id">
                <input type="hidden" name="quantity" id="form_quantity">
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    Tambah ke Keranjang
                </button>
            </form>

            <form id="form_buy_now" method="POST" action="{{ route('customer.cart.checkout') }}" class="inline ml-2">
                @csrf
                <input type="hidden" name="product_id" id="form_buy_product_id">
                <input type="hidden" name="quantity" id="form_buy_quantity">
                <input type="hidden" name="payment_method" value="cash">
                <input type="hidden" name="note" value="Beli cepat dari tombol">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Beli Sekarang
                </button>
            </form>
        </div>
    </div>
</div>
