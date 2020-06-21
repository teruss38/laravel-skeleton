<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Routing\Registrar as RouteContract;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

//社交账户登录
Route::get('auth/social/{provider}', 'Auth\SocialLoginController@redirectToProvider');
Route::get('auth/social/{provider}/callback', 'Auth\SocialLoginController@handleProviderCallback');
Route::get('auth/social/{provider}/binding', 'Auth\SocialLoginController@handleProviderBinding');
Route::get('/home', 'HomeController@index')->name('home');

/**
 * 站内信
 */
Route::group(['prefix' => 'messages'], function () {
    Route::get('/', 'User\MessageController@index')->name('user.messages');
    Route::post('create', 'User\MessageController@store')->name('user.messages.store');
    Route::get('{user_id}', 'User\MessageController@show')->name('user.messages.show');
});

/**
 * 通知
 */
Route::get('notifications', 'User\NotificationController@index')->name('user.notifications');
