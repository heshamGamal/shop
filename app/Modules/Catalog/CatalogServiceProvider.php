<?php

namespace App\Modules\Catalog;

use App\Modules\Catalog\Domain\Contracts\AttributeRepositoryInterface;
use App\Modules\Catalog\Domain\Contracts\BrandRepositoryInterface;
use App\Modules\Catalog\Domain\Contracts\CategoryRepositoryInterface;
use App\Modules\Catalog\Domain\Contracts\ProductRepositoryInterface;
use App\Modules\Catalog\Infrastructure\Persistence\EloquentAttributeRepository;
use App\Modules\Catalog\Infrastructure\Persistence\EloquentBrandRepository;
use App\Modules\Catalog\Infrastructure\Persistence\EloquentCategoryRepository;
use App\Modules\Catalog\Infrastructure\Persistence\EloquentProductRepository;
use Illuminate\Support\ServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{
    public function register(): void
        {
                $this->app->bind(
                            CategoryRepositoryInterface::class,
                                        EloquentCategoryRepository::class
                                                );

                                                        $this->app->bind(
                                                                    BrandRepositoryInterface::class,
                                                                                EloquentBrandRepository::class
                                                                                        );

                                                                                                $this->app->bind(
                                                                                                            AttributeRepositoryInterface::class,
                                                                                                                        EloquentAttributeRepository::class
                                                                                                                                );

                                                                                                                                        $this->app->bind(
                                                                                                                                                    ProductRepositoryInterface::class,
                                                                                                                                                                EloquentProductRepository::class
                                                                                                                                                                        );
                                                                                                                                                                            }

                                                                                                                                                                                public function boot(): void
                                                                                                                                                                                    {
                                                                                                                                                                                            //
                                                                                                                                                                                                }
                                                                                                                                                                                                }