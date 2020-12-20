<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Observers;

use App\Models\UserDownload;

/**
 * Class UserDownloadObserver
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UserDownloadObserver
{
    /**
     * Handle the UserDownload "created" event.
     *
     * @param UserDownload $userDownload
     * @return void
     */
    public function created(UserDownload $userDownload)
    {
        if ($userDownload->download->score > 0) {
            $integral = -$userDownload->download->score;
            $currentIntegral = bcadd($userDownload->user->integral, $integral);

            //扣分
            $userDownload->transaction()->create([
                'user_id' => $userDownload->user_id,
                'type' => 'download',
                'description' => trans('integral.download'),
                'integral' => $integral,
                'current_integral' => $currentIntegral
            ]);

            //作者加分
            $userDownload->transaction()->create([
                'user_id' => $userDownload->download->user_id,
                'type' => 'download',
                'description' => trans('integral.download'),
                'integral' => $userDownload->download->score,
                'current_integral' => bcadd($userDownload->download->user->integral, $userDownload->download->score)
            ]);
        }
    }
}
