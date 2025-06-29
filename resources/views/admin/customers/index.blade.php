<x-admin-layout>
    <x-flash-modal />
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-white text-xl">Customers Data</h2>
        <br>
        <!-- Desktop View -->
        <div class="hidden md:block">
            <div class="mb-4 flex justify-between items-center">
                <!-- Search Form -->
                <form method="GET" action="{{ route('admin.customers.index') }}" id="searchForm"
                    class="flex md:flex-row md:items-center md:justify-between gap-2">
                    <div class="flex items-center w-full md:w-1/3">
                        <input type="text" id="searchInput" name="search" value="{{ request('search') }}"
                            placeholder="Search customers..."
                            class="w-full px-6 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100">
                    </div>
                    <button type="button" id="resetButton"
                        class="inline-flex items-center px-4 bg-gray-300 border border-transparent rounded-md text-xs font-semibold text-gray-800 uppercase tracking-widest hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Reset
                    </button>
                </form>
                <a href="{{ route('admin.users.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Add New Customer
                </a>
            </div>

            <!-- Wrapper untuk menghindari overflow -->
            <div class="overflow-x-auto w-full">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                No</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Name</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Email</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Phone</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Address</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                        @forelse($customers as $index => $customer)
                            <tr>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $loop->iteration + $customers->firstItem() - 1 }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $customer->user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $customer->user->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $customer->phone }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $customer->address }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.customers.show', $customer) }}"
                                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Detail</a>
                                        <a href="{{ route('admin.customers.edit', $customer) }}"
                                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No customers found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $customers->appends(request()->query())->links() }}
            </div>
        </div>

        <!-- Mobile View -->
        <div class="block md:hidden space-y-4">
            <div class="mb-4 flex justify-between items-center">
                <!-- Search Form -->
                <form method="GET" action="{{ route('admin.customers.index') }}" id="searchForm"
                    class="flex md:flex-row md:items-center md:justify-between gap-2">
                    <div class="items-center w-full md:w-1/3">
                        <input type="text" id="searchInput" name="search" value="{{ request('search') }}"
                            placeholder="Search customers..."
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100">
                    </div>
                    <button type="button" id="resetButton"
                        class="inline-flex items-center px-3 py-2 bg-gray-300 border border-transparent rounded-md text-xs font-semibold text-gray-800 uppercase tracking-widest hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Reset
                    </button>
                </form>
                <a href="{{ route('admin.users.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Add New Customer
                </a>
            </div>
            @forelse($customers as $customer)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ $customer->user->name }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                        Email: {{ $customer->user->email }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                        Phone: {{ $customer->phone }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                        Address: {{ $customer->address }}
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('admin.customers.show', $customer) }}"
                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Detail</a>
                        <a href="{{ route('admin.customers.edit', $customer) }}"
                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Edit</a>
                    </div>
                </div>
            @empty
                <div
                    class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md text-center text-gray-500 dark:text-gray-400">
                    No customers found.
                </div>
            @endforelse
            <div class="mt-4">
                {{ $customers->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <script>
        let debounceTimer;
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        const resetButton = document.getElementById('resetButton');

        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                searchForm.submit();
            }, 500); // delay 500ms after the user stops typing
        });

        resetButton.addEventListener('click', function() {
            searchInput.value = '';
            // Redirect to the base URL without query parameters
            window.location.href = window.location.pathname;
        });
    </script>
</x-admin-layout>
