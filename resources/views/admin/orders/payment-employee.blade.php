<x-admin-layout>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h1 class="text-2xl text-white font-bold mb-4">Pembayaran Upah Karyawan</h1>

        <form action="{{ route('admin.order_payments.store') }}" method="POST" id="payment-form">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">

            <div class="mb-4">
                <label for="source"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">Sumber/Dampak</label>
                <select name="source" id="source"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                    <option value="">-- Pilih Sumber/Dampak --</option>
                    <option value="cash" {{ old('source') == 'cash' ? 'selected' : '' }}>Cash (Rp
                        {{ number_format($cashBalance, 0, ',', '.') }})</option>
                    <option value="bank" {{ old('source') == 'bank' ? 'selected' : '' }}>Bank (Rp
                        {{ number_format($bankBalance, 0, ',', '.') }})</option>
                </select>
                @error('source')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Sopir</h2>
            @if ($order->driver)
                <div class="mb-4">
                    <input type="hidden" name="payments[0][employee_id]" value="{{ $order->driver->id }}">
                    <input type="hidden" name="payments[0][role]" value="sopir">
                    <label for="payment_driver"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ $order->driver->user->name }}</label>
                    <input type="number" id="payment_driver" name="payments[0][amount]" placeholder="Upah sopir"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        required>
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400">Tidak ada sopir yang ditugaskan.</p>
            @endif

            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mt-6 mb-2">Buruh</h2>
            @forelse($order->workers as $index => $worker)
                <div class="mb-4">
                    <input type="hidden" name="payments[{{ $index + 1 }}][employee_id]" value="{{ $worker->id }}">
                    <input type="hidden" name="payments[{{ $index + 1 }}][role]" value="buruh">
                    <label for="payment_worker_{{ $worker->id }}"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ $worker->user->name }}</label>
                    <input type="number" id="payment_worker_{{ $worker->id }}"
                        name="payments[{{ $index + 1 }}][amount]" placeholder="Upah buruh"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        required>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400">Tidak ada buruh yang ditugaskan.</p>
            @endforelse

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('admin.orders.index') }}"
                    class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    Kembali ke Daftar Order
                </a>
                <button type="button" x-data @click="$dispatch('open-modal', 'confirm-payment')"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Submit Pembayaran
                </button>
            </div>
        </form>

        <x-confirm-create-update-button :name="'confirm-payment'" modalForm="payment-form"
            confirmMessage="Konfirmasi Pembayaran" question="Apakah Anda yakin ingin memproses pembayaran ini?"
            buttonText="Ya, Proses Pembayaran" />
    </div>
</x-admin-layout>
