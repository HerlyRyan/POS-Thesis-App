@props([
    'route', // route untuk action form
    'modalId', // nama unik modal, misalnya 'confirm-delete-1'
    'name' => 'Hapus',
])

<button type="button" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300" x-data
    @click="$dispatch('open-modal', '{{ $modalId }}')">
    {{ $name }}
</button>

<x-modal name="{{ $modalId }}" focusable>
    <div class="p-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
            @if ($name == 'Batal')
                Konfirmasi Batalkan Penjualan
            @else
                Konfirmasi Hapus Data
            @endif
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
            @if ($name == 'Batal')
                Apakah kamu yakin ingin membatalkan penjualan ini?
            @else
                Apakah kamu yakin ingin menghapus data ini?
            @endif
        </p>

        <div class="mt-6 flex justify-end">
            <button @click="$dispatch('close-modal', '{{ $modalId }}')" type="button"
                class="mr-3 px-4 py-2 bg-gray-400 dark:bg-gray-600 text-gray-800 dark:text-white rounded-md hover:bg-gray-500 dark:hover:bg-gray-700">
                Batal
            </button>

            <form action="{{ $route }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    @if ($name == 'Batal')
                        Ya, Batal
                    @else                        
                        Ya, Hapus
                    @endif
                </button>
            </form>
        </div>
    </div>
</x-modal>
