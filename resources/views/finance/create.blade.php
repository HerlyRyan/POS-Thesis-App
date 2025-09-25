<x-admin-layout>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h1 class="text-2xl text-white font-bold">Tambah Transaksi</h1>
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
            </div>

            {{-- Kategori --}}
            <div class="mb-4">
                <label for="category"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">Kategori</label>
                <select name="category" id="category"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="general" {{ old('category') == 'general' ? 'selected' : '' }}>Umum</option>
                    <option value="payable_payment" {{ old('category') == 'payable_payment' ? 'selected' : '' }}>
                        Pembayaran Hutang</option>
                </select>
            </div>

            {{-- Pilih Hutang --}}
            <div class="mb-4" id="payable-wrapper" style="display: none;">
                <label for="payable_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Pilih
                    Hutang</label>
                <select name="payable_id" id="payable_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                    <option value="">-- Pilih Hutang --</option>
                    @foreach ($payables as $payable)
                        <option value="{{ $payable->id }}">
                            {{ $payable->lender_name }} (Sisa: {{ number_format($payable->remaining_amount, 0) }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Sumber Dana --}}
            <div class="mb-4">
                <label for="source" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Akun</label>
                <select name="source" id="source"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                    <option value="">-- Pilih Akun --</option>
                    <option value="cash" {{ old('source') == 'cash' ? 'selected' : '' }}>
                        Cash (Saldo: {{ number_format($cashBalance, 0) }})
                    </option>
                    <option value="bank" {{ old('source') == 'bank' ? 'selected' : '' }}>
                        Bank (Saldo: {{ number_format($bankBalance, 0) }})
                    </option>
                </select>
            </div>

            {{-- Tanggal Transaksi --}}
            <div class="mb-4">
                <label for="transaction_date" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal
                    Transaksi</label>
                <input type="date" id="transaction_date" name="transaction_date"
                    value="{{ old('transaction_date', now()->toDateString()) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
            </div>

            {{-- Nominal --}}
            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Jumlah</label>
                <input type="number" id="amount" name="amount" value="{{ old('amount') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4">
                <label for="description"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">Deskripsi</label>
                <textarea id="description" name="description"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    rows="3">{{ old('description') }}</textarea>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.finance.index') }}"
                    class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    Kembali ke Transaksi Keuangan
                </a>
                <button type="button" onclick="document.getElementById('finance-form').submit()"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Simpan Transaksi
                </button>
            </div>
        </form>
    </div>

    {{-- Script JS untuk toggle dropdown hutang --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const categorySelect = document.getElementById("category");
            const payableWrapper = document.getElementById("payable-wrapper");

            function togglePayable() {
                if (categorySelect.value === "payable_payment") {
                    payableWrapper.style.display = "block";
                } else {
                    payableWrapper.style.display = "none";
                }
            }

            // Jalankan saat load (untuk old value)
            togglePayable();

            // Jalankan saat user pilih kategori
            categorySelect.addEventListener("change", togglePayable);
        });
    </script>
</x-admin-layout>
