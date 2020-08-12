<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Form\Field;

/**
 * Class File
 * @author Tongle Xu <xutongle@gmail.com>
 */
class File extends \Dcat\Admin\Form\Field\File
{
    /**
     * Initialize the storage instance.
     *
     * @return void.
     * @throws \Exception
     */
    protected function initStorage()
    {
        $this->disk(config('filesystems.cloud'));

        if (! $this->storage) {
            $this->storage = false;
        }
    }
}
