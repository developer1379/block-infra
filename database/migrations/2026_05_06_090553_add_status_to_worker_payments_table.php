<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasColumn('worker_payments', 'status')) {
            Schema::table('worker_payments', function (Blueprint $table) {
                // Add the status column, defaulting to 'pending'
                $table->string('status')->default('pending')->after('amount');
            });
        }
    }

    public function down()
    {
        Schema::table('worker_payments', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
