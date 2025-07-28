<x-admin-layout>
    <x-flash-modal />
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-white text-xl">Data Pemesanan</h2>
        <br>

        <!-- Desktop View -->
        <div class="hidden md:block">
            <x-filter-report-table :action="route('admin.report_orders.index')" :printRoute="route('admin.report_orders.print')" searchPlaceholder="Cari invoice atau status..."
                selectName="status" :selectOptions="['persiapan' => 'Persiapan', 'pengiriman' => 'Pengiriman', 'selesai' => 'Selesai']" selectLabel="Semua Status" date='true' />

            <div class="overflow-x-auto w-full">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                No</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                Invoice</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                Buruh</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                Supir</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                Truk</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                Tanggal Kirim</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                        @forelse($orders as $index => $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $loop->iteration + $orders->firstItem() - 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $order->sale->invoice_number ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    @if ($order->workers->count() > 0)
                                        {{ $order->workers->pluck('user.name')->map(fn($name) => ucfirst($name))->join(', ') }}
                                    @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Belum Ditentukan
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    @if ($order->driver && $order->driver->user)
                                        {{ ucfirst($order->driver->user->name) }}
                                    @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Belum Ditentukan
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    @if ($order->truck)
                                        {{ $order->truck->plate_number }}
                                    @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Belum Ditentukan
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    @if ($order->shipping_date)
                                        {{ \Carbon\Carbon::parse($order->shipping_date)->format('d M Y') }}
                                    @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Belum Ditentukan
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $order->status == 'draft' ? 'bg-red-600 text-white' : ($order->status == 'persiapan' ? 'bg-yellow-100 text-yellow-800' : ($order->status == 'pengiriman' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800')) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Tidak
                                    ada data pemesanan ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        </div>

        <!-- Mobile View -->
        <div class="block md:hidden space-y-4">
            <x-filter-report-table :action="route('admin.report_orders.index')" :printRoute="route('admin.report_orders.print')" searchPlaceholder="Cari invoice atau status..."
                selectName="status" :selectOptions="['persiapan' => 'Persiapan', 'pengiriman' => 'Pengiriman', 'selesai' => 'Selesai']" selectLabel="Semua Status" date='true' />

            @forelse($orders as $order)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ $order->sale->invoice_number ?? '-' }}</div>
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $order->status == 'draft' ? 'bg-red-600 text-white' : ($order->status == 'persiapan' ? 'bg-yellow-100 text-yellow-800' : ($order->status == 'pengiriman' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800')) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                        Supir: {{ ucfirst(optional(optional($order->driver)->user)->name) ?? '-' }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                        Truk: {{ $order->truck->plate_number ?? '-' }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                        Tanggal Kirim: {{ \Carbon\Carbon::parse($order->shipping_date)->format('d M Y') }}
                    </div>
                </div>
            @empty
                <div
                    class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md text-center text-gray-500 dark:text-gray-400">
                    Tidak ada data pemesanan ditemukan.
                </div>
            @endforelse

            <div class="mt-4">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
