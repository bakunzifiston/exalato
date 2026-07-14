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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('sales_id')->unique();
            $table->string('barcode')->nullable();
            $table->string('customer_name');
            $table->string('customer_Phone')->nullable();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
             $table->foreignId('production_id')->constrained('productions')->onDelete('cascade');
            $table->decimal('quantity_sold', 10, 2);
            $table->decimal('selling_price', 10, 2);
            $table->decimal('total_revenue', 12, 2);
            $table->enum('payment_status', ['Paid', 'Pending', 'Credit']);
            $table->enum('delivery_status', ['Delivered', 'Pending', 'Returned']);
            $table->string('sales_channel');
            $table->string('invoice_number')->nullable();
            $table->date('sale_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
