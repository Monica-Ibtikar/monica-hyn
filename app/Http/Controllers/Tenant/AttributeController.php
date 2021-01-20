<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttribute;
use App\Http\Resources\AttributeResource;
use App\Http\Resources\SuccessResource;
use App\Services\AttributeService;
use Illuminate\Http\Response;

class AttributeController extends Controller
{
    protected $attributeService;

    public function __construct(AttributeService $service)
    {
        $this->attributeService = $service;
    }

    public function store(StoreAttribute $request)
    {
        $attributeData = $request->input();
        $this->attributeService->store($attributeData);
        return new SuccessResource(Response::HTTP_CREATED);
    }

    public function index()
    {
        $attributes = $this->attributeService->index();
        return AttributeResource::collection($attributes);
    }

}
