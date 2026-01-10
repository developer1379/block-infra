<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('projects', function (Blueprint $table) {
        // Add the missing column
        $table->integer('current_progress')->default(0)->after('status');
    });
}

public function down()
{
    Schema::table('projects', function (Blueprint $table) {
        $table->dropColumn('current_progress');
    });
}
};
