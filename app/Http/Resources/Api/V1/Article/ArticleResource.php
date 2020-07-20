<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Resources\Api\V1\Article;

use App\Http\Resources\Api\V1\Tag\TagResource;
use App\Http\Resources\Resource;
use App\Models\Article;

/**
 * Class ArticleResource
 * @mixin Article
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ArticleResource extends Resource
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
            'id' => $this->id,
            'category_id' => $this->category_id,
            'category' => $this->when($this->category_id != 0, new CategoryResource($this->category)),
            'title' => $this->title,
            'thumb' => $this->thumb,
            'recommend' => $this->recommend,
            'order' => $this->order,
            'views' => $this->views,
            'comment_count' => $this->comment_count,
            'support_count' => $this->support_count,
            'collection_count' => $this->collection_count,
            'tags' => TagResource::collection($this->tags),
            'content' => $this->content,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'feed'=>$this->baidu_feed
        ];
    }
}
