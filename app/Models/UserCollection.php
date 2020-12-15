<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models;

use App\Models\Traits\HasCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * 用户收藏
 * @property int $id
 * @property int $user_id
 * @property int $source_id
 * @property string $souce_type
 * @property string $subject
 *
 * @property User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserCollection type($type)
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UserCollection extends Model
{
    use Traits\HasDateTimeFormatter;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'user_collections';

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'source_id', 'source_type', 'subject'
    ];

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Get the user relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 多态关联
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function source()
    {
        return $this->morphTo();
    }

    /**
     * 查找指定类型的收藏
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeType($query, $type)
    {
        return $query->where('source_type', $type);
    }

    /**
     * 获取Source模型
     * @param string $type
     * @param int $id
     * @return HasCollection
     */
    public static function getSourceModel($type, $id)
    {
        $class = Relation::getMorphedModel($type);
        if (!$class) {
            return null;
        }
        return $class::find($id);
    }
}
