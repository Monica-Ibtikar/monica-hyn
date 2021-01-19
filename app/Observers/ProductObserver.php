<?php

namespace App\Observers;

use App\Jobs\IncrementProductCount;
use App\Models\Tenant\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Hyn\Tenancy\Environment;

class ProductObserver
{
    protected  $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function created(Product $product)
    {
        $productCount = $this->productRepository->count();
        $websiteId = app(Environment::class)->tenant()->id;
        IncrementProductCount::dispatch($productCount, $websiteId);
    }
}
