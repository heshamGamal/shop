<?php

namespace App\Modules\Catalog\Infrastructure\Persistence;

use App\Models\Category;
use App\Modules\Catalog\Application\DTOs\CategoryData;
use App\Modules\Catalog\Domain\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentCategoryRepository implements CategoryRepositoryInterface
{
    public function findById(int $id): ?Category
        {
                return Category::query()->find($id);
                    }

                        public function findBySlug(string $slug): ?Category
                            {
                                    return Category::query()
                                                ->where('slug', $slug)
                                                            ->first();
                                                                }

                                                                    public function getAll(): Collection
                                                                        {
                                                                                return Category::query()
                                                                                            ->with('parent')
                                                                                                        ->orderBy('sort_order')
                                                                                                                    ->orderBy('name')
                                                                                                                                ->get();
                                                                                                                                    }

                                                                                                                                        public function create(CategoryData $data): Category
                                                                                                                                            {
                                                                                                                                                    return Category::query()->create([
                                                                                                                                                                'name' => $data->name,
                                                                                                                                                                            'slug' => $data->slug,
                                                                                                                                                                                        'parent_id' => $data->parentId,
                                                                                                                                                                                                    'description' => $data->description,
                                                                                                                                                                                                                'image_path' => $data->imagePath,
                                                                                                                                                                                                                            'is_active' => $data->isActive,
                                                                                                                                                                                                                                        'sort_order' => $data->sortOrder,
                                                                                                                                                                                                                                                ]);
                                                                                                                                                                                                                                                    }

                                                                                                                                                                                                                                                        public function update(
                                                                                                                                                                                                                                                                int $id,
                                                                                                                                                                                                                                                                        CategoryData $data
                                                                                                                                                                                                                                                                            ): Category {
                                                                                                                                                                                                                                                                                    $category = Category::query()->findOrFail($id);

                                                                                                                                                                                                                                                                                            $category->update([
                                                                                                                                                                                                                                                                                                        'name' => $data->name,
                                                                                                                                                                                                                                                                                                                    'slug' => $data->slug,
                                                                                                                                                                                                                                                                                                                                'parent_id' => $data->parentId,
                                                                                                                                                                                                                                                                                                                                            'description' => $data->description,
                                                                                                                                                                                                                                                                                                                                                        'image_path' => $data->imagePath,
                                                                                                                                                                                                                                                                                                                                                                    'is_active' => $data->isActive,
                                                                                                                                                                                                                                                                                                                                                                                'sort_order' => $data->sortOrder,
                                                                                                                                                                                                                                                                                                                                                                                        ]);

                                                                                                                                                                                                                                                                                                                                                                                                return $category->fresh();
                                                                                                                                                                                                                                                                                                                                                                                                    }

                                                                                                                                                                                                                                                                                                                                                                                                        public function delete(int $id): bool
                                                                                                                                                                                                                                                                                                                                                                                                            {
                                                                                                                                                                                                                                                                                                                                                                                                                    return Category::query()
                                                                                                                                                                                                                                                                                                                                                                                                                                ->whereKey($id)
                                                                                                                                                                                                                                                                                                                                                                                                                                            ->delete() > 0;
                                                                                                                                                                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                                                                                                                                                                }