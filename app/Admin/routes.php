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

    /**
     * 设置中心
     */
    $router->get('settings/system', 'SettingsController@system')->name('admin.settings.system');
    $router->get('settings/user', 'SettingsController@user')->name('admin.settings.user');
    $router->get('settings/storage', 'SettingsController@storage')->name('admin.settings.storage');
    $router->get('settings/socialite', 'SettingsController@socialite')->name('admin.settings.socialite');

    //用户
    $router->get('user/settings/basic', 'User\SettingsController@basic')->name('admin.user.settings.basic');
    $router->get('user/settings/socialite', 'User\SettingsController@socialite')->name('admin.user.settings.socialite');
    $router->resource('user/clients', 'User\ClientController');
    $router->resource('user/members', 'User\MemberController');
    $router->resource('user/socials', 'User\SocialController')->only(['index', 'show']);

    //模块

});
