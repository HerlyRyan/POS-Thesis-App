<x-admin-layout>
    <x-flash-modal />
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-white text-xl">Data Pekerja Lepas</h2>
        <br>
        <!-- Desktop View -->
        <div class="hidden md:block">
            <x-filter-report-table :action="route('admin.report_employees.index')" :printRoute="route('admin.report_employees.print')" searchPlaceholder="Cari pekerja lepas..."
                selectName="position" :selectOptions="['buruh' => 'Buruh', 'supir' => 'Supir']" selectLabel="Semua Posisi" />

            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            No</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Nama</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Nomor Telepon</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Posisi</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                    @forelse($employees as $index => $employee)
                        <tr>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $loop->iteration + $employees->firstItem() - 1 }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ ucfirst($employee->user->name) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $employee->phone }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ ucfirst($employee->position) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $employee->status == 'tersedia' ? 'bg-green-100 text-green-800' : 'bg-yellow-500 text-white' }}">
                                    {{ ucfirst($employee->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                No employees found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $employees->appends(request()->query())->links() }}
            </div>
        </div>

        <!-- Mobile View -->
        <div class="block md:hidden space-y-4">
            <x-filter-report-table :action="route('admin.report_employees.index')" :printRoute="route('admin.report_employees.print')" searchPlaceholder="Cari pekerja lepas..."
                selectName="position" :selectOptions="['buruh' => 'Buruh', 'supir' => 'Supir']" selectLabel="Semua Posisi" />
            @forelse($employees as $employee)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $employee->user->name }}
                        </div>
                    </div>
                    <div class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                        <p><span class="font-medium">Phone:</span> {{ $employee->phone }}</p>
                        <p><span class="font-medium">Position:</span> {{ $employee->position }}</p>
                        <p><span class="font-medium">Hourly Rate:</span> Rp
                            {{ number_format($employee->hourly_rate, 0, ',', '.') }}</p>
                    </div>
                </div>
            @empty
                <div
                    class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md text-center text-gray-500 dark:text-gray-400">
                    No employees found.
                </div>
            @endforelse
            <div class="mt-4">
                {{ $employees->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
