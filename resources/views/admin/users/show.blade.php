@extends('admin.layouts.app')

@section('title', 'View User')

@section('breadcrumbs')
    <x-admin.breadcrumbs :items="[['label' => 'Users', 'url' => route('admin.users.index')], ['label' => $user->name]]" />
@endsection

@section('content')
    <x-admin.page-header title="User Details" :search="false">
        <x-admin.button :href="route('admin.users.edit', $user)">Edit</x-admin.button>
    </x-admin.page-header>

    <x-admin.card class="max-w-3xl">
        <dl class="grid gap-4 sm:grid-cols-2">
            <div>
                <dt class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">Name</dt>
                <dd class="mt-1 text-sm">{{ $user->name }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">Email</dt>
                <dd class="mt-1 text-sm">{{ $user->email }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">Email Verified At</dt>
                <dd class="mt-1 text-sm">{{ $user->email_verified_at ?: '—' }}</dd>
            </div>
        </dl>
    </x-admin.card>
@endsection
