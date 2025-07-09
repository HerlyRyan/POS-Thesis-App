<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? config('app.name', 'Toko Kayu Galam') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hero-section {
            background-image: url('https://images.unsplash.com/photo-1558185348-c1e6660355c6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            height: 400px;
            position: relative;
        }

        @media (min-width: 768px) {
            .hero-section {
                height: 500px;
            }
        }

        .hero-overlay {
            background-color: rgba(0, 0, 0, 0.6);
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
            transition: all 0.3s ease;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>

</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-zinc-900">
    <!-- Header -->
    <header
        class="sticky top-0 z-50 flex items-center justify-between px-6 py-4 bg-white border-b-4 border-indigo-600 shadow-md dark:bg-gray-800">
        <a href="/" class="flex items-center space-x-2">
            <span class="text-xl font-bold text-indigo-600 dark:text-indigo-400">Galam Sani</span>
        </a>
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
                    <button @click="open = !open"
                        class="flex items-center space-x-2 text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 focus:outline-none">
                        <span>{{ explode(' ', Auth::user()->name)[0] }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg py-1 z-50">
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                            <i class="fas fa-user mr-2"></i> Profil
                        </a>
                        <a href="{{ route('customer.cart.index') }}"
                            class="flex justify-between px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                            <span><i class="fas fa-shopping-cart mr-2"></i> Keranjang</span>
                            @php
                                $cartItemsCount = Auth::user()->carts()->count();
                            @endphp
                            @if ($cartItemsCount > 0)
                                <span
                                    class="bg-red-500 text-white rounded-full px-2 py-0.5 text-xs">{{ $cartItemsCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('customer.orders.index') }}"
                            class="flex justify-between px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                            <span><i class="fas fa-box mr-2"></i> Pesanan</span>
                            @if ($orderCount > 0)
                                <span
                                    class="bg-blue-500 text-white rounded-full px-2 py-0.5 text-xs">{{ $orderCount }}</span>
                            @endif
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="flex space-x-2">
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 text-sm font-medium text-indigo-600 border border-indigo-600 bg-white rounded-md hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Register
                    </a>
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Login
                    </a>
                </div>
            @endauth
        </div>
    </header>

    <!-- Slot konten utama -->
    <main class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            {{ $slot }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-lg font-semibold mb-4">Tentang Kami</h3>
                <p class="text-gray-400">Toko Kayu Galam menyediakan produk kayu berkualitas untuk berbagai kebutuhan
                    konstruksi dan dekorasi.</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4">Kontak</h3>
                <p class="text-gray-400"><i class="fas fa-phone mr-2"></i> +62-xxx-xxxx-xxxx</p>
                <p class="text-gray-400"><i class="fas fa-envelope mr-2"></i> info@tokogalam.com</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4">Ikuti Kami</h3>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter fa-lg"></i></a>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 pt-6 mt-6 border-t border-gray-800 text-center text-sm text-gray-400">
            &copy; {{ date('Y') }} Toko Kayu Galam. Semua Hak Dilindungi.
        </div>
    </footer>

    <x-add-to-cart-modal />

    <script>
        function openAddToCartModal(id, name, price, stock) {
            document.getElementById('modal_product_id').value = id;
            document.getElementById('modal_product_name').value = name;
            document.getElementById('modal_product_price').value = price;
            document.getElementById('modal_product_stock').textContent = 'Stok: ' + stock;
            document.getElementById('modal_quantity').value = 1;

            updateModalTotal();

            document.getElementById('form_product_id').value = id;
            document.getElementById('form_buy_product_id').value = id;

            const modal = document.getElementById('addToCartModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeAddToCartModal() {
            document.getElementById('addToCartModal').classList.add('hidden');
        }

        function updateModalTotal() {
            const qty = parseInt(document.getElementById('modal_quantity').value);
            const price = parseFloat(document.getElementById('modal_product_price').value);
            const total = qty * price;

            document.getElementById('modal_total').value = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('form_quantity').value = qty;
            document.getElementById('form_buy_quantity').value = qty;
        }
    </script>
</body>

</html>
