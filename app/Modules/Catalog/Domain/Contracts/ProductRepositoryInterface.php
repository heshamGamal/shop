<?php

namespace App\Modules\Catalog\Domain\Contracts;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Modules\Catalog\Application\DTOs\ProductData;
use App\Modules\Catalog\Application\DTOs\ProductVariantData;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    public function findById(int $id): ?Product;

        public function findBySlug(string $slug): ?Product;

            public function findVariantById(int $id): ?ProductVariant;

                public function findBySku(string $sku): ?Product;

                    public function skuExists(
                            string $sku,
                                    ?int $ignoreProductId = null,
                                            ?int $ignoreVariantId = null
                                                ): bool;

                                                    public function getAll(): Collection;

                                                        public function create(ProductData $data): Product;

                                                            public function update(int $id, ProductData $data): Product;

                                                                public function delete(int $id): bool;

                                                                    public function createVariant(
                                                                            ProductVariantData $data
                                                                                ): ProductVariant;

                                                                                    public function updateVariant(
                                                                                            int $id,
                                                                                                    ProductVariantData $data
                                                                                                        ): ProductVariant;

                                                                                                            public function deleteVariant(int $id): bool;

                                                                                                                public function syncCategories(
                                                                                                                        int $productId,
                                                                                                                                array $categoryIds
                                                                                                                                    ): void;

                                                                                                                                        public function syncVariantAttributes(
                                                                                                                                                int $variantId,
                                                                                                                                                        array $attributeValueIds
                                                                                                                                                            ): void;
                                                                                                                                                            public function variantCombinationExists(
                                                                                                                                                                    int $productId,
                                                                                                                                                                        array $attributeValueIds,
                                                                                                                                                                            ?int $ignoreVariantId = null
                                                                                                                                                                            ): bool;
                                                                                                                                                            )
                                                                                                                                                            }