<x-customer-layout>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full bg-white rounded-xl shadow-xl overflow-hidden p-8">
            <!-- Back Button -->
            <a href="#" onclick="history.back()"
                class="text-indigo-600 hover:text-indigo-800 flex items-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Detail Produk
            </a>

            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-6 text-center">
                Berikan Komentar & Rating
            </h1>

            <!-- Product Info (Optional, for context) -->
            <div class="bg-indigo-50 p-4 rounded-lg mb-8 flex items-center space-x-4">
                <img src="{{ $product->image ? asset('/storage/products/' . $product->image) : 'https://placehold.co/600x400/E0E7FF/3F51B5?text=Gambar+Produk' }}"
                    alt="Product Thumbnail" class="w-20 h-20 object-cover rounded-md">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">{{ $product->name }}</h2>
                    <p class="text-gray-600 text-sm">Berikan ulasan Anda untuk produk ini.</p>
                </div>
            </div>

            <!-- Comment & Rating Form -->
            <form id="commentForm" class="space-y-6"
                action="{{ route('customer.create.product.comment', ['sales' => $salesId, 'product' => $product->id]) }}"
                method="POST">
                @csrf
                <div>
                    <label for="userName" class="block text-sm font-medium text-gray-700 mb-1">Nama Anda:</label>
                    <input type="text" id="userName" name="userName"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Contoh: John Doe" value="{{ $user->name }}" required>
                    <p class="text-xs text-gray-500 mt-1">Nama ini akan ditampilkan bersama komentar Anda.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating Anda:</label>
                    <div class="flex items-center justify-center sm:justify-start">
                        <div id="rating-stars" class="flex flex-row-reverse items-center">
                            @for ($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" name="rating"
                                    value="{{ $i }}" class="hidden peer" {{ $i == 1 ? 'required' : '' }} />
                                <label for="star{{ $i }}"
                                    class="cursor-pointer text-gray-300 peer-hover:text-yellow-400 hover:text-yellow-400 peer-checked:text-yellow-500 transition-colors duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.783.57-1.838-.197-1.538-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.381-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z" />
                                    </svg>
                                </label>
                            @endfor
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1 text-center sm:text-left">Pilih 1 sampai 5 bintang.</p>
                </div>

                <div>
                    <label for="commentText" class="block text-sm font-medium text-gray-700 mb-1">Komentar Anda:</label>
                    <textarea id="commentText" name="comment" rows="5"
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Bagikan pengalaman Anda tentang produk ini..." required></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg flex items-center justify-center space-x-2 transform hover:scale-105 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Kirim Komentar & Rating</span>
                </button>
            </form>

            <hr class="my-10 border-gray-200">

            <!-- Existing Comments Section -->
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Ulasan Pelanggan</h2>

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
