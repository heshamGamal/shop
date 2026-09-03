<?php

namespace App\Modules\Catalog\Application\UseCases\Attributes;

use App\Models\Attribute;
use App\Modules\Catalog\Application\DTOs\AttributeData;
use App\Modules\Catalog\Domain\Contracts\AttributeRepositoryInterface;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class CreateAttribute
{
    public function __construct(
            private readonly AttributeRepositoryInterface $repository,
                ) {
                    }

                        public function execute(AttributeData $data): Attribute
                            {
                                    if ($this->repository->findBySlug($data->slug)) {
                                                throw new RuntimeException(
                                                                "Attribute slug [{$data->slug}] already exists."
                                                                            );
                                                                                    }

                                                                                            return DB::transaction(
                                                                                                        fn () => $this->repository->create($data)
                                                                                                                );
                                                                                                                    }
                                                                                                                    }