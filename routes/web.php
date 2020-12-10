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
Route::get('register/mobile', [\App\Http\Controllers\Auth\RegisterController::class, 'showMobileRegistrationForm'])->name('mobile.register');
Route::post('register/mobile', [\App\Http\Controllers\Auth\RegisterController::class, 'mobileRegister'])->name('mobile.register.store');

//社交账户登录
Route::get('auth/social/{provider}', [\App\Http\Controllers\Auth\SocialController::class, 'redirectToProvider']);
Route::get('auth/social/{provider}/callback', [\App\Http\Controllers\Auth\SocialController::class, 'handleProviderCallback']);
Route::get('auth/social/{provider}/binding', [\App\Http\Controllers\Auth\SocialController::class, 'handleProviderBinding']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//上传
Route::group(['prefix' => 'uploader', 'as' => 'uploader.'], function () {
    Route::post('ckeditor', [App\Http\Controllers\UploaderController::class, 'ckeditor'])->name('ckeditor');
});

/**
 * 单页面
 */
Route::get('about', [App\Http\Controllers\PageController::class, 'about'])->name('page.about');
Route::get('contact', [App\Http\Controllers\PageController::class, 'contact'])->name('page.contact');
Route::get('terms', [App\Http\Controllers\PageController::class, 'terms'])->name('page.terms');
Route::get('copyright', [App\Http\Controllers\PageController::class, 'copyright'])->name('page.copyright');
Route::get('privacy', [App\Http\Controllers\PageController::class, 'privacy'])->name('page.privacy');
Route::get('adm', [App\Http\Controllers\PageController::class, 'adm'])->name('page.adm');
Route::get('delete', [App\Http\Controllers\PageController::class, 'delete'])->name('page.delete');
Route::get('link', [App\Http\Controllers\PageController::class, 'link'])->name('page.link');

/**
 * 站内信
 */
Route::group(['prefix' => 'messages'], function () {
    Route::get('link', [App\Http\Controllers\User\MessageController::class, 'index'])->name('user.messages');
    Route::post('create', [App\Http\Controllers\User\MessageController::class, 'store'])->name('user.messages.store');
    Route::get('{user_id}', [App\Http\Controllers\User\MessageController::class, 'show'])->name('user.messages.show');
});

/**
 * 通知
 */
Route::get('notifications', [App\Http\Controllers\User\NotificationController::class, 'index'])->name('user.notifications');

/**
 * 远程调用
 */
Route::group(['prefix' => 'ajax'], function () {
    Route::get('info', [App\Http\Controllers\AjaxController::class, 'info']);//获取用户登录状态
    Route::get('tags', [App\Http\Controllers\AjaxController::class, 'tags'])->name('ajax.tags');//获取用户登录状态
});

/**
 * 搜索
 */
//Route::group(['prefix' => 'search', 'as' => 'search.'], function () {
//    Route::get('search', [App\Http\Controllers\SearchController::class, 'index'])->name('index');
//    Route::get('search/query', [App\Http\Controllers\SearchController::class, 'query'])->name('query');
//});

Route::get('category/{id}', [App\Http\Controllers\ArticleController::class, 'category'])->name('articles.category');
Route::resource('articles', App\Http\Controllers\ArticleController::class);
Route::resource('news', App\Http\Controllers\NewsController::class);

/**
 * 标签
 */
Route::group(['prefix' => 'tags', 'as' => 'tag.'], function () {
    Route::get('/', [App\Http\Controllers\TagController::class, 'index'])->name('index');
    Route::get('{tag}', [App\Http\Controllers\TagController::class, 'show'])->name('show');
    Route::get('{tag}/articles', [App\Http\Controllers\ArticleController::class, 'tag'])->name('articles');
    Route::get('{tag}/news', [App\Http\Controllers\NewsController::class, 'tag'])->name('news');
});

/**
 * 站点地图
 */
Route::get('sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap.index');//站点地图索引页
Route::group(['prefix' => 'sitemap', 'as' => 'sitemap.'], function () {
    Route::get('misc.xml', [App\Http\Controllers\SitemapController::class, 'misc'])->name('misc');//单页地图
    Route::get('articles-{page}.xml', [App\Http\Controllers\SitemapController::class, 'articles'])->name('article');//文章地图
    Route::get('tags-{page}.xml', [App\Http\Controllers\SitemapController::class, 'tags'])->name('tag');//Tag地图
});
