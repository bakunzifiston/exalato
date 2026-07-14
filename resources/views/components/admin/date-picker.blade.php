@props([
    'label',
    'name',
    'value' => null,
    'required' => false,
    'min' => null,
    'max' => null,
])

<x-admin.input
    :label="$label"
    :name="$name"
    type="date"
    :value="$value"
    :required="$required"
    {{ $attributes }}
/>
