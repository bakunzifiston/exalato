@props([
    'label',
    'name',
    'options' => [],
    'placeholder' => 'All',
])

<div {{ $attributes->class('w-full space-y-1.5 sm:w-44') }}>
    <label for="filter-{{ $name }}" class="block text-sm font-medium text-slate-700 dark:text-slate-300">{{ $label }}</label>
    <select id="filter-{{ $name }}" name="{{ $name }}" class="admin-input">
        <option value="">{{ $placeholder }}</option>
        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @selected((string) request($name) === (string) $optionValue)>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>
</div>
