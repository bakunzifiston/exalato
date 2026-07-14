@extends('admin.layouts.app')

@section('title', 'Inventory Records')

@section('breadcrumbs')
    <x-admin.breadcrumbs :items="[['label' => 'Inventory Records']]" />
@endsection

@section('content')
    <x-admin.page-header title="Inventory Records" description="Supplier stock in/out ledger." :create-url="route('admin.inventory-records.create')" create-label="New Record" />

    <x-admin.kpi-grid :kpis="$kpis" />

    <x-admin.filters :action="route('admin.inventory-records.index')" search-placeholder="Search item, supplier, location…">
        <x-admin.filter-select label="Item type" name="item_type" :options="$itemTypeOptions" />
        <x-admin.filter-date label="From" name="from" />
        <x-admin.filter-date label="To" name="to" />
    </x-admin.filters>

    <form method="POST" action="{{ route('admin.inventory-records.bulk-destroy') }}" x-data="{ selected: [] }">
        @csrf
        <div class="mb-3" x-show="selected.length" x-cloak>
            <x-admin.button variant="danger" size="sm" type="button" onclick="adminConfirmDelete(this.closest('form'), 'Delete selected records?')">Delete selected</x-admin.button>
        </div>

        @if ($records->count())
            <x-admin.table>
                <x-slot:head>
                    <tr>
                        <x-admin.table-head class="w-10"><input type="checkbox" class="rounded border-slate-300 text-brand focus:ring-brand dark:border-slate-600" @change="selected = $event.target.checked ? [...$el.closest('table').querySelectorAll('[data-row-id]')].map(el => el.value) : []"></x-admin.table-head>
                        <x-admin.table-head>Supplier</x-admin.table-head>
                        <x-admin.table-head>Type</x-admin.table-head>
                        <x-admin.table-head>Item</x-admin.table-head>
                        <x-admin.table-head>Qty In</x-admin.table-head>
                        <x-admin.table-head>Qty Out</x-admin.table-head>
                        <x-admin.table-head>Date</x-admin.table-head>
                        <x-admin.table-head>Actions</x-admin.table-head>
                    </tr>
                </x-slot:head>
                @foreach ($records as $record)
                    <x-admin.table-row>
                        <x-admin.table-cell><input type="checkbox" name="ids[]" value="{{ $record->id }}" data-row-id x-model="selected" class="rounded border-slate-300 text-brand focus:ring-brand dark:border-slate-600"></x-admin.table-cell>
                        <x-admin.table-cell>{{ $record->supplier_name }}</x-admin.table-cell>
                        <x-admin.table-cell><x-admin.badge>{{ $record->item_type }}</x-admin.badge></x-admin.table-cell>
                        <x-admin.table-cell>{{ $record->item_name }}</x-admin.table-cell>
                        <x-admin.table-cell>{{ $record->quantity_in }} L</x-admin.table-cell>
                        <x-admin.table-cell>{{ $record->quantity_out }} L</x-admin.table-cell>
                        <x-admin.table-cell>{{ $record->record_date }}</x-admin.table-cell>
                        <x-admin.table-cell>
                            <x-admin.row-actions :show-url="route('admin.inventory-records.show', $record)" :edit-url="route('admin.inventory-records.edit', $record)" />
                        </x-admin.table-cell>
                    </x-admin.table-row>
                @endforeach
            </x-admin.table>
        @else
            <x-admin.empty-state title="No inventory records found" :action-url="route('admin.inventory-records.create')" action-label="New Record" />
        @endif
    </form>

    @if ($records->hasPages())
        <div class="mt-4"><x-admin.pagination :paginator="$records" /></div>
    @endif
@endsection
