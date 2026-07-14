@props([
    'label',
    'name',
    'options' => [],
    'value' => null,
    'required' => false,
    'placeholder' => 'Select…',
    'hint' => null,
])

@php
    $fieldValue = old($name, $value);
@endphp

<div {{ $attributes->class('space-y-1.5') }}>
    <label for="{{ $name }}" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
        {{ $label }}
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    <select
        id="{{ $name }}"
        name="{{ $name }}"
        @if ($required) required @endif
        class="admin-input"
    >
        <option value="">{{ $placeholder }}</option>
        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @selected((string) $fieldValue === (string) $optionValue)>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>
    @if ($hint)
        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $hint }}</p>
    @endif
    @error($name)
        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>
