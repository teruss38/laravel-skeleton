<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * Class MessageTest
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class MessageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 获取短消息会话列表
     */
    public function testIndex()
    {
        $user = factory(\App\Models\User::class)->create();
        Passport::actingAs($user);
        $response = $this->json('GET', url('api/v1/user/messages'));
        //断言他是成功的
        $response->assertStatus(200);
    }

    /**
     * 发送短消息
     */
    public function testSend()
    {
        $user = factory(\App\Models\User::class)->create();
        $user2 = factory(\App\Models\User::class)->create();
        Passport::actingAs($user);
        //发送
        $response = $this->json('POST', url('api/v1/user/messages'), [
            'to_user_id' => $user2->id,
            'content' => '测试短信内容',
        ]);
        $response->assertStatus(201);

        //查看
        $response = $this->json('GET', url('api/v1/user/messages', ['user_id' => $user2->id]));
        $messages = $response->json('data');
        $response->assertOk();
        $messageId = $messages[0]['id'];

        //删除
        $response = $this->deleteJson( url('api/v1/user/messages', ['id' => $messageId]));
        $response->assertStatus(204);
    }
}
