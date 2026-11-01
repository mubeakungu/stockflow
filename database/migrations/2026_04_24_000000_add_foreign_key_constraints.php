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
        // Add foreign key constraint to products.brand_id
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('brand_id')
                ->references('id')
                ->on('brands')
                ->onDelete('restrict');
        });

        // Add foreign key constraints to batches
        Schema::table('batches', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('restrict');

            $table->foreign('supplier_id')
                ->references('id')
                ->on('suppliers')
                ->onDelete('restrict');
        });

        // Add foreign key constraint to invoices and fix data types
        Schema::table('invoices', function (Blueprint $table) {
            // Change data types from integer/string to decimal
            $table->decimal('total', 10, 2)->change();
            $table->decimal('due', 10, 2)->change();
            $table->decimal('profit', 10, 2)->change();

            // Add foreign key constraint
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('restrict');
        });

        // Add foreign key constraint to expenses
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreign('type_id')
                ->references('id')
                ->on('types')
                ->onDelete('restrict');
        });

        // Add foreign key constraint to invoice_items (if not already present)
        // This is already done in the create_invoice_items_table migration,
        // but we ensure it's properly set up
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove foreign key constraints
        Schema::table('invoice_items', function (Blueprint $table) {
            // Already handled in drop migration
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            // Revert data types back to original
            $table->integer('total')->change();
            $table->integer('due')->change();
            $table->string('profit')->change();
        });

        Schema::table('batches', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
            $table->dropForeign(['product_id']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
        });
    }
};
