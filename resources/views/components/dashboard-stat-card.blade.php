@props(['label', 'value', 'icon', 'iconBgColor' => 'bg-indigo-600'])

<div class="relative flex flex-col min-w-0 break-words bg-white rounded-lg shadow-md mb-6">
    <div class="flex-auto p-4">
        <div class="flex flex-wrap">
            <div class="relative w-full max-w-full flex-grow flex-1">
                <h6 class="text-gray-500 text-xs font-semibold mb-2 uppercase">
                    {{ $label }}
                </h6>
                <span class="font-semibold text-xl text-gray-800">
                    {{ $value }}
                </span>
            </div>
            <div class="relative w-auto pl-4 flex-initial">
                <div
                    class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 rounded-full {{ $iconBgColor ?? 'bg-indigo-600' }}">
                    {{ $icon }}
                </div>
            </div>
        </div>
    </div>
</div>
