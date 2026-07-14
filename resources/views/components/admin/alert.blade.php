@props([
    'type' => 'info',
    'title' => null,
    'dismissible' => false,
])

@php
    $types = [
        'success' => 'border-emerald-200 bg-emerald-50 text-emerald-800 dark:border-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
        'error' => 'border-red-200 bg-red-50 text-red-800 dark:border-red-800 dark:bg-red-900/30 dark:text-red-300',
        'warning' => 'border-amber-200 bg-amber-50 text-amber-800 dark:border-amber-800 dark:bg-amber-900/30 dark:text-amber-300',
        'info' => 'border-sky-200 bg-sky-50 text-sky-800 dark:border-sky-800 dark:bg-sky-900/30 dark:text-sky-300',
    ];
@endphp

<div
    {{ $attributes->class(['rounded-lg border px-4 py-3 text-sm', $types[$type] ?? $types['info']]) }}
    @if ($dismissible) x-data="{ show: true }" x-show="show" x-transition @endif
>
    <div class="flex items-start justify-between gap-3">
        <div>
            @if ($title)
                <p class="font-semibold">{{ $title }}</p>
            @endif
            <div @class(['text-sm', $title ? 'mt-1' : ''])>{{ $slot }}</div>
        </div>
        @if ($dismissible)
            <button type="button" class="text-current/70 hover:text-current" @click="show = false" aria-label="Dismiss">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        @endif
    </div>
</div>
