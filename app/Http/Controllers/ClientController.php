<?php

namespace App\Http\Controllers;

use App\Http\Resources\SuccessResource;
use App\Services\ClientService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClientController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $client)
    {
        $this->clientService = $client;
    }

    public function store(Request $request)
    {
        $this->clientService->store($request->only('name'));
        return new SuccessResource(Response::HTTP_CREATED);
    }
}
