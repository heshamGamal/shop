<?php

namespace App\Modules\Catalog\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttributeValueRequest extends FormRequest
{
    public function authorize(): bool
        {
                return true;
                    }

                        public function rules(): array
                            {
                                    return [
                                                'attribute_id' => [
                                                                'required',
                                                                                'integer',
                                                                                                'exists:attributes,id',
                                                                                                            ],

                                                                                                                        'value' => [
                                                                                                                                        'required',
                                                                                                                                                        'string',
                                                                                                                                                                        'max:255',
                                                                                                                                                                                    ],

                                                                                                                                                                                                'slug' => [
                                                                                                                                                                                                                'required',
                                                                                                                                                                                                                                'string',
                                                                                                                                                                                                                                                'max:255',
                                                                                                                                                                                                                                                                'alpha_dash',
                                                                                                                                                                                                                                                                            ],

                                                                                                                                                                                                                                                                                        'display_value' => [
                                                                                                                                                                                                                                                                                                        'nullable',
                                                                                                                                                                                                                                                                                                                        'string',
                                                                                                                                                                                                                                                                                                                                        'max:255',
                                                                                                                                                                                                                                                                                                                                                    ],

                                                                                                                                                                                                                                                                                                                                                                'color_hex' => [
                                                                                                                                                                                                                                                                                                                                                                                'nullable',
                                                                                                                                                                                                                                                                                                                                                                                                'regex:/^#[0-9A-Fa-f]{6}$/',
                                                                                                                                                                                                                                                                                                                                                                                                            ],

                                                                                                                                                                                                                                                                                                                                                                                                                        'sort_order' => [
                                                                                                                                                                                                                                                                                                                                                                                                                                        'sometimes',
                                                                                                                                                                                                                                                                                                                                                                                                                                                        'integer',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        'min:0',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ],
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ];
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                }