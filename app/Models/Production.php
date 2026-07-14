<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    /** @use HasFactory<\Database\Factories\ProductionFactory> */
    use HasFactory;
    // Allow mass assignment for these attributes
    protected $fillable = [
        'batch_id',
        'product_id',
        'barcode',
        'quantity_produced',
        'damaged',
        'row_materials_used',
        'production_date',
        'responsible_staff',
        'quality_control_notes',
        // Add any other fields you are saving to the database
    ];
    // Define the relationship with the Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    // Define the relationship with the Employee model
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

}
