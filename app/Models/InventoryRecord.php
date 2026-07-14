<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryRecord extends Model
{
    /** @use HasFactory<\Database\Factories\InventoryRecordFactory> */
    use HasFactory;
    // Allow mass assignment for these attributes
    protected $fillable = [
        'supplier_name',
        'item_type',
        'item_name',
        'quantity_in',
        'quantity_out',
        'damaged',
        'storage_location',
        'record_date',
    ];
}
