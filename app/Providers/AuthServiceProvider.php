<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Providers;

use App\Models\PassportClient;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerPassport();
        Gate::guessPolicyNamesUsing(function ($modelClass) {
            return \sprintf('App\Policies\%sPolicy', \class_basename($modelClass));
        });
    }

    /**
     * 注册 Passport
     */
    public function registerPassport()
    {
        //注册路由
        Passport::routes();

        Passport::useClientModel(PassportClient::class);

        //开启隐式授权令牌
        Passport::enableImplicitGrant();

        //忽略 CSRF 验证
        Passport::$ignoreCsrfToken = true;

        //设置令牌过期时间15天
        Passport::tokensExpireIn(now()->addDays(config('passport.tokens_expire_in', 15)));

        //设置刷新令牌过期时间30天
        Passport::refreshTokensExpireIn(now()->addDays(config('passport.refresh_tokens_expire_in', 30)));

        // 定义作用域
        //Passport::tokensCan(config('passport.scopes'));

        //默认作用域
        //Passport::setDefaultScope(config('passport.default_scopes'));
    }
}
