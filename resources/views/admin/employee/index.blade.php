<x-admin-layout>
    <x-flash-modal />
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-white text-xl">Employees Data</h2>
        <br>
        <!-- Desktop View -->
        <div class="hidden md:block">
            <div class="mb-4 flex justify-between items-center">
                <!-- Search Form -->
                <form method="GET" action="{{ route('admin.employee.index') }}" id="searchForm"
                    class="flex md:flex-row md:items-center md:justify-between gap-2">
                    <div class="flex items-center w-full md:w-1/3">
                        <input type="text" id="searchInput" name="search" value="{{ request('search') }}"
                            placeholder="Search products..."
                            class="w-full px-6 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100">
                    </div>
                    <div class="w-full md:w-48">
                        <select name="category" id="categoryFilter"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100 transition">
                            <option value="">All Categories</option>
                            @foreach (['galam', 'bambu', 'atap'] as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                    {{ ucfirst($cat) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button" id="resetButton"
                        class="inline-flex items-center px-4 bg-gray-300 border border-transparent rounded-md text-xs font-semibold text-gray-800 uppercase tracking-widest hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Reset
                    </button>
                </form>
                <a href="{{ route('product.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Add New Product
                </a>
            </div>

            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            No</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Image</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Name</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Price</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Stocks</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                    @forelse($products as $index => $product)
                        <tr>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $loop->iteration + $products->firstItem() - 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                <img src="{{ asset('/storage/products/' . $product->image) }}" class="rounded"
                                    style="width: 150px">
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $product->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $product->stock }} unit</td>
                            <td
                                class="flex justify-between items-center px-6 py-12 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('product.show', $product) }}"
                                    class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">View</a>
                                <a href="{{ route('product.edit', $product) }}"
                                    class=" text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Edit</a>
                                <x-confirm-delete-button :route="route('product.destroy', $product)"
                                    modalId="confirm-delete-{{ $product->id }}" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) }}"
                                class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                No products found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>

        <!-- Mobile View -->
        <div class="block md:hidden space-y-4">
            <div class="mb-4 flex justify-between items-center">
                <!-- Search Form -->
                <form method="GET" action="{{ route('product.index') }}" id="searchForm"
                    class="flex md:flex-row md:items-center md:justify-between gap-2">
                    <div class="items-center w-full md:w-1/3">
                        <input type="text" id="searchInput" name="search" value="{{ request('search') }}"
                            placeholder="Search users..."
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100">
                    </div>
                    <button type="button" id="resetButton"
                        class="inline-flex items-center px-3 py-2 bg-gray-300 border border-transparent rounded-md text-xs font-semibold text-gray-800 uppercase tracking-widest hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Reset
                    </button>
                </form>
                <a href="{{ route('product.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Add New Product
                </a>
            </div>
            @forelse($products as $product)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                    <div class="flex justify-between items-center mb-4">
                        <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $product->name }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $product->price }}</div>
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('product.show', $product) }}"
                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">View</a>
                        <a href="{{ route('product.edit', $product) }}"
                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Edit</a>
                        <x-confirm-delete-button :route="route('product.destroy', $product)" modalId="confirm-delete-{{ $product->id }}" />


                    </div>
                </div>
            @empty
                <div
                    class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md text-center text-gray-500 dark:text-gray-400">
                    No products found.
                </div>
            @endforelse
            <div class="mt-4">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <script>
        let debounceTimer;
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        const categoryFilter = document.getElementById('categoryFilter');
        const resetButton = document.getElementById('resetButton');

        categoryFilter.addEventListener('change', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                searchForm.submit();
            }, 500);
        });

        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                searchForm.submit();
            }, 500); // delay 500ms setelah user berhenti mengetik
        });

        resetButton.addEventListener('click', function() {
            searchInput.value = '';
            categoryFilter.value = '';
            // Hapus query string di URL tanpa reload halaman
            history.pushState({}, '', window.location.pathname);
            searchForm.submit();
        });
    </script>
</x-admin-layout>
