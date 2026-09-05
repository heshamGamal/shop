<?php

namespace App\Modules\Settings\Application\UseCases;

use App\Models\Setting;
use App\Modules\Settings\Application\DTOs\SettingData;
use App\Modules\Settings\Domain\Contracts\SettingRepositoryInterface;

final class UpdateSetting
{
    public function __construct(
            private readonly SettingRepositoryInterface $settings,
                ) {
                    }

                        public function execute(SettingData $data): Setting
                            {
                                    return $this->settings->save($data);
                                        }
                                        }