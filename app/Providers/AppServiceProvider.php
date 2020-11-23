<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Providers;

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
        'username' => \App\Validators\UsernameValidator::class,
        'nickname' => \App\Validators\NicknameValidator::class,
        'phone_verify_code' => \App\Validators\PhoneVerifyCodeValidator::class,
        'mail_verify_code' => \App\Validators\MailVerifyCodeValidator::class,
        'hash' => \App\Validators\HashValidator::class,
        'longitude' => \App\Validators\LongitudeValidator::class,//纬度
        'latitude' => \App\Validators\LatitudeValidator::class,//经度
        'ticket' => \App\Validators\TicketValidator::class,
        'phone_verify' => \App\Validators\PhoneVerifyValidator::class,
        'mac_address' => \App\Validators\MacAddressValidator::class,//Mac 地址验证
        'captcha' => \App\Validators\CaptchaValidator::class,//验证码验证
        'id_card' => \App\Validators\IdCardValidator::class,//中国大陆身份证验证
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Support\Carbon::setLocale('zh');
        $this->registerValidators();
    }

    /**
     * Register validators.
     */
    protected function registerValidators()
    {
        foreach ($this->validators as $rule => $validator) {
            \Illuminate\Support\Facades\Validator::extend($rule, "{$validator}@validate");
        }
    }
}
