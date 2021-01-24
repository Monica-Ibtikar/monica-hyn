<?php
/**
 * Created by PhpStorm.
 * User: monica
 * Date: 17/01/21
 * Time: 09:40 م
 */

namespace App\Repositories;


use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository extends AbstractGenericRepository implements ProductRepositoryInterface
{
    public function store(array $attributes)
    {
        $product = parent::store($attributes);
        $product->variations()->sync($attributes['variation_ids']);
    }

    public function count()
    {
        return $this->model::count();
    }

    public function createInventory($product, $quantity)
    {
        $product->inventory()->create(["available" => $quantity]);
    }

    public function updateInventory($product, $quantity, $attribute = "available")
    {
        $product->inventory->lockForUpdate();
        $product->inventory->$attribute += $quantity;
        $product->inventory->save();
    }

    public function getProductsWithVariations()
    {
        return $this->model::with('variations')->get();
    }

    public function paginateProductsWithInventory()
    {
        return $this->model::with('inventory')->paginate();
    }

    public function getProductsByIds(array $ids)
    {
        $products = $this->model::with('inventory')->whereIn("id", $ids)->get();
        return $products;
    }
}