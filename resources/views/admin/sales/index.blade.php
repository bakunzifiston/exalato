@extends('admin.layouts.app')

@section('title', 'Sales')

@section('breadcrumbs')
    <x-admin.breadcrumbs :items="[['label' => 'Sales']]" />
@endsection

@section('content')
    <x-admin.page-header title="Sales" description="Track customer orders and revenue." :create-url="route('admin.sales.create')" create-label="New Sale" />

    <x-admin.kpi-grid :kpis="$kpis" />

    <x-admin.filters :action="route('admin.sales.index')" search-placeholder="Search sale ID, customer, invoice…">
        <x-admin.filter-select label="Product" name="product_id" :options="$productOptions" />
        <x-admin.filter-select label="Payment" name="payment_status" :options="$paymentStatusOptions" />
        <x-admin.filter-select label="Delivery" name="delivery_status" :options="$deliveryStatusOptions" />
        <x-admin.filter-select label="Channel" name="sales_channel" :options="$salesChannelOptions" />
        <x-admin.filter-date label="From" name="from" />
        <x-admin.filter-date label="To" name="to" />
    </x-admin.filters>

    <form method="POST" action="{{ route('admin.sales.bulk-destroy') }}" x-data="{ selected: [] }">
        @csrf
        <div class="mb-3" x-show="selected.length" x-cloak>
            <x-admin.button variant="danger" size="sm" type="button" onclick="adminConfirmDelete(this.closest('form'), 'Delete selected sales?')">Delete selected</x-admin.button>
        </div>

        @if ($sales->count())
            <x-admin.table>
                <x-slot:head>
                    <tr>
                        <x-admin.table-head class="w-10"><input type="checkbox" class="rounded border-slate-300 text-brand focus:ring-brand dark:border-slate-600" @change="selected = $event.target.checked ? [...$el.closest('table').querySelectorAll('[data-row-id]')].map(el => el.value) : []"></x-admin.table-head>
                        <x-admin.table-head>Sales ID</x-admin.table-head>
                        <x-admin.table-head>Customer</x-admin.table-head>
                        <x-admin.table-head>Product</x-admin.table-head>
                        <x-admin.table-head>Batch</x-admin.table-head>
                        <x-admin.table-head>Qty</x-admin.table-head>
                        <x-admin.table-head>Revenue</x-admin.table-head>
                        <x-admin.table-head>Status</x-admin.table-head>
                        <x-admin.table-head>Date</x-admin.table-head>
                        <x-admin.table-head>Actions</x-admin.table-head>
                    </tr>
                </x-slot:head>
                @foreach ($sales as $sale)
                    <x-admin.table-row>
                        <x-admin.table-cell><input type="checkbox" name="ids[]" value="{{ $sale->id }}" data-row-id x-model="selected" class="rounded border-slate-300 text-brand focus:ring-brand dark:border-slate-600"></x-admin.table-cell>
                        <x-admin.table-cell class="font-medium">{{ $sale->sales_id }}</x-admin.table-cell>
                        <x-admin.table-cell>{{ $sale->customer_name }}</x-admin.table-cell>
                        <x-admin.table-cell>{{ $sale->product?->name }}</x-admin.table-cell>
                        <x-admin.table-cell>{{ $sale->production?->batch_id }}</x-admin.table-cell>
                        <x-admin.table-cell>{{ $sale->quantity_sold }} bottles</x-admin.table-cell>
                        <x-admin.table-cell>{{ number_format($sale->total_revenue, 2) }} Rwf</x-admin.table-cell>
                        <x-admin.table-cell>
                            <x-admin.badge :color="$sale->payment_status === 'Paid' ? 'success' : ($sale->payment_status === 'Pending' ? 'warning' : 'info')">{{ $sale->payment_status }}</x-admin.badge>
                        </x-admin.table-cell>
                        <x-admin.table-cell>{{ $sale->sale_date }}</x-admin.table-cell>
                        <x-admin.table-cell>
                            <x-admin.row-actions :show-url="route('admin.sales.show', $sale)" :edit-url="route('admin.sales.edit', $sale)" />
                        </x-admin.table-cell>
                    </x-admin.table-row>
                @endforeach
            </x-admin.table>
        @else
            <x-admin.empty-state title="No sales found" :action-url="route('admin.sales.create')" action-label="New Sale" />
        @endif
    </form>

    @if ($sales->hasPages())
        <div class="mt-4"><x-admin.pagination :paginator="$sales" /></div>
    @endif
@endsection
