<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductionRequest;
use App\Http\Requests\Admin\UpdateProductionRequest;
use App\Models\Product;
use App\Models\Production;
use App\Support\Barcodes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductionController extends Controller
{
    public function index(Request $request): View
    {
        $query = Production::query()->with('product')->latest();

        if ($search = $request->string('search')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('batch_id', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%")
                    ->orWhere('responsible_staff', 'like', "%{$search}%")
                    ->orWhereHas('product', function ($productQuery) use ($search) {
                        $productQuery->where('type', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($productId = $request->integer('product_id')) {
            $query->where('product_id', $productId);
        }

        if ($from = $request->string('from')->toString()) {
            $query->whereDate('production_date', '>=', $from);
        }

        if ($to = $request->string('to')->toString()) {
            $query->whereDate('production_date', '<=', $to);
        }

        $kpis = [
            [
                'label' => 'Batches',
                'value' => (string) Production::count(),
                'description' => 'All production runs',
            ],
            [
                'label' => 'Quantity produced',
                'value' => number_format((float) Production::sum('quantity_produced'), 0),
                'description' => 'Units in stock batches',
            ],
            [
                'label' => 'Damaged',
                'value' => number_format((float) Production::sum('damaged'), 0),
                'description' => 'Units written off',
            ],
            [
                'label' => 'Products',
                'value' => (string) Production::distinct('product_id')->count('product_id'),
                'description' => 'SKUs produced',
            ],
        ];

        return view('admin.productions.index', [
            'productions' => $query->paginate(15)->withQueryString(),
            'kpis' => $kpis,
            'productOptions' => Product::orderBy('name')->get()->mapWithKeys(
                fn (Product $product) => [$product->id => "{$product->name} ({$product->type})"]
            )->all(),
        ]);
    }

    public function create(): View
    {
        return view('admin.productions.create', [
            'products' => Product::orderBy('type')->get(),
            'barcodes' => Barcodes::options(),
        ]);
    }

    public function store(StoreProductionRequest $request): RedirectResponse
    {
        Production::create($request->validated());

        return redirect()
            ->route('admin.productions.index')
            ->with('success', 'Production created successfully.');
    }

    public function show(Production $production): View
    {
        $production->load('product');

        return view('admin.productions.show', compact('production'));
    }

    public function edit(Production $production): View
    {
        return view('admin.productions.edit', [
            'production' => $production,
            'products' => Product::orderBy('type')->get(),
            'barcodes' => Barcodes::options(),
        ]);
    }

    public function update(UpdateProductionRequest $request, Production $production): RedirectResponse
    {
        $production->update($request->validated());

        return redirect()
            ->route('admin.productions.index')
            ->with('success', 'Production updated successfully.');
    }

    public function destroy(Production $production): RedirectResponse
    {
        $production->delete();

        return redirect()
            ->route('admin.productions.index')
            ->with('success', 'Production deleted successfully.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $ids = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:productions,id'],
        ])['ids'];

        Production::whereIn('id', $ids)->delete();

        return redirect()
            ->route('admin.productions.index')
            ->with('success', 'Selected productions deleted successfully.');
    }
}
