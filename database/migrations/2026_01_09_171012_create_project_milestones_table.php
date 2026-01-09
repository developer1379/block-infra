<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_milestones', function (Blueprint $table) {
            $table->id();

            // Foreign Key to Projects
            $table->foreignId('project_id')
                  ->constrained('projects')
                  ->onDelete('cascade');

            $table->string('title');
            $table->text('description')->nullable();

            // Budget allocation for this milestone
            $table->decimal('amount', 10, 2)->default(0.00);

            // Duration allocation (Expected completion date for this chunk)
            $table->date('due_date')->nullable();

            $table->enum('status', ['pending', 'in_progress', 'completed', 'paid'])
                  ->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_milestones');
    }
};
