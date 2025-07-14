<x-admin-layout>
    <x-flash-modal />
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-white text-xl">Data Truk</h2>
        <br>
        <!-- Desktop View -->
        <div class="hidden md:block">
            <x-filter-report-table :action="route('admin.report_trucks.index')" :printRoute="route('admin.report_trucks.print')" searchPlaceholder="Cari nomor plat..."
                selectName="status" :selectOptions="['tersedia' => 'Tersedia', 'dipakai' => 'Dipakai', 'diperbaiki' => 'Diperbaiki']" selectLabel="Semua status" />

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
                                Nomor Plat</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Tipe</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Kapasitas</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                        @forelse($trucks as $index => $truck)
                            <tr>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $loop->iteration + $trucks->firstItem() - 1 }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $truck->plate_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $truck->type }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $truck->capacity }} Ton
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $truck->status == 'tersedia'
                                ? 'bg-green-100 text-green-800'
                                : ($truck->status == 'dipakai'
                                    ? 'bg-yellow-500 text-white'
                                    : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($truck->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.trucks.edit', $truck) }}"
                                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Edit</a>
                                        <x-confirm-delete-button :route="route('admin.trucks.destroy', $truck)"
                                            modalId="confirm-delete-{{ $truck->id }}" name="Hapus" />
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data truk ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $trucks->appends(request()->query())->links() }}
            </div>
        </div>

        <!-- Mobile View -->
        <div class="block md:hidden space-y-4">
            <x-filter-report-table :action="route('admin.report_trucks.index')" :printRoute="route('admin.report_trucks.print')" searchPlaceholder="Cari nomor plat..."
                selectName="status" :selectOptions="['tersedia' => 'Tersedia', 'dipakai' => 'Dipakai', 'diperbaiki' => 'Diperbaiki']" selectLabel="Semua status" />
            @forelse($trucks as $truck)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $truck->plate_number }}
                        </div>
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $truck->status == 'tersedia'
                                ? 'bg-green-100 text-green-800'
                                : ($truck->status == 'dipakai'
                                    ? 'bg-yellow-500 text-white'
                                    : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($truck->status) }}
                        </span>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                        Tipe: {{ $truck->type }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                        Kapasitas: {{ $truck->capacity }}
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('admin.trucks.edit', $truck) }}"
                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Edit</a>
                        <x-confirm-delete-button :route="route('admin.trucks.destroy', $truck)" modalId="confirm-delete-mobile-{{ $truck->id }}"
                            name="Hapus" />
                    </div>
                </div>
            @empty
                <div
                    class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md text-center text-gray-500 dark:text-gray-400">
                    Tidak ada data truk ditemukan.
                </div>
            @endforelse
            <div class="mt-4">
                {{ $trucks->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
