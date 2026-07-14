@extends('admin.layouts.app')

@section('title', 'Create Production')

@section('breadcrumbs')
    <x-admin.breadcrumbs :items="[['label' => 'Productions', 'url' => route('admin.productions.index')], ['label' => 'Create']]" />
@endsection

@section('content')
    <x-admin.page-header title="Create Production" :search="false" />
    <x-admin.card class="max-w-3xl">
        @include('admin.productions._form', ['action' => route('admin.productions.store'), 'submitLabel' => 'Create', 'products' => $products, 'barcodes' => $barcodes])
    </x-admin.card>
@endsection
