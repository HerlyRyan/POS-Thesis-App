<x-admin-layout>
    <x-flash-modal />
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-white text-xl">Sales Data</h2>
        <br>
        <!-- Desktop View -->
        <div class="hidden md:block">
            <x-filter-add-table :action="route('admin.sales.index')" :route="route('admin.sales.create')" searchPlaceholder="Search sales..."
                selectName="status" :selectOptions="['dibayar' => 'Dibayar', 'belum dibayar' => 'Belum dibayar', 'cicil' => 'Cicil']" selectLabel="All Stutuses" textAdd="Sale" />

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
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Actions</th>
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if ($sale->payment_status == 'belum dibayar')
                                        @if ($sale->payment_method == 'cash')
                                            <x-confirm-button :route="route('admin.sales.confirm_payment', $sale)"
                                                modalId="confirm-payment-{{ $sale->id }}"
                                                total="{{ $sale->total_price }}" />
                                        @else
                                            @if ($sale->snap_url)
                                                <a href="{{ $sale->snap_url }}" target="_blank"
                                                    class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                                    Pembayaran
                                                </a>
                                            @endif
                                        @endif
                                        <x-confirm-delete-button :route="route('admin.sales.cancel', $sale)"
                                            modalId="confirm-delete-{{ $sale->id }}" name="Batal" />
                                    @else
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.sales.show', $sale) }}"
                                                class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Detail</a>
                                            <x-confirm-delete-button :route="route('admin.sales.destroy', $sale)"
                                                modalId="confirm-delete-{{ $sale->id }}" name="Hapus" />
                                        </div>
                                    @endif
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
            <x-filter-add-table :action="route('admin.sales.index')" :route="route('admin.sales.create')" searchPlaceholder="Search sales..."
                selectName="status" :selectOptions="['dibayar' => 'Dibayar', 'belum dibayar' => 'Belum dibayar', 'cicil' => 'Cicil']" selectLabel="All Stutuses" textAdd="Sale" />
            @forelse($sales as $sale)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $sale->invoice_number }}
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
                    <div class="flex space-x-4">
                        @if ($sale->payment_status == 'belum dibayar')
                            @if ($sale->payment_method == 'cash')
                                <x-confirm-button :route="route('admin.sales.confirm_payment', $sale)" modalId="confirm-payment-{{ $sale->id }}"
                                    total="{{ $sale->total_price }}" />
                            @else
                                @if ($sale->snap_url)
                                    <a href="{{ $sale->snap_url }}" target="_blank"
                                        class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                        Pembayaran
                                    </a>
                                @endif
                            @endif
                            <x-confirm-delete-button :route="route('admin.sales.cancel', $sale)" modalId="confirm-delete-{{ $sale->id }}"
                                name="Batal" />
                        @else
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.sales.show', $sale) }}"
                                    class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Detail</a>
                                <x-confirm-delete-button :route="route('admin.sales.destroy', $sale)"
                                    modalId="confirm-delete-{{ $sale->id }}" name="Hapus" />
                            </div>
                        @endif
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
