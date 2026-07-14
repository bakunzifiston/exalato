@extends('admin.layouts.app')

@section('title', 'Edit Inventory Record')

@section('breadcrumbs')
    <x-admin.breadcrumbs :items="[['label' => 'Inventory Records', 'url' => route('admin.inventory-records.index')], ['label' => 'Edit']]" />
@endsection

@section('content')
    <x-admin.page-header title="Edit Inventory Record" :search="false" />
    <x-admin.card class="max-w-3xl">
        @include('admin.inventory-records._form', ['action' => route('admin.inventory-records.update', $inventoryRecord), 'method' => 'PUT', 'submitLabel' => 'Save', 'inventoryRecord' => $inventoryRecord])
    </x-admin.card>
    <div class="mt-4 max-w-3xl"><x-admin.delete-button :action="route('admin.inventory-records.destroy', $inventoryRecord)" message="Delete this inventory record?" /></div>
@endsection
