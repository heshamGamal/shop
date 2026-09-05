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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

                        $table->string('name');
                                    $table->string('slug')->unique();

                                                $table->text('short_description')->nullable();
                                                            $table->longText('description')->nullable();

                                                                        $table->foreignId('brand_id')
                                                                                        ->nullable()
                                                                                                        ->constrained('brands')
                                                                                                                        ->nullOnDelete();

                                                                                                                                    $table->string('product_type', 30)
                                                                                                                                                    ->default('simple');

                                                                                                                                                                $table->string('status', 30)
                                                                                                                                                                                ->default('draft')
                                                                                                                                                                                                ->index();

                                                                                                                                                                                                            $table->decimal('price', 15, 2)
                                                                                                                                                                                                                            ->nullable();

                                                                                                                                                                                                                                        $table->decimal('compare_at_price', 15, 2)
                                                                                                                                                                                                                                                        ->nullable();

                                                                                                                                                                                                                                                                    $table->decimal('cost_price', 15, 2)
                                                                                                                                                                                                                                                                                    ->nullable();

                                                                                                                                                                                                                                                                                                $table->string('sku', 100)
                                                                                                                                                                                                                                                                                                                ->nullable()
                                                                                                                                                                                                                                                                                                                                ->unique();

                                                                                                                                                                                                                                                                                                                                            $table->string('barcode', 100)
                                                                                                                                                                                                                                                                                                                                                            ->nullable()
                                                                                                                                                                                                                                                                                                                                                                            ->unique();

                                                                                                                                                                                                                                                                                                                                                                                        $table->decimal('weight', 12, 3)
                                                                                                                                                                                                                                                                                                                                                                                                        ->nullable();

                                                                                                                                                                                                                                                                                                                                                                                                                    $table->decimal('length', 12, 3)
                                                                                                                                                                                                                                                                                                                                                                                                                                    ->nullable();

                                                                                                                                                                                                                                                                                                                                                                                                                                                $table->decimal('width', 12, 3)
                                                                                                                                                                                                                                                                                                                                                                                                                                                                ->nullable();

                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $table->decimal('height', 12, 3)
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ->nullable();

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $table->string('weight_unit', 10)
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ->default('kg');

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $table->string('dimension_unit', 10)
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ->default('cm');

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $table->boolean('is_active')
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ->default(true)
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ->index();

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $table->boolean('is_featured')
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ->default(false)
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ->index();

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $table->unsignedInteger('sort_order')
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ->default(0);

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $table->timestamps();

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $table->index('brand_id');
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $table->index('product_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
