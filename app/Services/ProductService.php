<?php
/**
 * Created by PhpStorm.
 * User: monica
 * Date: 17/01/21
 * Time: 10:04 م
 */

namespace App\Services;

use App\Models\Tenant\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Hyn\Tenancy\Environment;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    protected $productRepo;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepo = $productRepository;
    }

    public function store(array $attributes)
    {
        $this->productRepo->store($attributes);
    }

    public function uploadImage($image, $productId)
    {
        $directory = 'products'.'/'.$productId;
        $storageDisk = Storage::disk('tenant');
        $this->deleteOldImages($storageDisk, $directory);
        $path = $storageDisk
            ->putFileAs($directory, $image, $productId.'.'.$image->extension()); // products/1/1.jpg
        $websiteUuid =  $website   = app(Environment::class)->tenant()->uuid;
        $relativePath = Storage::url("$websiteUuid/$path");
        $this->productRepo->update(["id" => $productId], ['image'=> $relativePath]);
    }

    protected function deleteOldImages($storageDisk, $directory)
    {
        $oldImages = $storageDisk->files($directory);
        $storageDisk->delete($oldImages);
    }

    public function indexProducts()
    {
        return $this->productRepo->getProductsWithVariations();
    }

    public function createOrUpdateInventory(Product $product, $quantity)
    {
        if($product->inventory) {
            $this->productRepo->updateInventory($product, $quantity);
        } else {
            $this->productRepo->createInventory($product, $quantity);
        }
    }

    public function indexWithInventory()
    {
        return $this->productRepo->paginateProductsWithInventory();
    }

    public function getProductById($id)
    {
        return $this->productRepo->first(["id" => $id]);
    }

    public function getProductsByIds(array $ids)
    {
        return $this->productRepo->getProductsByIds($ids);
    }
}