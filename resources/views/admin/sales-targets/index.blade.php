<x-admin-layout>
    <x-flash-modal />
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-white text-xl">Data Target Penjualan</h2>
        <br>
        <!-- Desktop View -->
        <div class="hidden md:block">
            <x-filter-add-table :action="route('admin.sales-targets.index')" :route="route('admin.sales-targets.create')" textAdd="Target Penjualan" year="true"
                search="0" />

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
                                Bulan</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Target Penjualan</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                        @forelse($salesTargets as $index => $item)
                            <tr>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $loop->iteration + $salesTargets->firstItem() - 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $item->month }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    Rp {{ number_format($item->target_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.sales-targets.show', $item) }}"
                                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Detail</a>
                                        <a href="{{ route('admin.sales-targets.edit', $item) }}"
                                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Ubah</a>
                                        <x-confirm-delete-button :route="route('admin.sales-targets.destroy', $item)"
                                            modalId="confirm-delete-{{ $item->id }}" />
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data target penjualan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $salesTargets->appends(request()->query())->links() }}
            </div>
        </div>

        <!-- Mobile View -->
        <div class="block md:hidden space-y-4">
            <x-filter-add-table :action="route('admin.sales-targets.index')" :route="route('admin.sales-targets.create')" searchPlaceholder="Cari nama pelanggan..."
                textAdd="Pelanggan" />
            @forelse($salesTargets as $item)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                        {{ $item->month }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                        {{ $item->target_amount }}
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('admin.sales-targets.show', $item) }}"
                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Detail</a>
                        <a href="{{ route('admin.sales-targets.edit', $item) }}"
                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Edit</a>
                        <x-confirm-delete-button :route="route('admin.sales-targets.destroy', $item)" modalId="confirm-delete-{{ $item->id }}" />
                    </div>
                </div>
            @empty
                <div
                    class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md text-center text-gray-500 dark:text-gray-400">
                    Tidak ada data target penjualan.
                </div>
            @endforelse
            <div class="mt-4">
                {{ $salesTargets->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
