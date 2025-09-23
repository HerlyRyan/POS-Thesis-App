@props([
    'action', // URL tujuan form filter
    'printRoute' => null, // Route tombol cetak
    'searchPlaceholder' => null,
    'selectName' => null,
    'selectOptions' => [],
    'selectLabel' => 'All Options',
    'date' => false,
    'year' => false,
])

<div class="mb-4">
    <form method="GET" action="{{ $action }}" id="searchForm">
        <!-- Unified Filter Container -->
        <div class="bg-white p-4 rounded-lg shadow-md mb-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 items-end">
                <!-- Search -->
                @if ($searchPlaceholder)
                    <div>
                        <label for="searchInput" class="block text-sm font-medium text-gray-700">Cari Data</label>
                        <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                            placeholder="{{ $searchPlaceholder }}"
                            class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                @endif

                <!-- Select Filter -->
                @if ($selectName && count($selectOptions))
                    <div>
                        <label for="filterSelect"
                            class="block text-sm font-medium text-gray-700">{{ $selectLabel }}</label>
                        <select name="{{ $selectName }}" id="filterSelect"
                            class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Semua</option>
                            @foreach ($selectOptions as $value => $label)
                                <option value="{{ $value }}"
                                    {{ request($selectName) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                @if ($date)
                    <!-- Start Date -->
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Awal</label>
                        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                            class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <!-- End Date -->
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                            class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <!-- Month -->
                    <div>
                        <label for="month" class="block text-sm font-medium text-gray-700">Bulan</label>
                        <select name="month" id="month"
                            class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Pilih Bulan</option>
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                @endif
                @if ($year)
                    <!-- Year -->
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700">Tahun</label>
                        <select name="year" id="year"
                            class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Pilih Tahun</option>
                            @for ($y = date('Y'); $y >= date('Y') - 10; $y--)
                                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                    </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap items-center gap-2">
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Filter
            </button>

            <button type="button" id="resetButton"
                class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 text-sm font-semibold rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Reset
            </button>

            @if ($printRoute)
                <a href="{{ $printRoute . '?' . http_build_query(request()->all()) }}" target="_blank"
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
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

            // Debounced submit for search and select (non-date filters)
            const debouncedSubmit = () => {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    // Only submit if date filters are not the primary trigger
                    if (!{{ $date ? 'true' : 'false' }}) {
                        form.submit();
                    }
                }, 500);
            };

            if (searchInput) {
                searchInput.addEventListener('input', debouncedSubmit);
            }

            if (selectFilter) {
                selectFilter.addEventListener('change', debouncedSubmit);
            }

            if (resetButton) {
                resetButton.addEventListener('click', () => {
                    window.location.href = "{{ $action }}";
                });
            }
        })();
    </script>
</div>
