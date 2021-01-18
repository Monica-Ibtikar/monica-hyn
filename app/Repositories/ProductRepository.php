<?php
/**
 * Created by PhpStorm.
 * User: monica
 * Date: 17/01/21
 * Time: 09:40 م
 */

namespace App\Repositories;


use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Arr;

class ProductRepository extends AbstractGenericRepository implements ProductRepositoryInterface
{
    public function store(array $attributes)
    {
        $product = parent::store(Arr::except($attributes, 'variation_ids'));
        $product->variations()->sync($attributes['variation_ids']);
    }
}