<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'api',
    'namespace' => 'Neliserp\Inventory\Http\Controllers',
], function() {
    Route::resource('items', 'ItemController')->except(['create', 'edit']);
});
