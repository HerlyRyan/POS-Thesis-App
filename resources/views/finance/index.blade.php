<x-admin-layout>
    <x-flash-modal />
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-white text-xl">Finance Records</h2>
        <br>
        <!-- Desktop View -->
        <div class="hidden md:block">
            <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-800 dark:text-gray-200">
                <div class="p-4 bg-white dark:bg-gray-700 rounded shadow">
                    <h3 class="font-semibold">Saldo Cash</h3>
                    <p class="text-lg font-bold text-green-600 dark:text-green-400">Rp
                        {{ number_format($cashBalance, 0, ',', '.') }}</p>
                </div>
                <div class="p-4 bg-white dark:bg-gray-700 rounded shadow">
                    <h3 class="font-semibold">Saldo Bank</h3>
                    <p class="text-lg font-bold text-blue-600 dark:text-blue-400">Rp
                        {{ number_format($bankBalance, 0, ',', '.') }}</p>
                </div>
                <div class="p-4 bg-white dark:bg-gray-700 rounded shadow">
                    <h3 class="font-semibold">Total Saldo</h3>
                    <p class="text-lg font-bold text-indigo-600 dark:text-indigo-400">Rp
                        {{ number_format($filteredTotal, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="mb-4 flex justify-between items-center">
                <a href="{{ route('admin.finance.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Add New Record
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
                                Sumber</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                1
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                CASH
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.finance.show', 'cash') }}"
                                        class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Detail</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                2
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                BANK
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.finance.show', 'bank') }}"
                                        class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Detail</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile View -->
        <div class="block md:hidden space-y-4">
            <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-800 dark:text-gray-200">
                <div class="p-4 bg-white dark:bg-gray-700 rounded shadow">
                    <h3 class="font-semibold">Saldo Cash</h3>
                    <p class="text-lg font-bold text-green-600 dark:text-green-400">Rp
                        {{ number_format($cashBalance, 0, ',', '.') }}</p>
                </div>
                <div class="p-4 bg-white dark:bg-gray-700 rounded shadow">
                    <h3 class="font-semibold">Saldo Bank</h3>
                    <p class="text-lg font-bold text-blue-600 dark:text-blue-400">Rp
                        {{ number_format($bankBalance, 0, ',', '.') }}</p>
                </div>
                <div class="p-4 bg-white dark:bg-gray-700 rounded shadow">
                    <h3 class="font-semibold">Total Saldo</h3>
                    <p class="text-lg font-bold text-indigo-600 dark:text-indigo-400">Rp
                        {{ number_format($filteredTotal, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="mb-4 flex justify-between items-center">
                <a href="{{ route('admin.finance.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Add New
                </a>
            </div>
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                <div class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                    CASH
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.finance.show', 'cash') }}"
                        class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Detail</a>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                <div class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                    BANK
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.finance.show', 'bank') }}"
                        class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Detail</a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
