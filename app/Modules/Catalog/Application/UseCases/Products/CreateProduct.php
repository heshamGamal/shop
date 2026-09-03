<?php

namespace App\Modules\Catalog\Application\UseCases\Products;

use App\Models\Product;
use App\Modules\Catalog\Application\DTOs\ProductData;
use App\Modules\Catalog\Domain\Contracts\BrandRepositoryInterface;
use App\Modules\Catalog\Domain\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class CreateProduct
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
        private readonly BrandRepositoryInterface $brandRepository,
    ) {}

    public function execute(ProductData $data): Product
    {
        $this->validate($data);

        return DB::transaction(function () use ($data) {
            $product = $this->repository->create($data);

            if ($data->categoryIds !== []) {
                $this->repository->syncCategories(
                    $product->id,
                    $data->categoryIds
                );
            }

            return $product->fresh([
                'brand',
                'categories',
                'variants',
                'images',
            ]);
        });
    }

    private function validate(ProductData $data): void
    {
        if ($this->repository->findBySlug($data->slug)) {
            throw new RuntimeException("Product slug [{$data->slug}] already exists.");
        }

        if ($data->sku !== null && $this->repository->skuExists($data->sku)) {
            throw new RuntimeException("SKU [{$data->sku}] already exists.");
        }

        if ($data->brandId !== null) {
            $brand = $this->brandRepository->findById($data->brandId);

            if ($brand === null) {
                throw new RuntimeException('Brand not found.');
            }

            if (!$brand->isActive()) {
                throw new RuntimeException('Cannot assign an inactive brand to a product.');
            }
        }

        if ($data->productType === 'simple') {
            return;
        }

        if ($data->productType !== 'variable') {
            throw new RuntimeException("Unsupported product type [{$data->productType}].");
        }
    }
}
