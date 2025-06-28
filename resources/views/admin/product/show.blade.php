<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold">Product Details</h1>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Product Information</h2>
        <div class="mb-4 flex justify-around gap-6">
            <div class="col-1">
                <img src="{{ asset('/storage/products/' . $product->image) }}" class="rounded" style="width: 30rem">
            </div>
            <div class="col-2">
                <h3 class="mt-2 text-gray-600 dark:text-gray-100 font-medium text-xl">{{ $product->name }}</h3>
                <hr>
                <p class="mt-2 text-gray-600 dark:text-gray-100">Deskripsi: <span class="font-medium">{{ $product->description }}</span></p>
                <p class="mt-2 text-gray-600 dark:text-gray-100">Harga: <span class="font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</span></p>
                <p class="mt-2 text-gray-600 dark:text-gray-100">Stok: <span class="font-medium">{{ $product->stock }}</span></p>
                <p class="mt-2 text-gray-600 dark:text-gray-100">Kategori: <span class="font-medium capitalize">{{ $product->category ?? '-' }}</span></p>                
            </div>
        </div>

        <div class="flex items-center justify-between mt-4">
            <a href="{{ route('admin.product.index') }}"
                class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                Kembali ke Produk List
            </a>
            <a href="{{ route('admin.product.edit', $product) }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Ubah Produk
            </a>
        </div>
    </div>
</x-admin-layout>
