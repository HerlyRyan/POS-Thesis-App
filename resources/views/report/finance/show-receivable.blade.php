<x-admin-layout>
    <x-flash-modal />
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <div class="flex justify-between">
            <h2 class="text-white text-xl">Data Piutang (Receivable)</h2>
            <a href="{{ route('admin.report_finance.index') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Kembali
            </a>
        </div>
        <br>
        <!-- Desktop View -->
        <div class="hidden md:block">
            <x-filter-report-table :action="url()->current()" :printRoute="route('admin.report_receivable.print')" searchPlaceholder="Cari nama pelanggan..."
                selectName="status" :selectOptions="['paid' => 'Lunas', 'unpaid' => 'Belum Lunas', 'partial' => 'Cicil']" selectLabel="Semua status" date='true' year='true' />

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
                                Pelanggan</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Total Piutang</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Sudah Dibayar</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Sisa Piutang</th>
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
                        @forelse($receivables as $index => $receivable)
                            <tr>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $loop->iteration + $receivables->firstItem() - 1 }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ Str::title($receivable->customer->user->name) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    Rp {{ number_format($receivable->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    Rp {{ number_format($receivable->paid_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    Rp {{ number_format($receivable->remaining_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $receivable->status == 'paid' ? 'bg-green-100 text-green-800' : ($receivable->status == 'partial' ? 'bg-yellow-500 text-white' : 'bg-red-100 text-red-800') }}">
                                        @if ($receivable->status == 'unpaid')
                                            Belum Lunas
                                        @elseif ($receivable->status == 'paid')
                                            Lunas
                                        @else
                                            Cicil
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($receivable->due_date)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.receivable.show', $receivable) }}"
                                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Detail</a>
                                        @if ($receivable->status != 'paid')
                                            <a href="{{ route('admin.receivable.edit', $receivable) }}"
                                                class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Ubah</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data piutang.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $receivables->appends(request()->query())->links() }}
            </div>
        </div>

        <!-- Mobile View -->
        <div class="block md:hidden space-y-4">
            <x-filter-add-table :action="route('admin.receivable.index')" :route="route('admin.receivable.create')" searchPlaceholder="Cari nama pelanggan..."
                textAdd="Piutang" />
            @forelse($receivables as $receivable)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                    <div class="flex justify-between items-start">
                        <div class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                            {{ Str::title($receivable->customer->name) }}
                        </div>
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $receivable->status == 'paid' ? 'bg-green-100 text-green-800' : ($receivable->status == 'partial' ? 'bg-yellow-500 text-white' : 'bg-red-100 text-red-800') }}">
                            @if ($receivable->status == 'unpaid')
                                Belum Lunas
                            @elseif ($receivable->status == 'paid')
                                Lunas
                            @else
                                Cicil
                            @endif
                        </span>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                        Total: @rupiah($receivable->total_amount)
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                        Sisa: <span class="font-bold">@rupiah($receivable->remaining_amount)</span>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                        Jatuh Tempo: {{ \Carbon\Carbon::parse($receivable->due_date)->format('d M Y') }}
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('admin.receivable.show', $receivable) }}"
                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Detail</a>
                        @if ($receivable->status != 'paid')
                            <a href="{{ route('admin.receivable.edit', $receivable) }}"
                                class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Ubah</a>
                        @endif
                    </div>
                </div>
            @empty
                <div
                    class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md text-center text-gray-500 dark:text-gray-400">
                    Tidak ada data piutang.
                </div>
            @endforelse
            <div class="mt-4">
                {{ $receivables->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
