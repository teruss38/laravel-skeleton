<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Controllers\Transaction;

use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Carbon;
use Larva\Transaction\Models\Charge;

/**
 * 付款单
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ChargeController extends AdminController
{
    /**
     * Get content title.
     *
     * @return string
     */
    protected function title()
    {
        return '付款单';
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(Charge::with(['user']), function (Grid $grid) {
            $grid->filter(function (Grid\Filter $filter) {
                //右侧搜索
                $filter->equal('id', '流水号');
                $filter->equal('user_id', '用户ID');
                $filter->equal('client_ip', '交易IP');
                $filter->between('created_at', '交易时间')->date();

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
            $grid->column('transaction_no', '网关流水号')->sortable();
            $grid->column('user.username', '用户');
            $grid->column('paid', '已支付')->bool();
            $grid->column('reversed', '已撤销')->bool();
            $grid->column('refunded', '已退款')->bool();

            $grid->column('currency', '币种');
            $grid->column('amount', '付款金额')->display(function ($amount) {
                return bcdiv($amount, 100, 2) . '元';
            });
            $grid->column('channel', '付款渠道');
            $grid->column('type', '付款类型');
            $grid->column('subject', '付款主题');
            $grid->column('order_id', '订单ID');

            $grid->column('created_at', '创建时间')->sortable();
            $grid->column('time_paid', '付款时间')->sortable();

            $grid->disableActions();
            $grid->disableCreateButton();
            $grid->paginate(10);
        });
    }
}
