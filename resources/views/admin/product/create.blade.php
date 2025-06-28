<x-admin-layout>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h1 class="text-2xl text-white font-bold">Create Product</h1>
        <br>
        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data" id="product-form">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">Deskripsi</label>
                <input type="text" id="description" name="description" value="{{ old('description') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                @error('description')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">Kategori</label>
                <select name="category"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach (['galam', 'bambu', 'atap'] as $cat)
                        <option value="{{ $cat }}"
                            {{ isset($product) && $product->category == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}
                        </option>
                    @endforeach
                </select><br>
            </div>

            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Harga</label>
                <input type="text" pattern="\d*" inputmode="numeric" id="price" name="price"
                    value="{{ old('price') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                @error('price')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Stock</label>
                <input type="text" pattern="\d*" inputmode="numeric" id="stock" name="stock"
                    value="{{ old('stock') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                @error('stock')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="unit" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Satuan</label>
                <input type="text" id="unit" name="unit" value="{{ old('unit') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                @error('unit')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Foto
                    Product</label>
                <input type="file" id="image" name="image"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 text-white"
                    required>
                @error('image')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('admin.product.index') }}"
                    class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    Kembali ke Produk List
                </a>
                <button type="button" x-data @click="$dispatch('open-modal', 'confirm-create')"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Buat Produk
                </button>
            </div>
        </form>

        <x-confirm-create-update-button :name="'confirm-create'" modalForm="product-form"
            confirmMessage="Konfirmasi Buat Produk" question="Apakah kamu yakin ingin menyimpan produk ini?"
            buttonText="Ya, Buat" />
    </div>
</x-admin-layout>
