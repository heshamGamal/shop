<?php

namespace App\Modules\Catalog\Application\UseCases\Attributes;

use App\Models\Attribute;
use App\Modules\Catalog\Domain\Contracts\AttributeRepositoryInterface;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class DeleteAttribute
{
    public function __construct(
        private readonly AttributeRepositoryInterface $repository,
    ) {}

    public function execute(int $id): bool
    {
        $attribute = $this->repository->findById($id);

        if ($attribute === null) {
            throw new RuntimeException('Attribute not found.');
        }

        if (
            $attribute->values()
                ->whereHas('variants')
                ->exists()
        ) {
            throw new RuntimeException(
                'Cannot delete an attribute that is used by product variants.'
            );
        }

        return DB::transaction(
            fn () => $this->repository->delete($id)
        );
    }
}
