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
                            <option value="{{ $slug }}" {{ request('category') === $slug ? 'selected' : '' }}>
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
                    class="product-card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300 border border-gray-200 flex flex-col">
                    <a href="{{ route('products.show', $product->id) }}" class="block">
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
                    </a>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 truncate" title="{{ $product->name }}">
                            <a href="{{ route('products.show', $product->id) }}" class="hover:text-indigo-600">
                                {{ $product->name }}
                            </a>
                        </h3>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2 h-10">
                            {{ Str::limit($product->description, 70) }}
                        </p>

                        <div class="flex items-center text-gray-500 text-sm mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400 mr-1"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.783.57-1.838-.197-1.538-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.381-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z" />
                            </svg>
                            <span>{{ $product->average_rating ?? 'N/A' }}
                                ({{ $product->reviews_count ?? 0 }} rating)
                            </span>
                            <span class="mx-2">|</span>
                            <span>Terjual:
                                @if ($product->sold_count > 100)
                                    100+
                                @else
                                    {{ $product->sold_count }}
                                @endif
                            </span>
                        </div>

                        <div class="flex justify-between items-center mb-4 mt-auto pt-2">
                            <span class="text-2xl font-extrabold text-indigo-700">Rp
                                {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-sm text-gray-500">Stok:
                                <span class="font-semibold">{{ $product->stock }}</span></span>
                        </div>
                        <div>
                            @auth
                                <div class="flex space-x-2">
                                    <a href="{{ route('products.show', $product->id) }}"
                                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2.5 px-4 rounded-lg flex items-center justify-center space-x-2 transform hover:scale-105 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Detail</span>
                                    </a>

                                    <button
                                        onclick="openAddToCartModal(
                                                '{{ $product->id }}',
                                                '{{ $product->name }}',
                                                '{{ $product->price }}',
                                                '{{ $product->stock }}'
                                            )"
                                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-4 rounded-lg flex items-center justify-center space-x-2 transform hover:scale-105 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-sm
                                            {{ $product->stock == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ $product->stock == 0 ? 'disabled' : '' }}>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.5 13 5.373 13h12.547a2 2 0 002-2V7.414a1 1 0 00-.293-.707l-3.586-3.586A1 1 0 0014.586 3H12V1a1 1 0 10-2 0v2H6a1 1 0 00-1 1v1H3zM16 16a1 1 0 11-2 0 1 1 0 012 0zm-6 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                        </svg>
                                        <span>{{ $product->stock == 0 ? 'Habis' : 'Keranjang' }}</span>
                                    </button>
                                </div>
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

        <div class="mt-4">
            {{ $products->appends(request()->query())->links() }}
        </div>
    </div>

    <x-add-to-cart-modal />

</x-customer-layout>
