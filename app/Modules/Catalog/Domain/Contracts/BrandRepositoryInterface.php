<?php

namespace App\Modules\Catalog\Domain\Contracts;

use App\Models\Brand;
use App\Modules\Catalog\Application\DTOs\BrandData;
use Illuminate\Support\Collection;

interface BrandRepositoryInterface
{
    public function findById(int $id): ?Brand;

        public function findBySlug(string $slug): ?Brand;

            public function getAll(): Collection;

                public function create(BrandData $data): Brand;

                    public function update(int $id, BrandData $data): Brand;

                        public function delete(int $id): bool;
                        }