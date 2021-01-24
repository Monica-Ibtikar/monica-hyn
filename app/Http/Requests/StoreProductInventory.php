<?php

namespace App\Http\Requests;

use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\ProductService;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductInventory extends FormRequest
{
    public function __construct()
    {
        parent::__construct();
        $product = resolve(ProductService::class)->getProductById(request()->product);
        request()->merge(["product" => $product]);
    }

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
            "quantity" => "required|integer|min:".$this->getMinAllowedQuantity()
        ];
    }

    protected function getMinAllowedQuantity()
    {
        $minQuantity = 1;
        if($this->product->inventory && $this->product->inventory->available > 0) {
            $minQuantity = -$this->product->inventory->available;//-ve means remove
        }
        return $minQuantity;
    }
}
