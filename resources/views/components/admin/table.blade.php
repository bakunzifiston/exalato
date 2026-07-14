@props([
    'selectable' => false,
])

<div {{ $attributes->class('overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800') }}>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            @isset($head)
                <thead class="admin-table-head">
                    {{ $head }}
                </thead>
            @endisset
            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
