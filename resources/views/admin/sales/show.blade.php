@extends('admin.layouts.app')

@section('title', 'View Sale')

@section('breadcrumbs')
    <x-admin.breadcrumbs :items="[['label' => 'Sales', 'url' => route('admin.sales.index')], ['label' => $sale->sales_id]]" />
@endsection

@section('content')
    <x-admin.page-header title="Sale Details" :search="false">
        <x-admin.button :href="route('admin.sales.edit', $sale)">Edit</x-admin.button>
    </x-admin.page-header>

    <x-admin.card class="max-w-3xl">
        <dl class="grid gap-4 sm:grid-cols-2">
            @foreach ([
                'Sales ID' => $sale->sales_id,
                'Customer Name' => $sale->customer_name,
                'Customer Phone' => $sale->customer_Phone ?: '—',
                'Product' => $sale->product?->name,
                'Production Batch' => $sale->production?->batch_id,
                'Quantity Sold' => $sale->quantity_sold . ' bottles',
                'Selling Price' => number_format($sale->selling_price, 2) . ' Rwf',
                'Total Revenue' => number_format($sale->total_revenue, 2) . ' Rwf',
                'Payment Status' => $sale->payment_status,
                'Delivery Status' => $sale->delivery_status,
                'Sales Channel' => $sale->sales_channel,
                'Barcode' => $sale->barcode,
                'Invoice Number' => $sale->invoice_number ?: '—',
                'Sale Date' => $sale->sale_date,
            ] as $label => $value)
                <div>
                    <dt class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">{{ $label }}</dt>
                    <dd class="mt-1 text-sm">{{ $value }}</dd>
                </div>
            @endforeach
        </dl>
    </x-admin.card>
@endsection
