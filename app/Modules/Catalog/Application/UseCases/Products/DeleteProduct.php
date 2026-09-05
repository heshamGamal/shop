<?php

namespace App\Modules\Catalog\Application\UseCases\Products;

use App\Modules\Catalog\Domain\Contracts\ProductRepositoryInterface;
use RuntimeException;

final class DeleteProduct
{
    public function __construct(
            private readonly ProductRepositoryInterface $repository,
                ) {
                    }

                        public function execute(int $id): void
                            {
                                    $product = $this->repository->findById($id);

                                            if ($product === null) {
                                                        throw new RuntimeException('Product not found.');
                                                                }

                                                                        $this->repository->delete($id);
                                                                            }
                                                                            }