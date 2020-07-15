<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.arva.com.cn/
 * @license http://www.arva.com.cn/license/
 */

use Illuminate\Database\Seeder;
use Laravel\Passport\Passport;

class PassportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Passport::client()->forceFill([
            'name' => '测试项目',
            'redirect' => 'https://dev.larvacms.cn',
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false,
        ])->save();
    }
}
