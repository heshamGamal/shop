<?php

namespace App\Modules\Catalog\Application\UseCases\Products;

use App\Models\ProductVariant;
use App\Modules\Catalog\Application\DTOs\ProductVariantData;
use App\Modules\Catalog\Domain\Contracts\AttributeRepositoryInterface;
use App\Modules\Catalog\Domain\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class CreateProductVariant
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly AttributeRepositoryInterface $attributeRepository,
    ) {}

    public function execute(ProductVariantData $data): ProductVariant
    {
        $product = $this->productRepository->findById($data->productId);

        if ($product === null) {
            throw new RuntimeException('Product not found.');
        }

        if (!$product->isVariable()) {
            throw new RuntimeException(
                'Variants can only be added to variable products.'
            );
        }

        if ($data->attributeValueIds === []) {
            throw new RuntimeException(
                'A variant must have at least one attribute value.'
            );
        }

        $attributeValueIds = array_values(
            array_unique(array_map('intval', $data->attributeValueIds))
        );

        $attributeIds = [];

        foreach ($attributeValueIds as $attributeValueId) {
            $value = $this->attributeRepository->findValueById(
                $attributeValueId
            );

            if ($value === null) {
                throw new RuntimeException(
                    "Attribute value [{$attributeValueId}] not found."
                );
            }

            $attribute = $value->attribute;

            if ($attribute === null) {
                throw new RuntimeException(
                    "Attribute for value [{$attributeValueId}] not found."
                );
            }

            if (!$attribute->isVariantAttribute()) {
                throw new RuntimeException(
                    "Attribute [{$attribute->name}] cannot be used for variants."
                );
            }

            if (!$attribute->isActive()) {
                throw new RuntimeException(
                    "Attribute [{$attribute->name}] is inactive."
                );
            }

            if (isset($attributeIds[$attribute->id])) {
                throw new RuntimeException(
                    "A variant cannot contain multiple values from attribute [{$attribute->name}]."
                );
            }

            $attributeIds[$attribute->id] = true;
        }

        if ($this->productRepository->skuExists($data->sku)) {
            throw new RuntimeException(
                "SKU [{$data->sku}] already exists."
            );
        }

        if ($this->productRepository->variantCombinationExists($data->productId, $attributeValueIds)) {
            throw new RuntimeException(
                'A variant with the same attribute combination already exists.'
            );
        }

        return DB::transaction(function () use (
            $data,
            $attributeValueIds
        ) {
            $variant = $this->productRepository->createVariant($data);

            $this->productRepository->syncVariantAttributes(
                $variant->id,
                $attributeValueIds
            );

            return $variant->fresh([
                'product',
                'attributeValues.attribute',
                'images',
            ]);
        });
    }
}
