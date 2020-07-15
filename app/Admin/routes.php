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

    //Api
    $router->get('api/tags', 'ApiController@tags');
    $router->get('api/users', 'ApiController@users');

    /**
     * 设置中心
     */
    $router->get('settings/system', 'SettingsController@system')->name('admin.settings.system');
    $router->get('settings/storage', 'SettingsController@storage')->name('admin.settings.storage');
    $router->get('settings/miniprogram', 'SettingsController@miniprogram')->name('admin.settings.miniprogram');

    //用户
    $router->get('user/settings/basic', 'User\SettingsController@basic')->name('admin.user.settings.basic');
    $router->resource('user/clients', 'User\ClientController');
    $router->resource('user/members', 'User\MemberController');
    $router->resource('user/socials', 'User\SocialController')->only(['index', 'show']);

    //模块

});
