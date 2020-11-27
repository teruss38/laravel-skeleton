<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Observers;

use App\Models\Tag;


/**
 * 标签观察者
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class TagObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param Tag $tag
     * @return void
     */
    public function created(Tag $tag)
    {

    }
}
