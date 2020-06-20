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
            'id' => 100000000,
            'name' => '测试项目',
            'secret' => 'J1ZcU3xtcNHNbVLo5JoTJe2h8husBz9fzqNLSqBS',
            'redirect' => 'https://dev.larvacms.cn',
            'personal_access_client' => true,
            'password_client' => true,
            'revoked' => false,
        ])->save();
    }
}
