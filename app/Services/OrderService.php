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
        $orderData["total"] = $this->calculateTotalAndReserveQuantities($orderData["products"], $orderData["product_objects"]);
        $orderData["status"] = Status::New;
        $order = $this->orderRepo->store($orderData);
        $this->orderRepo->syncProducts($order, $this->prepareSyncData($orderData["products"]));
        return $order;
    }

    protected function calculateTotalAndReserveQuantities($requestProducts, $dbProducts)
    {
        $total = 0;
        array_walk($requestProducts, function ($requestProd) use(&$total, $dbProducts) {
            $dbProduct = $dbProducts->firstWhere("id", $requestProd["id"]);
            $total += $dbProduct->price * $requestProd["quantity"];
            $this->reserveQuantity($dbProduct, $requestProd["quantity"]);
        });
        return $total;
    }

    protected function reserveQuantity($dbProduct, $quantity)
    {
        $this->productRepo->updateInventory($dbProduct, -$quantity);
        $this->productRepo->updateInventory($dbProduct, $quantity, "pending");
    }

    protected function prepareSyncData(array $products)
    {
        $syncData = [];
        array_walk($products, function (&$product) use (&$syncData) {
            //sync data should be in that form to be compatible with the laravel sync function
            $syncData[$product['id']] = [
                'quantity' => $product['quantity'],
            ];
        });
        return $syncData;
    }

    public function paginateAndFilter(array $query)
    {
        $where = [];
        if($query["status"]) {
            $status = Status::coerce($query["status"]);
            $query["status"] = optional($status)->value;
        }
        foreach ($query as $key => $value) {
            $where[] = [$key, "like", "%$value%"];
        }
        return $this->orderRepo->paginateAndFilter($where);
    }
}