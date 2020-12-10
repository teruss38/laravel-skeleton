<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\View\Components\Widgets;

use App\Models\Carousel;
use Illuminate\View\Component;

/**
 * 首页轮播
 * @author Tongle Xu <xutongle@gmail.com>
 */
class HomeCarousel extends Component
{
    /**
     * 缓存时间
     *
     * @var int
     */
    public $cacheMinutes;

    /**
     * Create a new component instance.
     *
     * @param int $cacheMinutes
     */
    public function __construct($cacheMinutes = 5)
    {
        $this->cacheMinutes = $cacheMinutes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $carousels = Carousel::home($this->cacheMinutes);
        return view('components.widgets.home_carousel', [
            'count' => $carousels->count(),
            'carousels' => $carousels
        ]);
    }
}
