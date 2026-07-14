@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('breadcrumbs')
    <x-admin.breadcrumbs :items="[
        ['label' => 'Products', 'url' => route('admin.products.index')],
        ['label' => $product->type, 'url' => route('admin.products.show', $product)],
        ['label' => 'Edit'],
    ]" />
@endsection

@section('content')
    <x-admin.page-header title="Edit Product" :search="false" />

    <x-admin.card class="max-w-3xl">
        <x-admin.form method="PUT" action="{{ route('admin.products.update', $product) }}">
            <x-admin.input label="Name" name="type" :value="$product->type" :required="true" />
            <x-admin.input label="Type" name="name" :value="$product->name" :required="true" />
            <x-admin.input label="Barcode" name="barcode" :value="$product->barcode" />
            <x-admin.input label="Description" name="description" :value="$product->description" />

            <div class="flex flex-wrap gap-3 pt-2">
                <x-admin.button type="submit">Save</x-admin.button>
                <x-admin.button variant="secondary" :href="route('admin.products.show', $product)">View</x-admin.button>
                <x-admin.button variant="secondary" :href="route('admin.products.index')">Cancel</x-admin.button>
            </div>
        </x-admin.form>
    </x-admin.card>

    <div class="mt-4 max-w-3xl">
        <x-admin.delete-button :action="route('admin.products.destroy', $product)" message="Delete this product?" />
    </div>
@endsection
