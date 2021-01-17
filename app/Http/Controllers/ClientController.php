<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClient;
use App\Http\Resources\SuccessResource;
use App\Services\ClientService;
use Illuminate\Http\Response;

class ClientController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $client)
    {
        $this->clientService = $client;
    }

    public function store(StoreClient $request)
    {
        $this->clientService->store($request->only('name'));
        return new SuccessResource(Response::HTTP_CREATED);
    }
}
