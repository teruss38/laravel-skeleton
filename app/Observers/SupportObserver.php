<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Observers;

use App\Models\Support;

/**
 * 点赞观察者
 * @author Tongle Xu <xutongle@gmail.com>
 */
class SupportObserver
{
    /**
     * 处理「created」事件
     * @param Support $support
     * @return void
     */
    public function created(Support $support)
    {
        $support->source()->increment('support_count');
    }

    /**
     * 处理「删除」事件
     *
     * @param Support $support
     * @return void
     */
    public function deleted(Support $support)
    {
        $support->source()->where('support_count', '>', 0)->decrement('support_count');
    }
}
