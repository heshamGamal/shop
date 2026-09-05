<?php

namespace App\Modules\Catalog\Application\DTOs;

final readonly class ProductData
{
    public function __construct(
            public string $name,
                    public string $slug,
                            public ?string $shortDescription = null,
                                    public ?string $description = null,
                                            public ?int $brandId = null,
                                                    public string $productType = 'simple',
                                                            public string $status = 'draft',
                                                                    public ?string $price = null,
                                                                            public ?string $compareAtPrice = null,
                                                                                    public ?string $costPrice = null,
                                                                                            public ?string $sku = null,
                                                                                                    public ?string $barcode = null,
                                                                                                            public ?string $weight = null,
                                                                                                                    public ?string $length = null,
                                                                                                                            public ?string $width = null,
                                                                                                                                    public ?string $height = null,
                                                                                                                                            public string $weightUnit = 'kg',
                                                                                                                                                    public string $dimensionUnit = 'cm',
                                                                                                                                                            public bool $isActive = true,
                                                                                                                                                                    public bool $isFeatured = false,
                                                                                                                                                                            public int $sortOrder = 0,
                                                                                                                                                                                    public array $categoryIds = [],
                                                                                                                                                                                        ) {
                                                                                                                                                                                            }
                                                                                                                                                                                            }