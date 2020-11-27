<?php

use Illuminate\Http\Request;
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

/**
 * RESTFul API common.
 *
 * Define the version of the interface that conforms to most of the
 * REST ful specification.
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * RESTFul API version 1.
 *
 * Define the version of the interface that conforms to most of the
 * REST ful specification.
 */
Route::group(['prefix' => 'v1'], function (Illuminate\Contracts\Routing\Registrar $api) {

    /**
     * 用户接口
     */
    Route::group(['prefix' => 'user'], function () {
        Route::post('exists', [App\Http\Controllers\Api\V1\UserController::class, 'exists']);//账号邮箱手机号检查
        //Route::post('phone-register', 'Api\V1\UserController@phoneRegister');//手机号注册
        //Route::post('email-register', 'Api\V1\UserController@emailRegister');//邮箱注册
        Route::post('avatar', [App\Http\Controllers\Api\V1\UserController::class, 'modifyAvatar']);//修改头像
    });
});
