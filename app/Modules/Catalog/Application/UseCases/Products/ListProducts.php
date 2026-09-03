<?php

namespace App\Modules\Catalog\Application\UseCases\Products;

use App\Models\Product;
use App\Modules\Catalog\Domain\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Collection;

final class ListProducts
{
    public function __construct(
            private readonly ProductRepositoryInterface $repository,
                ) {}

                    public function execute(): Collection
                        {
                                return $this->repository->getAll();
                                    }
                                    }