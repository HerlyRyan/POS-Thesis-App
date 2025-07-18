<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? config('app.name', 'Toko Kayu Galam') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Base styles for the body and fonts */
        body {
            font-family: 'Figtree', sans-serif;
            @apply bg-gray-50 text-gray-800;
        }

        /* Custom scrollbar for a sleeker look */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

</head>

<body class="antialiased">
    <header
        class="sticky top-0 z-50 flex items-center justify-between px-6 py-4 bg-white shadow-lg border-b border-gray-100">
        <a href="/" class="flex items-center space-x-2">
            {{-- <img src="{{ asset('path/to/your/logo.png') }}" alt="Galam Sani Logo" class="h-8 w-auto"> --}}
            {{-- Replace 'path/to/your/logo.png' with your actual logo path --}}
            <span class="text-2xl font-extrabold text-indigo-700 tracking-tight">GALAM SANI</span>
        </a>
        <nav class="hidden md:flex items-center space-x-6">
            <a href="/"
                class="text-gray-700 hover:text-indigo-600 font-medium transition duration-200">Beranda</a>
            <a href="/products"
                class="text-gray-700 hover:text-indigo-600 font-medium transition duration-200">Produk</a>
            <a href="/about" class="text-gray-700 hover:text-indigo-600 font-medium transition duration-200">Tentang
                Kami</a>
            <a href="/contact"
                class="text-gray-700 hover:text-indigo-600 font-medium transition duration-200">Kontak</a>
        </nav>
        <div class="flex items-center space-x-4">
            @auth
                @php
                    $orderCount = \App\Models\Order::where('status', '!=', 'selesai')
                        ->whereHas('sale', function ($q) {
                            $q->where('customer_id', auth()->user()->customer->id);
                        })
                        ->count();
                @endphp
                <div class="relative" x-data="{ open: false }">
                    <button onclick="toggleUserMenu()" id="userMenuBtn"
                        class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-full px-3 py-1 transition-colors duration-200">
                        <span class="font-semibold text-lg">{{ explode(' ', Auth::user()->name)[0] }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div id="userMenu"
                        class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl py-2 z-50 border border-gray-100">
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-indigo-600 transition duration-150">
                            <i class="fas fa-user-circle mr-3 text-lg"></i> Profil Saya
                        </a>
                        <a href="{{ route('customer.cart.index') }}"
                            class="flex justify-between items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-indigo-600 transition duration-150">
                            <span><i class="fas fa-shopping-cart mr-3 text-lg"></i> Keranjang</span>
                            @php
                                $cartItemsCount = Auth::user()->carts()->count();
                            @endphp
                            @if ($cartItemsCount > 0)
                                <span
                                    class="bg-red-500 text-white rounded-full px-2 py-0.5 text-xs font-semibold">{{ $cartItemsCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('customer.orders.index') }}"
                            class="flex justify-between items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-indigo-600 transition duration-150">
                            <span><i class="fas fa-box-open mr-3 text-lg"></i> Pesanan</span>
                            @if ($orderCount > 0)
                                <span
                                    class="bg-blue-500 text-white rounded-full px-2 py-0.5 text-xs font-semibold">{{ $orderCount }}</span>
                            @endif
                        </a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition duration-150">
                                <i class="fas fa-sign-out-alt mr-3 text-lg"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="flex space-x-2">
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 text-sm font-medium text-indigo-600 border border-indigo-600 bg-white rounded-md hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 shadow-sm">
                        Daftar
                    </a>
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 shadow">
                        Login
                    </a>
                </div>
            @endauth
        </div>
        <button class="md:hidden text-gray-700 hover:text-indigo-600 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </header>

    <main class="min-h-screen bg-gray-50">
        <div class="px-4 sm:px-6 lg:px-8 py-8">
            {{ $slot }}
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Script -->
    <script>
        function openAddToCartModal(productId, productName, productPrice, productStock) {
            document.getElementById('modalProductId').value = productId;
            document.getElementById('modalProductName').value = productName;
            document.getElementById('modalProductPrice').value = formatRupiah(productPrice);
            document.getElementById('modalHiddenPrice').value = productPrice;

            const qtyInput = document.getElementById('modalQuantity');
            qtyInput.setAttribute('max', productStock);
            qtyInput.value = 1;

            updateModalTotal(); // panggil saat buka modal
            window.dispatchEvent(new CustomEvent('open-modal'));
            document.body.classList.add('overflow-hidden');
        }

        function updateModalTotal() {
            const price = parseFloat(document.getElementById('modalHiddenPrice').value);
            const qty = parseInt(document.getElementById('modalQuantity').value);
            const total = isNaN(price * qty) ? 0 : price * qty;
            document.getElementById('modalTotal').value = formatRupiah(total);
        }

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(angka);
        }

        function closeAddToCartModal() {
            window.dispatchEvent(new CustomEvent('close-modal'));
            setTimeout(() => {
                document.body.classList.remove('overflow-hidden');
            }, 300);
        }

        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.classList.toggle('hidden');
        }
    </script>

    <x-add-to-cart-modal />
</body>

</html>
