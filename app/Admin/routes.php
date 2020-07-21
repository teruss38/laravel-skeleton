<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->get('settings', 'HomeController@settings')->name('admin.settings');

    //Api
    $router->get('api/tags', 'ApiController@tags');
    $router->get('api/users', 'ApiController@users');

    //数据管理
    $router->resource('dictionary/stop-words', 'Dictionary\StopWordController');

    //内容
    $router->resource('content/categories', 'Content\CategoryController');
    $router->resource('content/articles', 'Content\ArticleController');
    $router->resource('content/tags', 'Content\TagController');

    //用户
    $router->resource('user/clients', 'User\ClientController');
    $router->resource('user/members', 'User\MemberController');
    $router->resource('user/socials', 'User\SocialController')->only(['index', 'show']);

    //模块
    $router->resource('module/links', 'Module\LinkController');


});
