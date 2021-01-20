<?php
/**
 * Created by PhpStorm.
 * User: monica
 * Date: 20/01/21
 * Time: 02:31 م
 */

namespace App\Repositories\Contracts;


use App\Models\Tenant\Order;

interface OrderRepositoryInterface extends GenericRepositoryInterface
{
    public function syncProducts(Order $order, array $products);
    public function paginateAndFilter(array $query);
}