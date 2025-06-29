<x-admin-layout>
    <x-flash-modal />
    <x-slot name="header">
        <h1 class="text-2xl font-bold">Edit Employee</h1>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-white">Edit Employee</h1>
        <br>
        <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST" id="edit-employee-form">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama</label>
                <div class="flex items-center">
                    <input type="text" id="name" name="name" value="{{ old('name', $employee->user->name) }}"
                        class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm text-gray-500 cursor-not-allowed"
                        required readonly>
                    <span class="ml-2 text-xs text-gray-500 dark:text-gray-400 italic">Edit nama di User Configuration</span>
                </div>
                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nomor
                    Telepon</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $employee->phone) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                @error('phone')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>    

            <div class="mb-4">
                <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Posisi</label>
                <select id="position" name="position" 
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                    <option value="buruh" {{ old('position', $employee->position) == 'buruh' ? 'selected' : '' }}>Buruh</option>
                    <option value="supir" {{ old('position', $employee->position) == 'supir' ? 'selected' : '' }}>Supir</option>
                </select>
                @error('position')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="hourly_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tarif per Jam</label>
                <input type="number" id="hourly_rate" name="hourly_rate" value="{{ old('hourly_rate', $employee->hourly_rate) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    step="0.01" min="0" required>
                @error('hourly_rate')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('admin.employees.index') }}"
                    class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    Kembali ke Employee List
                </a>
                <button type="button" x-data @click="$dispatch('open-modal', 'confirm-edit')"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Simpan
                </button>
            </div>
        </form>

        <x-confirm-create-update-button :name="'confirm-edit'" modalForm="edit-employee-form"
            confirmMessage="Konfirmasi Edit Employee" question="Apakah kamu yakin ingin mengubah data karyawan ini?"
            buttonText="Ya, Simpan" />
    </div>
</x-admin-layout>
