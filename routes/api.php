<?php

use App\API\V1\Controllers\Authorization\CheckPoliciesController;
use App\API\V1\Controllers\Authorization\CheckServicePoliciesController;
use App\API\V1\Controllers\Authorization\ServiceController;
use App\API\V1\Controllers\Users\GetUsersController;
use App\Http\Controllers\Auth\PassportAuthController;
use Illuminate\Support\Facades\Route;

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
// ToDo: use this https://sathyaventhan.medium.com/laravel-secure-rest-api-with-swagger-26050dafa55
// https://copyprogramming.com/howto/how-to-configure-swagger-with-laravel-passport
Route::post('register', [PassportAuthController::class, 'registerUserExample']);
Route::post('login', [PassportAuthController::class, 'loginUserExample']);
Route::post('token', [PassportAuthController::class, 'token']);
Route::post('refresh-token', [PassportAuthController::class, 'refreshToken']);
Route::post('service-register', [ServiceController::class, 'register']);
Route::post('service-refresh-token', [ServiceController::class, 'refreshToken']);
Route::post('service-token', [ServiceController::class, 'token']);
//add this middleware to ensure that every request is authenticated
Route::middleware('auth:api')->group(function () {
    Route::get('me', [PassportAuthController::class, 'authenticatedUserDetails']);

    Route::prefix('v1')->group(function () {
        Route::prefix('authorization')->group(function () {
            Route::post('/check', CheckPoliciesController::class);
        });
    });
});
Route::middleware('auth:api-services')->group(function () {
    Route::prefix('services')->group(function () {
        Route::get('me', [PassportAuthController::class, 'authenticatedUserDetails']);

    });
    Route::prefix('v1')->group(function () {
        Route::prefix('services')->group(function () {
            Route::prefix('authorization')->group(function () {
                Route::post('/check', CheckServicePoliciesController::class);
            });
        });
    });
});

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);
$api->version('v1', function (Router $api) {
    $api->group(['prefix' => 'users'], function (Router $api) {
        $api->get('/', GetUsersController::class);
    });
});


Route::get('apiRoutes', function () {
    \Artisan::call(' api:routes');
    return "<pre>" . \Artisan::output() . "</pre>";
});
