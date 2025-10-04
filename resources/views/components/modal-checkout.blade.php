@props([
    'name',     
    'modalForm',
    'confirmMessage',
    'question',
    'buttonText' 
])

<x-modal name="{{$name}}" focusable>
    <div class="p-8">
        <!-- Header with Icon -->
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-question-circle text-indigo-600 text-2xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                {{$confirmMessage}}
            </h2>
        </div>

        <!-- Question Text -->
        <p class="text-center text-gray-600 dark:text-gray-300 mb-8 text-lg">
            {{$question}}
        </p>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <button @click="$dispatch('close-modal', '{{$name}}')" type="button"
                class="px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-xl border border-gray-300 dark:border-gray-600 transition duration-200 flex items-center justify-center">
                <i class="fas fa-times mr-2"></i>
                Batal
            </button>

            <button type="button" 
                class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl transition duration-200 flex items-center justify-center shadow-lg"
                onclick="document.getElementById('{{$modalForm}}').submit();">
                <i class="fas fa-check mr-2"></i>
                {{$buttonText}}
            </button>
        </div>
    </div>
</x-modal>