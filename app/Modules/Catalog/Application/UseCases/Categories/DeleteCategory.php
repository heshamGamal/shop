<?php

namespace App\Modules\Catalog\Application\UseCases\Categories;

use App\Modules\Catalog\Domain\Contracts\CategoryRepositoryInterface;
use RuntimeException;

final class DeleteCategory
{
    public function __construct(
            private readonly CategoryRepositoryInterface $repository,
                ) {
                    }

                        public function execute(int $id): void
                            {
                                    $category = $this->repository->findById($id);

                                            if ($category === null) {
                                                        throw new RuntimeException('Category not found.');
                                                                }

                                                                        $this->repository->delete($id);
                                                                            }
                                                                            }