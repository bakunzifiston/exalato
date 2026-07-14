<div
    class="pointer-events-none fixed right-4 top-4 z-[70] flex w-full max-w-sm flex-col gap-2"
    aria-live="polite"
    aria-atomic="true"
>
    <template x-for="toast in $store.toasts.items" :key="toast.id">
        <div
            x-show="true"
            x-transition
            class="pointer-events-auto rounded-lg border px-4 py-3 shadow-lg"
            :class="{
                'border-emerald-200 bg-emerald-50 text-emerald-800 dark:border-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-200': toast.type === 'success',
                'border-red-200 bg-red-50 text-red-800 dark:border-red-800 dark:bg-red-900/40 dark:text-red-200': toast.type === 'error',
                'border-amber-200 bg-amber-50 text-amber-800 dark:border-amber-800 dark:bg-amber-900/40 dark:text-amber-200': toast.type === 'warning',
                'border-sky-200 bg-sky-50 text-sky-800 dark:border-sky-800 dark:bg-sky-900/40 dark:text-sky-200': toast.type === 'info',
            }"
        >
            <div class="flex items-start justify-between gap-3">
                <p class="text-sm font-medium" x-text="toast.message"></p>
                <button type="button" class="text-current/70 hover:text-current" @click="$store.toasts.remove(toast.id)">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </template>
</div>
