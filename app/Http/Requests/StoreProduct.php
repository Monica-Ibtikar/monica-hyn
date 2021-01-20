<?php

namespace App\Http\Requests;

class StoreProduct extends CommonRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sku' => 'required|unique:tenant.products,sku',
            'name' => 'required',
            'price' => 'required|numeric',
            'variation_ids' => $this->requiredArrayRules,
            'variation_ids.*' => 'required|exists:tenant.variations,id'
        ];
    }
}
