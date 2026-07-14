<div
    x-cloak
    x-show="$store.confirm.open"
    x-transition.opacity
    class="fixed inset-0 z-[60] flex items-center justify-center p-4"
    role="alertdialog"
    aria-modal="true"
>
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="$store.confirm.cancel()"></div>
    <div
        x-show="$store.confirm.open"
        x-transition
        class="relative w-full max-w-md rounded-xl border border-slate-200 bg-white p-6 shadow-2xl dark:border-slate-700 dark:bg-slate-800"
    >
        <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-full bg-red-100 text-red-600 dark:bg-red-900/40 dark:text-red-300">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-slate-900 dark:text-white" x-text="$store.confirm.title"></h3>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300" x-text="$store.confirm.message"></p>
        <div class="mt-6 flex justify-end gap-2">
            <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700" @click="$store.confirm.cancel()" x-text="$store.confirm.cancelLabel"></button>
            <button type="button" class="inline-flex items-center justify-center rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700" @click="$store.confirm.submit()" x-text="$store.confirm.confirmLabel"></button>
        </div>
    </div>
</div>
