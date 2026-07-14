@props([
    'label',
    'name',
])

<div {{ $attributes->class('w-full space-y-1.5 sm:w-40') }}>
    <label for="filter-{{ $name }}" class="block text-sm font-medium text-slate-700 dark:text-slate-300">{{ $label }}</label>
    <input
        id="filter-{{ $name }}"
        type="date"
        name="{{ $name }}"
        value="{{ request($name) }}"
        class="admin-input"
    >
</div>
