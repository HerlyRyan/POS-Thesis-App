<x-admin-layout>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h1 class="text-2xl text-white font-bold">Edit Data Target Penjualan</h1>
        <br>
        <form action="{{ route('admin.sales-targets.update', $salesTarget->id) }}" method="POST" id="sales-target-form">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="month" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Bulan</label>
                <input type="month" id="month" name="month" value="{{ old('month', $salesTarget->month) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                @error('month')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="target_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Target Penjualan</label>
                <input type="number" step="0.01" min="0" id="target_amount" name="target_amount" value="{{ old('target_amount', $salesTarget->target_amount) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                @error('target_amount')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('admin.sales-targets.index') }}"
                    class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    Kembali ke Daftar Target Penjualan
                </a>
                <button type="button" x-data @click="$dispatch('open-modal', 'confirm-update')"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Target Penjualan
                </button>
            </div>
        </form>

        <x-confirm-create-update-button :name="'confirm-update'" modalForm="sales-target-form"
            confirmMessage="Konfirmasi Update Target Penjualan" question="Apakah kamu yakin ingin mengupdate data target penjualan ini?"
            buttonText="Ya, Update" />
    </div>
</x-admin-layout>
