<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

use Illuminate\Database\Seeder;
use Larva\Settings\Settings;

/**
 * 默认设置
 * @author Tongle Xu <xutongle@gmail.com>
 */
class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::set('system.icp_record', '京ICP备00000001号');
        Settings::set('system.police_record', '');
        Settings::set('system.support_email', 'support@email.com');

        Settings::set('user.enable_registration', '1');//启用注册
        Settings::set('user.enable_socialite_auto_registration', '1');
        Settings::set('user.enable_sms_auto_registration', '1');
        Settings::set('user.enable_password_recovery', '1');
        Settings::set('user.enable_welcome_email', '1');
        Settings::set('user.enable_login_email', '0');
        Settings::set('user.enable_register_ticket', '0');
        Settings::set('user.enable_login_ticket', '0');
    }
}
