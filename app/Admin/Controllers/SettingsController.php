<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Controllers;

use App\Admin\Forms\Settings\Storage;
use App\Admin\Forms\Settings\System;
use App\Http\Controllers\Controller;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Card;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

/**
 * 系统设置
 * @author Tongle Xu <xutongle@gmail.com>
 */
class SettingsController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        Session::setPreviousUrl(Url::current());
    }

    /**
     * 网站设置
     * @param Content $content
     * @return Content
     */
    public function system(Content $content)
    {
        return $content->title('网站设置')->body(new Card('网站设置', new System));
    }


    /**
     * 附件设置
     * @param Content $content
     * @return Content
     */
    public function storage(Content $content)
    {
        return $content->title('附件设置')->body(new Card('附件设置', new Storage));
    }

}
