<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">Detail Produk</h1>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-xl">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 border-b-2 border-indigo-500 pb-2">Informasi
            Produk</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch">
            {{-- Product Image --}}
            <div class="flex items-center justify-center md:justify-end">
                <img src="{{ asset('/storage/products/' . $product->image) }}" alt="Gambar Produk: {{ $product->name }}"
                    class="rounded-lg shadow-lg max-h-[400px] object-contain w-full">
            </div>

            {{-- Product Details --}}
            <div class="space-y-4">
                <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $product->name }}</h3>
                <hr class="border-gray-300 dark:border-gray-600">

                <p class="text-lg text-gray-700 dark:text-gray-300">
                    <strong class="font-semibold">Deskripsi:</strong>
                    <span
                        class="block mt-1 text-gray-600 dark:text-gray-400 leading-relaxed">{{ $product->description }}</span>
                </p>

                <p class="text-lg text-gray-700 dark:text-gray-300">
                    <strong class="font-semibold">Harga:</strong>
                    <span class="text-indigo-600 dark:text-indigo-400 font-bold text-xl">Rp
                        {{ number_format($product->price, 0, ',', '.') }}</span>
                </p>

                <p class="text-lg text-gray-700 dark:text-gray-300">
                    <strong class="font-semibold">Stok:</strong>
                    <span class="font-medium">{{ $product->stock }} unit</span>
                </p>

                <p class="text-lg text-gray-700 dark:text-gray-300">
                    <strong class="font-semibold">Kategori:</strong>
                    <span
                        class="font-medium capitalize text-indigo-600 dark:text-indigo-400">{{ $product->category ?? 'Tidak Ada Kategori' }}</span>
                </p>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div
            class="flex flex-col sm:flex-row items-center justify-between mt-8 pt-6 border-t-2 border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.product.index') }}"
                class="text-gray-600 dark:text-gray-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition duration-300 ease-in-out mb-4 sm:mb-0">
                Kembali ke Daftar Produk
            </a>
            <a href="{{ route('admin.product.edit', $product) }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Ubah Data Produk
            </a>
        </div>
    </div>
</x-admin-layout>
