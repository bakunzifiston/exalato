@props([
    'title' => null,
    'description' => null,
    'createUrl' => null,
    'createLabel' => 'Create',
    'search' => true,
    'searchPlaceholder' => 'Search…',
])

<div {{ $attributes->class('mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between') }}>
    <div>
        @if ($title)
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-white">{{ $title }}</h1>
        @endif
        @if ($description)
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $description }}</p>
        @endif
    </div>

    <div class="flex shrink-0 flex-col gap-2 sm:flex-row sm:items-center">
        @if ($search)
            <form method="GET" class="relative w-full sm:w-64">
                <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z"/>
                </svg>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="{{ $searchPlaceholder }}" class="admin-input h-9 pl-9">
            </form>
        @endif

        @if ($createUrl)
            <x-admin.button :href="$createUrl" size="sm">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5"/></svg>
                {{ $createLabel }}
            </x-admin.button>
        @endif

        {{ $slot }}
    </div>
</div>
