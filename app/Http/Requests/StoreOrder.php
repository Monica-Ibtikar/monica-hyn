<?php

namespace App\Http\Requests;

use App\Rules\AvailableQuantity;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class StoreOrder extends CommonRequest
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
            "customer_name" => "required",
            "customer_phone" => "required|regex:/^01[0125][0-9]{8}$/",
            "products" => array_merge($this->requiredArrayRules, [new AvailableQuantity()]),
            "products.*.id" => ["required", Rule::exists('tenant.products', 'id')->whereNull('deleted_at')],
            "products.*.quantity" => ["required", "integer"]
        ];
    }

}
