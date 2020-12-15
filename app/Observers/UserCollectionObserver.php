<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Observers;

use App\Models\UserCollection;

/**
 * 收藏观察者
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UserCollectionObserver
{
    /**
     * 处理「created」事件
     * @param UserCollection $collection
     * @return void
     */
    public function created(UserCollection $collection)
    {
        $collection->source()->increment('collection_count');
    }

    /**
     * 处理「删除」事件
     *
     * @param UserCollection $collection
     * @return void
     */
    public function deleted(UserCollection $collection)
    {
        $collection->source()->where('collection_count', '>', 0)->decrement('collection_count');
    }
}
