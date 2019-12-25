<?php

use Illuminate\Http\Request;

Route::prefix('auth')->group(function(){
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('logout', 'AuthController@logout')->name('logout');
    Route::post('register', 'AuthController@register')->name('register');
});

Route::middleware(['auth:api', 'adminOnly'])->group(function () {
    Route::resource('meals', 'MealsController')->only(['store', 'update', 'destroy']);

    Route::resource('orders', 'OrderController')->only(['destroy', 'update']);

    Route::get('drivers', 'DriverApiController@index')->name('drivers.index');

});

Route::middleware(['auth:api'])->group(function () {
    Route::resource('orders', 'OrderController')->only(['index', 'store', 'show']);
});

Route::resource('meals', 'MealsController')->only(['index', 'show']);




Route::fallback(function(){
    return response()->json([
        'status' => false,
        'message' => 'Api endpoint not found.'
    ], \Illuminate\Http\Response::HTTP_NOT_FOUND);
});
