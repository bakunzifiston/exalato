@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
])

@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-lg font-medium transition focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 dark:focus:ring-offset-slate-900';

    $variants = [
        'primary' => 'bg-brand text-white shadow-sm hover:bg-brand-dark focus:ring-brand/40',
        'secondary' => 'border border-slate-200 bg-white text-slate-700 shadow-sm hover:bg-slate-50 focus:ring-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800',
        'danger' => 'bg-red-600 text-white shadow-sm hover:bg-red-700 focus:ring-red-400',
        'ghost' => 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white',
        'link' => 'text-brand hover:text-brand-dark p-0',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-5 py-2.5 text-base',
    ];

    $classes = $base.' '.($variants[$variant] ?? $variants['primary']).' '.($variant === 'link' ? '' : ($sizes[$size] ?? $sizes['md']));
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->class($classes) }}>{{ $slot }}</button>
@endif
