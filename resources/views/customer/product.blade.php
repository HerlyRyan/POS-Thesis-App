<x-customer-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

        <div class="text-center mb-8 sm:mb-12">
            <h2 class="text-4xl sm:text-5xl font-extrabold text-gray-900 leading-tight">
                <i class="fas fa-cubes text-indigo-600 mr-3"></i> Jelajahi Produk Kami
            </h2>
            <p class="mt-3 text-lg text-gray-600">Temukan berbagai produk berkualitas yang kami tawarkan.</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 mb-8 sm:mb-10">
            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-filter text-indigo-600 mr-2"></i> Filter Produk
            </h3>
            <form action="{{ route('products.index') }}" method="GET"
                class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Produk</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Cari nama produk..."
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select id="category" name="category"
                        class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Semua Kategori</option>
                        @foreach (['galam' => 'Galam', 'bambu' => 'Bambu', 'atap' => 'Atap'] as $slug => $name)
                            <option value="{{ $slug }}"
                                {{ request('category') === $slug ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                        <i class="fas fa-search-plus mr-2"></i> Terapkan Filter
                    </button>
                    @if (request('search') || request('category'))
                        <a href="{{ route('products.index') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2 border border-gray-300 text-base font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                            <i class="fas fa-times-circle mr-2"></i> Reset Filter
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">
            @forelse ($products as $product)
                <div
                    class="product-card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300 border border-gray-200">
                    <div class="relative">
                        {{-- Image with fallback and aspect ratio control --}}
                        <img src="{{ asset('/storage/products/' . $product->image) }}"
                            onerror="this.onerror=null;this.src='https://via.placeholder.com/400x300.png?text=No+Image';"
                            class="w-full h-56 object-cover object-center" alt="{{ $product->name }}">

                        {{-- Stock Badges --}}
                        @if ($product->stock <= 5 && $product->stock > 0)
                            <span
                                class="absolute top-3 right-3 bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">Stok
                                Terbatas!</span>
                        @elseif ($product->stock == 0)
                            <span
                                class="absolute top-3 right-3 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow">Habis</span>
                        @endif
                    </div>
                    <div class="p-5 flex flex-col justify-between h-auto"> {{-- Adjusted height for better spacing --}}
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2 truncate" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-3 line-clamp-3"> {{-- Increased line-clamp for more description --}}
                                {{ Str::limit($product->description, 100) }}
                            </p>
                        </div>

                        <div class="flex justify-between items-center mt-auto mb-4"> {{-- mt-auto pushes to bottom --}}
                            <span class="text-2xl font-extrabold text-indigo-700">Rp
                                {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-sm text-gray-500">Stok:
                                <span class="font-semibold">{{ $product->stock }}</span>
                            </span>
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
                <div class="col-span-full text-center py-12 bg-gray-50 rounded-lg shadow-inner">
                    <p class="text-gray-500 text-lg">
                        <i class="fas fa-box-open text-xl mr-2"></i> Ups! Tidak ada produk yang sesuai dengan filter
                        Anda. Silakan coba filter lain.
                    </p>
                    <a href="{{ route('products.index') }}"
                        class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                        Reset Filter
                    </a>
                </div>
            @endforelse
        </div>

        <div class="mt-12 flex justify-center">
            {{ $products->links('vendor.pagination.tailwind') }}
        </div>
    </div>

</x-customer-layout>
