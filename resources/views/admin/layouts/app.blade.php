<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — 2ES Ltd</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="admin-shell font-sans">
    @if (session('success'))
        <div id="flash-success" data-message="{{ session('success') }}" class="hidden"></div>
    @endif

    <div class="flex min-h-screen" x-data="{ sidebarOpen: false }">
        <div
            x-show="sidebarOpen"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-30 bg-slate-900/40 backdrop-blur-sm lg:hidden"
            @click="sidebarOpen = false"
        ></div>

        @include('admin.layouts.partials.sidebar')

        <div class="flex min-w-0 flex-1 flex-col">
            @include('admin.layouts.partials.navbar')

            <main class="mx-auto w-full max-w-[1400px] flex-1 px-4 py-5 lg:px-6 xl:px-8">
                @hasSection('breadcrumbs')
                    <div class="mb-2">@yield('breadcrumbs')</div>
                @elseif (! empty($breadcrumbs ?? null))
                    <x-admin.breadcrumbs :items="$breadcrumbs" />
                @endif

                @if ($errors->any())
                    <x-admin.alert type="error" title="Please fix the following" class="mb-6">
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-admin.alert>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <x-admin.toast />
    <x-admin.confirm-dialog />

    @stack('scripts')
</body>
</html>
