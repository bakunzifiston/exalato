@php
    $record = $inventoryRecord ?? null;
@endphp

<x-admin.form :method="$method ?? 'POST'" :action="$action">
    <x-admin.input label="Supplier Name" name="supplier_name" :value="$record->supplier_name ?? null" :required="true" />
    <x-admin.select label="Item Type" name="item_type" :options="['Product' => 'Product', 'Raw Material' => 'Raw Material']" :value="$record->item_type ?? null" :required="true" />
    <x-admin.input label="Item Name" name="item_name" :value="$record->item_name ?? null" :required="true" />
    <x-admin.input label="Quantity In" name="quantity_in" type="number" step="any" :value="$record->quantity_in ?? null" :required="true" />
    <x-admin.input label="Quantity Out" name="quantity_out" type="number" step="any" :value="$record->quantity_out ?? null" :required="true" />
    <x-admin.input label="Damaged" name="damaged" type="number" step="any" :value="$record->damaged ?? null" :required="true" />
    <x-admin.input label="Storage Location" name="storage_location" :value="$record->storage_location ?? null" :required="true" />
    <x-admin.date-picker label="Record Date" name="record_date" :value="isset($record) && $record->record_date ? \Illuminate\Support\Carbon::parse($record->record_date)->format('Y-m-d') : null" :required="true" />

    <div class="flex flex-wrap gap-3 pt-2">
        <x-admin.button type="submit">{{ $submitLabel }}</x-admin.button>
        <x-admin.button variant="secondary" :href="route('admin.inventory-records.index')">Cancel</x-admin.button>
    </div>
</x-admin.form>
