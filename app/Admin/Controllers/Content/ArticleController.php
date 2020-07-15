<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Controllers\Content;

use App\Admin\Actions\Content\ArticleVerify;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\User;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Illuminate\Support\Carbon;

/**
 * 文章管理
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ArticleController extends AdminController
{
    protected function title()
    {
        return '文章';
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Article(), function (Grid $grid) {
            $grid->model()->with(['category', 'tags', 'user']);
            $grid->model()->orderBy('id', 'desc');

            $grid->filter(function (Grid\Filter $filter) {
                //右侧搜索
                $filter->equal('id');
                $filter->equal('title');
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

            $grid->column('id', 'ID')->sortable();
            $grid->column('user.username', '作者');
            $grid->column('category.title', '文章类别');
            $grid->column('title', '标题')->title();
            $grid->column('tag_values', '标签');
            $grid->column('views', '查看数');
            $grid->column('comment_count', '评论数');
            $grid->column('support_count', '点赞数');
            $grid->column('collection_count', '收藏数');
            $grid->column('recommend', '推荐')->switch();
            $grid->column('status', '状态')->using(Article::getStatusLabels())->dot(Article::getStatusDots(), 'info');
            $grid->column('order', '排序权重')->editable();
            $grid->column('created_at', '发布时间')->sortable();
            $grid->column('pending', '审核')->action(ArticleVerify::make());
            $grid->disableRowSelector();
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
        return Show::make($id, new Article, function (Show $show) {
            $show->model()->with(['category', 'tags']);
            $show->field('id', 'ID');
            $show->field('category.title', '文章类别');
            $show->field('title', '标题');
            $show->field('description', '摘要');
            $show->field('thumb', '特色图像')->image();
            $show->field('tag_values', '标签');
            $show->field('views', '查看数');
            $show->field('comment_count', '评论数');
            $show->field('support_count', '点赞数');
            $show->field('collection_count', '收藏数');
            $show->field('order', '排序权重');
            $show->field('content', '文章内容');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Article, function (Form $form) {
            $form->tab('基本', function (Form $form) {
                $form->text('title', '标题')->required()->rules('required|string|max:30:min:5')->placeholder('请输入文字标题（5-30个汉字）');
                $form->editor('content', '内容')->required()->placeholder('请输入正文');
            })->tab('扩展', function (Form $form) {
                $form->embeds('seo', 'SEO设置', function ($form) {
                    $form->text('title', 'SEO标题');
                    $form->text('keywords', 'SEO关键词');
                    $form->textarea('description', 'SEO描述')->rows(3);
                    $form->switch('bd_daily', '百度快速收录')->default(0);
                });
                $form->embeds('extra', '扩展', function ($form) {
                    $form->text('from', '来源名');
                    $form->text('from_url', '来源网址');
                });
            });

            // 设置默认卡片宽度
            $form->setDefaultBlockWidth(8);

            // 分块显示

            $form->block(4, function (Form\BlockForm $form) {
                $form->radio('status', '状态')->options(Article::getStatusLabels())->default(Article::STATUS_ACCEPTED);
                $form->switch('recommend', '推荐');
                $form->select('category_id', '栏目')->options(ArticleCategory::selectOptions())->required();
                $form->tags('tag_values', '标签')->ajax('api/tags', 'name', 'name');
                $form->image('thumb', '特色图像')->rules('file|image')->dir('images/' . date('Y/m'))->uniqueName()->autoUpload();
                $form->textarea('description', '摘要')->rows(3);
                $form->select('user_id', '作者')->model(User::class, 'id', 'username')->default(User::SYSTEM_USER_ID)->ajax('api/users', 'id', 'username');
                $form->number('order', '排序权重')->default(0);
            });
        });
    }
}
