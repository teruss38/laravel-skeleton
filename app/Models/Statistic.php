<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * 统计表
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Statistic extends Model
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'statistics';

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'type', 'date', 'quantity'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;


    /**
     * 获取当前日期到之前多少天之间的统计数
     * @param string $type 类别
     * @param int $days
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getTimingHistory($type, $days)
    {
        $days = (int)$days;
        $data['quantity'] = static::query()->where('type', $type)
            ->where('date', '<=', Carbon::now())->where('date', '>=', Carbon::today()->subDays($days))
            ->sum('quantity');
        $data['data'] =
            static::query()->select(['quantity'])->where('type', $type)
                ->where('date', '<=', Carbon::now())->where('date', '>=', Carbon::today()->subDays($days))
                ->pluck('quantity');
        return $data;
    }
}
