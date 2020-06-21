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
 * Class NotificationTest
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class NotificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 标记所有未读的通知为已读
     */
    public function testMarkRead()
    {
        $user = factory(\App\Models\User::class)->create();
        Passport::actingAs($user);
        $response = $this->json('POST', url('api/v1/user/notifications/mark-read'));
        $response->assertStatus(200);
    }

    /**
     * 获取未读通知
     */
    public function testUnreadCount()
    {
        $user = factory(\App\Models\User::class)->create();
        Passport::actingAs($user);
        $response = $this->json('GET', url('api/v1/user/notifications/unread-count'));
        $response->assertStatus(200);
    }
}
