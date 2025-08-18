<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Category & Subcategory
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('cascade');

            $table->foreignId('subcategory_id')
                  ->constrained('subcategories')
                  ->onDelete('cascade');

            // Product Details
            $table->string('name', 200);
            $table->string('slug', 220)->unique();
            $table->text('description')->nullable();

            // Medicine-specific info
            $table->string('manufacturer', 150)->nullable();
            $table->string('batch_number', 100)->nullable();
            $table->date('expiry_date')->nullable();

            // Pricing & Stock
            $table->decimal('purchase_price', 10, 2)->default(0);
            $table->decimal('selling_price', 10, 2)->default(0);
            $table->integer('stock_quantity')->default(0);

            // Status
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            // Unique constraint: prevent duplicate product names in the same category
            $table->unique(['category_id', 'subcategory_id', 'name'], 'uq_products_category_subcategory_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

