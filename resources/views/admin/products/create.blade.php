@extends('admin.layouts.app')

@section('title', 'Create Product')

@section('breadcrumbs')
    <x-admin.breadcrumbs :items="[
        ['label' => 'Products', 'url' => route('admin.products.index')],
        ['label' => 'Create'],
    ]" />
@endsection

@section('content')
    <x-admin.page-header title="Create Product" :search="false" />

    <x-admin.card class="max-w-3xl">
        <x-admin.form method="POST" action="{{ route('admin.products.store') }}">
            <x-admin.input label="Name" name="type" :required="true" />
            <x-admin.input label="Type" name="name" :required="true" />
            <x-admin.input label="Barcode" name="barcode" />
            <x-admin.input label="Description" name="description" />

            <div class="flex flex-wrap gap-3 pt-2">
                <x-admin.button type="submit">Create</x-admin.button>
                <x-admin.button variant="secondary" :href="route('admin.products.index')">Cancel</x-admin.button>
            </div>
        </x-admin.form>
    </x-admin.card>
@endsection
