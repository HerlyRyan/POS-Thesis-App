<x-admin-layout>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h1 class="text-2xl text-white font-bold">Tetapkan Supir & Truk - Order #{{ $order->sale->invoice_number }}</h1>
        <br>
        <form method="POST" action="{{ route('admin.orders.assign_delivery', $order) }}" id="delivery-form">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Pilih Supir</label>
                <select name="driver_id" id="driver_id" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">-- Pilih Supir --</option>
                    @foreach ($drivers as $driver)
                        <option value="{{ $driver->id }}">{{ $driver->user->name }} ({{ $driver->user->email }})</option>
                    @endforeach
                </select>
                @error('driver_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Pilih Truk</label>
                <select name="truck_id" id="truck_id" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">-- Pilih Truk --</option>
                    @foreach ($trucks as $truck)
                        <option value="{{ $truck->id }}">{{ $truck->plate_number }} - {{ $truck->type }}
                            ({{ $truck->capacity }} ton)</option>
                    @endforeach
                </select>
                @error('truck_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('admin.orders.index') }}"
                    class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    Kembali ke Daftar Order
                </a>
                <button type="button" x-data @click="$dispatch('open-modal', 'confirm-update')"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Simpan Perubahan
                </button>
            </div>
        </form>

        <x-confirm-create-update-button :name="'confirm-update'" modalForm="delivery-form"
            confirmMessage="Konfirmasi Penetapan Supir & Truk"
            question="Apakah kamu yakin ingin menetapkan supir dan truk ke order ini?" buttonText="Ya, Simpan" />
    </div>
</x-admin-layout>
