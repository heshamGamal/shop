<?php

namespace App\Modules\Catalog\Application\UseCases\Brands;

use App\Modules\Catalog\Domain\Contracts\BrandRepositoryInterface;
use RuntimeException;

final class DeleteBrand
{
    public function __construct(
            private readonly BrandRepositoryInterface $repository,
                ) {
                    }

                        public function execute(int $id): void
                            {
                                    $brand = $this->repository->findById($id);

                                            if ($brand === null) {
                                                        throw new RuntimeException('Brand not found.');
                                                                }

                                                                        $this->repository->delete($id);
                                                                            }
                                                                            }