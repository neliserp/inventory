<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'api',
    'namespace' => 'Neliserp\Inventory',
], function() {
    Route::get('items', 'ItemController@index');
    Route::get('items/{item}', 'ItemController@show');
    Route::post('items', 'ItemController@store');
    Route::put('items/{item}', 'ItemController@update');
    Route::delete('items/{item}', 'ItemController@destroy');
});
