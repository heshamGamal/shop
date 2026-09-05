<?php

namespace App\Modules\Catalog\Application\UseCases\Products;

use App\Models\Product;
use App\Modules\Catalog\Application\DTOs\ProductData;
use App\Modules\Catalog\Domain\Contracts\BrandRepositoryInterface;
use App\Modules\Catalog\Domain\Contracts\CategoryRepositoryInterface;
use App\Modules\Catalog\Domain\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class UpdateProduct
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
        private readonly BrandRepositoryInterface $brandRepository,
        private readonly CategoryRepositoryInterface $categoryRepository,
    ) {}

    public function execute(int $id, ProductData $data): Product
    {
        $product = $this->repository->findById($id);

        if ($product === null) {
            throw new RuntimeException('Product not found.');
        }

        $this->validate($product, $data);

        return DB::transaction(function () use ($id, $data) {
            $product = $this->repository->update($id, $data);

            $this->repository->syncCategories(
                $id,
                $data->categoryIds
            );

            return $product->fresh([
                'brand',
                'categories',
                'variants',
                'images',
            ]);
        });
    }

    private function validate(
        Product $product,
        ProductData $data
    ): void {
        $existing = $this->repository->findBySlug($data->slug);

        if (
            $existing !== null &&
            $existing->id !== $product->id
        ) {
            throw new RuntimeException(
                "Product slug [{$data->slug}] already exists."
            );
        }

        if (
            $data->sku !== null &&
            $this->repository->skuExists(
                $data->sku,
                $product->id,
                null
            )
        ) {
            throw new RuntimeException(
                "SKU [{$data->sku}] already exists."
            );
        }

        if ($data->brandId !== null) {
            $brand = $this->brandRepository->findById(
                $data->brandId
            );

            if ($brand === null) {
                throw new RuntimeException('Brand not found.');
            }

            if (!$brand->isActive()) {
                throw new RuntimeException(
                    'Cannot assign an inactive brand to a product.'
                );
            }
        }

        if (!in_array(
            $data->productType,
            ['simple', 'variable'],
            true
        )) {
            throw new RuntimeException(
                "Unsupported product type [{$data->productType}]."
            );
        }

        if (
            $product->isVariable() &&
            $data->productType === 'simple' &&
            $product->variants()->exists()
        ) {
            throw new RuntimeException(
                'A variable product with variants cannot be changed to simple.'
            );
        }

        foreach ($data->categoryIds as $categoryId) {
            $category = $this->categoryRepository->findById(
                (int) $categoryId
            );

            if ($category === null) {
                throw new RuntimeException(
                    "Category [{$categoryId}] not found."
                );
            }

            if (!$category->isActive()) {
                throw new RuntimeException(
                    "Category [{$categoryId}] is inactive."
                );
            }
        }

        if (
            $data->status === 'published' &&
            $data->productType === 'variable' &&
            !$product->variants()->exists()
        ) {
            throw new RuntimeException(
                'A variable product must have at least one variant before publishing.'
            );
        }
    }
}
