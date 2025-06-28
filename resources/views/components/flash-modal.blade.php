@if (session('success'))
    <x-modal name="flash-success" focusable>
        <div class="p-6">
            <h2 class="text-lg font-semibold text-green-700 dark:text-green-400">
                Sukses
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                {{ session('success') }}
            </p>
            <div class="mt-6 flex justify-end">
                <button @click="$dispatch('close-modal', 'flash-success')" type="button"
                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    Tutup
                </button>
            </div>
        </div>
    </x-modal>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'flash-success'
                }))
                setTimeout(() => {
                    window.dispatchEvent(new CustomEvent('close-modal', {
                        detail: 'flash-success'
                    }));
                }, 3000);
            }, 100); // Delay agar Alpine siap
        });
    </script>
@endif

@if (session('error'))
    <x-modal name="flash-error" focusable>
        <div class="p-6">
            <h2 class="text-lg font-semibold text-red-700 dark:text-red-400">
                Gagal
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                {{ session('error') }}
            </p>
            <div class="mt-6 flex justify-end">
                <button @click="$dispatch('close-modal', 'flash-error')" type="button"
                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Tutup
                </button>
            </div>
        </div>
    </x-modal>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'flash-error'
                }))
                setTimeout(() => {
                    window.dispatchEvent(new CustomEvent('close-modal', {
                        detail: 'flash-success'
                    }));
                }, 3000);
            }, 100);
        });
    </script>
@endif
