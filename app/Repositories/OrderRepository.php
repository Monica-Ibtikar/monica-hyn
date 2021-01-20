<?php
/**
 * Created by PhpStorm.
 * User: monica
 * Date: 20/01/21
 * Time: 02:31 م
 */

namespace App\Repositories;

use App\Models\Tenant\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;

class OrderRepository extends AbstractGenericRepository implements OrderRepositoryInterface
{
    public function syncProducts(Order $order, array $products)
    {
        $order->products()->sync($products);
    }

    public function paginateAndFilter(array $query)
    {
       return $this->model::where($query)->paginate();
    }
}