<?php

namespace App\Modules\Catalog\Application\DTOs;

final readonly class BrandData
{
    public function __construct(
            public string $name,
                    public string $slug,
                            public ?string $description = null,
                                    public ?string $logoPath = null,
                                            public bool $isActive = true,
                                                ) {
                                                    }
                                                    }