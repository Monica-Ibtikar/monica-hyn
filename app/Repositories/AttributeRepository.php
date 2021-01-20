<?php
/**
 * Created by PhpStorm.
 * User: monica
 * Date: 17/01/21
 * Time: 06:52 م
 */

namespace App\Repositories;


use App\Repositories\Contracts\AttributeRepositoryInterface;
use Illuminate\Support\Arr;

class AttributeRepository extends  AbstractGenericRepository implements AttributeRepositoryInterface
{
    public function store(array $attributes)
    {
        $attribute = parent::store(Arr::only($attributes, 'name'));
        $attribute->variations()->createMany($attributes["variations"]);
    }
}