<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    use HasFactory;
        protected $table = 'attributes';
            protected $fillable = [
                    'name',
                            'slug',
                                    'type',
                                            'is_variant',
                                                    'is_active',
                                                            'sort_order',
                                                                ];

                                                                    protected function casts(): array
                                                                        {
                                                                                return [
                                                                                            'is_variant' => 'boolean',
                                                                                                        'is_active' => 'boolean',
                                                                                                                    'sort_order' => 'integer',
                                                                                                                            ];
                                                                                                                                }

                                                                                                                                    public function values(): HasMany
                                                                                                                                        {
                                                                                                                                                return $this->hasMany(
                                                                                                                                                            AttributeValue::class,
                                                                                                                                                                        'attribute_id'
                                                                                                                                                                                )->orderBy('sort_order');
                                                                                                                                                                                    }

                                                                                                                                                                                        public function isVariantAttribute(): bool
                                                                                                                                                                                            {
                                                                                                                                                                                                    return $this->is_variant;
                                                                                                                                                                                                        }

                                                                                                                                                                                                            public function isActive(): bool
                                                                                                                                                                                                                {
                                                                                                                                                                                                                        return $this->is_active;
                                                                                                                                                                                                                            }
                                                                                                                                                                                                                            }