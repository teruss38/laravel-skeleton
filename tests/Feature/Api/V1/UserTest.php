<?php

namespace Tests\Feature\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 测试检查用户名是否可用
     */
    public function testExistUsername()
    {
        $user = factory(\App\Models\User::class)->create();
        //发送 post 请求
        $response = $this->json('POST', url('api/v1/user/exists'), [
            'username' => $user->username,
        ]);
        //断言他是成功的
        $response->assertStatus(200)->assertExactJson([
            'exist' => false,
        ]);
    }

    /**
     * @test
     * 测试检查邮箱是否可用
     */
    public function testExistEmail()
    {
        $user = factory(\App\Models\User::class)->create();

        //发送 post 请求
        $response = $this->json('POST', url('api/v1/user/exists'), [
            'email' => $user->email,
        ]);

        //断言他是成功的
        $response->assertStatus(200)->assertExactJson([
            'exist' => false,
        ]);
    }

    /**
     * 测试检查手机是否可用
     */
    public function testExistPhone()
    {
        $user = factory(\App\Models\User::class)->states('phone')->create();

        //发送 post 请求
        $response = $this->json('POST', url('api/v1/user/exists'), [
            'phone' => $user->phone,
        ]);

        //断言他是成功的
        $response->assertStatus(200)->assertExactJson([
            'exist' => false,
        ]);
    }

    /**
     * 测试检查空
     */
    public function testExistFailure()
    {
        //发送 post 请求
        $response = $this->json('POST', url('api/v1/user/exists'));
        //断言他是成功的
        $response->assertStatus(400);
    }

    /**
     * 手机注册
     */
    public function testPhoneRegister()
    {
        //User的数据
        $data = [
            'phone' => '13800138180',
            'verify_code' => '1234',
            'password' => 'secret1234',
        ];
        //发送 post 请求
        $response = $this->json('POST', url('api/v1/user/phone-register'), $data);
        //断言他是成功的
        $response->assertStatus(201)->assertJson([
            'phone' => $data['phone'],
        ]);
    }

    /**
     * 邮箱注册
     */
    public function testEmailRegister()
    {
        //User的数据
        $data = [
            'email' => 'test@gmail.com',
            'username' => 'Test',
            'password' => 'secret1234',
        ];
        //发送 post 请求
        $response = $this->json('POST', url('api/v1/user/email-register'), $data);
        //断言他是成功的
        $response->assertStatus(201)->assertJson([
            'username' => $data['username'],
            'email' => $data['email'],
        ]);
    }

    /**
     * 测试发送激活邮件
     */
    public function testSendVerificationMail()
    {
        $user = factory(\App\Models\User::class)->create();
        Passport::actingAs($user);
        $response = $this->json('POST', url('api/v1/user/send-verification-mail'));
        $response->assertStatus(200);
    }

    /**
     * 通过手机短信重置密码
     */
    public function testResetPasswordByPhone()
    {
        $user = factory(\App\Models\User::class)->states('phone')->create();

        $response = $this->json('POST', url('api/v1/user/phone-reset-password'), [
            'phone' => $user->phone,
            'verify_code' => '1234',
            'password' => 'secret1234',
        ]);
        $response->dump();
        $response->assertStatus(200);
    }

    /**
     * 获取个人资料
     */
    public function testProfile()
    {
        $user = factory(\App\Models\User::class)->state('phone')->create();
        Passport::actingAs($user);
        $response = $this->json('GET', url('api/v1/user/profile'));
        $response->assertStatus(200)->assertJson([
            'username' => $user->username,
            'email' => $user->email,
            'phone' => $user->phone,
        ]);
    }

    /**
     * 获取扩展资料
     */
    public function testExtra()
    {
        $user = factory(\App\Models\User::class)->state('phone')->create();
        Passport::actingAs($user);
        $response = $this->json('GET', url('api/v1/user/extra'));
        $response->assertStatus(200)->assertJson([
            'login_num' => 0,
            'views' => 0,
            'articles' => 0,
        ]);
    }

    /**
     * 验证手机号码
     */
    public function testVerifyPhone()
    {
        $user = factory(\App\Models\User::class)->state('phone')->create();
        Passport::actingAs($user);
        $response = $this->json('POST', url('api/v1/user/verify-phone'), [
            'phone' => $user->phone,
            'verify_code' => '1234',
        ]);
        $response->assertStatus(200);
    }

    /**
     * 修改邮箱
     */
    public function testModifyEMail()
    {
        $user = factory(\App\Models\User::class)->state('phone')->create();
        Passport::actingAs($user);
        $response = $this->json('POST', url('api/v1/user/email'), [
            'email' => 'abcd@123a.com',
            'verify_code' => '1234',
        ]);
        $response->assertStatus(200);
    }

    /**
     * 修改手机号
     */
    public function testModifyPhone()
    {
        $user = factory(\App\Models\User::class)->state('phone')->create();
        Passport::actingAs($user);
        $response = $this->json('POST', url('api/v1/user/phone'), [
            'phone' => '15166668888',
            'verify_code' => '1234',
        ]);
        $response->assertStatus(200);
    }

    /**
     * 修改个人资料
     */
    public function testModifyProfile()
    {
        $user = factory(\App\Models\User::class)->state('phone')->create();
        Passport::actingAs($user);
        $response = $this->json('POST', url('api/v1/user/profile'), [
            'username' => '昵称',
            'birthday' => '2019-01-01',
            'gender' => 0,
            'country_code' => 'CN',
            'province_id' => 370000,
            'city_id' => 370100,
            'district_id' => 370102,
            'address' => '这是地址',
            'website' => 'https://www.larva.com.cn',
            'introduction' => '这是描述',
            'bio' => '这是签名'
        ]);
        $response->assertStatus(200)->assertJson([
            'username' => '昵称',
            'birthday' => '2019-01-01',
            'gender' => 0,
            'country_code' => 'CN',
            'province_id' => 370000,
            'city_id' => 370100,
            'district_id' => 370102,
            'address' => '这是地址',
            'website' => 'https://www.larva.com.cn',
            'introduction' => '这是描述',
            'bio' => '这是签名'
        ]);
    }

    /**
     * 修改头像
     */
    public function testModifyAvatar()
    {
        $user = factory(\App\Models\User::class)->state('phone')->create();
        Passport::actingAs($user);
        Storage::fake(config('user.avatar_disk'));
        $file = UploadedFile::fake()->image('avatar.jpg')->size(100);
        $response = $this->json('POST', url('api/v1/user/avatar'), [
            'avatar' => $file,
        ]);
        $response->assertStatus(200);
    }

    /**
     * 修改密码
     */
    public function testModifyPassword()
    {
        $user = factory(\App\Models\User::class)->state('phone')->create();
        Passport::actingAs($user);

        $response = $this->json('POST', url('api/v1/user/password'), [
            'old_password' => 'password123',
            'password' => '12345678'
        ]);
        $response->assertStatus(422);

        $response = $this->json('POST', url('api/v1/user/password'), [
            'old_password' => 'password',
            'password' => '12345678'
        ]);
        $response->assertStatus(200);
    }

    /**
     * 搜索用户
     */
    public function testSearch()
    {
        $user = factory(\App\Models\User::class)->create();
        $user2 = factory(\App\Models\User::class)->create();
        Passport::actingAs($user);
        $response = $this->getJson(url('api/v1/user/search') . '?q=' . mb_substr($user2->username, 0, 2));
        $response->assertStatus(200);
    }

    /**
     * 注销删除自己
     */
    public function testDestroy()
    {
        $user = factory(\App\Models\User::class)->create();
        Passport::actingAs($user);
        $response = $this->deleteJson(url('api/v1/user'));
        $response->assertStatus(204);
    }

    /**
     * 登录历史
     */
    public function testLoginHistories()
    {
        $user = factory(\App\Models\User::class)->create();
        Passport::actingAs($user);
        $response = $this->getJson(url('api/v1/user/login-histories') );
        $response->assertStatus(200);
    }
}


