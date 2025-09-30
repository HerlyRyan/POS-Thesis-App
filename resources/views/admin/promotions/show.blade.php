<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">Detail Promosi</h1>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-xl">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 border-b-2 border-indigo-500 pb-2">Informasi
            Promosi</h2>

        <div class="space-y-6">
            {{-- Promotion Title --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-400">Judul Promosi</h3>
                <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $promotion->title }}</p>
            </div>
            <hr class="border-gray-300 dark:border-gray-600">

            {{-- Promotion Description --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-400">Deskripsi</h3>
                <p class="mt-1 text-gray-700 dark:text-gray-300 leading-relaxed">{{ $promotion->description }}</p>
            </div>
            <hr class="border-gray-300 dark:border-gray-600">

            {{-- Promotion Dates --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-400">Tanggal Mulai</h3>
                    <p class="mt-1 text-lg text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($promotion->start_date)->format('d F Y') }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-400">Tanggal Berakhir</h3>
                    <p class="mt-1 text-lg text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($promotion->end_date)->format('d F Y') }}</p>
                </div>
            </div>
            <hr class="border-gray-300 dark:border-gray-600">

            {{-- Expected Increase --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-400">Target Peningkatan Penjualan</h3>
                <p class="mt-1 text-lg text-indigo-600 dark:text-indigo-400 font-bold">{{ $promotion->expected_increase }}%</p>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div
            class="flex flex-col sm:flex-row items-center justify-between mt-8 pt-6 border-t-2 border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.promotions.index') }}"
                class="text-gray-600 dark:text-gray-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition duration-300 ease-in-out mb-4 sm:mb-0">
                Kembali ke Daftar Promosi
            </a>
            <a href="{{ route('admin.promotions.edit', $promotion) }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Ubah Promosi
            </a>
        </div>
    </div>
</x-admin-layout>
