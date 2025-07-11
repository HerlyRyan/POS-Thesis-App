<x-admin-layout>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h1 class="text-2xl text-white font-bold">Tetapkan Buruh</h1>
        <br>
        <form action="{{ route('admin.orders.assignWorker', $order) }}" method="POST" id="worker-form">
            @csrf
            @method('PUT')            

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal Pengiriman</label>
                <input type="date" name="shipping_date" value="{{ old('shipping_date', $order->shipping_date ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                @error('shipping_date')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Pilih Buruh</label>
                @foreach ($availableWorkers as $worker)
                    <div class="flex items-center mb-2">
                        <input type="checkbox" id="worker_{{ $worker->id }}" name="worker_ids[]" value="{{ $worker->id }}"
                            {{ in_array($worker->id, old('worker_ids', $order->workers->pluck('id')->toArray() ?? [])) ? 'checked' : '' }} class="mr-2">
                        <label for="worker_{{ $worker->id }}"
                            class="text-sm text-gray-900 dark:text-gray-100">{{ $worker->user->name }}</label>
                    </div>
                @endforeach
                @error('worker_ids')
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

        <x-confirm-create-update-button :name="'confirm-update'" modalForm="worker-form"
            confirmMessage="Konfirmasi Penetapan Buruh"
            question="Apakah kamu yakin ingin menetapkan buruh ke order ini?" buttonText="Ya, Simpan" />
    </div>
</x-admin-layout>
