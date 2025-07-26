<x-customer-layout>
    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Product Details Card -->
            <div class="bg-white rounded-xl shadow-xl overflow-hidden md:flex">
                <!-- Product Image Section -->
                <div class="md:w-1/2 p-4 flex items-center justify-center bg-gray-50">
                    <img src="{{ $product->image ? asset('/storage/products/' . $product->image) : 'https://placehold.co/600x400/E0E7FF/3F51B5?text=Gambar+Produk' }}"
                        alt="{{ $product->name }}" class="w-full h-auto object-cover rounded-lg shadow-md">
                </div>

                <!-- Product Details Section -->
                <div class="md:w-1/2 p-8 flex flex-col justify-between">
                    <div>
                        <!-- Back Button -->
                        <a href="{{ url()->previous() }}"
                            class="text-indigo-600 hover:text-indigo-800 flex items-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali
                        </a>

                        <!-- Product Name -->
                        <h1 class="text-4xl font-extrabold text-gray-900 mb-4">
                            {{ $product->name }}
                        </h1>

                        <!-- Product Description -->
                        <p class="text-gray-700 text-lg leading-relaxed mb-6">
                            {!! nl2br(e($product->description)) !!}
                        </p>

                        <!-- Price, Stock, Rating, Sold Items -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                            <div class="bg-indigo-50 p-4 rounded-lg">
                                <span class="text-sm text-indigo-500">Harga</span>
                                <p class="text-3xl font-extrabold text-indigo-700">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-lg">
                                <span class="text-sm text-gray-500">Stok Tersedia</span>
                                <p class="text-xl font-semibold text-gray-800">
                                    {{ $product->stock }} {{ $product->unit }}
                                </p>
                            </div>
                            <div class="bg-yellow-50 p-4 rounded-lg flex items-center">
                                <svg class="h-6 w-6 text-yellow-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.783.57-1.838-.197-1.538-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.381-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z" />
                                </svg>
                                <span class="text-lg text-gray-700">{{ $product->average_rating ?? 'N/A' }}
                                    ({{ $product->reviews_count ?? 0 }} rating)</span>
                            </div>
                            <div class="bg-blue-50 p-4 rounded-lg flex items-center">
                                <svg class="h-6 w-6 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span class="text-lg text-gray-700">Terjual:
                                    @if ($product->sold_count > 100)
                                        100+
                                    @else
                                        {{ $product->sold_count }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Add to Cart Section -->
                    <div class="mt-auto">
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
                    </div>
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="mt-8 bg-white rounded-xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Ulasan Pembeli</h2>
                @forelse ($product->reviews as $review)
                    <div class="border-b border-gray-200 py-4">
                        <div class="flex items-center mb-2">
                            <div class="font-semibold text-gray-800">{{ $review->customer->user->name }}</div>
                            <div class="flex items-center ml-4">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="h-5 w-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.783.57-1.838-.197-1.538-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.381-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                        </div>
                        <p class="text-gray-600 mb-2">{{ $review->comment }}</p>
                        <p class="text-sm text-gray-400">{{ $review->created_at->format('d M Y') }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada ulasan untuk produk ini.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-customer-layout>
