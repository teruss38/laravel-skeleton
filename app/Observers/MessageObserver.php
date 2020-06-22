<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Observers;

use App\Models\Message;
use App\Notifications\MessageNotification;

/**
 * 站内信观察者
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class MessageObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param Message $message
     * @return void
     */
    public function created(Message $message)
    {
        //通知收件人
        $message->user->notify(new MessageNotification($message));
    }
}
