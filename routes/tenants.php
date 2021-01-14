<?php
use Illuminate\Support\Facades\Route;



$namespace = 'App\\Http\\Controllers\\Tenant\\';

Route::prefix('api')->namespace($namespace)->group(function () {
    Route::apiResource('users', 'UserController');
    Route::post('login', 'AuthController@login');
});