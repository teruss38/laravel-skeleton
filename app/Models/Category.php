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
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Spatie\EloquentSortable\Sortable;

/**
 * 栏目
 * @property int $id ID
 * @property int $parent_id 父ID
 * @property string $name 栏目名称
 * @property string $image_path 缩略图
 * @property string $title 网页Title
 * @property string $keywords 关键词
 * @property string $description 描述
 * @property int $order 排序
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @property-read string $image 缩略图连接
 * @property-read string $link 栏目链接
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Category extends Model implements Sortable
{
    use ModelTree;
    use Traits\HasDateTimeFormatter;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * 允许批量赋值的属性
     * @var array
     */
    public $fillable = [
        'id', 'parent_id', 'name', 'order', 'image_path', 'title', 'keywords', 'description'
    ];

    /**
     * 模型的默认属性值。
     *
     * @var array
     */
    protected $attributes = [
        'order' => 0,
    ];

    /**
     * 排序字段
     * @var array
     */
    protected $sortable = [
        // 设置排序字段名称
        'order_column_name' => 'order',
        // 是否在创建时自动排序，此参数建议设置为true
        'sort_when_creating' => true,
    ];

    /**
     * 追加字段
     * @var string[]
     */
    protected $appends = [
        'image'
    ];

    /**
     * 标题字段
     * @var string
     */
    protected $titleColumn = 'name';

    /**
     * Get the children relation.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(static::class, 'parent_id', 'id');
    }

    /**
     * Get the parent relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(static::class);
    }

    /**
     * 获取子栏目
     * @return array
     */
    public function getChildrenIds()
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
     * 获取栏目缩略图
     * @return string
     */
    public function getImageAttribute()
    {
        $image = $this->attributes['image_path'];
        if ($image) {
            if (!URL::isValidUrl($image)) {
                $image = Storage::cloud()->url($image);
            }
            return $image;
        }
        return asset('img/img_invalid.png');
    }
}
