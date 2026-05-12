<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use raw SQL to modify enum since Blueprint doesn't support changing enum values easily across all DB drivers
        DB::statement("ALTER TABLE material_inventory MODIFY COLUMN type ENUM('in', 'out', 'purchase', 'consumption', 'adjustment') NOT NULL DEFAULT 'purchase'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE material_inventory MODIFY COLUMN type ENUM('in', 'out', 'purchase') NOT NULL DEFAULT 'purchase'");
    }
};
