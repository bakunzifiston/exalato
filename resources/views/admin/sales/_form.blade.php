@php
    $record = $sale ?? null;
    $productOptions = $products->pluck('name', 'id')->all();
@endphp

<x-admin.form
    :method="$method ?? 'POST'"
    :action="$action"
    x-data='{
        productId: @json(old("product_id", $record->product_id ?? "")),
        productionId: @json(old("production_id", $record->production_id ?? "")),
        quantitySold: @json(old("quantity_sold", $record->quantity_sold ?? "")),
        sellingPrice: @json(old("selling_price", $record->selling_price ?? "")),
        productionsByProduct: @json($productionsByProduct),
        get batches() { return this.productionsByProduct[this.productId] || []; },
        get totalRevenue() {
            const qty = Number(this.quantitySold);
            const price = Number(this.sellingPrice);
            return Number.isFinite(qty) && Number.isFinite(price) ? qty * price : "";
        },
        onProductChange() { this.productionId = ""; }
    }'
>
    <x-admin.input label="Customer Name" name="customer_name" :value="$record->customer_name ?? null" :required="true" />
    <x-admin.input label="Customer Phone" name="customer_Phone" :value="$record->customer_Phone ?? null" />

    <div class="space-y-1.5">
        <label for="product_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Product <span class="text-red-500">*</span></label>
        <select id="product_id" name="product_id" x-model="productId" @change="onProductChange()" required class="admin-input">
            <option value="">Select…</option>
            @foreach ($productOptions as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>
        @error('product_id') <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
    </div>

    <div class="space-y-1.5">
        <label for="production_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Select Production Batch <span class="text-red-500">*</span></label>
        <select id="production_id" name="production_id" x-model="productionId" required class="admin-input">
            <option value="">Select…</option>
            <template x-for="batch in batches" :key="batch.id">
                <option :value="batch.id" x-text="batch.batch_id"></option>
            </template>
        </select>
        @error('production_id') <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
    </div>

    <div class="space-y-1.5">
        <label for="quantity_sold" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Quantity Sold <span class="text-red-500">*</span></label>
        <input id="quantity_sold" name="quantity_sold" type="number" step="any" x-model="quantitySold" required class="admin-input">
        @error('quantity_sold') <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
    </div>

    <div class="space-y-1.5">
        <label for="selling_price" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Selling Price <span class="text-red-500">*</span></label>
        <input id="selling_price" name="selling_price" type="number" step="any" x-model="sellingPrice" required class="admin-input">
        @error('selling_price') <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
    </div>

    <div class="space-y-1.5">
        <label for="total_revenue" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Total Revenue <span class="text-red-500">*</span></label>
        <input id="total_revenue" name="total_revenue" type="number" step="any" :value="totalRevenue" readonly required class="admin-input admin-input-readonly">
        @error('total_revenue') <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
    </div>

    <x-admin.select label="Payment Status" name="payment_status" :options="['Paid' => 'Paid', 'Pending' => 'Pending', 'Credit' => 'Credit']" :value="$record->payment_status ?? null" :required="true" />
    <x-admin.select label="Delivery Status" name="delivery_status" :options="['Delivered' => 'Delivered', 'Pending' => 'Pending', 'In Transit' => 'In Transit']" :value="$record->delivery_status ?? null" :required="true" />
    <x-admin.select label="Sales Channel" name="sales_channel" :options="['Momo Pay' => 'Momo Pay', 'Card' => 'Card', 'Cash' => 'Cash']" :value="$record->sales_channel ?? null" :required="true" />
    <x-admin.select label="Select Barcode" name="barcode" :options="$barcodes" :value="$record->barcode ?? null" :required="true" />
    <x-admin.input label="Invoice Number" name="invoice_number" :value="$record->invoice_number ?? null" />
    <x-admin.date-picker label="Sale Date" name="sale_date" :value="isset($record) && $record->sale_date ? \Illuminate\Support\Carbon::parse($record->sale_date)->format('Y-m-d') : null" :required="true" />

    <div class="flex flex-wrap gap-3 pt-2">
        <x-admin.button type="submit">{{ $submitLabel }}</x-admin.button>
        <x-admin.button variant="secondary" :href="route('admin.sales.index')">Cancel</x-admin.button>
    </div>
</x-admin.form>
