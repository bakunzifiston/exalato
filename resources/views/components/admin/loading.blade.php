@props([
    'label' => 'Loading…',
    'overlay' => false,
])

<div
    {{ $attributes->class([
        'flex items-center justify-center gap-3 text-sm text-slate-500 dark:text-slate-400',
        'absolute inset-0 z-10 rounded-xl bg-white/70 backdrop-blur-sm dark:bg-slate-900/70' => $overlay,
        'py-12' => ! $overlay,
    ]) }}
    role="status"
    aria-live="polite"
>
    <svg class="h-5 w-5 animate-spin text-brand" viewBox="0 0 24 24" fill="none">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
    </svg>
    <span>{{ $label }}</span>
</div>
