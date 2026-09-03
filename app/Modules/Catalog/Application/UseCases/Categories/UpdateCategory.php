<?php

namespace App\Modules\Catalog\Application\UseCases\Categories;

use App\Models\Category;
use App\Modules\Catalog\Application\DTOs\CategoryData;
use App\Modules\Catalog\Domain\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class UpdateCategory
{
    public function __construct(
            private readonly CategoryRepositoryInterface $repository,
                ) {
                    }

                        public function execute(int $id, CategoryData $data): Category
                            {
                                    $category = $this->repository->findById($id);

                                            if ($category === null) {
                                                        throw new RuntimeException('Category not found.');
                                                                }

                                                                        $existing = $this->repository->findBySlug($data->slug);

                                                                                if ($existing !== null && $existing->id !== $id) {
                                                                                            throw new RuntimeException(
                                                                                                            "Category slug [{$data->slug}] already exists."
                                                                                                                        );
                                                                                                                                }

                                                                                                                                        if ($data->parentId === $id) {
                                                                                                                                                    throw new RuntimeException(
                                                                                                                                                                    'A category cannot be its own parent.'
                                                                                                                                                                                );
                                                                                                                                                                                        }

                                                                                                                                                                                                if ($data->parentId !== null) {
                                                                                                                                                                                                            $parent = $this->repository->findById($data->parentId);

                                                                                                                                                                                                                        if ($parent === null) {
                                                                                                                                                                                                                                        throw new RuntimeException('Parent category not found.');
                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                            }

                                                                                                                                                                                                                                                                    return DB::transaction(
                                                                                                                                                                                                                                                                                fn () => $this->repository->update($id, $data)
                                                                                                                                                                                                                                                                                        );
                                                                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                                                                            }