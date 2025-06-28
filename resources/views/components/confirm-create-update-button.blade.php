@props([
    'name',     
    'modalForm',
    'confirmMessage',
    'question',
    'buttonText' 
])

<x-modal name="{{$name}}" focusable>
    <div class="p-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
            {{$confirmMessage}}
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
            {{$question}}
        </p>

        <div class="mt-6 flex justify-between">
            <button @click="$dispatch('close-modal', '{{$name}}')" type="button"
                class="mr-3 px-4 py-2 bg-gray-400 dark:bg-gray-600 text-gray-800 dark:text-white rounded-md hover:bg-gray-400 dark:hover:bg-gray-700">
                Batal
            </button>

            <button type="button" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
                onclick="document.getElementById('{{$modalForm}}').submit();">
                {{$buttonText}}
            </button>
        </div>
    </div>
</x-modal>