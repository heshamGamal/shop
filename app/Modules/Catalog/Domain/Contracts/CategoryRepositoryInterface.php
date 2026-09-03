<?php

namespace App\Modules\Catalog\Domain\Contracts;

use App\Models\Category;
use App\Modules\Catalog\Application\DTOs\CategoryData;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    public function findById(int $id): ?Category;

        public function findBySlug(string $slug): ?Category;

            public function getAll(): Collection;

                public function create(CategoryData $data): Category;

                    public function update(int $id, CategoryData $data): Category;

                        public function delete(int $id): bool;
                        }