<?php
use Illuminate\Support\Facades\Route;



$namespace = 'App\\Http\\Controllers\\Tenant\\';

Route::prefix('api')->namespace($namespace)->group(function () {
    Route::apiResource('users', 'UserController')->only('store');
    Route::apiResource('attributes', 'AttributeController')->only(['store', 'index']);
    Route::apiResource('products', 'ProductController')->only(['store', 'index']);
    Route::post('login', 'AuthController@login');
    Route::post('products/{id}/upload-image','ProductController@uploadImage');
});