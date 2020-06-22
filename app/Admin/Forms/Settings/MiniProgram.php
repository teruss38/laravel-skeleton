<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Forms\Settings;

/**
 * Class MiniProgram
 * @author Tongle Xu <xutongle@gmail.com>
 */
class MiniProgram extends Settings
{
    /**
     * Build a form here.
     */
    public function form()
    {
        $this->text('miniprogram.name','小程序名称')->rules('nullable|string')->default(config('app.name'));
        $this->text('miniprogram.desc','小程序描述')->rules('nullable|string');
    }
}
