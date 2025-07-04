<x-admin-layout>
    <x-flash-modal />

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-white text-xl">Laporan Stok Menipis</h2>
        <br>
        <x-filter-report-table :action="route('admin.report_low_stock.index')" :printRoute="route('admin.report_low_stock.print')" searchPlaceholder="Cari produk..."
            selectName="category" :selectOptions="['galam' => 'Galam', 'bambu' => 'Bambu', 'atap' => 'Atap']" selectLabel="Semua Category" />

        <!-- Desktop View -->
        <div class="hidden md:block">
            <div class="overflow-x-auto w-full">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                No</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Nama Produk</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Stok Saat Ini</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Batas Minimum</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Rekomendasi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                        @forelse($lowStockProducts as $index => $product)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $product->name }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-red-600 dark:text-red-400 font-semibold">
                                    {{ $product->stock }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $product->minimum_stock ?? 10 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 dark:text-green-400">
                                    Segera lakukan pemesanan ulang
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Semua stok aman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile View -->
        <div class="block md:hidden space-y-4">
            @forelse($lowStockProducts as $product)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ $product->name }}
                        </div>
                        <span class="text-sm font-medium text-red-600 dark:text-red-400">
                            Stok: {{ $product->stock }}
                        </span>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                        Batas Minimum: {{ 10 }}
                    </div>
                    <div class="text-sm text-green-600 dark:text-green-400">
                        ✅ Rekomendasi: Segera lakukan pemesanan ulang
                    </div>
                </div>
            @empty
                <div
                    class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md text-center text-gray-500 dark:text-gray-400">
                    Semua stok aman.
                </div>
            @endforelse
        </div>
    </div>
</x-admin-layout>
