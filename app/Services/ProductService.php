<?php
/**
 * Created by PhpStorm.
 * User: monica
 * Date: 17/01/21
 * Time: 10:04 م
 */

namespace App\Services;

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
        $fullPath = config('app.url')."/storage/$websiteUuid/".$path;
        $this->productRepo->update(["id" => $productId], ['image'=> $fullPath]);
    }

    protected function deleteOldImages($storageDisk, $directory)
    {
        $oldImages = $storageDisk->files($directory);
        $storageDisk->delete($oldImages);
    }

    public function index()
    {
        return $this->productRepo->all();
    }
}