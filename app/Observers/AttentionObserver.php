<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Observers;

use App\Models\Attention;
use App\Models\UserExtra;

/**
 * 关注观察者
 * @author Tongle Xu <xutongle@gmail.com>
 */
class AttentionObserver
{
    /**
     * 处理「created」事件
     * @param Attention $attention
     * @return void
     */
    public function created(Attention $attention)
    {
        if ($attention->source_type == 'user') {
            UserExtra::inc($attention->source_id, 'followers');
        } else {
            $attention->source()->increment('follower_count');
        }
    }

    /**
     * 处理「删除」事件
     *
     * @param Attention $attention
     * @return void
     */
    public function deleted(Attention $attention)
    {
        if ($attention->source_type == 'user') {
            UserExtra::dec($attention->source_id, 'followers');
        } else {
            $attention->source()->where('follower_count', '>', 0)->decrement('follower_count');
        }
    }
}
