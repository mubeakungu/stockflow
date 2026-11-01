<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Fields needed to print KRA eTIMS-compliant receipts.
 *
 * The kra_* invoice fields are returned by KRA eTIMS when a sale is
 * transmitted to it; they stay empty until an eTIMS connection fills them.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('kra_pin', 20)->nullable()->after('email');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->string('kra_cu_invoice_no')->nullable()->after('profit');
            $table->string('kra_cu_serial_no')->nullable()->after('kra_cu_invoice_no');
            $table->string('kra_receipt_signature')->nullable()->after('kra_cu_serial_no');
            $table->string('kra_internal_data')->nullable()->after('kra_receipt_signature');
            $table->string('kra_qr_url', 512)->nullable()->after('kra_internal_data');
            $table->timestamp('kra_signed_at')->nullable()->after('kra_qr_url');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn([
                'kra_cu_invoice_no', 'kra_cu_serial_no', 'kra_receipt_signature',
                'kra_internal_data', 'kra_qr_url', 'kra_signed_at',
            ]);
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('kra_pin');
        });
    }
};
