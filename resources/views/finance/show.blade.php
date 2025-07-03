<x-admin-layout>
    <x-flash-modal />
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-white text-xl">Finance Records</h2>
        <br>
        <!-- Desktop View -->
        <div class="hidden md:block">
            <x-filter-add-table :action="route('admin.finance.index')" :route="route('admin.finance.index')" searchPlaceholder="Search finance record..."
            selectName="status" :selectOptions="['income' => 'Income', 'expense' => 'Expense']" selectLabel="All Types"/>            

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
                                Tanggal</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Tipe</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Dampak</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Kategori</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Jumlah</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Deskripsi</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Total</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                        @forelse($records as $index => $record)
                            <tr>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $loop->iteration + $records->firstItem() - 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($record->transaction_date)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $record->type == 'income' ? 'bg-green-100 text-green-800' : 'bg-red-500 text-white' }}">
                                        {{ ucfirst($record->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $record->source }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $record->category }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    Rp {{ number_format($record->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $record->description }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    Rp {{ number_format($record->total, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.finance.edit', $record) }}"
                                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Edit</a>
                                        <x-confirm-delete-button :route="route('admin.finance.destroy', $record)"
                                            modalId="confirm-delete-{{ $record->id }}" name="Delete" />
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No finance records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $records->appends(request()->query())->links() }}
            </div>
        </div>

        <!-- Mobile View -->
        <div class="block md:hidden space-y-4">
            <div class="mb-4 flex justify-between items-center">
                <!-- Search Form -->
                <form method="GET" action="{{ url()->current() }}" id="mobileSearchForm"
                    class="flex md:flex-row md:items-center md:justify-between gap-2">
                    <div class="items-center w-full md:w-1/3">
                        <input type="text" id="mobileSearchInput" name="search" value="{{ request('search') }}"
                            placeholder="Search records..."
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100">
                    </div>
                    <button type="button" id="mobileResetButton"
                        class="inline-flex items-center px-3 py-2 bg-gray-300 border border-transparent rounded-md text-xs font-semibold text-gray-800 uppercase tracking-widest hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Reset
                    </button>
                </form>
                <a href="{{ route('admin.finance.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Kembali
                </a>
            </div>
            @forelse($records as $record)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                        Date: {{ \Carbon\Carbon::parse($record->transaction_date)->format('d M Y') }}
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $record->type == 'income' ? 'bg-green-100 text-green-800' : 'bg-red-500 text-white' }}">
                            {{ ucfirst($record->type) }}
                        </span>
                        <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Rp {{ number_format($record->amount, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                        Dampak: {{ $record->source }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                        Category: {{ $record->category }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                        Description: {{ $record->description }}
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('admin.finance.edit', $record) }}"
                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Edit</a>
                        <x-confirm-delete-button :route="route('admin.finance.destroy', $record)" modalId="mobile-confirm-delete-{{ $record->id }}"
                            name="Delete" />
                    </div>
                </div>
            @empty
                <div
                    class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md text-center text-gray-500 dark:text-gray-400">
                    No finance records found.
                </div>
            @endforelse
            <div class="mt-4">
                {{ $records->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <script>
        let debounceTimer;
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        const typeFilter = document.getElementById('typeFilter');
        const resetButton = document.getElementById('resetButton');
        const mobileSearchInput = document.getElementById('mobileSearchInput');
        const mobileResetButton = document.getElementById('mobileResetButton');

        if (typeFilter) {
            typeFilter.addEventListener('change', function() {
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
            }, 500);
        });

        resetButton.addEventListener('click', function() {
            searchInput.value = '';
            if (typeFilter) {
                typeFilter.value = '';
            }
            window.location.href = window.location.pathname;
        });

        // Mobile handlers
        mobileSearchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                document.getElementById('mobileSearchForm').submit();
            }, 500);
        });

        mobileResetButton.addEventListener('click', function() {
            mobileSearchInput.value = '';
            window.location.href = window.location.pathname;
        });
    </script>
</x-admin-layout>
