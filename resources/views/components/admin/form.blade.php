@props([
    'method' => 'POST',
    'action' => null,
])

<form
    method="{{ in_array(strtoupper($method), ['GET', 'POST']) ? $method : 'POST' }}"
    @if ($action) action="{{ $action }}" @endif
    {{ $attributes->class('space-y-5') }}
>
    @if (! in_array(strtoupper($method), ['GET', 'POST']))
        @method($method)
    @endif
    @csrf
    {{ $slot }}
</form>
