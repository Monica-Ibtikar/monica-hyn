<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProduct;
use App\Http\Requests\UploadImage;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SuccessResource;
use App\Services\ProductService;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $products = $this->productService->index();
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProduct $request
     * @return SuccessResource
     */
    public function store(StoreProduct $request)
    {
        $this->productService->store($request->input());
        return new SuccessResource(Response::HTTP_CREATED);
    }

    /**
     * Upload Image
     *
     * @param UploadImage $request
     * @param $id
     * @return SuccessResource
     */
    public function uploadImage(UploadImage $request, $id)
    {
        $this->productService->uploadImage($request->file('image'), $id);
        return new SuccessResource(Response::HTTP_OK);
    }
}
