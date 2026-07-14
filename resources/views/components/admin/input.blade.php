@props([
    'label',
    'name',
    'type' => 'text',
    'value' => null,
    'required' => false,
    'readonly' => false,
    'step' => null,
    'placeholder' => null,
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
    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ $fieldValue }}"
        @if ($placeholder) placeholder="{{ $placeholder }}" @endif
        @if ($required) required @endif
        @if ($readonly) readonly @endif
        @if ($step) step="{{ $step }}" @endif
        @class([
            'admin-input',
            'admin-input-readonly' => $readonly,
        ])
    >
    @if ($hint)
        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $hint }}</p>
    @endif
    @error($name)
        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>
