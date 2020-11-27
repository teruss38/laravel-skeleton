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
use Larva\Settings\SettingEloquent;

/**
 * 系统设置
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Settings extends Form
{
    /**
     * Build a form here.
     */
    public function form()
    {
        $this->tab('基本设置', function () {
            $this->text('system.title', '网站标题')->required()->rules('required|string|min:2')->placeholder('请输入网站标题（一般不超过80个字符）');
            $this->text('system.keywords', '网站关键词')->required()->rules('required|string|min:5')->placeholder('请输入网站标题（一般不超过100个字符）');
            $this->textarea('system.description', '网站描述')->required()->rules('required|string|min:5')->placeholder('请输入网站标题（一般不超过200个字符）');
            $this->text('system.icp_record', 'ICP备案')->rules('nullable|string');
            $this->text('system.police_record', '公安备案')->rules('nullable|string');
            $this->email('system.support_email', '服务邮箱')->rules('nullable|email');
            $this->email('system.lawyer_email', '法律邮箱')->rules('nullable|email');
        });
        $this->tab('系统设置', function () {
            $this->switch('system.text_censor', '启用文本智能审核')->help('该功能依赖百度云文本审核。<a href="https://cloud.baidu.com/product/textcensoring" target="_blank">查看</a>');
            $this->switch('system.image_censor', '启用图片智能审核')->help('该功能依赖百度云图片审核。<a href="https://cloud.baidu.com/product/imagecensoring" target="_blank">查看</a>');
            $this->switch('system.voice_censor', '启用音频智能审核')->help('该功能依赖百度云音频审核。<a href="https://cloud.baidu.com/doc/ANTIPORN/s/Gk928k8z9" target="_blank">查看</a>');
            $this->switch('system.video_censor', '启用视频智能审核')->help('该功能依赖百度云视频审核。<a href="https://cloud.baidu.com/doc/ANTIPORN/s/ek7ehnhso" target="_blank">查看</a>');
            $this->text('system.sitemap_chunk', '单个Sitemap Url 数量')->append('<span class="input-group-text">个</span>')->help('修改该值请手动删除所有已经生成的 XML 文件，防止错乱！');
            $this->text('system.sitemap_cache', 'Sitemap 缓存时间')->append('<span class="input-group-text">分钟</span>');
            $this->switch('system.sitemap_static', 'Sitemap 智能静态化')->help('在第一次请求时自动生成静态 XML 文件减轻服务器压力并自动跳过最后一页。');
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
     * @return \Dcat\Admin\Http\JsonResponse
     */
    public function handle(array $input)
    {
        $input = Arr::dot($input);
        foreach ($input as $key => $val) {
            \Larva\Settings\Settings::set($key, $val);
        }
        return $this->response()->success('Processed successfully.')->refresh();
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
