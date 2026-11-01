<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update all users with null roles to 'staff'
        DB::table('users')
            ->whereNull('role')
            ->update(['role' => 'staff']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback by setting staff roles back to null
        DB::table('users')
            ->where('role', 'staff')
            ->update(['role' => null]);
    }
};
