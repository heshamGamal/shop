<?php

namespace App\Modules\Catalog\Application\UseCases\Brands;

use App\Models\Brand;
use App\Modules\Catalog\Application\DTOs\BrandData;
use App\Modules\Catalog\Domain\Contracts\BrandRepositoryInterface;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class CreateBrand
{
    public function __construct(
            private readonly BrandRepositoryInterface $repository,
                ) {
                    }

                        public function execute(BrandData $data): Brand
                            {
                                    if ($this->repository->findBySlug($data->slug)) {
                                                throw new RuntimeException(
                                                                "Brand slug [{$data->slug}] already exists."
                                                                            );
                                                                                    }

                                                                                            return DB::transaction(
                                                                                                        fn () => $this->repository->create($data)
                                                                                                                );
                                                                                                                    }
                                                                                                                    }