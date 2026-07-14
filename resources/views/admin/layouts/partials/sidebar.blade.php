@php
    $links = [
        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'match' => 'admin.dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4'],
        ['route' => 'admin.products.index', 'label' => 'Products', 'match' => 'admin.products.*', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10'],
        ['route' => 'admin.employees.index', 'label' => 'Employees', 'match' => 'admin.employees.*', 'icon' => 'M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m0-6a4 4 0 110 8'],
        ['route' => 'admin.productions.index', 'label' => 'Productions', 'match' => 'admin.productions.*', 'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9H4m0 0V4'],
        ['route' => 'admin.inventory-records.index', 'label' => 'Inventory', 'match' => 'admin.inventory-records.*', 'icon' => 'M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8'],
        ['route' => 'admin.sales.index', 'label' => 'Sales', 'match' => 'admin.sales.*', 'icon' => 'M3 3v18h18M7 16l3-3 3 3 4-6'],
        ['route' => 'admin.users.index', 'label' => 'Users', 'match' => 'admin.users.*', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1'],
    ];

    $user = auth()->user();
@endphp

<aside
    class="fixed inset-y-0 left-0 z-40 flex w-[4.75rem] -translate-x-full flex-col bg-gradient-to-b from-brand-deeper via-brand-dark to-[#3a0a0d] text-white transition-transform lg:static lg:w-20 lg:translate-x-0 xl:w-64"
    :class="{ 'translate-x-0': sidebarOpen }"
>
    <div class="flex h-16 items-center justify-center gap-3 border-b border-white/10 px-3 xl:justify-start xl:px-5">
        <img src="{{ asset('images/logo.png') }}" alt="2ES Ltd" class="h-9 w-auto rounded-lg bg-white/95 object-contain p-0.5">
        <div class="hidden min-w-0 xl:block">
            <p class="truncate text-sm font-semibold tracking-wide">2ES Ltd</p>
            <p class="truncate text-[11px] text-white/60">Admin Panel</p>
        </div>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto p-2 xl:p-3">
        @foreach ($links as $link)
            <a
                href="{{ route($link['route']) }}"
                title="{{ $link['label'] }}"
                @class([
                    'flex items-center justify-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition xl:justify-start',
                    'bg-brand text-white shadow-lg shadow-black/20' => request()->routeIs($link['match']),
                    'text-white/70 hover:bg-white/10 hover:text-white' => ! request()->routeIs($link['match']),
                ])
            >
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $link['icon'] }}"/>
                </svg>
                <span class="hidden xl:inline">{{ $link['label'] }}</span>
            </a>
        @endforeach
    </nav>

    {{-- Account profile --}}
    <div class="border-t border-white/10 p-3 xl:p-4">
        <a
            href="{{ route('admin.users.edit', $user) }}"
            class="group block rounded-2xl bg-white/5 p-3 transition hover:bg-white/10"
            title="My profile"
        >
            {{-- Collapsed: image only --}}
            <div class="flex flex-col items-center xl:hidden">
                <x-admin.avatar :user="$user" size="md" class="ring-brand-accent/40" />
            </div>

            {{-- Expanded: full profile card --}}
            <div class="hidden xl:block">
                <div class="flex flex-col items-center text-center">
                    <x-admin.avatar :user="$user" size="xl" class="ring-2 ring-brand-accent/50 shadow-lg shadow-black/30" />
                    <p class="mt-3 truncate text-sm font-semibold text-white">{{ $user->name }}</p>
                    <p class="mt-0.5 truncate text-[11px] text-white/55">{{ $user->email }}</p>
                    <span class="mt-2 inline-flex rounded-full bg-brand-accent/20 px-2.5 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-brand-accent">
                        Admin
                    </span>
                </div>

                <div class="mt-3 flex items-center justify-center gap-2 border-t border-white/10 pt-3 text-[11px] text-white/60 group-hover:text-white">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    My profile
                </div>
            </div>
        </a>
    </div>
</aside>
