@extends('admin.layouts.app')

@section('title', 'Productions')

@section('breadcrumbs')
    <x-admin.breadcrumbs :items="[['label' => 'Productions']]" />
@endsection

@section('content')
    <x-admin.page-header title="Productions" description="Track production batches and output." :create-url="route('admin.productions.create')" create-label="New Production" />

    <x-admin.kpi-grid :kpis="$kpis" />

    <x-admin.filters :action="route('admin.productions.index')" search-placeholder="Search batch, barcode, staff…">
        <x-admin.filter-select label="Product" name="product_id" :options="$productOptions" />
        <x-admin.filter-date label="From" name="from" />
        <x-admin.filter-date label="To" name="to" />
    </x-admin.filters>

    <form method="POST" action="{{ route('admin.productions.bulk-destroy') }}" x-data="{ selected: [] }">
        @csrf
        <div class="mb-3" x-show="selected.length" x-cloak>
            <x-admin.button variant="danger" size="sm" type="button" onclick="adminConfirmDelete(this.closest('form'), 'Delete selected productions?')">Delete selected</x-admin.button>
        </div>

        @if ($productions->count())
            <x-admin.table>
                <x-slot:head>
                    <tr>
                        <x-admin.table-head class="w-10"><input type="checkbox" class="rounded border-slate-300 text-brand focus:ring-brand dark:border-slate-600" @change="selected = $event.target.checked ? [...$el.closest('table').querySelectorAll('[data-row-id]')].map(el => el.value) : []"></x-admin.table-head>
                        <x-admin.table-head>Batch ID</x-admin.table-head>
                        <x-admin.table-head>Product</x-admin.table-head>
                        <x-admin.table-head>Quantity</x-admin.table-head>
                        <x-admin.table-head>Date</x-admin.table-head>
                        <x-admin.table-head>Barcode</x-admin.table-head>
                        <x-admin.table-head>Actions</x-admin.table-head>
                    </tr>
                </x-slot:head>
                @foreach ($productions as $production)
                    <x-admin.table-row>
                        <x-admin.table-cell><input type="checkbox" name="ids[]" value="{{ $production->id }}" data-row-id x-model="selected" class="rounded border-slate-300 text-brand focus:ring-brand dark:border-slate-600"></x-admin.table-cell>
                        <x-admin.table-cell class="font-medium">{{ $production->batch_id }}</x-admin.table-cell>
                        <x-admin.table-cell>{{ $production->product?->name }} · {{ $production->product?->type }}</x-admin.table-cell>
                        <x-admin.table-cell>{{ $production->quantity_produced }} bottles</x-admin.table-cell>
                        <x-admin.table-cell>{{ $production->production_date }}</x-admin.table-cell>
                        <x-admin.table-cell>{{ $production->barcode }}</x-admin.table-cell>
                        <x-admin.table-cell>
                            <x-admin.row-actions :show-url="route('admin.productions.show', $production)" :edit-url="route('admin.productions.edit', $production)" />
                        </x-admin.table-cell>
                    </x-admin.table-row>
                @endforeach
            </x-admin.table>
        @else
            <x-admin.empty-state title="No productions found" :action-url="route('admin.productions.create')" action-label="New Production" />
        @endif
    </form>

    @if ($productions->hasPages())
        <div class="mt-4"><x-admin.pagination :paginator="$productions" /></div>
    @endif
@endsection
