<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Forms\User;

use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\URL;
use Larva\Settings\SettingEloquent;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Settings
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Settings extends Form
{
    public function __construct($data = [], $key = null)
    {
        parent::__construct($data, $key);
        $this->disableResetButton();
    }

    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return Response
     */
    public function handle(array $input)
    {
        $input = Arr::dot($input);
        foreach ($input as $key => $val) {
            \Larva\Settings\Settings::set($key, $val);
        }
        return $this->success('Processed successfully.', URL::previous());
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->switch('user.enable_registration', '启用新用户注册');
        $this->switch('user.enable_socialite_auto_registration', '启用社交用户自动注册');
        $this->switch('user.enable_sms_auto_registration', '启用短信验证码注册');
        $this->switch('user.enable_password_recovery', '启用找回密码');
        $this->switch('user.enable_welcome_email', '发送注册欢迎邮件');
        $this->switch('user.enable_login_email', '发送登录通知邮件');
        $this->switch('user.enable_register_ticket', '启用注册滑动解锁');
        $this->switch('user.enable_login_ticket', '启用登录滑动解锁');
    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        $settings = [];
        SettingEloquent::all()->each(function ($setting) use (&$settings) {
            $settings[$setting['key']] = $setting['value'];
        });
        return $settings;
    }
}
