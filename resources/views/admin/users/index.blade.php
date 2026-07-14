@extends('admin.layouts.app')

@section('title', 'Users')

@section('breadcrumbs')
    <x-admin.breadcrumbs :items="[['label' => 'Users']]" />
@endsection

@section('content')
    <x-admin.page-header title="Users" description="Manage admin accounts." :create-url="route('admin.users.create')" create-label="New User" />

    <x-admin.kpi-grid :kpis="$kpis" />

    <x-admin.filters :action="route('admin.users.index')" search-placeholder="Search name or email…">
        <x-admin.filter-select label="Status" name="verified" :options="$verifiedOptions" />
    </x-admin.filters>

    <form method="POST" action="{{ route('admin.users.bulk-destroy') }}" x-data="{ selected: [] }">
        @csrf
        <div class="mb-3" x-show="selected.length" x-cloak>
            <x-admin.button variant="danger" size="sm" type="button" onclick="adminConfirmDelete(this.closest('form'), 'Delete selected users?')">Delete selected</x-admin.button>
        </div>

        @if ($users->count())
            <x-admin.table>
                <x-slot:head>
                    <tr>
                        <x-admin.table-head class="w-10"><input type="checkbox" class="rounded border-slate-300 text-brand focus:ring-brand dark:border-slate-600" @change="selected = $event.target.checked ? [...$el.closest('table').querySelectorAll('[data-row-id]')].map(el => el.value) : []"></x-admin.table-head>
                        <x-admin.table-head>Name</x-admin.table-head>
                        <x-admin.table-head>Email</x-admin.table-head>
                        <x-admin.table-head>Verified</x-admin.table-head>
                        <x-admin.table-head>Actions</x-admin.table-head>
                    </tr>
                </x-slot:head>
                @foreach ($users as $user)
                    <x-admin.table-row>
                        <x-admin.table-cell><input type="checkbox" name="ids[]" value="{{ $user->id }}" data-row-id x-model="selected" class="rounded border-slate-300 text-brand focus:ring-brand dark:border-slate-600"></x-admin.table-cell>
                        <x-admin.table-cell class="font-medium">{{ $user->name }}</x-admin.table-cell>
                        <x-admin.table-cell>{{ $user->email }}</x-admin.table-cell>
                        <x-admin.table-cell>
                            @if ($user->email_verified_at)
                                <x-admin.badge color="success">Verified</x-admin.badge>
                            @else
                                <x-admin.badge color="warning">Pending</x-admin.badge>
                            @endif
                        </x-admin.table-cell>
                        <x-admin.table-cell>
                            <x-admin.row-actions :show-url="route('admin.users.show', $user)" :edit-url="route('admin.users.edit', $user)" />
                        </x-admin.table-cell>
                    </x-admin.table-row>
                @endforeach
            </x-admin.table>
        @else
            <x-admin.empty-state title="No users found" :action-url="route('admin.users.create')" action-label="New User" />
        @endif
    </form>

    @if ($users->hasPages())
        <div class="mt-4"><x-admin.pagination :paginator="$users" /></div>
    @endif
@endsection
