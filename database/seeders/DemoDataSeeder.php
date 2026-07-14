<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\InventoryRecord;
use App\Models\Product;
use App\Models\Production;
use App\Models\Sale;
use App\Models\User;
use App\Support\Barcodes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Sale::truncate();
        Production::truncate();
        InventoryRecord::truncate();
        Product::truncate();
        Employee::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->seedUsers();
        $employees = $this->seedEmployees();
        $products = $this->seedProducts();
        $productions = $this->seedProductions($products, $employees);
        $this->seedInventory();
        $this->seedSales($products, $productions);

        $this->command?->info('Demo data ready.');
        $this->command?->info('Login: admin@2es.rw / password');
    }

    private function seedUsers(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@2es.rw'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'sales@2es.rw'],
            [
                'name' => 'Sales Officer',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }

    private function seedEmployees(): array
    {
        $rows = [
            ['EMP-001', 'Jean Claude Habimana', 'Production Supervisor', '0788001101', 'jean.habimana@2es.rw', 'Kigali City', 'Gasabo'],
            ['EMP-002', 'Marie Uwase', 'Quality Control', '0788001102', 'marie.uwase@2es.rw', 'Kigali City', 'Kicukiro'],
            ['EMP-003', 'Eric Niyonsenga', 'Warehouse Manager', '0788001103', 'eric.niyonsenga@2es.rw', 'Eastern', 'Rwamagana'],
            ['EMP-004', 'Sandrine Mukamana', 'Sales Lead', '0788001104', 'sandrine.mukamana@2es.rw', 'Southern', 'Huye'],
            ['EMP-005', 'Patrick Iradukunda', 'Machine Operator', '0788001105', 'patrick.iradukunda@2es.rw', 'Northern', 'Musanze'],
            ['EMP-006', 'Claudine Ingabire', 'Inventory Clerk', '0788001106', 'claudine.ingabire@2es.rw', 'Western', 'Rubavu'],
        ];

        $employees = [];

        foreach ($rows as [$employeeId, $name, $position, $phone, $email, $province, $district]) {
            $employees[] = Employee::create([
                'employee_id' => $employeeId,
                'name' => $name,
                'position' => $position,
                'phone' => $phone,
                'email' => $email,
                'province' => $province,
                'district' => $district,
            ]);
        }

        return $employees;
    }

    private function seedProducts(): array
    {
        $barcodes = array_keys(Barcodes::options());

        $rows = [
            ['Bottle 500ml', 'Purified Water', 'Still purified drinking water, 500ml bottle.', $barcodes[0]],
            ['Bottle 1L', 'Purified Water', 'Still purified drinking water, 1 liter bottle.', $barcodes[1]],
            ['Bottle 1.5L', 'Mineral Water', 'Mineral water for retail and hospitality, 1.5L.', $barcodes[2]],
            ['Gallon 20L', 'Dispenser Water', '20 liter dispenser refill for offices and homes.', $barcodes[3]],
        ];

        $products = [];

        foreach ($rows as [$type, $name, $description, $barcode]) {
            $products[] = Product::create([
                'type' => $type,
                'name' => $name,
                'description' => $description,
                'barcode' => $barcode,
            ]);
        }

        return $products;
    }

    private function seedProductions(array $products, array $employees): array
    {
        $barcodes = array_keys(Barcodes::options());
        $months = [1, 2, 3, 4, 5, 6];
        $productions = [];
        $batch = 1;

        foreach ($products as $index => $product) {
            foreach ($months as $month) {
                $qty = match ($product->type) {
                    'Bottle 500ml' => 4200 + ($month * 80),
                    'Bottle 1L' => 3100 + ($month * 60),
                    'Bottle 1.5L' => 2400 + ($month * 50),
                    default => 900 + ($month * 20),
                };

                $damaged = round($qty * 0.01, 2);
                $staff = $employees[$index % count($employees)]->name;

                $production = Production::create([
                    'batch_id' => sprintf('BATCH-%s-%03d', now()->year, $batch++),
                    'product_id' => $product->id,
                    'barcode' => $barcodes[$index % count($barcodes)],
                    'quantity_produced' => $qty,
                    'damaged' => $damaged,
                    'production_date' => now()->startOfYear()->addMonths($month - 1)->addDays(4 + ($index * 2)),
                    'responsible_staff' => $staff,
                    'quality_control_notes' => 'Passed visual and fill-level checks.',
                ]);

                DB::table('productions')->where('id', $production->id)->update([
                    'raw_materials_used' => json_encode([
                        'source_water' => round($qty * 1.05, 2).' L',
                        'bottles' => (int) $qty,
                        'caps' => (int) $qty,
                        'labels' => (int) $qty,
                    ]),
                ]);

                $productions[] = $production->fresh();
            }
        }

        return $productions;
    }

    private function seedInventory(): void
    {
        $rows = [
            ['Nyabarongo Supplies Ltd', 'Raw Material', 'PET Preforms 500ml', 12000, 4500, 40, 'Warehouse A', '-5 months'],
            ['Kigali Packaging Co', 'Raw Material', 'Bottle Caps', 15000, 6200, 25, 'Warehouse A', '-4 months'],
            ['Lake Source Water', 'Raw Material', 'Source Water Intake', 80000, 62000, 0, 'Treatment Plant', '-3 months'],
            ['Green Label Printers', 'Raw Material', 'Product Labels', 10000, 4800, 15, 'Warehouse B', '-2 months'],
            ['2ES Production', 'Product', 'Bottle 500ml Finished', 5000, 2100, 30, 'Finished Goods Bay', '-45 days'],
            ['2ES Production', 'Product', 'Bottle 1L Finished', 3200, 1400, 18, 'Finished Goods Bay', '-30 days'],
            ['2ES Production', 'Product', 'Gallon 20L Finished', 1200, 480, 8, 'Dispenser Zone', '-20 days'],
            ['East Africa Stretch Film', 'Raw Material', 'Shrink Wrap Film', 600, 220, 5, 'Warehouse B', '-10 days'],
        ];

        foreach ($rows as [$supplier, $itemType, $itemName, $qtyIn, $qtyOut, $damaged, $location, $when]) {
            InventoryRecord::create([
                'supplier_name' => $supplier,
                'item_type' => $itemType,
                'item_name' => $itemName,
                'quantity_in' => $qtyIn,
                'quantity_out' => $qtyOut,
                'damaged' => $damaged,
                'storage_location' => $location,
                'record_date' => now()->modify($when)->toDateString(),
            ]);
        }
    }

    private function seedSales(array $products, array $productions): void
    {
        $customers = [
            ['Kigali Mart', '0788112233'],
            ['Simba Supermarket', '0788223344'],
            ['Hotel des Mille Collines', '0788334455'],
            ['University Cafeteria', '0788445566'],
            ['Office Park Kacyiru', '0788556677'],
            ['Nyabugogo Wholesale', '0788667788'],
            ['Rubavu Mini Mart', '0788778899'],
            ['Huye Campus Store', '0788889900'],
        ];

        $channels = ['Cash', 'Momo Pay', 'Card'];
        $payments = ['Paid', 'Pending', 'Credit'];
        $deliveries = ['Delivered', 'Pending', 'Returned'];
        $barcodes = array_keys(Barcodes::options());

        // Prefer later batches (higher remaining stock after seeding productions)
        $byProduct = collect($productions)->groupBy('product_id');

        $saleIndex = 0;

        foreach ($products as $productIndex => $product) {
            $batches = $byProduct->get($product->id, collect())->values();

            foreach (range(1, 4) as $i) {
                $batch = $batches[min($i + 1, $batches->count() - 1)] ?? $batches->last();
                if (! $batch) {
                    continue;
                }

                $customer = $customers[$saleIndex % count($customers)];
                $qty = match ($product->type) {
                    'Gallon 20L' => 20 + ($i * 5),
                    'Bottle 1.5L' => 80 + ($i * 10),
                    'Bottle 1L' => 120 + ($i * 15),
                    default => 180 + ($i * 20),
                };

                $price = match ($product->type) {
                    'Gallon 20L' => 3500,
                    'Bottle 1.5L' => 900,
                    'Bottle 1L' => 700,
                    default => 500,
                };

                Sale::create([
                    'customer_name' => $customer[0],
                    'customer_Phone' => $customer[1],
                    'product_id' => $product->id,
                    'production_id' => $batch->id,
                    'quantity_sold' => $qty,
                    'selling_price' => $price,
                    'total_revenue' => $qty * $price,
                    'payment_status' => $payments[$saleIndex % count($payments)],
                    'delivery_status' => $deliveries[$saleIndex % count($deliveries)],
                    'sales_channel' => $channels[$saleIndex % count($channels)],
                    'barcode' => $barcodes[$productIndex % count($barcodes)],
                    'invoice_number' => sprintf('INV-2026-%04d', 1001 + $saleIndex),
                    'sale_date' => now()->subDays(55 - ($saleIndex * 3))->toDateString(),
                ]);

                $saleIndex++;
            }
        }
    }
}
