@props([
    'action',
    'message' => 'Delete this record?',
    'label' => 'Delete',
])

<form method="POST" action="{{ $action }}" {{ $attributes }}>
    @csrf
    @method('DELETE')
    <x-admin.button
        variant="danger"
        size="sm"
        type="button"
        onclick="adminConfirmDelete(this.closest('form'), @js($message))"
    >
        {{ $label }}
    </x-admin.button>
</form>
