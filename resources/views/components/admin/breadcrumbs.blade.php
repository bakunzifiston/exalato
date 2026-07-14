@props([
    'items' => [],
])

@if (count($items))
    <nav aria-label="Breadcrumb" class="mb-5">
        <ol class="flex flex-wrap items-center gap-1.5 text-sm text-slate-500 dark:text-slate-400">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="transition hover:text-brand">Home</a>
            </li>
            @foreach ($items as $item)
                <li class="flex items-center gap-1.5">
                    <span class="text-slate-300 dark:text-slate-600">/</span>
                    @if (! empty($item['url']))
                        <a href="{{ $item['url'] }}" class="transition hover:text-brand">{{ $item['label'] }}</a>
                    @else
                        <span class="font-medium text-slate-700 dark:text-slate-200">{{ $item['label'] }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
