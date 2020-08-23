<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Observers;

use App\Models\Keyword;

/**
 * Class KeywordObserver
 * @author Tongle Xu <xutongle@gmail.com>
 */
class KeywordObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param \App\Models\Keyword $keyword
     * @return void
     */
    public function created(Keyword $keyword)
    {
        if (!config('app.debug')) {
//            \Larva\Baidu\Push\BaiduPush::push($keyword->link);//推普通收录
//            \Larva\Bing\Push\BingPush::push($keyword->link);
        }
    }
}
