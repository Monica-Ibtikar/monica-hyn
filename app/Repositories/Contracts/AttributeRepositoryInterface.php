<?php
/**
 * Created by PhpStorm.
 * User: monica
 * Date: 17/01/21
 * Time: 06:51 م
 */

namespace App\Repositories\Contracts;


interface AttributeRepositoryInterface extends GenericRepositoryInterface
{
    public function store(array $attributes);
}