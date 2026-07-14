@extends('admin.layouts.app')

@section('title', 'Products')

@section('breadcrumbs')
    <x-admin.breadcrumbs :items="[['label' => 'Products']]" />
@endsection

@section('content')
    <x-admin.page-header
        title="Products"
        description="Manage finished goods and product catalog."
        :create-url="route('admin.products.create')"
        create-label="New Product"
    />

    <x-admin.kpi-grid :kpis="$kpis" />

    <x-admin.filters :action="route('admin.products.index')" search-placeholder="Search name, type, barcode…">
        <x-admin.filter-select label="Product" name="name" :options="$nameOptions" />
        <x-admin.filter-select label="Packaging" name="type" :options="$typeOptions" />
        <x-admin.filter-select label="Barcode" name="has_barcode" :options="['1' => 'With barcode', '0' => 'Without barcode']" />
    </x-admin.filters>

    <form method="POST" action="{{ route('admin.products.bulk-destroy') }}" x-data="{ selected: [] }">
        @csrf
        <div class="mb-3 flex items-center gap-2" x-show="selected.length" x-cloak>
            <x-admin.badge color="primary" x-text="`${selected.length} selected`"></x-admin.badge>
            <x-admin.button variant="danger" size="sm" type="button" onclick="adminConfirmDelete(this.closest('form'), 'Delete selected products?')">
                Delete selected
            </x-admin.button>
        </div>

        @if ($products->count())
            <x-admin.table>
                <x-slot:head>
                    <tr>
                        <x-admin.table-head class="w-10">
                            <input type="checkbox" class="rounded border-slate-300 text-brand focus:ring-brand dark:border-slate-600" @change="selected = $event.target.checked ? [...$el.closest('table').querySelectorAll('[data-row-id]')].map(el => el.value) : []">
                        </x-admin.table-head>
                        <x-admin.table-head>Name</x-admin.table-head>
                        <x-admin.table-head>Type</x-admin.table-head>
                        <x-admin.table-head>Barcode</x-admin.table-head>
                        <x-admin.table-head>Description</x-admin.table-head>
                        <x-admin.table-head>Actions</x-admin.table-head>
                    </tr>
                </x-slot:head>

                @foreach ($products as $product)
                    <x-admin.table-row>
                        <x-admin.table-cell>
                            <input type="checkbox" name="ids[]" value="{{ $product->id }}" data-row-id x-model="selected" class="rounded border-slate-300 text-brand focus:ring-brand dark:border-slate-600">
                        </x-admin.table-cell>
                        <x-admin.table-cell class="font-medium text-slate-900 dark:text-white">{{ $product->name }}</x-admin.table-cell>
                        <x-admin.table-cell>{{ $product->type }}</x-admin.table-cell>
                        <x-admin.table-cell>{{ $product->barcode ?: '—' }}</x-admin.table-cell>
                        <x-admin.table-cell class="max-w-xs truncate">{{ $product->description ?: '—' }}</x-admin.table-cell>
                        <x-admin.table-cell>
                            <x-admin.row-actions
                                :show-url="route('admin.products.show', $product)"
                                :edit-url="route('admin.products.edit', $product)"
                            />
                        </x-admin.table-cell>
                    </x-admin.table-row>
                @endforeach
            </x-admin.table>
        @else
            <x-admin.empty-state
                title="No products found"
                description="Create your first product to get started."
                :action-url="route('admin.products.create')"
                action-label="New Product"
            />
        @endif
    </form>

    @if ($products->hasPages())
        <div class="mt-4">
            <x-admin.pagination :paginator="$products" />
        </div>
    @endif
@endsection
