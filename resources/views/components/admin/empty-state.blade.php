@props([
    'title' => 'Nothing here yet',
    'description' => 'Get started by creating a new record.',
    'actionUrl' => null,
    'actionLabel' => 'Create',
])

<div {{ $attributes->class('flex flex-col items-center justify-center rounded-xl border border-dashed border-slate-300 bg-white px-6 py-14 text-center dark:border-slate-600 dark:bg-slate-800/50') }}>
    <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400 dark:bg-slate-700 dark:text-slate-300">
        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4m16 0H4"/>
        </svg>
    </div>
    <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">{{ $title }}</h3>
    <p class="mt-1 max-w-sm text-sm text-slate-500 dark:text-slate-400">{{ $description }}</p>
    @if ($actionUrl)
        <x-admin.button :href="$actionUrl" class="mt-5">{{ $actionLabel }}</x-admin.button>
    @endif
    {{ $slot }}
</div>
