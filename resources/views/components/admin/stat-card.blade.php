@props([
    'label' => '',
    'value' => '',
    'description' => '',
    'tone' => 'default',
])

@php
    $accents = [
        'default' => 'border-l-slate-300',
        'maroon' => 'border-l-brand-dark',
        'rust' => 'border-l-brand',
        'orange' => 'border-l-brand-accent',
    ];
@endphp

<div {{ $attributes->class(['admin-card border-l-4 p-5', $accents[$tone] ?? $accents['default']]) }}>
    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ $label }}</p>
    <p class="mt-1 text-2xl font-semibold tracking-tight text-slate-900 dark:text-white">{{ $value }}</p>
    @if ($description)
        <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">{{ $description }}</p>
    @endif
</div>
