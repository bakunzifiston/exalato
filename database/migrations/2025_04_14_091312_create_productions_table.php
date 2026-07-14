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
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->string('batch_id')->unique();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('barcode')->nullable();
            $table->decimal('quantity_produced', 10, 2);
            $table->decimal('damaged', 10, 2);
            $table->json('raw_materials_used')->nullable(); // Optional for now
            $table->date('production_date');
            $table->string('responsible_staff')->nullable();
            $table->text('quality_control_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productions');
    }
};
