<?php

namespace App\Providers;

use App\Models\System\Client;
use App\Models\Tenant\User;
use App\Observers\ClientObserver;
use App\Repositories\ClientRepository;
use App\Repositories\Contracts\ClientRepositoryInterface;
use App\Repositories\Contracts\PassportClientRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\PassportClientRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use App\Models\Tenant\Passport\Client as PassportClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Passport::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Client::observe(ClientObserver::class);
        $this->app->bind(ClientRepositoryInterface::class, function ($app) {
            return new ClientRepository(Client::class);
        });
        $this->app->bind(UserRepositoryInterface::class, function ($app) {
            return new UserRepository(User::class);
        });
        $this->app->bind(PassportClientRepositoryInterface::class, function ($app) {
            return new PassportClientRepository(PassportClient::class);
        });
    }
}
