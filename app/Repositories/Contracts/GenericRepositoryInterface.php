<?php
/**
 * Created by PhpStorm.
 * User: monica
 * Date: 11/01/21
 * Time: 03:56 م
 */

namespace App\Repositories\Contracts;


interface GenericRepositoryInterface
{
    public function store(array $attributes);
    public function first(array $attributes);
}