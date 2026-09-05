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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                            ->constrained('products')
                                            ->cascadeOnDelete();

                                                        $table->string('name')->nullable();

                                                                    $table->decimal('price', 15, 2)
                                                                                    ->nullable();

                                                                                                $table->decimal('compare_at_price', 15, 2)
                                                                                                                ->nullable();

                                                                                                                            $table->decimal('cost_price', 15, 2)
                                                                                                                                            ->nullable();

                                                                                                                                                        $table->string('sku', 100)
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

                                                                                                                                                                                                                                                                                                                                                $table->boolean('is_active')
                                                                                                                                                                                                                                                                                                                                                                ->default(true)
                                                                                                                                                                                                                                                                                                                                                                                ->index();

                                                                                                                                                                                                                                                                                                                                                                                            $table->unsignedInteger('sort_order')
                                                                                                                                                                                                                                                                                                                                                                                                            ->default(0);

                                                                                                                                                                                                                                                                                                                                                                                                                        $table->timestamps();

                                                                                                                                                                                                                                                                                                                                                                                                                                    $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
