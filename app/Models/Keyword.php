<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * 关键词库
 * @property int $id
 * @property string $word
 * @property int $frequency
 * @property string $title
 * @property string $keywords
 * @property string $description
 *
 * @property-read string $link
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Keyword extends Model
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'keywords';

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'word',  'frequency', 'title', 'keywords', 'description'
    ];

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * 获取标题
     * @return boolean
     */
    public function getTitleAttribute()
    {
        if (!empty($this->attributes['title'])) {
            return $this->attributes['title'];
        }
        return $this->attributes['word'];
    }

    /**
     * 获取关键词
     * @return boolean
     */
    public function getKeywordsAttribute()
    {
        if (!empty($this->attributes['keywords'])) {
            return $this->attributes['keywords'];
        }
        return $this->attributes['word'];
    }

    /**
     * 获取描述
     * @return boolean
     */
    public function getDescriptionsAttribute()
    {
        if (!empty($this->attributes['description'])) {
            return $this->attributes['description'];
        }
        return $this->attributes['word'];
    }

    /**
     * 获取访问Url
     * @return string
     */
    public function getLinkAttribute()
    {
        return route('keyword.show', ['id' => $this->id]);
    }


    /**
     * 获取最新的10个
     * @param int $limit
     * @return mixed
     */
    public static function latest($limit = 10)
    {
        $ids = Cache::store('file')->remember('keywords:latest:'.$limit, now()->addMinutes(15), function () use ($limit) {
            return static::query()->orderByDesc('id')->limit($limit)->pluck('id');
        });
        return $ids->map(function ($id) {
            return static::find($id);
        });
    }
}
