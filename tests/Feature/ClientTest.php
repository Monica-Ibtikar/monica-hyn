<?php

namespace Tests\Feature;

use App\Models\System\Client;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Database\Connection;
use Hyn\Tenancy\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public  function tearDown(): void
    {
        $websites = Website::all();
        $websites->each(function($website) {
            app(WebsiteRepository::class)->delete($website);
        });
    }

    public function test_create_client_with_no_name_expects_422_status()
    {
        $response = $this->postJson(route('clients.store'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_create_client_with_duplicated_name_expects_422_status()
    {
        $client = factory(Client::class)->create();
        $response = $this->postJson(route('clients.store'), ["name" => $client->name]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_create_client_with_valid_name_expects_success()
    {
        $response = $this->postJson(route('clients.store'), ["name" => $this->faker->word]);
        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(['message', 'data' ]);
    }

    public function test_create_client_with_valid_name_expects_creating_tenant()
    {
        $clientName = $this->faker->word;
        $this->postJson(route('clients.store'), ["name" => $clientName]);
        $this->assertDatabaseHas('hostnames', [
            'fqdn' => $clientName.".".config("app.url")
        ]);
    }

    public function test_create_client_with_valid_name_expects_creating_oauth_clients_in_tenant()
    {
        $clientName = $this->faker->word;
        $this->postJson(route('clients.store'), ["name" => $clientName]);
        $client = Client::where(["name" => $clientName])->first();
        $this->assertDatabaseCount($client->website->uuid.".oauth_clients", 2);
    }
}
