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
 * Tag
 * @property int $id ID
 * @property string $name Tag名称
 * @property int $frequency 热度
 * @property string $title SEO标题
 * @property string $keywords SEO关键词
 * @property string $description SEO描述
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 *
 * @property-read string $link
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Tag name($name)
 */
class Tag extends Model
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'tags';

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'name', 'frequency', 'title', 'keywords', 'description'
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
     * 通过ID获取内容
     * @param string $id
     * @return mixed
     */
    public static function findById($id)
    {
        return Cache::store('file')->rememberForever('tag:' . $id, function () use ($id) {
            return static::find($id);
        });
    }

    /**
     * 查找指定的Tag
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }

    /**
     * 通过ID获取内容
     * @param string $name
     * @return mixed
     */
    public static function findByName($name)
    {
        $item = static::query()->name($name)->first();
        if ($item) {
            return static::findById($item->id);
        }
        return false;
    }

    /**
     * 获取 访问Url
     * @return string
     */
    public function getLinkAttribute()
    {
        return route('tag.show', ['id' => $this->id]);
    }

    /**
     * 拥有这个标签的文章
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function articles()
    {
        return $this->morphedByMany(Article::class, 'taggable');
    }
}
