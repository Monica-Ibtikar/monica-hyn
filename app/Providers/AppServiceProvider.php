<?php

namespace App\Providers;

use App\Models\System\Client;
use App\Models\Tenant\User;
use App\Observers\ClientObserver;
use App\Repositories\ClientRepository;
use App\Repositories\Contracts\ClientRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\ClientService;
use App\Services\Contracts\CreateTenant;
use App\Services\CreateTenantService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\Client as ClientServiceInterface;
use App\Services\Contracts\User as UserServiceInterface;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
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
    }
}
