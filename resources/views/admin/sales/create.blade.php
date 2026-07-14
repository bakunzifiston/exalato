@extends('admin.layouts.app')

@section('title', 'Create Sale')

@section('breadcrumbs')
    <x-admin.breadcrumbs :items="[['label' => 'Sales', 'url' => route('admin.sales.index')], ['label' => 'Create']]" />
@endsection

@section('content')
    <x-admin.page-header title="Create Sale" :search="false" />
    <x-admin.card class="max-w-3xl">
        @include('admin.sales._form', [
            'action' => route('admin.sales.store'),
            'submitLabel' => 'Create',
            'products' => $products,
            'barcodes' => $barcodes,
            'productionsByProduct' => $productionsByProduct,
        ])
    </x-admin.card>
@endsection
