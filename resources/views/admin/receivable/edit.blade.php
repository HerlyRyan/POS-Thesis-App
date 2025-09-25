<x-admin-layout>
    <x-flash-modal />
    <x-slot name="header">
        <h1 class="text-2xl font-bold">Edit Hutang</h1>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h1 class="text-2xl text-gray-900 dark:text-white font-bold">Ubah Data Hutang</h1>
        <br>
        <form action="{{ route('admin.payable.update', $payable->id) }}" method="POST" id="edit-payable-form">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Lender Name --}}
                <div class="mb-4">
                    <label for="lender_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama
                        Pemberi Pinjaman</label>
                    <input type="text" id="lender_name" name="lender_name"
                        value="{{ old('lender_name', $payable->lender_name) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        required>
                    @error('lender_name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Due Date --}}
                <div class="mb-4">
                    <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal
                        Jatuh Tempo</label>
                    <input type="date" id="due_date" name="due_date"
                        value="{{ old('due_date', \Carbon\Carbon::parse($payable->due_date)->format('Y-m-d')) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        required>
                    @error('due_date')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Total Amount --}}
                <div class="mb-4">
                    <label for="total_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Jumlah
                        Total</label>
                    <input type="number" step="0.01" id="total_amount" name="total_amount"
                        value="{{ old('total_amount', $payable->total_amount) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        required min="0">
                    @error('total_amount')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Installment Amount --}}
                <div class="mb-4">
                    <label for="installment_amount"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-200">Jumlah Angsuran</label>
                    <input type="number" step="0.01" id="installment_amount" name="installment_amount"
                        value="{{ old('installment_amount', $payable->installment_amount) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        required min="0">
                    @error('installment_amount')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Remaining Amount --}}
                <div class="mb-4">
                    <label for="remaining_amount"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-200">Sisa Hutang</label>
                    <input type="number" step="0.01" id="remaining_amount" name="remaining_amount"
                        value="{{ old('remaining_amount', $payable->remaining_amount) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        required min="0">
                    @error('remaining_amount')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="mb-4">
                    <label for="status"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-200">Status</label>
                    <select id="status" name="status"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        required>
                        <option value="unpaid" @selected(old('status', $payable->status) == 'unpaid')>Belum Lunas</option>
                        <option value="partial" @selected(old('status', $payable->status) == 'partial')>Sebagian</option>
                        <option value="paid" @selected(old('status', $payable->status) == 'paid')>Lunas</option>
                    </select>
                    @error('status')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <label for="description"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">Deskripsi</label>
                <textarea id="description" name="description" rows="3"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">{{ old('description', $payable->description) }}</textarea>
                @error('description')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('admin.payable.index') }}"
                    class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    Kembali
                </a>
                <button type="button" x-data @click="$dispatch('open-modal', 'confirm-edit')"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Simpan Perubahan
                </button>
            </div>
        </form>

        <x-confirm-create-update-button :name="'confirm-edit'" modalForm="edit-payable-form"
            confirmMessage="Konfirmasi Edit Hutang" question="Apakah kamu yakin ingin mengubah data hutang ini?"
            buttonText="Ya, Simpan" />
    </div>
</x-admin-layout>
