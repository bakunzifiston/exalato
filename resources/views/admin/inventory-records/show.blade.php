@extends('admin.layouts.app')

@section('title', 'View Inventory Record')

@section('breadcrumbs')
    <x-admin.breadcrumbs :items="[['label' => 'Inventory Records', 'url' => route('admin.inventory-records.index')], ['label' => $inventoryRecord->item_name]]" />
@endsection

@section('content')
    <x-admin.page-header title="Inventory Record Details" :search="false">
        <x-admin.button :href="route('admin.inventory-records.edit', $inventoryRecord)">Edit</x-admin.button>
    </x-admin.page-header>

    <x-admin.card class="max-w-3xl">
        <dl class="grid gap-4 sm:grid-cols-2">
            @foreach ([
                'Supplier Name' => $inventoryRecord->supplier_name,
                'Item Type' => $inventoryRecord->item_type,
                'Item Name' => $inventoryRecord->item_name,
                'Quantity In' => $inventoryRecord->quantity_in . ' L',
                'Quantity Out' => $inventoryRecord->quantity_out . ' L',
                'Damaged' => $inventoryRecord->damaged,
                'Storage Location' => $inventoryRecord->storage_location,
                'Record Date' => $inventoryRecord->record_date,
            ] as $label => $value)
                <div>
                    <dt class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">{{ $label }}</dt>
                    <dd class="mt-1 text-sm">{{ $value }}</dd>
                </div>
            @endforeach
        </dl>
    </x-admin.card>
@endsection
