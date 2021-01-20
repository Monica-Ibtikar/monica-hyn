<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductInventory;
use App\Http\Resources\ProductInventoryResource;
use App\Http\Resources\SuccessResource;
use App\Services\ProductService;
use Illuminate\Http\Response;

class ProductInventoryController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function store(StoreProductInventory $request)
    {
        $this->productService->createOrUpdateInventory($request->product, $request->quantity);
        return new SuccessResource(Response::HTTP_OK);
    }

    public function index($id)
    {
        $product = $this->productService->getProductById($id);
        return new ProductInventoryResource($product);
    }


}
