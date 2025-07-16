@props([
    'route', // route untuk aksi konfirmasi
    'modalId', // id unik untuk modal
])

<button type="button" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300"
    x-data @click="$dispatch('open-modal', '{{ $modalId }}')">
    Konfirmasi COD
</button>

<x-modal name="{{ $modalId }}" focusable>
    <div class="p-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
            Konfirmasi Pembayaran COD
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
            Apakah Anda yakin bahwa pembayaran COD untuk transaksi ini telah diterima?
        </p>

        <div class="mt-6 flex justify-end">
            <button @click="$dispatch('close-modal', '{{ $modalId }}')" type="button"
                class="mr-3 px-4 py-2 bg-gray-400 dark:bg-gray-600 text-gray-800 dark:text-white rounded-md hover:bg-gray-500 dark:hover:bg-gray-700">
                Batal
            </button>

            <form action="{{ $route }}" method="POST" class="inline">
                @csrf
                @method('PUT')
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    Ya, Sudah Dibayar
                </button>
            </form>
        </div>
    </div>
</x-modal>
