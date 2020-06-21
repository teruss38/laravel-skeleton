<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 测试登录
     */
    public function testLoginPage()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    /**
     * 测试邮箱登录
     */
    public function testEmailLogin()
    {
        $user = factory(\App\Models\User::class)->create();
        $uri = url('/');
        $response = $this->withSession(['actions-redirect' => $uri])->post('/login', [
            'account' => $user->email,
            'password' => 'password'
        ]);
        $response->assertStatus(302);
        $response->assertLocation($uri);
        $response->assertRedirect($uri);
    }

    /**
     * 测试手机登录
     */
    public function testPhoneLogin()
    {
        $user = factory(\App\Models\User::class)->states('phone')->create();
        $uri = url('/');
        $response = $this->withSession(['actions-redirect' => $uri])->post('/login', [
            'account' => $user->phone,
            'password' => 'password'
        ]);
        $response->assertStatus(302);
        $response->assertLocation($uri);
        $response->assertRedirect($uri);
    }
}
