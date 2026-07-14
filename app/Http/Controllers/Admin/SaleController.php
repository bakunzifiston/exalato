<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSaleRequest;
use App\Http\Requests\Admin\UpdateSaleRequest;
use App\Models\Product;
use App\Models\Production;
use App\Models\Sale;
use App\Support\Barcodes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SaleController extends Controller
{
    public function index(Request $request): View
    {
        $query = Sale::query()->with(['product', 'production'])->latest();

        if ($search = $request->string('search')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('sales_id', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_Phone', 'like', "%{$search}%")
                    ->orWhere('sales_channel', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%")
                    ->orWhere('invoice_number', 'like', "%{$search}%");
            });
        }

        if ($productId = $request->integer('product_id')) {
            $query->where('product_id', $productId);
        }

        if ($paymentStatus = $request->string('payment_status')->toString()) {
            $query->where('payment_status', $paymentStatus);
        }

        if ($deliveryStatus = $request->string('delivery_status')->toString()) {
            $query->where('delivery_status', $deliveryStatus);
        }

        if ($salesChannel = $request->string('sales_channel')->toString()) {
            $query->where('sales_channel', $salesChannel);
        }

        if ($from = $request->string('from')->toString()) {
            $query->whereDate('sale_date', '>=', $from);
        }

        if ($to = $request->string('to')->toString()) {
            $query->whereDate('sale_date', '<=', $to);
        }

        $kpis = [
            [
                'label' => 'Sales',
                'value' => (string) Sale::count(),
                'description' => 'All orders',
            ],
            [
                'label' => 'Units sold',
                'value' => number_format((float) Sale::sum('quantity_sold'), 0),
                'description' => 'Bottles / gallons',
            ],
            [
                'label' => 'Revenue',
                'value' => number_format((float) Sale::sum('total_revenue'), 0).' Rwf',
                'description' => 'Gross sales',
            ],
            [
                'label' => 'Paid',
                'value' => (string) Sale::where('payment_status', 'Paid')->count(),
                'description' => Sale::where('payment_status', 'Pending')->count().' pending',
            ],
        ];

        return view('admin.sales.index', [
            'sales' => $query->paginate(15)->withQueryString(),
            'kpis' => $kpis,
            'productOptions' => Product::orderBy('name')->get()->mapWithKeys(
                fn (Product $product) => [$product->id => "{$product->name} ({$product->type})"]
            )->all(),
            'paymentStatusOptions' => [
                'Paid' => 'Paid',
                'Pending' => 'Pending',
                'Credit' => 'Credit',
            ],
            'deliveryStatusOptions' => [
                'Delivered' => 'Delivered',
                'Pending' => 'Pending',
                'In Transit' => 'In Transit',
            ],
            'salesChannelOptions' => [
                'Momo Pay' => 'Momo Pay',
                'Card' => 'Card',
                'Cash' => 'Cash',
            ],
        ]);
    }

    public function create(): View
    {
        return view('admin.sales.create', $this->formData());
    }

    public function store(StoreSaleRequest $request): RedirectResponse
    {
        // Sales_id generation and production stock decrement stay in Sale model hooks.
        Sale::create($request->validated());

        return redirect()
            ->route('admin.sales.index')
            ->with('success', 'Sale created successfully.');
    }

    public function show(Sale $sale): View
    {
        $sale->load(['product', 'production']);

        return view('admin.sales.show', compact('sale'));
    }

    public function edit(Sale $sale): View
    {
        return view('admin.sales.edit', array_merge(
            ['sale' => $sale],
            $this->formData($sale)
        ));
    }

    public function update(UpdateSaleRequest $request, Sale $sale): RedirectResponse
    {
        $sale->update($request->validated());

        return redirect()
            ->route('admin.sales.index')
            ->with('success', 'Sale updated successfully.');
    }

    public function destroy(Sale $sale): RedirectResponse
    {
        $sale->delete();

        return redirect()
            ->route('admin.sales.index')
            ->with('success', 'Sale deleted successfully.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $ids = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:sales,id'],
        ])['ids'];

        Sale::whereIn('id', $ids)->delete();

        return redirect()
            ->route('admin.sales.index')
            ->with('success', 'Selected sales deleted successfully.');
    }

    private function formData(?Sale $sale = null): array
    {
        $availableProductions = Production::query()
            ->when($sale, function ($query) use ($sale) {
                $query->where(function ($inner) use ($sale) {
                    $inner->where('quantity_produced', '>', 0)
                        ->orWhere('id', $sale->production_id);
                });
            }, function ($query) {
                $query->where('quantity_produced', '>', 0);
            })
            ->get(['id', 'product_id', 'batch_id', 'quantity_produced']);

        return [
            'products' => Product::orderBy('name')->get(),
            'barcodes' => Barcodes::options(),
            'productionsByProduct' => $availableProductions
                ->groupBy('product_id')
                ->map(fn ($items) => $items->map(fn ($p) => [
                    'id' => $p->id,
                    'batch_id' => $p->batch_id,
                    'quantity_produced' => $p->quantity_produced,
                ])->values())
                ->toArray(),
        ];
    }
}
