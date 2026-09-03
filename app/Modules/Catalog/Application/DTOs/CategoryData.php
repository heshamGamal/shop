<?php

namespace App\Modules\Catalog\Application\DTOs;

final readonly class CategoryData
{
    public function __construct(
            public string $name,
                    public string $slug,
                            public ?int $parentId = null,
                                    public ?string $description = null,
                                            public ?string $imagePath = null,
                                                    public bool $isActive = true,
                                                            public int $sortOrder = 0,
                                                                ) {
                                                                    }
                                                                    }