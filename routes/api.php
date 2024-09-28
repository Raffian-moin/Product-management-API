<?php

use Illuminate\Support\Facades\Route;

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

Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'
], function ($router) {
    Route::get('products', 'ProductController@index');
    Route::get('products/{id}', 'ProductController@show');
    Route::post('products/store', 'ProductController@store');
    Route::put('products/update/{id}', 'ProductController@update');
    Route::patch('products/update/partial/{id}', 'ProductController@updatePartial');
});
