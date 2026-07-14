@extends('admin.layouts.app')

@section('title', 'View Employee')

@section('breadcrumbs')
    <x-admin.breadcrumbs :items="[['label' => 'Employees', 'url' => route('admin.employees.index')], ['label' => $employee->name]]" />
@endsection

@section('content')
    <x-admin.page-header title="Employee Details" :search="false">
        <x-admin.button :href="route('admin.employees.edit', $employee)">Edit</x-admin.button>
    </x-admin.page-header>

    <x-admin.card class="max-w-3xl">
        <dl class="grid gap-4 sm:grid-cols-2">
            @foreach ([
                'Employee ID' => $employee->employee_id,
                'Name' => $employee->name,
                'Position' => $employee->position ?: '—',
                'Phone' => $employee->phone ?: '—',
                'Email' => $employee->email ?: '—',
                'Province' => $employee->province ?: '—',
                'District' => $employee->district ?: '—',
            ] as $label => $value)
                <div>
                    <dt class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">{{ $label }}</dt>
                    <dd class="mt-1 text-sm">{{ $value }}</dd>
                </div>
            @endforeach
        </dl>
    </x-admin.card>
@endsection
