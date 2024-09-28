<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::group([
    'middleware' => 'admin',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'products'
],
    function ($router) {
        Route::post('store', 'ProductController@store');
        Route::put('/update/{id}', 'ProductController@update');
        Route::patch('/update/partial/{id}', 'ProductController@updatePartial');
    }
);

Route::group([
    'middleware' => 'authenticate.user',
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    Route::post('orders/store', 'OrderController@store');
    Route::get('orders', 'OrderController@index');
    Route::get('orders/details/{id}', 'OrderController@show');
});

