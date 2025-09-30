@props([
    'action', // route atau url tujuan filter
    'route' => null, // route untuk tombol "Add New"
    'searchPlaceholder' => 'Search...',
    'selectName' => null, // nama filter select (opsional)
    'selectOptions' => [], // isi option
    'selectLabel' => 'All Options',
    'textAdd' => null,
    'routeProduct' => null,
    'year' => false,
    'search' => 1,
])

@php
    // Base classes for form inputs for consistency
    $inputClasses =
        'block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm';

    // Base classes for buttons for consistency
    $buttonBaseClasses =
        'inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2';
@endphp

<div class="mb-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <!-- Filter Form -->
    <form method="GET" action="{{ $action }}" class="flex flex-wrap md:flex-nowrap items-center gap-3"
        id="searchForm">
        @if ($search == 1)
            <!-- Input Search -->
            <div class="flex-grow w-full md:w-auto">
                <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                    placeholder="{{ $searchPlaceholder }}" class="{{ $inputClasses }}">
            </div>
        @endif

        <!-- Select Filter -->
        @if ($selectName && count($selectOptions))
            <div class="w-full md:w-48">
                <select name="{{ $selectName }}" id="filter" class="{{ $inputClasses }}">
                    <option value="">{{ $selectLabel }}</option>
                    @foreach ($selectOptions as $value => $label)
                        <option value="{{ $value }}" {{ request($selectName) == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        @if ($year)
            <!-- Year -->
            <div class="w-full md:w-36">
                <select name="year" id="year" class="{{ $inputClasses }}">
                    <option value="">Pilih Tahun</option>
                    @for ($y = date('Y'); $y >= date('Y') - 10; $y--)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>
        @endif

        <!-- Reset Button -->
        <div class="flex flex-wrap items-center gap-2">
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Filter
            </button>

            <button type="button" onclick="window.location.href='{{ $action }}'" id="resetButton"
                class="{{ $buttonBaseClasses }} bg-gray-600 text-white hover:bg-gray-700 focus:ring-gray-500">
                Reset
            </button>
        </div>
    </form>

    <div class="flex flex-shrink-0 items-center gap-3">
        @if ($routeProduct)
            <a href="{{ $routeProduct }}"
                class="{{ $buttonBaseClasses }} bg-green-600 hover:bg-green-700 focus:ring-green-500">
                Tambah Stok
            </a>
        @endif

        <!-- Tombol Tambah -->
        @if ($route)
            <a href="{{ $route }}"
                class="{{ $buttonBaseClasses }} bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500">
                @if ($textAdd)
                    Tambahkan {{ $textAdd }}
                @else
                    Kembali
                @endif
            </a>
        @endif
    </div>

    <script>
        let debounceTimer;
        const searchForm = document.getElementById('searchForm');
        const searchInput = document.getElementById('searchInput');
        const filterSelect = document.getElementById('filter');
        const yearSelect = document.getElementById('year');
        const resetButton = document.getElementById('resetButton');

        const submitForm = () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                searchForm.submit();
            }, 500); // delay 500ms
        };

        searchInput.addEventListener('input', submitForm);
        if (filterSelect) {
            filterSelect.addEventListener('change', () => searchForm.submit());
        }
        if (yearSelect) {
            yearSelect.addEventListener('change', () => searchForm.submit());
        }

        resetButton.addEventListener('click', function() {
            // Redirect to the base URL without query parameters
            window.location.href = window.location.pathname;
        });
    </script>
</div>
