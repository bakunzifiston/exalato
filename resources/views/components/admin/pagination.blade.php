@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex flex-wrap items-center justify-between gap-3">
        <p class="text-sm text-slate-500 dark:text-slate-400">
            Showing
            <span class="font-medium text-slate-700 dark:text-slate-200">{{ $paginator->firstItem() }}</span>
            to
            <span class="font-medium text-slate-700 dark:text-slate-200">{{ $paginator->lastItem() }}</span>
            of
            <span class="font-medium text-slate-700 dark:text-slate-200">{{ $paginator->total() }}</span>
            results
        </p>

        <div class="flex items-center gap-1">
            @if ($paginator->onFirstPage())
                <span class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm text-slate-400 dark:border-slate-700">Previous</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-700">Previous</a>
            @endif

            @foreach ($paginator->getUrlRange(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2)) as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="rounded-lg bg-brand px-3 py-1.5 text-sm font-medium text-white">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-700">{{ $page }}</a>
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-700">Next</a>
            @else
                <span class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm text-slate-400 dark:border-slate-700">Next</span>
            @endif
        </div>
    </nav>
@endif
