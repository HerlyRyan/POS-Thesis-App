<x-admin-layout>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h1 class="text-2xl text-white font-bold">Create Transaction</h1>
        <br>
        <form action="{{ route('admin.finance.store') }}" method="POST" id="finance-form">
            @csrf

            {{-- Tipe Transaksi --}}
            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tipe</label>
                <select name="type" id="type"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                    <option value="">-- Pilih Tipe Transaksi --</option>
                    <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Masuk</option>
                    <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Keluar</option>
                </select>
                @error('type')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Kategori --}}
            <div class="mb-4">
                <label for="category"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">Kategori</label>
                <input type="text" id="category" name="category" value="{{ old('category') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                @error('category')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Sumber Dana --}}
            <div class="mb-4">
                <label for="source" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Sumber/Dampak</label>
                <select name="source" id="source"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                    <option value="">-- Pilih Sumber/Dampak --</option>
                    <option value="cash" {{ old('source') == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="bank" {{ old('source') == 'bank' ? 'selected' : '' }}>Bank</option>
                </select>
                @error('source')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Tanggal Transaksi --}}
            <div class="mb-4">
                <label for="transaction_date"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal Transaksi</label>
                <input type="date" id="transaction_date" name="transaction_date"
                    value="{{ old('transaction_date', now()->toDateString()) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                @error('transaction_date')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Nominal --}}
            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Jumlah</label>
                <input type="number" pattern="\d*" inputmode="numeric" id="amount" name="amount"
                    value="{{ old('amount') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                @error('amount')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4">
                <label for="description"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">Deskripsi</label>
                <textarea id="description" name="description"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.finance.index') }}"
                    class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    Kembali ke Transaksi Keuangan
                </a>
                <button type="button" x-data @click="$dispatch('open-modal', 'confirm-create')"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Simpan Transaksi
                </button>
            </div>
        </form>

        {{-- Modal Konfirmasi --}}
        <x-confirm-create-update-button :name="'confirm-create'" modalForm="finance-form"
            confirmMessage="Konfirmasi Buat Record" question="Apakah kamu yakin ingin menyimpan record ini?"
            buttonText="Ya, Buat" />
    </div>
</x-admin-layout>
