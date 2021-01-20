<?php
/**
 * Created by PhpStorm.
 * User: monica
 * Date: 11/01/21
 * Time: 05:14 م
 */

namespace App\Services;


use App\Repositories\Contracts\ClientRepositoryInterface;

class ClientService
{
    protected $clientRepo;

    public function __construct()
    {
        $this->clientRepo = resolve(ClientRepositoryInterface::class);
    }

    public function store(array $attributes)
    {
        $this->clientRepo->store($attributes);
    }

    public function updateProductsCount($websiteId, $productCount)
    {
        $this->clientRepo->update(["website_id" => $websiteId], ["product_count" => $productCount]);
    }
}