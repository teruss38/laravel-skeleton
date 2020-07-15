<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Forms\Settings;

/**
 * 附件设置
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Storage extends Settings
{
    /**
     * Build a form here.
     */
    public function form()
    {

        $this->select('storage.avatar_disk', '头像存储磁盘')->options(array_keys(config('filesystems.disks')));
    }
}
