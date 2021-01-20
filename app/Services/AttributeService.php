<?php
/**
 * Created by PhpStorm.
 * User: monica
 * Date: 17/01/21
 * Time: 06:48 م
 */

namespace App\Services;


use App\Repositories\Contracts\AttributeRepositoryInterface;

class AttributeService
{
    protected $attributeRepo;

    public function __construct(AttributeRepositoryInterface $attributeRepository)
    {
        $this->attributeRepo = $attributeRepository;
    }

    public function store(array $attributeData)
    {
        $this->attributeRepo->store($attributeData);
    }

    public function index()
    {
        return $this->attributeRepo->all();
    }
}