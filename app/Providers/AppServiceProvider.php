<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Providers;

use App\Http\Resources\Resource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @var array 验证器
     */
    protected $validators = [
        'phone' => \App\Validators\PhoneValidator::class,
        'tel_phone' => \App\Validators\TelPhoneValidator::class,
        'phone_two' => \App\Validators\PhoneTwoValidator::class,
        'hash' => \App\Validators\HashValidator::class,
        
    ];
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //忽略 Passport 默认迁移
        \Laravel\Passport\Passport::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //设置迁移的 string 字段默认长度是 191
        Schema::defaultStringLength(191);
        //关闭 API 响应的 data 包裹
        Resource::withoutWrapping();
        Carbon::setLocale('zh');
        //
        $this->registerObserve();
        $this->registerValidators();
    }

    /**
     * Register observes.
     */
    protected function registerObserve()
    {
        \App\Models\User::observe(\App\Observers\UserObserver::class);//用户
        \App\Models\UserLoginHistory::observe(\App\Observers\UserLoginHistoryObserver::class);//登录
    }

    /**
     * Register validators.
     */
    protected function registerValidators()
    {
        foreach ($this->validators as $rule => $validator) {
            Validator::extend($rule, "{$validator}@validate");
        }
    }
}
