@extends('admin.layouts.app')

@section('title', 'View Product')

@section('breadcrumbs')
    <x-admin.breadcrumbs :items="[
        ['label' => 'Products', 'url' => route('admin.products.index')],
        ['label' => $product->type],
    ]" />
@endsection

@section('content')
    <x-admin.page-header title="Product Details" :search="false">
        <x-admin.button :href="route('admin.products.edit', $product)">Edit</x-admin.button>
    </x-admin.page-header>

    <x-admin.card class="max-w-3xl">
        <dl class="grid gap-4 sm:grid-cols-2">
            @foreach ([
                'Name' => $product->type,
                'Type' => $product->name,
                'Barcode' => $product->barcode ?: '—',
                'Description' => $product->description ?: '—',
            ] as $label => $value)
                <div @class(['sm:col-span-2' => $label === 'Description'])>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">{{ $label }}</dt>
                    <dd class="mt-1 text-sm text-slate-800 dark:text-slate-100">{{ $value }}</dd>
                </div>
            @endforeach
        </dl>
    </x-admin.card>
@endsection
