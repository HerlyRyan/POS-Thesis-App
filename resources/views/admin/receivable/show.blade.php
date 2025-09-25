<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">Detail Piutang</h1>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-xl">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 border-b-2 border-indigo-500 pb-2">Informasi
            Piutang</h2>

        <div class="space-y-4">
            <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ Str::title($receivable->customer->user->name) }}</h3>
            <hr class="border-gray-300 dark:border-gray-600">

            <p class="text-lg text-gray-700 dark:text-gray-300">
                <strong class="font-semibold w-48 inline-block">Deskripsi:</strong>
                <span class="font-medium">{{ $receivable->description }}</span>
            </p>

            <p class="text-lg text-gray-700 dark:text-gray-300">
                <strong class="font-semibold w-48 inline-block">Total Piutang:</strong>
                <span class="font-medium text-green-600 dark:text-green-400">Rp
                    {{ number_format($receivable->total_amount, 0, ',', '.') }}</span>
            </p>

            <p class="text-lg text-gray-700 dark:text-gray-300">
                <strong class="font-semibold w-48 inline-block">Sudah Dibayar:</strong>
                <span class="font-medium">Rp {{ number_format($receivable->paid_amount, 0, ',', '.') }}</span>
            </p>

            <p class="text-lg text-gray-700 dark:text-gray-300">
                <strong class="font-semibold w-48 inline-block">Sisa Piutang:</strong>
                <span class="font-medium text-red-600 dark:text-red-400">Rp
                    {{ number_format($receivable->remaining_amount, 0, ',', '.') }}</span>
            </p>

            <p class="text-lg text-gray-700 dark:text-gray-300">
                <strong class="font-semibold w-48 inline-block">Status:</strong>
                <span
                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $receivable->status == 'paid'
                                ? 'bg-green-100 text-green-800'
                                : ($receivable->status == 'partial'
                                    ? 'bg-yellow-500 text-white'
                                    : 'bg-red-100 text-red-800') }}">
                    @if ($receivable->status == 'unpaid')
                        Belum Lunas
                    @elseif ($receivable->status == 'paid')
                        Lunas
                    @else
                        Cicil
                    @endif
                </span>
            </p>

            <p class="text-lg text-gray-700 dark:text-gray-300">
                <strong class="font-semibold w-48 inline-block">Tanggal Jatuh Tempo:</strong>
                <span class="font-medium">{{ \Carbon\Carbon::parse($receivable->due_date)->format('d F Y') }}</span>
            </p>
        </div>

        {{-- Action Buttons --}}
        <div
            class="flex flex-col sm:flex-row items-center justify-between mt-8 pt-6 border-t-2 border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.receivable.index') }}"
                class="text-gray-600 dark:text-gray-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition duration-300 ease-in-out mb-4 sm:mb-0">
                Kembali ke Daftar Piutang
            </a>
            @if ($receivable->status != 'paid')
                <a href="{{ route('admin.receivable.edit', $receivable) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Ubah Piutang
                </a>
            @endif
        </div>
    </div>
</x-admin-layout>
