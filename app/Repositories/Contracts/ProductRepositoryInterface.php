<?php
/**
 * Created by PhpStorm.
 * User: monica
 * Date: 17/01/21
 * Time: 09:40 م
 */

namespace App\Repositories\Contracts;


interface ProductRepositoryInterface extends GenericRepositoryInterface
{
    public function store(array $attributes);
}