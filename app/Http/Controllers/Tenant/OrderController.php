<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrder;
use App\Http\Resources\OrderResource;
use App\Http\Resources\SuccessResource;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
      $this->orderService = $orderService;
        $this->middleware('fill_product')->only(['store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $orders = $this->orderService->paginateAndFilter($request->query());
        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreOrder|Request $request
     * @return SuccessResource
     */
    public function store(StoreOrder $request)
    {
        $order = $this->orderService->createOrder($request->input());
        return new SuccessResource(Response::HTTP_CREATED, "Order has been created successfully",
            new OrderResource($order));
    }

}
