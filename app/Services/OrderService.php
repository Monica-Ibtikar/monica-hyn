<?php
/**
 * Created by PhpStorm.
 * User: monica
 * Date: 20/01/21
 * Time: 02:32 م
 */

namespace App\Services;


use App\Enums\Status;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Carbon\Carbon;

class OrderService
{
    protected $orderRepo;
    protected $productRepo;

    public function __construct(OrderRepositoryInterface $orderRepository, ProductRepositoryInterface $productRepository)
    {
        $this->orderRepo = $orderRepository;
        $this->productRepo = $productRepository;
    }

    public function createOrder(array $orderData)
    {
        $orderData["total"] = $this->calculateTotal($orderData["products"], $orderData["product_objects"]);
        $orderData["status"] = Status::NEW;
        $orderData["pivot_data"] = $this->preparePivotData($orderData["products"]);
        $this->orderRepo->store($orderData);
    }

    protected function calculateTotal($requestProducts, $dbProducts)
    {
        $total = 0;
        array_walk($requestProducts, function ($requestProd) use(&$total, $dbProducts) {
            $dbProduct = $dbProducts->firstWhere("id", $requestProd["id"]);
            $total += $dbProduct->price * $requestProd["quantity"];
        });
        return $total;
    }

    protected function preparePivotData(array $products)
    {
        $orderProductInserts = [];
        array_walk($products, function (&$product) use (&$orderProductInserts) {
            $orderProductInserts[] = [
                "product_id" => $product["id"],
                "quantity" => $product["quantity"],
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ];
        });
        return $orderProductInserts;
    }

    public function paginateAndFilter(array $query)
    {
        $where = [];
        if(array_key_exists("status", $query)) {
            $status = Status::coerce($query["status"]);
            $query["status"] = optional($status)->value;
        }
        foreach ($query as $key => $value) {
            $where[] = [$key, "like", "%$value%"];
        }
        return $this->orderRepo->paginateAndFilter($where);
    }
}