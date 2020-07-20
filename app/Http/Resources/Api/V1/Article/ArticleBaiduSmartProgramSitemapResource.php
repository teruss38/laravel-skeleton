<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Resources\Api\V1\Article;

use App\Http\Resources\Resource;
use App\Models\Article;

/**
 * 百度小程序站点地图
 * @mixin Article
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ArticleBaiduSmartProgramSitemapResource extends Resource
{
    /**
     * 禁用资源包裹
     *
     * @var string
     */
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'path' => '/pages/article/article?id=' . $this->id,
            'releaseDate' => $this->created_at->toDateTimeString(),
        ];
    }
}
