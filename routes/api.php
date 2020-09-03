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

Route::group([ //authentication
    'middleware' => 'api',
    // 'prefix' => 'auth'
], function ($router) {
    Route::prefix('auth')->group(function () {        
        Route::post('login', 'API\AuthController@login');
        Route::post('register', 'API\AuthController@register');
        Route::post('logout', 'API\AuthController@logout');
        Route::post('refresh', 'API\AuthController@refresh');
        Route::get('user-profile', 'API\AuthController@userProfile');
    });

    Route::prefix('company')->group(function () {        
        Route::post('employee', 'API\APICompanyController@listEmployees');
        
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
