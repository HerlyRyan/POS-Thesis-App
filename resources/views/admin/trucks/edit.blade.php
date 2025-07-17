<x-admin-layout>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h1 class="text-2xl text-white font-bold">Ubah Data Truk</h1>
        <br>
        <form action="{{ route('admin.trucks.update', $truck->id) }}" method="POST" id="truck-form">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="plate_number" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nomor Plat</label>
                <input type="text" id="plate_number" name="plate_number" value="{{ old('plate_number', $truck->plate_number) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                @error('plate_number')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tipe Truk</label>
                <input type="text" id="type" name="type" value="{{ old('type', $truck->type) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                @error('type')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="capacity" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Kapasitas</label>
                <input type="text" id="capacity" name="capacity" value="{{ old('capacity', $truck->capacity) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                @error('capacity')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Status</label>
                <select name="status"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                    @foreach (['tersedia', 'dipakai', 'diperbaiki'] as $status)
                        <option value="{{ $status }}" {{ old('status', $truck->status) == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('admin.trucks.index') }}"
                    class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    Kembali ke Datfar Truk
                </a>
                <button type="button" x-data @click="$dispatch('open-modal', 'confirm-update')"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Simpan Perubahan
                </button>
            </div>
        </form>

        <x-confirm-create-update-button :name="'confirm-update'" modalForm="truck-form"
            confirmMessage="Konfirmasi Update Truk" question="Apakah kamu yakin ingin mengubah data truk ini?"
            buttonText="Ya, Update" />
    </div>
</x-admin-layout>
