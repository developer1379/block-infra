<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();

            // ✅ Linked category & unit (no foreign key enforcement for flexibility)
            $table->unsignedBigInteger('category_id')->nullable()->index();
            $table->unsignedBigInteger('unit_id')->nullable()->index();

            // ✅ Work title (like “Site Clearing and Grubbing”)
            $table->string('name');

            // ✅ Clean numeric ranges (no ₹ symbols)
            $table->decimal('labor_min', 10, 2)->nullable()->comment('Minimum labor-only rate');
            $table->decimal('labor_max', 10, 2)->nullable()->comment('Maximum labor-only rate');
            $table->decimal('labor_material_min', 10, 2)->nullable()->comment('Minimum labor + material rate');
            $table->decimal('labor_material_max', 10, 2)->nullable()->comment('Maximum labor + material rate');

            // ✅ Unit of measure (e.g., per sqft, per cum, project-wise)
            $table->string('unit_label')->nullable()->comment('Display label for measurement unit');

            // ✅ Optional description for notes or additional info
            $table->text('description')->nullable();

            // ✅ Active status
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Indexes for performance
            $table->index(['category_id', 'unit_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};
