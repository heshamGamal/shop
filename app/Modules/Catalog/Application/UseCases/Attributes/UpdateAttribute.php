<?php

namespace App\Modules\Catalog\Application\UseCases\Attributes;

use App\Models\Attribute;
use App\Modules\Catalog\Application\DTOs\AttributeData;
use App\Modules\Catalog\Domain\Contracts\AttributeRepositoryInterface;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class UpdateAttribute
{
    public function __construct(
        private readonly AttributeRepositoryInterface $repository,
    ) {}

    public function execute(int $id, AttributeData $data): Attribute
    {
        $attribute = $this->repository->findById($id);

        if ($attribute === null) {
            throw new RuntimeException('Attribute not found.');
        }

        $existing = $this->repository->findBySlug($data->slug);

        if (
            $existing !== null &&
            $existing->id !== $id
        ) {
            throw new RuntimeException(
                "Attribute slug [{$data->slug}] already exists."
            );
        }

        if (
            $attribute->is_variant &&
            !$data->isVariant &&
            $attribute->values()
                ->whereHas('variants')
                ->exists()
        ) {
            throw new RuntimeException(
                'Cannot disable variant usage for an attribute that is already used by product variants.'
            );
        }

        return DB::transaction(
            fn () => $this->repository->update($id, $data)
        );
    }
}
