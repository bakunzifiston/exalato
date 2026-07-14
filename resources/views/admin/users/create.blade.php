@extends('admin.layouts.app')

@section('title', 'Create User')

@section('breadcrumbs')
    <x-admin.breadcrumbs :items="[['label' => 'Users', 'url' => route('admin.users.index')], ['label' => 'Create']]" />
@endsection

@section('content')
    <x-admin.page-header title="Create User" :search="false" />
    <x-admin.card class="max-w-3xl">
        @include('admin.users._form', ['action' => route('admin.users.store'), 'submitLabel' => 'Create'])
    </x-admin.card>
@endsection
