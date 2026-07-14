@props([
    'color' => 'default',
])

@php
    $colors = [
        'default' => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-200',
        'primary' => 'bg-brand/10 text-brand dark:bg-brand/20 dark:text-brand-accent',
        'success' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300',
        'warning' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300',
        'danger' => 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300',
        'info' => 'bg-sky-100 text-sky-800 dark:bg-sky-900/40 dark:text-sky-300',
    ];
@endphp

<span {{ $attributes->class(['inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium', $colors[$color] ?? $colors['default']]) }}>
    {{ $slot }}
</span>
