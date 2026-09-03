<?php

namespace App\Modules\Catalog\Application\UseCases\Attributes;

use App\Models\AttributeValue;
use App\Modules\Catalog\Application\DTOs\AttributeValueData;
use App\Modules\Catalog\Domain\Contracts\AttributeRepositoryInterface;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class CreateAttributeValue
{
    public function __construct(
            private readonly AttributeRepositoryInterface $repository,
                ) {
                    }

                        public function execute(AttributeValueData $data): AttributeValue
                            {
                                    $attribute = $this->repository->findById($data->attributeId);

                                            if ($attribute === null) {
                                                        throw new RuntimeException('Attribute not found.');
                                                                }

                                                                        if (!$attribute->isActive()) {
                                                                                    throw new RuntimeException(
                                                                                                    'Cannot add a value to an inactive attribute.'
                                                                                                                );
                                                                                                                        }

                                                                                                                                return DB::transaction(
                                                                                                                                            fn () => $this->repository->createValue($data)
                                                                                                                                                    );
                                                                                                                                                        }
                                                                                                                                                           }
                                                                                                                