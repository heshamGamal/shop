<?php

namespace App\Modules\Catalog\Application\UseCases\Brands;

use App\Models\Brand;
use App\Modules\Catalog\Application\DTOs\BrandData;
use App\Modules\Catalog\Domain\Contracts\BrandRepositoryInterface;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class UpdateBrand
{
    public function __construct(
            private readonly BrandRepositoryInterface $repository,
                ) {
                    }

                        public function execute(int $id, BrandData $data): Brand
                            {
                                    $brand = $this->repository->findById($id);

                                            if ($brand === null) {
                                                        throw new RuntimeException('Brand not found.');
                                                                }

                                                                        $existing = $this->repository->findBySlug($data->slug);

                                                                                if ($existing !== null && $existing->id !== $id) {
                                                                                            throw new RuntimeException(
                                                                                                            "Brand slug [{$data->slug}] already exists."
                                                                                                                        );
                                                                                                                                }

                                                                                                                                        return DB::transaction(
                                                                                                                                                    fn () => $this->repository->update($id, $data)
                                                                                                                                                            );
                                                                                                                                                                }
                                                                                                                                                                }