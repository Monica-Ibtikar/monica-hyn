<?php
/**
 * Created by PhpStorm.
 * User: monica
 * Date: 12/01/21
 * Time: 12:32 ص
 */

namespace App\Services;


use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

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
}