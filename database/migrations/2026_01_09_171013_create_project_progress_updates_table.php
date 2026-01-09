<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_progress_updates', function (Blueprint $table) {
            $table->id();

            // Foreign Key to Projects
            $table->foreignId('project_id')
                  ->constrained('projects')
                  ->onDelete('cascade');

            // Foreign Key to Contractor (User)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Work percentage (0 to 100)
            $table->integer('progress_percentage')->default(0);

            // Detailed report text
            $table->longText('report_description')->nullable();

            // File path for PDF/Doc uploads
            $table->string('report_file_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_progress_updates');
    }
};
