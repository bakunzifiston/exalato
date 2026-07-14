<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_records', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_name');
            $table->enum('item_type', ['Product', 'Raw Material']);
            $table->string('item_name');
            $table->decimal('quantity_in', 10, 2);
            $table->decimal('quantity_out', 10, 2);
            $table->decimal('damaged', 10, 2);
            $table->string('storage_location');
            $table->date('record_date');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_records');
    }
};
