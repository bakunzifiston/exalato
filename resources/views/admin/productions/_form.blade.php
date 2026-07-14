@php
    $record = $production ?? null;
    $productOptions = $products->pluck('type', 'id')->all();
@endphp

<x-admin.form :method="$method ?? 'POST'" :action="$action">
    <x-admin.input label="Batch ID" name="batch_id" :value="$record->batch_id ?? null" :required="true" />
    <x-admin.select label="Product" name="product_id" :options="$productOptions" :value="$record->product_id ?? null" :required="true" />
    <x-admin.input label="Quantity Produced" name="quantity_produced" type="number" step="any" :value="$record->quantity_produced ?? null" :required="true" />
    <x-admin.input label="Damaged" name="damaged" type="number" step="any" :value="old('damaged', $record->damaged ?? 0)" :required="true" />
    <x-admin.textarea label="Raw Materials Used" name="raw_materials_used" :value="is_array($record->raw_materials_used ?? null) ? json_encode($record->raw_materials_used) : ($record->raw_materials_used ?? null)" />
    <x-admin.date-picker label="Production Date" name="production_date" :value="isset($record) && $record->production_date ? \Illuminate\Support\Carbon::parse($record->production_date)->format('Y-m-d') : null" :required="true" />
    <x-admin.input label="Responsible Staff" name="responsible_staff" :value="$record->responsible_staff ?? null" />
    <x-admin.select label="Select Barcode" name="barcode" :options="$barcodes" :value="$record->barcode ?? null" :required="true" />
    <x-admin.textarea label="Quality Control Notes" name="quality_control_notes" :value="$record->quality_control_notes ?? null" />

    <div class="flex flex-wrap gap-3 pt-2">
        <x-admin.button type="submit">{{ $submitLabel }}</x-admin.button>
        <x-admin.button variant="secondary" :href="route('admin.productions.index')">Cancel</x-admin.button>
    </div>
</x-admin.form>
