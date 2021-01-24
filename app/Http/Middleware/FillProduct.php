<?php

namespace App\Http\Middleware;

use App\Services\ProductService;
use Closure;
use Illuminate\Support\Arr;

class FillProduct
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $inputProducts = $request->input('products');
        $products = $this->productService->getProductsByIds(Arr::pluck($inputProducts, "id"));
        $request->merge(["product_objects" => $products]);
        return $next($request);
    }
}
