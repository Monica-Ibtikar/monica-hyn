<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AvailableQuantity implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $productQuantities
     * @return bool
     */
    public function passes($attribute, $productQuantities)
    {
        $products = request()->product_objects;
        foreach ($productQuantities as $productQuantity) {
            $product = $products->firstWhere("id", $productQuantity["id"]);
            if($productQuantity["quantity"] > optional($product->inventory)->available) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid quantities';
    }
}
