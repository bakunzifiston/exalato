@props([
    'title' => null,
    'padding' => true,
])

<div {{ $attributes->class(['admin-card overflow-hidden', $padding ? 'p-5' : '']) }}>
    @if ($title)
        <div class="mb-4 border-b border-slate-100 pb-3 dark:border-slate-800">
            <h3 class="text-sm font-semibold text-slate-900 dark:text-white">{{ $title }}</h3>
        </div>
    @endif
    {{ $slot }}
</div>
