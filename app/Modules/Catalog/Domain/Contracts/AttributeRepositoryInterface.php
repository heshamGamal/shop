<?php

namespace App\Modules\Catalog\Domain\Contracts;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Modules\Catalog\Application\DTOs\AttributeData;
use App\Modules\Catalog\Application\DTOs\AttributeValueData;
use Illuminate\Support\Collection;

interface AttributeRepositoryInterface
{
    public function findById(int $id): ?Attribute;

        public function findValueById(int $id): ?AttributeValue;

            public function findBySlug(string $slug): ?Attribute;

                public function getAll(): Collection;

                    public function create(AttributeData $data): Attribute;

                        public function update(int $id, AttributeData $data): Attribute;

                            public function delete(int $id): bool;

                                public function createValue(AttributeValueData $data): AttributeValue;

                                    public function updateValue(
                                            int $id,
                                                    AttributeValueData $data
                                                        ): AttributeValue;

                                                            public function deleteValue(int $id): bool;
                                                            }