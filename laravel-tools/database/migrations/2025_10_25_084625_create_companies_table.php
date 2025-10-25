<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            // Basic Info
            $table->string('name')->unique();
            $table->string('slug')->unique()->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            // Address Info
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('country')->default('Bangladesh');

            // Business Info
            $table->string('trade_license')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('owner_name')->nullable();

            // Branding
            $table->string('logo')->nullable(); // Store logo image path

            // Status
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
