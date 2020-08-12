<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Controllers\Module;

use App\Models\Link;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Illuminate\Support\Carbon;

/**
 * Class LinkController
 * @author Tongle Xu <xutongle@gmail.com>
 */
class LinkController extends AdminController
{
    protected function title()
    {
        return '友情链接';
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Link(), function (Grid $grid) {
            $grid->selector(function (Grid\Tools\Selector $selector) {
                $selector->select('type', '类型', Link::getTypeLabels());
            });

            $grid->filter(function (Grid\Filter $filter) {
                //右侧搜索
                $filter->equal('id');
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
            $grid->quickSearch(['id', 'title']);
            $grid->model()->orderBy('id', 'desc');

            $grid->column('id', 'ID')->sortable();
            $grid->column('type', '链接类型')->using(Link::getTypeLabels());
            $grid->column('title', '链接名称')->title();
            $grid->column('url')->link();
            $grid->column('logo')->image();
            $grid->description('链接描述');
            $grid->column('expired_at','过期时间');
            $grid->column('created_at','创建时间')->sortable();
            $grid->disableRowSelector();
            $grid->enableDialogCreate();
            $grid->disableViewButton();
            $grid->paginate(10);
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Link(), function (Form $form) {
            $form->radio('type', '链接类型')->options(Link::getTypeLabels())->required()->default(Link::TYPE_HOME);
            $form->text('title', '链接名称')->required();
            $form->url('url', 'Url')->required();
            $form->image('logo_path', '链接Logo')->rules('file|image')->dir('images/' . date('Y/m'))->uniqueName()->autoUpload();
            $form->text('description', '链接描述');
            $form->datetime('expired_at', '过期时间');
        });
    }
}
