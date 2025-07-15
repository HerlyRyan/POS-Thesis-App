@props([
    'action', // URL tujuan form filter
    'printRoute' => null, // Route tombol cetak
    'searchPlaceholder' => 'Search...',
    'selectName' => null,
    'selectOptions' => [],
    'selectLabel' => 'All Options',
    'date' => false,
])

<div class="mb-4 flex flex-col md:flex-row md:items-start md:justify-between gap-4">
    <!-- Filter Form -->
    <form method="GET" action="{{ $action }}" id="searchForm"
        class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-2 w-full">

        <!-- Search -->
        <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
            placeholder="{{ $searchPlaceholder }}"
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md dark:bg-gray-900 dark:text-gray-100">

        <!-- Select Filter -->
        @if ($selectName && count($selectOptions))
            <select name="{{ $selectName }}" id="filterSelect"
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md dark:bg-gray-900 dark:text-gray-100">
                <option value="">{{ $selectLabel }}</option>
                @foreach ($selectOptions as $value => $label)
                    <option value="{{ $value }}" {{ request($selectName) == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        @endif

        @if ($date)
            <!-- Rentang Tanggal -->
            <input type="date" name="start_date" value="{{ request('start_date') }}"
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md dark:bg-gray-900 dark:text-gray-100">

            <input type="date" name="end_date" value="{{ request('end_date') }}"
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md dark:bg-gray-900 dark:text-gray-100">

            <!-- Bulan -->
            <select name="month"
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md dark:bg-gray-900 dark:text-gray-100">
                <option value="">Pilih Bulan</option>
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
        @endif

        <!-- Tombol Aksi -->
        <div class="col-span-full flex flex-wrap gap-2 mt-2">
            @if ($date)
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-xs uppercase tracking-widest font-semibold rounded-md hover:bg-blue-700">
                    Filter
                </button>
            @endif

            <button type="button" id="resetButton"
                class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-xs uppercase tracking-widest font-semibold rounded-md hover:bg-gray-400">
                Reset
            </button>

            @if ($printRoute)
                <a href="{{ $printRoute . '?' . http_build_query(request()->all()) }}" target="_blank"
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-xs uppercase tracking-widest font-semibold rounded-md hover:bg-green-700">
                    Cetak
                </a>
            @endif
        </div>
    </form>

    <!-- Script Filter -->
    <script>
        (() => {
            const form = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');
            const selectFilter = document.getElementById('filterSelect');
            const resetButton = document.getElementById('resetButton');
            let debounceTimer;

            if (searchInput) {
                searchInput.addEventListener('input', () => {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => form.submit(), 500);
                });
            }

            if (selectFilter) {
                selectFilter.addEventListener('change', () => {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => form.submit(), 500);
                });
            }

            resetButton.addEventListener('click', () => {
                window.location.href = "{{ $action }}";
            });
        })();
    </script>
</div>
