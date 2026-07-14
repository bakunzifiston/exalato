@props([
    'user' => null,
    'size' => 'md',
])

@php
    $user = $user ?? auth()->user();
    $sizes = [
        'sm' => 'h-8 w-8',
        'md' => 'h-10 w-10',
        'lg' => 'h-14 w-14',
        'xl' => 'h-16 w-16',
    ];
    $px = [
        'sm' => 64,
        'md' => 80,
        'lg' => 112,
        'xl' => 128,
    ];
    $class = $sizes[$size] ?? $sizes['md'];
    $dim = $px[$size] ?? 80;
@endphp

<img
    src="{{ $user->avatarUrl($dim) }}"
    alt="{{ $user->name }}"
    {{ $attributes->class([$class, 'rounded-full object-cover ring-2 ring-white/20']) }}
/>
