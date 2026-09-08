<?php
namespace App\Modules\Catalog\Application\UseCases\Products;

use App\Models\ProductVariant;
use App\Modules\Catalog\Application\DTOs\ProductVariantData;
use App\Modules\Catalog\Domain\Contracts\AttributeRepositoryInterface;
use App\Modules\Catalog\Domain\Contracts\ProductRepositoryInterface;
use App\Modules\Catalog\Domain\Exceptions\BusinessRuleException;
use Illuminate\Support\Facades\DB;

final class UpdateProductVariant
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly AttributeRepositoryInterface $attributeRepository,
    ) {}

    public function execute(
        int $id,
        ProductVariantData $data
    ): ProductVariant {
        $variant = $this->productRepository->findVariantById($id);

        if ($variant === null) {
            throw BusinessRuleException::variantNotFound();
        }

        if ($variant->product_id !== $data->productId) {
            throw BusinessRuleException::variantDoesNotBelongToProduct();
        }

        $product = $this->productRepository->findById($data->productId);

        if ($product === null) {
            throw BusinessRuleException::productNotFound();
        }

        if (!$product->isVariable()) {
            throw BusinessRuleException::variantsOnlyForVariableProducts();
        }

        if ($data->attributeValueIds === []) {
            throw BusinessRuleException::variantRequiresAttributeValue();
        }

        $attributeValueIds = array_values(
            array_unique(
                array_map('intval', $data->attributeValueIds)
            )
        );

        $attributeIds = [];

        foreach ($attributeValueIds as $attributeValueId) {
            $value = $this->attributeRepository->findValueById(
                $attributeValueId
            );

            if ($value === null) {
                throw BusinessRuleException::attributeValueNotFound(
                    $attributeValueId
                );
            }

            $attribute = $value->attribute;

            if ($attribute === null) {
                throw BusinessRuleException::attributeNotFoundForValue(
                    $attributeValueId
                );
            }

            if (!$attribute->isVariantAttribute()) {
                throw BusinessRuleException::attributeCannotBeUsedForVariants(
                    $attribute->name
                );
            }

            if (!$attribute->isActive()) {
                throw BusinessRuleException::attributeInactive(
                    $attribute->name
                );
            }

            if (isset($attributeIds[$attribute->id])) {
                throw BusinessRuleException::multipleValuesFromSameAttribute(
                    $attribute->name
                );
            }

            $attributeIds[$attribute->id] = true;
        }

        if (
            $this->productRepository->skuExists(
                $data->sku,
                $data->productId,
                $id
            )
        ) {
            throw BusinessRuleException::duplicateSku($data->sku);
        }

        if (
            $this->productRepository->variantCombinationExists(
                $data->productId,
                $attributeValueIds,
                $id
            )
        ) {
            throw BusinessRuleException::duplicateVariantCombination();
        }

        return DB::transaction(function () use (
            $id,
            $data,
            $attributeValueIds
        ) {
            $variant = $this->productRepository->updateVariant(
                $id,
                $data
            );

            $this->productRepository->syncVariantAttributes(
                $id,
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
