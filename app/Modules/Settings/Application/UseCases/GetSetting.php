<?php

namespace App\Modules\Settings\Application\UseCases;

use App\Modules\Settings\Domain\Contracts\SettingRepositoryInterface;

final class GetSetting
{
    public function __construct(
            private readonly SettingRepositoryInterface $settings,
                ) {
                    }

                        public function execute(
                                string $key,
                                        mixed $default = null,
                                            ): mixed {
                                                    $setting = $this->settings->findByKey($key);

                                                            if ($setting === null) {
                                                                        return $default;
                                                                                }

                                                                                        return $setting->getTypedValue();
                                                                                            }
                                                                                            }