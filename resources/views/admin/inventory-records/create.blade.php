@extends('admin.layouts.app')

@section('title', 'Create Inventory Record')

@section('breadcrumbs')
    <x-admin.breadcrumbs :items="[['label' => 'Inventory Records', 'url' => route('admin.inventory-records.index')], ['label' => 'Create']]" />
@endsection

@section('content')
    <x-admin.page-header title="Create Inventory Record" :search="false" />
    <x-admin.card class="max-w-3xl">
        @include('admin.inventory-records._form', ['action' => route('admin.inventory-records.store'), 'submitLabel' => 'Create'])
    </x-admin.card>
@endsection
