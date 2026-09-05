<?php

namespace App\Modules\Settings\Infrastructure\Persistence;

use App\Models\Setting;
use App\Modules\Settings\Application\DTOs\SettingData;
use App\Modules\Settings\Domain\Contracts\SettingRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentSettingRepository implements SettingRepositoryInterface
{
    public function findByKey(string $key): ?Setting
        {
                return Setting::query()
                            ->where('key', $key)
                                        ->first();
                                            }

                                                public function getByGroup(string $group): Collection
                                                    {
                                                            return Setting::query()
                                                                        ->where('group', $group)
                                                                                    ->orderBy('key')
                                                                                                ->get();
                                                                                                    }

                                                                                                        public function getAll(): Collection
                                                                                                            {
                                                                                                                    return Setting::query()
                                                                                                                                ->orderBy('group')
                                                                                                                                            ->orderBy('key')
                                                                                                                                                        ->get();
                                                                                                                                                            }

                                                                                                                                                                public function save(SettingData $data): Setting
                                                                                                                                                                    {
                                                                                                                                                                            $setting = Setting::query()->firstOrNew([
                                                                                                                                                                                        'key' => $data->key,
                                                                                                                                                                                                ]);

                                                                                                                                                                                                        $setting->group = $data->group;
                                                                                                                                                                                                                $setting->type = $data->type;
                                                                                                                                                                                                                        $setting->description = $data->description;

                                                                                                                                                                                                                                $setting->value = match ($data->type) {
                                                                                                                                                                                                                                            'boolean' => $data->value ? '1' : '0',

                                                                                                                                                                                                                                                        'integer' => (string) $data->value,

                                                                                                                                                                                                                                                                    'float' => (string) $data->value,

                                                                                                                                                                                                                                                                                'json' => json_encode(
                                                                                                                                                                                                                                                                                                $data->value,
                                                                                                                                                                                                                                                                                                                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                                                                                                                                                                                                                                                                                                                            ),

                                                                                                                                                                                                                                                                                                                                        default => (string) $data->value,
                                                                                                                                                                                                                                                                                                                                                };

                                                                                                                                                                                                                                                                                                                                                        $setting->save();

                                                                                                                                                                                                                                                                                                                                                                return $setting->fresh();
                                                                                                                                                                                                                                                                                                                                                                    }

                                                                                                                                                                                                                                                                                                                                                                        public function delete(string $key): bool
                                                                                                                                                                                                                                                                                                                                                                            {
                                                                                                                                                                                                                                                                                                                                                                                    return Setting::query()
                                                                                                                                                                                                                                                                                                                                                                                                ->where('key', $key)
                                                                                                                                                                                                                                                                                                                                                                                                            ->delete() > 0;
                                                                                                                                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                                                                                                                                }