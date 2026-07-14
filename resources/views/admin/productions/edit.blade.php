@extends('admin.layouts.app')

@section('title', 'Edit Production')

@section('breadcrumbs')
    <x-admin.breadcrumbs :items="[['label' => 'Productions', 'url' => route('admin.productions.index')], ['label' => $production->batch_id, 'url' => route('admin.productions.show', $production)], ['label' => 'Edit']]" />
@endsection

@section('content')
    <x-admin.page-header title="Edit Production" :search="false" />
    <x-admin.card class="max-w-3xl">
        @include('admin.productions._form', ['action' => route('admin.productions.update', $production), 'method' => 'PUT', 'submitLabel' => 'Save', 'production' => $production, 'products' => $products, 'barcodes' => $barcodes])
    </x-admin.card>
    <div class="mt-4 max-w-3xl"><x-admin.delete-button :action="route('admin.productions.destroy', $production)" message="Delete this production?" /></div>
@endsection
