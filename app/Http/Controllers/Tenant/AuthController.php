<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Resources\ErrorResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Psr\Http\Message\ServerRequestInterface;

class AuthController extends Controller
{
    public function login(Request $request, ServerRequestInterface $serverRequest,UserService $userService)
    {
        try {
            return $userService->callPassortToken($request->only(["email", "password"]), $serverRequest);
        } catch (\Exception $exception) {
            return new ErrorResource(Response::HTTP_UNAUTHORIZED, $exception->getMessage());
        }

    }
}
