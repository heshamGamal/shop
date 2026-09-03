<?php

namespace App\Modules\Catalog\Application\DTOs;

final readonly class ProductVariantData
{
    public function __construct(
            public int $productId,
                    public ?string $name,
                            public ?string $price,
                                    public ?string $compareAtPrice,
                                            public ?string $costPrice,
                                                    public string $sku,
                                                            public ?string $barcode = null,
                                                                    public ?string $weight = null,
                                                                            public ?string $length = null,
                                                                                    public ?string $width = null,
                                                                                            public ?string $height = null,
                                                                                                    public bool $isActive = true,
                                                                                                            public int $sortOrder = 0,
                                                                                                                    public array $attributeValueIds = [],
                                                                                                                        ) {
                                                                                                                            }
                                                                                                                            }