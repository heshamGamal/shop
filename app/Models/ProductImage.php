<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    use HasFactory;

        protected $fillable = [
                'product_id',
                        'product_variant_id',
                                'path',
                                        'alt_text',
                                                'title',
                                                        'sort_order',
                                                                'is_primary',
                                                                    ];

                                                                        protected function casts(): array
                                                                            {
                                                                                    return [
                                                                                                'sort_order' => 'integer',
                                                                                                            'is_primary' => 'boolean',
                                                                                                                    ];
                                                                                                                        }

                                                                                                                            public function product(): BelongsTo
                                                                                                                                {
                                                                                                                                        return $this->belongsTo(
                                                                                                                                                    Product::class,
                                                                                                                                                                'product_id'
                                                                                                                                                                        );
                                                                                                                                                                            }

                                                                                                                                                                                public function variant(): BelongsTo
                                                                                                                                                                                    {
                                                                                                                                                                                            return $this->belongsTo(
                                                                                                                                                                                                        ProductVariant::class,
                                                                                                                                                                                                                    'product_variant_id'
                                                                                                                                                                                                                            );
                                                                                                                                                                                                                                }

                                                                                                                                                                                                                                    public function isVariantImage(): bool
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                                return $this->product_variant_id !== null;
                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                    }