<?php

namespace App\Jobs;

use App\Services\ClientService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IncrementProductCount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $productCount;
    protected $websiteId;

    /**
     * Create a new job instance.
     * @param $productCount
     * @param $websiteId
     */
    public function __construct($productCount, $websiteId)
    {
        $this->productCount = $productCount;
        $this->websiteId = $websiteId;
    }

    /**
     * Execute the job.
     *
     * @param ClientService $clientService
     * @return void
     */
    public function handle(ClientService $clientService)
    {
        $clientService->updateProductsCount($this->websiteId, $this->productCount);
    }
}
