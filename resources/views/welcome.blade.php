<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Toko Kayu Galam</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Styles -->
    <style>
        /* Additional custom styles */
        .hero-section {
            background-image: url('https://images.unsplash.com/photo-1558185348-c1e6660355c6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            height: 400px;
            /* Reduced height for mobile */
            position: relative;
        }

        @media (min-width: 768px) {
            .hero-section {
                height: 500px;
                /* Original height for desktop */
            }
        }

        .hero-overlay {
            background-color: rgba(0, 0, 0, 0.5);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 1rem;
            text-align: center;
        }

        .product-card {
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .cart-icon {
            position: relative;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #FF2D20;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        /* Mobile menu toggle */
        .mobile-menu {
            display: none;
        }

        .mobile-menu.active {
            display: block;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    {{-- <img src="https://via.placeholder.com/50" alt="Logo" class="h-8 w-auto sm:h-10"> --}}
                    <h1 class="ml-2 sm:ml-3 text-lg sm:text-xl font-bold text-black dark:text-white">Toko Kayu Galam
                    </h1>
                </div>

                <!-- Mobile menu button -->
                <button id="mobile-menu-button" class="sm:hidden text-black dark:text-white">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Desktop menu -->
                <div class="hidden sm:flex items-center space-x-6">
                    <div class="relative">
                        <input type="text" placeholder="Cari produk..."
                            class="px-4 py-2 rounded-lg border dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    </div>

                    @if (Route::has('login'))
                        <div>
                            @auth
                                <div class="flex items-center space-x-4">
                                    <a href="{{ route('customer.cart') }}"
                                        class="text-black dark:text-white hover:text-gray-500 dark:hover:text-gray-300">
                                        <div class="cart-icon">
                                            <i class="fas fa-shopping-cart text-xl"></i>
                                            <span class="cart-badge">0</span>
                                        </div>
                                    </a>
                                    <a href="{{ route('customer.orders') }}"
                                        class="text-black dark:text-white hover:text-gray-500 dark:hover:text-gray-300">
                                        <div class="cart-icon">
                                            <i class="fas fa-box text-xl"></i>
                                        </div>
                                    </a>
                                    <div class="hidden sm:flex sm:items-center sm:ms-3">
                                        <x-dropdown align="right" width="48">
                                            <x-slot name="trigger">
                                                <button
                                                    class="inline-flex items-center px-3 py-2 text-black dark:text-white hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                                    <i class="fas fa-user mr-2"></i>
                                                    <div>{{ Auth::user()->name }}</div>

                                                    <div class="ms-1">
                                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </button>
                                            </x-slot>

                                            <x-slot name="content">
                                                <x-dropdown-link :href="route('profile.edit')"
                                                    class="text-black dark:text-white hover:bg-gray-100 dark:hover:bg-zinc-700">
                                                    <i class="fas fa-user-edit mr-2"></i>{{ __('Profile') }}
                                                </x-dropdown-link>

                                                <!-- Authentication -->
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf

                                                    <x-dropdown-link :href="route('logout')"
                                                        onclick="event.preventDefault();
                                                                        this.closest('form').submit();"
                                                        class="text-black dark:text-white hover:bg-gray-100 dark:hover:bg-zinc-700">
                                                        <i class="fas fa-sign-out-alt mr-2"></i>{{ __('Log Out') }}
                                                    </x-dropdown-link>
                                                </form>
                                            </x-slot>
                                        </x-dropdown>
                                    </div>

                                    @role('admin')
                                        <a href="{{ url('/admin') }}"
                                            class="rounded-md px-3 py-2 text-white bg-[#FF2D20] hover:bg-red-600">
                                            Dasbor
                                        </a>
                                    @endrole
                                </div>
                            @else
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('login') }}"
                                        class="rounded-md px-3 py-2 text-black bg-gray-100 hover:bg-gray-200 dark:text-white dark:bg-zinc-700 dark:hover:bg-zinc-600">
                                        Masuk
                                    </a>

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}"
                                            class="rounded-md px-3 py-2 text-white bg-[#FF2D20] hover:bg-red-600">
                                            Daftar
                                        </a>
                                    @endif
                                </div>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>

            <!-- Mobile menu (hidden by default) -->
            <div id="mobile-menu" class="mobile-menu mt-4 sm:hidden">
                <div class="flex flex-col space-y-4">
                    <div class="relative">
                        <input type="text" placeholder="Cari produk..."
                            class="w-full px-4 py-2 rounded-lg border dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    </div>


                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('customer.cart') }}"
                                class="flex items-center justify-center text-black dark:text-white hover:text-gray-500 dark:hover:text-gray-300 rounded-md px-3 py-2 bg-gray-100 dark:bg-zinc-700">
                                <div class="cart-icon">
                                    <i class="fas fa-shopping-cart text-xl"></i>
                                    <span class="cart-badge">0</span>
                                </div>
                                <span class="ml-2">Keranjang</span>
                            </a>

                            <a href="{{ route('customer.orders') }}"
                                class="flex items-center justify-center text-black dark:text-white hover:text-gray-500 dark:hover:text-gray-300 rounded-md px-3 py-2 bg-gray-100 dark:bg-zinc-700">
                                <i class="fas fa-box text-xl"></i>
                                <span class="ml-2">Pesanan</span>
                            </a>

                            <div class="hidden sm:flex sm:items-center sm:ms-3">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button
                                            class="inline-flex items-center px-3 py-2 text-black dark:text-white hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                            <i class="fas fa-user mr-2"></i>
                                            <div>{{ Auth::user()->name }}</div>

                                            <div class="ms-1">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('profile.edit')"
                                            class="text-black dark:text-white hover:bg-gray-100 dark:hover:bg-zinc-700">
                                            <i class="fas fa-user-edit mr-2"></i>{{ __('Profile') }}
                                        </x-dropdown-link>

                                        <!-- Authentication -->
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf

                                            <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault();
                                                                this.closest('form').submit();"
                                                class="text-black dark:text-white hover:bg-gray-100 dark:hover:bg-zinc-700">
                                                <i class="fas fa-sign-out-alt mr-2"></i>{{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>

                            @role('admin')
                                <a href="{{ url('/admin') }}"
                                    class="rounded-md px-3 py-2 text-white bg-[#FF2D20] hover:bg-red-600 text-center">
                                    Dasbor
                                </a>
                            @endrole
                        @else
                            <a href="{{ route('login') }}"
                                class="rounded-md px-3 py-2 text-black bg-gray-100 hover:bg-gray-200 dark:text-white dark:bg-zinc-700 dark:hover:bg-zinc-600 text-center">
                                Masuk
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="rounded-md px-3 py-2 text-white bg-[#FF2D20] hover:bg-red-600 text-center">
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-2 sm:mb-4">Produk Kayu Berkualitas
                Premium</h1>
            <p class="text-lg sm:text-xl text-white mb-4 sm:mb-8">Kayu Galam, Bambu, dan Bahan Atap</p>
            <a href="#products"
                class="bg-[#FF2D20] hover:bg-red-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg transition">
                Belanja Sekarang
            </a>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-8 sm:py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-2xl sm:text-3xl font-bold text-center mb-6 sm:mb-10 text-black dark:text-white">Kategori
                Kami</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-8">
                <a href="#galam"
                    class="bg-white dark:bg-zinc-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition">
                    <img src="{{ asset('/storage/welcome/galam.png') }}" class="w-full h-48 sm:h-64 object-cover"
                        alt="Kayu Galam">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg sm:text-xl font-bold text-black dark:text-white mb-2">Kayu Galam</h3>
                        <p class="text-gray-700 dark:text-gray-300">Kayu galam berkualitas tinggi untuk kebutuhan
                            konstruksi Anda</p>
                    </div>
                </a>

                <a href="#roofing"
                    class="bg-white dark:bg-zinc-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition">
                    <img src="{{ asset('/storage/welcome/atap.png') }}" class="w-full h-48 sm:h-64 object-cover"
                        alt="Bahan Atap">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg sm:text-xl font-bold text-black dark:text-white mb-2">Bahan Atap</h3>
                        <p class="text-gray-700 dark:text-gray-300">Bahan atap yang tahan lama dan tahan cuaca</p>
                    </div>
                </a>

                <a href="#bamboo"
                    class="bg-white dark:bg-zinc-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition sm:col-span-2 lg:col-span-1 mx-auto sm:mx-0 max-w-sm sm:max-w-none w-full">
                    <img src="{{ asset('/storage/welcome/bambu.png') }}" class="w-full h-48 sm:h-64 object-cover"
                        alt="Bambu">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg sm:text-xl font-bold text-black dark:text-white mb-2">Bambu</h3>
                        <p class="text-gray-700 dark:text-gray-300">Produk bambu yang berkelanjutan dan serba guna</p>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="products" class="py-8 sm:py-12 px-4 bg-gray-50 dark:bg-zinc-800">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-2xl sm:text-3xl font-bold text-center mb-6 sm:mb-10 text-black dark:text-white">Produk
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <!-- Product Cards with responsive sizing -->
                @forelse ($products as $product)
                    <div class="product-card bg-white dark:bg-zinc-700 rounded-lg overflow-hidden shadow">
                        <img src="{{ asset('/storage/products/' . $product->image) ?? 'https://images.unsplash.com/photo-1605457867610-e990b096bf76?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80' }}"
                            class="w-full h-48 object-cover rounded" alt="{{ $product->name }}">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-black dark:text-white mb-2">{{ $product->name }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-2">
                                {{ Str::limit($product->description, 60) }}</p>
                            <div class="flex justify-between items-center mt-4">
                                <span class="text-lg font-bold text-black dark:text-white">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Stok:
                                    {{ $product->stock }}</span>
                            </div>
                            <div class="mt-3">
                                @auth
                                    <button
                                        class="bg-[#FF2D20] hover:bg-red-600 text-white px-3 py-2 rounded-md transition w-full text-center"
                                        data-product-id="{{ $product->id }}">
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
                    class="inline-block bg-black dark:bg-white text-white dark:text-black font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg hover:bg-gray-800 dark:hover:bg-gray-200 transition">
                    Lihat Semua Produk
                </a>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-8 sm:py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-2xl sm:text-3xl font-bold text-center mb-6 sm:mb-10 text-black dark:text-white">Mengapa
                Memilih Kami</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 sm:gap-8">
                <div class="bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-lg text-center">
                    <div class="inline-block p-4 bg-[#FF2D20]/10 rounded-full mb-4">
                        <i class="fas fa-truck text-[#FF2D20] text-3xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-black dark:text-white mb-2">Pengiriman Cepat</h3>
                    <p class="text-gray-600 dark:text-gray-300">Kami memastikan pengiriman cepat dan terpercaya ke
                        lokasi Anda</p>
                </div>

                <div class="bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-lg text-center">
                    <div class="inline-block p-4 bg-[#FF2D20]/10 rounded-full mb-4">
                        <i class="fas fa-medal text-[#FF2D20] text-3xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-black dark:text-white mb-2">Kualitas Premium</h3>
                    <p class="text-gray-600 dark:text-gray-300">Semua produk kami memenuhi standar kualitas tertinggi
                    </p>
                </div>

                <div
                    class="bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-lg text-center sm:col-span-2 md:col-span-1 mx-auto sm:mx-0 max-w-sm sm:max-w-none w-full">
                    <div class="inline-block p-4 bg-[#FF2D20]/10 rounded-full mb-4">
                        <i class="fas fa-headset text-[#FF2D20] text-3xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-black dark:text-white mb-2">Layanan 24/7</h3>
                    <p class="text-gray-600 dark:text-gray-300">Tim layanan pelanggan kami selalu siap membantu Anda
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-10 sm:py-16 px-4 bg-[#FF2D20]">
        <div class="max-w-7xl mx-auto text-center">
            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-3 sm:mb-4">Siap Memulai Proyek Anda?</h2>
            <p class="text-white text-lg sm:text-xl mb-6 sm:mb-8">Jelajahi koleksi produk kayu premium dan bahan
                bangunan kami</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                <a href="/products"
                    class="bg-white text-[#FF2D20] font-bold py-2 sm:py-3 px-6 sm:px-8 rounded-lg hover:bg-gray-100 transition">
                    Belanja Sekarang
                </a>
                <a href="/contact"
                    class="bg-transparent border-2 border-white text-white font-bold py-2 sm:py-3 px-6 sm:px-8 rounded-lg hover:bg-white/10 transition">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">Toko Kayu Galam</h3>
                <p class="text-gray-300">Produk kayu berkualitas premium, bahan atap, dan bambu untuk semua kebutuhan
                    konstruksi Anda.</p>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">Tautan Cepat</h4>
                <ul class="space-y-2">
                    <li><a href="/" class="text-gray-300 hover:text-white transition">Beranda</a></li>
                    <li><a href="/products" class="text-gray-300 hover:text-white transition">Produk</a></li>
                    <li><a href="/about" class="text-gray-300 hover:text-white transition">Tentang Kami</a></li>
                    <li><a href="/contact" class="text-gray-300 hover:text-white transition">Kontak</a></li>
                </ul>
            </div>

            <div class="sm:col-span-2 md:col-span-1">
                <h4 class="text-lg font-semibold mb-4">Informasi Kontak</h4>
                <ul class="space-y-2">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-2 text-[#FF2D20]"></i>
                        <span>Jalan Utama 123, Banjarmasin, Indonesia</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-phone mt-1 mr-2 text-[#FF2D20]"></i>
                        <span>+62 123 4567 890</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-envelope mt-1 mr-2 text-[#FF2D20]"></i>
                        <span>info@tokokayugalam.com</span>
                    </li>
                </ul>
            </div>

            <div class="sm:col-span-2 md:col-span-1">
                <h4 class="text-lg font-semibold mb-4">Ikuti Kami</h4>
                <div class="flex space-x-4">
                    <a href="#" class="text-2xl hover:text-[#FF2D20] transition"><i
                            class="fab fa-facebook"></i></a>
                    <a href="#" class="text-2xl hover:text-[#FF2D20] transition"><i
                            class="fab fa-instagram"></i></a>
                    <a href="#" class="text-2xl hover:text-[#FF2D20] transition"><i
                            class="fab fa-twitter"></i></a>
                    <a href="#" class="text-2xl hover:text-[#FF2D20] transition"><i
                            class="fab fa-youtube"></i></a>
                </div>

                <div class="mt-6">
                    <h4 class="text-lg font-semibold mb-4">Buletin</h4>
                    <form class="flex">
                        <input type="email" placeholder="Email Anda"
                            class="px-4 py-2 rounded-l-md w-full text-black">
                        <button type="submit"
                            class="bg-[#FF2D20] px-4 py-2 rounded-r-md hover:bg-red-600 transition">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div
            class="max-w-7xl mx-auto px-4 pt-6 sm:pt-8 mt-6 sm:mt-8 border-t border-gray-800 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} Toko Kayu Galam. Hak cipta dilindungi.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
            mobileMenuButton.innerHTML = mobileMenu.classList.contains('active') ?
                '<i class="fas fa-times text-xl"></i>' :
                '<i class="fas fa-bars text-xl"></i>';
        });

        // Cart functionality
        const addToCartButtons = document.querySelectorAll('.product-card button');
        const cartBadge = document.querySelector('.cart-badge');
        let cartCount = 0;

        addToCartButtons.forEach(button => {
            button.addEventListener('click', () => {
                cartCount++;
                document.querySelectorAll('.cart-badge').forEach(badge => {
                    badge.textContent = cartCount;
                });

                // Animation effect
                button.innerHTML = '<i class="fas fa-check mr-1"></i> Ditambahkan';
                button.classList.remove('bg-[#FF2D20]', 'hover:bg-red-600');
                button.classList.add('bg-green-500', 'hover:bg-green-600');

                setTimeout(() => {
                    button.innerHTML = '<i class="fas fa-cart-plus mr-1"></i> Tambahkan';
                    button.classList.remove('bg-green-500', 'hover:bg-green-600');
                    button.classList.add('bg-[#FF2D20]', 'hover:bg-red-600');
                }, 1500);
            });
        });
    </script>
</body>

</html>
