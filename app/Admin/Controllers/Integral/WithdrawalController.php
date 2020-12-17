<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Controllers\Integral;

use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Carbon;
use Larva\Integral\Models\Withdrawal;

/**
 * 积分提现
 * @author Tongle Xu <xutongle@gmail.com>
 */
class WithdrawalController extends AdminController
{
    /**
     * Get content title.
     *
     * @return string
     */
    protected function title()
    {
        return '积分提现';
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(Withdrawal::with(['user']), function (Grid $grid) {
            $grid->filter(function (Grid\Filter $filter) {
                //右侧搜索
                $filter->equal('id', '流水号');
                $filter->equal('user_id', '用户ID');
                $filter->equal('transaction_no', '网关流水号');
                $filter->between('succeeded_at', '付款时间')->date();

                //顶部筛选
                $filter->scope('today', '今天数据')->whereDay('created_at', Carbon::today());
                $filter->scope('yesterday', '昨天数据')->whereDay('created_at', Carbon::yesterday());
                $thisWeek = [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()];
                $filter->scope('this_week', '本周数据')
                    ->whereBetween('created_at', $thisWeek);
                $lastWeek = [Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek()];
                $filter->scope('last_week', '上周数据')->whereBetween('created_at', $lastWeek);
                $filter->scope('this_month', '本月数据')->whereMonth('created_at', Carbon::now()->month);
                $filter->scope('last_month', '上月数据')->whereBetween('created_at', [Carbon::now()->subMonth()->startOfDay(), Carbon::now()->subMonth()->endOfDay()]);
                $filter->scope('year', '本年数据')->whereYear('created_at', Carbon::now()->year);
            });
            $grid->quickSearch(['id', 'transaction_no']);
            $grid->model()->orderBy('id', 'desc');

            $grid->column('id', '流水号')->sortable();
            $grid->column('user.username', '用户');
            $grid->column('integral', '提现积分');
            $grid->column('channel', '付款渠道');
            $grid->column('status','状态')->using(Withdrawal::getStatusLabels())->dot(Withdrawal::getStatusDots());
            $grid->column('canceled_at', '取消时间')->sortable();
            $grid->column('created_at', '创建时间')->sortable();
            $grid->column('succeeded_at', '成功时间')->sortable();
            $grid->disableActions();
            $grid->disableCreateButton();
            $grid->paginate(10);
        });
    }
}
