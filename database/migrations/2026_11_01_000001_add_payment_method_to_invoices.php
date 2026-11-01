<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // cash | mpesa | bank_transfer | credit (see Invoice::PAYMENT_METHODS)
            $table->string('payment_method', 20)->default('cash')->after('status');
            // M-Pesa transaction code or bank reference
            $table->string('payment_reference', 50)->nullable()->after('payment_method');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_reference']);
        });
    }
};
