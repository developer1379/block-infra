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
        Schema::dropIfExists('feedback');
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('contractor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type')->default('issue'); // issue, bug, suggestion, other
            $table->string('subject');
            $table->text('description');
            $table->string('attachment')->nullable();
            $table->string('status')->default('pending'); // pending, in_progress, resolved
            $table->text('admin_reply')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
