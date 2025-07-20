@php
    $role = Auth::user()->roles->first()?->name;
@endphp

<div x-cloak :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false"
    class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>

<div x-cloak :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
    class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-gray-900 lg:translate-x-0 lg:static lg:inset-0">
    <div class="flex items-center justify-center mt-8">
        <div class="flex items-center">
            <span class="mx-2 text-2xl font-semibold text-white">Galam Sani</span>
        </div>
    </div>

    <nav class="mt-10">
        <a class="flex items-center px-6 py-2 mt-4 {{ Route::currentRouteNamed('dashboard') ? 'text-gray-100' : 'text-gray-500' }} hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
            href="{{ route('dashboard') }}">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
            </svg>

            <span class="mx-3">Dashboard</span>
        </a>

        @if ($role === 'admin')
            <div class="relative group">
                <button id="dropdown-button-master"
                    class="flex items-center px-6 py-2 mt-4 {{ Route::currentRouteNamed('admin.product.*') || Route::currentRouteNamed('admin.customers.*') || Route::currentRouteNamed('admin.employees.*') || Route::currentRouteNamed('admin.trucks.*') ? 'text-gray-100' : 'text-gray-500' }} hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7c-2 0-3 1-3 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-6m3 6v-4m3 4v-2" />
                    </svg>
                    <span class="mx-3">Data Master</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2 -mr-1" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div id="dropdown-menu-master" class="dropdown_branding w-full hidden">
                    <a class="flex items-center px-6 py-2 mt-4 ml-5 {{ Route::currentRouteNamed('admin.product.*') ? 'text-gray-100' : 'text-gray-500' }} hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                        href="{{ route('admin.product.index') }}">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>

                        <span class="mx-3">Produk</span>
                    </a>
                    <a class="flex items-center px-6 py-2 mt-4 ml-5 {{ Route::currentRouteNamed('admin.customers.*') ? 'text-gray-100' : 'text-gray-500' }} hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                        href="{{ route('admin.customers.index') }}">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>

                        <span class="mx-3">Pelanggan</span>
                    </a>
                    <a class="flex items-center px-6 py-2 mt-4 ml-5 {{ Route::currentRouteNamed('admin.employees.*') ? 'text-gray-100' : 'text-gray-500' }} hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                        href="{{ route('admin.employees.index') }}">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>

                        <span class="mx-3">Pekerja Lepas</span>
                    </a>
                    <a class="flex items-center px-6 py-2 mt-4 ml-5 {{ Route::currentRouteNamed('admin.trucks.*') ? 'text-gray-100' : 'text-gray-500' }} hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                        href="{{ route('admin.trucks.index') }}">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12a2 2 0 012 2v7a2 2 0 01-2 2H8m0-11v11a2 2 0 01-2 2H4a2 2 0 01-2-2v-5m0 0l3-6a2 2 0 012-2h2m-1 14a2 2 0 100-4 2 2 0 000 4zm10 0a2 2 0 100-4 2 2 0 000 4z" />
                        </svg>

                        <span class="mx-3">Truk</span>
                    </a>
                </div>
            </div>
            <a class="flex items-center px-6 py-2 mt-4 {{ Route::currentRouteNamed('admin.sales.*') ? 'text-gray-100' : 'text-gray-500' }} hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                href="{{ route('admin.sales.index') }}">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>

                <span class="mx-3">Penjualan</span>
            </a>
            <a class="flex items-center px-6 py-2 mt-4 {{ Route::currentRouteNamed('admin.orders.*') ? 'text-gray-100' : 'text-gray-500' }} hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                href="{{ route('admin.orders.index') }}">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>

                <span class="mx-3">Pesanan</span>
            </a>
            <a class="flex items-center px-6 py-2 mt-4 {{ Route::currentRouteNamed('admin.finance.*') ? 'text-gray-100' : 'text-gray-500' }} hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                href="{{ route('admin.finance.index') }}">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

                <span class="mx-3">Keuangan</span>
            </a>
            <a class="flex items-center px-6 py-2 mt-4 {{ Route::currentRouteNamed('admin.tracking.*') ? 'text-gray-100' : 'text-gray-500' }} hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                href="{{ route('admin.tracking.truck') }}">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                </svg>

                <span class="mx-3">Tes Tracking</span>
            </a>
        @endif

        <div class="relative group">
            <button id="dropdown-button-report"
                class="flex items-center px-6 py-2 mt-4 {{ Route::currentRouteNamed('admin.report_finance.*') || Route::currentRouteNamed('admin.report_sales.*') || Route::currentRouteNamed('admin.report_best_sellers.*') ? 'text-gray-100' : 'text-gray-500' }} hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-4m4 4v-6m4 6v-2M5 3v18M19 9l-7 4-7-4" />
                </svg>
                <span class="mx-3 ">Laporan</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2 -mr-1" viewBox="0 0 20 20"
                    fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
            <div id="dropdown-menu-report" class="dropdown_branding w-full">
                <a class="flex items-center px-6 py-2 mt-4 ml-5 {{ Route::currentRouteNamed('admin.report_finance.*') ? 'text-gray-100' : 'text-gray-500' }} hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                    href="{{ route('admin.report_finance.index') }}">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>

                    <span class="mx-3">Keuangan</span>
                </a>
                <a class="flex items-center px-6 py-2 mt-4 ml-5 {{ Route::currentRouteNamed('admin.report_sales.*') ? 'text-gray-100' : 'text-gray-500' }} hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                    href="{{ route('admin.report_sales.index') }}">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>

                    <span class="mx-3">Penjualan</span>
                </a>
                <a class="flex items-center px-6 py-2 mt-4 ml-5 {{ Route::currentRouteNamed('admin.report_best_sellers.*') ? 'text-gray-100' : 'text-gray-500' }} hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                    href="{{ route('admin.report_best_sellers.index') }}">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>

                    <span class="mx-3">Produk Terlaris</span>
                </a>
                <a class="flex items-center px-6 py-2 mt-4 ml-5 {{ Route::currentRouteNamed('admin.report_low_stock.*') ? 'text-gray-100' : 'text-gray-500' }} hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                    href="{{ route('admin.report_low_stock.index') }}">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>

                    <span class="mx-3">Stok Menipis</span>
                </a>
                <a class="flex items-center px-6 py-2 mt-4 ml-5 {{ Route::currentRouteNamed('admin.report_orders.*') ? 'text-gray-100' : 'text-gray-500' }} hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                    href="{{ route('admin.report_orders.index') }}">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>

                    <span class="mx-3">Pesanan</span>
                </a>
                <a class="flex items-center px-6 py-2 mt-4 ml-5 {{ Route::currentRouteNamed('admin.report_employees.*') ? 'text-gray-100' : 'text-gray-500' }} hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                    href="{{ route('admin.report_employees.index') }}">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>

                    <span class="mx-3">Pekerja Lepas</span>
                </a>
                <a class="flex items-center px-6 py-2 mt-4 ml-5 {{ Route::currentRouteNamed('admin.report_customers.*') ? 'text-gray-100' : 'text-gray-500' }} hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                    href="{{ route('admin.report_customers.index') }}">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>

                    <span class="mx-3">History Pelanggan</span>
                </a>
                <a class="flex items-center px-6 py-2 mt-4 ml-5 {{ Route::currentRouteNamed('admin.report_trucks.*') ? 'text-gray-100' : 'text-gray-500' }} hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                    href="{{ route('admin.report_trucks.index') }}">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7h12a2 2 0 012 2v7a2 2 0 01-2 2H8m0-11v11a2 2 0 01-2 2H4a2 2 0 01-2-2v-5m0 0l3-6a2 2 0 012-2h2m-1 14a2 2 0 100-4 2 2 0 000 4zm10 0a2 2 0 100-4 2 2 0 000 4z" />
                    </svg>

                    <span class="mx-3">Truk</span>
                </a>
            </div>
        </div>

        @if ($role === 'admin')
            <div class="relative group">
                <button id="dropdown-button"
                    class="flex items-center px-6 py-2 mt-4 {{ Route::currentRouteNamed('admin.users.index') || Route::currentRouteNamed('admin.roles.index') || Route::currentRouteNamed('admin.permissions.index') ? 'text-gray-100' : 'text-gray-500' }} hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24"stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    <span class="mx-3 ">Konfigurasi</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2 -mr-1" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div id="dropdown-menu" class="dropdown_branding w-full">
                    <a class="flex items-center px-6 py-2 mt-4 ml-5 {{ Route::currentRouteNamed('admin.users.index') ? 'text-gray-100' : 'text-gray-500' }} hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                        href="{{ route('admin.users.index') }}">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z" />
                        </svg>

                        <span class="mx-3">Pengguna</span>
                    </a>

                    <a class="flex items-center px-6 py-2 mt-4 ml-5 {{ Route::currentRouteNamed('admin.roles.index') ? 'text-gray-100' : 'text-gray-500' }} hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                        href="{{ route('admin.roles.index') }}">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>

                        <span class="mx-3">Role</span>
                    </a>

                    <a class="flex items-center px-6 py-2 mt-4 ml-5 {{ Route::currentRouteNamed('admin.permissions.index') ? 'text-gray-100' : 'text-gray-500' }} hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                        href="{{ route('admin.permissions.index') }}">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>

                        <span class="mx-3">Izin Akses</span>
                    </a>
                </div>
            </div>
        @endif
    </nav>
</div>

<script>
    // Fungsi umum toggle dropdown
    function setupDropdown(buttonId, menuId, shouldBeOpen) {
        const button = document.getElementById(buttonId);
        const menu = document.getElementById(menuId);

        if (!button || !menu) return; // jika button atau menu tidak ada, dropdown tetap bisa (owner session)

        // Set initial state based on current route
        if (shouldBeOpen) {
            menu.classList.remove('hidden');
        } else {
            menu.classList.add('hidden');
        }

        button.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    }

    // Inisialisasi dropdown
    document.addEventListener('DOMContentLoaded', function() {
        // Check if current route is under relevant sections
        const isMasterActive =
            {{ Route::currentRouteNamed('admin.product.*') ||
            Route::currentRouteNamed('admin.customers.*') ||
            Route::currentRouteNamed('admin.employees.*') ||
            Route::currentRouteNamed('admin.trucks.*')
                ? 'true'
                : 'false' }};

        const isReportActive =
            {{ Route::currentRouteNamed('admin.report_finance.*') ||
            Route::currentRouteNamed('admin.report_sales.*') ||
            Route::currentRouteNamed('admin.report_best_sellers.*') ||
            Route::currentRouteNamed('admin.report_low_stock.*') ||
            Route::currentRouteNamed('admin.report_orders.*') ||
            Route::currentRouteNamed('admin.report_employees.*') ||
            Route::currentRouteNamed('admin.report_customers.*') ||
            Route::currentRouteNamed('admin.report_trucks.*')
                ? 'true'
                : 'false' }};

        const isConfigActive =
            {{ Route::currentRouteNamed('admin.users.index') ||
            Route::currentRouteNamed('admin.roles.index') ||
            Route::currentRouteNamed('admin.permissions.index')
                ? 'true'
                : 'false' }};

        setupDropdown('dropdown-button-master', 'dropdown-menu-master', isMasterActive);
        setupDropdown('dropdown-button-report', 'dropdown-menu-report', isReportActive);
        setupDropdown('dropdown-button', 'dropdown-menu', isConfigActive);
    });
</script>
