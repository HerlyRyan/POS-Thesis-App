@props([
    'route', // route untuk action form
    'modalId', // nama unik modal
    'total', // total harga
])

<!-- Tombol untuk membuka modal -->
<button type="button" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300"
    x-data @click="$dispatch('open-modal', '{{ $modalId }}')">
    Konfirmasi
</button>

<!-- Modal -->
<x-modal name="{{ $modalId }}" focusable>
    <!-- Komponen AlpineJS untuk hitung kembalian -->
    <div class="p-6" x-data="{
        total: {{ $total }},
        cash: '',
        get kembalian() {
            return this.cash - this.total;
        },
        formatRupiah(value) {
            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
    }">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
            Konfirmasi Pembayaran
        </h2>

        <!-- Total -->
        <div class="mt-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Total Pembayaran</label>
            <input type="text" readonly
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed"
                :value="formatRupiah(total)">
        </div>

        <!-- Cash -->
        <div class="mt-2">
            <label for="cash" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Cash</label>
            <input type="number" id="cash" name="cash" x-model.number="cash"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Masukkan jumlah uang tunai" min="0">
        </div>

        <!-- Kembalian -->
        <div class="mt-2">
            <label class="block font-medium text-gray-700 dark:text-gray-200">Kembalian</label>
            <p class="mt-1 text-lg font-bold"
                :class="kembalian >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600'"
                x-text="formatRupiah(kembalian)">
            </p>
        </div>

        <!-- Konfirmasi -->
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
            Apakah kamu yakin ingin mengkonfirmasi pembayaran ini?
        </p>

        <!-- Tombol Aksi -->
        <div class="mt-6 flex justify-end">
            <button type="button" @click="$dispatch('close-modal', '{{ $modalId }}')"
                class="mr-3 px-4 py-2 bg-gray-400 dark:bg-gray-600 text-gray-800 dark:text-white rounded-md hover:bg-gray-500 dark:hover:bg-gray-700">
                Batal
            </button>

            <form action="{{ $route }}" method="POST" class="inline">
                @csrf
                @method('PUT')
                <input type="hidden" name="cash" :value="cash">
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    Ya, Konfirmasi
                </button>
            </form>
        </div>
    </div>
</x-modal>
