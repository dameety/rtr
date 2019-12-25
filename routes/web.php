<?php


Route::get('auth/{any}', 'FrontSpaController')->where('any', '.*');


Route::prefix('admin')->group(function(){
    Route::get('/', 'AdminSpaController@index');
    Route::get('{any}', 'AdminSpaController@index')->where('any', '.*');
});

Route::get('{any}', 'FrontSpaController')->where('any', '.*');


