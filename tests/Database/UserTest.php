<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Tests\Database;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

/**
 * Class UserTest
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 测试邮箱
     *
     * @return void
     */
    public function testUserEmail()
    {
        $user = factory(\App\Models\User::class)->create();
        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);
    }

    /**
     * 测试手机
     *
     * @return void
     */
    public function testUserPhone()
    {
        $user = factory(\App\Models\User::class)->states('phone')->create();
        $this->assertDatabaseHas('users', [
            'phone' => $user->phone,
        ]);
    }

    /**
     * 测试附加信息
     */
    public function testProfileExtra()
    {
        $user = factory(\App\Models\User::class)->states('phone')->create();
        $this->assertDatabaseHas('user_profiles', [
            'user_id' => $user->id,
        ]);
        $this->assertDatabaseHas('user_extras', [
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('user_identification', [
            'user_id' => $user->id,
        ]);
    }

    /**
     * 账户模型测试
     */
    public function testDisabled()
    {
        $user = factory(\App\Models\User::class)->states('phone')->create();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);
        $this->assertFalse($user->hasDisabled());

        $user->markDisabled();
        $this->assertTrue($user->hasDisabled());

        $user->markEmailAsVerified();
        $this->assertTrue($user->hasVerifiedEmail());

        $user->markPhoneAsVerified();
        $this->assertTrue($user->hasVerifiedPhone());

        $user->resetPhone(13000000000);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'phone' => 13000000000,
        ]);

        $user->resetMail('aaavvbc@demo.com');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'aaavvbc@demo.com',
        ]);
    }

    /**
     * 缓存测试
     */
    public function testCache()
    {
        $user = factory(\App\Models\User::class)->states('phone')->create();
        \App\Models\User::findById($user->id);
        $this->assertTrue(Cache::has('users:' . $user->id));

        $user->update(['username' => 'test']);
        $this->assertFalse(Cache::has('users:' . $user->id));
    }
}
