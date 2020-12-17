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
 * 财务统计
 * @property int $id
 * @property double $wallet_income
 * @property double $wallet_withdrawal
 * @property double $integral_income
 * @property double $integral_withdrawal
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Finance extends Model
{
    const UPDATED_AT = null;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'finance';

    /**
     * 允许批量赋值的属性
     * @var array
     */
    public $fillable = [
        'wallet_income', 'wallet_withdrawal', 'integral_income', 'integral_withdrawal'
    ];


}
