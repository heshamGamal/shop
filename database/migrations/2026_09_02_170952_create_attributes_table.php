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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
                        $table->string('slug')->unique();

                                    $table->string('type', 30)
                                                    ->default('select');

                                                                $table->boolean('is_variant')
                                                                                ->default(true);

                                                                                            $table->boolean('is_active')
                                                                                                            ->default(true);

                                                                                                                        $table->unsignedInteger('sort_order')
                                                                                                                                        ->default(0);

                                                                                                                                                    $table->timestamps();

                                                                                                                                                                $table->index(['is_variant', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
