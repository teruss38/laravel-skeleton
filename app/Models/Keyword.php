<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 关键词库
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
     * 获取 访问Url
     * @return string
     */
    public function getLinkAttribute()
    {
        return route('tag.show', ['id' => $this->id]);
    }
}
