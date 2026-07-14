@extends('admin.layouts.app')

@section('title', 'Create Employee')

@section('breadcrumbs')
    <x-admin.breadcrumbs :items="[['label' => 'Employees', 'url' => route('admin.employees.index')], ['label' => 'Create']]" />
@endsection

@section('content')
    <x-admin.page-header title="Create Employee" :search="false" />
    <x-admin.card class="max-w-3xl">
        @include('admin.employees._form', [
            'action' => route('admin.employees.store'),
            'submitLabel' => 'Create',
            'employee' => null,
            'provinces' => $provinces,
            'districtsByProvince' => $districtsByProvince,
        ])
    </x-admin.card>
@endsection
