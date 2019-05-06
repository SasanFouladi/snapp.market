<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::namespace('Api')->prefix('v1')->group(function () {

    Route::post('login', 'UserController@login')->name('user.login');

    Route::prefix('products')->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::post('add', 'ProductsController@create');
        });
        Route::get('categories', 'ProductsController@getCategories');
        Route::get('category/index', 'ProductsController@getCategoryItems');
        Route::get('search', 'ProductsController@search');
    });
});


