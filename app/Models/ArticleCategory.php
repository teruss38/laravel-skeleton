<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models;

use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\EloquentSortable\Sortable;

/**
 * 文章栏目
 * @property int $id ID
 * @property int $parent_id 父ID
 * @property string $title 栏目名称
 * @property int $order 排序
 * @property string $image_path 缩略图
 * @property string $description 描述
 * @property-read string $link 链接
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @property-read string $image
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ArticleCategory extends Model implements Sortable
{
    use ModelTree;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article_categories';

    /**
     * 允许批量赋值的属性
     * @var array
     */
    public $fillable = [
        'id', 'parent_id', 'title', 'order', 'image_path', 'description'
    ];

    /**
     * 模型的默认属性值。
     *
     * @var array
     */
    protected $attributes = [
        'order' => 0,
    ];

    protected $sortable = [
        // 设置排序字段名称
        'order_column_name' => 'order',
        // 是否在创建时自动排序，此参数建议设置为true
        'sort_when_creating' => true,
    ];


    protected $appends = [
        'image'
    ];

    /**
     * 获取子栏目
     * @return array
     */
    public function getChildren()
    {
        return $this->children()->pluck('id')->all();
    }

    /**
     * 获取 访问Url
     * @return string
     */
    public function getLinkAttribute()
    {
        return route('article.category', ['id' => $this->id]);
    }

    /**
     * 获取image存储位置
     * @return string
     */
    public function getImageAttribute()
    {
        if (!empty($this->attributes['image_path'])) {
            if (Str::contains($this->attributes['image_path'], '//')) {
                return $this->attributes['image_path'];
            } else {
                return Storage::cloud()->url($this->attributes['image_path']);
            }
        }
        return null;
    }
}
