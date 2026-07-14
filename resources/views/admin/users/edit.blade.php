@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('breadcrumbs')
    <x-admin.breadcrumbs :items="[['label' => 'Users', 'url' => route('admin.users.index')], ['label' => $user->name, 'url' => route('admin.users.show', $user)], ['label' => 'Edit']]" />
@endsection

@section('content')
    <x-admin.page-header title="Edit User" :search="false" />
    <x-admin.card class="max-w-3xl">
        @include('admin.users._form', ['action' => route('admin.users.update', $user), 'method' => 'PUT', 'submitLabel' => 'Save', 'user' => $user])
    </x-admin.card>
    <div class="mt-4 max-w-3xl"><x-admin.delete-button :action="route('admin.users.destroy', $user)" message="Delete this user?" /></div>
@endsection
