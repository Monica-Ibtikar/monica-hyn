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
use Carbon\Carbon;
use Hyn\Tenancy\Environment;
use Illuminate\Support\Facades\DB;

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

    public function store(array $attributes)
    {
        $websiteUuid = app(Environment::class)->tenant()->uuid;
        DB::transaction(function () use($attributes, $websiteUuid){
            $orderId = DB::table("{$websiteUuid}.orders")->insertGetId([
                "customer_name" => $attributes["customer_name"],
                "customer_phone" => $attributes["customer_phone"],
                "status" => $attributes["status"],
                "total" => $attributes["total"],
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);
            data_fill($attributes, "pivot_data.*.order_id", $orderId);
            foreach ($attributes["products"] as $product) {
                DB::table("{$websiteUuid}.inventories")->where(['product_id' => $product["id"]])
                    ->lockForUpdate()->increment('pending', $product["quantity"]);
                DB::table("{$websiteUuid}.inventories")->where(['product_id' => $product["id"]])
                    ->lockForUpdate()->decrement('available', $product["quantity"]);
            }
            DB::table("{$websiteUuid}.order_product")->insert($attributes["pivot_data"]);
        });
    }
}