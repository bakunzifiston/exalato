<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Employee;
use App\Models\Production;

class Sale extends Model
{
    use HasFactory;

    // Allow mass assignment for these attributes
    protected $fillable = [
        'sales_id',
        'customer_name',
        'customer_Phone',
        'product_id',
        'production_id',
        'quantity_sold',
        'selling_price',
        'total_revenue',
        'payment_status',
        'delivery_status',
        'sales_channel',
        'invoice_number',
        'sale_date',
        'barcode',
    ];

    // Automatically generate sales_id and reduce production stock
    protected static function booted()
    {
        // Generate sales_id before creating
        static::creating(function ($sale) {
            $sale->sales_id = 'SALE-' . now()->format('YmdHis') . '-' . rand(100, 999);
        });

        // Reduce stock for the selected production batch after creating
        static::created(function ($sale) {
            $production = Production::find($sale->production_id);
            if ($production) {
                $production->quantity_produced = max($production->quantity_produced - $sale->quantity_sold, 0);
                $production->save();
            }
        });
    }

    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
        public function production()
    {
        return $this->belongsTo(Production::class);
    }
    // Relationship with Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
