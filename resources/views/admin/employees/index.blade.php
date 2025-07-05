<x-admin-layout>
    <x-flash-modal />
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-white text-xl">Data Pekerja Lepas</h2>
        <br>
        <!-- Desktop View -->
        <div class="hidden md:block">
            <x-filter-add-table :action="route('admin.employees.index')" :route="route('admin.users.create')" searchPlaceholder="Search employee..."
                selectName="position" :selectOptions="['buruh' => 'Buruh', 'supir' => 'Supir']" selectLabel="All Position" textAdd="Employee" />            

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
                            Phone</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Position</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Hourly Rate</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Actions</th>
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
                                {{ $employee->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $employee->phone }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $employee->position }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                Rp {{ number_format($employee->hourly_rate, 0, ',', '.') }}
                            </td>
                            <td
                                class="flex justify-between items-center px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.employees.show', $employee) }}"
                                    class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">View</a>
                                <a href="{{ route('admin.employees.edit', $employee) }}"
                                    class=" text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Edit</a>
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
            <x-filter-add-table :action="route('admin.employees.index')" :route="route('admin.users.create')" searchPlaceholder="Search employee..."
                selectName="position" :selectOptions="['buruh' => 'Buruh', 'supir' => 'Supir']" selectLabel="All Position" textAdd="Employee" />
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
                    <div class="flex space-x-4 mt-3">
                        <a href="{{ route('admin.employees.show', $employee) }}"
                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">View</a>
                        <a href="{{ route('admin.employees.edit', $employee) }}"
                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Edit</a>
                        >
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

    <script>
        let debounceTimer;
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        const positionFilter = document.getElementById('positionFilter');
        const resetButton = document.getElementById('resetButton');

        if (positionFilter) {
            positionFilter.addEventListener('change', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    searchForm.submit();
                }, 500);
            });
        }

        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                searchForm.submit();
            }, 500); // delay 500ms after user stops typing
        });

        resetButton.addEventListener('click', function() {
            searchInput.value = '';
            if (positionFilter) positionFilter.value = '';
            // Remove query string from URL without page reload
            history.pushState({}, '', window.location.pathname);
            searchForm.submit();
        });
    </script>
</x-admin-layout>
