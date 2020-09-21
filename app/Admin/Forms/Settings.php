<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Forms;

use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\URL;
use Larva\Settings\SettingEloquent;
use Symfony\Component\HttpFoundation\Response;

/**
 * 系统设置
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Settings extends Form
{
    /**
     * Constructor.
     * @param array $data
     * @param null $key
     */
    public function __construct($data = [], $key = null)
    {
        parent::__construct($data, $key);
        $this->disableResetButton();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->tab('基本设置', function () {
            $this->text('system.title', '网站标题')->required()->rules('required|string|min:2')->placeholder('请输入网站标题（一般不超过80个字符）');
            $this->text('system.keywords', '网站关键词')->required()->rules('required|string|min:5')->placeholder('请输入网站标题（一般不超过100个字符）');
            $this->textarea('system.description', '网站描述')->required()->rules('required|string|min:5')->placeholder('请输入网站标题（一般不超过200个字符）');
            $this->switch('system.censor', '启用文本反垃圾');
            $this->text('system.icp_record', 'ICP备案')->rules('nullable|string');
            $this->text('system.police_record', '公安备案')->rules('nullable|string');
            $this->email('system.support_email', '服务邮箱')->rules('nullable|email');
            $this->email('system.lawyer_email', '法律邮箱')->rules('nullable|email');
            $this->text('system.locoy', '火车采集器密钥')->rules('nullable|string');
        });
        $this->tab('用户设置', function () {
            $this->switch('user.enable_registration', '启用新用户注册');
            $this->switch('user.enable_socialite_auto_registration', '启用社交用户自动注册');
            $this->switch('user.enable_sms_auto_registration', '启用短信验证码注册');
            $this->switch('user.enable_miniprogram_auto_registration', '启用小程序注册');
            $this->switch('user.enable_password_recovery', '启用找回密码');
            $this->switch('user.enable_welcome_email', '发送注册欢迎邮件');
            $this->switch('user.enable_login_email', '发送登录通知邮件');
            $this->switch('user.enable_register_ticket', '启用注册滑动解锁');
            $this->switch('user.enable_login_ticket', '启用登录滑动解锁');

            if (class_exists('\Larva\Wallet\Models\Wallet')) {

            }
            if (class_exists('\Larva\Integral\Models\IntegralWallet')) {

            }
        });
        $this->tab('小程序设置', function () {
            $this->text('miniprogram.name', '小程序名称')->rules('nullable|string')->default(config('app.name'));
            $this->text('miniprogram.desc', '小程序描述')->rules('nullable|string');
        });
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
        return $this->success('Processed successfully.', route('admin.settings'));
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
