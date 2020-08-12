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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * 文章模型
 * @property int $id ID
 * @property int $user_id 作者ID
 * @property int $category_id 栏目ID
 * @property string $title 标题
 * @property string $description 描述
 * @property string $thumb_path 缩略图
 * @property boolean $recommend 是否推荐
 * @property int $status 状态
 * @property string $content 内容
 * @property int $order 排序
 * @property int $views 查看次数
 * @property int $comment_count 评论次数
 * @property int $support_count 点赞次数
 * @property int $collection_count 收藏次数
 * @property array $seo SEO信息
 * @property array $extra 扩展信息
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @property Tag[] $tags
 * @property ArticleCategory $category
 * @property User $user
 *
 * @property string $tag_values Tags
 * @property-read string $link
 * @property-read boolean $accepted
 * @property-read boolean $pending
 * @property-read boolean $thumb 缩略图Url
 * @property array $baidu_feed 百度信息流
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Article accepted()
 * @method static \Illuminate\Database\Eloquent\Builder|Article recommend()
 * @method static \Illuminate\Database\Eloquent\Builder|Article byCategoryId($categoryId)
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Article extends Model
{
    use Traits\Taggable;
    use Traits\BelongsToUser;

    const STATUS_PENDING = 0b0;//待审核
    const STATUS_ACCEPTED = 0b1;//正常
    const STATUS_REJECTED = 0b10;//拒绝

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articles';

    /**
     * 允许批量赋值的属性
     * @var array
     */
    public $fillable = [
        'user_id', 'category_id', 'title', 'thumb_path', 'recommend', 'status', 'description', 'content', 'order', 'tag_values',
        'seo', 'extra'
    ];

    /**
     * 追加标签字段
     * @var string[]
     */
    protected $appends = [
        'tag_values',
        'accepted',
        'pending',
        'thumb'
    ];

    /**
     * 模型的默认属性值。
     *
     * @var array
     */
    protected $attributes = [
        'recommend' => false,
        'user_id' => User::SYSTEM_USER_ID,
        'status' => 0b1,
        'views' => 0,
        'order' => 0,
        'comment_count' => 0,
        'support_count' => 0,
        'collection_count' => 0,
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * 属性类型转换
     *
     * @var array
     */
    protected $casts = [
        'seo' => 'array',
        'extra' => 'array',
        'views' => 'int',
        'order' => 'int',
        'comment_count' => 'int',
        'support_count' => 'int',
        'collection_count' => 'int',
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
     * 关联到栏目
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ArticleCategory::class);
    }

    /**
     * 查询推荐的文章
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param bool $recommend
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecommend($query, $recommend = true)
    {
        return $query->where('recommend', $recommend);
    }

    /**
     * 查找指定栏目下的文章
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $categoryId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCategoryId($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', static::STATUS_ACCEPTED);
    }

    /**
     * 是否待审核
     * @return boolean
     */
    public function getPendingAttribute()
    {
        return $this->status == static::STATUS_PENDING;
    }

    /**
     * 是否已经审核
     * @return boolean
     */
    public function getAcceptedAttribute()
    {
        return $this->status == static::STATUS_ACCEPTED;
    }

    /**
     * 获取缩略图
     * @return string
     */
    public function getThumbAttribute()
    {
        if (!empty($this->attributes['thumb_path'])) {
            if (Str::contains($this->attributes['thumb_path'], '//')) {
                return $this->attributes['thumb_path'];
            } else {
                return Storage::cloud()->url($this->attributes['thumb_path']);
            }
        }
        return null;
    }

    /**
     * 上一篇
     * @return \Illuminate\Database\Eloquent\Builder|Model|object
     */
    public function getPreviousAttribute()
    {
        return static::accepted()->byCategoryId($this->category_id)->where('id', '<', $this->id)->first();
    }

    /**
     * 下一篇
     * @return \Illuminate\Database\Eloquent\Builder|Model|object
     */
    public function getNextAttribute()
    {
        return static::accepted()->byCategoryId($this->category_id)->where('id', '>', $this->id)->first();
    }

    /**
     * 获取 访问Url
     * @return string
     */
    public function getLinkAttribute()
    {
        return route('article.show', ['id' => $this->id]);
    }

    /**
     * 获取百度信息流参数
     * @return array
     */
    public function getBaiduFeedAttribute()
    {
        $resource = [
            'title' => $this->title,
            'body' => $this->description,
            'publish_time' => date('Y 年 m 月 d 日', time()),
            'tags' => $this->tag_values,
            'feed_type' => 1000,
            'feed_sub_type' => 1001,
        ];
        if (($images = $this->thumb) != null) {
            $resource['images'][] = $this->thumb;
        } else {
            $resource['images'][] = asset('img/baidu_thumb.jpg');
        }
        if (isset($this->extra['publish_time'])) {
            $resource['publish_time'] = date('Y 年 m 月 d 日', $this->created_at->getTimestamp());
        }
        return $resource;
    }

    /**
     * 获取推荐文章
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function recommended($limit = 10)
    {
        $ids = Cache::store('file')->remember('articles:recommended:ids', now()->addMinutes(60), function () use ($limit) {
            return static::accepted()->where('recommend', '=', true)->orderByDesc('support_count')->orderByDesc('created_at')->limit($limit)->pluck('id');
        });
        return $ids->map(function ($id) {
            return static::find($id);
        });
    }

    /**
     * 获取最新的10条资讯
     * @param int $limit
     * @return mixed
     */
    public static function latest($limit = 10)
    {
        $ids = Cache::store('file')->remember('articles:latest:ids', now()->addMinutes(15), function () use ($limit) {
            return static::accepted()->orderByDesc('id')->limit($limit)->pluck('id');
        });
        return $ids->map(function ($id) {
            return static::find($id);
        });
    }

    /**
     * 获取状态Label
     * @return string[]
     */
    public static function getStatusLabels()
    {
        return [
            Article::STATUS_PENDING => '等待复审',
            Article::STATUS_ACCEPTED => '通过',
            Article::STATUS_REJECTED => '拒绝',
        ];
    }

    /**
     * 获取状态Dot
     * @return string[]
     */
    public static function getStatusDots()
    {
        return [
            Article::STATUS_PENDING => 'info',
            Article::STATUS_ACCEPTED => 'success',
            Article::STATUS_REJECTED => 'warning',
        ];
    }
}
