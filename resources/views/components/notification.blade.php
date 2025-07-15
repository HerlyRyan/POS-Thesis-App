@props(['type' => 'info', 'dismissible' => false, 'content' => ''])

<div {{ $attributes->merge(['class' => "bg-{$type}-100 border-l-4 border-{$type}-500 text-{$type}-700 p-4"]) }}
    role="alert">
    @if ($dismissible)
        <button type="button" class="float-right text-{$type}-700 hover:text-{$type}-900"
            onclick="this.parentElement.remove()">
            <span class="text-2xl">&times;</span>
        </button>
    @endif
    <div>{{ $content }}</div>
</div>
