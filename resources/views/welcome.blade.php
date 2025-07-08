<x-customer-layout>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-2 sm:mb-4">Produk Kayu Berkualitas
                Premium</h1>
            <p class="text-lg sm:text-xl text-white mb-4 sm:mb-8">Kayu Galam, Bambu, dan Bahan Atap</p>
            <a href="#products"
                class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-md transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Belanja Sekarang
            </a>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-8 sm:py-12 px-4 bg-gray-100 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-2xl sm:text-3xl font-bold text-center mb-6 sm:mb-10 text-gray-900 dark:text-white">Kategori
                Kami</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-8">
                <a href="#galam"
                    class="bg-white dark:bg-gray-700 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition border-t-4 border-indigo-600">
                    <img src="{{ asset('/storage/welcome/galam.png') }}" class="w-full h-48 sm:h-64 object-cover"
                        alt="Kayu Galam">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-2">Kayu Galam</h3>
                        <p class="text-gray-700 dark:text-gray-300">Kayu galam berkualitas tinggi untuk kebutuhan
                            konstruksi Anda</p>
                    </div>
                </a>

                <a href="#roofing"
                    class="bg-white dark:bg-gray-700 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition border-t-4 border-indigo-600">
                    <img src="{{ asset('/storage/welcome/atap.png') }}" class="w-full h-48 sm:h-64 object-cover"
                        alt="Bahan Atap">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-2">Bahan Atap</h3>
                        <p class="text-gray-700 dark:text-gray-300">Bahan atap yang tahan lama dan tahan cuaca</p>
                    </div>
                </a>

                <a href="#bamboo"
                    class="bg-white dark:bg-gray-700 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition border-t-4 border-indigo-600 sm:col-span-2 lg:col-span-1 mx-auto sm:mx-0 max-w-sm sm:max-w-none w-full">
                    <img src="{{ asset('/storage/welcome/bambu.png') }}" class="w-full h-48 sm:h-64 object-cover"
                        alt="Bambu">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-2">Bambu</h3>
                        <p class="text-gray-700 dark:text-gray-300">Produk bambu yang berkelanjutan dan serba guna</p>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="products" class="py-8 sm:py-12 px-4 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-2xl sm:text-3xl font-bold text-center mb-6 sm:mb-10 text-gray-900 dark:text-white">Produk
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <!-- Product Cards with responsive sizing -->
                @forelse ($products as $product)
                    <div class="product-card bg-white dark:bg-gray-700 rounded-lg overflow-hidden shadow border border-gray-200 dark:border-gray-600">
                        <img src="{{ asset('/storage/products/' . $product->image) ?? 'https://images.unsplash.com/photo-1605457867610-e990b096bf76?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80' }}"
                            class="w-full h-48 object-cover" alt="{{ $product->name }}">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $product->name }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-2">
                                {{ Str::limit($product->description, 60) }}</p>
                            <div class="flex justify-between items-center mt-4">
                                <span class="text-lg font-bold text-gray-900 dark:text-white">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Stok:
                                    {{ $product->stock }}</span>
                            </div>
                            <div class="mt-3">
                                @auth
                                    <button
                                        onclick="openAddToCartModal(
                                    {{ $product->id }},
                                    '{{ $product->name }}',
                                    {{ $product->price }},
                                    {{ $product->stock }}
                                )"
                                        class="bg-indigo-600 hover:bg-indigo-500 text-white px-3 py-2 rounded-md transition w-full text-center focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <i class="fas fa-cart-plus mr-1"></i> Tambahkan
                                    </button>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded-md transition w-full text-center block">
                                        <i class="fas fa-lock mr-1"></i> Login untuk membeli
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-500 dark:text-gray-400">Tidak ada produk yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                {{ $products->links() }}
            </div>

            <div class="text-center mt-6 sm:mt-10">
                <a href="/products"
                    class="inline-block bg-indigo-600 text-white font-medium py-2 px-4 sm:py-3 sm:px-6 rounded-md hover:bg-indigo-500 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Lihat Semua Produk
                </a>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-8 sm:py-12 px-4 bg-gray-100 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-2xl sm:text-3xl font-bold text-center mb-6 sm:mb-10 text-gray-900 dark:text-white">Mengapa
                Memilih Kami</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 sm:gap-8">
                <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md border-t-4 border-indigo-600 text-center">
                    <div class="inline-block p-4 bg-indigo-100 dark:bg-indigo-900 rounded-full mb-4">
                        <i class="fas fa-truck text-indigo-600 dark:text-indigo-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-2">Pengiriman Cepat</h3>
                    <p class="text-gray-600 dark:text-gray-300">Kami memastikan pengiriman cepat dan terpercaya ke
                        lokasi Anda</p>
                </div>

                <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md border-t-4 border-indigo-600 text-center">
                    <div class="inline-block p-4 bg-indigo-100 dark:bg-indigo-900 rounded-full mb-4">
                        <i class="fas fa-medal text-indigo-600 dark:text-indigo-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-2">Kualitas Premium</h3>
                    <p class="text-gray-600 dark:text-gray-300">Semua produk kami memenuhi standar kualitas tertinggi
                    </p>
                </div>

                <div
                    class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md border-t-4 border-indigo-600 text-center sm:col-span-2 md:col-span-1 mx-auto sm:mx-0 max-w-sm sm:max-w-none w-full">
                    <div class="inline-block p-4 bg-indigo-100 dark:bg-indigo-900 rounded-full mb-4">
                        <i class="fas fa-headset text-indigo-600 dark:text-indigo-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-2">Layanan 24/7</h3>
                    <p class="text-gray-600 dark:text-gray-300">Tim layanan pelanggan kami selalu siap membantu Anda
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-10 sm:py-16 px-4 bg-indigo-600">
        <div class="max-w-7xl mx-auto text-center">
            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-3 sm:mb-4">Siap Memulai Proyek Anda?</h2>
            <p class="text-white text-lg sm:text-xl mb-6 sm:mb-8">Jelajahi koleksi produk kayu premium dan bahan
                bangunan kami</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                <a href="/products"
                    class="bg-white text-indigo-600 font-bold py-2 sm:py-3 px-6 sm:px-8 rounded-md hover:bg-gray-100 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                    Belanja Sekarang
                </a>
                <a href="/contact"
                    class="bg-transparent border-2 border-white text-white font-bold py-2 sm:py-3 px-6 sm:px-8 rounded-md hover:bg-indigo-500 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>      

</x-customer-layout>
