<?php
/**
 * Created by PhpStorm.
 * User: monica
 * Date: 11/01/21
 * Time: 05:00 م
 */

namespace App\Repositories;


use App\Repositories\Contracts\GenericRepositoryInterface;

class AbstractGenericRepository implements GenericRepositoryInterface
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function store(array $attributes)
    {
        $this->model::create($attributes);
    }

    public function first(array $attributes)
    {
        return $this->model::where($attributes)->first();
    }
}