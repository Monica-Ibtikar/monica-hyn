<?php

namespace App\Observers;

use App\Models\System\Client;
use App\Services\CreateTenantService;
use Illuminate\Support\Facades\Artisan;

class ClientObserver
{
    protected $createTenant;

    public function __construct(CreateTenantService $createTenant)
    {
        $this->createTenant = $createTenant;
    }

    public function created(Client $client)
    {
        $this->createTenant->createWebsite($client);
    }
}
