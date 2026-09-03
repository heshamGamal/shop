<?php

namespace App\Modules\Settings\Application\UseCases;

use App\Modules\Settings\Domain\Contracts\SettingRepositoryInterface;
use Illuminate\Support\Collection;

final class GetSettingsByGroup
{
    public function __construct(
            private readonly SettingRepositoryInterface $settings,
                ) {
                    }

                        public function execute(string $group): Collection
                            {
                                    return $this->settings->getByGroup($group);
                                        }
                                        }