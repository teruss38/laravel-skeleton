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

Route::get('/', [\App\Http\Controllers\MainController::class, 'index']);
Route::get('captcha', \App\Http\Controllers\CaptchaController::class)->name('captcha');

Illuminate\Support\Facades\Auth::routes(['verify' => true]);
Route::get('register/phone', [\App\Http\Controllers\Auth\RegisterController::class,'showPhoneRegistrationForm'])->name('mobile.register');
Route::post('register/phone', [\App\Http\Controllers\Auth\RegisterController::class,'phoneRegister'])->name('mobile.register.store');

//社交账户登录
Route::get('auth/social/{provider}', [\App\Http\Controllers\Auth\SocialController::class,'redirectToProvider']);
Route::get('auth/social/{provider}/callback', [\App\Http\Controllers\Auth\SocialController::class,'handleProviderCallback']);
Route::get('auth/social/{provider}/binding', [\App\Http\Controllers\Auth\SocialController::class,'handleProviderBinding']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/**
 * 远程调用
 */
Route::group(['prefix' => 'ajax'], function () {
    Route::get('info', [App\Http\Controllers\AjaxController::class, 'info']);//获取用户登录状态
});
