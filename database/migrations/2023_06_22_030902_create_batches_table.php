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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch_no')->unique();
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict');
            $table->integer('quantity');
            $table->integer('rem_quantity');
            $table->integer('purchase_price');
            $table->integer('sell_price');
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('restrict');
            $table->integer('total_purchase_cost');
            $table->integer('due_amount')->default(0);
            $table->enum('status', ['paid', 'partial', 'due'])->default('paid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
