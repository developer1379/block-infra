<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contractor_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('contractor_id')->nullable()->index(); // link to contractor
            $table->string('document_type'); // e.g., 'License', 'GST', 'Aadhar', etc.
            $table->string('file_path')->nullable(); // path to uploaded file
            $table->boolean('is_verified')->default(false); // verification flag
            $table->string('verified_by')->nullable(); // admin user who verified
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contractor_documents');
    }
};
