@extends('admin.layouts.guest')

@section('title', 'Login')

@section('content')
    <x-admin.card class="p-6">
        <x-admin.form method="POST" action="{{ route('admin.login.store') }}" class="space-y-4">
            <x-admin.input label="Email" name="email" type="email" :value="old('email')" :required="true" />
            <x-admin.input label="Password" name="password" type="password" :required="true" />

            <label class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                <input type="checkbox" name="remember" value="1" class="rounded border-slate-300 text-brand focus:ring-brand/30" @checked(old('remember'))>
                Remember me
            </label>

            <x-admin.button type="submit" class="w-full">Sign in</x-admin.button>
        </x-admin.form>
    </x-admin.card>
@endsection
