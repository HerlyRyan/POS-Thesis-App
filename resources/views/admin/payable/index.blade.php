<x-admin-layout>
    <x-flash-modal />
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-white text-xl">Data Hutang (Payable)</h2>
        <br>
        <!-- Desktop View -->
        <div class="hidden md:block">
            <x-filter-add-table :action="route('admin.payable.index')" :route="route('admin.finance.index')" searchPlaceholder="Cari nama pemberi pinjaman..."
                selectName="status" :selectOptions="['paid' => 'Dibayar', 'unpaid' => 'Belum dibayar', 'partial' => 'Cicil']" selectLabel="Semua status" />

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
                                Pemberi Pinjaman</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Total Pinjaman</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Angsuran</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Sisa Pinjaman</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Jatuh Tempo</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                        @forelse($payables as $index => $payable)
                            <tr>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $loop->iteration + $payables->firstItem() - 1 }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $payable->lender_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    Rp {{ number_format($payable->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    Rp {{ number_format($payable->installment_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    Rp {{ number_format($payable->remaining_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $payable->status == 'paid'
                                ? 'bg-green-100 text-green-800'
                                : ($payable->status == 'partial'
                                    ? 'bg-yellow-500 text-yellow-800'
                                    : 'bg-red-100 text-red-800') }}">
                                        @if ($payable->status == 'unpaid')
                                            Belum dibayar
                                        @elseif ($payable->status == 'paid')
                                            Lunas
                                        @else
                                            Dibayar sebagian
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($payable->due_date)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.payable.show', $payable) }}"
                                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Detail</a>
                                        @if ($payable->status == 'unpaid')
                                            <a href="{{ route('admin.payable.edit', $payable) }}"
                                                class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Ubah</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data hutang.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $payables->appends(request()->query())->links() }}
            </div>
        </div>

        <!-- Mobile View -->
        <div class="block md:hidden space-y-4">
            <x-filter-add-table :action="route('admin.payable.index')" :route="route('admin.payable.create')" searchPlaceholder="Cari nama pemberi pinjaman..."
                textAdd="Hutang" />
            @forelse($payables as $payable)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                    <div class="flex justify-between items-start">
                        <div class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                            {{ $payable->lender_name }}
                        </div>
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $payable->status == 'paid'
                                ? 'bg-green-100 text-green-800'
                                : ($payable->status == 'partial'
                                    ? 'bg-yellow-500 text-yellow-800'
                                    : 'bg-red-100 text-red-800') }}">
                            @if ($payable->status == 'unpaid')
                                Belum dibayar
                            @elseif ($payable->status == 'paid')
                                Lunas
                            @else
                                Dibayar sebagian
                            @endif
                        </span>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                        Total: Rp {{ number_format($payable->total_amount, 0, ',', '.') }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                        Sisa: <span class="font-bold">Rp {{ number_format($payable->remaining_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                        Jatuh Tempo: {{ \Carbon\Carbon::parse($payable->due_date)->format('d M Y') }}
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('admin.payable.show', $payable) }}"
                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Detail</a>
                        <a href="{{ route('admin.payable.edit', $payable) }}"
                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Edit</a>
                    </div>
                </div>
            @empty
                <div
                    class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md text-center text-gray-500 dark:text-gray-400">
                    Tidak ada data hutang.
                </div>
            @endforelse
            <div class="mt-4">
                {{ $payables->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
