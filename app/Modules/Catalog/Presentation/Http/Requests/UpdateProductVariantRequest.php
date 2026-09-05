<?php

namespace App\Modules\Catalog\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateProductVariantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'price' => [
                'nullable',
                'numeric',
                'min:0',
                'decimal:0,2',
            ],

            'compare_at_price' => [
                'nullable',
                'numeric',
                'min:0',
                'decimal:0,2',
            ],

            'cost_price' => [
                'nullable',
                'numeric',
                'min:0',
                'decimal:0,2',
            ],

            'sku' => [
                'required',
                'string',
                'max:100',
            ],

            'barcode' => [
                'nullable',
                'string',
                'max:100',
            ],

            'weight' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'length' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'width' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'height' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'is_active' => [
                'sometimes',
                'boolean',
            ],

            'sort_order' => [
                'sometimes',
                'integer',
                'min:0',
            ],

            'attribute_value_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'attribute_value_ids.*' => [
                'integer',
                'distinct',
                'exists:attribute_values,id',
            ],
        ];
    }
}
