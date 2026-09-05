<?php

namespace App\Modules\Catalog\Application\UseCases\Attributes;

use App\Models\AttributeValue;
use App\Modules\Catalog\Domain\Contracts\AttributeRepositoryInterface;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class DeleteAttributeValue
{
    public function __construct(
        private readonly AttributeRepositoryInterface $repository,
    ) {}

    public function execute(int $id): bool
    {
        $value = $this->repository->findValueById($id);

        if ($value === null) {
            throw new RuntimeException(
                'Attribute value not found.'
            );
        }

        if ($value->variants()->exists()) {
            throw new RuntimeException(
                'Cannot delete an attribute value that is used by product variants.'
            );
        }

        return DB::transaction(
            fn () => $this->repository->deleteValue($id)
        );
    }
}
