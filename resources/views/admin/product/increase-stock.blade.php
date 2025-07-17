<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold">Tambah Stock</h1>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-white">Tambah Stock Produk</h1>
        <br>
        <form action="{{ route('admin.product.update-stock') }}" method="POST" enctype="multipart/form-data"
            id="edit-product-form">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-1 mb-4">
                <label for="productId" class="block font-medium text-gray-700 dark:text-gray-200">Pelanggan</label>
                <select name="productId" class="product-select w-full rounded border-gray-300">
                    <option value="">-- Pilih Produk --</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-4">
                <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Stok</label>
                <input type="text" pattern="\d*" inputmode="numeric" id="stock" name="stock"
                    value="{{ old('stock') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                @error('stock')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('admin.product.index') }}"
                    class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    Kembali ke Daftar Produk
                </a>
                <button type="button" x-data @click="$dispatch('open-modal', 'confirm-edit')"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Simpan Perubahan
                </button>
            </div>            
        </form>

        <x-confirm-create-update-button :name="'confirm-edit'" modalForm="edit-product-form"
            confirmMessage="Konfirmasi Tambah Stok Produk" question="Apakah kamu yakin ingin menambah stok produk ini?"
            buttonText="Ya, Simpan" />
    </div>
</x-admin-layout>
