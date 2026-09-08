<?php

namespace App\Modules\Catalog\Application\UseCases\Products;

use App\Models\Product;
use App\Modules\Catalog\Application\DTOs\ProductData;
use App\Modules\Catalog\Domain\Contracts\BrandRepositoryInterface;
use App\Modules\Catalog\Domain\Contracts\CategoryRepositoryInterface;
use App\Modules\Catalog\Domain\Contracts\ProductRepositoryInterface;
use App\Modules\Catalog\Domain\Exceptions\BusinessRuleException;
use Illuminate\Support\Facades\DB;

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
            throw BusinessRuleException::productNotFound();
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
            throw BusinessRuleException::duplicateSlug(
                $data->slug
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
            throw BusinessRuleException::duplicateProductSku(
                $data->sku
            );
        }

        if ($data->brandId !== null) {
            $brand = $this->brandRepository->findById(
                $data->brandId
            );

            if ($brand === null) {
                throw BusinessRuleException::brandNotFound(
                    $data->brandId
                );
            }

            if (!$brand->isActive()) {
                throw BusinessRuleException::brandInactive(
                    $data->brandId
                );
            }
        }

        if (!in_array(
            $data->productType,
            ['simple', 'variable'],
            true
        )) {
            throw BusinessRuleException::invalidProductType(
                $data->productType
            );
        }

        if (
            $product->isVariable() &&
            $data->productType === 'simple' &&
            $product->variants()->exists()
        ) {
            throw BusinessRuleException::cannotConvertVariableToSimple();
        }

        foreach ($data->categoryIds as $categoryId) {
            $categoryId = (int) $categoryId;

            $category = $this->categoryRepository->findById(
                $categoryId
            );

            if ($category === null) {
                throw BusinessRuleException::categoryNotFound(
                    $categoryId
                );
            }

            if (!$category->isActive()) {
                throw BusinessRuleException::categoryInactive(
                    $categoryId
                );
            }
        }

        if (
            $data->status === 'published' &&
            $data->productType === 'variable' &&
            !$product->variants()->exists()
        ) {
            throw BusinessRuleException::variableProductRequiresVariants();
        }
    }
}
