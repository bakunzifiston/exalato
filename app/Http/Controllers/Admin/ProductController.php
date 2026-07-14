<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::query()->latest();

        if ($search = $request->string('search')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('type', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($name = $request->string('name')->toString()) {
            $query->where('name', $name);
        }

        if ($type = $request->string('type')->toString()) {
            $query->where('type', $type);
        }

        if ($request->filled('has_barcode')) {
            $request->string('has_barcode')->toString() === '1'
                ? $query->whereNotNull('barcode')->where('barcode', '!=', '')
                : $query->where(fn ($q) => $q->whereNull('barcode')->orWhere('barcode', ''));
        }

        $kpis = [
            [
                'label' => 'Products',
                'value' => (string) Product::count(),
                'description' => 'Catalog items',
            ],
            [
                'label' => 'Product lines',
                'value' => (string) Product::distinct('name')->count('name'),
                'description' => 'Distinct product names',
            ],
            [
                'label' => 'Packaging types',
                'value' => (string) Product::distinct('type')->count('type'),
                'description' => 'Bottle / gallon sizes',
            ],
            [
                'label' => 'With barcode',
                'value' => (string) Product::whereNotNull('barcode')->where('barcode', '!=', '')->count(),
                'description' => 'SKU coded',
            ],
        ];

        return view('admin.products.index', [
            'products' => $query->paginate(15)->withQueryString(),
            'kpis' => $kpis,
            'nameOptions' => Product::query()->orderBy('name')->distinct()->pluck('name', 'name')->all(),
            'typeOptions' => Product::query()->orderBy('type')->distinct()->pluck('type', 'type')->all(),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.create');
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        Product::create($request->validated());

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product): View
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $ids = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:products,id'],
        ])['ids'];

        Product::whereIn('id', $ids)->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Selected products deleted successfully.');
    }
}
