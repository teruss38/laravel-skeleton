<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Routing\Registrar as RouteContract;

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
 * RESTFul API version 1.
 *
 * Define the version of the interface that conforms to most of the
 * REST ful specification.
 */
Route::group(['prefix' => 'v1'], function (RouteContract $api) {

    /**
     * 用户接口
     */
    Route::group(['prefix' => 'user'], function () {
        Route::post('exists', 'Api\V1\UserController@exists');//账号邮箱手机号检查
        Route::post('phone-register', 'Api\V1\UserController@phoneRegister');//手机号注册
        Route::post('email-register', 'Api\V1\UserController@emailRegister');//邮箱注册
        Route::post('send-verification-mail', 'Api\V1\UserController@sendVerificationMail');//发送激活邮件
        Route::post('phone-reset-password', 'Api\V1\UserController@resetPasswordByPhone');//通过手机重置用户登录密码
        Route::get('profile', 'Api\V1\UserController@profile');//获取用户个人资料
        Route::get('extra', 'Api\V1\UserController@extra');//获取扩展资料
        Route::post('verify-phone', 'Api\V1\UserController@verifyPhone');//验证手机号码
        Route::post('email', 'Api\V1\UserController@modifyEMail');//修改邮箱
        Route::post('phone', 'Api\V1\UserController@modifyPhone');//修改手机号码
        Route::post('profile', 'Api\V1\UserController@modifyProfile');//修改用户个人资料
        Route::post('avatar', 'Api\V1\UserController@modifyAvatar');//修改头像
        Route::post('password', 'Api\V1\UserController@modifyPassword');//修改密码
        Route::get('search', 'Api\V1\UserController@search');//搜索用户
        Route::delete('', 'Api\V1\UserController@destroy');//注销并删除自己的账户
        Route::get('login-histories', 'Api\V1\UserController@loginHistories');//获取登录历史
        /**
         * 社交账户
         */
        Route::group(['prefix' => 'social'], function () {
            Route::get('accounts', 'Api\V1\SocialController@socialAccounts');//获取绑定的社交账户
            Route::delete('accounts/{provider}', 'Api\V1\SocialController@destroySocial');//解绑
            Route::get('bind/{provider}', 'Api\V1\SocialController@bindSocial');//绑定社交账户
        });

        /**
         * 私信
         */
        Route::group(['prefix' => 'messages'], function () {
            Route::get('', 'Api\V1\MessageController@index');//获取话题列表
            Route::post('', 'Api\V1\MessageController@store');//发送短消息
            Route::get('{user_id}', 'Api\V1\MessageController@show');//获取话题详情
            Route::delete('{id}', 'Api\V1\MessageController@destroy');//删除消息
        });

        /**
         * 通知
         */
        Route::group(['prefix' => 'notifications'], function () {
            Route::post('mark-read', 'Api\V1\NotificationController@markAsRead');//标记所有未读通知为已读
            Route::get('unread-count', 'Api\V1\NotificationController@unreadCount');// 通知统计
        });

    });

    /**
     * 设备接口
     */
    Route::group(['prefix' => 'device'], function () {
        Route::post('register', 'Api\V1\DeviceController@register');//设备注册
    });
});
