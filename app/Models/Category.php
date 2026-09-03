<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

        protected $fillable = [
                'name',
                        'slug',
                                'parent_id',
                                        'description',
                                                'image_path',
                                                        'is_active',
                                                                'sort_order',
                                                                    ];

                                                                        protected function casts(): array
                                                                            {
                                                                                    return [
                                                                                                'is_active' => 'boolean',
                                                                                                            'sort_order' => 'integer',
                                                                                                                    ];
                                                                                                                        }

                                                                                                                            public function parent(): BelongsTo
                                                                                                                                {
                                                                                                                                        return $this->belongsTo(
                                                                                                                                                    Category::class,
                                                                                                                                                                'parent_id'
                                                                                                                                                                        );
                                                                                                                                                                            }

                                                                                                                                                                                public function children(): HasMany
                                                                                                                                                                                    {
                                                                                                                                                                                            return $this->hasMany(
                                                                                                                                                                                                        Category::class,
                                                                                                                                                                                                                    'parent_id'
                                                                                                                                                                                                                            )->orderBy('sort_order');
                                                                                                                                                                                                                                }

                                                                                                                                                                                                                                    public function products(): BelongsToMany
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                                return $this->belongsToMany(
                                                                                                                                                                                                                                                            Product::class,
                                                                                                                                                                                                                                                                        'category_product',
                                                                                                                                                                                                                                                                                    'category_id',
                                                                                                                                                                                                                                                                                                'product_id'
                                                                                                                                                                                                                                                                                                        )->withPivot([
                                                                                                                                                                                                                                                                                                                    'is_primary',
                                                                                                                                                                                                                                                                                                                                'sort_order',
                                                                                                                                                                                                                                                                                                                                        ]);
                                                                                                                                                                                                                                                                                                                                            }

                                                                                                                                                                                                                                                                                                                                                public function isRoot(): bool
                                                                                                                                                                                                                                                                                                                                                    {
                                                                                                                                                                                                                                                                                                                                                            return $this->parent_id === null;
                                                                                                                                                                                                                                                                                                                                                                }

                                                                                                                                                                                                                                                                                                                                                                    public function isActive(): bool
                                                                                                                                                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                                                                                                                                                                return $this->is_active;
                                                                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                                                                    }