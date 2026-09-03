<?php

namespace App\Modules\Settings\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Settings\Application\Settings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct(
            private readonly Settings $settings,
                ) {
                    }

                        public function index(): JsonResponse
                            {
                                    return response()->json([
                                                'data' => $this->settings->getSettingGroups(),
                                                        ]);
                                                            }

                                                                public function show(string $key): JsonResponse
                                                                    {
                                                                            return response()->json([
                                                                                        'key' => $key,
                                                                                                    'value' => $this->settings->get($key),
                                                                                                            ]);
                                                                                                                }

                                                                                                                    public function update(Request $request, string $key): JsonResponse
                                                                                                                        {
                                                                                                                                $validated = $request->validate([
                                                                                                                                            'group' => ['required', 'string', 'max:100'],
                                                                                                                                                        'value' => ['nullable'],
                                                                                                                                                                    'type' => [
                                                                                                                                                                                    'required',
                                                                                                                                                                                                    'string',
                                                                                                                                                                                                                    'in:string,boolean,integer,float,json',
                                                                                                                                                                                                                                ],
                                                                                                                                                                                                                                            'description' => ['nullable', 'string'],
                                                                                                                                                                                                                                                    ]);

                                                                                                                                                                                                                                                            $this->settings->set(
                                                                                                                                                                                                                                                                        group: $validated['group'],
                                                                                                                                                                                                                                                                                    key: $key,
                                                                                                                                                                                                                                                                                                value: $validated['value'] ?? null,
                                                                                                                                                                                                                                                                                                            type: $validated['type'],
                                                                                                                                                                                                                                                                                                                        description: $validated['description'] ?? null,
                                                                                                                                                                                                                                                                                                                                );

                                                                                                                                                                                                                                                                                                                                        return response()->json([
                                                                                                                                                                                                                                                                                                                                                    'message' => 'Setting updated successfully.',
                                                                                                                                                                                                                                                                                                                                                                'key' => $key,
                                                                                                                                                                                                                                                                                                                                                                            'value' => $this->settings->get($key),
                                                                                                                                                                                                                                                                                                                                                                                    ]);
                                                                                                                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                                                                                                                        }