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

Route::get('/', 'MainController@index');
Route::get('captcha', 'CaptchaController')->name('captcha');

Auth::routes(['verify' => true]);
Route::get('register/phone', 'Auth\RegisterController@showPhoneRegistrationForm')->name('mobile.register');
Route::post('register/phone', 'Auth\RegisterController@phoneRegister')->name('mobile.register.store');

//社交账户登录
Route::get('auth/social/{provider}', 'Auth\SocialController@redirectToProvider');
Route::get('auth/social/{provider}/callback', 'Auth\SocialController@handleProviderCallback');
Route::get('auth/social/{provider}/binding', 'Auth\SocialController@handleProviderBinding');

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

/**
 * 远程调用
 */
Route::group(['prefix' => 'ajax'], function () {
    Route::get('info', 'AjaxController@info');//获取用户登录状态
});

/**
 * 搜索
 */
Route::get('search', 'SearchController@index')->name('search');
Route::get('search/query', 'SearchController@query')->name('search.query');

/**
 * 文章
 */
Route::group(['prefix' => 'articles'], function () {
    Route::get('/', 'ArticleController@index')->name('article.index');
    Route::get('category/{id}', 'ArticleController@category')->name('article.category');
    Route::get('{id}.html', 'ArticleController@show')->name('article.show');
    Route::get('create', 'ArticleController@create')->name('article.create');
    Route::post('create', 'ArticleController@store')->name('article.store');
});

/**
 * 标签
 */
Route::group(['prefix' => 'tags'], function () {
    Route::get('/', 'TagController@index')->name('tag.index');
    Route::get('{id}', 'TagController@show')->name('tag.show');
    Route::get('{id}/articles', 'ArticleController@tag')->name('tag.articles');
    Route::get('auto-complete', 'TagController@autoComplete')->name('tag.auto-complete');
});

/**
 * 热点长尾词
 */
Route::group(['prefix' => 'hotword'], function () {
    Route::get('/', 'KeywordController@index')->name('keyword.index');
    Route::get('{id}', 'KeywordController@show')->name('keyword.show');
});
