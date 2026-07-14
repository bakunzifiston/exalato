@extends('admin.layouts.app')

@section('title', 'View Production')

@section('breadcrumbs')
    <x-admin.breadcrumbs :items="[['label' => 'Productions', 'url' => route('admin.productions.index')], ['label' => $production->batch_id]]" />
@endsection

@section('content')
    <x-admin.page-header title="Production Details" :search="false">
        <x-admin.button :href="route('admin.productions.edit', $production)">Edit</x-admin.button>
    </x-admin.page-header>

    <x-admin.card class="max-w-3xl">
        <dl class="grid gap-4 sm:grid-cols-2">
            @foreach ([
                'Batch ID' => $production->batch_id,
                'Product' => $production->product?->type,
                'Quantity Produced' => $production->quantity_produced . ' bottles',
                'Damaged' => $production->damaged,
                'Production Date' => $production->production_date,
                'Responsible Staff' => $production->responsible_staff ?: '—',
                'Barcode' => $production->barcode,
                'Raw Materials Used' => is_array($production->raw_materials_used) ? json_encode($production->raw_materials_used) : ($production->raw_materials_used ?: '—'),
                'Quality Control Notes' => $production->quality_control_notes ?: '—',
            ] as $label => $value)
                <div @class(['sm:col-span-2' => in_array($label, ['Raw Materials Used', 'Quality Control Notes'])])>
                    <dt class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">{{ $label }}</dt>
                    <dd class="mt-1 whitespace-pre-wrap text-sm">{{ $value }}</dd>
                </div>
            @endforeach
        </dl>
    </x-admin.card>
@endsection
