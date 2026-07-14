@extends('admin.layouts.app')

@section('title', 'Edit Sale')

@section('breadcrumbs')
    <x-admin.breadcrumbs :items="[['label' => 'Sales', 'url' => route('admin.sales.index')], ['label' => $sale->sales_id, 'url' => route('admin.sales.show', $sale)], ['label' => 'Edit']]" />
@endsection

@section('content')
    <x-admin.page-header title="Edit Sale" :search="false" />
    <x-admin.card class="max-w-3xl">
        @include('admin.sales._form', [
            'action' => route('admin.sales.update', $sale),
            'method' => 'PUT',
            'submitLabel' => 'Save',
            'sale' => $sale,
            'products' => $products,
            'barcodes' => $barcodes,
            'productionsByProduct' => $productionsByProduct,
        ])
    </x-admin.card>
    <div class="mt-4 max-w-3xl">
        <x-admin.delete-button :action="route('admin.sales.destroy', $sale)" message="Delete this sale?" />
    </div>
@endsection
