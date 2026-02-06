<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('migration_path')->nullable();
            $table->string('seeder_class')->nullable();
            $table->string('version')->default('1.0.0');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('organization_modules', function (Blueprint $table) {
            $table->id();
            $table->string('organization_id');
            $table->foreignId('module_id')->constrained('modules')->cascadeOnDelete();
            $table->boolean('is_enabled')->default(false);
            $table->boolean('is_installed')->default(false);
            $table->timestamp('installed_at')->nullable();
            $table->timestamps();

            $table->foreign('organization_id')->references('id')->on('organizations')->cascadeOnDelete();
            $table->unique(['organization_id', 'module_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organization_modules');
        Schema::dropIfExists('modules');
    }
};
