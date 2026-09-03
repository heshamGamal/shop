<?php

namespace App\Modules\Catalog\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBrandRequest extends FormRequest
{
    public function authorize(): bool
        {
                return true;
                    }

                        public function rules(): array
                            {
                                    $brandId = $this->route('brand');

                                            return [
                                                        'name' => [
                                                                        'required',
                                                                                        'string',
                                                                                                        'max:255',
                                                                                                                    ],

                                                                                                                                'slug' => [
                                                                                                                                                'required',
                                                                                                                                                                'string',
                                                                                                                                                                                'max:255',
                                                                                                                                                                                                'alpha_dash',
                                                                                                                                                                                                                Rule::unique('brands', 'slug')
                                                                                                                                                                                                                                    ->ignore($brandId),
                                                                                                                                                                                                                                                ],

                                                                                                                                                                                                                                                            'description' => [
                                                                                                                                                                                                                                                                            'nullable',
                                                                                                                                                                                                                                                                                            'string',
                                                                                                                                                                                                                                                                                                        ],

                                                                                                                                                                                                                                                                                                                    'logo_path' => [
                                                                                                                                                                                                                                                                                                                                    'nullable',
                                                                                                                                                                                                                                                                                                                                                    'string',
                                                                                                                                                                                                                                                                                                                                                                    'max:2048',
                                                                                                                                                                                                                                                                                                                                                                                ],

                                                                                                                                                                                                                                                                                                                                                                                            'is_active' => [
                                                                                                                                                                                                                                                                                                                                                                                                            'sometimes',
                                                                                                                                                                                                                                                                                                                                                                                                                            'boolean',
                                                                                                                                                                                                                                                                                                                                                                                                                                        ],
                                                                                                                                                                                                                                                                                                                                                                                                                                                ];
                                                                                                                                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                                                                                                                                    }