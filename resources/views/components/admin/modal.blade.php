@props([
    'name' => 'modal',
    'title' => null,
    'maxWidth' => 'lg',
])

@php
    $maxWidths = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
    ];
@endphp

<div
    x-data="{ open: false }"
    x-on:open-modal.window="if ($event.detail === '{{ $name }}') open = true"
    x-on:close-modal.window="if ($event.detail === '{{ $name }}') open = false"
    x-on:keydown.escape.window="open = false"
    {{ $attributes }}
>
    <div
        x-show="open"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        role="dialog"
        aria-modal="true"
    >
        <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" @click="open = false"></div>
        <div
            x-show="open"
            x-transition
            @class([
                'relative w-full rounded-xl border border-slate-200 bg-white shadow-xl dark:border-slate-700 dark:bg-slate-800',
                $maxWidths[$maxWidth] ?? $maxWidths['lg'],
            ])
        >
            @if ($title)
                <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4 dark:border-slate-700">
                    <h3 class="text-base font-semibold text-slate-900 dark:text-white">{{ $title }}</h3>
                    <button type="button" class="rounded-lg p-1 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700" @click="open = false">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif
            <div class="px-5 py-4">
                {{ $slot }}
            </div>
            @isset($footer)
                <div class="flex justify-end gap-2 border-t border-slate-200 px-5 py-4 dark:border-slate-700">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
