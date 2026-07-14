<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreInventoryRecordRequest;
use App\Http\Requests\Admin\UpdateInventoryRecordRequest;
use App\Models\InventoryRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryRecordController extends Controller
{
    public function index(Request $request): View
    {
        $query = InventoryRecord::query()->latest();

        if ($search = $request->string('search')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('item_name', 'like', "%{$search}%")
                    ->orWhere('storage_location', 'like', "%{$search}%")
                    ->orWhere('supplier_name', 'like', "%{$search}%");
            });
        }

        if ($itemType = $request->string('item_type')->toString()) {
            $query->where('item_type', $itemType);
        }

        if ($from = $request->string('from')->toString()) {
            $query->whereDate('record_date', '>=', $from);
        }

        if ($to = $request->string('to')->toString()) {
            $query->whereDate('record_date', '<=', $to);
        }

        $qtyIn = (float) InventoryRecord::sum('quantity_in');
        $qtyOut = (float) InventoryRecord::sum('quantity_out');

        $kpis = [
            [
                'label' => 'Records',
                'value' => (string) InventoryRecord::count(),
                'description' => 'Ledger entries',
            ],
            [
                'label' => 'Quantity in',
                'value' => number_format($qtyIn, 0),
                'description' => 'Units received',
            ],
            [
                'label' => 'Quantity out',
                'value' => number_format($qtyOut, 0),
                'description' => 'Units issued',
            ],
            [
                'label' => 'Net stock',
                'value' => number_format($qtyIn - $qtyOut, 0),
                'description' => 'In − Out',
            ],
        ];

        return view('admin.inventory-records.index', [
            'records' => $query->paginate(15)->withQueryString(),
            'kpis' => $kpis,
            'itemTypeOptions' => [
                'Product' => 'Product',
                'Raw Material' => 'Raw Material',
            ],
        ]);
    }

    public function create(): View
    {
        return view('admin.inventory-records.create');
    }

    public function store(StoreInventoryRecordRequest $request): RedirectResponse
    {
        InventoryRecord::create($request->validated());

        return redirect()
            ->route('admin.inventory-records.index')
            ->with('success', 'Inventory record created successfully.');
    }

    public function show(InventoryRecord $inventoryRecord): View
    {
        return view('admin.inventory-records.show', compact('inventoryRecord'));
    }

    public function edit(InventoryRecord $inventoryRecord): View
    {
        return view('admin.inventory-records.edit', compact('inventoryRecord'));
    }

    public function update(UpdateInventoryRecordRequest $request, InventoryRecord $inventoryRecord): RedirectResponse
    {
        $inventoryRecord->update($request->validated());

        return redirect()
            ->route('admin.inventory-records.index')
            ->with('success', 'Inventory record updated successfully.');
    }

    public function destroy(InventoryRecord $inventoryRecord): RedirectResponse
    {
        $inventoryRecord->delete();

        return redirect()
            ->route('admin.inventory-records.index')
            ->with('success', 'Inventory record deleted successfully.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $ids = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:inventory_records,id'],
        ])['ids'];

        InventoryRecord::whereIn('id', $ids)->delete();

        return redirect()
            ->route('admin.inventory-records.index')
            ->with('success', 'Selected inventory records deleted successfully.');
    }
}
