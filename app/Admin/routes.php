<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'as' => 'admin.',
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    //用户
    $router->resource('user/clients', 'User\ClientController');
    $router->resource('user/members', 'User\MemberController');
    $router->resource('user/socials', 'User\SocialController')->only(['index', 'show']);
});
