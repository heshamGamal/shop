<?php

namespace App\Modules\Catalog\Application\UseCases\Categories;

use App\Models\Category;
use App\Modules\Catalog\Application\DTOs\CategoryData;
use App\Modules\Catalog\Domain\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class CreateCategory
{
    public function __construct(
            private readonly CategoryRepositoryInterface $repository,
                ) {
                    }

                        public function execute(CategoryData $data): Category
                            {
                                    if ($this->repository->findBySlug($data->slug)) {
                                                throw new RuntimeException(
                                                                "Category slug [{$data->slug}] already exists."
                                                                            );
                                                                                    }

                                                                                            if ($data->parentId !== null) {
                                                                                                        $parent = $this->repository->findById($data->parentId);

                                                                                                                    if ($parent === null) {
                                                                                                                                    throw new RuntimeException('Parent category not found.');
                                                                                                                                                }

                                                                                                                                                            if (!$parent->isActive()) {
                                                                                                                                                                            throw new RuntimeException(
                                                                                                                                                                                                'Cannot create a category under an inactive parent.'
                                                                                                                                                                                                                );
                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                    }

                                                                                                                                                                                                                                            return DB::transaction(
                                                                                                                                                                                                                                                        fn () => $this->repository->create($data)
                                                                                                                                                                                                                                                                );
                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                    }