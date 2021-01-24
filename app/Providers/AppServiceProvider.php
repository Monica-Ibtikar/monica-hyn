<?php

namespace App\Providers;

use App\Models\System\Client;
use App\Models\Tenant\Attribute;
use App\Models\Tenant\Order;
use App\Models\Tenant\Product;
use App\Models\Tenant\User;
use App\Observers\ClientObserver;
use App\Observers\ProductObserver;
use App\Repositories\AttributeRepository;
use App\Repositories\ClientRepository;
use App\Repositories\Contracts\AttributeRepositoryInterface;
use App\Repositories\Contracts\ClientRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\PassportClientRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Repositories\PassportClientRepository;
use App\Repositories\ProductRepository;
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
        Product::observe(ProductObserver::class);
        $this->app->bind(ClientRepositoryInterface::class, function ($app) {
            return new ClientRepository(Client::class);
        });
        $this->app->bind(UserRepositoryInterface::class, function ($app) {
            return new UserRepository(User::class);
        });
        $this->app->bind(PassportClientRepositoryInterface::class, function ($app) {
            return new PassportClientRepository(PassportClient::class);
        });
        $this->app->bind(AttributeRepositoryInterface::class, function ($app) {
            return new AttributeRepository(Attribute::class);
        });
        $this->app->bind(ProductRepositoryInterface::class, function ($app) {
            return new ProductRepository(Product::class);
        });
        $this->app->bind(OrderRepositoryInterface::class, function ($app) {
            return new OrderRepository(Order::class);
        });
    }
}
