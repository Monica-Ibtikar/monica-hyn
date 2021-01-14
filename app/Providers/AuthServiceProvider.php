<?php

namespace App\Providers;

use App\Models\Tenant\Passport\AuthCode;
use App\Models\Tenant\Passport\Client;
use App\Models\Tenant\Passport\PersonalAccessClient;
use App\Models\Tenant\Passport\RefreshToken;
use App\Models\Tenant\Passport\Token;
use Hyn\Tenancy\Environment;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Console\ClientCommand;
use Laravel\Passport\Console\InstallCommand;
use Laravel\Passport\Console\KeysCommand;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if(app(Environment::class)->tenant()){
            Passport::useTokenModel(Token::class);
            Passport::useClientModel(Client::class);
            Passport::useAuthCodeModel(AuthCode::class);
            Passport::usePersonalAccessClientModel(PersonalAccessClient::class);
            Passport::useRefreshTokenModel(RefreshToken::class);
        }
        Passport::routes();
    }
}
