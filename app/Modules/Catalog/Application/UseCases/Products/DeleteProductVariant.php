<?php

namespace App\Modules\Catalog\Application\UseCases\Products;

use App\Modules\Catalog\Domain\Contracts\ProductRepositoryInterface;
use RuntimeException;

final class DeleteProductVariant
{
    public function __construct(
            private readonly ProductRepositoryInterface $repository,
                ) {}

                    public function execute(
                            int $productId,
                                    int $variantId
                                        ): void {
                                                $variant = $this->repository->findVariantById($variantId);

                                                        if ($variant === null) {
                                                                    throw new RuntimeException('Variant not found.');
                                                                            }

                                                                                    if ($variant->product_id !== $productId) {
                                                                                                throw new RuntimeException(
                                                                                                                'Variant does not belong to the specified product.'
                                                                                                                            );
                                                                                                                                    }

                                                                                                                                            $deleted = $this->repository->deleteVariant($variantId);

                                                                                                                                                    if (!$deleted) {
                                                                                                                                                                throw new RuntimeException(
                                                                                                                                                                                'Failed to delete product variant.'
                                                                                                                                                                                            );
                                                                                                                                                                                                    }
                                                                                                                                                                                                        }
                                                                                                                                                                                                        }