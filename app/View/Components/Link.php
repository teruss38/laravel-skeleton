<?php

namespace App\View\Components;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

/**
 * 友情链接
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Link extends Component
{
    /**
     * 友情连接 类型。
     *
     * @var string
     */
    public $type;

    /**
     * 缓存时间
     *
     * @var int
     */
    public $cacheMinutes;

    /**
     * Create a new component instance.
     *
     * @param string $type
     * @param int $cacheMinutes
     */
    public function __construct($type, $cacheMinutes = 5)
    {
        $this->type = $type;
        $this->cacheMinutes = $cacheMinutes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $ids = Cache::store('file')->remember('links:home:ids', Carbon::now()->addMinutes($this->cacheMinutes), function () {
            return \App\Models\Link::active()->whereIn('type', [\App\Models\Link::TYPE_HOME, \App\Models\Link::TYPE_ALL])->orderByDesc('id')->pluck('id');
        });
        $links = \App\Models\Link::query()->whereIn('id', $ids)->get();
        return view('components.link', [
            'links' => $links
        ]);
    }
}
