<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold">Customer Details</h1>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Customer Information</h2>
        <div class="mb-4 flex justify-around gap-6">
            <div class="col-2 w-full">
                <h3 class="mt-2 text-gray-600 dark:text-gray-100 font-medium text-xl">{{ $customer->user->name }}</h3>
                <hr>
                <p class="mt-2 text-gray-600 dark:text-gray-100">Email: <span class="font-medium">{{ $customer->user->email }}</span></p>
                <p class="mt-2 text-gray-600 dark:text-gray-100">Phone: <span class="font-medium">{{ $customer->phone ?? '-' }}</span></p>
                <p class="mt-2 text-gray-600 dark:text-gray-100">Address: <span class="font-medium">{{ $customer->address ?? '-' }}</span></p>
            </div>
        </div>

        <div class="flex items-center justify-between mt-4">
            <a href="{{ route('admin.customers.index') }}"
                class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                Back to Customers List
            </a>
            <a href="{{ route('admin.customers.edit', $customer) }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Edit Customer
            </a>
        </div>
    </div>
</x-admin-layout>
