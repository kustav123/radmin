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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique(); // e.g., 'payroll', 'crm'
            $table->text('description')->nullable();
            $table->string('migration_path')->nullable(); // e.g., 'database/migrations/modules/payroll'
            $table->string('seeder_class')->nullable(); // e.g., 'Modules\Payroll\Database\Seeders\PayrollSeeder'
            $table->string('version')->default('1.0.0');
            $table->boolean('is_active')->default(true); // Global kill switch
            $table->timestamps();
        });

        Schema::create('organization_modules', function (Blueprint $table) {
            $table->id();
            $table->string('organization_id'); // Foreign key to organizations.id (which is a string)
            $table->foreignId('module_id')->constrained('modules')->cascadeOnDelete();
            
            $table->boolean('is_enabled')->default(false); // License: Granted by Super Admin
            $table->boolean('is_installed')->default(false); // Installation: Has Tenant run migrations?
            $table->timestamp('installed_at')->nullable();
            
            $table->timestamps();

            // Foreign key constraint (referencing organizations table)
            $table->foreign('organization_id')->references('id')->on('organizations')->cascadeOnDelete();

            // Unique constraint to prevent duplicate assignments
            $table->unique(['organization_id', 'module_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_modules');
        Schema::dropIfExists('modules');
    }
};
