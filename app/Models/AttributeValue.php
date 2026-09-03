<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AttributeValue extends Model
{
    use HasFactory;

        protected $fillable = [
                'attribute_id',
                        'value',
                                'slug',
                                        'display_value',
                                                'color_hex',
                                                        'sort_order',
                                                            ];

                                                                protected function casts(): array
                                                                    {
                                                                            return [
                                                                                        'sort_order' => 'integer',
                                                                                                ];
                                                                                                    }

                                                                                                        public function attribute(): BelongsTo
                                                                                                            {
                                                                                                                    return $this->belongsTo(
                                                                                                                                Attribute::class,
                                                                                                                                            'attribute_id'
                                                                                                                                                    );
                                                                                                                                                        }

                                                                                                                                                            public function variants(): BelongsToMany
                                                                                                                                                                {
                                                                                                                                                                        return $this->belongsToMany(
                                                                                                                                                                                    ProductVariant::class,
                                                                                                                                                                                                'product_variant_attribute_value',
                                                                                                                                                                                                            'attribute_value_id',
                                                                                                                                                                                                                        'product_variant_id'
                                                                                                                                                                                                                                );
                                                                                                                                                                                                                                    }

                                                                                                                                                                                                                                        public function getDisplayValue(): string
                                                                                                                                                                                                                                            {
                                                                                                                                                                                                                                                    return $this->display_value ?: $this->value;
                                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                                            public function isColor(): bool
                                                                                                                                                                                                                                                                {
                                                                                                                                                                                                                                                                        return $this->color_hex !== null;
                                                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                                                            }