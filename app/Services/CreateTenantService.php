<?php
/**
 * Created by PhpStorm.
 * User: monica
 * Date: 11/01/21
 * Time: 06:24 م
 */

namespace App\Services;

use App\Models\System\Client;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;

class CreateTenantService
{
    public function createWebsite(Client $client)
    {
        $website = new Website;
        app(WebsiteRepository::class)->create($website);
        $this->createHostname($website, $client->name);
        $client->website()->associate($website);
        $client->save();
    }

    public function createHostname($website, $clientName)
    {
        $hostname = new Hostname;
        $hostname->fqdn = $clientName.".".env('SYS_FQDN');
        $hostname = app(HostnameRepository::class)->create($hostname);
        app(HostnameRepository::class)->attach($hostname, $website);
    }
}