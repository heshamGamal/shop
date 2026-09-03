<?php

namespace App\Modules\Settings;

use App\Modules\Settings\Domain\Contracts\SettingRepositoryInterface;
use App\Modules\Settings\Infrastructure\Persistence\EloquentSettingRepository;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    public function register(): void
        {
                $this->app->bind(
                            SettingRepositoryInterface::class,
                                        EloquentSettingRepository::class
                                                );
                                                    }

                                                        public function boot(): void
                                                            {
                                                                    //
                                                                        }
                                                                        }