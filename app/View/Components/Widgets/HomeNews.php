<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\View\Components\Widgets;

use App\Models\News;
use Illuminate\View\Component;

/**
 * 首页快讯调用
 * @author Tongle Xu <xutongle@gmail.com>
 */
class HomeNews extends Component
{
    /**
     * @var int
     */
    public $limit;

    /**
     * 缓存时间
     *
     * @var int
     */
    public $cacheMinutes;

    /**
     * Create a new component instance.
     *
     * @param int $limit
     * @param int $cacheMinutes
     */
    public function __construct($limit = 10, $cacheMinutes = 5)
    {
        $this->limit = $limit;
        $this->cacheMinutes = $cacheMinutes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $items = News::latest($this->limit);
        return view('components.widgets.home_news', [
            'items' => $items
        ]);
    }
}
