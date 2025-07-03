<x-admin-layout>
    <x-flash-modal />

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <div class="flex justify-between">
            <h2 class="text-white text-xl">Sales Data</h2>
            <!-- Tombol Print -->
            <div class="flex md:items-start justify-end">
                <a href="{{ route('admin.report_sales.print', request()->all()) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Print
                </a>
            </div>
        </div>
        <br>
        <!-- Desktop View -->
        <div class="hidden md:block">
            <div class="mb-4 flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                <!-- Filter Form -->
                <form method="GET" action="{{ route('admin.report_sales.index') }}" id="searchForm"
                    class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-2 w-full">

                    <!-- Search -->
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari invoice / customer..."
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md dark:bg-gray-900 dark:text-gray-100">

                    <!-- Status -->
                    <select name="status"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md dark:bg-gray-900 dark:text-gray-100">
                        <option value="">Semua Status</option>
                        @foreach (['dibayar', 'belum dibayar', 'cicil'] as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Rentang Tanggal -->
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md dark:bg-gray-900 dark:text-gray-100">

                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md dark:bg-gray-900 dark:text-gray-100">

                    <!-- Bulan -->
                    <select name="month"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md dark:bg-gray-900 dark:text-gray-100">
                        <option value="">Pilih Bulan</option>
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>

                    <!-- Tombol Filter dan Reset -->
                    <div class="col-span-full flex gap-2 mt-2">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-xs uppercase tracking-widest font-semibold rounded-md hover:bg-blue-700">
                            Filter
                        </button>
                        <a href="{{ route('admin.report_sales.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-xs uppercase tracking-widest font-semibold rounded-md hover:bg-gray-400">
                            Reset
                        </a>
                    </div>
                </form>
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
                                Invoice Number</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Customer</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Sales Person</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Total Price</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Payment Method</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                        @forelse($sales as $index => $sale)
                            <tr>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $loop->iteration + $sales->firstItem() - 1 }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $sale->invoice_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $sale->customer->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $sale->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    Rp {{ number_format($sale->total_price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $sale->payment_method }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $sale->payment_status == 'dibayar'
                                ? 'bg-green-100 text-green-800'
                                : ($sale->payment_status == 'belum dibayar'
                                    ? 'bg-yellow-500 text-white'
                                    : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($sale->payment_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $sale->transaction_date->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No sales found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $sales->appends(request()->query())->links() }}
            </div>
        </div>

        <!-- Mobile View -->
        <div class="block md:hidden space-y-4">
            <div class="mb-4 flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                <!-- Filter Form -->
                <form method="GET" action="{{ route('admin.report_sales.index') }}" id="searchForm"
                    class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-2 w-full">

                    <!-- Search -->
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari invoice / customer..."
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md dark:bg-gray-900 dark:text-gray-100">

                    <!-- Status -->
                    <select name="status"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md dark:bg-gray-900 dark:text-gray-100">
                        <option value="">Semua Status</option>
                        @foreach (['dibayar', 'belum dibayar', 'cicil'] as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Rentang Tanggal -->
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md dark:bg-gray-900 dark:text-gray-100">
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md dark:bg-gray-900 dark:text-gray-100">

                    <!-- Bulan -->
                    <select name="month"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md dark:bg-gray-900 dark:text-gray-100">
                        <option value="">Pilih Bulan</option>
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>

                    <!-- Tombol Filter dan Reset -->
                    <div class="col-span-full flex gap-2 mt-2">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-xs font-semibold rounded-md hover:bg-blue-700">
                            Filter
                        </button>
                        <a href="{{ route('admin.report_sales.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-xs font-semibold rounded-md hover:bg-gray-400">
                            Reset
                        </a>
                    </div>
                </form>

                <!-- Tombol Print -->
                <div class="flex md:items-start justify-end">
                    <a href="{{ route('admin.report_sales.print', request()->all()) }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Print
                    </a>
                </div>
            </div>
            @forelse($sales as $sale)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ $sale->invoice_number }}
                        </div>
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $sale->payment_status == 'dibayar'
                                ? 'bg-green-100 text-green-800'
                                : ($sale->payment_status == 'belum dibayar'
                                    ? 'bg-yellow-500 text-white'
                                    : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($sale->payment_status) }}
                        </span>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                        Customer: {{ $sale->customer->user->name ?? 'N/A' }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                        Total: Rp {{ number_format($sale->total_price, 0, ',', '.') }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                        Date: {{ $sale->transaction_date->format('d M Y') }}
                    </div>
                </div>
            @empty
                <div
                    class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md text-center text-gray-500 dark:text-gray-400">
                    No sales found.
                </div>
            @endforelse
            <div class="mt-4">
                {{ $sales->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <script>
        let debounceTimer;
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        const statusFilter = document.getElementById('statusFilter');
        const resetButton = document.getElementById('resetButton');

        if (statusFilter) {
            statusFilter.addEventListener('change', function() {
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
            }, 500); // delay 500ms after the user stops typing
        });

        resetButton.addEventListener('click', function() {
            searchInput.value = '';
            if (statusFilter) {
                statusFilter.value = '';
            }
            // Redirect to the base URL without query parameters
            window.location.href = window.location.pathname;
        });
    </script>
</x-admin-layout>
