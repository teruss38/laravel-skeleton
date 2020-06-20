<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Controllers\User;

use App\Admin\Forms\User\Settings;
use App\Http\Controllers\Controller;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Card;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

/**
 * Class SettingsController
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
     * 用户设置
     * @param Content $content
     * @return Content
     */
    public function basic(Content $content)
    {
        return $content->title('会员设置')->body(new Card('会员设置',new Settings));
    }
}
