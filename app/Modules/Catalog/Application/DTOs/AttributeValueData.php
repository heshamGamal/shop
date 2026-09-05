<?php

namespace App\Modules\Catalog\Application\DTOs;

final readonly class AttributeValueData
{
    public function __construct(
            public int $attributeId,
                    public string $value,
                            public string $slug,
                                    public ?string $displayValue = null,
                                            public ?string $colorHex = null,
                                                    public int $sortOrder = 0,
                                                        ) {
                                                            }
                                                            }