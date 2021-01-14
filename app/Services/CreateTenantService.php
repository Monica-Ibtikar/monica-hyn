<?php
/**
 * Created by PhpStorm.
 * User: monica
 * Date: 11/01/21
 * Time: 06:24 م
 */

namespace App\Services;

use App\Models\System\Client;
use App\Models\Tenant\Passport\AuthCode;
use App\Models\Tenant\Passport\PersonalAccessClient;
use App\Models\Tenant\Passport\RefreshToken;
use App\Models\Tenant\Passport\Token;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use App\Models\Tenant\Passport\Client as PassportClient;

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

    protected function createHostname($website, $clientName)
    {
        $hostname = new Hostname;
        $hostname->fqdn = $clientName.".".config("app.url");
        $hostname = app(HostnameRepository::class)->create($hostname);
        app(HostnameRepository::class)->attach($hostname, $website);
        $this->prepareClientEnvironment($website);
        $this->installPassport($website);
    }

    protected function installPassport($website)
    {
        Artisan::call('tenancy:run', ['run' => 'passport:install', '--tenant' => [$website->id]]);
    }

    protected function prepareClientEnvironment($website)
    {
        // switch to client environment
        app(Environment::class)->tenant($website);
        Passport::useTokenModel(Token::class);
        Passport::useClientModel(PassportClient::class);
        Passport::useAuthCodeModel(AuthCode::class);
        Passport::usePersonalAccessClientModel(PersonalAccessClient::class);
        Passport::useRefreshTokenModel(RefreshToken::class);
    }
}