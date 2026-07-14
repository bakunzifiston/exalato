@props([
    'showUrl',
    'editUrl',
])

<div class="flex items-center gap-1.5">
    <x-admin.button variant="ghost" size="sm" :href="$showUrl">View</x-admin.button>
    <x-admin.button variant="secondary" size="sm" :href="$editUrl">Edit</x-admin.button>
</div>
