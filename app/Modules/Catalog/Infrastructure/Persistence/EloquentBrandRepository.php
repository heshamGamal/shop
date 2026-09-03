<?php

namespace App\Modules\Catalog\Infrastructure\Persistence;

use App\Models\Brand;
use App\Modules\Catalog\Application\DTOs\BrandData;
use App\Modules\Catalog\Domain\Contracts\BrandRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentBrandRepository implements BrandRepositoryInterface
{
    public function findById(int $id): ?Brand
        {
                return Brand::query()->find($id);
                    }

                        public function findBySlug(string $slug): ?Brand
                            {
                                    return Brand::query()
                                                ->where('slug', $slug)
                                                            ->first();
                                                                }

                                                                    public function getAll(): Collection
                                                                        {
                                                                                return Brand::query()
                                                                                            ->withCount('products')
                                                                                                        ->orderBy('name')
                                                                                                                    ->get();
                                                                                                                        }

                                                                                                                            public function create(BrandData $data): Brand
                                                                                                                                {
                                                                                                                                        return Brand::query()->create([
                                                                                                                                                    'name' => $data->name,
                                                                                                                                                                'slug' => $data->slug,
                                                                                                                                                                            'description' => $data->description,
                                                                                                                                                                                        'logo_path' => $data->logoPath,
                                                                                                                                                                                                    'is_active' => $data->isActive,
                                                                                                                                                                                                            ]);
                                                                                                                                                                                                                }

                                                                                                                                                                                                                    public function update(
                                                                                                                                                                                                                            int $id,
                                                                                                                                                                                                                                    BrandData $data
                                                                                                                                                                                                                                        ): Brand {
                                                                                                                                                                                                                                                $brand = Brand::query()->findOrFail($id);

                                                                                                                                                                                                                                                        $brand->update([
                                                                                                                                                                                                                                                                    'name' => $data->name,
                                                                                                                                                                                                                                                                                'slug' => $data->slug,
                                                                                                                                                                                                                                                                                            'description' => $data->description,
                                                                                                                                                                                                                                                                                                        'logo_path' => $data->logoPath,
                                                                                                                                                                                                                                                                                                                    'is_active' => $data->isActive,
                                                                                                                                                                                                                                                                                                                            ]);

                                                                                                                                                                                                                                                                                                                                    return $brand->fresh();
                                                                                                                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                                                                                                                            public function delete(int $id): bool
                                                                                                                                                                                                                                                                                                                                                {
                                                                                                                                                                                                                                                                                                                                                        return Brand::query()
                                                                                                                                                                                                                                                                                                                                                                    ->whereKey($id)
                                                                                                                                                                                                                                                                                                                                                                                ->delete() > 0;
                                                                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                                                                    }