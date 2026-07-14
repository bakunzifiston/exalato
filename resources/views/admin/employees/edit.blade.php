@extends('admin.layouts.app')

@section('title', 'Edit Employee')

@section('breadcrumbs')
    <x-admin.breadcrumbs :items="[['label' => 'Employees', 'url' => route('admin.employees.index')], ['label' => $employee->name, 'url' => route('admin.employees.show', $employee)], ['label' => 'Edit']]" />
@endsection

@section('content')
    <x-admin.page-header title="Edit Employee" :search="false" />
    <x-admin.card class="max-w-3xl">
        @include('admin.employees._form', [
            'action' => route('admin.employees.update', $employee),
            'method' => 'PUT',
            'submitLabel' => 'Save',
            'employee' => $employee,
            'provinces' => $provinces,
            'districtsByProvince' => $districtsByProvince,
        ])
    </x-admin.card>
    <div class="mt-4 max-w-3xl">
        <x-admin.delete-button :action="route('admin.employees.destroy', $employee)" message="Delete this employee?" />
    </div>
@endsection
