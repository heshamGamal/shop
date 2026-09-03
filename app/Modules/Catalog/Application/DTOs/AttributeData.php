<?php

namespace App\Modules\Catalog\Application\DTOs;

final readonly class AttributeData
{
    public function __construct(
            public string $name,
                    public string $slug,
                            public string $type = 'select',
                                    public bool $isVariant = true,
                                            public bool $isActive = true,
                                                    public int $sortOrder = 0,
                                                        ) {
                                                            }
                                                            }