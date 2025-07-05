<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold">Employee Details</h1>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <div class="mb-4">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Employee Information</h2>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Name: <span class="font-medium">{{ $employee->name }}</span></p>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Email: <span class="font-medium">{{ $employee->email }}</span></p>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Position: <span class="font-medium">{{ $employee->position }}</span></p>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Phone: <span class="font-medium">{{ $employee->phone }}</span></p>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Address: <span class="font-medium">{{ $employee->address }}</span></p>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Hire Date: <span class="font-medium">{{ $employee->hire_date->format('d-m-Y') }}</span></p>
        </div>

        <div class="flex items-center justify-between mt-4">
            <a href="{{ route('admin.employees.index') }}"
                class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                Back to Employees List
            </a>
            <a href="{{ route('admin.employees.edit', $employee) }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-xs uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Edit Employee
            </a>
        </div>
    </div>
</x-admin-layout>
