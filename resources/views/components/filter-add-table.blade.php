@props([
    'action', // route atau url tujuan filter
    'route' => null, // route untuk tombol "Add New"
    'searchPlaceholder' => 'Search...',
    'selectName' => null, // nama filter select (opsional)
    'selectOptions' => [], // isi option
    'selectLabel' => 'All Options',
    'textAdd' => null,
    'routeProduct' => null,
])

<div class="mb-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <!-- Filter Form -->
    <form method="GET" action="{{ $action }}" class="flex flex-wrap md:flex-row md:items-center items-center gap-3"
        id="searchForm">
        <!-- Input Search -->
        <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
            placeholder="{{ $searchPlaceholder }}"
            class="flex-1 w-full md:basis-1/3 max-w-md px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">

        <!-- Select Filter -->
        @if ($selectName && count($selectOptions))
            <select name="{{ $selectName }}" id="filter"
                class="w-full md:w-48 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">{{ $selectLabel }}</option>
                @foreach ($selectOptions as $value => $label)
                    <option value="{{ $value }}" {{ request($selectName) == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        @endif

        <!-- Reset Button -->
        <button type="button" onclick="window.location.href='{{ $action }}'" id="resetButton"
            class="inline-flex items-center px-3 py-2 bg-gray-300 border border-transparent rounded-md text-xs font-semibold text-gray-800 uppercase tracking-widest hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
            Reset
        </button>
    </form>

    <div class="flex flex-wrap md:flex-row md:items-center items-center gap-3">
        @if ($routeProduct)
            <a href="{{ $routeProduct }}"
                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Tambah Stok
            </a>
        @endif

        <!-- Tombol Tambah -->
        @if ($route)
            <a href="{{ $route }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                @if ($textAdd)
                    Tambahkan Data {{ $textAdd }}
                @else
                    Kembali
                @endif
            </a>
        @endif
    </div>

    <script>
        let debounceTimer;
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        const filter = document.getElementById('filter');
        const resetButton = document.getElementById('resetButton');

        if (filter) {
            filter.addEventListener('change', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    searchForm.submit();
                }, 500);
            });
        }

        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                searchForm.submit();
            }, 500); // delay 500ms after the user stops typing
        });

        resetButton.addEventListener('click', function() {
            searchInput.value = '';
            if (filter) {
                filter.value = '';
            }
            // Redirect to the base URL without query parameters
            window.location.href = window.location.pathname;
        });
    </script>
</div>
