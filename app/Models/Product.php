<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    // Allow mass assignment for these attributes
    protected $fillable = [
        'name',
        'type',
        'description',
        'barcode'
        // Add any other fields you are saving to the database
    ];
    
}
