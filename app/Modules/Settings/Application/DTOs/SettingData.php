<?php

namespace App\Modules\Settings\Application\DTOs;

final readonly class SettingData
{
    public function __construct(
            public string $group,
                    public string $key,
                            public mixed $value,
                                    public string $type = 'string',
                                            public ?string $description = null,
                                                ) {
                                                    }
                                                    }