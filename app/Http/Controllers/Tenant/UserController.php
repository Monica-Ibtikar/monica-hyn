<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Resources\SuccessResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $user)
    {
        $this->userService = $user;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return SuccessResource
     */
    public function store(Request $request)
    {
        $this->userService->store($request->input());
        return new SuccessResource(Response::HTTP_CREATED);
    }

}
