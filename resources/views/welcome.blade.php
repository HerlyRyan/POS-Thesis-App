<x-customer-layout>
    <section class="relative bg-cover bg-center h-[500px] md:h-[600px] flex items-center"
        style="background-image: url('{{ asset('/storage/welcome/hero-wood-bg.jpg') ?? 'https://images.unsplash.com/photo-1517672651790-e23949b25bdc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80' }}');">
        <div class="absolute inset-0 bg-black opacity-60"></div>
        <div class="relative z-10 max-w-4xl mx-auto text-center px-4">
            <h1
                class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-4 drop-shadow-lg">
                Produk Kayu Berkualitas Premium untuk Setiap Proyek
            </h1>
            <p class="text-lg sm:text-xl md:text-2xl text-gray-200 mb-8 max-w-2xl mx-auto opacity-90">
                Temukan Kayu Galam, Bambu, dan Bahan Atap terbaik untuk konstruksi dan dekorasi Anda.
            </p>
            <a href="#products"
                class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-full text-lg shadow-lg transform hover:scale-105 transition duration-300 ease-in-out focus:outline-none focus:ring-3 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-black">
                Jelajahi Produk
            </a>
        </div>
    </section>

    <section class="py-12 sm:py-16 px-4 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-center mb-8 sm:mb-12 text-gray-900">Kategori Produk Kami
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                <a href="#galam"
                    class="group bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300 border border-gray-100">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('/storage/welcome/galam.png') }}"
                            class="w-full h-56 sm:h-72 object-cover group-hover:scale-105 transition-transform duration-500 ease-in-out"
                            alt="Kayu Galam">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <h3
                            class="absolute bottom-4 left-4 text-2xl font-bold text-white drop-shadow-md group-hover:text-indigo-300 transition-colors duration-300">
                            Kayu Galam</h3>
                    </div>
                    <div class="p-5">
                        <p class="text-gray-700 text-base leading-relaxed">Kayu galam berkualitas tinggi, ideal untuk
                            berbagai kebutuhan konstruksi dan fondasi.</p>
                    </div>
                </a>

                <a href="#roofing"
                    class="group bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300 border border-gray-100">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('/storage/welcome/atap.png') }}"
                            class="w-full h-56 sm:h-72 object-cover group-hover:scale-105 transition-transform duration-500 ease-in-out"
                            alt="Bahan Atap">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <h3
                            class="absolute bottom-4 left-4 text-2xl font-bold text-white drop-shadow-md group-hover:text-indigo-300 transition-colors duration-300">
                            Bahan Atap</h3>
                    </div>
                    <div class="p-5">
                        <p class="text-gray-700 text-base leading-relaxed">Pilihan bahan atap yang kokoh, tahan lama,
                            dan estetis untuk melindungi bangunan Anda.</p>
                    </div>
                </a>

                <a href="#bamboo"
                    class="group bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300 border border-gray-100 sm:col-span-2 lg:col-span-1 mx-auto sm:mx-0 max-w-sm sm:max-w-none w-full">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('/storage/welcome/bambu.png') }}"
                            class="w-full h-56 sm:h-72 object-cover group-hover:scale-105 transition-transform duration-500 ease-in-out"
                            alt="Bambu">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <h3
                            class="absolute bottom-4 left-4 text-2xl font-bold text-white drop-shadow-md group-hover:text-indigo-300 transition-colors duration-300">
                            Bambu</h3>
                    </div>
                    <div class="p-5">
                        <p class="text-gray-700 text-base leading-relaxed">Produk bambu serbaguna, ramah lingkungan,
                            dan kuat untuk berbagai aplikasi.</p>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <section id="products" class="py-12 sm:py-16 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-center mb-8 sm:mb-12 text-gray-900">Produk Unggulan
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">
                @forelse ($topProducts as $product)
                    <div
                        class="product-card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300 border border-gray-200">
                        <div class="relative">
                            <img src="{{ asset('/storage/products/' . $product->image) ?? 'https://images.unsplash.com/photo-1605457867610-e990b096bf76?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80' }}"
                                class="w-full h-56 object-cover" alt="{{ $product->name }}">
                            @if ($product->stock <= 5 && $product->stock > 0)
                                <span
                                    class="absolute top-3 right-3 bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full">Stok
                                    Terbatas!</span>
                            @elseif ($product->stock == 0)
                                <span
                                    class="absolute top-3 right-3 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full">Habis</span>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 truncate" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                {{ Str::limit($product->description, 70) }}
                            </p>
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-2xl font-extrabold text-indigo-700">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span class="text-sm text-gray-500">Stok:
                                    <span class="font-semibold">{{ $product->stock }}</span></span>
                            </div>
                            <div>
                                @auth
                                    <button
                                        onclick="openAddToCartModal(
                                        '{{ $product->id }}',
                                        '{{ $product->name }}',
                                        '{{ $product->price }}',
                                        '{{ $product->stock }}'
                                    )"
                                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg flex items-center justify-center space-x-2 transform hover:scale-105 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                                        {{ $product->stock == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ $product->stock == 0 ? 'disabled' : '' }}>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.5 13 5.373 13h12.547a2 2 0 002-2V7.414a1 1 0 00-.293-.707l-3.586-3.586A1 1 0 0014.586 3H12V1a1 1 0 10-2 0v2H6a1 1 0 00-1 1v1H3zM16 16a1 1 0 11-2 0 1 1 0 012 0zm-6 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                        </svg>
                                        <span>{{ $product->stock == 0 ? 'Stok Habis' : 'Tambahkan ke Keranjang' }}</span>
                                    </button>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="w-full bg-gray-700 hover:bg-gray-800 text-white font-semibold py-3 rounded-lg flex items-center justify-center space-x-2 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span>Login untuk Membeli</span>
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg">Tidak ada produk yang tersedia saat ini. Silakan cek kembali
                            nanti!</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('products.index') }}"
                    class="inline-block bg-gray-800 text-white font-semibold py-3 px-8 rounded-full hover:bg-gray-900 transition duration-300 ease-in-out focus:outline-none focus:ring-3 focus:ring-offset-2 focus:ring-gray-500">
                    Lihat Semua Produk
                </a>
            </div>
        </div>
    </section>

    <section class="py-12 sm:py-16 px-4 bg-gray-100">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-center mb-8 sm:mb-12 text-gray-900">Mengapa Memilih
                Kami?
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 sm:gap-8">
                <div
                    class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-indigo-600 text-center transform hover:scale-105 transition duration-300 ease-in-out">
                    <div class="inline-flex items-center justify-center p-4 bg-indigo-100 rounded-full mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3">Kualitas Premium</h3>
                    <p class="text-gray-700 leading-relaxed">Semua produk kayu kami dipilih dengan cermat untuk
                        memastikan kualitas dan daya tahan terbaik.</p>
                </div>

                <div
                    class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-indigo-600 text-center transform hover:scale-105 transition duration-300 ease-in-out">
                    <div class="inline-flex items-center justify-center p-4 bg-indigo-100 rounded-full mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3">Pengiriman Cepat & Aman</h3>
                    <p class="text-gray-700 leading-relaxed">Kami memastikan produk Anda tiba di lokasi dengan cepat
                        dan dalam kondisi sempurna.</p>
                </div>

                <div
                    class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-indigo-600 text-center transform hover:scale-105 transition duration-300 ease-in-out sm:col-span-2 md:col-span-1 mx-auto sm:mx-0 max-w-sm sm:max-w-none w-full">
                    <div class="inline-flex items-center justify-center p-4 bg-indigo-100 rounded-full mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18.364 5.636l-3.536 3.536m0 0A9.953 9.953 0 0112 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10c0 1.21-.26 2.36-.75 3.424m-3.914-3.914L18.364 5.636m0 0L19.707 4.293a1 1 0 00-1.414-1.414l-1.343 1.343m-3.914 3.914L5.636 18.364m0 0L4.293 19.707a1 1 0 001.414 1.414l1.343-1.343" />
                        </svg>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3">Dukungan Pelanggan</h3>
                    <p class="text-gray-700 leading-relaxed">Tim kami siap membantu Anda dengan pertanyaan atau
                        kebutuhan produk.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 sm:py-24 px-4 bg-indigo-700 text-white">
        <div class="max-w-7xl mx-auto text-center">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-5 leading-tight">Mulai Proyek Impian Anda
                Hari Ini!</h2>
            <p class="text-lg sm:text-xl md:text-2xl mb-10 max-w-3xl mx-auto opacity-90">
                Jelajahi beragam pilihan kayu galam, bambu, dan bahan atap berkualitas premium kami.
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="/products"
                    class="bg-white text-indigo-700 font-bold py-3 px-10 rounded-full text-lg shadow-md hover:bg-gray-100 transform hover:scale-105 transition duration-300 ease-in-out focus:outline-none focus:ring-3 focus:ring-offset-2 focus:ring-white">
                    Belanja Sekarang
                </a>
                <a href="/contact"
                    class="bg-transparent border-2 border-white text-white font-bold py-3 px-10 rounded-full text-lg shadow-md hover:bg-white hover:text-indigo-700 transform hover:scale-105 transition duration-300 ease-in-out focus:outline-none focus:ring-3 focus:ring-offset-2 focus:ring-white">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>

</x-customer-layout>

<footer class="bg-gray-800 text-gray-300 py-12">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <div class="lg:col-span-2">
            <h3 class="text-xl font-bold text-white mb-4">Toko Kayu Galam</h3>
            <p class="text-gray-400 leading-relaxed">Kami menyediakan produk kayu galam, bambu, dan bahan atap
                berkualitas tinggi untuk memenuhi kebutuhan konstruksi dan dekorasi Anda dengan harga terbaik.</p>
        </div>
        <div>
            <h3 class="text-xl font-bold text-white mb-4">Navigasi Cepat</h3>
            <ul class="space-y-2">
                <li><a href="/" class="hover:text-white transition duration-200">Beranda</a></li>
                <li><a href="{{ route('products.index') }}" class="hover:text-white transition duration-200">Produk</a></li>
                <li><a href="/about" class="hover:text-white transition duration-200">Tentang Kami</a></li>
                <li><a href="/contact" class="hover:text-white transition duration-200">Kontak</a></li>
            </ul>
        </div>
        <div>
            <h3 class="text-xl font-bold text-white mb-4">Hubungi Kami</h3>
            <p class="text-gray-400 mb-2"><i class="fas fa-map-marker-alt mr-2 text-indigo-400"></i> Jl. Contoh No.
                123,
                Banjarmasin</p>
            <p class="text-gray-400 mb-2"><i class="fas fa-phone mr-2 text-indigo-400"></i> +62-812-3456-7890</p>
            <p class="text-gray-400"><i class="fas fa-envelope mr-2 text-indigo-400"></i> info@tokogalam.com</p>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 pt-8 mt-8 border-t border-gray-700 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} Toko Kayu Galam. Semua Hak Dilindungi.
    </div>
</footer>
