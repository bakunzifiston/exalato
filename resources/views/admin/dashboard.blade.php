@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
    $productionChartConfig = json_encode([
        'type' => 'bar',
        'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        'values' => $productionChart,
        'label' => 'Units',
        'color' => '#9C3620',
    ], JSON_HEX_APOS | JSON_HEX_QUOT);

    $paymentChartConfig = json_encode([
        'type' => 'doughnut',
        'labels' => ['Paid', 'Pending', 'Credit'],
        'values' => [$paymentDonut['paid'], $paymentDonut['pending'], $paymentDonut['credit']],
        'colors' => ['#611215', '#9C3620', '#D37424'],
        'center' => $paymentDonut['percent'],
    ], JSON_HEX_APOS | JSON_HEX_QUOT);
@endphp

    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">Welcome back,</p>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-white">
                {{ auth()->user()->name }}
            </h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Production, inventory, and sales overview for 2ES Ltd.
            </p>
        </div>
        <a href="{{ route('admin.sales.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-brand-dark">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5"/></svg>
            New Sale
        </a>
    </div>

    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_20rem]">
        {{-- Main column --}}
        <div class="space-y-5">
            {{-- KPI row --}}
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($kpis as $kpi)
                    <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-xs font-medium uppercase tracking-wide text-slate-500 dark:text-slate-400">{{ $kpi['label'] }}</p>
                                <p class="mt-2 text-3xl font-semibold tracking-tight text-slate-900 dark:text-white">{{ $kpi['value'] }}</p>
                                <p class="mt-1 text-xs text-slate-400">{{ $kpi['hint'] }}</p>
                            </div>
                            <div class="rounded-xl bg-brand/10 p-2.5 text-brand">
                                @if ($kpi['icon'] === 'users')
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-6a4 4 0 11-8 0 4 4 0 018 0zm8 0a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                @elseif ($kpi['icon'] === 'box')
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
                                @elseif ($kpi['icon'] === 'beaker')
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 3h6m-5 0v5.586a1 1 0 01-.293.707l-4.414 4.414A2 2 0 005 15.414V19a2 2 0 002 2h10a2 2 0 002-2v-3.586a2 2 0 00-.586-1.414l-4.414-4.414A1 1 0 0114 8.586V3"/></svg>
                                @else
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 12v-2"/></svg>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Charts row --}}
            <div class="grid gap-5 lg:grid-cols-5">
                <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm lg:col-span-3 dark:border-slate-800 dark:bg-slate-900">
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Production Overview</h2>
                            <p class="text-xs text-slate-500">Monthly units produced</p>
                        </div>
                        <span class="rounded-full bg-brand/10 px-2.5 py-1 text-[11px] font-medium text-brand">This year</span>
                    </div>
                    <canvas
                        id="productionChart"
                        height="160"
                        data-dashboard-chart="{{ $productionChartConfig }}"
                    ></canvas>
                </div>

                <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm lg:col-span-2 dark:border-slate-800 dark:bg-slate-900">
                    <div class="mb-4">
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Payment Status</h2>
                        <p class="text-xs text-slate-500">Share of sales payments</p>
                    </div>
                    <div class="relative mx-auto max-w-[220px]">
                        <canvas
                            id="paymentDonut"
                            height="180"
                            data-dashboard-chart="{{ $paymentChartConfig }}"
                        ></canvas>
                        <div class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-3xl font-semibold text-brand-dark dark:text-white">{{ $paymentDonut['percent'] }}%</span>
                            <span class="text-[11px] uppercase tracking-wide text-slate-400">Paid</span>
                        </div>
                    </div>
                    <div class="mt-4 space-y-2 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-2 text-slate-600 dark:text-slate-300"><span class="h-2 w-2 rounded-full bg-brand-dark"></span> Paid</span>
                            <span class="font-medium">{{ $paymentDonut['paid'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-2 text-slate-600 dark:text-slate-300"><span class="h-2 w-2 rounded-full bg-brand"></span> Pending</span>
                            <span class="font-medium">{{ $paymentDonut['pending'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-2 text-slate-600 dark:text-slate-300"><span class="h-2 w-2 rounded-full bg-brand-accent"></span> Credit</span>
                            <span class="font-medium">{{ $paymentDonut['credit'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Production by product --}}
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Production by Product</h2>
                        <p class="text-xs text-slate-500">Remaining batch stock grouped by product</p>
                    </div>
                    <a href="{{ route('admin.productions.index') }}" class="text-xs font-medium text-brand hover:text-brand-dark">View all</a>
                </div>
                <div class="grid gap-3 sm:grid-cols-2">
                    @forelse ($productionByProduct as $item)
                        <div class="flex items-center gap-3 rounded-xl border border-slate-100 bg-slate-50/70 p-3 dark:border-slate-800 dark:bg-slate-800/40">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand/10 text-sm font-semibold text-brand">
                                {{ strtoupper(substr($item->product?->type ?? 'P', 0, 2)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-slate-900 dark:text-white">{{ $item->product?->type ?? 'Product' }}</p>
                                <p class="truncate text-xs text-slate-500">{{ $item->product?->name ?? 'Unknown' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ number_format($item->total, 0) }}</p>
                                <p class="text-[11px] text-slate-400">units</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500 sm:col-span-2">No production data yet.</p>
                    @endforelse
                </div>
            </div>

            {{-- Inventory overview --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 dark:border-slate-800">
                    <div>
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Inventory Overview</h2>
                        <p class="text-xs text-slate-500">Latest stock movements</p>
                    </div>
                    <a href="{{ route('admin.inventory-records.index') }}" class="text-xs font-medium text-brand hover:text-brand-dark">Manage</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="admin-table-head">
                            <tr>
                                <th class="px-5 py-3">Item</th>
                                <th class="px-5 py-3">Type</th>
                                <th class="px-5 py-3">Net Stock</th>
                                <th class="px-5 py-3">Location</th>
                                <th class="px-5 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse ($inventoryOverview as $row)
                                <tr class="admin-table-row">
                                    <td class="px-5 py-3 font-medium text-slate-900 dark:text-white">{{ $row['name'] }}</td>
                                    <td class="px-5 py-3 text-slate-500">{{ $row['type'] }}</td>
                                    <td class="px-5 py-3">{{ $row['stock'] }}</td>
                                    <td class="px-5 py-3 text-slate-500">{{ $row['location'] }}</td>
                                    <td class="px-5 py-3">
                                        @php
                                            $statusClass = match ($row['status']) {
                                                'Healthy' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
                                                'Low Stock' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
                                                default => 'bg-brand/10 text-brand',
                                            };
                                        @endphp
                                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-[11px] font-medium {{ $statusClass }}">{{ $row['status'] }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-8 text-center text-slate-500">No inventory records.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right rail --}}
        <aside class="space-y-5">
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Operations Score</h2>
                    <span class="rounded-full bg-brand/10 px-2 py-0.5 text-[11px] font-semibold text-brand">LIVE</span>
                </div>
                <div class="relative mx-auto my-4 h-36 w-36">
                    <svg viewBox="0 0 120 120" class="h-full w-full -rotate-90">
                        <circle cx="60" cy="60" r="50" fill="none" stroke="#f1f5f9" stroke-width="10"></circle>
                        <circle
                            cx="60" cy="60" r="50" fill="none"
                            stroke="#9C3620" stroke-width="10" stroke-linecap="round"
                            stroke-dasharray="{{ round(($paymentDonut['percent'] / 100) * 314) }} 314"
                        ></circle>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center rotate-0">
                        <span class="text-3xl font-semibold text-brand-dark dark:text-white">{{ $paymentDonut['percent'] }}</span>
                        <span class="text-[10px] uppercase tracking-wider text-slate-400">Score</span>
                    </div>
                </div>
                <p class="text-center text-xs text-slate-500">Based on paid sales ratio across all recorded orders.</p>
            </div>

            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Recent Sales</h2>
                    <a href="{{ route('admin.sales.index') }}" class="text-xs font-medium text-brand">All</a>
                </div>
                <div class="space-y-3">
                    @forelse ($recentSales as $sale)
                        <a href="{{ route('admin.sales.show', $sale) }}" class="flex items-center gap-3 rounded-xl p-2 transition hover:bg-slate-50 dark:hover:bg-slate-800/60">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-dark text-[10px] font-semibold text-white">
                                {{ strtoupper(substr($sale->product?->name ?? 'S', 0, 2)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-slate-900 dark:text-white">{{ $sale->customer_name }}</p>
                                <p class="truncate text-[11px] text-slate-500">{{ $sale->sales_id }} · {{ $sale->quantity_sold }} units</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-semibold text-slate-800 dark:text-slate-200">{{ number_format($sale->total_revenue, 0) }}</p>
                                <p class="text-[10px] text-slate-400">RWF</p>
                            </div>
                        </a>
                    @empty
                        <p class="text-sm text-slate-500">No sales yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h2 class="mb-4 text-sm font-semibold text-slate-900 dark:text-white">Alerts</h2>
                <div class="space-y-3">
                    <div class="rounded-xl border border-brand/20 bg-brand/5 p-3">
                        <div class="flex items-center justify-between gap-2">
                            <p class="text-sm font-medium text-brand-dark dark:text-brand-accent">Pending deliveries</p>
                            <span class="rounded-full bg-brand text-[11px] font-semibold text-white px-2 py-0.5">{{ $pendingDeliveries }}</span>
                        </div>
                        <p class="mt-1 text-xs text-slate-500">Orders waiting to leave the warehouse.</p>
                    </div>
                    <div class="rounded-xl border border-amber-200 bg-amber-50 p-3 dark:border-amber-900/40 dark:bg-amber-950/30">
                        <div class="flex items-center justify-between gap-2">
                            <p class="text-sm font-medium text-amber-800 dark:text-amber-300">Returned orders</p>
                            <span class="rounded-full bg-amber-600 text-[11px] font-semibold text-white px-2 py-0.5">{{ $returnedDeliveries }}</span>
                        </div>
                        <p class="mt-1 text-xs text-amber-700/80 dark:text-amber-400/80">May need inventory adjustments.</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-700 dark:bg-slate-800/50">
                        <p class="text-sm font-medium text-slate-800 dark:text-slate-200">Stock on hand</p>
                        <p class="mt-1 text-lg font-semibold text-brand">{{ number_format($currentStock, 0) }} units</p>
                        <p class="text-xs text-slate-500">Inventory in − inventory out</p>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl bg-gradient-to-br from-brand-deeper via-brand-dark to-brand p-5 text-white shadow-lg">
                <p class="text-xs uppercase tracking-wider text-white/70">Revenue</p>
                <p class="mt-2 text-3xl font-semibold">{{ number_format($totalRevenue, 0) }}</p>
                <p class="text-sm text-white/80">RWF total collected</p>
                <a href="{{ route('admin.sales.index') }}" class="mt-4 inline-flex rounded-lg bg-white/15 px-3 py-1.5 text-xs font-medium hover:bg-white/25">
                    Open sales →
                </a>
            </div>
        </aside>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (!window.Chart) return;

    const isDark = document.documentElement.classList.contains('dark');
    const tick = isDark ? '#94a3b8' : '#64748b';
    const grid = isDark ? '#1e293b' : '#e2e8f0';

    document.querySelectorAll('[data-dashboard-chart]').forEach((canvas) => {
        const config = JSON.parse(canvas.dataset.dashboardChart);

        if (config.type === 'doughnut') {
            new Chart(canvas, {
                type: 'doughnut',
                data: {
                    labels: config.labels,
                    datasets: [{
                        data: config.values,
                        backgroundColor: config.colors,
                        borderWidth: 0,
                        hoverOffset: 4,
                    }],
                },
                options: {
                    responsive: true,
                    cutout: '72%',
                    plugins: {
                        legend: { display: false },
                    },
                },
            });
            return;
        }

        new Chart(canvas, {
            type: config.type || 'bar',
            data: {
                labels: config.labels,
                datasets: [{
                    label: config.label,
                    data: config.values,
                    backgroundColor: config.color,
                    borderRadius: 8,
                    maxBarThickness: 28,
                }],
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { ticks: { color: tick }, grid: { display: false } },
                    y: { ticks: { color: tick }, grid: { color: grid }, beginAtZero: true },
                },
            },
        });
    });
});
</script>
@endpush
