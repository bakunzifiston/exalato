@extends('admin.layouts.app')

@section('title', 'Employees')

@section('breadcrumbs')
    <x-admin.breadcrumbs :items="[['label' => 'Employees']]" />
@endsection

@section('content')
    <x-admin.page-header
        title="Employees"
        description="Manage staff records and locations."
        :create-url="route('admin.employees.create')"
        create-label="New Employee"
    />

    <x-admin.kpi-grid :kpis="$kpis" />

    <x-admin.filters :action="route('admin.employees.index')" search-placeholder="Search name, ID, phone, email…">
        <x-admin.filter-select label="Position" name="position" :options="$positionOptions" />
        <x-admin.filter-select label="Province" name="province" :options="$provinces" />
        <x-admin.filter-select label="District" name="district" :options="$districtOptions" />
    </x-admin.filters>

    <form method="POST" action="{{ route('admin.employees.bulk-destroy') }}" x-data="{ selected: [] }">
        @csrf
        <div class="mb-3" x-show="selected.length" x-cloak>
            <x-admin.button variant="danger" size="sm" type="button" onclick="adminConfirmDelete(this.closest('form'), 'Delete selected employees?')">Delete selected</x-admin.button>
        </div>

        @if ($employees->count())
            <x-admin.table>
                <x-slot:head>
                    <tr>
                        <x-admin.table-head class="w-10"><input type="checkbox" class="rounded border-slate-300 text-brand focus:ring-brand dark:border-slate-600" @change="selected = $event.target.checked ? [...$el.closest('table').querySelectorAll('[data-row-id]')].map(el => el.value) : []"></x-admin.table-head>
                        <x-admin.table-head>Employee ID</x-admin.table-head>
                        <x-admin.table-head>Name</x-admin.table-head>
                        <x-admin.table-head>Position</x-admin.table-head>
                        <x-admin.table-head>Phone</x-admin.table-head>
                        <x-admin.table-head>Email</x-admin.table-head>
                        <x-admin.table-head>Province</x-admin.table-head>
                        <x-admin.table-head>District</x-admin.table-head>
                        <x-admin.table-head>Actions</x-admin.table-head>
                    </tr>
                </x-slot:head>
                @foreach ($employees as $employee)
                    <x-admin.table-row>
                        <x-admin.table-cell><input type="checkbox" name="ids[]" value="{{ $employee->id }}" data-row-id x-model="selected" class="rounded border-slate-300 text-brand focus:ring-brand dark:border-slate-600"></x-admin.table-cell>
                        <x-admin.table-cell>{{ $employee->employee_id }}</x-admin.table-cell>
                        <x-admin.table-cell class="font-medium">{{ $employee->name }}</x-admin.table-cell>
                        <x-admin.table-cell>{{ $employee->position ?: '—' }}</x-admin.table-cell>
                        <x-admin.table-cell>{{ $employee->phone ?: '—' }}</x-admin.table-cell>
                        <x-admin.table-cell>{{ $employee->email ?: '—' }}</x-admin.table-cell>
                        <x-admin.table-cell>{{ $employee->province ?: '—' }}</x-admin.table-cell>
                        <x-admin.table-cell>{{ $employee->district ?: '—' }}</x-admin.table-cell>
                        <x-admin.table-cell>
                            <x-admin.row-actions :show-url="route('admin.employees.show', $employee)" :edit-url="route('admin.employees.edit', $employee)" />
                        </x-admin.table-cell>
                    </x-admin.table-row>
                @endforeach
            </x-admin.table>
        @else
            <x-admin.empty-state title="No employees found" :action-url="route('admin.employees.create')" action-label="New Employee" />
        @endif
    </form>

    @if ($employees->hasPages())
        <div class="mt-4"><x-admin.pagination :paginator="$employees" /></div>
    @endif
@endsection
