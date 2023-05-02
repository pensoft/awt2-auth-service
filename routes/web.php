<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('appRoutes', function() {
    \Artisan::call('route:list');
    return "<pre>" . \Artisan::output() . "</pre>";
});

Route::group(['middleware' => 'auth'], function () {

});

require __DIR__.'/auth.php';
