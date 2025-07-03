<x-admin-layout>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-white text-xl">Laporan Produk Terlaris</h2>
        <br>

        <!-- Desktop View -->
        <div class="hidden md:block">
            <div class="mb-4 flex justify-between items-center">
                <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap gap-2 items-center">
                    <input type="text" name="search" value="{{ $request->search }}" placeholder="Cari produk..."
                        class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md dark:bg-gray-900 dark:text-gray-100">

                    <input type="date" name="start_date" value="{{ $request->start_date }}"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md dark:bg-gray-900 dark:text-gray-100">

                    <input type="date" name="end_date" value="{{ $request->end_date }}"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md dark:bg-gray-900 dark:text-gray-100">

                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white text-xs font-semibold rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                        Cari
                    </button>

                    <a href="{{ url()->current() }}"
                        class="px-4 py-2 bg-gray-300 text-gray-800 text-xs font-semibold rounded-md hover:bg-gray-400">
                        Reset
                    </a>
                </form>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                No</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                Nama Produk</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                Total Terjual</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($topProducts as $product)
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $product->name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $product->total_sold ?? 0 }} unit
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data produk terlaris.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile View -->
        <div class="block md:hidden space-y-4 mt-6">
            @forelse ($topProducts as $product)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Nama Produk</div>
                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                        {{ $product->name }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Total Terjual: {{ $product->total_sold ?? 0 }} unit
                    </div>
                </div>
            @empty
                <div
                    class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md text-center text-gray-500 dark:text-gray-400">
                    Tidak ada data produk terlaris.
                </div>
            @endforelse
        </div>
    </div>
</x-admin-layout>
