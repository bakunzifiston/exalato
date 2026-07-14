<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\InventoryRecord;
use App\Models\Product;
use App\Models\Production;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $totalQuantityProduced = Production::sum('quantity_produced');
        $totalInventoryIn = InventoryRecord::sum('quantity_in');
        $totalInventoryOut = InventoryRecord::sum('quantity_out');
        $currentStock = $totalInventoryIn - $totalInventoryOut;
        $totalRevenue = Sale::sum('total_revenue');

        $productionByProduct = Production::select('product_id', DB::raw('SUM(quantity_produced) as total'))
            ->with('product:id,name,type')
            ->groupBy('product_id')
            ->get();

        $kpis = [
            [
                'label' => 'Employees',
                'value' => (string) Employee::count(),
                'hint' => 'Total staff',
                'icon' => 'users',
            ],
            [
                'label' => 'Inventory Stock',
                'value' => number_format($currentStock, 0).' u',
                'hint' => 'In − Out',
                'icon' => 'box',
            ],
            [
                'label' => 'Produced Quantity',
                'value' => number_format($totalQuantityProduced, 0),
                'hint' => 'All batches',
                'icon' => 'beaker',
            ],
            [
                'label' => 'Total Revenue',
                'value' => number_format($totalRevenue / 1000000, 1).'M',
                'hint' => 'RWF from sales',
                'icon' => 'cash',
            ],
        ];

        $monthlyProduction = Production::selectRaw('MONTH(production_date) as month, SUM(quantity_produced) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $productionChart = [];
        for ($i = 1; $i <= 12; $i++) {
            $productionChart[] = (float) ($monthlyProduction[$i] ?? 0);
        }

        $monthlySales = Sale::selectRaw('MONTH(sale_date) as month, SUM(total_revenue) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $salesChart = [];
        for ($i = 1; $i <= 12; $i++) {
            $salesChart[] = (float) ($monthlySales[$i] ?? 0);
        }

        $paymentBreakdown = Sale::select('payment_status', DB::raw('COUNT(*) as total'))
            ->groupBy('payment_status')
            ->pluck('total', 'payment_status');

        $deliveryBreakdown = Sale::select('delivery_status', DB::raw('COUNT(*) as total'))
            ->groupBy('delivery_status')
            ->pluck('total', 'delivery_status');

        $paidCount = (int) ($paymentBreakdown['Paid'] ?? 0);
        $pendingCount = (int) ($paymentBreakdown['Pending'] ?? 0);
        $creditCount = (int) ($paymentBreakdown['Credit'] ?? 0);
        $paymentTotal = max($paidCount + $pendingCount + $creditCount, 1);
        $paidPercent = round(($paidCount / $paymentTotal) * 100);

        $recentSales = Sale::with(['product', 'production'])
            ->latest('sale_date')
            ->limit(5)
            ->get();

        $pendingDeliveries = (int) ($deliveryBreakdown['Pending'] ?? 0);
        $returnedDeliveries = (int) ($deliveryBreakdown['Returned'] ?? 0);

        $inventoryOverview = InventoryRecord::query()
            ->latest('record_date')
            ->limit(6)
            ->get()
            ->map(function (InventoryRecord $record) {
                $net = $record->quantity_in - $record->quantity_out;
                $status = $record->damaged > 20
                    ? 'Attention'
                    : ($net < 500 ? 'Low Stock' : 'Healthy');

                return [
                    'name' => $record->item_name,
                    'type' => $record->item_type,
                    'stock' => number_format($net, 0),
                    'location' => $record->storage_location,
                    'status' => $status,
                ];
            });

        return view('admin.dashboard', [
            'kpis' => $kpis,
            'productionChart' => $productionChart,
            'salesChart' => $salesChart,
            'paymentDonut' => [
                'paid' => $paidCount,
                'pending' => $pendingCount,
                'credit' => $creditCount,
                'percent' => $paidPercent,
            ],
            'recentSales' => $recentSales,
            'pendingDeliveries' => $pendingDeliveries,
            'returnedDeliveries' => $returnedDeliveries,
            'inventoryOverview' => $inventoryOverview,
            'productionByProduct' => $productionByProduct,
            'totalRevenue' => $totalRevenue,
            'currentStock' => $currentStock,
        ]);
    }
}
