@props([
    'action',
    'search' => true,
    'searchPlaceholder' => 'Search…',
])

@php
    $hasActive = collect(request()->except('page'))->filter(fn ($v) => filled($v))->isNotEmpty();
@endphp

<form method="GET" action="{{ $action }}" {{ $attributes->class('mb-5 rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900') }}>
    <div class="flex flex-col gap-3 lg:flex-row lg:items-end">
        @if ($search)
            <div class="min-w-0 flex-1 space-y-1.5">
                <label for="filter-search" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Search</label>
                <input
                    id="filter-search"
                    type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="{{ $searchPlaceholder }}"
                    class="admin-input"
                >
            </div>
        @endif

        {{ $slot }}

        <div class="flex shrink-0 flex-wrap items-center gap-2">
            <x-admin.button type="submit" size="sm">Filter</x-admin.button>
            @if ($hasActive)
                <x-admin.button variant="secondary" size="sm" :href="$action">Clear</x-admin.button>
            @endif
        </div>
    </div>
</form>
