<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('project_works', function (Blueprint $table) {
            $table->integer('quantity')->default(1);
            $table->decimal('amount', 15, 2)->default(0.00); // The calculated cost for this work
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_works', function (Blueprint $table) {
            //
        });
    }
};
