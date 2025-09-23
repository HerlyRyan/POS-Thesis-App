<x-admin-layout>
    <x-flash-modal />
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Keuangan Dashboard</h2>
            <a href="{{ route('admin.finance.create') }}"
                class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Tambah Transaksi
            </a>
        </div>

        <!-- Summary Cards -->
        <div class="space-y-8">
            <!-- Saldo Section -->
            <div>
                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Ringkasan Saldo</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="p-4 bg-gray-50 rounded-lg shadow">
                        <h4 class="font-semibold text-gray-600">Saldo Cash</h4>
                        <p class="text-2xl font-bold text-green-500">Rp {{ number_format($cashBalance, 0, ',', '.') }}
                        </p>
                        <div class="mt-2">
                            <a href="{{ route('admin.finance.show', 'cash') }}"
                                class="text-sm text-indigo-600 hover:underline">Lihat Detail</a>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg shadow">
                        <h4 class="font-semibold text-gray-600">Saldo Bank</h4>
                        <p class="text-2xl font-bold text-blue-500">Rp {{ number_format($bankBalance, 0, ',', '.') }}
                        </p>
                        <div class="mt-2">
                            <a href="{{ route('admin.finance.show', 'bank') }}"
                                class="text-sm text-indigo-600 hover:underline">Lihat Detail</a>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg shadow">
                        <h4 class="font-semibold text-gray-600">Total Saldo</h4>
                        <p class="text-2xl font-bold text-indigo-500">Rp
                            {{ number_format($filteredTotal, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Piutang Section -->
            <div>
                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Ringkasan Piutang (Aset)</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="p-4 bg-gray-50 rounded-lg shadow">
                        <h4 class="font-semibold text-gray-600">Piutang Terbayar</h4>
                        <p class="text-2xl font-bold text-teal-500">Rp
                            {{ number_format($paid_receivables, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg shadow">
                        <h4 class="font-semibold text-gray-600">Piutang Tersisa</h4>
                        <p class="text-2xl font-bold text-teal-500">Rp
                            {{ number_format($remaining_receivables, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg shadow">
                        <h4 class="font-semibold text-gray-600">Total Piutang</h4>
                        <p class="text-2xl font-bold text-teal-600">Rp
                            {{ number_format($total_receivables, 0, ',', '.') }}</p>
                        {{-- <div class="mt-2"><a href="#" class="text-sm text-indigo-600 hover:underline">Lihat Detail</a></div> --}}
                    </div>
                </div>
            </div>

            <!-- Utang Section -->
            <div>
                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Ringkasan Utang (Liabilitas)</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="p-4 bg-gray-50 rounded-lg shadow">
                        <h4 class="font-semibold text-gray-600">Utang Terbayar</h4>
                        <p class="text-2xl font-bold text-orange-500">Rp
                            {{ number_format($paid_payables, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg shadow">
                        <h4 class="font-semibold text-gray-600">Utang Tersisa</h4>
                        <p class="text-2xl font-bold text-orange-500">Rp
                            {{ number_format($remaining_payables, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg shadow">
                        <h4 class="font-semibold text-gray-600">Total Utang</h4>
                        <p class="text-2xl font-bold text-orange-600">Rp
                            {{ number_format($total_payables, 0, ',', '.') }}</p>
                        {{-- <div class="mt-2"><a href="#" class="text-sm text-indigo-600 hover:underline">Lihat Detail</a></div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
