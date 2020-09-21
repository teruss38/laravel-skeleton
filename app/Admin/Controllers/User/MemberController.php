<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Controllers\User;

use App\Admin\Repositories\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Illuminate\Support\Carbon;

/**
 * 会员管理
 * @author Tongle Xu <xutongle@gmail.com>
 */
class MemberController extends AdminController
{
    protected function title()
    {
        return '会员';
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new User(), function (Grid $grid) {
            $grid->filter(function (Grid\Filter $filter) {
                //右侧搜索
                $filter->equal('id');
                $filter->equal('phone');
                $filter->equal('email');
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
            $grid->quickSearch(['id', 'phone', 'email']);
            $grid->model()->orderBy('id', 'desc');
            $with = ['profile'];
            if (class_exists('\Larva\Wallet\Models\Wallet')) {
                $with[] = 'wallet';
            }
            if (class_exists('\Larva\Integral\Models\IntegralWallet')) {
                $with[] = 'integral';
            }

            $grid->model()->with($with);

            $grid->column('id', 'ID')->sortable();
            $grid->column('username', '用户名');
            $grid->column('phone', '手机');
            $grid->column('email', '邮箱');
            if (class_exists('\Larva\Integral\Models\IntegralWallet')) {
                $grid->column('integral.integral', '积分');
            }
            if (class_exists('\Larva\Wallet\Models\Wallet')) {
                $grid->column('wallet.available_amount', '余额');
            }
            $grid->column('phone_verified_at');
            $grid->column('email_verified_at');
            $grid->column('created_at')->sortable();
            $grid->column('updated_at')->sortable();

            $grid->disableRowSelector();
            $grid->disableCreateButton();
            $grid->paginate(10);
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new User(), function (Show $show) {
            $with = ['profile'];
            if (class_exists('\Larva\Wallet\Models\Wallet')) {
                $with[] = 'wallet';
            }
            if (class_exists('\Larva\Integral\Models\IntegralWallet')) {
                $with[] = 'integral';
            }

            $show->model()->with($with);

            $show->id;
            $show->username;
            $show->phone;
            $show->email;
            $show->phone_verified_at;
            $show->email_verified_at;
            $show->created_at;
            $show->updated_at;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new User(), function (Form $form) {


            $form->display('id');
            $form->text('username');
            $form->text('phone');
            $form->text('phone_verified_at');
            $form->text('email');
            $form->text('email_verified_at');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
