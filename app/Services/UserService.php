<?php
/**
 * Created by PhpStorm.
 * User: monica
 * Date: 12/01/21
 * Time: 12:32 ص
 */

namespace App\Services;


use App\Repositories\Contracts\PassportClientRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Hyn\Tenancy\Environment;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client as GuzzleClient;
use Laravel\Passport\Http\Controllers\AccessTokenController;

class UserService
{
    protected $userRepo;

    public function __construct()
    {
        $this->userRepo = resolve(UserRepositoryInterface::class);
    }

    public function store(array $attributes)
    {
        $attributes['password'] = Hash::make($attributes['password']);
        $this->userRepo->store($attributes);
    }

    public function callPassortToken(array $credentials, $serverRequest)
    {
        $user = $this->userRepo->first(["email" => $credentials["email"]]);
        if($user) {
            $tokenController = app(AccessTokenController::class);
            $passwordClient = $this->getPasswordAccessGrantClient();
            $request = $serverRequest->withParsedBody([
                'grant_type' => 'password',
                'client_id' => $passwordClient->id,
                'client_secret' => $passwordClient->secret,
                'username' => $credentials["email"],
                'password' => $credentials["password"]
            ]);
            return $tokenController->issueToken($request);
        } else {
            throw new \Exception("Invalid Login credentials", Response::HTTP_UNAUTHORIZED);
        }
    }

    protected function getPasswordAccessGrantClient()
    {
        return resolve(PassportClientRepositoryInterface::class)->first(
            [
                "name" => "Laravel Password Grant Client"
            ]
        );
    }
}