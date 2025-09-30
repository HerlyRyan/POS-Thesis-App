<x-admin-layout>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h1 class="text-2xl text-white font-bold">Edit Promo Penjualan</h1>
        <br>
        <form action="{{ route('admin.promotions.update', $promotion->id) }}" method="POST" id="promotion-form">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Judul Promo</label>
                <input type="text" id="title" name="title" value="{{ old('title', $promotion->title) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                @error('title')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Deskripsi</label>
                <textarea id="description" name="description" rows="3"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">{{ old('description', $promotion->description) }}</textarea>
                @error('description')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $promotion->start_date) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        required>
                    @error('start_date')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal Selesai</label>
                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $promotion->end_date) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        required>
                    @error('end_date')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="expected_increase" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Peningkatan Penjualan yang Diharapkan (%)</label>
                <input type="number" step="0.01" id="expected_increase" name="expected_increase" value="{{ old('expected_increase', $promotion->expected_increase) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                @error('expected_increase')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('admin.promotions.index') }}"
                    class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    Kembali ke Daftar Promo
                </a>
                <button type="button" x-data @click="$dispatch('open-modal', 'confirm-update')"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Promo
                </button>
            </div>
        </form>

        <x-confirm-create-update-button :name="'confirm-update'" modalForm="promotion-form"
            confirmMessage="Konfirmasi Update Promo" question="Apakah kamu yakin ingin memperbarui data promo ini?"
            buttonText="Ya, Update" />
    </div>
</x-admin-layout>
